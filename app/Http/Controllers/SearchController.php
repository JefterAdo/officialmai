<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Communique;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return view('search.results', ['results' => collect(), 'query' => '']);
        }

        // Recherche dans les actualités
        $newsResults = News::where('is_published', true)
                            ->where(function ($q) use ($query) {
                                $q->where('title', 'LIKE', "%{$query}%")
                                  ->orWhere('content', 'LIKE', "%{$query}%");
                            })
                            ->get()
                            ->map(function ($item) {
                                $item->type = 'Actualité';
                                $item->url = route('actualites.show', $item->slug);
                                return $item;
                            });

        // Recherche dans les communiqués
        $communiqueResults = Communique::where('is_published', true)
                                      ->where(function ($q) use ($query) {
                                          $q->where('title', 'LIKE', "%{$query}%")
                                            ->orWhere('content', 'LIKE', "%{$query}%");
                                      })
                                      ->get()
                                      ->map(function ($item) {
                                          $item->type = 'Communiqué';
                                          $item->url = route('communiques.show', $item->slug);
                                          return $item;
                                      });

        // Combine et trie les résultats
        $results = $newsResults->concat($communiqueResults)->sortByDesc('created_at');

        return view('search.results', compact('results', 'query'));
    }
}
