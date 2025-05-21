<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class FixLivewireUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:fix-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Résout les problèmes de téléchargement de fichiers avec Livewire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== RÉPARATION DES TÉLÉCHARGEMENTS LIVEWIRE ===');

        // 1. Récupérer la configuration actuelle de Livewire
        $disk = Config::get('livewire.temporary_file_upload.disk', 'public');
        $directory = Config::get('livewire.temporary_file_upload.directory', 'tmp-uploads');
        
        $this->info("Configuration actuelle : Disque = {$disk}, Dossier = {$directory}");
        
        // 2. Vérifier si le disque existe
        if (!array_key_exists($disk, Config::get('filesystems.disks', []))) {
            $this->error("Le disque '{$disk}' n'existe pas dans la configuration filesystems.php");
            return 1;
        }
        
        // 3. Créer les dossiers nécessaires
        $this->info('Création des dossiers nécessaires...');
        
        // Chemin dans le système de fichiers
        $storagePath = storage_path("app/public/{$directory}");
        $publicPath = public_path("storage/{$directory}");
        
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0777, true);
            $this->info("Dossier créé : {$storagePath}");
        }
        
        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0777, true);
            $this->info("Dossier créé : {$publicPath}");
        }
        
        // 4. Appliquer les permissions
        $this->info('Application des permissions...');
        chmod($storagePath, 0777);
        chmod($publicPath, 0777);
        
        // 5. Créer un fichier .gitignore dans les dossiers
        $gitignoreContent = "*\n!.gitignore\n";
        File::put("{$storagePath}/.gitignore", $gitignoreContent);
        File::put("{$publicPath}/.gitignore", $gitignoreContent);
        
        // 6. Tester les permissions en écrivant un fichier de test
        $this->info('Test des permissions...');
        $testFile = "{$publicPath}/test-file.txt";
        $testContent = "Test file created at " . now() . "\n";
        
        try {
            File::put($testFile, $testContent);
            $this->info("✅ Test d'écriture réussi");
            
            $readContent = File::get($testFile);
            $this->info("✅ Test de lecture réussi");
            
            File::delete($testFile);
            $this->info("✅ Test de suppression réussi");
        } catch (\Exception $e) {
            $this->error("❌ Erreur lors du test des permissions : " . $e->getMessage());
            return 1;
        }
        
        // 7. Créer un fichier index.php vide dans le dossier public
        $indexContent = "<?php\n// Silence is golden\n";
        File::put("{$publicPath}/index.php", $indexContent);
        
        // 8. Vider le cache de configuration
        $this->call('config:clear');
        
        $this->info('');
        $this->info('✅ Réparation terminée avec succès !');
        $this->info("Les téléchargements de fichiers Livewire sont maintenant correctement configurés.");
        $this->info("Si vous rencontrez encore des problèmes, exécutez à nouveau cette commande.");
        
        return 0;
    }
}
