<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

class FilamentServiceProvider extends ServiceProvider
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
        // Modifier la façon dont les URLs de Storage sont générées dans Filament
        // Pour contourner le problème "Too many levels of symbolic links"
        URL::macro('storageAsset', function ($path) {
            return '/storage/' . $path;
        });

        // Ajouter une directive Blade personnalisée pour les images
        Blade::directive('storageUrl', function ($expression) {
            return "<?php echo '/storage/' . {$expression}; ?>";
        });

        // Remplacer la fonction asset() pour les chemins storage/ dans les vues Filament
        $this->app->bind('storage.url', function ($app, $parameters) {
            $path = $parameters[0] ?? '';
            if (Str::startsWith($path, 'storage/')) {
                return '/storage/' . Str::after($path, 'storage/');
            }
            return asset($path);
        });
    }
}
