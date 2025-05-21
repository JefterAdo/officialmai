<?php

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$basePath = dirname(__DIR__);

echo "<h1>Diagnostic de l'administration Filament</h1>";

// Vérifier les informations de base
echo "<h2>Informations de base</h2>";
echo "<p>Chemin de base: " . $basePath . "</p>";
echo "<p>PHP version: " . phpversion() . "</p>";

// Vérifier les répertoires essentiels
$directories = [
    'app/Filament',
    'app/Filament/Resources',
    'app/Filament/Pages',
    'app/Providers/Filament',
    'resources/views/filament',
    'public/vendor/filament',
    'public/vendor/livewire'
];

echo "<h2>Vérification des répertoires</h2>";
echo "<ul>";
foreach ($directories as $dir) {
    $path = $basePath . '/' . $dir;
    $exists = is_dir($path);
    echo "<li>" . $dir . ": " . ($exists ? "Existe" : "Manquant") . "</li>";
}
echo "</ul>";

// Vérifier les fichiers de configuration essentiels
$files = [
    'config/filament.php',
    'app/Providers/Filament/AdminPanelProvider.php',
    'resources/views/filament/pages/auth/login.blade.php',
    'public/index.php'
];

echo "<h2>Vérification des fichiers</h2>";
echo "<ul>";
foreach ($files as $file) {
    $path = $basePath . '/' . $file;
    $exists = file_exists($path);
    echo "<li>" . $file . ": " . ($exists ? "Existe" : "Manquant") . "</li>";
}
echo "</ul>";

// Vérifier les routes
echo "<h2>Vérification des routes Filament</h2>";
try {
    include $basePath . '/vendor/autoload.php';
    
    $app = require_once $basePath . '/bootstrap/app.php';
    
    echo "<p>Application Laravel chargée avec succès</p>";
    
    echo "<h3>Liste des routes enregistrées pour 'admin'</h3>";
    echo "<pre>";
    $routes = $app->make('router')->getRoutes();
    foreach ($routes as $route) {
        if (strpos($route->uri(), 'admin') !== false) {
            echo $route->methods()[0] . ' ' . $route->uri() . " → " . $route->getActionName() . "\n";
        }
    }
    echo "</pre>";
} catch (\Throwable $e) {
    echo "<p style='color: red'>Erreur lors du chargement des routes: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

// Vérifier la connexion à la base de données
echo "<h2>Test de connexion à la base de données</h2>";
try {
    $dbConfig = [
        'host' => '127.0.0.1',
        'database' => 'database',
        'username' => 'data',
        'password' => 'IJwsQVA6ZCHMvOPxLIhH'
    ];
    
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']}",
        $dbConfig['username'],
        $dbConfig['password']
    );
    
    echo "<p style='color: green'>Connexion à la base de données réussie!</p>";
    
    // Vérifier la table users
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    $usersTableExists = $stmt->rowCount() > 0;
    echo "<p>Table 'users': " . ($usersTableExists ? "Existe" : "Manquante") . "</p>";
    
    if ($usersTableExists) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>Nombre d'utilisateurs: " . $result['count'] . "</p>";
    }
} catch (\PDOException $e) {
    echo "<p style='color: red'>Erreur de connexion à la base de données: " . $e->getMessage() . "</p>";
}
