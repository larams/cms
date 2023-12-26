<?php

namespace Larams\Cms\Http\Middleware;

use Closure;
use Larams\Cms\Model\Redirect;
use Larams\Cms\Model\StructureItem;

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
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $requestUrl = ltrim($request->getRequestUri(), '/');
        $urls = $this->redirect->all();

        foreach ($urls as $url) {
            $pattern = '#' . str_replace('/', '\\/', $url->from_url) . '#';
            if (preg_match($pattern, $requestUrl)) {
                $targetUrl = preg_replace($pattern, $url->to_url, $requestUrl);
                return redirect($targetUrl, 301);
            }
        }

        return $next($request);
    }
}
