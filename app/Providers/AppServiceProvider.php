<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

use Auth;
use Carbon\Carbon;

use App\Helpers\AuthHelper;
use App\Helpers\EnvHelper;
use App\Helpers\GlobalChecker;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        if (config('web.force_https')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {

            View::share('self', new AuthHelper);
            
            View::share('checker', new GlobalChecker);
            View::share('env', new EnvHelper);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
