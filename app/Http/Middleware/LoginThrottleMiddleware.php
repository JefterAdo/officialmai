<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AuthSecurityService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LoginThrottleMiddleware
{
    /**
     * Limite le nombre de tentatives de connexion pour prévenir les attaques par force brute.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ne vérifier que les requêtes de connexion
        if ($request->is('admin/login') && $request->isMethod('post')) {
            $ip = $request->ip();
            
            // Vérifier si l'adresse IP est bloquée
            if (AuthSecurityService::hasTooManyLoginAttempts($ip)) {
                $seconds = AuthSecurityService::getSecondsUntilUnlock($ip);
                $minutes = ceil($seconds / 60);
                
                // Journaliser la tentative bloquée
                Log::warning('Tentative de connexion bloquée (trop de tentatives)', [
                    'ip' => $ip,
                    'user_agent' => $request->userAgent(),
                    'email' => $request->input('email'),
                    'seconds_until_unlock' => $seconds
                ]);
                
                // Rediriger avec un message d'erreur
                return redirect()->back()
                    ->withInput($request->except('password'))
                    ->withErrors([
                        'email' => "Trop de tentatives de connexion. Veuillez réessayer dans {$minutes} minute(s)."
                    ]);
            }
        }
        
        return $next($request);
    }
}
