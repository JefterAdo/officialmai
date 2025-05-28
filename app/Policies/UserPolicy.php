<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir la liste des utilisateurs.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // Seuls les administrateurs peuvent voir la liste des utilisateurs
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Détermine si l'utilisateur peut voir un utilisateur spécifique.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        // Les utilisateurs peuvent voir leur propre profil
        if ($user->id === $model->id) {
            return true;
        }
        
        // Les administrateurs peuvent voir tous les profils
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Détermine si l'utilisateur peut créer des utilisateurs.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // Seuls les super-admins peuvent créer des utilisateurs
        $canCreate = $user->hasRole('super-admin');
        
        if (!$canCreate) {
            Log::warning('Tentative non autorisée de création d\'utilisateur', [
                'user_id' => $user->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canCreate;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un utilisateur.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        // Les utilisateurs peuvent modifier leur propre profil
        if ($user->id === $model->id) {
            return true;
        }
        
        // Les super-admins peuvent modifier tous les profils
        if ($user->hasRole('super-admin')) {
            return true;
        }
        
        // Les admins peuvent modifier tous les profils sauf ceux des super-admins
        if ($user->hasRole('admin') && !$model->hasRole('super-admin')) {
            return true;
        }
        
        Log::warning('Tentative non autorisée de modification d\'utilisateur', [
            'user_id' => $user->id,
            'target_user_id' => $model->id,
            'ip' => request()->ip()
        ]);
        
        return false;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un utilisateur.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        // Les utilisateurs ne peuvent pas se supprimer eux-mêmes
        if ($user->id === $model->id) {
            return false;
        }
        
        // Les super-admins peuvent supprimer tous les utilisateurs
        if ($user->hasRole('super-admin')) {
            return true;
        }
        
        // Les admins peuvent supprimer tous les utilisateurs sauf les super-admins et les autres admins
        if ($user->hasRole('admin') && !$model->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }
        
        Log::warning('Tentative non autorisée de suppression d\'utilisateur', [
            'user_id' => $user->id,
            'target_user_id' => $model->id,
            'ip' => request()->ip()
        ]);
        
        return false;
    }

    /**
     * Détermine si l'utilisateur peut restaurer un utilisateur supprimé.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function restore(User $user, User $model): bool
    {
        // Seuls les super-admins peuvent restaurer des utilisateurs supprimés
        return $user->hasRole('super-admin');
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement un utilisateur.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Seuls les super-admins peuvent supprimer définitivement des utilisateurs
        return $user->hasRole('super-admin');
    }
    
    /**
     * Détermine si l'utilisateur peut modifier les rôles d'un utilisateur.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function manageRoles(User $user, User $model): bool
    {
        // Seuls les super-admins peuvent modifier les rôles
        $canManage = $user->hasRole('super-admin');
        
        if (!$canManage) {
            Log::warning('Tentative non autorisée de modification des rôles', [
                'user_id' => $user->id,
                'target_user_id' => $model->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canManage;
    }
    
    /**
     * Détermine si l'utilisateur peut verrouiller ou déverrouiller un compte.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function manageLock(User $user, User $model): bool
    {
        // Les utilisateurs ne peuvent pas verrouiller leur propre compte
        if ($user->id === $model->id) {
            return false;
        }
        
        // Les super-admins peuvent verrouiller tous les comptes
        if ($user->hasRole('super-admin')) {
            return true;
        }
        
        // Les admins peuvent verrouiller tous les comptes sauf ceux des super-admins
        if ($user->hasRole('admin') && !$model->hasRole('super-admin')) {
            return true;
        }
        
        Log::warning('Tentative non autorisée de verrouillage/déverrouillage de compte', [
            'user_id' => $user->id,
            'target_user_id' => $model->id,
            'ip' => request()->ip()
        ]);
        
        return false;
    }
}
