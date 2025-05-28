<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileSecurityService
{
    /**
     * Vérifie si un type MIME est autorisé
     *
     * @param string $mimeType
     * @return bool
     */
    public static function isAllowedMimeType(string $mimeType): bool
    {
        $allowedMimeTypes = Config::get('app.security.allowed_mime_types', []);
        return in_array($mimeType, $allowedMimeTypes);
    }

    /**
     * Vérifie si un domaine est autorisé
     *
     * @param string $url
     * @return bool
     */
    public static function isAllowedDomain(string $url): bool
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $host = parse_url($url, PHP_URL_HOST);
        $allowedDomains = Config::get('app.security.allowed_domains', []);

        foreach ($allowedDomains as $domain) {
            if ($host === $domain || Str::endsWith($host, '.' . $domain)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Vérifie si une URL est sécurisée (HTTPS)
     *
     * @param string $url
     * @return bool
     */
    public static function isSecureUrl(string $url): bool
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        return strtolower($scheme) === 'https';
    }

    /**
     * Valide un fichier téléchargé
     *
     * @param UploadedFile $file
     * @return array
     */
    public static function validateUploadedFile(UploadedFile $file): array
    {
        $maxSize = Config::get('app.security.max_upload_size', 10 * 1024 * 1024);
        $errors = [];

        // Vérifier la taille du fichier
        if ($file->getSize() > $maxSize) {
            $errors[] = 'Le fichier dépasse la taille maximale autorisée.';
        }

        // Vérifier le type MIME
        if (!self::isAllowedMimeType($file->getMimeType())) {
            $errors[] = 'Le type de fichier n\'est pas autorisé.';
        }

        return $errors;
    }

    /**
     * Génère un nom de fichier sécurisé
     *
     * @param string $originalName
     * @param string $extension
     * @return string
     */
    public static function generateSecureFilename(string $originalName, string $extension = ''): string
    {
        // Nettoyer le nom original
        $cleanName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        
        // Ajouter un identifiant unique pour éviter les collisions
        $uniqueId = Str::random(8);
        
        // Construire le nom final
        $extension = empty($extension) ? pathinfo($originalName, PATHINFO_EXTENSION) : $extension;
        $extension = !empty($extension) ? '.' . $extension : '';
        
        return $cleanName . '_' . $uniqueId . $extension;
    }

    /**
     * Vérifie si un chemin de fichier est sécurisé (pas de traversée de répertoire)
     *
     * @param string $path
     * @return bool
     */
    public static function isSecurePath(string $path): bool
    {
        // Vérifier les tentatives de traversée de répertoire
        if (Str::contains($path, '..') || Str::contains($path, './') || Str::startsWith($path, '/')) {
            Log::warning('Tentative de traversée de répertoire détectée', ['path' => $path]);
            return false;
        }

        return true;
    }

    /**
     * Vérifie si un fichier existe dans le stockage public
     *
     * @param string $path
     * @return bool
     */
    public static function fileExists(string $path): bool
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return true; // On ne peut pas vérifier l'existence d'une URL externe
        }

        return Storage::disk('public')->exists($path);
    }

    /**
     * Trouve un chemin alternatif pour un fichier s'il n'existe pas à l'emplacement d'origine
     *
     * @param string $originalPath
     * @param array $alternativeFolders
     * @return string|null
     */
    public static function findAlternativePath(string $originalPath, array $alternativeFolders = ['documents', 'communiques/documents']): ?string
    {
        if (self::fileExists($originalPath)) {
            return $originalPath;
        }

        $basename = basename($originalPath);
        
        foreach ($alternativeFolders as $folder) {
            $altPath = "{$folder}/{$basename}";
            
            if (Storage::disk('public')->exists($altPath)) {
                Log::info("Fichier trouvé avec chemin alternatif", [
                    'original_path' => $originalPath,
                    'alternative_path' => $altPath
                ]);
                
                return $altPath;
            }
        }
        
        return null;
    }
}
