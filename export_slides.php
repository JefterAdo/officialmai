<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

use App\Models\Slide;
use Illuminate\Support\Facades\File;

// Créer le dossier d'export s'il n'existe pas
$exportDir = __DIR__ . '/storage/app/exports/slides';
if (!File::exists($exportDir)) {
    File::makeDirectory($exportDir, 0755, true);
}

// Récupérer tous les slides
$slides = Slide::all();

// Préparer les données pour l'export
$exportData = [];
foreach ($slides as $slide) {
    $exportData[] = [
        'id' => $slide->id,
        'title' => $slide->title,
        'description' => $slide->description,
        'image_path' => $slide->image_path,
        'button_text' => $slide->button_text,
        'button_link' => $slide->button_link,
        'order' => $slide->order,
        'is_active' => $slide->is_active,
        'created_at' => $slide->created_at,
        'updated_at' => $slide->updated_at
    ];

    // Copier l'image si elle existe
    if (File::exists(public_path($slide->image_path))) {
        $fileName = basename($slide->image_path);
        $targetPath = $exportDir . '/images/' . $fileName;
        
        if (!File::exists($exportDir . '/images')) {
            File::makeDirectory($exportDir . '/images', 0755, true);
        }
        
        File::copy(public_path($slide->image_path), $targetPath);
    }
}

// Sauvegarder les données en JSON
File::put($exportDir . '/slides.json', json_encode($exportData, JSON_PRETTY_PRINT));

// Copier le code du slider depuis welcome.blade.php
if (File::exists(__DIR__ . '/resources/views/welcome.blade.php')) {
    File::copy(
        __DIR__ . '/resources/views/welcome.blade.php',
        $exportDir . '/slider_code.blade.php'
    );
}

echo "Export terminé !\n";
echo "Les données ont été exportées dans : " . $exportDir . "\n"; 