<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UrlGenerationServiceProvider extends ServiceProvider
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
        // Remplacer la fonction asset() pour les chemins storage/
        // Cela affecte toute l'application, y compris Filament
        URL::macro('fixedStorageUrl', function ($path) {
            if (Str::startsWith($path, 'storage/')) {
                return '/storage/' . Str::after($path, 'storage/');
            }
            return $path;
        });
        
        // Remplacer la fonction asset() globalement
        $this->app->bind('url.asset', function ($app, $parameters) {
            $path = $parameters[0] ?? '';
            $secure = $parameters[1] ?? null;
            
            // Si c'est un chemin storage/, utiliser l'URL directe
            if (Str::startsWith($path, 'storage/')) {
                return '/storage/' . Str::after($path, 'storage/');
            }
            
            // Sinon, utiliser la fonction asset() normale
            return asset($path, $secure);
        });
    }
}
