<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as FilamentLogin;
use Illuminate\Support\Facades\Route;

class Login extends FilamentLogin
{
    // Personnaliser la page de login si nécessaire
    protected static string $view = 'filament.pages.auth.login';

    // Ajouter cette méthode pour le debugging
    public static function getRouteName(): string
    {
        return 'filament.admin.auth.login';
    }

    // Désactiver la génération automatique de routes pour éviter les conflits
    public static function getRoutes(): \Closure
    {
        return function () {
            // Ne rien faire ici, car nous gérons les routes manuellement dans web.php
        };
    }

    public function mount(): void
    {
        parent::mount();

        if (auth()->check()) {
            redirect()->intended(static::getUrl());
        }
    }
} 