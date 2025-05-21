<?php
// Script pour corriger les chemins d'images des slides

// Connexion à la base de données
$db = new PDO('mysql:host=127.0.0.1;dbname=userrhdp', 'officiel', 'KSGyqoUnjFGmCPDMP0g7');

// Récupérer tous les slides
$slides = $db->query('SELECT id, title, image_path FROM slides')->fetchAll(PDO::FETCH_ASSOC);

// Dossier de stockage des images
$storageDir = '/home/zertos/htdocs/website/storage/app/public/slides/';

// Récupérer tous les fichiers dans le dossier
$files = scandir($storageDir);

echo "<h1>Correction des chemins d'images des slides</h1>";
echo "<pre>";

foreach ($slides as $slide) {
    echo "Slide ID: {$slide['id']} - Titre: {$slide['title']}\n";
    echo "  Chemin actuel: {$slide['image_path']}\n";
    
    // Extraire le nom de fichier du chemin
    $filename = basename(trim($slide['image_path']));
    echo "  Nom de fichier: {$filename}\n";
    
    // Vérifier si le fichier existe
    $fullPath = $storageDir . $filename;
    if (file_exists($fullPath)) {
        echo "  Le fichier existe: {$fullPath}\n";
        
        // Normaliser le chemin
        $normalizedPath = 'slides/' . $filename;
        
        // Mettre à jour la base de données si nécessaire
        if ($normalizedPath != $slide['image_path']) {
            $stmt = $db->prepare('UPDATE slides SET image_path = ? WHERE id = ?');
            $stmt->execute([$normalizedPath, $slide['id']]);
            echo "  Chemin corrigé: {$normalizedPath}\n";
        } else {
            echo "  Aucune correction nécessaire\n";
        }
    } else {
        echo "  Le fichier n'existe pas: {$fullPath}\n";
        
        // Recherche approximative
        $found = false;
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            
            // Comparer sans espaces ni caractères spéciaux
            $cleanFilename = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($filename));
            $cleanFile = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($file));
            
            if (strpos($cleanFile, $cleanFilename) !== false || strpos($cleanFilename, $cleanFile) !== false) {
                echo "  Fichier similaire trouvé: {$file}\n";
                
                // Normaliser le chemin
                $normalizedPath = 'slides/' . $file;
                
                // Mettre à jour la base de données
                $stmt = $db->prepare('UPDATE slides SET image_path = ? WHERE id = ?');
                $stmt->execute([$normalizedPath, $slide['id']]);
                echo "  Chemin corrigé: {$normalizedPath}\n";
                
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo "  AUCUN FICHIER SIMILAIRE TROUVÉ!\n";
        }
    }
    
    echo "\n";
}

echo "</pre>";
echo "<p><strong>Terminé!</strong> Retournez à la <a href='/'>page d'accueil</a> pour voir si les images s'affichent correctement maintenant.</p>";
?>
