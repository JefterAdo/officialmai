<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    /**
     * Redirige vers la page de connexion Filament.
     */
    public function login()
    {
        // Redirection directe vers la page de connexion admin sans utiliser les routes nommées
        return redirect('/admin/login');
    }

    /**
     * Redirige vers la page d'accueil après déconnexion.
     */
    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }
}
