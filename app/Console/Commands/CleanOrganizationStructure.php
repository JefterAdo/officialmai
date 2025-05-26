<?php

namespace App\Console\Commands;

use App\Models\OrganizationStructure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CleanOrganizationStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rhdp:clean-organization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nettoyer les doublons dans la table organization_structure et rattacher les images manquantes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Début du nettoyage de la table organization_structure...');
        
        // 1. Désactiver temporairement les contraintes de clé étrangère
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // 2. Récupérer tous les membres triés par nom et date de création (du plus ancien au plus récent)
        $members = OrganizationStructure::orderBy('name')->orderBy('created_at')->get();

        $names = [];
        $duplicates = [];
        $toDelete = [];

        $this->info('Recherche des doublons...');
        
        // 3. Identifier les doublons
        foreach ($members as $member) {
            $normalizedName = $this->normalizeName($member->name);
            
            if (!isset($names[$normalizedName])) {
                $names[$normalizedName] = [];
            }
            
            $names[$normalizedName][] = $member;
            
            if (count($names[$normalizedName]) > 1) {
                $duplicates[$normalizedName] = $names[$normalizedName];
            }
        }

        $this->info(sprintf('Nombre de doublons trouvés : %d', count($duplicates)));

        // 4. Traiter les doublons
        foreach ($duplicates as $name => $duplicateMembers) {
            // Garder le membre le plus récent
            $latestMember = $duplicateMembers[count($duplicateMembers) - 1];
            
            $this->info("\nTraitement des doublons pour : " . $name);
            $this->line("- Conserver : " . $latestMember->id . " (créé le " . $latestMember->created_at . ")");
            
            // Mettre à jour les références des membres à supprimer
            for ($i = 0; $i < count($duplicateMembers) - 1; $i++) {
                $oldMember = $duplicateMembers[$i];
                $this->line("  Supprimer : " . $oldMember->id . " (créé le " . $oldMember->created_at . ")");
                
                // Mettre à jour les références parentes
                DB::table('organization_structure')
                    ->where('parent_id', $oldMember->id)
                    ->update(['parent_id' => $latestMember->id]);
                    
                // Supprimer le doublon
                $oldMember->delete();
            }
        }

        // 5. Vérifier et rattacher les images manquantes
        $this->info("\nVérification des images manquantes...");

        // Récupérer tous les membres restants
        $allMembers = OrganizationStructure::all();
        $imageFiles = [];

        // Lister toutes les images dans le dossier membres/
        $directories = ['membres/directoire', 'membres/secretariat_executif'];

        foreach ($directories as $dir) {
            $files = Storage::disk('public')->files($dir);
            
            foreach ($files as $file) {
                // Exclure les fichiers cachés comme .DS_Store
                if (strpos(basename($file), '.') !== 0) {
                    $imageFiles[] = $file;
                }
            }
        }

        $this->info(sprintf('Nombre d\'images trouvées : %d', count($imageFiles)));
        $updatedCount = 0;

        // Parcourir tous les membres pour vérifier leurs images
        foreach ($allMembers as $member) {
            // Si le membre n'a pas d'image ou que l'image n'existe pas
            if (empty($member->image) || !Storage::disk('public')->exists($member->image)) {
                $memberName = $this->normalizeName($member->name);
                
                // Chercher une image correspondante
                foreach ($imageFiles as $imageFile) {
                    $imageName = pathinfo($imageFile, PATHINFO_FILENAME);
                    $normalizedImageName = $this->normalizeName($imageName);
                    
                    // Vérifier si le nom du fichier contient le nom du membre
                    if (str_contains($normalizedImageName, $memberName) || 
                        str_contains($memberName, $normalizedImageName)) {
                        
                        // Mettre à jour le chemin de l'image
                        $oldImage = $member->image;
                        $member->image = $imageFile;
                        $member->save();
                        
                        $this->info(sprintf(
                            'Image rattachée pour %s : %s (ancienne valeur : %s)',
                            $member->name,
                            $imageFile,
                            $oldImage ?? 'aucune'
                        ));
                        
                        $updatedCount++;
                        break;
                    }
                }
            }
        }

        // Réactiver les contraintes de clé étrangère
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info("\nNettoyage terminé !");
        $this->info(sprintf('- %d doublons traités', count($duplicates)));
        $this->info(sprintf('- %d images rattachées', $updatedCount));

        return 0;
    }

    /**
     * Normalise un nom en supprimant les accents, la ponctuation, etc.
     *
     * @param string $name
     * @return string
     */
    private function normalizeName($name)
    {
        // Supprimer les titres (M., Mme, etc.)
        $name = preg_replace('/^(M\.|Mme|Mlle|Dr|Pr|Me)\s+/i', '', $name);
        
        // Supprimer la ponctuation et les espaces multiples
        $name = preg_replace('/[^\p{L}0-9\s]/u', '', $name);
        $name = preg_replace('/\s+/', ' ', $name);
        
        // Convertir en majuscules et supprimer les accents
        $name = mb_strtoupper($name);
        $name = str_replace(
            ['À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ'],
            ['A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y'],
            $name
        );
        
        return trim($name);
    }
}
