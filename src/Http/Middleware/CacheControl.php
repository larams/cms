<?php

namespace Larams\Cms\Http\Middleware;

use Closure;

class CacheControl
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-cache, must-revalidate');

        return $response;
    }
}
