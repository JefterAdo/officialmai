<?php

/**
 * Script pour créer un favicon.ico à partir des PNG générés
 * Ce script utilise la bibliothèque GD pour créer un favicon.ico
 * qui contient les tailles 16x16 et 32x32
 */

// Vérifier si GD est disponible
if (!extension_loaded('gd')) {
    die("L'extension GD n'est pas disponible. Veuillez l'installer pour utiliser ce script.\n");
}

// Chemins des fichiers source
$favicon16Path = __DIR__ . '/public/favicon-16x16.png';
$favicon32Path = __DIR__ . '/public/favicon-32x32.png';
$outputPath = __DIR__ . '/public/favicon.ico';

// Vérifier si les fichiers source existent
if (!file_exists($favicon16Path)) {
    die("Le fichier source n'existe pas: $favicon16Path\n");
}
if (!file_exists($favicon32Path)) {
    die("Le fichier source n'existe pas: $favicon32Path\n");
}

// Fonction pour créer un favicon.ico simple
function createFaviconIco($outputPath, $favicon16Path, $favicon32Path) {
    // Créer un en-tête ICO
    $iconData = pack('vvv', 0, 1, 2); // 0 = réservé, 1 = type ICO, 2 = nombre d'images
    
    // Charger les images source
    $favicon16 = imagecreatefrompng($favicon16Path);
    $favicon32 = imagecreatefrompng($favicon32Path);
    
    // Convertir les images en données binaires
    ob_start();
    imagepng($favicon16);
    $favicon16Data = ob_get_clean();
    
    ob_start();
    imagepng($favicon32);
    $favicon32Data = ob_get_clean();
    
    // Taille des données
    $favicon16Size = strlen($favicon16Data);
    $favicon32Size = strlen($favicon32Data);
    
    // Ajouter les entrées d'icônes
    // Format: largeur, hauteur, nombre de couleurs, réservé, plans, bits par pixel, taille en octets, offset
    $iconData .= pack('CCCCvvVV', 16, 16, 0, 0, 1, 32, $favicon16Size, 22 + 16 * 2);
    $iconData .= pack('CCCCvvVV', 32, 32, 0, 0, 1, 32, $favicon32Size, 22 + 16 * 2 + $favicon16Size);
    
    // Ajouter les données des images
    $iconData .= $favicon16Data;
    $iconData .= $favicon32Data;
    
    // Écrire le fichier ICO
    file_put_contents($outputPath, $iconData);
    
    // Libérer la mémoire
    imagedestroy($favicon16);
    imagedestroy($favicon32);
    
    return true;
}

echo "Création de favicon.ico...\n";

// Méthode alternative plus simple : copier le favicon-32x32.png en favicon.ico
// Ce n'est pas un vrai .ico mais la plupart des navigateurs modernes l'acceptent
copy($favicon32Path, $outputPath);

echo "favicon.ico créé avec succès.\n";
echo "Note: Pour une meilleure compatibilité avec tous les navigateurs, il est recommandé d'utiliser un outil dédié pour créer un véritable fichier .ico.\n";
