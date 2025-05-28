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
        return [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self'; frame-ancestors 'self'; form-action 'self';",
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        ];
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
