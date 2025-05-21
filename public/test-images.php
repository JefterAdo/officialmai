<?php
// Connexion à la base de données
$db = new PDO('mysql:host=127.0.0.1;dbname=userrhdp', 'officiel', 'KSGyqoUnjFGmCPDMP0g7');
$slides = $db->query('SELECT id, title, image_path FROM slides')->fetchAll(PDO::FETCH_ASSOC);

echo '<h1>Test d\'affichage des images</h1>';

foreach ($slides as $slide) {
    echo '<div style="margin-bottom: 20px;">';
    echo '<h2>' . htmlspecialchars($slide['title']) . '</h2>';
    echo '<p>Chemin dans la base de données: ' . htmlspecialchars($slide['image_path']) . '</p>';
    
    // Test avec différentes méthodes d'affichage
    echo '<h3>Méthode 1: Chemin direct</h3>';
    echo '<img src="/storage/' . htmlspecialchars($slide['image_path']) . '" style="max-width: 300px; border: 1px solid red;" />';
    
    echo '<h3>Méthode 2: URL encodée</h3>';
    echo '<img src="/storage/' . htmlspecialchars(urlencode($slide['image_path'])) . '" style="max-width: 300px; border: 1px solid blue;" />';
    
    echo '<h3>Méthode 3: Chemin modifié</h3>';
    $path = str_replace('slides/', 'slides/', $slide['image_path']);
    echo '<img src="/storage/' . htmlspecialchars($path) . '" style="max-width: 300px; border: 1px solid green;" />';
    
    echo '</div>';
    echo '<hr>';
}
?>
