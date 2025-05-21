<?php
// Script de déploiement pour la solution d'images sur le serveur de production
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DÉPLOIEMENT DE LA SOLUTION D'IMAGES SUR LE SERVEUR DE PRODUCTION ===\n\n";

// 1. Vérifier si nous sommes sur le serveur de production
$hostname = gethostname();
$isProduction = strpos($hostname, 'zertos.online') !== false;

echo "1. VÉRIFICATION DE L'ENVIRONNEMENT\n";
echo "Hostname: {$hostname}\n";
echo "Environnement: " . ($isProduction ? "Production" : "Développement") . "\n";

if (!$isProduction) {
    echo "\n⚠️ Ce script doit être exécuté sur le serveur de production.\n";
    echo "Veuillez transférer les fichiers suivants vers le serveur de production :\n";
    echo "- sync-storage.php\n";
    echo "- app/Observers/MediaObserver.php\n";
    echo "- app/Observers/SlideObserver.php\n";
    echo "- README-SLIDER.md\n";
    echo "- fix-all-images.php\n";
    echo "- deploy-image-fix.php (ce script)\n\n";
    echo "Puis exécutez ce script sur le serveur de production avec la commande :\n";
    echo "php deploy-image-fix.php\n";
    exit(0);
}

// 2. Vérifier la structure des dossiers
echo "\n2. VÉRIFICATION DE LA STRUCTURE DES DOSSIERS\n";
$storagePath = storage_path('app/public');
$publicPath = public_path('storage');

echo "Dossier storage/app/public: " . (is_dir($storagePath) ? "Existe" : "N'existe pas") . "\n";
echo "Dossier public/storage: " . (is_dir($publicPath) ? "Existe" : "N'existe pas") . "\n";

// Vérifier si public/storage est un lien symbolique
if (is_link($publicPath)) {
    $target = readlink($publicPath);
    echo "public/storage est un lien symbolique pointant vers: {$target}\n";
    
    // Supprimer le lien symbolique qui cause des problèmes
    unlink($publicPath);
    echo "✅ Lien symbolique supprimé\n";
} else {
    echo "public/storage n'est pas un lien symbolique\n";
    
    // Si c'est un dossier, le supprimer
    if (is_dir($publicPath)) {
        system('rm -rf ' . escapeshellarg($publicPath));
        echo "✅ Dossier public/storage supprimé\n";
    }
}

// 3. Créer une structure de dossiers directe (sans lien symbolique)
echo "\n3. CRÉATION D'UNE STRUCTURE DE DOSSIERS DIRECTE\n";

// Créer le dossier public/storage
if (!is_dir($publicPath)) {
    mkdir($publicPath, 0777, true);
    echo "✅ Dossier public/storage créé\n";
} else {
    echo "Le dossier public/storage existe déjà\n";
}

// 4. Synchroniser les fichiers de storage/app/public vers public/storage
echo "\n4. SYNCHRONISATION DES FICHIERS\n";

// Exécuter le script de synchronisation
system('php ' . __DIR__ . '/sync-storage.php');

// 5. Vérifier les observateurs
echo "\n5. VÉRIFICATION DES OBSERVATEURS\n";
$mediaObserverPath = app_path('Observers/MediaObserver.php');
$slideObserverPath = app_path('Observers/SlideObserver.php');

echo "MediaObserver: " . (file_exists($mediaObserverPath) ? "Existe" : "N'existe pas") . "\n";
echo "SlideObserver: " . (file_exists($slideObserverPath) ? "Existe" : "N'existe pas") . "\n";

// 6. Vérifier l'enregistrement des observateurs dans AppServiceProvider
echo "\n6. VÉRIFICATION DE L'ENREGISTREMENT DES OBSERVATEURS\n";
$appServiceProviderPath = app_path('Providers/AppServiceProvider.php');
$appServiceProviderContent = file_get_contents($appServiceProviderPath);

// Vérifier si les observateurs sont déjà enregistrés
$observersRegistered = strpos($appServiceProviderContent, 'SlideObserver') !== false;
echo "Observateurs enregistrés: " . ($observersRegistered ? "OUI" : "NON") . "\n";

if (!$observersRegistered) {
    // Ajouter les imports
    $appServiceProviderContent = str_replace(
        'namespace App\\Providers;',
        "namespace App\\Providers;\n\nuse App\\Models\\Media;\nuse App\\Models\\Slide;\nuse App\\Observers\\MediaObserver;\nuse App\\Observers\\SlideObserver;",
        $appServiceProviderContent
    );
    
    // Ajouter l'enregistrement des observateurs
    $appServiceProviderContent = str_replace(
        'public function boot(): void',
        "public function boot(): void\n    {\n        // Enregistrer les observateurs\n        Media::observe(MediaObserver::class);\n        Slide::observe(SlideObserver::class);",
        $appServiceProviderContent
    );
    
    file_put_contents($appServiceProviderPath, $appServiceProviderContent);
    echo "✅ Observateurs enregistrés dans AppServiceProvider\n";
}

// 7. Vider les caches
echo "\n7. VIDAGE DES CACHES\n";
system('php ' . __DIR__ . '/artisan cache:clear');
system('php ' . __DIR__ . '/artisan view:clear');
system('php ' . __DIR__ . '/artisan config:clear');
system('php ' . __DIR__ . '/artisan route:clear');

// 8. Vérifier les permissions
echo "\n8. VÉRIFICATION DES PERMISSIONS\n";
system('chmod -R 777 ' . escapeshellarg($storagePath));
system('chmod -R 777 ' . escapeshellarg($publicPath));
echo "✅ Permissions mises à jour\n";

// 9. Tester l'accès aux images
echo "\n9. TEST D'ACCÈS AUX IMAGES\n";
echo "Pour tester l'accès aux images, veuillez visiter les URLs suivantes dans votre navigateur :\n";
echo "- https://www.zertos.online/storage/slides/illustration.png\n";
echo "- https://www.zertos.online/storage/news/featured/01JSG2N0XMEEMPNJJVJ4HX53BP.jpg\n";
echo "- https://www.zertos.online/storage/images/vjMGC7icV3tntanYg5qlnLnZ4GDp5g3YFt9DxBd7.jpg\n";

// 10. Ajouter une tâche cron pour la synchronisation régulière
echo "\n10. CONFIGURATION DE LA TÂCHE CRON\n";
echo "Pour assurer une synchronisation régulière des fichiers, ajoutez la ligne suivante à votre crontab :\n";
echo "*/15 * * * * php " . __DIR__ . "/sync-storage.php >> " . __DIR__ . "/storage/logs/sync-storage.log 2>&1\n";

echo "\n=== RÉSUMÉ DU DÉPLOIEMENT ===\n";
echo "✅ Lien symbolique remplacé par une copie directe\n";
echo "✅ Fichiers synchronisés\n";
echo "✅ Observateurs configurés\n";
echo "✅ Caches vidés\n";
echo "✅ Permissions mises à jour\n";
echo "\nLa solution est maintenant déployée sur le serveur de production.\n";
echo "Veuillez vérifier que les images s'affichent correctement sur le site.\n";
