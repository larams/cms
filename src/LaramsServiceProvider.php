<?php
/**
 * Larams - Content Management System
 *
 * @author    Tomas Talandis <tomas@talandis.lt>
 * @copyright 2015 Tomas Talandis
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/talandis/larams
 */

namespace Talandis\Larams;

require( __DIR__ . '/Helpers/functions.php' );

use \Illuminate\Routing\Router;

class LaramsServiceProvider extends \Illuminate\Support\ServiceProvider
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
    public function boot()
    {

        $viewsPath = __DIR__ . '/../resources/views';

        $this->loadViewsFrom($viewsPath, 'larams');

        $this->setupRoutes($this->app->router);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'larams');

        $this->publishes([
            $viewsPath . '/types' => base_path('resources/views/vendor/larams/types'),
            __DIR__.'../public' => public_path('vendor/larams'),
            __DIR__.'../migrations' => database_path('migrations'),
            __DIR__.'../seeds' => database_path('seeds'),
        ], '');

    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {

        $router->group(['namespace' => 'Talandis\Larams\Http\Controllers'], function ($router) {
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

        foreach ($defaultHandlers as $defaultHandler) {
            $this->mergeConfigFrom(__DIR__ . '/../config/handlers/' . $defaultHandler . '.php', 'larams.handlers.' . $defaultHandler);
        }
    }

}
