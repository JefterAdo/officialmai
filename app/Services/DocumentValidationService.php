<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Communique;
use App\Models\CommuniqueAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentValidationService
{
    /**
     * Valide un document avant de le sauvegarder
     *
     * @param array $data
     * @param UploadedFile|null $file
     * @return array
     */
    public static function validateDocument(array $data, ?UploadedFile $file = null): array
    {
        $errors = [];

        // Validation des données de base
        if (empty($data['title'])) {
            $errors[] = 'Le titre du document est requis.';
        }

        if (empty($data['type'])) {
            $errors[] = 'Le type de document est requis.';
        }

        // Validation du fichier si présent
        if ($file) {
            $fileErrors = FileSecurityService::validateUploadedFile($file);
            $errors = array_merge($errors, $fileErrors);
        } elseif (!empty($data['file_path'])) {
            // Validation de l'URL si c'est une URL externe
            if (filter_var($data['file_path'], FILTER_VALIDATE_URL)) {
                if (!FileSecurityService::isAllowedDomain($data['file_path'])) {
                    $errors[] = 'Le domaine de l\'URL n\'est pas autorisé.';
                }
                
                if (!FileSecurityService::isSecureUrl($data['file_path'])) {
                    $errors[] = 'L\'URL doit utiliser le protocole HTTPS.';
                }
            } else {
                // Validation du chemin local
                if (!FileSecurityService::isSecurePath($data['file_path'])) {
                    $errors[] = 'Le chemin du fichier n\'est pas sécurisé.';
                }
                
                // Vérifier si le fichier existe
                $path = FileSecurityService::findAlternativePath($data['file_path']);
                if (!$path) {
                    $errors[] = 'Le fichier spécifié n\'existe pas.';
                }
            }
        } else {
            $errors[] = 'Un fichier ou une URL est requis.';
        }

        return $errors;
    }

    /**
     * Valide un communiqué avant de le sauvegarder
     *
     * @param array $data
     * @return array
     */
    public static function validateCommunique(array $data): array
    {
        $errors = [];

        // Validation des données de base
        if (empty($data['title'])) {
            $errors[] = 'Le titre du communiqué est requis.';
        }

        if (empty($data['content'])) {
            $errors[] = 'Le contenu du communiqué est requis.';
        }

        // Validation de la date de publication si présente
        if (!empty($data['published_at'])) {
            try {
                $date = new \DateTime($data['published_at']);
            } catch (\Exception $e) {
                $errors[] = 'La date de publication n\'est pas valide.';
            }
        }

        return $errors;
    }

    /**
     * Valide une pièce jointe de communiqué
     *
     * @param UploadedFile $file
     * @param int $communiqueId
     * @return array
     */
    public static function validateCommuniqueAttachment(UploadedFile $file, int $communiqueId): array
    {
        $errors = [];

        // Vérifier que le communiqué existe
        $communique = Communique::find($communiqueId);
        if (!$communique) {
            $errors[] = 'Le communiqué spécifié n\'existe pas.';
            return $errors;
        }

        // Validation du fichier
        $fileErrors = FileSecurityService::validateUploadedFile($file);
        $errors = array_merge($errors, $fileErrors);

        return $errors;
    }

    /**
     * Sauvegarde un document avec validation
     *
     * @param array $data
     * @param UploadedFile|null $file
     * @return array
     */
    public static function saveDocument(array $data, ?UploadedFile $file = null): array
    {
        // Valider les données
        $errors = self::validateDocument($data, $file);
        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
                'document' => null
            ];
        }

        try {
            // Traiter le fichier si présent
            if ($file) {
                $result = FileSecurityService::storeSecurely($file, 'documents');
                if (!$result['success']) {
                    return [
                        'success' => false,
                        'errors' => $result['errors'],
                        'document' => null
                    ];
                }
                $data['file_path'] = $result['path'];
            }

            // Créer ou mettre à jour le document
            $document = isset($data['id']) ? Document::find($data['id']) : new Document();
            
            if (!$document) {
                return [
                    'success' => false,
                    'errors' => ['Document non trouvé.'],
                    'document' => null
                ];
            }

            $document->fill($data);
            $document->save();

            return [
                'success' => true,
                'errors' => [],
                'document' => $document
            ];
        } catch (\Exception $e) {
            Log::error('Erreur lors de la sauvegarde du document', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            return [
                'success' => false,
                'errors' => ['Une erreur est survenue lors de la sauvegarde du document.'],
                'document' => null
            ];
        }
    }

    /**
     * Sauvegarde une pièce jointe de communiqué avec validation
     *
     * @param UploadedFile $file
     * @param int $communiqueId
     * @return array
     */
    public static function saveCommuniqueAttachment(UploadedFile $file, int $communiqueId): array
    {
        // Valider les données
        $errors = self::validateCommuniqueAttachment($file, $communiqueId);
        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
                'attachment' => null
            ];
        }

        try {
            $result = FileSecurityService::storeSecurely($file, 'communiques/documents');
            if (!$result['success']) {
                return [
                    'success' => false,
                    'errors' => $result['errors'],
                    'attachment' => null
                ];
            }
            $path = $result['path'];
            
            // Créer l'enregistrement de pièce jointe
            $attachment = new CommuniqueAttachment([
                'communique_id' => $communiqueId,
                'file_path' => $path,
                'file_type' => strtolower($file->getClientOriginalExtension()),
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'download_count' => 0
            ]);
            
            $attachment->save();

            return [
                'success' => true,
                'errors' => [],
                'attachment' => $attachment
            ];
        } catch (\Exception $e) {
            Log::error('Erreur lors de la sauvegarde de la pièce jointe', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'communique_id' => $communiqueId
            ]);

            return [
                'success' => false,
                'errors' => ['Une erreur est survenue lors de la sauvegarde de la pièce jointe.'],
                'attachment' => null
            ];
        }
    }
}
