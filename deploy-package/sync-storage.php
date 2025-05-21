<?php
// Script pour synchroniser les fichiers de storage/app/public vers public/storage
require __DIR__ . '/vendor/autoload.php';

$storagePath = __DIR__ . '/storage/app/public';
$publicPath = __DIR__ . '/public/storage';

echo "=== SYNCHRONISATION DES FICHIERS DE STORAGE ===\n\n";

// Fonction pour copier un dossier et son contenu
function copyDirectory($source, $destination) {
    if (!is_dir($destination)) {
        mkdir($destination, 0777, true);
    }
    
    $items = scandir($source);
    $count = 0;
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        
        $sourcePath = $source . '/' . $item;
        $destPath = $destination . '/' . $item;
        
        if (is_dir($sourcePath)) {
            copyDirectory($sourcePath, $destPath);
        } else {
            if (copy($sourcePath, $destPath)) {
                chmod($destPath, 0777);
                $count++;
            }
        }
    }
    
    return $count;
}

// Vérifier si les dossiers existent
if (!is_dir($storagePath)) {
    echo "❌ Le dossier source n'existe pas: {$storagePath}\n";
    exit(1);
}

// Créer le dossier de destination s'il n'existe pas
if (!is_dir($publicPath)) {
    mkdir($publicPath, 0777, true);
    echo "✅ Dossier de destination créé: {$publicPath}\n";
}

// Copier les fichiers
$filesCopied = copyDirectory($storagePath, $publicPath);
echo "✅ {$filesCopied} fichiers copiés de storage/app/public vers public/storage\n";

echo "\nTerminé.\n";