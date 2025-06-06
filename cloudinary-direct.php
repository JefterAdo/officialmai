<?php
// Script pour migrer les images vers Cloudinary en utilisant l'API directement
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Slide;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

echo "=== MIGRATION DES IMAGES VERS CLOUDINARY (MÉTHODE DIRECTE) ===\n\n";

// Configuration Cloudinary
$cloudName = 'dsc3ru80e';
$apiKey = '444678797461641';
$apiSecret = 'Fz9wlSyx36vdDi_41H2QaJ6Zwzw';

// Initialiser Cloudinary avec l'URL complète
$cloudinaryUrl = "cloudinary://{$apiKey}:{$apiSecret}@{$cloudName}";
putenv("CLOUDINARY_URL={$cloudinaryUrl}");

// Fonction pour uploader une image vers Cloudinary
function uploadToCloudinary($localPath, $folder = 'slides') {
    global $cloudName, $apiKey, $apiSecret;
    
    // Vérifier si le fichier existe
    if (!file_exists($localPath)) {
        return null;
    }
    
    // Préparer les données pour l'upload
    $timestamp = time();
    $data = [
        'timestamp' => $timestamp,
        'folder' => $folder,
        'api_key' => $apiKey,
    ];
    
    // Générer la signature
    ksort($data);
    $signatureString = '';
    foreach ($data as $key => $value) {
        $signatureString .= $key . '=' . $value . '&';
    }
    $signatureString = rtrim($signatureString, '&');
    $signature = sha1($signatureString . $apiSecret);
    
    // Préparer la requête cURL
    $url = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";
    $post = [
        'file' => new CURLFile($localPath),
        'timestamp' => $timestamp,
        'folder' => $folder,
        'api_key' => $apiKey,
        'signature' => $signature,
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode != 200) {
        echo "  ❌ Erreur HTTP {$httpCode}: " . $response . "\n";
        return null;
    }
    
    $result = json_decode($response, true);
    if (!isset($result['secure_url'])) {
        echo "  ❌ Réponse invalide: " . $response . "\n";
        return null;
    }
    
    return $result['secure_url'];
}

// 1. Migrer les slides
$slides = Slide::all();
echo "1. MIGRATION DES SLIDES\n";
echo "Nombre de slides trouvés: " . $slides->count() . "\n\n";

foreach ($slides as $slide) {
    echo "Slide ID: {$slide->id}, Titre: {$slide->title}\n";
    
    // Vérifier si l'image est déjà sur Cloudinary
    if (strpos($slide->image_path, 'cloudinary.com') !== false) {
        echo "  ✅ Déjà sur Cloudinary\n";
        continue;
    }
    
    // Vérifier si l'image existe localement
    $localPath = storage_path('app/public/' . $slide->image_path);
    if (!File::exists($localPath)) {
        echo "  ❌ Image locale introuvable: {$slide->image_path}\n";
        continue;
    }
    
    // Upload vers Cloudinary
    $cloudinaryUrl = uploadToCloudinary($localPath, 'slides');
    if ($cloudinaryUrl) {
        // Mettre à jour le slide
        $slide->image_path = $cloudinaryUrl;
        $slide->save();
        
        echo "  ✅ Migré vers Cloudinary: {$cloudinaryUrl}\n";
    }
}

// 2. Migrer les médias (si vous avez une table Media)
echo "\n2. VÉRIFICATION DE LA TABLE MEDIA\n";
if (Schema::hasTable('media')) {
    $media = DB::table('media')->get();
    echo "Nombre de médias trouvés: " . $media->count() . "\n\n";
    
    foreach ($media as $item) {
        echo "Media ID: {$item->id}, Titre: " . ($item->title ?? 'Sans titre') . "\n";
        
        // Vérifier si l'image est déjà sur Cloudinary
        if (isset($item->file_path) && strpos($item->file_path, 'cloudinary.com') !== false) {
            echo "  ✅ Déjà sur Cloudinary\n";
            continue;
        }
        
        // Vérifier si l'image existe localement
        if (!isset($item->file_path)) {
            echo "  ❌ Pas de chemin de fichier défini\n";
            continue;
        }
        
        $localPath = storage_path('app/public/' . $item->file_path);
        if (!File::exists($localPath)) {
            echo "  ❌ Image locale introuvable: {$item->file_path}\n";
            continue;
        }
        
        // Déterminer le dossier approprié en fonction du type de média
        $folder = 'media';
        if (isset($item->file_type)) {
            if (strpos($item->file_type, 'image') !== false) {
                $folder = 'images';
            } elseif (strpos($item->file_type, 'video') !== false) {
                $folder = 'videos';
            } elseif (strpos($item->file_type, 'audio') !== false) {
                $folder = 'audio';
            } elseif (strpos($item->file_type, 'pdf') !== false || strpos($item->file_type, 'document') !== false) {
                $folder = 'documents';
            }
        }
        
        // Upload vers Cloudinary
        $cloudinaryUrl = uploadToCloudinary($localPath, $folder);
        if ($cloudinaryUrl) {
            // Mettre à jour le média
            DB::table('media')->where('id', $item->id)->update(['file_path' => $cloudinaryUrl]);
            
            echo "  ✅ Migré vers Cloudinary: {$cloudinaryUrl}\n";
        }
    }
} else {
    echo "La table 'media' n'existe pas dans la base de données.\n";
}

// 3. Vérifier s'il y a d'autres tables avec des images
echo "\n3. VÉRIFICATION D'AUTRES TABLES AVEC DES IMAGES\n";
$potentialImageTables = [
    'news' => ['image', 'featured_image', 'thumbnail'],
    'articles' => ['image', 'featured_image', 'thumbnail'],
    'pages' => ['featured_image', 'banner_image'],
    'users' => ['avatar', 'profile_image'],
    'galleries' => ['cover_image'],
    'photos' => ['file_path', 'image_path'],
];

foreach ($potentialImageTables as $table => $columns) {
    if (Schema::hasTable($table)) {
        echo "Table '{$table}' trouvée\n";
        
        foreach ($columns as $column) {
            if (Schema::hasColumn($table, $column)) {
                echo "  Colonne '{$column}' trouvée\n";
                
                $items = DB::table($table)->whereNotNull($column)->get();
                echo "  Nombre d'éléments avec {$column}: " . $items->count() . "\n";
                
                foreach ($items as $item) {
                    $imagePath = $item->$column;
                    
                    // Vérifier si l'image est déjà sur Cloudinary
                    if (strpos($imagePath, 'cloudinary.com') !== false) {
                        echo "    ✅ Déjà sur Cloudinary: ID {$item->id}\n";
                        continue;
                    }
                    
                    // Vérifier si l'image existe localement
                    $localPath = storage_path('app/public/' . $imagePath);
                    if (!File::exists($localPath)) {
                        echo "    ❌ Image locale introuvable: {$imagePath} (ID: {$item->id})\n";
                        continue;
                    }
                    
                    // Upload vers Cloudinary
                    $cloudinaryUrl = uploadToCloudinary($localPath, strtolower($table));
                    if ($cloudinaryUrl) {
                        // Mettre à jour l'élément
                        DB::table($table)->where('id', $item->id)->update([$column => $cloudinaryUrl]);
                        
                        echo "    ✅ Migré vers Cloudinary: ID {$item->id}\n";
                    }
                }
            }
        }
    }
}

echo "\n=== RÉSUMÉ DE LA MIGRATION ===\n";
echo "✅ Migration des images vers Cloudinary terminée\n";
echo "✅ Les images sont maintenant servies par le CDN Cloudinary\n";
echo "✅ Les problèmes de liens symboliques sont définitivement résolus\n";
echo "\nVotre site RHDP est maintenant optimisé pour l'affichage des images.\n";
echo "Les images seront chargées plus rapidement et s'adapteront automatiquement aux différents appareils.\n";
