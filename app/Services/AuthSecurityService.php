<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class AuthSecurityService
{
    /**
     * Nombre maximum de tentatives de connexion avant blocage temporaire
     */
    const MAX_LOGIN_ATTEMPTS = 5;
    
    /**
     * Durée de blocage après trop de tentatives (en minutes)
     */
    const LOCKOUT_DURATION = 10;
    
    /**
     * Durée minimale d'un mot de passe (en caractères)
     */
    const MIN_PASSWORD_LENGTH = 12;
    
    /**
     * Vérifie si une adresse IP a dépassé le nombre de tentatives de connexion autorisées
     *
     * @param string $ip Adresse IP
     * @return bool
     */
    public static function hasTooManyLoginAttempts(string $ip): bool
    {
        $key = self::getLoginThrottleKey($ip);
        return RateLimiter::tooManyAttempts($key, self::MAX_LOGIN_ATTEMPTS);
    }
    
    /**
     * Incrémente le compteur de tentatives de connexion pour une adresse IP
     *
     * @param string $ip Adresse IP
     * @return void
     */
    public static function incrementLoginAttempts(string $ip): void
    {
        $key = self::getLoginThrottleKey($ip);
        RateLimiter::hit($key, self::LOCKOUT_DURATION * 60);
    }
    
    /**
     * Réinitialise le compteur de tentatives de connexion pour une adresse IP
     *
     * @param string $ip Adresse IP
     * @return void
     */
    public static function clearLoginAttempts(string $ip): void
    {
        $key = self::getLoginThrottleKey($ip);
        RateLimiter::clear($key);
    }
    
    /**
     * Retourne le temps restant avant la fin du blocage (en secondes)
     *
     * @param string $ip Adresse IP
     * @return int
     */
    public static function getSecondsUntilUnlock(string $ip): int
    {
        $key = self::getLoginThrottleKey($ip);
        return RateLimiter::availableIn($key);
    }
    
    /**
     * Génère une clé unique pour le rate limiter
     *
     * @param string $ip Adresse IP
     * @return string
     */
    private static function getLoginThrottleKey(string $ip): string
    {
        return 'login_attempts:' . $ip;
    }
    
    /**
     * Vérifie si un mot de passe respecte les critères de sécurité
     *
     * @param string $password Mot de passe à vérifier
     * @return array Tableau contenant le résultat (valid) et les erreurs éventuelles (errors)
     */
    public static function validatePasswordStrength(string $password): array
    {
        $errors = [];
        
        // Vérifier la longueur minimale
        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            $errors[] = 'Le mot de passe doit contenir au moins ' . self::MIN_PASSWORD_LENGTH . ' caractères.';
        }
        
        // Vérifier la présence de lettres majuscules
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
        }
        
        // Vérifier la présence de lettres minuscules
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre minuscule.';
        }
        
        // Vérifier la présence de chiffres
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un chiffre.';
        }
        
        // Vérifier la présence de caractères spéciaux
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un caractère spécial.';
        }
        
        // Vérifier si le mot de passe ne contient pas de séquences communes
        $commonSequences = ['123456', 'abcdef', 'qwerty', 'azerty', 'password', 'admin'];
        foreach ($commonSequences as $sequence) {
            if (stripos($password, $sequence) !== false) {
                $errors[] = 'Le mot de passe ne doit pas contenir de séquences communes comme "' . $sequence . '".';
                break;
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
    
    /**
     * Journalise une tentative de connexion réussie
     *
     * @param User $user Utilisateur connecté
     * @param Request $request Requête HTTP
     * @return void
     */
    public static function logSuccessfulLogin(User $user, Request $request): void
    {
        // Mettre à jour la date de dernière connexion
        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->ip();
        $user->save();
        
        // Journaliser la connexion
        Log::info('Connexion réussie', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        // Réinitialiser le compteur de tentatives
        self::clearLoginAttempts($request->ip());
    }
    
    /**
     * Journalise une tentative de connexion échouée
     *
     * @param string $email Email utilisé
     * @param Request $request Requête HTTP
     * @param string $reason Raison de l'échec
     * @return void
     */
    public static function logFailedLogin(string $email, Request $request, string $reason): void
    {
        // Journaliser l'échec
        Log::warning('Tentative de connexion échouée', [
            'email' => $email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'reason' => $reason
        ]);
        
        // Incrémenter le compteur de tentatives
        self::incrementLoginAttempts($request->ip());
    }
    
    /**
     * Vérifie si un compte utilisateur est verrouillé
     *
     * @param User $user Utilisateur à vérifier
     * @return bool
     */
    public static function isAccountLocked(User $user): bool
    {
        return $user->locked_until && Carbon::now()->lt($user->locked_until);
    }
    
    /**
     * Verrouille un compte utilisateur
     *
     * @param User $user Utilisateur à verrouiller
     * @param int $minutes Durée du verrouillage en minutes
     * @param string $reason Raison du verrouillage
     * @return void
     */
    public static function lockAccount(User $user, int $minutes, string $reason): void
    {
        $user->locked_until = Carbon::now()->addMinutes($minutes);
        $user->lock_reason = $reason;
        $user->save();
        
        Log::warning('Compte utilisateur verrouillé', [
            'user_id' => $user->id,
            'email' => $user->email,
            'duration' => $minutes,
            'reason' => $reason
        ]);
    }
    
    /**
     * Déverrouille un compte utilisateur
     *
     * @param User $user Utilisateur à déverrouiller
     * @return void
     */
    public static function unlockAccount(User $user): void
    {
        $user->locked_until = null;
        $user->lock_reason = null;
        $user->save();
        
        Log::info('Compte utilisateur déverrouillé', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);
    }
    
    /**
     * Vérifie si un utilisateur a le rôle d'administrateur
     *
     * @param User|null $user Utilisateur à vérifier
     * @return bool
     */
    public static function isAdmin(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        
        return $user->hasAnyRole(['super-admin', 'admin']);
    }
    
    /**
     * Génère un mot de passe aléatoire fort
     *
     * @return string
     */
    public static function generateStrongPassword(): string
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';
        
        $password = '';
        
        // Au moins une majuscule
        $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
        
        // Au moins une minuscule
        $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
        
        // Au moins un chiffre
        $password .= $numbers[rand(0, strlen($numbers) - 1)];
        
        // Au moins un caractère spécial
        $password .= $specialChars[rand(0, strlen($specialChars) - 1)];
        
        // Compléter avec des caractères aléatoires
        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        for ($i = 0; $i < self::MIN_PASSWORD_LENGTH - 4; $i++) {
            $password .= $allChars[rand(0, strlen($allChars) - 1)];
        }
        
        // Mélanger le mot de passe
        return str_shuffle($password);
    }
}
