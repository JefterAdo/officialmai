<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir la liste des documents.
     *
     * @param  \App\Models\User|null  $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        // Tout le monde peut voir la liste des documents publics
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir un document spécifique.
     *
     * @param  \App\Models\User|null  $user
     * @param  \App\Models\Document  $document
     * @return bool
     */
    public function view(?User $user, Document $document): bool
    {
        // Les documents actifs sont visibles par tous
        if ($document->is_active) {
            return true;
        }

        // Les documents inactifs ne sont visibles que par les administrateurs
        return $user && $user->hasAnyRole(['super-admin', 'admin', 'editor']);
    }

    /**
     * Détermine si l'utilisateur peut télécharger un document.
     *
     * @param  \App\Models\User|null  $user
     * @param  \App\Models\Document  $document
     * @return bool
     */
    public function download(?User $user, Document $document): bool
    {
        // Seuls les documents actifs peuvent être téléchargés
        if (!$document->is_active) {
            Log::warning('Tentative de téléchargement d\'un document inactif', [
                'document_id' => $document->id,
                'user_id' => $user ? $user->id : null,
                'ip' => request()->ip()
            ]);
            return false;
        }

        // Si le document est public, tout le monde peut le télécharger
        if ($document->is_public) {
            return true;
        }

        // Si le document est privé, seuls les utilisateurs connectés peuvent le télécharger
        return $user !== null;
    }

    /**
     * Détermine si l'utilisateur peut créer des documents.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        $canCreate = $user->hasAnyRole(['super-admin', 'admin', 'editor']);
        
        if (!$canCreate) {
            Log::warning('Tentative non autorisée de création de document', [
                'user_id' => $user->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canCreate;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return bool
     */
    public function update(User $user, Document $document): bool
    {
        // Les super-admins et admins peuvent modifier tous les documents
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }
        
        // Les éditeurs ne peuvent modifier que les documents qu'ils ont créés
        $canUpdate = $user->hasRole('editor') && $document->user_id === $user->id;
        
        if (!$canUpdate) {
            Log::warning('Tentative non autorisée de modification de document', [
                'user_id' => $user->id,
                'document_id' => $document->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canUpdate;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return bool
     */
    public function delete(User $user, Document $document): bool
    {
        // Seuls les super-admins et admins peuvent supprimer des documents
        $canDelete = $user->hasAnyRole(['super-admin', 'admin']);
        
        if (!$canDelete) {
            Log::warning('Tentative non autorisée de suppression de document', [
                'user_id' => $user->id,
                'document_id' => $document->id,
                'ip' => request()->ip()
            ]);
        }
        
        return $canDelete;
    }

    /**
     * Détermine si l'utilisateur peut restaurer un document supprimé.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return bool
     */
    public function restore(User $user, Document $document): bool
    {
        // Seuls les super-admins peuvent restaurer des documents supprimés
        return $user->hasRole('super-admin');
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement un document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return bool
     */
    public function forceDelete(User $user, Document $document): bool
    {
        // Seuls les super-admins peuvent supprimer définitivement des documents
        return $user->hasRole('super-admin');
    }
}
