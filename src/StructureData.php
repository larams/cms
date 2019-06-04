<?php

namespace Larams\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StructureData
 * @package Larams\Cms
 *
 */
class StructureData extends Model
{

    protected $table = 'structure_data';

    protected $fillable = ['id', 'item_id', 'name', 'data'];

    public function item()
    {
        return $this->belongsTo('Larams\Cms\StructureItem', 'item_id');
    }

    public function getDataAttribute()
    {
        $result = json_decode($this->attributes['data']);
        if ($result != $this->attributes['data'] && json_last_error() == JSON_ERROR_NONE) {
            return $result;
        }

        return $this->attributes['data'];
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = is_scalar($value) ? $value : json_encode($value);
    }
}
