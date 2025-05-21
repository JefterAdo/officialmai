<?php

/**
 * Script de réparation pour les fichiers temporaires de Livewire
 * 
 * Ce script résout les problèmes d'upload d'images avec Livewire en s'assurant que :
 * 1. Le dossier livewire-tmp existe avec les bonnes permissions
 * 2. Les fichiers temporaires sont correctement configurés
 */

echo "=== RÉPARATION DES FICHIERS TEMPORAIRES LIVEWIRE ===\n\n";

// Chemins des dossiers
$storagePath = __DIR__ . '/storage/app';
$livewireTmpPath = $storagePath . '/livewire-tmp';
$publicLivewireTmpPath = __DIR__ . '/public/livewire-tmp';

// Étape 1: S'assurer que les dossiers existent
if (!file_exists($livewireTmpPath)) {
    echo "Création du dossier: {$livewireTmpPath}\n";
    mkdir($livewireTmpPath, 0777, true);
}

if (!file_exists($publicLivewireTmpPath)) {
    echo "Création du dossier: {$publicLivewireTmpPath}\n";
    mkdir($publicLivewireTmpPath, 0777, true);
}

// Étape 2: Appliquer les permissions
echo "Application des permissions (777) sur les dossiers temporaires...\n";
chmod($livewireTmpPath, 0777);
chmod($publicLivewireTmpPath, 0777);

// Étape 3: Créer un fichier .gitignore dans les dossiers temporaires
$gitignoreContent = "*\n!.gitignore\n";
file_put_contents($livewireTmpPath . '/.gitignore', $gitignoreContent);
file_put_contents($publicLivewireTmpPath . '/.gitignore', $gitignoreContent);

// Étape 4: Créer un fichier vide pour tester les permissions
$testFile = $livewireTmpPath . '/test-file.txt';
$testContent = "Test file created at " . date('Y-m-d H:i:s') . "\n";

try {
    file_put_contents($testFile, $testContent);
    echo "✅ Test d'écriture réussi dans: {$testFile}\n";
    
    // Lire le fichier pour vérifier les permissions de lecture
    $readContent = file_get_contents($testFile);
    echo "✅ Test de lecture réussi\n";
    
    // Supprimer le fichier de test
    unlink($testFile);
    echo "✅ Test de suppression réussi\n";
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    exit(1);
}

// Étape 5: Création d'un fichier index.php vide dans le dossier public pour éviter le listing des fichiers
$indexContent = "<?php\n// Silence is golden\n";
file_put_contents($publicLivewireTmpPath . '/index.php', $indexContent);

// Étape 6: Créer un fichier livewire-tmp vide dans le dossier livewire-tmp pour éviter l'erreur
$livewireTmpFile = $livewireTmpPath . '/livewire-tmp';
file_put_contents($livewireTmpFile, '');
chmod($livewireTmpFile, 0777);
echo "✅ Création du fichier livewire-tmp réussie\n";

echo "\n✅ Réparation terminée avec succès!\n";
echo "Les dossiers temporaires de Livewire sont maintenant correctement configurés.\n";
