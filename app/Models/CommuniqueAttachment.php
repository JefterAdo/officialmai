<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CommuniqueAttachment extends Model
{
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
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($attachment) {
            // Supprimer le fichier physique du disque public
            if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        });
    }

    /**
     * Obtenir l'URL complète du fichier
     */
    public function getFullUrlAttribute(): string
    {
        if (empty($this->file_path)) {
            return '';
        }
        
        // Si le chemin est déjà une URL complète
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }
        
        // Assurer que le chemin est relatif à storage/app/public
        $path = $this->file_path;
        
        // Vérifier si le fichier existe physiquement
        if (!Storage::disk('public')->exists($path)) {
            \Log::warning("Fichier non trouvé : {$path}");
            // Essayer de trouver le fichier avec un chemin alternatif
            $basename = basename($path);
            $altPath = "communiques/documents/{$basename}";
            
            if (Storage::disk('public')->exists($altPath)) {
                \Log::info("Fichier trouvé avec chemin alternatif : {$altPath}");
                $path = $altPath;
            }
        }
        
        return asset('storage/' . $path);
    }

    /**
     * Obtenir le nom de fichier pour le téléchargement
     */
    public function getDownloadNameAttribute(): string
    {
        $extension = pathinfo($this->file_path, PATHINFO_EXTENSION);
        $name = Str::slug(pathinfo($this->original_name, PATHINFO_FILENAME));
        return $name . '.' . $extension;
    }

    /**
     * Obtenir la taille du fichier dans un format lisible
     */
    public function getHumanReadableSizeAttribute()
    {
        if (!$this->size) return null;
        
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
