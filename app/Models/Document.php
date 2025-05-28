<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Document extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'file_path',
        'type',
        'description',
        'is_active',
        'download_count',
        'view_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'view_count' => 'integer',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = Str::slug($document->title);
            }
        });
        
        // Supprimer le fichier physique lors de la suppression du document
        static::deleting(function ($document) {
            try {
                $path = $document->getRawOriginal('file_path');
                
                if (!empty($path) && !filter_var($path, FILTER_VALIDATE_URL)) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                        Log::info("Fichier supprimé avec succès", ['path' => $path, 'document_id' => $document->id]);
                    } else {
                        // Essayer avec un chemin alternatif
                        $basename = basename($path);
                        $altPath = "documents/{$basename}";
                        
                        if (Storage::disk('public')->exists($altPath)) {
                            Storage::disk('public')->delete($altPath);
                            Log::info("Fichier supprimé avec chemin alternatif", ['path' => $altPath, 'document_id' => $document->id]);
                        } else {
                            Log::warning("Fichier introuvable lors de la suppression", ['path' => $path, 'document_id' => $document->id]);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error("Erreur lors de la suppression du fichier", [
                    'document_id' => $document->id,
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
     * @param string $value
     * @return string|null
     */
    public function getFilePathAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        
        // Si le chemin est déjà une URL complète
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        
        // Vérifier si le fichier existe physiquement
        if (!Storage::disk('public')->exists($value)) {
            // Essayer de trouver le fichier avec un chemin alternatif
            $basename = basename($value);
            $altPath = "documents/{$basename}";
            
            if (Storage::disk('public')->exists($altPath)) {
                Log::info("Document trouvé avec chemin alternatif", [
                    'original_path' => $value,
                    'alternative_path' => $altPath,
                    'document_id' => $this->id
                ]);
                $value = $altPath;
            }
        }
        
        return asset('storage/' . $value);
    }

    public function getTypeLabelAttribute()
    {
        return [
            'statut' => 'Statut',
            'reglement-interieur' => 'Règlement Intérieur',
        ][$this->type] ?? $this->type;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helpers
    public static function getStatut()
    {
        return static::where('type', 'statut')
            ->active()
            ->latest()
            ->first();
    }

    public static function getReglementInterieur()
    {
        return static::where('type', 'reglement-interieur')
            ->active()
            ->latest()
            ->first();
    }
}
