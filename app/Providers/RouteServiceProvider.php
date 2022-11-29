<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapDeveloperRoutes();

        $this->mapGuestRoutes();

        $this->mapCommonRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Web')
            ->name('web.')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware(['api', 'cors', 'api.device'])
            ->namespace($this->namespace . '\API')
            ->name('api.')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'assign.guard:admin'])
            ->namespace($this->namespace . '\Admin')
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "developer" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapDeveloperRoutes()
    {
        Route::middleware(['web', 'developer'])
            ->namespace($this->namespace)
            ->group(base_path('routes/developer.php'));
    }

    /**
     * Define the "guest" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapGuestRoutes()
    {
        Route::middleware(['web', 'assign.guard:web'])
            ->name('guest.')
            ->namespace($this->namespace . '\Guest')
            ->group(base_path('routes/guest.php'));
    }

    /**
     * Define the "common" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCommonRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/common.php'));
    }
}
