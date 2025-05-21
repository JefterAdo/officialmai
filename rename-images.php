<?php
// Script pour renommer les fichiers d'images avec des noms simples

$slidesDir = __DIR__ . '/storage/app/public/slides/';
$files = scandir($slidesDir);

echo "Renommage des fichiers d'images...\n";

$newFiles = [];
$counter = 1;

foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }
    
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $newName = 'slide_' . $counter . '.' . $extension;
    
    echo "Renommage de '{$file}' en '{$newName}'...\n";
    
    if (copy($slidesDir . $file, $slidesDir . $newName)) {
        echo "  Succès!\n";
        $newFiles[$file] = $newName;
        $counter++;
    } else {
        echo "  Échec!\n";
    }
}

// Mettre à jour la base de données
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "\nMise à jour de la base de données...\n";

// Récupérer tous les slides
$slides = DB::table('slides')->get();

foreach ($slides as $slide) {
    $oldPath = $slide->image_path;
    $oldFilename = basename($oldPath);
    
    if (isset($newFiles[$oldFilename])) {
        $newPath = 'slides/' . $newFiles[$oldFilename];
        
        echo "Mise à jour du slide ID {$slide->id}: '{$oldPath}' -> '{$newPath}'\n";
        
        DB::table('slides')->where('id', $slide->id)->update(['image_path' => $newPath]);
    }
}

echo "\nTerminé!\n";
?>
