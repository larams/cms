<?php

namespace Talandis\Larams\Http\Controllers;

use Talandis\Larams\StructureItem;
use Talandis\Larams\StructureType;

class TypeController extends Controller
{

    public function getIndex( StructureItem $structureItem )
    {

        $uri = trim( str_replace( env('BASE_URL', ''), '', request()->path() ), '/' );

        $currentSite = $structureItem->byTypeName('site')->first();

        // Collect current language
        $languageUri = request()->segment(1);
        $languageQuery = $structureItem->where('parent_id', $currentSite->id )->where('active', 1 )->orderBy('left');
        if (!empty( $languageUri )) {
            $languageQuery = $languageQuery->where('uri', $languageUri );
        }
        $currentLanguage = $languageQuery->first();

        $currentItem = null;
        // Collect current item
        if ( empty( $uri ) || $uri == $languageUri ) {
            $className = 'App\Http\Controllers\IndexController';

            $params =  [ $currentLanguage, $currentSite ];
        } else {

            $currentItem = $structureItem->with('type')->where('uri', $uri )->first();

            if (empty( $currentItem)) {
                return response( 'Page not found', 404 );
            }

            $className = 'App\Http\Controllers\Type\\' . ucfirst( $currentItem->type->name ) . 'Controller';

            $params = [ $currentItem, $currentLanguage, $currentSite ];
        }


        if ( class_exists( $className ) ) {

            $controller = app()->make( $className );

            app()->call( [ $controller, 'beforeAction'], [ $currentLanguage, $currentSite, $currentItem ] );

            return app()->call( [ $controller, 'getIndex'], $params );

        }

        return response('"'. $className .'" type controller not found');

    }

}
