<?php

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Mettre à jour le slide avec l'ID 5
$updated = DB::table('slides')->where('id', 5)->update(['image_path' => 'slides/slide_2.jpg']);

if ($updated) {
    echo "Slide mis à jour avec succès!\n";
} else {
    echo "Aucune mise à jour effectuée. Vérifiez que le slide avec ID 5 existe.\n";
}
