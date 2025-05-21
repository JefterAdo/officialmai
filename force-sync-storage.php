<?php
/**
 * Script de synchronisation forcée des fichiers de storage/app/public vers public/storage
 * À exécuter manuellement après un upload d'image ou en cas de problème d'affichage
 */

// Charger l'environnement Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== SYNCHRONISATION FORCÉE DES IMAGES ===\n";
echo "Copie de tous les fichiers de storage/app/public vers public/storage\n";
echo "Cette opération peut prendre quelques secondes...\n\n";

// Forcer la copie de tous les fichiers (ignorer les dates de modification)
function forceSyncDirectory($source, $destination) {
    $count = 0;
    
    if (!is_dir($source)) {
        echo "ERREUR: Le dossier source n'existe pas: {$source}\n";
        return 0;
    }
    
    if (!is_dir($destination)) {
        if (!mkdir($destination, 0777, true)) {
            echo "ERREUR: Impossible de créer le dossier: {$destination}\n";
            return 0;
        }
        echo "Dossier créé: {$destination}\n";
    }
    
    $dir = opendir($source);
    while (($file = readdir($dir)) !== false) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        
        $sourceFile = $source . '/' . $file;
        $destFile = $destination . '/' . $file;
        
        if (is_dir($sourceFile)) {
            // Récursion pour les sous-dossiers
            $count += forceSyncDirectory($sourceFile, $destFile);
        } else {
            // Copier tous les fichiers, même s'ils existent déjà
            $copyCommand = "sudo cp '{$sourceFile}' '{$destFile}' 2>&1";
            $output = shell_exec($copyCommand);
            
            if (empty($output) && file_exists($destFile)) {
                // Copier les permissions
                shell_exec("sudo chmod 777 '{$destFile}' 2>&1");
                echo "Fichier copié: {$sourceFile} -> {$destFile}\n";
                $count++;
            } else {
                echo "ERREUR: Impossible de copier {$sourceFile}\n";
            }
        }
    }
    
    closedir($dir);
    return $count;
}

// Exécuter la synchronisation forcée
$sourcePath = storage_path('app/public');
$destPath = public_path('storage');

$totalCopied = forceSyncDirectory($sourcePath, $destPath);

echo "\nSynchronisation terminée. {$totalCopied} fichiers copiés.\n";
echo "Les images devraient maintenant s'afficher correctement sur le site.\n";

// Journaliser l'opération
use Illuminate\Support\Facades\Log;
Log::info("Synchronisation forcée storage: {$totalCopied} fichiers copiés.");
