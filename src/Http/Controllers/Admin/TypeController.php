<?php

namespace Talandis\Larams\Http\Controllers\Admin;

use Talandis\Larams\StructureType;

class TypeController extends Controller
{

    public function getIndex( StructureType $structureType )
    {

        $types = $structureType->orderBy('name')->get();

        return $this->view('larams::admin.types.index', compact('types'));

    }

    public function getAdd( StructureType $structureType )
    {

        $isCreate = true;

        $handlersPath = config_path('handlers');
        $handlers = \File::files( $handlersPath );

        foreach ( $handlers as &$handler ) {
            $handler = array('name' => str_replace( array($handlersPath . '/', '.php'), '', $handler ) );
        }

        $types = $structureType->orderBy('name')->get();

        return $this->view('larams::admin.types.edit', compact('isCreate', 'types', 'handlers'));

    }

    public function getEdit( StructureType $structureType, $id )
    {

        $item = $structureType->find( $id );

        $handlersPath = config_path('handlers');
        $handlers = \File::files( $handlersPath );

        foreach ( $handlers as &$handler ) {
            $handler = str_replace( array($handlersPath . '/', '.php'), '', $handler );
        }

        $types = $structureType->orderBy('name')->get();

        $relations = $item->types()->where('additional', 0 )->lists('id')->all();
        $additional = $item->types()->where('additional', 1 )->lists('id')->all();

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

        return redirect('admin/types');
    }

    public function getDelete( StructureType $structureType, $id )
    {

        $item = $structureType->find( $id );
        $item->delete();

        return redirect('admin/types');

    }

}
