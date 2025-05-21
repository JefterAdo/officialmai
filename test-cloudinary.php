<?php
// Script pour tester la connexion à Cloudinary
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

echo "=== TEST DE CONNEXION CLOUDINARY ===\n\n";

try {
    // Afficher la configuration actuelle
    echo "Configuration actuelle :\n";
    echo "CLOUDINARY_URL: " . env('CLOUDINARY_URL') . "\n";
    echo "CLOUDINARY_CLOUD_NAME: " . env('CLOUDINARY_CLOUD_NAME') . "\n";
    echo "CLOUDINARY_API_KEY: " . env('CLOUDINARY_KEY') . "\n";
    echo "CLOUDINARY_API_SECRET: " . (env('CLOUDINARY_SECRET') ? '******' : 'Non défini') . "\n\n";
    
    // Tester l'upload d'une image de test
    $testImage = __DIR__ . '/public/images/logo.png';
    
    if (!file_exists($testImage)) {
        echo "Image de test introuvable. Utilisation d'une image alternative...\n";
        // Chercher une image dans le dossier public
        $images = glob(__DIR__ . '/public/images/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        if (empty($images)) {
            $images = glob(__DIR__ . '/public/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        }
        
        if (empty($images)) {
            echo "❌ Aucune image trouvée pour le test.\n";
            exit(1);
        }
        
        $testImage = $images[0];
    }
    
    echo "Utilisation de l'image: " . $testImage . "\n";
    
    // Upload de l'image
    $result = Cloudinary::upload($testImage, [
        'folder' => 'tests',
        'public_id' => 'test-' . time(),
    ]);
    
    // Vérifier le résultat
    if ($result && $result->getSecurePath()) {
        echo "✅ Test réussi! Image uploadée avec succès.\n";
        echo "URL de l'image: " . $result->getSecurePath() . "\n";
        
        // Tester la transformation d'image
        echo "\nTest de transformation d'image:\n";
        $transformedUrl = Cloudinary::getImage($result->getPublicId())->resize('fill', 300, 200)->getRoundedCorners(20)->toUrl();
        echo "URL transformée: " . $transformedUrl . "\n";
        
        echo "\n✅ Cloudinary est correctement configuré et fonctionne!\n";
    } else {
        echo "❌ Échec du test. Résultat inattendu.\n";
        var_dump($result);
    }
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
