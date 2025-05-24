<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ImageService;
use App\Services\ViewCacheService;
use App\Services\PerformanceMonitor;
use Illuminate\Support\Facades\URL;
use Filament\Facades\Filament;
use Filament\Pages\Auth\Login;
use App\Models\Media;
use App\Observers\MediaObserver;
use App\Models\Slide;
use App\Observers\SlideObserver;
use App\Providers\FilamentServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use League\Flysystem\Filesystem;
use Cloudinary\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\CloudinaryStorageAdapter;
use App\Http\View\Composers\FlashInfoComposer;

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
        
        // Enregistrer le FilamentServiceProvider pour corriger les URLs d'images
        $this->app->register(FilamentServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistrer les observateurs pour la synchronisation des fichiers
        Media::observe(MediaObserver::class);
        Slide::observe(SlideObserver::class);
        
        if (!app()->isLocal()) {
            $viewCache = app(ViewCacheService::class);
            $viewCache->cachePartials();
        }

        $performanceMonitor = app(PerformanceMonitor::class);
        
        // Enregistrer le View Composer pour les flash infos
        View::composer('*', FlashInfoComposer::class);
        $performanceMonitor->startMeasure();

        // Force HTTPS in production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        
        // Enregistrer le pilote Cloudinary
        Storage::extend('cloudinary', function ($app, $config) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => $config['cloud_name'],
                    'api_key' => $config['api_key'],
                    'api_secret' => $config['api_secret'],
                ],
                'url' => [
                    'secure' => true
                ]
            ]);
            
            $adapter = new CloudinaryStorageAdapter($cloudinary);
            return new Filesystem($adapter);
        });
        
        // Définir explicitement les routes d'authentification de Filament
        Filament::registerRenderHook(
            'scripts.start',
            fn (): string => '<script>
                window.filamentData = {
                    authRoutes: {
                        login: "' . route('filament.admin.auth.login') . '",
                    }
                };
            </script>'
        );
    }
}
