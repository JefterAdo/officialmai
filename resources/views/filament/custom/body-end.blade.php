<!-- Scripts personnalisés pour l'administration -->
<script>
    // Configuration globale
    window.adminConfig = {
        baseUrl: '{{ config('app.url') }}',
        csrfToken: '{{ csrf_token() }}',
        debug: {{ config('app.debug') ? 'true' : 'false' }},
        user: @json(auth()->user() ?? null)
    };

    // Gestionnaire d'erreurs personnalisé
    window.addEventListener('error', function(e) {
        if (window.adminConfig.debug) {
            console.error('Erreur JavaScript:', e.message);
        }
    });

    // Amélioration de l'expérience utilisateur
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter une confirmation avant de quitter un formulaire modifié
        window.addEventListener('beforeunload', function(e) {
            if (document.querySelector('form[data-dirty="true"]')) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Marquer les formulaires comme modifiés
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('change', function() {
                this.dataset.dirty = 'true';
            });
            form.addEventListener('submit', function() {
                this.dataset.dirty = 'false';
            });
        });
    });
</script>

<!-- Styles personnalisés pour l'administration -->
<style>
    /* Améliorations visuelles */
    .filament-sidebar-nav {
        scrollbar-width: thin;
    }

    .filament-sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .filament-sidebar-nav::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
    }

    .filament-sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
    }

    /* Animations douces */
    .filament-sidebar-nav .transition {
        transition-duration: 200ms;
    }

    /* Amélioration de la lisibilité des formulaires */
    .filament-forms-field-wrapper {
        margin-bottom: 1.5rem;
    }

    .filament-forms-field-wrapper label {
        font-weight: 500;
    }

    /* Style des boutons d'action */
    .filament-button {
        transition: all 0.2s ease;
    }

    .filament-button:hover {
        transform: translateY(-1px);
    }
</style> 