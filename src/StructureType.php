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

    public function getHandlers()
    {
        $handlersPath = config_path('handlers');
        $handlers = \File::files( $handlersPath );

        $preparedHandlersPath = realpath( __DIR__ . '/../config/handlers' );
        $preparedHandlers = \File::files( $preparedHandlersPath );

        $handlers = array_merge( $preparedHandlers, $handlers );

        foreach ( $handlers as &$handler ) {

            $handlerName = str_replace( array( $handlersPath . '/', '.php', $preparedHandlersPath . '/' ), '', $handler );

            $handler = array(
                'id' => $handlerName,
                'title' => str_replace('_', ' ', ucfirst( $handlerName ) )
            );
        }

        usort( $handlers, function($a,$b) {
            return $a['title'] >= $b['title'];
        });

        return $handlers;
    }
}
