<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    protected $apiKey;
    protected $channelId;
    
    public function __construct()
    {
        $this->apiKey = 'AIzaSyD9D8xgJOqF6hvB-w6g0o_ev8JbC-v-Jkw';
        $this->channelId = 'UCZpVrNAWFKdZfbKRVGFNKNw'; // ID de la chaîne @rassemblementwebtv5828
    }
    
    /**
     * Affiche la liste des vidéos YouTube
     */
    public function index()
    {
        try {
            // Récupérer les 6 dernières vidéos de la chaîne
            $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
                'key' => $this->apiKey,
                'channelId' => $this->channelId,
                'part' => 'snippet,id',
                'order' => 'date',
                'maxResults' => 6,
                'type' => 'video'
            ]);
            
            if ($response->successful()) {
                $videos = $response->json()['items'];
                return view('mediatheque.videos', compact('videos'));
            } else {
                // En cas d'erreur API, afficher la vue sans vidéos
                return view('mediatheque.videos', ['videos' => [], 'error' => 'Impossible de récupérer les vidéos']);
            }
        } catch (\Exception $e) {
            // En cas d'exception, afficher la vue sans vidéos
            return view('mediatheque.videos', ['videos' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Affiche une vidéo spécifique
     */
    public function show($videoId)
    {
        try {
            // Récupérer les détails de la vidéo
            $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'key' => $this->apiKey,
                'id' => $videoId,
                'part' => 'snippet,player,statistics'
            ]);
            
            if ($response->successful() && !empty($response->json()['items'])) {
                $video = $response->json()['items'][0];
                
                // Récupérer quelques vidéos connexes
                $relatedResponse = Http::get('https://www.googleapis.com/youtube/v3/search', [
                    'key' => $this->apiKey,
                    'channelId' => $this->channelId,
                    'part' => 'snippet,id',
                    'maxResults' => 4,
                    'type' => 'video',
                    'videoId' => $videoId
                ]);
                
                $relatedVideos = [];
                if ($relatedResponse->successful()) {
                    $relatedVideos = $relatedResponse->json()['items'];
                }
                
                return view('mediatheque.video-single', compact('video', 'relatedVideos'));
            } else {
                // Vidéo non trouvée ou erreur API
                return redirect()->route('mediatheque.videos')
                    ->with('error', 'La vidéo demandée n\'est pas disponible');
            }
        } catch (\Exception $e) {
            return redirect()->route('mediatheque.videos')
                ->with('error', 'Erreur lors de la récupération de la vidéo: ' . $e->getMessage());
        }
    }
} 