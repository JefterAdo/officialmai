<?php

namespace App\Http\Controllers;

use App\Models\Speech;
use Illuminate\Http\Request;

class SpeechController extends Controller
{
    public function index()
    {
        $speeches = Speech::where('is_published', true)
            ->orderBy('speech_date', 'desc')
            ->paginate(12);

        return view('mediatheque.discours', compact('speeches'));
    }

    public function show($slug)
    {
        $speech = Speech::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedSpeeches = Speech::where('id', '!=', $speech->id)
            ->where('is_published', true)
            ->orderBy('speech_date', 'desc')
            ->limit(3)
            ->get();

        return view('mediatheque.discours-show', compact('speech', 'relatedSpeeches'));
    }
} 