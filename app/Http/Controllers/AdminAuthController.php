<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');
        
        Log::info('Tentative de connexion admin', ['username' => $request->username]);
        
        if (Auth::guard('admin')->attempt($credentials)) {
            Log::info('Connexion admin réussie', ['username' => $request->username]);
            return redirect()->intended('/admin');
        }

        Log::error('Échec de connexion admin', ['username' => $request->username]);
        return back()->withErrors(['username' => 'Identifiants invalides'])->withInput();
    }

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin');
        }
        
        Log::info('Affichage du formulaire de connexion admin');
        return view('admin.auth.login');
    }

    public function logout()
    {
        $username = Auth::guard('admin')->user()->username ?? 'unknown';
        Auth::guard('admin')->logout();
        Log::info('Déconnexion admin', ['username' => $username]);
        return redirect('/admin/login');
    }
}
