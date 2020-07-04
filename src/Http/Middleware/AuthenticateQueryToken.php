<?php

namespace Larams\Cms\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;

class AuthenticateQueryToken extends Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->input('access_token');
        if (!empty($token)) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return parent::handle($request, $next, ...$guards);
    }
}
