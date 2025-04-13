<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speech extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'speech_category_id',
        'title',
        'slug',
        'description',
        'content',
        'speaker',
        'event_name',
        'location',
        'speech_date',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'video_url',
        'audio_url',
        'is_featured',
        'is_published',
        'published_at',
        'excerpt',
    ];

    protected $casts = [
        'speech_date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SpeechCategory::class, 'speech_category_id');
    }

    public function getFileUrl()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getHumanFileSize()
    {
        if (!$this->file_size) return null;
        
        $size = intval($this->file_size);
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public function getYoutubeEmbedUrl()
    {
        if (!$this->video_url) return null;

        // Extraire l'ID de la vidéo YouTube de l'URL
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $this->video_url, $matches)) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }

        return null;
    }
}
