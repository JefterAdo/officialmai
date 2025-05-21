<?php

// Charger l'environnement Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

echo "=== CORRECTION COMPLÈTE DES IMAGES DU SITE ===\n\n";

// Fonction pour normaliser un nom de fichier
function normalizeFilename($filename) {
    // Extraire l'extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    // Nettoyer le nom de base (sans extension)
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    // Remplacer les espaces et caractères spéciaux par des underscores
    $cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', $basename);
    // Convertir en minuscules et limiter la longueur
    $cleanName = strtolower(substr($cleanName, 0, 50));
    // Retourner le nom normalisé avec l'extension
    return $cleanName . '.' . $extension;
}

// Fonction pour corriger les permissions
function fixPermissions($path) {
    echo "Correction des permissions pour: $path\n";
    
    // Récursivité pour les dossiers
    if (is_dir($path)) {
        chmod($path, 0775); // rwxrwxr-x
        chown($path, 'www-data');
        chgrp($path, 'www-data');
        
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                fixPermissions($path . '/' . $file);
            }
        }
    } 
    // Fichiers
    else if (is_file($path)) {
        chmod($path, 0664); // rw-rw-r--
        chown($path, 'www-data');
        chgrp($path, 'www-data');
    }
}

// 1. Correction des permissions des dossiers de stockage
echo "ÉTAPE 1: Correction des permissions des dossiers de stockage\n";
$storagePath = storage_path();
$publicPath = public_path('storage');
$bootstrapCachePath = base_path('bootstrap/cache');

echo "Correction des permissions pour storage/\n";
fixPermissions($storagePath);
echo "Correction des permissions pour public/storage/\n";
fixPermissions($publicPath);
echo "Correction des permissions pour bootstrap/cache/\n";
fixPermissions($bootstrapCachePath);

echo "\nÉTAPE 1 terminée.\n\n";

// 2. Normalisation des noms de fichiers dans le dossier slides
echo "ÉTAPE 2: Normalisation des noms de fichiers des slides\n";
$slidesDir = storage_path('app/public/slides/');
$files = scandir($slidesDir);
$fileMapping = [];

foreach ($files as $file) {
    if ($file == '.' || $file == '..' || is_dir($slidesDir . $file)) {
        continue;
    }
    
    // Vérifier si le nom contient des espaces ou caractères spéciaux
    if (preg_match('/[\s\'"\(\)&]/', $file)) {
        $newFilename = normalizeFilename($file);
        
        // Éviter les collisions de noms
        $counter = 1;
        $baseNewFilename = $newFilename;
        while (file_exists($slidesDir . $newFilename) && $newFilename != $file) {
            $extension = pathinfo($baseNewFilename, PATHINFO_EXTENSION);
            $basename = pathinfo($baseNewFilename, PATHINFO_FILENAME);
            $newFilename = $basename . '_' . $counter . '.' . $extension;
            $counter++;
        }
        
        echo "Renommage: $file -> $newFilename\n";
        
        if (rename($slidesDir . $file, $slidesDir . $newFilename)) {
            $fileMapping[$file] = $newFilename;
            // Corriger les permissions du nouveau fichier
            chmod($slidesDir . $newFilename, 0664);
            chown($slidesDir . $newFilename, 'www-data');
            chgrp($slidesDir . $newFilename, 'www-data');
        } else {
            echo "ERREUR: Impossible de renommer $file\n";
        }
    } else {
        // Même si le nom est déjà correct, on s'assure que les permissions sont bonnes
        chmod($slidesDir . $file, 0664);
        chown($slidesDir . $file, 'www-data');
        chgrp($slidesDir . $file, 'www-data');
    }
}

echo "\nÉTAPE 2 terminée.\n\n";

// 3. Mise à jour de la base de données avec les nouveaux noms de fichiers
echo "ÉTAPE 3: Mise à jour de la base de données\n";
$slides = DB::table('slides')->get();

foreach ($slides as $slide) {
    echo "Slide ID: {$slide->id} - Titre: {$slide->title}\n";
    echo "  Chemin actuel: {$slide->image_path}\n";
    
    // Extraire le nom de fichier du chemin
    $filename = basename(trim($slide->image_path));
    
    // Vérifier si ce fichier a été renommé
    if (isset($fileMapping[$filename])) {
        $newPath = 'slides/' . $fileMapping[$filename];
        DB::table('slides')->where('id', $slide->id)->update(['image_path' => $newPath]);
        echo "  Chemin mis à jour: $newPath\n";
    } 
    // Vérifier si le fichier existe
    else {
        $fullPath = $slidesDir . $filename;
        if (!file_exists($fullPath)) {
            echo "  ATTENTION: Le fichier n'existe pas: $fullPath\n";
            
            // Rechercher un fichier correspondant dans le dossier
            $found = false;
            foreach (scandir($slidesDir) as $file) {
                if ($file == '.' || $file == '..' || is_dir($slidesDir . $file)) {
                    continue;
                }
                
                // Vérifier si le nom du fichier correspond au slide ID
                if (strpos($file, 'slide_' . $slide->id . '.') === 0 || 
                    strpos($file, 'slide_' . $slide->id . '_') === 0) {
                    $newPath = 'slides/' . $file;
                    DB::table('slides')->where('id', $slide->id)->update(['image_path' => $newPath]);
                    echo "  Chemin mis à jour avec fichier trouvé: $newPath\n";
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                echo "  ERREUR: Aucun fichier correspondant trouvé pour le slide ID {$slide->id}\n";
            }
        } else {
            echo "  Le fichier existe, aucune mise à jour nécessaire\n";
        }
    }
}

echo "\nÉTAPE 3 terminée.\n\n";

// 4. Vérification finale
echo "ÉTAPE 4: Vérification finale\n";
$slides = DB::table('slides')->get();

foreach ($slides as $slide) {
    $filename = basename(trim($slide->image_path));
    $fullPath = $slidesDir . $filename;
    
    if (file_exists($fullPath)) {
        echo "✓ Slide ID {$slide->id}: Le fichier existe: $fullPath\n";
    } else {
        echo "✗ Slide ID {$slide->id}: ERREUR - Le fichier n'existe pas: $fullPath\n";
    }
}

echo "\nÉTAPE 4 terminée.\n\n";

echo "=== CORRECTION TERMINÉE ===\n";
echo "N'oubliez pas de vider le cache de l'application avec:\n";
echo "php artisan cache:clear\n";
echo "php artisan view:clear\n";
echo "php artisan config:clear\n";
