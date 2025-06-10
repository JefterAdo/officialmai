<?php

namespace App\Http\Controllers\Mediatheque;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class OfficialTextsController extends Controller
{
    /**
     * Affiche la page listant les textes officiels.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer tous les documents, pas seulement les actifs
        $documents = Document::orderByDesc('updated_at')
                            ->get();

        // Journaliser le nombre de documents trouvés pour débogage
        \Illuminate\Support\Facades\Log::info('Documents trouvés pour la page textes', [
            'count' => $documents->count(),
            'documents' => $documents->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'slug' => $doc->slug,
                    'is_active' => $doc->is_active,
                ];
            })
        ]);

        return view('mediatheque.textes', compact('documents'));
    }
}
