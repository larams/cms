<?php

namespace Talandis\Larams;

class StructureType extends \Eloquent {


    protected $table = 'structure_types';

    protected $fillable = ['id', 'name', 'handler', 'name_lang'];

    public function types()
    {
        return $this->belongsToMany('Talandis\Larams\StructureType', 'structure_types_relations', 'type_id', 'rel_type_id')->withPivot( ['additional'] );
    }

}
