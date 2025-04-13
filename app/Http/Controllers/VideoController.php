<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\YouTubeService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $youtubeService;

    public function __construct(YouTubeService $youtubeService)
    {
        $this->youtubeService = $youtubeService;
    }

    public function index()
    {
        $videos = Video::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        // Débogage
        \Log::info('Nombre de vidéos trouvées : ' . $videos->count());
        \Log::info('Première vidéo : ', $videos->first() ? $videos->first()->toArray() : ['aucune vidéo']);

        return view('mediatheque.videos', compact('videos'));
    }

    public function show(Video $video)
    {
        if (!$video->is_published) {
            abort(404);
        }

        $relatedVideos = Video::where('id', '!=', $video->id)
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('mediatheque.video-show', compact('video', 'relatedVideos'));
    }
} 