<?php

namespace App\Filament\Resources\CommuniqueResource\Pages;

use App\Filament\Resources\CommuniqueResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreateCommunique extends CreateRecord
{
    protected static string $resource = CommuniqueResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Séparer les données du communiqué des données des nouvelles pièces jointes
        $communiqueData = collect($data)->except('attachments')->toArray();
        $uploadedFilePaths = $data['attachments'] ?? [];

        $communique = static::getModel()::create($communiqueData);

        if (!empty($uploadedFilePaths) && is_array($uploadedFilePaths)) {
            foreach ($uploadedFilePaths as $filePath) {
                if (!empty($filePath)) {
                    try {
                        // Vérifier si le fichier existe sur le disque
                        if (!Storage::disk('public')->exists($filePath)) {
                            \Log::warning("Fichier non trouvé : {$filePath}");
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
                        $communique->attachments()->create([
                            'file_path' => $filePath,
                            'original_name' => $originalName,
                            'file_type' => $fileType,
                            'size' => $fileSize, // Assurez-vous que la colonne s'appelle 'size' et non 'file_size'
                            'mime_type' => $fileType,
                            'download_count' => 0,
                            'download_name' => $downloadName,
                        ]);
                        
                        \Log::info("Pièce jointe créée avec succès", [
                            'chemin' => $filePath,
                            'taille' => $fileSize,
                            'type' => $fileType
                        ]);
                        
                    } catch (\Exception $e) {
                        \Log::error("Erreur lors de la création de la pièce jointe", [
                            'erreur' => $e->getMessage(),
                            'chemin' => $filePath ?? 'inconnu',
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
            }
        }
        
        // Mettre à jour le champ has_attachments
        $communique->update(['has_attachments' => $communique->attachments()->exists()]);

        return $communique;
    }
}