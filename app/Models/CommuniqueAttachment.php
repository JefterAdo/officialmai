<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CommuniqueAttachment extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'communique_id',
        'file_path',
        'file_type',
        'original_name',
        'size',
        'mime_type',
        'download_count',
    ];

    protected $appends = ['human_readable_size', 'full_url', 'download_name'];

    protected $casts = [
        'download_count' => 'integer',
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Les attributs qui doivent être cachés pour les sérialisations.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'raw_file_path',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($attachment) {
            try {
                // Supprimer le fichier physique du disque public
                $path = $attachment->getRawOriginal('file_path');
                
                if (!empty($path) && !filter_var($path, FILTER_VALIDATE_URL)) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                        Log::info("Pièce jointe supprimée avec succès", ['path' => $path, 'attachment_id' => $attachment->id]);
                    } else {
                        // Essayer avec un chemin alternatif
                        $basename = basename($path);
                        $altPath = "communiques/documents/{$basename}";
                        
                        if (Storage::disk('public')->exists($altPath)) {
                            Storage::disk('public')->delete($altPath);
                            Log::info("Pièce jointe supprimée avec chemin alternatif", ['path' => $altPath, 'attachment_id' => $attachment->id]);
                        } else {
                            Log::warning("Fichier introuvable lors de la suppression", ['path' => $path, 'attachment_id' => $attachment->id]);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error("Erreur lors de la suppression de la pièce jointe", [
                    'attachment_id' => $attachment->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        });
    }

    /**
     * Obtenir le chemin brut du fichier (sans asset())
     * 
     * @return string|null
     */
    public function getRawFilePathAttribute()
    {
        return $this->attributes['file_path'] ?? null;
    }
    
    /**
     * Obtenir l'URL complète du fichier
     * 
     * @return string
     */
    public function getFullUrlAttribute(): string
    {
        if (empty($this->file_path)) {
            return '';
        }
        
        // Si le chemin est déjà une URL complète
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            // Vérifier que l'URL est sécurisée (HTTPS) et provient d'un domaine approuvé
            $host = parse_url($this->file_path, PHP_URL_HOST);
            $scheme = parse_url($this->file_path, PHP_URL_SCHEME);
            
            // Vérifier que l'URL est sécurisée (HTTPS)
            if (strtolower($scheme) !== 'https') {
                Log::warning("URL non sécurisée détectée", [
                    'attachment_id' => $this->id,
                    'url' => $this->file_path
                ]);
            }
            
            return $this->file_path;
        }
        
        // Assurer que le chemin est relatif à storage/app/public
        $path = $this->getRawOriginal('file_path');
        
        // Vérifier si le fichier existe physiquement
        if (!Storage::disk('public')->exists($path)) {
            Log::warning("Fichier non trouvé", [
                'path' => $path,
                'attachment_id' => $this->id
            ]);
            
            // Essayer de trouver le fichier avec un chemin alternatif
            $basename = basename($path);
            $altPath = "communiques/documents/{$basename}";
            
            if (Storage::disk('public')->exists($altPath)) {
                Log::info("Fichier trouvé avec chemin alternatif", [
                    'original_path' => $path,
                    'alternative_path' => $altPath,
                    'attachment_id' => $this->id
                ]);
                $path = $altPath;
            }
        }
        
        return asset('storage/' . $path);
    }

    /**
     * Obtenir le nom de fichier pour le téléchargement
     * 
     * @return string
     */
    public function getDownloadNameAttribute(): string
    {
        // Récupérer le chemin brut pour extraire l'extension
        $path = $this->getRawOriginal('file_path');
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        // Si aucune extension n'est trouvée, essayer avec le nom original
        if (empty($extension) && !empty($this->original_name)) {
            $extension = pathinfo($this->original_name, PATHINFO_EXTENSION);
        }
        
        // Créer un nom de fichier sécurisé à partir du nom original
        $name = Str::slug(pathinfo($this->original_name ?? 'document', PATHINFO_FILENAME));
        
        // S'assurer que l'extension est présente
        return $name . (!empty($extension) ? '.' . $extension : '');
    }

    /**
     * Obtenir la taille du fichier dans un format lisible
     * 
     * @return string|null
     */
    public function getHumanReadableSizeAttribute()
    {
        if (!$this->size) {
            // Si la taille n'est pas définie mais que le fichier existe, tenter de la récupérer
            $path = $this->getRawOriginal('file_path');
            
            if (!empty($path) && !filter_var($path, FILTER_VALIDATE_URL)) {
                $fullPath = Storage::disk('public')->path($path);
                
                if (file_exists($fullPath)) {
                    $size = filesize($fullPath);
                    
                    // Mettre à jour la taille dans la base de données
                    $this->update(['size' => $size]);
                    
                    // Utiliser cette taille pour le calcul
                    $units = ['B', 'KB', 'MB', 'GB'];
                    $power = $size > 0 ? floor(log($size, 1024)) : 0;
                    return number_format($size / pow(1024, $power), 2, '.', '') . ' ' . $units[$power];
                }
            }
            
            return null;
        }
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $this->size > 0 ? floor(log($this->size, 1024)) : 0;
        
        return number_format($this->size / pow(1024, $power), 2, '.', '') . ' ' . $units[$power];
    }

    /**
     * Obtient le communiqué auquel appartient cette pièce jointe.
     */
    public function communique(): BelongsTo
    {
        return $this->belongsTo(Communique::class);
    }
}
