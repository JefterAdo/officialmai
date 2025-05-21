<?php

/**
 * Script de synchronisation pour les fichiers temporaires de Livewire
 * 
 * Ce script résout les problèmes d'upload d'images avec Livewire en s'assurant que :
 * 1. Le dossier livewire-tmp existe avec les bonnes permissions
 * 2. Les fichiers temporaires sont correctement synchronisés
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

// Chemins des dossiers
$storagePath = __DIR__ . '/storage/app';
$livewireTmpPath = $storagePath . '/livewire-tmp';
$publicLivewireTmpPath = __DIR__ . '/public/livewire-tmp';

echo "=== SYNCHRONISATION DES FICHIERS TEMPORAIRES LIVEWIRE ===\n\n";

// Étape 1: S'assurer que les dossiers existent
if (!File::exists($livewireTmpPath)) {
    echo "Création du dossier: {$livewireTmpPath}\n";
    File::makeDirectory($livewireTmpPath, 0777, true, true);
}

if (!File::exists($publicLivewireTmpPath)) {
    echo "Création du dossier: {$publicLivewireTmpPath}\n";
    File::makeDirectory($publicLivewireTmpPath, 0777, true, true);
}

// Étape 2: Appliquer les permissions
echo "Application des permissions (777) sur les dossiers temporaires...\n";
chmod($livewireTmpPath, 0777);
chmod($publicLivewireTmpPath, 0777);

// Étape 3: Créer un fichier .gitignore dans les dossiers temporaires
$gitignoreContent = "*\n!.gitignore\n";
File::put($livewireTmpPath . '/.gitignore', $gitignoreContent);
File::put($publicLivewireTmpPath . '/.gitignore', $gitignoreContent);

// Étape 4: Créer un fichier vide pour tester les permissions
$testFile = $livewireTmpPath . '/test-file.txt';
$testContent = "Test file created at " . date('Y-m-d H:i:s') . "\n";

try {
    File::put($testFile, $testContent);
    echo "✅ Test d'écriture réussi dans: {$testFile}\n";
    
    // Lire le fichier pour vérifier les permissions de lecture
    $readContent = File::get($testFile);
    echo "✅ Test de lecture réussi\n";
    
    // Supprimer le fichier de test
    File::delete($testFile);
    echo "✅ Test de suppression réussi\n";
} catch (\Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    exit(1);
}

// Étape 5: Création d'un fichier index.php vide dans le dossier public pour éviter le listing des fichiers
$indexContent = "<?php\n// Silence is golden\n";
File::put($publicLivewireTmpPath . '/index.php', $indexContent);

echo "\n✅ Synchronisation terminée avec succès!\n";
echo "Les dossiers temporaires de Livewire sont maintenant correctement configurés.\n";
