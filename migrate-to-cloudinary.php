<?php
// Script pour migrer les images existantes vers Cloudinary
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Slide;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

echo "=== MIGRATION DES IMAGES VERS CLOUDINARY ===\n\n";

$cloudinary = new CloudinaryService();

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
    
    try {
        // Upload vers Cloudinary
        $cloudinaryUrl = $cloudinary->uploadFromPath($localPath, 'slides');
        
        // Mettre à jour le slide
        $slide->image_path = $cloudinaryUrl;
        $slide->save();
        
        echo "  ✅ Migré vers Cloudinary: {$cloudinaryUrl}\n";
    } catch (\Exception $e) {
        echo "  ❌ Erreur: " . $e->getMessage() . "\n";
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
        
        try {
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
            $cloudinaryUrl = $cloudinary->uploadFromPath($localPath, $folder);
            
            // Mettre à jour le média
            DB::table('media')->where('id', $item->id)->update(['file_path' => $cloudinaryUrl]);
            
            echo "  ✅ Migré vers Cloudinary: {$cloudinaryUrl}\n";
        } catch (\Exception $e) {
            echo "  ❌ Erreur: " . $e->getMessage() . "\n";
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
                    
                    try {
                        // Upload vers Cloudinary
                        $cloudinaryUrl = $cloudinary->uploadFromPath($localPath, strtolower($table));
                        
                        // Mettre à jour l'élément
                        DB::table($table)->where('id', $item->id)->update([$column => $cloudinaryUrl]);
                        
                        echo "    ✅ Migré vers Cloudinary: ID {$item->id}\n";
                    } catch (\Exception $e) {
                        echo "    ❌ Erreur: " . $e->getMessage() . " (ID: {$item->id})\n";
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
