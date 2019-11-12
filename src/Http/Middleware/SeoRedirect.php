<?php

namespace Larams\Cms\Http\Middleware;

use Closure;
use Larams\Cms\Redirect;
use Larams\Cms\StructureItem;

class SeoRedirect
{

    /** @var Redirect  */
    protected $redirect;

    public function __construct( Redirect $redirect )
    {
        $this->redirect = $redirect;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//        $uri = trim(str_replace(env('BASE_URL', ''), '', request()->path()), '/');
//
//        echo '<pre>'; var_dump( $uri ); echo '</pre>';
//        die( '<span style="color: #0A0;">'. __FILE__ .'</span>:'. __LINE__.PHP_EOL );

        return $next($request);
    }
}
