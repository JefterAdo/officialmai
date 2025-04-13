<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('is_published', true)
            ->orderBy('event_date', 'desc')
            ->paginate(12);

        return view('mediatheque.photos', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        if (!$gallery->is_published) {
            abort(404);
        }

        return view('mediatheque.gallery-show', compact('gallery'));
    }
}
