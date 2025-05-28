<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SqlSecurityService;
use App\Services\SecurityService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SqlInjectionProtectionMiddleware
{
    /**
     * Gérer une requête entrante et la protéger contre les injections SQL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si la requête contient des tentatives d'injection SQL
        if ($this->checkForSqlInjection($request)) {
            // Journaliser la tentative d'attaque
            SecurityService::logUnauthorizedAccess('sql_injection_attempt', null, $request);
            
            // Retourner une erreur 403
            return response()->json([
                'error' => 'Accès refusé. Requête potentiellement malveillante détectée.'
            ], 403);
        }
        
        // Continuer le traitement de la requête
        return $next($request);
    }
    
    /**
     * Vérifie si la requête contient des tentatives d'injection SQL
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function checkForSqlInjection(Request $request): bool
    {
        // Ignorer les requêtes GET pour éviter les faux positifs
        // Les requêtes GET sont généralement moins susceptibles d'être utilisées pour des injections SQL
        // et plus susceptibles de contenir des paramètres légitimes qui pourraient être détectés comme des faux positifs
        if ($request->isMethod('GET')) {
            return false;
        }
        
        // Ignorer les requêtes authentifiées d'administrateurs
        // Les administrateurs sont supposés être de confiance
        if ($request->user() && $request->user()->isAdmin()) {
            return false;
        }
        
        // Récupérer tous les paramètres de la requête
        $allInputs = $request->all();
        
        // Vérifier récursivement tous les paramètres
        return $this->checkArrayForSqlInjection($allInputs);
    }
    
    /**
     * Vérifie récursivement un tableau pour des tentatives d'injection SQL
     *
     * @param  array  $inputs
     * @return bool
     */
    protected function checkArrayForSqlInjection(array $inputs): bool
    {
        foreach ($inputs as $key => $value) {
            // Vérifier la clé si c'est une chaîne
            if (is_string($key) && SqlSecurityService::containsSqlInjection($key)) {
                Log::warning('Tentative d\'injection SQL détectée dans une clé de paramètre', [
                    'key' => $key,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent()
                ]);
                return true;
            }
            
            // Vérifier la valeur
            if (is_string($value)) {
                if (SqlSecurityService::containsSqlInjection($value)) {
                    Log::warning('Tentative d\'injection SQL détectée dans une valeur de paramètre', [
                        'key' => $key,
                        'value' => $value,
                        'ip' => request()->ip(),
                        'user_agent' => request()->userAgent()
                    ]);
                    return true;
                }
            } elseif (is_array($value)) {
                // Vérifier récursivement les tableaux imbriqués
                if ($this->checkArrayForSqlInjection($value)) {
                    return true;
                }
            }
        }
        
        return false;
    }
}
