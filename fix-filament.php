<?php

// Charger l'environnement Laravel
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Définir le chemin vers les fichiers publics
$publicPath = realpath(__DIR__ . '/../www.zertos.online/public');
if (!$publicPath) {
    $publicPath = realpath(__DIR__ . '/public');
}

echo "Chemin public: {$publicPath}\n";

// Vérifier et créer des liens symboliques si nécessaire
$filamentAssets = [
    '/js/filament',
    '/css/filament',
    '/js/awcodes',
    '/css/awcodes'
];

// Exécuter Artisan pour reconstruire Filament
echo "Publication des assets Filament...\n";
system('php artisan filament:assets');

// Effacer les caches
echo "Effacement des caches...\n";
system('php artisan optimize:clear');
system('php artisan route:clear');
system('php artisan view:clear');
system('php artisan config:clear');
system('php artisan cache:clear');

// Nettoyer le cache des vues compilées
$viewsPath = __DIR__ . '/storage/framework/views';
if (is_dir($viewsPath)) {
    $files = glob($viewsPath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "Cache des vues nettoyé.\n";
}

// Reconstruire le cache des vues
echo "Reconstruction du cache des vues...\n";
system('php artisan view:cache');

// Définir les bonnes permissions
echo "Définition des permissions...\n";
system('chmod -R 775 storage');
system('chmod -R 775 bootstrap/cache');

echo "\nTerminé ! Veuillez maintenant vider le cache de votre navigateur et réessayer.\n";
echo "Si la page est toujours blanche, essayez d'ouvrir la console développeur de votre navigateur pour voir les erreurs JavaScript.\n"; 