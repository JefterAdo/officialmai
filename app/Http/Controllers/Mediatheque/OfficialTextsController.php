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
        $documents = Document::active()
                            ->orderByDesc('updated_at') // Ou 'created_at' ou un champ 'order' spécifique
                            ->get();

        return view('mediatheque.textes', compact('documents'));
    }
}
