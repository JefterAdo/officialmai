<?php
// Script pour tester la connexion à Cloudinary avec le SDK direct
require __DIR__ . '/vendor/autoload.php';

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

echo "=== TEST DE CONNEXION CLOUDINARY (SDK DIRECT) ===\n\n";

try {
    // Configuration Cloudinary
    $cloudName = 'dsc3ru80e';
    $apiKey = '444678797461641';
    $apiSecret = 'Fz9wlSyx36vdDi_41H2QaJ6Zwzw';
    
    echo "Configuration utilisée :\n";
    echo "CLOUD_NAME: {$cloudName}\n";
    echo "API_KEY: {$apiKey}\n";
    echo "API_SECRET: ******\n\n";
    
    // Initialiser Cloudinary
    $config = new Configuration([
        'cloud' => [
            'cloud_name' => $cloudName,
            'api_key' => $apiKey,
            'api_secret' => $apiSecret,
        ],
    ]);
    
    $cloudinary = new Cloudinary($config);
    
    // Tester l'upload d'une image de test
    $testImage = __DIR__ . '/public/images/logo.png';
    
    if (!file_exists($testImage)) {
        echo "Image de test introuvable. Recherche d'une image alternative...\n";
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
    $result = $cloudinary->uploadApi()->upload($testImage, [
        'folder' => 'tests',
        'public_id' => 'test-' . time(),
    ]);
    
    // Vérifier le résultat
    if ($result && isset($result['secure_url'])) {
        echo "✅ Test réussi! Image uploadée avec succès.\n";
        echo "URL de l'image: " . $result['secure_url'] . "\n";
        echo "Public ID: " . $result['public_id'] . "\n";
        
        // Tester la transformation d'image
        echo "\nTest de transformation d'image:\n";
        $transformedUrl = $cloudinary->image($result['public_id'])
            ->resize('fill', 300, 200)
            ->roundCorners(20)
            ->toUrl();
        
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
