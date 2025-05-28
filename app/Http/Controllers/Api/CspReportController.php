<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CspReportController extends Controller
{
    /**
     * Recevoir et traiter les rapports de violation CSP
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        // Récupérer le rapport JSON brut
        $content = $request->getContent();
        
        try {
            // Décoder le rapport JSON
            $report = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            
            // Extraire les informations pertinentes du rapport
            $cspReport = $report['csp-report'] ?? [];
            
            // Journaliser la violation CSP
            Log::channel('security')->warning('Violation CSP détectée', [
                'document_uri' => $cspReport['document-uri'] ?? 'inconnu',
                'violated_directive' => $cspReport['violated-directive'] ?? 'inconnu',
                'blocked_uri' => $cspReport['blocked-uri'] ?? 'inconnu',
                'source_file' => $cspReport['source-file'] ?? 'inconnu',
                'line_number' => $cspReport['line-number'] ?? 'inconnu',
                'user_agent' => $request->header('User-Agent'),
                'ip' => $request->ip(),
            ]);
            
            return response()->noContent(204);
        } catch (\Exception $e) {
            // Journaliser l'erreur de traitement
            Log::error('Erreur lors du traitement du rapport CSP', [
                'error' => $e->getMessage(),
                'raw_content' => $content,
            ]);
            
            return response()->json(['error' => 'Erreur de traitement du rapport'], 400);
        }
    }
}
