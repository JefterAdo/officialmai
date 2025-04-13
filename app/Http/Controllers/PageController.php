<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Si la page a un template spécifique, on l'utilise
        if ($page->template !== 'default') {
            return view($page->template, [
                'page' => $page,
                'meta_title' => $page->meta_title ?? $page->title,
                'meta_description' => $page->meta_description,
            ]);
        }

        // Sinon, on utilise le template par défaut
        return view('pages.show', [
            'page' => $page,
            'meta_title' => $page->meta_title ?? $page->title,
            'meta_description' => $page->meta_description,
        ]);
    }

    public function home()
    {
        $latestVideos = \App\Models\Video::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('welcome', compact('latestVideos'));
    }
} 