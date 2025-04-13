<?php

namespace App\Http\Controllers;

use App\Models\Communique;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommuniqueController extends Controller
{
    public function index()
    {
        $communiques = Communique::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('actualites.communiques', compact('communiques'));
    }

    public function show($slug)
    {
        $communique = Communique::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('actualites.communique-show', compact('communique'));
    }
} 