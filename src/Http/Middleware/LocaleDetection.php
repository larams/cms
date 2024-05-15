<?php

namespace Larams\Cms\Http\Middleware;

use Closure;
use Larams\Cms\Model\StructureItem;

class LocaleDetection
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
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $currentDomain = config('larams.domain');
        if (empty($currentDomain)) {
            $currentDomain = $request->getHost();
        }

        // Set current site
        $sites = $this->structureItem->byTypeName('site')->get();
        if (count($sites) > 1) {
            foreach ($sites as $site) {
                if (empty($currSite) || $site->name == $currentDomain) {
                    $currSite = $site;
                }
            }
        } else {
            $currSite = $this->structureItem->byTypeName('site')->first();
        }

        $this->structureItem->currSite($currSite);

        if (!empty($currSite)) {

            $uri = trim(str_replace(env('BASE_URL', ''), '', request()->path()), '/');
            list($languageUri) = explode('/', $uri);

            $languageQuery = $this->structureItem->where('parent_id', $currSite->id)->where('active', 1)->orderBy('left');
            if (!empty($languageUri)) {
                $languageQuery = $languageQuery->where('uri', $languageUri);
            } elseif ( $request->getLocale() != $request->getDefaultLocale() ) {
                $languageQuery = $languageQuery->where('uri', $request->getLocale() );
            }

            $currLang = $languageQuery->first();

            if (empty($currLang) && !empty($uri)) {
                $currItem = $this->structureItem->where('active', 1)->where('uri', $uri)->first();
                if (!empty($currItem)) {
                    $currLang = $this->structureItem->leftJoin('structure_types', 'structure_types.id', '=', 'structure_items.type_id')->where('left', '<', $currItem->left)->where('right', '>', $currItem->right)->where('structure_types.name', 'site_lang')->select('structure_items.*')->first();
                }
            }

            if (empty( $currLang) && $request->getLocale()) {
                $currLang = $this->structureItem->where('uri', $request->getLocale())->where('active', 1)->orderBy('left')->first();
            }

            $this->structureItem->currLang($currLang);

            if (!empty($currLang) && !empty($currLang->data->short_code)) {
                app()->setLocale($currLang->data->short_code);
            }

        }

        return $next($request);
    }
}
