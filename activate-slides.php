<?php

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ACTIVATION DES SLIDES ===\n\n";

// Définir les slides à activer avec leurs chemins d'images
$slidesToActivate = [
    1 => 'slides/slide_1.jpg',
    2 => 'slides/slide_3.png',
    3 => 'slides/slide_4.jpg',
    // Le slide 5 est déjà actif avec slide_2.jpg
];

// Ordre de départ pour les nouveaux slides
$order = 1; // Le slide 5 est déjà à l'ordre 0

foreach ($slidesToActivate as $id => $imagePath) {
    // Vérifier si le slide existe
    $slide = DB::table('slides')->where('id', $id)->first();
    
    if ($slide) {
        // Mettre à jour le slide existant
        DB::table('slides')->where('id', $id)->update([
            'image_path' => $imagePath,
            'is_active' => true,
            'order' => $order
        ]);
        echo "Slide ID {$id} activé et mis à jour avec l'image {$imagePath} (ordre: {$order})\n";
    } else {
        // Créer un nouveau slide si l'ID n'existe pas
        $slideData = [
            'title' => "Slide {$id}",
            'description' => "Description du slide {$id}",
            'image_path' => $imagePath,
            'is_active' => true,
            'order' => $order,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        $newId = DB::table('slides')->insertGetId($slideData);
        echo "Nouveau slide créé avec ID {$newId}, image {$imagePath} (ordre: {$order})\n";
    }
    
    $order++;
}

echo "\n=== VÉRIFICATION DES SLIDES ACTIFS ===\n\n";

$activeSlides = DB::table('slides')->where('is_active', true)->orderBy('order')->get();

foreach ($activeSlides as $slide) {
    echo "ID: {$slide->id}, Titre: {$slide->title}, Image: {$slide->image_path}, Ordre: {$slide->order}\n";
    
    // Vérifier si le fichier existe
    $fullPath = storage_path('app/public/' . $slide->image_path);
    echo "  Le fichier existe: " . (file_exists($fullPath) ? "OUI" : "NON") . "\n";
}

echo "\n=== TERMINÉ ===\n";
