<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
     * Obtenir l'URL complète du fichier
     */
    public function getFullUrlAttribute(): string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : '';
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
