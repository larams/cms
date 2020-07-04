<?php

namespace Larams\Cms;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 * @package App
 *
 * @method whereCrudDate(string $field, array $dates)
 * @method whereCrudNumber(string $field, array $range)
 */
class Model extends BaseModel
{

    use FixesEmptyStrings;

    protected $related = [];

    /**
     * @return array
     */
    public function parentForLog()
    {
        return [null, null];
    }

    public function setAttribute($key, $value)
    {
        if (is_scalar($value)) {
            $value = $this->emptyStringToNull($value);
        }

        parent::setAttribute($key, $value);
    }


    public function getCreatedDateAttribute()
    {
        return date('Y-m-d', strtotime($this->attributes['created_at']));
    }

    public function afterCreate($input)
    {
    }

    public function afterUpdate($input)
    {
    }

    public function beforeDelete()
    {
    }

    public function afterDelete()
    {
    }

    /**
     * @param $query
     * @param $field
     * @param $dates
     * @return mixed
     * @throws \Exception
     */
    public function scopeWhereCrudDate($query, $field, $range)
    {
        return $this->crudRangeFilter($query, $field, $range, 'date_from', 'date_to');
    }

    /**
     * @param $query
     * @param $field
     * @param $range
     * @return mixed
     * @throws \Exception
     */
    public function scopeWhereCrudNumber($query, $field, $range)
    {
        return $this->crudRangeFilter($query, $field, $range, 'from', 'to');
    }

    protected function crudRangeFilter($query, $field, $range, $fromField, $toField)
    {
        if (!array_key_exists($fromField, $range) || !array_key_exists($toField, $range)) {
            throw new \Exception("Invalid Range Filter for column: {$field}");
        }

        if (!empty($range[$fromField])) {
            $query = $query->where($field, '>=', $range[$fromField]);
        }

        if (!empty($range[$toField])) {
            $query = $query->where($field, '<=', $range[$toField]);
        }

        return $query;
    }

    public function isModified( $values )
    {
        foreach ( $values as $k => $v ) {
            if ( $this->$k != $v ) {
                return true;
            }
        }

        return false;
    }
}
