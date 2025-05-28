<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AuthSecurityService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StrongPasswordMiddleware
{
    /**
     * Vérifie que les mots de passe soumis respectent les critères de sécurité.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ne vérifier que les requêtes qui contiennent des mots de passe
        if ($request->has('password') && !empty($request->password)) {
            $password = $request->password;
            
            // Valider la force du mot de passe
            $validation = AuthSecurityService::validatePasswordStrength($password);
            
            if (!$validation['valid']) {
                // Journaliser la tentative avec un mot de passe faible
                Log::warning('Tentative d\'utilisation d\'un mot de passe faible', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'errors' => $validation['errors']
                ]);
                
                // Rediriger avec les erreurs
                return redirect()->back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors(['password' => $validation['errors']]);
            }
        }
        
        return $next($request);
    }
}
