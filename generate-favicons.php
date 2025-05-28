<?php

/**
 * Script pour générer des favicons à partir du logo RHDP
 * 
 * Ce script utilise la bibliothèque GD de PHP pour créer différentes tailles de favicon
 * à partir du logo RHDP existant.
 */

// Vérifier si GD est disponible
if (!extension_loaded('gd')) {
    die("L'extension GD n'est pas disponible. Veuillez l'installer pour utiliser ce script.\n");
}

// Chemin vers le logo source
$sourcePath = __DIR__ . '/public/images/rhdp_logo.png';

// Vérifier si le fichier source existe
if (!file_exists($sourcePath)) {
    die("Le fichier source n'existe pas: $sourcePath\n");
}

// Charger l'image source
$sourceImage = imagecreatefrompng($sourcePath);
if (!$sourceImage) {
    die("Impossible de charger l'image source.\n");
}

// Obtenir les dimensions de l'image source
$sourceWidth = imagesx($sourceImage);
$sourceHeight = imagesy($sourceImage);

// Définir les tailles de favicon à générer
$sizes = [
    'favicon-16x16.png' => 16,
    'favicon-32x32.png' => 32,
    'apple-touch-icon.png' => 180,
    'android-chrome-192x192.png' => 192,
    'android-chrome-512x512.png' => 512,
    'mstile-150x150.png' => 150
];

// Créer un répertoire temporaire pour les favicons
$outputDir = __DIR__ . '/public';

// Générer les favicons pour chaque taille
foreach ($sizes as $filename => $size) {
    echo "Génération de $filename...\n";
    
    // Créer une nouvelle image carrée avec fond transparent
    $faviconImage = imagecreatetruecolor($size, $size);
    
    // Activer la transparence
    imagealphablending($faviconImage, false);
    imagesavealpha($faviconImage, true);
    $transparent = imagecolorallocatealpha($faviconImage, 0, 0, 0, 127);
    imagefilledrectangle($faviconImage, 0, 0, $size, $size, $transparent);
    
    // Calculer les dimensions pour conserver les proportions
    $ratio = $sourceWidth / $sourceHeight;
    
    // Nous voulons que le logo occupe environ 80% de l'espace du favicon
    $targetWidth = $size * 0.8;
    $targetHeight = $targetWidth / $ratio;
    
    // Si la hauteur résultante est supérieure à 80% de la taille du favicon,
    // ajuster en fonction de la hauteur à la place
    if ($targetHeight > $size * 0.8) {
        $targetHeight = $size * 0.8;
        $targetWidth = $targetHeight * $ratio;
    }
    
    // Calculer la position pour centrer le logo
    $x = ($size - $targetWidth) / 2;
    $y = ($size - $targetHeight) / 2;
    
    // Redimensionner et copier l'image source dans le favicon
    imagecopyresampled(
        $faviconImage, $sourceImage,
        $x, $y, 0, 0,
        $targetWidth, $targetHeight, $sourceWidth, $sourceHeight
    );
    
    // Enregistrer le favicon
    $outputPath = "$outputDir/$filename";
    imagepng($faviconImage, $outputPath);
    
    // Libérer la mémoire
    imagedestroy($faviconImage);
    
    echo "Favicon $filename généré avec succès.\n";
}

// Générer le favicon.ico (combinaison de 16x16, 32x32 et 48x48)
echo "Génération de favicon.ico...\n";

// Libérer la mémoire
imagedestroy($sourceImage);

echo "Tous les favicons ont été générés avec succès.\n";
echo "N'oubliez pas de créer manuellement favicon.ico à partir de favicon-16x16.png et favicon-32x32.png.\n";
