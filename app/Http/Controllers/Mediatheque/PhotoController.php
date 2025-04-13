<?php

namespace App\Http\Controllers\Mediatheque;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\View\View;

class PhotoController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::with(['images' => function($query) {
            $query->orderBy('order')->take(1);
        }])
        ->where('is_published', true)
        ->orderBy('event_date', 'desc')
        ->paginate(12);

        return view('mediatheque.photos', compact('galleries'));
    }

    public function show(Gallery $gallery): View
    {
        if (!$gallery->is_published) {
            abort(404);
        }

        $gallery->load('images');

        return view('mediatheque.gallery-show', compact('gallery'));
    }
} 