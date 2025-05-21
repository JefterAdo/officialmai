<?php
// Script d'audit : vérifie l'existence des images en base et sur le disque
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = [
    'slides' => 'image_path',
    'news'   => 'featured_image', // Champ correct pour les articles
    // Ajouter d'autres tables/clés si nécessaire
];

foreach ($tables as $table => $column) {
    echo "=== Table: $table (colonne: $column) ===\n";
    $records = DB::table($table)->get();
    foreach ($records as $rec) {
        $id = $rec->id ?? '(n/a)';
        $path = trim($rec->$column);
        $fullPath = storage_path('app/public/' . $path);
        $exists = file_exists($fullPath) ? 'OUI' : 'NON';
        echo "ID: $id, Path: $path, FullPath: $fullPath, Exists: $exists\n";
    }
    echo "\n";
}

exit;
