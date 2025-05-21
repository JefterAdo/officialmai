<?php
// Script pour résoudre définitivement le problème des images sur tout le site
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== SOLUTION GLOBALE POUR LES PROBLÈMES D'IMAGES ===\n\n";

// 1. Vérifier la structure des dossiers
echo "1. VÉRIFICATION DE LA STRUCTURE DES DOSSIERS\n";
$storagePath = storage_path('app/public');
$publicPath = public_path('storage');

echo "Dossier storage/app/public: " . (is_dir($storagePath) ? "Existe" : "N'existe pas") . "\n";
echo "Dossier public/storage: " . (is_dir($publicPath) ? "Existe" : "N'existe pas") . "\n";

// Vérifier si public/storage est un lien symbolique
if (is_link($publicPath)) {
    $target = readlink($publicPath);
    echo "public/storage est un lien symbolique pointant vers: {$target}\n";
    
    // Supprimer le lien symbolique qui cause des problèmes
    unlink($publicPath);
    echo "✅ Lien symbolique supprimé\n";
} else {
    echo "public/storage n'est pas un lien symbolique\n";
    
    // Si c'est un dossier, le supprimer
    if (is_dir($publicPath)) {
        File::deleteDirectory($publicPath);
        echo "✅ Dossier public/storage supprimé\n";
    }
}

// 2. Créer une structure de dossiers directe (sans lien symbolique)
echo "\n2. CRÉATION D'UNE STRUCTURE DE DOSSIERS DIRECTE\n";

// Créer le dossier public/storage
if (!is_dir($publicPath)) {
    mkdir($publicPath, 0777, true);
    echo "✅ Dossier public/storage créé\n";
} else {
    echo "Le dossier public/storage existe déjà\n";
}

// 3. Synchroniser les fichiers de storage/app/public vers public/storage
echo "\n3. SYNCHRONISATION DES FICHIERS\n";

function copyDirectory($source, $destination) {
    if (!is_dir($destination)) {
        mkdir($destination, 0777, true);
    }
    
    $items = scandir($source);
    $count = 0;
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        
        $sourcePath = $source . '/' . $item;
        $destPath = $destination . '/' . $item;
        
        if (is_dir($sourcePath)) {
            copyDirectory($sourcePath, $destPath);
        } else {
            if (copy($sourcePath, $destPath)) {
                chmod($destPath, 0777);
                $count++;
            }
        }
    }
    
    return $count;
}

$filesCopied = copyDirectory($storagePath, $publicPath);
echo "✅ {$filesCopied} fichiers copiés de storage/app/public vers public/storage\n";

// 4. Créer un observateur pour synchroniser automatiquement les fichiers
echo "\n4. CRÉATION D'UN SYSTÈME DE SYNCHRONISATION AUTOMATIQUE\n";

// Créer le dossier des observateurs s'il n'existe pas
$observersDir = app_path('Observers');
if (!is_dir($observersDir)) {
    mkdir($observersDir, 0777, true);
    echo "✅ Dossier des observateurs créé\n";
}

// Créer l'observateur pour les médias
$mediaObserverPath = app_path('Observers/MediaObserver.php');
$mediaObserverContent = <<<'PHP'
<?php

namespace App\Observers;

use App\Models\Media;
use Illuminate\Support\Facades\File;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function created(Media $media): void
    {
        $this->syncFile($media);
    }

    /**
     * Handle the Media "updated" event.
     */
    public function updated(Media $media): void
    {
        $this->syncFile($media);
    }

    /**
     * Handle the Media "deleted" event.
     */
    public function deleted(Media $media): void
    {
        // Supprimer le fichier de public/storage si nécessaire
        $publicPath = public_path('storage/' . $media->file_path);
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }
    }

    /**
     * Synchroniser le fichier de storage/app/public vers public/storage
     */
    private function syncFile(Media $media): void
    {
        if (!$media->file_path) {
            return;
        }

        $sourcePath = storage_path('app/public/' . $media->file_path);
        $destPath = public_path('storage/' . $media->file_path);

        // Créer le dossier de destination si nécessaire
        $destDir = dirname($destPath);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        // Copier le fichier
        if (file_exists($sourcePath)) {
            copy($sourcePath, $destPath);
            chmod($destPath, 0777);
        }
    }
}
PHP;

file_put_contents($mediaObserverPath, $mediaObserverContent);
echo "✅ Observateur MediaObserver créé\n";

// Créer l'observateur pour les slides
$slideObserverPath = app_path('Observers/SlideObserver.php');
$slideObserverContent = <<<'PHP'
<?php

namespace App\Observers;

use App\Models\Slide;
use Illuminate\Support\Facades\File;

class SlideObserver
{
    /**
     * Handle the Slide "created" event.
     */
    public function created(Slide $slide): void
    {
        $this->syncFile($slide);
    }

    /**
     * Handle the Slide "updated" event.
     */
    public function updated(Slide $slide): void
    {
        $this->syncFile($slide);
    }

    /**
     * Handle the Slide "deleted" event.
     */
    public function deleted(Slide $slide): void
    {
        // Supprimer le fichier de public/storage si nécessaire
        $publicPath = public_path('storage/' . $slide->image_path);
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }
    }

    /**
     * Synchroniser le fichier de storage/app/public vers public/storage
     */
    private function syncFile(Slide $slide): void
    {
        if (!$slide->image_path) {
            return;
        }

        $sourcePath = storage_path('app/public/' . $slide->image_path);
        $destPath = public_path('storage/' . $slide->image_path);

        // Créer le dossier de destination si nécessaire
        $destDir = dirname($destPath);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        // Copier le fichier
        if (file_exists($sourcePath)) {
            copy($sourcePath, $destPath);
            chmod($destPath, 0777);
        }
    }
}
PHP;

file_put_contents($slideObserverPath, $slideObserverContent);
echo "✅ Observateur SlideObserver créé\n";

// Créer un script de synchronisation pour être exécuté régulièrement
$syncScriptPath = base_path('sync-storage.php');
$syncScriptContent = <<<'PHP'
<?php
// Script pour synchroniser les fichiers de storage/app/public vers public/storage
require __DIR__ . '/vendor/autoload.php';

$storagePath = __DIR__ . '/storage/app/public';
$publicPath = __DIR__ . '/public/storage';

echo "=== SYNCHRONISATION DES FICHIERS DE STORAGE ===\n\n";

// Fonction pour copier un dossier et son contenu
function copyDirectory($source, $destination) {
    if (!is_dir($destination)) {
        mkdir($destination, 0777, true);
    }
    
    $items = scandir($source);
    $count = 0;
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        
        $sourcePath = $source . '/' . $item;
        $destPath = $destination . '/' . $item;
        
        if (is_dir($sourcePath)) {
            copyDirectory($sourcePath, $destPath);
        } else {
            if (copy($sourcePath, $destPath)) {
                chmod($destPath, 0777);
                $count++;
            }
        }
    }
    
    return $count;
}

// Vérifier si les dossiers existent
if (!is_dir($storagePath)) {
    echo "❌ Le dossier source n'existe pas: {$storagePath}\n";
    exit(1);
}

// Créer le dossier de destination s'il n'existe pas
if (!is_dir($publicPath)) {
    mkdir($publicPath, 0777, true);
    echo "✅ Dossier de destination créé: {$publicPath}\n";
}

// Copier les fichiers
$filesCopied = copyDirectory($storagePath, $publicPath);
echo "✅ {$filesCopied} fichiers copiés de storage/app/public vers public/storage\n";

echo "\nTerminé.\n";
PHP;

file_put_contents($syncScriptPath, $syncScriptContent);
echo "✅ Script de synchronisation sync-storage.php créé\n";

// Enregistrer les observateurs dans le AppServiceProvider
$appServiceProviderPath = app_path('Providers/AppServiceProvider.php');
$appServiceProviderContent = file_get_contents($appServiceProviderPath);

// Vérifier si les observateurs sont déjà enregistrés
if (strpos($appServiceProviderContent, 'SlideObserver') === false) {
    // Ajouter les imports
    $appServiceProviderContent = str_replace(
        'namespace App\\Providers;',
        "namespace App\\Providers;\n\nuse App\\Models\\Media;\nuse App\\Models\\Slide;\nuse App\\Observers\\MediaObserver;\nuse App\\Observers\\SlideObserver;",
        $appServiceProviderContent
    );
    
    // Ajouter l'enregistrement des observateurs
    $appServiceProviderContent = str_replace(
        'public function boot(): void',
        "public function boot(): void\n    {\n        // Enregistrer les observateurs\n        Media::observe(MediaObserver::class);\n        Slide::observe(SlideObserver::class);",
        $appServiceProviderContent
    );
    
    file_put_contents($appServiceProviderPath, $appServiceProviderContent);
    echo "✅ Observateurs enregistrés dans AppServiceProvider\n";
} else {
    echo "Les observateurs sont déjà enregistrés dans AppServiceProvider\n";
}

// 5. Mettre à jour tous les templates pour utiliser des URLs directes
echo "\n5. MISE À JOUR DES TEMPLATES\n";

// Liste des fichiers à vérifier
$templatesDir = resource_path('views');
$templates = [];

function findFilesRecursively($dir, &$files) {
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            findFilesRecursively($path, $files);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) == 'php' || 
                 pathinfo($path, PATHINFO_EXTENSION) == 'blade.php') {
            $files[] = $path;
        }
    }
}

findFilesRecursively($templatesDir, $templates);
echo "Nombre de templates trouvés: " . count($templates) . "\n";

$templatesUpdated = 0;

foreach ($templates as $template) {
    $content = file_get_contents($template);
    $originalContent = $content;
    
    // Remplacer asset('storage/... par /storage/...
    $content = preg_replace('/asset\s*\(\s*[\'"]storage\/([^\'"]*?)[\'"]\s*\)/', "'/storage/\\1'", $content);
    
    // Remplacer Storage::url('public/... par /storage/...
    $content = preg_replace('/Storage::url\s*\(\s*[\'"]public\/([^\'"]*?)[\'"]\s*\)/', "'/storage/\\1'", $content);
    
    if ($content !== $originalContent) {
        file_put_contents($template, $content);
        $templatesUpdated++;
        echo "  ✅ Template mis à jour: " . basename($template) . "\n";
    }
}

echo "✅ {$templatesUpdated} templates mis à jour\n";

// 6. Créer un fichier README avec des instructions
echo "\n6. CRÉATION D'UN FICHIER README\n";

$readmePath = base_path('README-SLIDER.md');
$readmeContent = <<<'MARKDOWN'
# Solution pour les problèmes d'images sur le site RHDP

## Problème

Le site rencontrait des problèmes avec l'affichage des images en raison de l'erreur "Too many levels of symbolic links" dans NGINX. Cette erreur se produisait car NGINX ne pouvait pas suivre correctement les liens symboliques entre `public/storage` et `storage/app/public`.

## Solution mise en place

### 1. Suppression du lien symbolique problématique

Le lien symbolique `public/storage` qui pointait vers `storage/app/public` a été supprimé et remplacé par une copie directe des fichiers.

### 2. Système de synchronisation automatique

Un système de synchronisation a été mis en place pour maintenir les fichiers à jour entre `storage/app/public` et `public/storage` :

- **Observateurs** : Des observateurs Laravel ont été créés pour les modèles Media et Slide, qui synchronisent automatiquement les fichiers lorsqu'ils sont créés, modifiés ou supprimés.
- **Script de synchronisation** : Un script `sync-storage.php` a été créé pour synchroniser manuellement tous les fichiers.

### 3. URLs directes

Tous les templates ont été mis à jour pour utiliser des URLs directes (`/storage/...`) au lieu de fonctions comme `asset('storage/...')` ou `Storage::url('public/...')`.

## Maintenance

### Synchronisation manuelle

Si vous constatez que certaines images ne s'affichent pas, vous pouvez exécuter le script de synchronisation :

```bash
php sync-storage.php
```

### Ajout de nouveaux types de médias

Si vous ajoutez de nouveaux types de médias au site, vous devrez peut-être créer des observateurs supplémentaires pour ces modèles.

## Recommandations pour NGINX

Pour une solution plus propre à long terme, vous pourriez configurer NGINX pour servir directement les fichiers de `storage/app/public` sans passer par un lien symbolique. Voici un exemple de configuration :

```nginx
server {
    # ... autres configurations ...

    # Servir les fichiers de storage directement
    location /storage {
        alias /home/zertos/htdocs/www.zertos.online/storage/app/public;
        try_files $uri =404;
    }

    # ... autres configurations ...
}
```

Cette configuration permettrait d'éviter complètement les problèmes de liens symboliques.
MARKDOWN;

file_put_contents($readmePath, $readmeContent);
echo "✅ Fichier README-SLIDER.md créé\n";

// 7. Vider les caches
echo "\n7. VIDAGE DES CACHES\n";
system('php artisan cache:clear');
system('php artisan view:clear');
system('php artisan config:clear');
system('php artisan route:clear');

echo "\n=== RÉSUMÉ ===\n";
echo "✅ Structure de dossiers corrigée (plus de lien symbolique)\n";
echo "✅ Fichiers synchronisés entre storage/app/public et public/storage\n";
echo "✅ Système de synchronisation automatique mis en place\n";
echo "✅ Templates mis à jour pour utiliser des URLs directes\n";
echo "✅ Documentation créée\n";
echo "✅ Caches vidés\n";
echo "\nLa solution est prête à être déployée sur le serveur de production.\n";
echo "Pour résoudre définitivement le problème sur le serveur, exécutez ce script sur le serveur de production.\n";
