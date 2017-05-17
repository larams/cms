<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;

class PasswordController extends Controller
{

    protected $layout = 'larams::admin.layouts.login';

    public function getIndex()
    {

        return $this->view('larams::admin.password.index');
    }

    public function postIndex( Request $request )
    {

        $this->validate( $request, [
            'password' => 'required|confirmed'
        ] );

        $user = auth()->user();
        $user->password = \Hash::make( $request->get('password') );
        $user->password_changed_at = date('Y-m-d H:i:s');
        $user->require_change = 0;
        $user->save();

        return redirect('admin/structure/index');

    }
}
