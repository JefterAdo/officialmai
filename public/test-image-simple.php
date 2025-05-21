<!DOCTYPE html>
<html>
<head>
    <title>Test Image Simple</title>
</head>
<body>
    <h1>Test d'image simple</h1>
    
    <h2>Image avec chemin direct</h2>
    <img src="/storage/slides/test_slide_1745367884.jpg" style="max-width: 300px; border: 2px solid red;">
    
    <h2>Image avec URL encodée</h2>
    <img src="/storage/slides/<?php echo urlencode('test_slide_1745367884.jpg'); ?>" style="max-width: 300px; border: 2px solid blue;">
    
    <h2>Image avec chemin complet</h2>
    <img src="<?php echo 'https://www.zertos.online/storage/slides/test_slide_1745367884.jpg'; ?>" style="max-width: 300px; border: 2px solid green;">
    
    <h2>Vérification du lien symbolique</h2>
    <p>
        <?php
        if (is_link('/home/zertos/htdocs/website/public/storage')) {
            echo 'Le lien symbolique existe et pointe vers: ' . readlink('/home/zertos/htdocs/website/public/storage');
        } else {
            echo 'Le lien symbolique n\'existe pas!';
        }
        ?>
    </p>
    
    <h2>Vérification des fichiers</h2>
    <p>
        <?php
        $file = '/home/zertos/htdocs/website/storage/app/public/slides/test_slide_1745367884.jpg';
        if (file_exists($file)) {
            echo 'Le fichier existe dans storage/app/public/slides/';
        } else {
            echo 'Le fichier n\'existe pas dans storage/app/public/slides/';
        }
        ?>
    </p>
    
    <h2>Vérification des fichiers via lien symbolique</h2>
    <p>
        <?php
        $file = '/home/zertos/htdocs/website/public/storage/slides/test_slide_1745367884.jpg';
        if (file_exists($file)) {
            echo 'Le fichier existe via le lien symbolique';
        } else {
            echo 'Le fichier n\'existe pas via le lien symbolique';
        }
        ?>
    </p>
</body>
</html>
