<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YouTubeController extends Controller
{
    /**
     * Affiche la page des vidéos YouTube
     */
    public function index()
    {
        return view('youtube-videos');
    }
}
