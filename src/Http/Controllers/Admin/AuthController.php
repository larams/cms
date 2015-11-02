<?php

namespace Talandis\Larams\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{

    protected $layout = 'larams::admin.layouts.login';

    protected $loginPath = 'admin/structure';

    use AuthenticatesUsers, ThrottlesLogins;

    public function __construct()
    {
//        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        if (view()->exists('larams::admin.auth.authenticate')) {
            return $this->view('larams::admin.auth.authenticate');
        }

        return $this->view('larams::admin.auth.login');
    }
}
