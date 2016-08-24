<?php
/**
 * Larams - Content Management System
 *
 * @author    Tomas Talandis <tomas@talandis.lt>
 * @copyright 2015 Tomas Talandis
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/talandis/larams
 */

namespace Larams\Cms;

require( __DIR__ . '/Helpers/functions.php' );

use \Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaramsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot( StructureItem $structureItem )
    {

        $this->loadStructureData( $structureItem );

        $viewsPath = __DIR__ . '/../resources/views';

        \URL::forceRootUrl( url(env('BASE_URL', '') ) );

        $this->loadViewsFrom($viewsPath, 'larams');

        $this->setupRoutes($this->app->router);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'larams');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/larams'),
            __DIR__.'/../migrations' => database_path('migrations'),
            __DIR__.'/../seeds' => database_path('seeds'),
        ], '');

    }

    public function loadStructureData( StructureItem $structureItem )
    {

        if ( \Schema::hasTable('structure_items')) {

            // Set current site
            $currSite = $structureItem->byTypeName('site')->first();
            $structureItem->currSite($currSite);

            if (!empty( $currSite )) {

                $uri = trim(str_replace(env('BASE_URL', ''), '', request()->path()), '/');
                list($languageUri) = explode('/', $uri);

                $languageQuery = $structureItem->where('parent_id', $currSite->id)->where('active', 1)->orderBy('left');
                if (!empty($languageUri)) {
                    $languageQuery = $languageQuery->where('uri', $languageUri);
                }
                $currLang = $languageQuery->first();
                $structureItem->currLang($currLang);

                if (!empty( $currLang )) {
                    app()->setLocale( $languageUri );
                }

            }
        }

    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {

        if (in_array( request()->segment(1), \Config::get('larams.locales'))) {
            app()->setLocale( request()->segment(1) );
        }

        $router->group(['namespace' => 'Larams\Cms\Http\Controllers'], function ($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

        $defaultHandlers = array('empty', 'form_field', 'site', 'site_lang', 'sites', 'text');

        $this->mergeConfigFrom(__DIR__ . '/../config/handler.php', 'larams.handler');
        $this->mergeConfigFrom(__DIR__ . '/../config/locales.php', 'larams.locales');

        foreach ($defaultHandlers as $defaultHandler) {
            $this->mergeConfigFrom(__DIR__ . '/../config/handlers/' . $defaultHandler . '.php', 'larams.handlers.' . $defaultHandler);
        }
    }

}
