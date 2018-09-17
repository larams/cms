<?php

namespace Larams\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Larams\Cms\StructureItem;
use Larams\Cms\StructureType;

class TypeController extends Controller
{

    protected function getIndexController( $currLang )
    {
        return 'App\Http\Controllers\IndexController';
    }

    protected function getTypeController( $structureType, $currLang, $typeName )
    {
        return 'App\Http\Controllers\Type\\' . $structureType->buildClassName( $typeName ) . 'Controller';
    }

    public function anyIndex( StructureItem $structureItem, StructureType $structureType, Request $request )
    {

        $uri = trim( str_replace( env('BASE_URL', ''), '', $request->path() ), '/' );

        $currItem = null;
        $currPath = [];
        $currLang = $structureItem->currLang();

        // Collect current item
        if ( empty( $uri ) || (!empty( $currLang ) && $uri == $currLang->uri) ) {
            $className = $this->getIndexController( $currLang );
        } else {

            /** @var StructureItem $currItem */
            $currItem = $structureItem->withTrashed()->with('type')->where('uri', $uri )->first();
            if (empty( $currItem) || empty($currLang) || !$currItem->canBeDisplayed() ) {

                if ( !empty( $currItem ) && $currItem->trashed()) {
                    $parentItems = $structureItem->withTrashed()->path( $currItem->left, $currItem->right )->orderBy('left', 'desc')->get();
                    foreach ( $parentItems as $parentItem ) {
                        if ( !$parentItem->trashed()) {
                            return redirect( $parentItem->uri, 301 );
                        }
                    }
                }

                return abort( 404, 'Page not found');
            }

            $currPath = $structureItem->path( $currItem->left, $currItem->right )->where('active', 1 )->where('left', '>', $currLang->left )->where('right', '<', $currLang->right )->orderBy('left')->get();

            $structureItem->currPath( $currPath );
            $structureItem->currItem( $currItem );

            $className = $this->getTypeController( $structureType, $currLang, $currItem->type->name );
        }

        if ( class_exists( $className ) ) {

            $methodPrefix = $request->method() == 'POST' ? 'post' : 'get';
            $methodName = $methodPrefix . 'Index';
            $controller = app()->make( $className );

            view()->share( compact('currItem', 'currPath') );

            if ( method_exists( $controller, 'beforeAction') ) {
                app()->call( [ $controller, 'beforeAction'] );
            }

            return app()->call( [ $controller, $methodName ] );

        }

        return abort( 404,'"'. $className .'" type controller not found');

    }
}
