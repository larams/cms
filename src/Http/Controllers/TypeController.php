<?php

namespace Talandis\Larams\Http\Controllers;

use Talandis\Larams\StructureItem;
use Talandis\Larams\StructureType;

class TypeController extends Controller
{

    public function getIndex( StructureItem $structureItem )
    {

        $uri = trim( str_replace( env('BASE_URL', ''), '', request()->path() ), '/' );

        $currSite = $structureItem->byTypeName('site')->first();

        // Collect current language
        $languageUri = request()->segment(1);
        $languageQuery = $structureItem->where('parent_id', $currSite->id )->where('active', 1 )->orderBy('left');
        if (!empty( $languageUri )) {
            $languageQuery = $languageQuery->where('uri', $languageUri );
        }
        $currLang = $languageQuery->first();

        $currItem = null;
        $currPath = null;
        // Collect current item
        if ( empty( $uri ) || $uri == $languageUri ) {
            $className = 'App\Http\Controllers\IndexController';

//            $params =  [  $currLang, $currSite ];
        } else {

            $currItem = $structureItem->with('type')->where('uri', $uri )->first();

            if (empty( $currItem)) {
                return response( 'Page not found', 404 );
            }

            $currPath = $structureItem->path( $currItem->left, $currItem->right )->get();

            $className = 'App\Http\Controllers\Type\\' . ucfirst( $currItem->type->name ) . 'Controller';

//            $params = [ $currItem, $currPath, $currLang, $currSite ];
        }


        if ( class_exists( $className ) ) {

            $variables = array('currItem', 'currPath', 'currLang', 'currSite');

            $r = new \ReflectionMethod( $className, 'getIndex');
            $methodParameters = $r->getParameters();

            $params = [];

            foreach ( $methodParameters as $param ) {

                if ( in_array( $param->getName(), $variables )) {
                    $params[] = ${$param->getName()};
                }
            }

            $controller = app()->make( $className );

            app()->call( [ $controller, 'beforeAction'], [ $currLang, $currSite, $currPath, $currItem ] );

            return app()->call( [ $controller, 'getIndex'], $params );

        }

        return response('"'. $className .'" type controller not found');

    }

}
