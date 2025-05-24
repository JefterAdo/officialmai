<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->environment('testing')) {
            // Désactiver le cache de vues pendant les tests
            Config::set('view.cache', false);
            
            // Désactiver d'autres caches si nécessaire
            Config::set('app.debug', true);
        }
    }
}
