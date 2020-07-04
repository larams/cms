<?php

namespace Larams\Cms\Repository;

use Larams\Cms\Repository;
use Larams\Cms\Model\StructureItem;

class StructureItems extends Repository
{
    /** @var StructureItem */
    protected $model;

    public function __construct(StructureItem $model)
    {
        $this->model = $model;
    }

    public function filter($params = [], $paginate = false)
    {
        if (empty($params['appends'])) {
            $params['appends'] = [];
        }

        $params['appends'][] = 'type_name';

        $items = parent::filter($params, $paginate);

        if (!empty($params['childs'])) {
            foreach ($items as &$item) {
                $q = $this->model->byParentId($item->id);
                if (!empty($params['keyword'])) {
                    $q = $q->where('search', 'LIKE', '%' . $params['keyword'] . '%');
                }
                $item->childs = $q->orderBy('left')->where('active', 1)->get();

                if ($params['childs'] >= 2) {
                    foreach ($item->childs as &$child) {
                        $child->childs = $this->model->byParentId($item->id)->orderBy('left')->where('active', 1)->get();
                    }
                }
            }
        }

        return $items;

    }

    public function buildQuery($params)
    {
        /** @var StructureItem $query */
        $query = parent::buildQuery($params);

        if (!empty($params['parent_type_name'])) {
            $query = $query->byParentTypeName($params['parent_type_name']);
        }

        if (!empty($params['type_name'])) {
            $query = $query->byTypeName($params['type_name']);
        }

        if (!empty($params['parent_id'])) {
            $query = $query->byParentId($params['parent_id']);
        }

        if (!empty($params['uri'])) {
            $query = $query
                ->where('uri', $params['uri'])
                ->where('active', 1);
        }

        return $query;
    }
}
