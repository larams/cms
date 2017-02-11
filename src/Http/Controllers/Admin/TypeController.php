<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Larams\Cms\StructureType;

class TypeController extends Controller
{

    protected $route = 'types';

    public function getIndex( StructureType $structureType )
    {

        $types = $structureType->orderBy('name')->get();

        return $this->view('larams::admin.types.index', compact('types'));

    }

    public function getAdd( StructureType $structureType )
    {

        $isCreate = true;

        $handlers = $this->readHandlers();

        $types = $structureType->orderBy('name')->get();

        return $this->view('larams::admin.types.edit', compact('isCreate', 'types', 'handlers'));

    }

    public function getEdit( StructureType $structureType, $id )
    {

        $item = $structureType->find( $id );

        $handlers = $this->readHandlers();

        $types = $structureType->orderBy('name')->get();

        $relations = $item->types()->where('additional', 0 )->lists('rel_type_id')->all();
        $additional = $item->types()->where('additional', 1 )->lists('rel_type_id')->all();

        return $this->view('larams::admin.types.edit', compact('item', 'types', 'handlers', 'relations', 'additional') );

    }

    public function postSave( StructureType $structureType, $id = null )
    {

        /** @var StructureType $item */
        if (!empty( $id )) {
            $item = $structureType->find( $id );
            $item->fill( request()->input() )->save();
        } else {
            $item = $structureType->create( request()->input() );
        }

        $additional = request()->input('additional');
        $relations = request()->input('relations');

        if (!empty( $relations )) {
            $relations = array_map(function( $id ) { return ['rel_type_id' => $id, 'additional' => 0 ]; }, $relations );
        }

        if (!empty( $additional )) {
            $additional = array_map(function( $id ) { return ['rel_type_id' => $id, 'additional' => 1 ]; }, $additional );
        }

        $item->types()->sync( array_merge( (array)$relations, (array)$additional ) );

        return redirect('admin/' . $this->route );
    }

    public function getDelete( StructureType $structureType, $id )
    {

        $item = $structureType->find( $id );
        $item->delete();

        return redirect('admin/'.$this->route );

    }

    protected function readHandlers()
    {
        $handlersPath = config_path('handlers');
        $handlers = \File::files( $handlersPath );

        $preparedHandlersPath = realpath( __DIR__ . '/../../../../config/handlers' );
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
