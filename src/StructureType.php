<?php

namespace Larams\Cms;

use Illuminate\Database\Eloquent\Model;

class StructureType extends Model
{

    protected $table = 'structure_types';

    protected $fillable = ['id', 'name', 'handler', 'name_lang'];

    public function types()
    {
        return $this->belongsToMany('Larams\Cms\StructureType', 'structure_types_relations', 'type_id', 'rel_type_id')->withPivot(['additional']);
    }

    public static function buildClassName($typeName)
    {

        $parts = explode('_', $typeName);

        foreach ($parts as &$part) {
            $part = ucfirst($part);
        }

        return implode('', $parts);

    }
}
