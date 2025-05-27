<?php

namespace App\Filament\Resources\CommuniqueResource\Pages;

use App\Filament\Resources\CommuniqueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditCommunique extends EditRecord
{
    protected static string $resource = CommuniqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Conserver les données des nouvelles pièces jointes pour les traiter dans afterSave
        // et les retirer des données principales pour éviter les erreurs de mass assignment.
        if (isset($data['attachments'])) {
            $this->newlyUploadedFilePaths = $data['attachments'];
            unset($data['attachments']);
        }
        return $data;
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();

        // Gérer les nouvelles pièces jointes (celles stockées dans $this->newlyUploadedFilePaths)
        if (!empty($this->newlyUploadedFilePaths) && is_array($this->newlyUploadedFilePaths)) {
            foreach ($this->newlyUploadedFilePaths as $filePath) {
                if (!empty($filePath)) {
                    try {
                        // Vérifier si le fichier existe sur le disque
                        if (!Storage::disk('public')->exists($filePath)) {
                            \Log::warning("Fichier non trouvé lors de la modification : {$filePath}");
                            continue;
                        }
                        
                        // Le fichier est déjà stocké par FileUpload, $filePath est son chemin
                        $originalName = basename($filePath);
                        
                        // Obtenir le type MIME de façon sécurisée
                        try {
                            $fileType = Storage::disk('public')->mimeType($filePath) ?? 'application/octet-stream';
                        } catch (\Exception $e) {
                            \Log::warning("Impossible de déterminer le type MIME pour {$filePath}: {$e->getMessage()}");
                            $fileType = 'application/octet-stream';
                        }
                        
                        // Obtenir la taille du fichier de façon sécurisée
                        try {
                            $fileSize = Storage::disk('public')->size($filePath);
                        } catch (\Exception $e) {
                            \Log::warning("Impossible de déterminer la taille pour {$filePath}: {$e->getMessage()}");
                            // Utiliser une méthode alternative pour obtenir la taille du fichier
                            $fullPath = Storage::disk('public')->path($filePath);
                            if (file_exists($fullPath)) {
                                $fileSize = filesize($fullPath);
                            } else {
                                $fileSize = 0;
                            }
                        }
                        
                        // Déterminer un nom de fichier sécurisé pour le téléchargement
                        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                        $downloadName = preg_replace('/[^\w\-\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
                        
                        // Créer la pièce jointe
                        $record->attachments()->create([
                            'file_path' => $filePath,
                            'original_name' => $originalName,
                            'file_type' => $fileType,
                            'size' => $fileSize, // Assurez-vous que la colonne s'appelle 'size' et non 'file_size'
                            'mime_type' => $fileType,
                            'download_count' => 0,
                            'download_name' => $downloadName,
                        ]);
                        
                        \Log::info("Pièce jointe ajoutée avec succès lors de la modification", [
                            'communique_id' => $record->id,
                            'chemin' => $filePath,
                            'taille' => $fileSize,
                            'type' => $fileType
                        ]);
                        
                    } catch (\Exception $e) {
                        \Log::error("Erreur lors de l'ajout de la pièce jointe en modification", [
                            'erreur' => $e->getMessage(),
                            'communique_id' => $record->id,
                            'chemin' => $filePath ?? 'inconnu',
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
            }
            // Réinitialiser pour les sauvegardes suivantes sur la même page
            $this->newlyUploadedFilePaths = []; 
        }

        // Mettre à jour le champ has_attachments après toutes les opérations
        $record->refresh(); // S'assurer que la relation attachments est à jour
        $record->update(['has_attachments' => $record->attachments()->exists()]);
    }
}