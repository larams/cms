<?php

namespace Larams\Cms\Http\Middleware;

use Closure;

class ValidateAdminIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $adminIps = config('larams.administrator_ips');

        if (!empty($adminIps) && !in_array($request->ip(), $adminIps)) {
            app()->abort(404);
        }

        return $next($request);
    }
}
