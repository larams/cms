<?php

namespace Talandis\Larams\Http\Controllers;

use Illuminate\Http\Request;
use Talandis\Larams\StructureItem;
use Talandis\Larams\StructureType;

class TypeController extends Controller
{

    public function anyIndex( StructureItem $structureItem, Request $request )
    {

        $uri = trim( str_replace( env('BASE_URL', ''), '', $request->path() ), '/' );

        $currSite = $structureItem->byTypeName('site')->first();

        // Collect current language
        list( $languageUri ) = explode('/', $uri );
        $languageQuery = $structureItem->where('parent_id', $currSite->id )->where('active', 1 )->orderBy('left');
        if (!empty( $languageUri )) {
            $languageQuery = $languageQuery->where('uri', $languageUri );
        }
        $currLang = $languageQuery->first();
        $currItem = null;
        $currPath = [];

        // Collect current item
        if ( empty( $uri ) || $uri == $languageUri ) {
            $className = 'App\Http\Controllers\IndexController';
        } else {

            $currItem = $structureItem->with('type')->where('uri', $uri )->first();
            if (empty( $currItem)) {
                return response( 'Page not found', 404 );
            }

            $currPath = $structureItem->path( $currItem->left, $currItem->right )->where('active', 1 )->where('left', '>', $currLang->left )->where('right', '<', $currLang->right )->get();
            $className = 'App\Http\Controllers\Type\\' . ucfirst( $currItem->type->name ) . 'Controller';
        }

        if ( class_exists( $className ) ) {

            $variables = array('currItem', 'currPath', 'currLang', 'currSite');

            $methodPrefix = $request->method() == 'POST' ? 'post' : 'get';
            $methodName = $methodPrefix . 'Index';

            $r = new \ReflectionMethod( $className, $methodName );
            $methodParameters = $r->getParameters();

            $params = [];

            foreach ( $methodParameters as $param ) {

                if ( in_array( $param->getName(), $variables )) {
                    $params[] = ${$param->getName()};
                }
            }

            $controller = app()->make( $className );

            view()->share( compact('currItem', 'currPath', 'currLang', 'currSite') );

            app()->call( [ $controller, 'beforeAction'], [ $currLang, $currSite, $currPath, $currItem ] );

            return app()->call( [ $controller, $methodName ], $params );

        }

        return response('"'. $className .'" type controller not found');

    }

}
