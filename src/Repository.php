<?php

namespace Larams\Cms;

use Larams\Cms\Exceptions\AppException;
use Illuminate\Database\Query\Builder;

abstract class Repository
{
    use FixesDecimalNumber;

    protected $searchFields = ['title'];

    protected $sortMap = [];

    public $grouping = null;

    protected $model;

    /**
     * @returns Model|Builder
     */
    public function getModel()
    {
        return $this->model;
    }

    public function create($input)
    {
        $input = $this->cleanDecimalFields($input);

        $model = $this->getModel()->create($input);
        if (method_exists($model, 'afterCreate')) {
            $model->afterCreate($input);
        }

        $model = $this->getModel()->find($model->getKey());

        return $model;
    }

    public function update($model, $input)
    {
        $input = $this->cleanDecimalFields($input);

        $model->update($input);

        if (method_exists($model, 'afterUpdate')) {
            $model->afterUpdate($input);
        }

        return $model;
    }

    protected function validateBeforeUpdate($model, $input)
    {
        if (method_exists($model, 'validateBeforeCreate')) {
            $model->validateBeforeCreate($input);
        }
    }

    /**
     * @param $params
     * @return Model|Builder
     */
    public function buildQuery($params)
    {
        $select = $this->getModel();

        if (!empty($params['id'])) {
            if (is_array($params['id'])) {
                $select = $select->whereIn($this->getModel()->qualifyColumn('id'), $params['id']);
            } else {
                $select = $select->where($this->getModel()->qualifyColumn('id'), $params['id']);
            }
        }

        if (!empty($params['sort'])) {

            if (!is_array($params['sort'])) {
                if (strpos($params['sort'], ',') !== false) {
                    $params['sort'] = explode(',', $params['sort']);
                } else {
                    $params['sort'] = [$params['sort']];
                }
            }

            foreach ($params['sort'] as $sort) {

                $direction = 'ASC';
                if (substr($sort, 0, 1) == '-') {
                    $direction = 'DESC';
                    $sort = substr($sort, 1);
                }

                $mappedSorts = $this->mapSortColumn($sort);
                foreach ($mappedSorts as $mappedSort) {
                    $mappedSort = $this->getModel()->qualifyColumn($mappedSort);
                    $select = $select->orderBy($mappedSort, $direction);
                }
            }
        }

        if (!empty($params['limit']) && $params['limit'] != -1) {
            $select = $select->take($params['limit']);
        }

        if (!empty($params['page']) && $params['limit'] != -1) {
            $select = $select->offset(max($params['page'] - 1, 0) * $params['limit']);
        }

        if (!empty($params['search'])) {
            $select = $select->where(function ($query) use ($params) {
                return $this->setSearchParams($query, $params['search']);
            });
        }

        if (!empty($params['fields'])) {
            $columns = [];
            foreach ($params['fields'] as $field) {
                $columns[] = $this->getModel()->qualifyColumn($field);
            }
            $select = $select->select($columns);
        }

        if (!empty($params['totals'])) {
            foreach ($params['totals'] as $column) {
                $select = $select->addSelect(\DB::raw('SUM(' . $column . ') AS ' . $column));
            }
        }

        return $select;
    }

    protected function addSort($select, $sort, $direction)
    {

        $select = $select->orderBy($sort, $direction);

        return $select;
    }

    protected function mapSortColumn($sort)
    {
        $sort = !empty($this->sortMap[$sort]) ? $this->sortMap[$sort] : $sort;

        return is_array($sort) ? $sort : [$sort];
    }

    protected function setSearchParams($select, $keyword)
    {
        if (!empty($this->searchFields)) {
            $select = $select->where(function ($query) use ($keyword) {
                foreach ($this->searchFields as $field) {

                    if (strpos($field, '.') === false) {
                        $field = $this->getModel()->getTable() . '.' . $field;
                    }

                    $query = $query->orWhere($field, 'LIKE', '%' . $keyword . '%');
                }
            });
        }

        return $select;
    }

    public function one($params = [])
    {
        $params['single'] = 1;
        $items = $this->filter($params);

        if (count($items)) {
            return $items->first();
        }

        return null;
    }

    protected function getGrouppingColumn()
    {
        return !empty($this->grouping)
            ? $this->grouping
            : ($this->getModel()->getConnection()->getTablePrefix() . $this->getModel()->getTable() . '.id');
    }

    public function getTotalRows($params = [])
    {
        unset($params['limit']);
        unset($params['page']);
        $params['count'] = true;

        return $this->buildQuery($params)->count(\DB::raw('DISTINCT( ' . $this->getGrouppingColumn() . ' )'));
    }

    public function filter($params = [], $paginate = false)
    {
        $items = $this->buildQuery($params);

        if (!empty($params['with'])) {
            foreach ($params['with'] as $withItem) {
                $items = $items->with($withItem);
            }
        }

        if (!empty($paginate)) {
            $items = $items->paginate($paginate);
        } else {
            $items = $items->get();
        }

        if (empty($params['single']) && !empty($params['keyBy'])) {
            $items = $items->keyBy($params['keyBy']);
        }

        if (!empty($params['appends'])) {
            $items->each(function ($item) use ($params) {

                foreach ($params['appends'] as $append) {
                    $item->append($append);
                }
            });
        }

        return $items;
    }

    public function totals($params = [])
    {
        $totals = $this->buildQuery($params)->first();

        return $totals;
    }

    public function delete($id, $authorizedUserId = null)
    {
        $item = $this->getModel()->find($id);

        if (!empty($authorizedUserId) && $item->user_id !== $authorizedUserId) {
            throw new AppException(trans('app.exception.not_allowed'), 403);
        }

        if (method_exists($item, 'beforeDelete')) {
            $item->beforeDelete();
        }

        $item->delete();

        if (method_exists($item, 'afterDelete')) {
            $item->afterDelete();
        }
    }


    public function changePosition($fieldId, $toIndex, $extraConditions = [], $positionColumn = 'position' )
    {
        $field = $this->getModel()->find($fieldId);

        if (empty($field)) {
            return false;
        }

        $this->buildChangePositionQuery( $extraConditions )
            ->where($positionColumn, '>', $field->position)
            ->update([$positionColumn => \DB::raw($positionColumn . ' - 1')]);

        $this->buildChangePositionQuery( $extraConditions )
            ->where($positionColumn, '>=', $toIndex)
            ->update([$positionColumn => \DB::raw($positionColumn . ' + 1')]);

        $this->getModel()
            ->where('id', $field->id)
            ->update([$positionColumn => $toIndex]);

        return true;
    }

    protected function buildChangePositionQuery( $extraConditions ) {

        $query = $this->getModel();

        if (!empty($extraConditions)) {
            foreach ( $extraConditions as $extraConditionKey => $extraConditionValue ) {
                $query = $query->where( $extraConditionKey, $extraConditionValue );
            }
        }

        return $query;
    }
}
