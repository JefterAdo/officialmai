<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_description',
        'featured_image',
        'category_id',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    /**
     * Calcule le temps de lecture estimé en minutes
     * Basé sur une vitesse de lecture moyenne de 200 mots par minute
     *
     * @return int
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, round($wordCount / 200)); // Au moins 1 minute
    }

    /**
     * Nettoie le titre pour l'affichage
     *
     * @return string
     */
    public function getCleanTitleAttribute(): string
    {
        return html_entity_decode($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Formatte le temps de lecture pour l'affichage
     *
     * @return string
     */
    public function getFormattedReadingTimeAttribute(): string
    {
        $minutes = $this->getReadingTimeAttribute();
        return $minutes . ' min' . ($minutes > 1 ? 's' : '') . ' de lecture';
    }
} 