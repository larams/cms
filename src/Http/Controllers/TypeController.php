<?php

namespace Talandis\Larams\Http\Controllers;

use Talandis\Larams\StructureItem;
use Talandis\Larams\StructureType;

class TypeController extends Controller
{

    public function getIndex( StructureItem $structureItem, $languageUri = null )
    {

        $uri = trim( request()->path(), '/' );

        $currentSite = $structureItem->byTypeName('site')->first();

        // Collect current language
        $languageQuery = $structureItem->where('parent_id', $currentSite->id )->where('active', 1 );
        if (!empty( $languageUri )) {
            $languageQuery = $languageQuery->where('uri', $languageUri );
        }
        $currentLanguage = $languageQuery->first();

        // Collect current item
        $currentItem = null;
        if (!empty( $uri )) {
            $currentItem = $structureItem->with('type')->where('uri', $uri )->first();

            if (empty( $currentItem)) {
                return response( 'Page not found', 404 );
            }
        }


        if ( empty( $uri )) {
            $className = 'App\Http\Controllers\IndexController';
        } else {
            $className = 'App\Http\Controllers\Type\\' . ucfirst( $currentItem->type->name ) . 'Controller';
        }


        if ( class_exists( $className ) ) {

            $controller = app()->make( $className );

            return app()->call( [ $controller, 'getIndex'], [ $currentItem, $currentLanguage, $currentSite ] );

        }

        return response('"'. $className .'" type controller not found');

    }

}
