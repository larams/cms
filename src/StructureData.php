<?php

namespace Talandis\Larams;

/**
 * Class StructureData
 * @package Talandis\Larams
 *
 */

class StructureData extends \Eloquent
{

    protected $table = 'structure_data';

    protected $fillable = ['id', 'item_id', 'name', 'data'];

    public function item()
    {
        return $this->belongsTo('Talandis\Larams\StructureItem', 'item_id');
    }

    public function getDataAttribute()
    {
        $result = json_decode( $this->attributes['data'] );

        if ( json_last_error() == JSON_ERROR_NONE ) {
            return $result;
        }

        return $this->attributes['data'];
    }

    public function setDataAttribute( $value )
    {
        $this->attributes['data'] = is_scalar( $value ) ? $value : json_encode( $value );
    }
}
