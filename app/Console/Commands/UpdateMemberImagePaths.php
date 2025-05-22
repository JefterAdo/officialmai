<?php

namespace App\Console\Commands;

use App\Models\OrganizationStructure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateMemberImagePaths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-member-image-paths';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour les chemins des images des membres pour correspondre à la nouvelle structure de dossiers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $members = OrganizationStructure::all();
        $updated = 0;
        $notFound = [];
        $skipped = [];

        $this->info("Début de la mise à jour des chemins d'images...");
        $bar = $this->output->createProgressBar(count($members));
        $bar->start();

        foreach ($members as $member) {
            if (empty($member->image)) {
                $skipped[] = "{$member->name}: Pas d'image définie";
                $bar->advance();
                continue;
            }

            // Ignorer les URLs complètes
            if (filter_var($member->image, FILTER_VALIDATE_URL)) {
                $skipped[] = "{$member->name}: URL complète détectée";
                $bar->advance();
                continue;
            }

            // Nettoyer le chemin
            $cleanPath = ltrim($member->image, '/');
            $filename = basename($cleanPath);
            
            // Déterminer le chemin attendu en fonction du groupe
            $expectedPath = "membres/{$member->group}/{$filename}";
            
            // Vérifier si le fichier existe avec le nouveau chemin
            if (Storage::disk('public')->exists($expectedPath)) {
                $member->image = $expectedPath;
                $member->save();
                $updated++;
                $bar->advance();
                continue;
            }
            
            // Essayer avec le nom en majuscules
            $uppercasePath = "membres/{$member->group}/" . strtoupper($filename);
            if (Storage::disk('public')->exists($uppercasePath)) {
                $member->image = $uppercasePath;
                $member->save();
                $updated++;
                $bar->advance();
                continue;
            }
            
            // Si on arrive ici, l'image n'a pas été trouvée
            $notFound[] = "{$member->name}: {$member->image}";
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        // Afficher un résumé
        $this->info("Résumé des mises à jour :");
        $this->line("- Membres mis à jour : {$updated}");
        $this->line("- Images non trouvées : " . count($notFound));
        $this->line("- Membres ignorés : " . count($skipped));
        
        // Afficher les images non trouvées si nécessaire
        if (!empty($notFound)) {
            $this->warn("\nImages non trouvées :");
            foreach ($notFound as $item) {
                $this->line("- {$item}");
            }
        }
        
        $this->info("\nMise à jour terminée !");
        
        return 0;
    }
}
