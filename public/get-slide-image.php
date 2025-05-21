<?php
// Ce script sert directement les images du slider en utilisant l'environnement Laravel
// Usage: get-slide-image.php?id=1

// Charger l'environnement Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

// Récupérer l'ID du slide
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('HTTP/1.0 400 Bad Request');
    exit('ID de slide invalide');
}

try {
    // Récupérer le slide depuis la base de données
    $slide = DB::table('slides')->where('id', $id)->first();

    if (!$slide) {
        header('HTTP/1.0 404 Not Found');
        exit('Slide non trouvé');
    }

    // Construire le chemin complet du fichier
    $imagePath = storage_path('app/public/' . trim($slide->image_path));

    // Si le fichier n'existe pas, essayons de trouver un fichier similaire
    if (!file_exists($imagePath)) {
        $dir = storage_path('app/public/slides/');
        $files = scandir($dir);
        $filename = basename(trim($slide->image_path));
        $found = false;
        
        // Recherche approximative
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                // Essayer différentes méthodes de correspondance
                if (
                    $file === $filename || 
                    stripos($file, str_replace(' ', '', $filename)) !== false ||
                    stripos($file, 'slide_' . $id) !== false
                ) {
                    $imagePath = $dir . $file;
                    $found = true;
                    
                    // Mettre à jour le chemin dans la base de données pour les futures requêtes
                    $newPath = 'slides/' . $file;
                    DB::table('slides')->where('id', $id)->update(['image_path' => $newPath]);
                    Log::info('Chemin d\'image mis à jour pour le slide ' . $id . ': ' . $newPath);
                    break;
                }
            }
        }
        
        if (!$found) {
            // Si aucun fichier spécifique n'est trouvé, utiliser un des fichiers slide_X.jpg disponibles
            foreach ($files as $file) {
                if (preg_match('/^slide_\\d+\\.(jpg|png|jpeg|gif)$/i', $file)) {
                    $imagePath = $dir . $file;
                    $newPath = 'slides/' . $file;
                    DB::table('slides')->where('id', $id)->update(['image_path' => $newPath]);
                    Log::info('Chemin d\'image de secours utilisé pour le slide ' . $id . ': ' . $newPath);
                    $found = true;
                    break;
                }
            }
        }
        
        if (!$found) {
            header('HTTP/1.0 404 Not Found');
            exit('Image non trouvée pour le slide ID: ' . $id);
        }
    }

    // Déterminer le type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $imagePath);
    finfo_close($finfo);

    // Envoyer les en-têtes appropriés
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($imagePath));
    header('Cache-Control: public, max-age=3600'); // Réduire le cache à 1 heure pour faciliter les mises à jour

    // Lire et envoyer le fichier
    readfile($imagePath);
    
} catch (Exception $e) {
    // Journaliser l'erreur
    Log::error('Erreur dans get-slide-image.php: ' . $e->getMessage());
    
    header('HTTP/1.0 500 Internal Server Error');
    exit('Erreur lors du traitement de l\'image: ' . $e->getMessage());
}

exit;
?>
