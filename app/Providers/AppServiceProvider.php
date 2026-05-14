<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Order;
use App\Observers\OrderObserver;

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
        // Forco HTTPS në production (shmang "invalid signature" te verify links)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Order::observe(OrderObserver::class);
    }
}
