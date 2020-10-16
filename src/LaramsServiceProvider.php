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

require(__DIR__ . '/Helpers/functions.php');

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
    public function boot()
    {

        $viewsPath = __DIR__ . '/../resources/views';

        \URL::forceRootUrl(url(env('BASE_URL', '')));

        $this->loadViewsFrom($viewsPath, 'larams');

        $this->setupRoutes($this->app->router);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'larams');

        if ( version_compare( app()->version(), '8.0.0', '>=')) {
            $seedersPath = database_path('seeders');
            $seedersSource = __DIR__ . '/../seeders';
        } else {
            $seedersPath = database_path('seeds');
            $seedersSource = __DIR__ . '/../seeds';
        }

        $this->publishes([
            __DIR__ . '/../config/larams.php' => config_path('larams.php'),
            __DIR__ . '/../public' => public_path('vendor/larams'),
            __DIR__ . '/../migrations' => database_path('migrations'),
            $seedersSource => $seedersPath,
            __DIR__ . '/../docker' => base_path('docker'),
            __DIR__ . '/../docker-compose.yml' => base_path('docker-compose.yml'),
            __DIR__ . '/../.rsync-exclude' => base_path('.rsync-exclude'),
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

        $router->aliasMiddleware('ipCheck', \Larams\Cms\Http\Middleware\ValidateAdminIp::class );
        $router->aliasMiddleware('cacheControl', \Larams\Cms\Http\Middleware\CacheControl::class );
        $router->aliasMiddleware('permission', \Larams\Cms\Http\Middleware\ValidateAdminPermisssions::class );

        if (in_array(request()->segment(1), config('larams.locales'))) {
            app()->setLocale(request()->segment(1));
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

        $this->mergeConfigFrom(__DIR__ . '/../config/larams.php', 'larams');
        $this->mergeConfigFrom(__DIR__ . '/../config/handler.php', 'larams.handler');

        foreach ($defaultHandlers as $defaultHandler) {
            $this->mergeConfigFrom(__DIR__ . '/../config/handlers/' . $defaultHandler . '.php', 'larams.handlers.' . $defaultHandler);
        }
    }

}
