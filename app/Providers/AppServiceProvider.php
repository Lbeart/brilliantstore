<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Vendos gjuhën nga session ose fallback te config('app.locale')
        App::setLocale(session('locale', config('app.locale')));

        // Forco HTTPS në production (shmang "invalid signature" te verify links)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
