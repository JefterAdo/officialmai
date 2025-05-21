<?php

// Charger l'environnement Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

echo "Correction des chemins d'images des slides...\n\n";

// Récupérer tous les slides
$slides = DB::table('slides')->get();

// Dossier de stockage des images
$storageDir = storage_path('app/public/slides/');

// Récupérer tous les fichiers dans le dossier
$files = scandir($storageDir);

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
        
        // Normaliser le chemin
        $normalizedPath = 'slides/' . $filename;
        
        // Mettre à jour la base de données si nécessaire
        if ($normalizedPath != $slide->image_path) {
            DB::table('slides')->where('id', $slide->id)->update(['image_path' => $normalizedPath]);
            echo "  Chemin corrigé: {$normalizedPath}\n";
        } else {
            echo "  Aucune correction nécessaire\n";
        }
    } else {
        echo "  Le fichier n'existe pas: {$fullPath}\n";
        
        // Recherche approximative
        $found = false;
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            
            // Comparer sans espaces ni caractères spéciaux
            $cleanFilename = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($filename));
            $cleanFile = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($file));
            
            if (strpos($cleanFile, $cleanFilename) !== false || strpos($cleanFilename, $cleanFile) !== false) {
                echo "  Fichier similaire trouvé: {$file}\n";
                
                // Normaliser le chemin
                $normalizedPath = 'slides/' . $file;
                
                // Mettre à jour la base de données
                DB::table('slides')->where('id', $slide->id)->update(['image_path' => $normalizedPath]);
                echo "  Chemin corrigé: {$normalizedPath}\n";
                
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo "  AUCUN FICHIER SIMILAIRE TROUVÉ!\n";
        }
    }
    
    echo "\n";
}

echo "Terminé!\n";
