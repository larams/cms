<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Larams\Cms\Model\Role;
use Larams\Cms\Model\StructureType;

class AdministratorController extends Controller
{

    protected $route = 'administrators';

    public function __construct()
    {
        $this->model = app()->make( config('larams.admin.database_model') );
    }

    public function getIndex()
    {

        $users = $this->model->orderBy('email')->get();

        return $this->view('larams::admin.administrators.index', compact('users'));

    }

    public function getAdd( Role $role )
    {
        $isCreate = true;
        $roles = $role->get();
        $user = $this->model->find( auth()->user()->id );

        return $this->view('larams::admin.administrators.edit', compact('isCreate', 'user', 'roles'));
    }

    public function getEdit( Role $role, $id )
    {
        $item = $this->model->find( $id );
        $roles = $role->get();
        $user = $this->model->find( auth()->user()->id );

        return $this->view('larams::admin.administrators.edit', compact('item', 'user', 'roles') );
    }

    public function postSave( Request $request, $id = null )
    {
        $input = request()->input();

        $this->validate( $request, [ 'email' => 'required|email' ] );

        if (config('larams.require_password_change') && !empty( $input['password']) ) {
            $input['require_change'] = 1;
        }

        /** @var StructureType $item */
        if (!empty( $id )) {
            $item = $this->model->find( $id );
            $item->fill( $input )->save();
        } else {
            $item = $this->model->create( $input );
        }

        if ( array_key_exists( 'send', $input ) ) {

            \Mail::send('larams::admin.emails.password', compact('input', 'item'), function( $message ) use ( $input, $item ) {

                $message->to( $input['email']);
                $message->subject( trans('admin.text.new_administrator_mail_subject') );

            });

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
