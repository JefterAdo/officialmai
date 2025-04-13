<?php

namespace App\Services;

use Google_Client;
use Google_Service_YouTube;
use App\Models\Video;
use Illuminate\Support\Str;
use Carbon\Carbon;

class YouTubeService
{
    protected $youtube;
    protected $channelId;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setDeveloperKey(config('services.youtube.api_key'));
        
        $this->youtube = new Google_Service_YouTube($client);
        $this->channelId = config('services.youtube.channel_id');
    }

    public function getLatestVideos(int $maxResults = 6)
    {
        try {
            $response = $this->youtube->search->listSearch('snippet', [
                'channelId' => $this->channelId,
                'maxResults' => $maxResults,
                'order' => 'date',
                'type' => 'video'
            ]);

            $videos = [];
            foreach ($response->getItems() as $item) {
                // Récupérer plus de détails sur la vidéo
                $videoDetails = $this->youtube->videos->listVideos('contentDetails', [
                    'id' => $item->id->videoId
                ])->getItems()[0];

                $videos[] = [
                    'video_url' => 'https://www.youtube.com/watch?v=' . $item->id->videoId,
                    'title' => $item->snippet->title,
                    'description' => $item->snippet->description,
                    'thumbnail' => $item->snippet->thumbnails->high->url,
                    'published_at' => Carbon::parse($item->snippet->publishedAt),
                    'duration' => $this->formatDuration($videoDetails->contentDetails->duration),
                    'video_id' => $item->id->videoId,
                ];
            }

            return $videos;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des vidéos YouTube : ' . $e->getMessage());
            return [];
        }
    }

    public function syncLatestVideos()
    {
        $videos = $this->getLatestVideos();
        
        foreach ($videos as $videoData) {
            Video::updateOrCreate(
                ['video_url' => $videoData['video_url']],
                [
                    'title' => $videoData['title'],
                    'slug' => Str::slug($videoData['title']),
                    'description' => $videoData['description'],
                    'thumbnail' => $videoData['thumbnail'],
                    'video_type' => 'youtube',
                    'duration' => $videoData['duration'],
                    'published_at' => $videoData['published_at'],
                    'is_published' => true,
                ]
            );
        }
    }

    protected function formatDuration(string $duration): string
    {
        try {
            $interval = new \DateInterval($duration);
            $parts = [];
            
            if ($interval->h > 0) {
                $parts[] = $interval->h . 'h';
            }
            if ($interval->i > 0) {
                $parts[] = $interval->i . 'min';
            }
            if ($interval->s > 0 || empty($parts)) {
                $parts[] = $interval->s . 's';
            }
            
            return implode(' ', $parts);
        } catch (\Exception $e) {
            return '0:00';
        }
    }

    public function getVideoIdFromUrl(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
} 