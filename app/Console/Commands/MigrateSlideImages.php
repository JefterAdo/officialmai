<?php

namespace App\Console\Commands;

use App\Models\Slide;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateSlideImages extends Command
{
    protected $signature = 'slides:migrate-images {--dry-run : Exécuter sans faire de modifications réelles} {--source=backup_images : Dossier source des images}';
    protected $description = 'Migrer les images des slides vers le nouveau système de stockage';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $sourceFolder = $this->option('source');
        
        if ($isDryRun) {
            $this->info('Mode dry-run activé - aucune modification ne sera effectuée');
        }

        $slides = Slide::all();
        $this->info('Migration de ' . $slides->count() . ' slides...');
        
        // Sauvegarde des chemins d'images actuels
        $backupData = [];
        foreach ($slides as $slide) {
            $backupData[] = [
                'id' => $slide->id,
                'old_path' => $slide->image_path,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];
        }
        
        if (!$isDryRun) {
            $backupFile = storage_path('logs/slides_paths_backup_' . now()->format('Y-m-d_H-i-s') . '.json');
            file_put_contents($backupFile, json_encode($backupData, JSON_PRETTY_PRINT));
            $this->info("Sauvegarde des chemins d'images dans : " . $backupFile);
        }

        $bar = $this->output->createProgressBar($slides->count());
        $errors = [];
        $success = [];

        foreach ($slides as $slide) {
            $oldPath = $slide->image_path;
            $backupPath = storage_path($sourceFolder . '/' . basename($oldPath));
            
            // Vérifier si l'image existe dans le backup
            if (!file_exists($backupPath)) {
                if (!$isDryRun) {
                    // Lister les images disponibles
                    $availableImages = array_filter(
                        scandir(storage_path($sourceFolder)),
                        fn($file) => !in_array($file, ['.', '..']) && is_file(storage_path($sourceFolder . '/' . $file))
                    );
                    
                    $this->warn("Image introuvable dans le backup pour le slide {$slide->id}: " . basename($oldPath));
                    $this->info("Images disponibles dans le backup :");
                    
                    $availableImages = array_values($availableImages); // Réindexer le tableau
                    foreach ($availableImages as $index => $image) {
                        $this->line(($index + 1) . ". " . $image);
                    }
                    
                    $this->info("Entrez le numéro de l'image (1-" . count($availableImages) . ") ou 0 pour ignorer :");
                    $choice = trim($this->ask("Votre choix"));
                    
                    if (is_numeric($choice) && $choice > 0 && $choice <= count($availableImages)) {
                        $selectedImage = $availableImages[$choice - 1];
                        $backupPath = storage_path($sourceFolder . '/' . $selectedImage);
                        $this->info("Image sélectionnée : " . $selectedImage);
                    } else {
                        $errors[] = "Slide {$slide->id} ignoré par l'utilisateur";
                        $bar->advance();
                        continue;
                    }
                } else {
                    $errors[] = "Image introuvable dans le backup pour le slide {$slide->id}: " . basename($oldPath);
                    $bar->advance();
                    continue;
                }
            }

            try {
                if ($isDryRun) {
                    $this->info("[DRY-RUN] Traitement de l'image : " . basename($oldPath));
                    $bar->advance();
                    continue;
                }

                // Créer une nouvelle image
                $sourceImage = imagecreatefromstring(file_get_contents($backupPath));
                $sourceWidth = imagesx($sourceImage);
                $sourceHeight = imagesy($sourceImage);
                
                // Calculer les nouvelles dimensions
                $targetWidth = 1920;
                $targetHeight = 1080;
                $ratio = min($targetWidth / $sourceWidth, $targetHeight / $sourceHeight);
                $newWidth = (int)($sourceWidth * $ratio);
                $newHeight = (int)($sourceHeight * $ratio);
                
                // Créer l'image redimensionnée
                $newImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
                
                // Générer un nouveau nom de fichier
                $extension = pathinfo($oldPath, PATHINFO_EXTENSION) ?: 'jpg';
                $newFilename = 'slide_' . uniqid() . '.' . $extension;
                $newPath = 'slides/' . $newFilename;
                $fullNewPath = Storage::disk('public')->path($newPath);
                
                // Créer le dossier de destination s'il n'existe pas
                if (!file_exists(dirname($fullNewPath))) {
                    mkdir(dirname($fullNewPath), 0755, true);
                }

                // Sauvegarder la nouvelle image
                switch(strtolower($extension)) {
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg($newImage, $fullNewPath, 90);
                        break;
                    case 'png':
                        imagepng($newImage, $fullNewPath, 9);
                        break;
                    case 'gif':
                        imagegif($newImage, $fullNewPath);
                        break;
                    default:
                        imagejpeg($newImage, $fullNewPath, 90);
                }
                
                // Libérer la mémoire
                imagedestroy($sourceImage);
                imagedestroy($newImage);

                // Mettre à jour le chemin dans la base de données
                $slide->update(['image_path' => $newPath]);
                $success[] = "Image migrée avec succès : " . basename($oldPath) . " -> " . $newPath;

            } catch (\Exception $e) {
                $errors[] = "Erreur lors de la migration de l'image du slide {$slide->id}: " . $e->getMessage();
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        
        // Afficher le résumé
        $this->info('Migration des images terminée !');
        
        if (!empty($success)) {
            $this->info("\nOpérations réussies :");
            foreach ($success as $msg) {
                $this->line("✓ " . $msg);
            }
        }
        
        if (!empty($errors)) {
            $this->error("\nErreurs rencontrées :");
            foreach ($errors as $error) {
                $this->warn("⚠ " . $error);
            }
        }
    }
} 