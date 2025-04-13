<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ImageService;
use App\Services\ViewCacheService;
use App\Services\PerformanceMonitor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageService::class);
        $this->app->singleton(ViewCacheService::class);
        $this->app->singleton(PerformanceMonitor::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->isLocal()) {
            $viewCache = app(ViewCacheService::class);
            $viewCache->cachePartials();
        }

        $performanceMonitor = app(PerformanceMonitor::class);
        $performanceMonitor->startMeasure();
    }
}
