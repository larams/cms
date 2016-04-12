<?php

namespace Talandis\Larams\Http\Controllers\Admin;

use Talandis\Larams\StructureType;
use Talandis\Larams\User;

class AdministratorController extends Controller
{

    protected $route = 'administrators';

    public function getIndex( User $user )
    {

        $users = $user->orderBy('email')->get();

        return $this->view('larams::admin.administrators.index', compact('users'));

    }

    public function getAdd( User $user)
    {

        $isCreate = true;
        $types = $user->types();

        return $this->view('larams::admin.administrators.edit', compact('isCreate', 'types'));

    }

    public function getEdit( User $user, $id )
    {

        $item = $user->find( $id );

        $types = $user->types();

        return $this->view('larams::admin.administrators.edit', compact('item', 'types') );

    }

    public function postSave( User $user, $id = null )
    {

        /** @var StructureType $item */
        if (!empty( $id )) {
            $item = $user->find( $id );
            $item->fill( request()->input() )->save();
        } else {
            $user->create( request()->input() );
        }

        return redirect('admin/' . $this->route );
    }

    public function getDelete( User $user, $id )
    {

        $item = $user->find( $id );
        $item->delete();

        return redirect('admin/' . $this->route );

    }

}
