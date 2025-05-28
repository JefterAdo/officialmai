<?php

namespace App\Policies;

use App\Models\Communique;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class CommuniquePolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir la liste des communiqués.
     *
     * @param  \App\Models\User|null  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        // Tout le monde peut voir la liste des communiqués publics
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir un communiqué spécifique.
     *
     * @param  \App\Models\User|null  $user
     * @param  \App\Models\Communique  $communique
     * @return bool
     */
    public function view(?User $user, Communique $communique): bool
    {
        // Les communiqués actifs sont visibles par tous
        if ($communique->is_active) {
            return true;
        }

        // Les communiqués inactifs ne sont visibles que par les administrateurs
        return $user && $user->hasAnyRole(['super-admin', 'admin', 'editor']);
    }

    /**
     * Détermine si l'utilisateur peut créer des communiqués.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        $canCreate = $user->hasAnyRole(['super-admin', 'admin', 'editor']);
        
        if (!$canCreate) {
            Log::warning('Tentative non autorisée de création de communiqué', [
                'user_id' => $user->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canCreate;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un communiqué.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communique  $communique
     * @return bool
     */
    public function update(User $user, Communique $communique): bool
    {
        // Les super-admins et admins peuvent modifier tous les communiqués
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }
        
        // Les éditeurs ne peuvent modifier que les communiqués qu'ils ont créés
        $canUpdate = $user->hasRole('editor') && $communique->user_id === $user->id;
        
        if (!$canUpdate) {
            Log::warning('Tentative non autorisée de modification de communiqué', [
                'user_id' => $user->id,
                'communique_id' => $communique->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canUpdate;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un communiqué.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communique  $communique
     * @return bool
     */
    public function delete(User $user, Communique $communique): bool
    {
        // Seuls les super-admins et admins peuvent supprimer des communiqués
        $canDelete = $user->hasAnyRole(['super-admin', 'admin']);
        
        if (!$canDelete) {
            Log::warning('Tentative non autorisée de suppression de communiqué', [
                'user_id' => $user->id,
                'communique_id' => $communique->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canDelete;
    }

    /**
     * Détermine si l'utilisateur peut restaurer un communiqué supprimé.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communique  $communique
     * @return bool
     */
    public function restore(User $user, Communique $communique): bool
    {
        // Seuls les super-admins peuvent restaurer des communiqués supprimés
        return $user->hasRole('super-admin');
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement un communiqué.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Communique  $communique
     * @return bool
     */
    public function forceDelete(User $user, Communique $communique): bool
    {
        // Seuls les super-admins peuvent supprimer définitivement des communiqués
        return $user->hasRole('super-admin');
    }
}
