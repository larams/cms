<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Larams\Cms\StructureType;

class AdministratorController extends Controller
{

    protected $route = 'administrators';

    public function __construct()
    {
        $this->model = app()->make( config('larams.administrators_model', \Larams\Cms\User::class ) );
    }

    public function getIndex()
    {

        $users = $this->model->orderBy('email')->get();

        return $this->view('larams::admin.administrators.index', compact('users'));

    }

    public function getAdd()
    {

        $isCreate = true;
        $types = $this->model->types();

        return $this->view('larams::admin.administrators.edit', compact('isCreate', 'types'));

    }

    public function getEdit( $id )
    {

        $item = $this->model->find( $id );

        $types = $this->model->types();

        return $this->view('larams::admin.administrators.edit', compact('item', 'types') );

    }

    public function postSave( $id = null )
    {

        /** @var StructureType $item */
        if (!empty( $id )) {
            $item = $this->model->find( $id );
            $item->fill( request()->input() )->save();
        } else {
            $this->model->create( request()->input() );
        }

        return redirect('admin/' . $this->route );
    }

    public function getDelete( $id )
    {

        $item = $this->model->find( $id );
        $item->delete();

        return redirect('admin/' . $this->route );

    }

}
