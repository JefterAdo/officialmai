<?php

// Charger l'environnement Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

echo "Renommage des fichiers d'images des slides...\n\n";

// Récupérer tous les slides
$slides = DB::table('slides')->get();

// Dossier de stockage des images
$storageDir = storage_path('app/public/slides/');

foreach ($slides as $slide) {
    echo "Slide ID: {$slide->id} - Titre: {$slide->title}\n";
    echo "  Chemin actuel: {$slide->image_path}\n";
    
    // Extraire le nom de fichier du chemin
    $filename = basename(trim($slide->image_path));
    echo "  Nom de fichier: {$filename}\n";
    
    // Vérifier si le fichier existe
    $fullPath = $storageDir . $filename;
    if (file_exists($fullPath)) {
        echo "  Le fichier existe: {$fullPath}\n";
        
        // Générer un nouveau nom de fichier sans espaces ni caractères spéciaux
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $newFilename = 'slide_' . $slide->id . '_' . time() . '.' . $extension;
        $newPath = $storageDir . $newFilename;
        
        // Copier le fichier avec le nouveau nom
        if (copy($fullPath, $newPath)) {
            echo "  Fichier copié vers: {$newPath}\n";
            
            // Mettre à jour la base de données
            $newDbPath = 'slides/' . $newFilename;
            DB::table('slides')->where('id', $slide->id)->update(['image_path' => $newDbPath]);
            echo "  Base de données mise à jour avec: {$newDbPath}\n";
        } else {
            echo "  ERREUR: Impossible de copier le fichier\n";
        }
    } else {
        echo "  Le fichier n'existe pas: {$fullPath}\n";
    }
    
    echo "\n";
}

echo "Terminé!\n";
