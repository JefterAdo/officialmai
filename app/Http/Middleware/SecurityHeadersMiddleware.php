<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SecurityService;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Gérer une requête entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si la requête est sécurisée (HTTPS)
        if (!SecurityService::isSecureRequest($request) && !app()->environment('local')) {
            // Rediriger vers HTTPS si on est en production
            return redirect()->secure($request->getRequestUri());
        }
        
        // Vérifier si la requête provient d'un domaine autorisé
        if (!SecurityService::isAllowedReferrer($request) && $request->method() !== 'GET') {
            // Journaliser la tentative d'accès non autorisée
            SecurityService::logUnauthorizedAccess('referrer_not_allowed', null, $request);
            
            // Retourner une erreur 403
            return response()->json([
                'error' => 'Accès refusé. Origine de la requête non autorisée.'
            ], 403);
        }
        
        // Vérifier si l'IP est sur la liste noire
        if (SecurityService::isBlacklistedIp($request->ip())) {
            // Journaliser la tentative d'accès non autorisée
            SecurityService::logUnauthorizedAccess('blacklisted_ip', null, $request);
            
            // Retourner une erreur 403
            return response()->json([
                'error' => 'Accès refusé.'
            ], 403);
        }
        
        // Continuer le traitement de la requête
        $response = $next($request);
        
        // Appliquer les en-têtes de sécurité à la réponse
        if ($response instanceof Response) {
            SecurityService::applySecurityHeaders($response);
        }
        
        return $response;
    }
}
