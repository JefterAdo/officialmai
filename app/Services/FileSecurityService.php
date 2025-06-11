<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class FileSecurityService
{
    /**
     * Liste des types MIME autorisés par défaut
     * 
     * @var array
     */
    protected static $defaultAllowedMimeTypes = [
        // Documents
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', // .pptx
        'text/plain',
        
        // Images
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/svg+xml',
        'image/webp',
        
        // Archives (avec précaution)
        'application/zip',
        'application/x-rar-compressed',
    ];
    
    /**
     * Extensions de fichiers dangereuses à bloquer
     * 
     * @var array
     */
    protected static $dangerousExtensions = [
        'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'pht', 'phar', 'phps',
        'cgi', 'pl', 'py', 'jsp', 'asp', 'aspx', 'exe', 'bat', 'cmd', 'sh',
        'htaccess', 'htpasswd', 'ini', 'config'
    ];

    /**
     * Vérifie si un type MIME est autorisé
     *
     * @param string $mimeType
     * @return bool
     */
    public static function isAllowedMimeType(string $mimeType): bool
    {
        $allowedMimeTypes = Config::get('app.security.allowed_mime_types', self::$defaultAllowedMimeTypes);
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
     * Valide un fichier téléchargé avec des vérifications de sécurité renforcées
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

        // Vérifier l'extension du fichier
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, self::$dangerousExtensions)) {
            $errors[] = 'L\'extension du fichier n\'est pas autorisée pour des raisons de sécurité.';
            Log::warning('Tentative d\'upload d\'un fichier avec extension dangereuse', [
                'extension' => $extension,
                'filename' => $file->getClientOriginalName(),
                'ip' => request()->ip()
            ]);
        }

        // Vérifier le type MIME déclaré
        $mimeType = $file->getMimeType();
        if (!self::isAllowedMimeType($mimeType)) {
            $errors[] = 'Le type de fichier n\'est pas autorisé.';
        }

        // Vérification supplémentaire du contenu réel du fichier
        $realMimeType = self::detectRealMimeType($file);
        if ($realMimeType && $realMimeType !== $mimeType && !self::isAllowedMimeType($realMimeType)) {
            $errors[] = 'Le contenu du fichier ne correspond pas au type déclaré.';
            Log::warning('Détection de type MIME incohérent', [
                'declared_mime' => $mimeType,
                'detected_mime' => $realMimeType,
                'filename' => $file->getClientOriginalName(),
                'ip' => request()->ip()
            ]);
        }

        return $errors;
    }
    
    /**
     * Détecte le type MIME réel d'un fichier en analysant son contenu
     *
     * @param UploadedFile $file
     * @return string|null
     */
    public static function detectRealMimeType(UploadedFile $file): ?string
    {
        // Utiliser finfo pour détecter le type MIME basé sur le contenu
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $filePath = $file->getRealPath();
        
        if (!$filePath || !file_exists($filePath)) {
            return null;
        }
        
        return $finfo->file($filePath);
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
        if (empty($cleanName)) {
            $cleanName = 'file'; // Nom par défaut si le nom nettoyé est vide
        }
        
        // Limiter la longueur du nom pour éviter les problèmes de système de fichiers
        $cleanName = substr($cleanName, 0, 50);
        
        // Ajouter un identifiant unique pour éviter les collisions
        $uniqueId = Str::random(8);
        
        // Traiter l'extension de manière sécurisée
        if (empty($extension)) {
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        }
        
        // Vérifier que l'extension n'est pas dangereuse
        $extension = strtolower($extension);
        if (in_array($extension, self::$dangerousExtensions)) {
            $extension = 'txt'; // Remplacer par une extension sécurisée
            Log::warning('Extension dangereuse détectée et remplacée', [
                'original_extension' => pathinfo($originalName, PATHINFO_EXTENSION),
                'filename' => $originalName,
                'ip' => request()->ip()
            ]);
        }
        
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
        // Normaliser le chemin pour détecter les tentatives de traversée cachées
        $normalizedPath = self::normalizePath($path);
        
        // Motifs dangereux à vérifier
        $dangerousPatterns = [
            '..', // Traversée de répertoire
            './', // Référence au répertoire courant
            '~/', // Référence au répertoire home
            '/etc/', // Accès aux fichiers de configuration système
            '/var/www/', // Accès direct aux fichiers web
            '/proc/', // Accès aux informations du système
            '/dev/', // Accès aux périphériques
            'php://', // Accès aux wrappers PHP
            'file://', // Accès aux wrappers de fichiers
            'phar://', // Accès aux archives PHP
            'data://', // Accès aux données encodées
            'zip://', // Accès aux archives ZIP
            'glob://', // Utilisation de motifs glob
        ];
        
        foreach ($dangerousPatterns as $pattern) {
            if (Str::contains($normalizedPath, $pattern)) {
                Log::warning('Tentative de traversée de répertoire ou d\'accès non autorisé détectée', [
                    'path' => $path,
                    'normalized_path' => $normalizedPath,
                    'pattern' => $pattern,
                    'ip' => request()->ip()
                ]);
                return false;
            }
        }
        
        // Vérifier les chemins absolus
        if (Str::startsWith($normalizedPath, '/') || (PHP_OS_FAMILY === 'Windows' && preg_match('/^[A-Z]:\\/', $normalizedPath))) {
            Log::warning('Tentative d\'utilisation de chemin absolu détectée', [
                'path' => $path,
                'normalized_path' => $normalizedPath,
                'ip' => request()->ip()
            ]);
            return false;
        }

        return true;
    }
    
    /**
     * Normalise un chemin pour détecter les tentatives de traversée cachées
     *
     * @param string $path
     * @return string
     */
    public static function normalizePath(string $path): string
    {
        // Convertir les backslashes en slashes pour la normalisation
        $path = str_replace('\\', '/', $path);
        
        // Décoder les URL encodages potentiels
        $path = urldecode($path);
        
        // Supprimer les doubles slashes
        $path = preg_replace('#/+#', '/', $path);
        
        // Supprimer les caractères null
        $path = str_replace(chr(0), '', $path);
        
        return $path;
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
     * avec vérifications de sécurité renforcées
     *
     * @param string $originalPath
     * @param array $alternativeFolders
     * @return string|null
     */
    public static function findAlternativePath(string $originalPath, array $alternativeFolders = ['documents', 'communiques/documents']): ?string
    {
        // Vérifier si le chemin original est sécurisé
        if (!self::isSecurePath($originalPath)) {
            Log::error('Tentative d\'accès à un chemin non sécurisé', [
                'path' => $originalPath,
                'ip' => request()->ip()
            ]);
            return null;
        }
        
        // Vérifier si le fichier existe à l'emplacement original
        if (self::fileExists($originalPath)) {
            return $originalPath;
        }

        // Extraire le nom de fichier de manière sécurisée
        $basename = basename($originalPath);
        
        // Vérifier que le nom de fichier ne contient pas de caractères dangereux
        if (preg_match('/[<>:"\\\/|?*]/', $basename)) {
            Log::warning('Nom de fichier contenant des caractères non autorisés', [
                'filename' => $basename,
                'ip' => request()->ip()
            ]);
            return null;
        }
        
        // Rechercher dans les dossiers alternatifs
        foreach ($alternativeFolders as $folder) {
            // Vérifier que le dossier alternatif est sécurisé
            if (!self::isSecurePath($folder)) {
                continue;
            }
            
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
    
    /**
     * Stocke un fichier téléchargé de manière sécurisée
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $filename
     * @return array
     */
    public static function storeSecurely(UploadedFile $file, string $directory, ?string $filename = null): array
    {
        // Valider le fichier avant de le stocker
        $validationErrors = self::validateUploadedFile($file);
        if (!empty($validationErrors)) {
            return [
                'success' => false,
                'errors' => $validationErrors,
                'path' => null
            ];
        }
        
        // Vérifier que le répertoire est sécurisé
        if (!self::isSecurePath($directory)) {
            return [
                'success' => false,
                'errors' => ['Le répertoire de destination n\'est pas sécurisé.'],
                'path' => null
            ];
        }
        
        // Générer un nom de fichier sécurisé si non fourni
        if (empty($filename)) {
            $extension = $file->getClientOriginalExtension();
            $filename = self::generateSecureFilename($file->getClientOriginalName(), $extension);
        } else {
            // Si un nom est fourni, vérifier qu'il est sécurisé
            $filename = self::generateSecureFilename($filename);
        }
        
        try {
            // Stocker le fichier dans le répertoire spécifié
            $path = $file->storeAs($directory, $filename, 'public');

            // Optimisation de l'image si c'en est une
            $imageMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $realMimeType = Storage::disk('public')->mimeType($path);

            if (in_array($realMimeType, $imageMimeTypes)) {
                try {
                    $manager = new ImageManager(new Driver());
                    $fullPath = Storage::disk('public')->path($path);
                    $image = $manager->read($fullPath);
                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                    switch ($extension) {
                        case 'jpeg':
                        case 'jpg':
                            $image->toJpeg(75)->save($fullPath);
                            break;
                        case 'png':
                            $image->toPng()->save($fullPath);
                            break;
                        case 'gif':
                            $image->toGif()->save($fullPath);
                            break;
                        case 'webp':
                            $image->toWebp(75)->save($fullPath);
                            break;
                    }
                    Log::info('Image optimisée avec succès', ['path' => $path]);
                } catch (\Exception $e) {
                    Log::error('Erreur lors de l\'optimisation de l\'image', [
                        'error' => $e->getMessage(),
                        'path' => $path
                    ]);
                    // On ne bloque pas le processus si l'optimisation échoue
                }
            }
            
            // Journaliser le stockage réussi
            Log::info('Fichier stocké avec succès', [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);
            
            return [
                'success' => true,
                'errors' => [],
                'path' => $path,
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize()
            ];
        } catch (\Exception $e) {
            Log::error('Erreur lors du stockage du fichier', [
                'original_name' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);
            
            return [
                'success' => false,
                'errors' => ['Une erreur est survenue lors du stockage du fichier.'],
                'path' => null
            ];
        }
    }
}
