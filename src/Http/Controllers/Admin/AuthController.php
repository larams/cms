<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Larams\Cms\UserLogin;

class AuthController extends Controller
{

    protected $layout = 'larams::admin.layouts.login';

    protected $loginPath = 'admin';

    protected $redirectTo = 'admin/structure';

    use AuthenticatesUsers;

    protected $userLogin;

    public function __construct( UserLogin $userLogin )
    {
        $this->userLogin = $userLogin;
        $this->redirectTo = config('larams.admin_redirect_location', 'admin/structure');

        //        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected function authenticated(Request $request, $user)
    {

        $userIp = !empty( $_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER["REMOTE_ADDR"];

        $this->userLogin->create( [
            'username' => $user->email,
            'has_logged' => 1,
            'ip' => $userIp
        ]);

        $user->logged_at = date('Y-m-d H:i:s');
        $user->last_ip = $userIp;
        $user->save();

        if ((config('larams.require_password_change') && !empty( $user->require_change )) ||
            (config('larams.password_expires_in') && strtotime($user->password_changed_at) <= strtotime(config('larams.password_expires_in')))) {
            return redirect('admin/password');
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function incrementLoginAttempts(Request $request)
    {

        $this->userLogin->create( [
            'username' => $request->input('email'),
            'has_logged' => 1,
            'ip' => !empty( $_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER["REMOTE_ADDR"]
        ]);

        $this->limiter()->hit($this->throttleKey($request));
    }

    public function getLogin()
    {
        if (view()->exists('larams::admin.auth.authenticate')) {
            return $this->view('larams::admin.auth.authenticate');
        }

        return $this->view('larams::admin.auth.login');
    }
}
