<?php

namespace App\Filament\Pages\Auth;

use App\Services\AuthSecurityService;
use App\Services\SecurityService;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as FilamentLogin;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException; // Important pour la gestion des erreurs d'authentification

class Login extends FilamentLogin
{
    // La vue Blade que nous avons examinée.
    protected static string $view = 'filament.pages.auth.login';

    // Étape 1: Définir les champs du formulaire
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(), // Champ email standard de Filament
                $this->getPasswordFormComponent(), // Champ mot de passe standard de Filament
                $this->getRememberFormComponent(), // Case à cocher "Se souvenir de moi" standard de Filament
            ]);
    }

    // Étape 2: Implémenter la logique d'authentification avec sécurité renforcée
    // (Cette méthode surcharge la méthode authenticate() de la classe parente FilamentLogin)
    public function authenticate(): ?LoginResponse
    {
        // Récupère les données du formulaire définies dans la méthode form()
        $data = $this->form->getState();
        $email = $data['email'];
        $request = request();
        
        // Vérifier si l'adresse IP a trop de tentatives de connexion
        if (AuthSecurityService::hasTooManyLoginAttempts($request->ip())) {
            $seconds = AuthSecurityService::getSecondsUntilUnlock($request->ip());
            $minutes = ceil($seconds / 60);
            
            // Journaliser la tentative bloquée
            SecurityService::logUnauthorizedAccess('too_many_login_attempts', null, $request);
            
            throw ValidationException::withMessages([
                'data.email' => "Trop de tentatives de connexion. Veuillez réessayer dans {$minutes} minute(s).",
            ]);
        }
        
        // Tente d'authentifier l'utilisateur
        $success = auth()->attempt([
            'email' => $email,
            'password' => $data['password'],
        ], $data['remember'] ?? false); // Utilise la valeur de 'remember' ou false par défaut
        
        if (!$success) {
            // Journaliser l'échec de connexion
            AuthSecurityService::logFailedLogin($email, $request, 'Identifiants invalides');
            
            // Lance une ValidationException en cas d'échec, Filament l'affichera correctement
            throw ValidationException::withMessages([
                'data.email' => __('auth.failed'), // 'data.email' pour que le message s'affiche sous le champ email
            ]);
        }
        
        // Récupérer l'utilisateur authentifié
        $user = auth()->user();
        
        // Vérifier si le compte est verrouillé
        if (AuthSecurityService::isAccountLocked($user)) {
            // Déconnecter l'utilisateur
            auth()->logout();
            
            // Journaliser la tentative de connexion à un compte verrouillé
            SecurityService::logUnauthorizedAccess('login_to_locked_account', null, $request);
            
            throw ValidationException::withMessages([
                'data.email' => 'Ce compte est temporairement verrouillé. Veuillez contacter l\'administrateur.',
            ]);
        }
        
        // Journaliser la connexion réussie
        AuthSecurityService::logSuccessfulLogin($user, $request);
        
        // Régénère la session pour des raisons de sécurité
        session()->regenerate();
        
        // Retourne la réponse de connexion attendue par Filament
        // Cela permettra à Filament de gérer la redirection vers la page prévue (intended)
        return app(LoginResponse::class);
    }

    // Étape 3: Supprimer getRoutes() et getRouteName()
    // Nous laissons ces méthodes non définies ici pour que Filament utilise ses propres mécanismes de génération de routes.

    // Étape 4: La méthode mount() existante est correcte
    // Elle redirige si l'utilisateur est déjà authentifié.
    public function mount(): void
    {
        parent::mount(); // Appelle la méthode mount de la classe parente

        // Si l'utilisateur est déjà connecté, le rediriger vers le tableau de bord ou la page prévue
        if (auth()->check()) {
            // Utilise la méthode de Filament pour obtenir l'URL de redirection après connexion
            redirect()->intended(config('filament.home_url') ?? static::getUrl(panel: $this->getPanel()));
        }
         // S'assure que le formulaire est initialisé même si on ne le remplit pas avec des données existantes
        $this->form->fill();
    }
} 