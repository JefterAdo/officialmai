<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class SecurityService
{
    /**
     * Vérifier si l'utilisateur a le droit d'accéder à une ressource
     *
     * @param string $ability
     * @param mixed $resource
     * @return bool
     */
    public static function can(string $ability, $resource = null): bool
    {
        return Gate::allows($ability, $resource);
    }

    /**
     * Vérifier si l'utilisateur a le droit d'accéder à une ressource, sinon lancer une exception
     *
     * @param string $ability
     * @param mixed $resource
     * @param string $message
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public static function authorize(string $ability, $resource = null, string $message = null): void
    {
        Gate::authorize($ability, $resource, $message);
    }

    /**
     * Journaliser une tentative d'accès non autorisée
     *
     * @param string $action
     * @param mixed $resource
     * @param Request|null $request
     * @return void
     */
    public static function logUnauthorizedAccess(string $action, $resource = null, ?Request $request = null): void
    {
        $request = $request ?? request();
        
        $data = [
            'action' => $action,
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'route' => $request->route() ? $request->route()->getName() : null,
            'method' => $request->method(),
        ];
        
        if ($resource) {
            if (is_object($resource)) {
                $data['resource_type'] = get_class($resource);
                $data['resource_id'] = $resource->id ?? null;
            } else {
                $data['resource'] = $resource;
            }
        }
        
        Log::warning('Tentative d\'accès non autorisée', $data);
    }

    /**
     * Journaliser une action sensible
     *
     * @param string $action
     * @param array $data
     * @param Request|null $request
     * @return void
     */
    public static function logSensitiveAction(string $action, array $data = [], ?Request $request = null): void
    {
        $request = $request ?? request();
        
        $logData = array_merge([
            'action' => $action,
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'route' => $request->route() ? $request->route()->getName() : null,
            'method' => $request->method(),
        ], $data);
        
        Log::info('Action sensible effectuée', $logData);
    }

    /**
     * Vérifier si une requête est sécurisée (HTTPS)
     *
     * @param Request|null $request
     * @return bool
     */
    public static function isSecureRequest(?Request $request = null): bool
    {
        $request = $request ?? request();
        return $request->isSecure() || app()->environment('local');
    }

    /**
     * Vérifier si une requête provient d'un domaine autorisé
     *
     * @param Request|null $request
     * @return bool
     */
    public static function isAllowedReferrer(?Request $request = null): bool
    {
        $request = $request ?? request();
        $referrer = $request->header('referer');
        
        if (empty($referrer)) {
            return true; // Pas de référent, considéré comme valide
        }
        
        $host = parse_url($referrer, PHP_URL_HOST);
        $allowedDomains = Config::get('app.security.allowed_domains', []);
        $appDomain = parse_url(config('app.url'), PHP_URL_HOST);
        
        // Toujours autoriser le domaine de l'application
        $allowedDomains[] = $appDomain;
        
        foreach ($allowedDomains as $domain) {
            if ($host === $domain || Str::endsWith($host, '.' . $domain)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Vérifier si une requête est une attaque CSRF potentielle
     *
     * @param Request|null $request
     * @return bool
     */
    public static function isPotentialCsrfAttack(?Request $request = null): bool
    {
        $request = $request ?? request();
        
        // Si la méthode est sécurisée (GET, HEAD), ce n'est pas une attaque CSRF
        if (in_array($request->method(), ['GET', 'HEAD'])) {
            return false;
        }
        
        // Vérifier si la requête a un token CSRF valide
        return !$request->hasValidSignature() && !$request->hasValidRelativeSignature();
    }

    /**
     * Obtenir les en-têtes de sécurité recommandés
     *
     * @return array
     */
    public static function getSecurityHeaders(): array
    {
        // Définir le domaine principal pour les politiques
        $domain = config('app.url');
        $parsed = parse_url($domain);
        $host = $parsed['host'] ?? 'rhdp.ci';
        
        return [
            // Protection contre le MIME-sniffing
            'X-Content-Type-Options' => 'nosniff',
            
            // Protection contre le clickjacking
            'X-Frame-Options' => 'SAMEORIGIN',
            
            // Protection XSS (déprécié mais encore utile pour les anciens navigateurs)
            'X-XSS-Protection' => '1; mode=block',
            
            // Contrôle des informations de référence transmises
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            
            // En-tête de sécurité pour HTTPS strict
            'Strict-Transport-Security' => 'max-age=63072000; includeSubDomains; preload',
            
            // Politique de sécurité du contenu (CSP)
            'Content-Security-Policy' => self::getContentSecurityPolicy($host),
            
            // Politique de permissions (anciennement Feature-Policy)
            'Permissions-Policy' => 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=(), interest-cohort=()',
            
            // Protection contre le cross-site request forgery (CSRF)
            'X-CSRF-Protection' => '1',
            
            // Contrôle du cache pour les données sensibles
            'Cache-Control' => 'no-store, max-age=0',
            
            // Empêcher l'inclusion dans les iframes de sites externes
            'Cross-Origin-Opener-Policy' => 'same-origin',
            
            // Contrôle des ressources partagées entre origines (CORS)
            'Cross-Origin-Resource-Policy' => 'same-origin',
            
            // Isolation des origines
            'Cross-Origin-Embedder-Policy' => 'require-corp',
            
            // Protection contre les attaques par déni de service (DoS)
            'X-DNS-Prefetch-Control' => 'off',
        ];
    }
    
    /**
     * Générer une politique de sécurité du contenu (CSP) adaptée au site RHDP
     *
     * @param string $host Le nom d'hôte principal
     * @return string La politique CSP formatée
     */
    private static function getContentSecurityPolicy(string $host): string
    {
        // Liste des domaines externes autorisés pour diverses ressources
        $trustedScriptSources = [
            'https://www.google-analytics.com',
            'https://www.googletagmanager.com',
            'https://cdn.jsdelivr.net',
            'https://code.jquery.com',
        ];
        
        $trustedStyleSources = [
            'https://fonts.googleapis.com',
            'https://cdn.jsdelivr.net',
        ];
        
        $trustedFontSources = [
            'https://fonts.gstatic.com',
            'https://cdn.jsdelivr.net',
        ];
        
        $trustedImageSources = [
            'https:',  // Permet les images de n'importe quelle source HTTPS
            'data:',   // Permet les images en base64
        ];
        
        $trustedConnectSources = [
            'https://www.google-analytics.com',
        ];
        
        // Construction de la politique CSP
        return implode('; ', [
            // Source par défaut: uniquement depuis le même domaine
            "default-src 'self'",
            
            // Scripts: domaine principal + sources externes approuvées + inline nécessaire pour certaines fonctionnalités
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' " . implode(' ', $trustedScriptSources),
            
            // Styles: domaine principal + sources externes approuvées + inline pour le styling dynamique
            "style-src 'self' 'unsafe-inline' " . implode(' ', $trustedStyleSources),
            
            // Images: domaine principal + sources externes approuvées
            "img-src 'self' " . implode(' ', $trustedImageSources),
            
            // Polices: domaine principal + sources externes approuvées
            "font-src 'self' " . implode(' ', $trustedFontSources),
            
            // Connexions: domaine principal + APIs externes
            "connect-src 'self' " . implode(' ', $trustedConnectSources),
            
            // Frames: uniquement depuis le même domaine
            "frame-ancestors 'self'",
            
            // Actions de formulaire: uniquement vers le même domaine
            "form-action 'self'",
            
            // Base URI: uniquement le domaine principal
            "base-uri 'self'",
            
            // Objets: bloquer par défaut (Flash, etc.)
            "object-src 'none'",
            
            // Manifest: uniquement depuis le domaine principal
            "manifest-src 'self'",
            
            // Media: uniquement depuis le domaine principal
            "media-src 'self'",
            
            // Worker: uniquement depuis le domaine principal
            "worker-src 'self'",
            
            // Rapport des violations CSP vers notre endpoint dédié
            "report-uri /api/csp-report",
            
            // Upgrade-Insecure-Requests: force les requêtes HTTP à être mises à niveau vers HTTPS
            "upgrade-insecure-requests"
        ]);
    }

    /**
     * Appliquer les en-têtes de sécurité à une réponse
     *
     * @param \Illuminate\Http\Response $response
     * @return \Illuminate\Http\Response
     */
    public static function applySecurityHeaders($response)
    {
        $headers = self::getSecurityHeaders();
        
        foreach ($headers as $header => $value) {
            $response->header($header, $value);
        }
        
        return $response;
    }

    /**
     * Vérifier si une IP est sur la liste noire
     *
     * @param string|null $ip
     * @return bool
     */
    public static function isBlacklistedIp(?string $ip = null): bool
    {
        $ip = $ip ?? request()->ip();
        $blacklistedIps = Config::get('app.security.blacklisted_ips', []);
        
        return in_array($ip, $blacklistedIps);
    }

    /**
     * Vérifier si un utilisateur a dépassé le nombre de tentatives autorisées pour une action
     *
     * @param string $action
     * @param int $maxAttempts
     * @param int $decayMinutes
     * @return bool
     */
    public static function hasTooManyAttempts(string $action, int $maxAttempts = 5, int $decayMinutes = 1): bool
    {
        $key = 'security:' . $action . ':' . (Auth::id() ?? request()->ip());
        
        return app('cache')->get($key, 0) >= $maxAttempts;
    }

    /**
     * Incrémenter le compteur de tentatives pour une action
     *
     * @param string $action
     * @param int $decayMinutes
     * @return void
     */
    public static function incrementAttempts(string $action, int $decayMinutes = 1): void
    {
        $key = 'security:' . $action . ':' . (Auth::id() ?? request()->ip());
        
        app('cache')->put(
            $key,
            app('cache')->get($key, 0) + 1,
            now()->addMinutes($decayMinutes)
        );
    }

    /**
     * Réinitialiser le compteur de tentatives pour une action
     *
     * @param string $action
     * @return void
     */
    public static function resetAttempts(string $action): void
    {
        $key = 'security:' . $action . ':' . (Auth::id() ?? request()->ip());
        
        app('cache')->forget($key);
    }
}
