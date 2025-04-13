<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audio extends Model
{
    use HasFactory;

    protected $fillable = [
        'audio_category_id',
        'title',
        'slug',
        'description',
        'speaker',
        'event_name',
        'location',
        'recording_date',
        'duration',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'is_featured',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'recording_date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AudioCategory::class, 'audio_category_id');
    }
}
