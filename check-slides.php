<?php

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Récupérer tous les slides
$slides = DB::table('slides')->get();

echo "=== INFORMATIONS SUR LES SLIDES ===\n\n";

foreach ($slides as $slide) {
    echo "ID: {$slide->id}\n";
    echo "Titre: {$slide->title}\n";
    echo "Chemin d'image: {$slide->image_path}\n";
    
    // Vérifier si le fichier existe
    $fullPath = storage_path('app/public/' . $slide->image_path);
    echo "Chemin complet: {$fullPath}\n";
    echo "Le fichier existe: " . (file_exists($fullPath) ? "OUI" : "NON") . "\n";
    
    // Vérifier si l'URL est accessible
    $url = asset('storage/' . $slide->image_path);
    echo "URL: {$url}\n";
    
    echo "Actif: " . ($slide->is_active ? "OUI" : "NON") . "\n";
    echo "Ordre: {$slide->order}\n";
    echo "\n----------------------------\n\n";
}

// Vérifier les fichiers dans le dossier slides
echo "=== FICHIERS DANS LE DOSSIER SLIDES ===\n\n";
$slidesDir = storage_path('app/public/slides');
$files = scandir($slidesDir);

foreach ($files as $file) {
    if ($file == '.' || $file == '..') continue;
    
    echo "Fichier: {$file}\n";
    echo "Taille: " . filesize($slidesDir . '/' . $file) . " octets\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($slidesDir . '/' . $file)), -4) . "\n";
    echo "Propriétaire: " . posix_getpwuid(fileowner($slidesDir . '/' . $file))['name'] . "\n";
    echo "Groupe: " . posix_getgrgid(filegroup($slidesDir . '/' . $file))['name'] . "\n";
    echo "\n";
}

// Vérifier la configuration du storage
echo "=== CONFIGURATION DU STORAGE ===\n\n";
echo "Storage disk par défaut: " . config('filesystems.default') . "\n";
echo "URL du disque public: " . config('filesystems.disks.public.url') . "\n";
echo "Racine du disque public: " . config('filesystems.disks.public.root') . "\n";
echo "Lien symbolique: " . json_encode(config('filesystems.links')) . "\n";
