<?php

namespace Larams\Cms\Http\Middleware;

use Closure;
use Larams\Cms\Model\StructureItem;

class LayoutBuilder
{
    /** @var StructureItem  */
    protected $structureItem;

    public function __construct(StructureItem $structureItem)
    {
        $this->structureItem = $structureItem;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($this->structureItem->currLang()) {

            $currSite = $this->structureItem->currSite();
            $currLang = $this->structureItem->currLang();

            view()->share('currSite', $currSite);
            view()->share('currLang', $currLang);

        }

        return $next($request);
    }
}
