<div class="space-y-4">
    @foreach($attachments as $attachment)
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 group" data-attachment-id="{{ $attachment['id'] }}">
            <div class="flex items-center space-x-3">
                @php
                    $icon = match(pathinfo($attachment['name'], PATHINFO_EXTENSION)) {
                        'pdf' => 'file-pdf',
                        'doc', 'docx' => 'file-word',
                        'xls', 'xlsx' => 'file-excel',
                        'jpg', 'jpeg', 'png', 'gif' => 'file-image',
                        'zip', 'rar', '7z' => 'file-archive',
                        default => 'file-alt'
                    };
                @endphp
                
                <div class="flex-shrink-0 text-gray-500">
                    <i class="fas fa-{{ $icon }} text-xl"></i>
                </div>
                
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $attachment['name'] }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $attachment['size'] }}
                    </p>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <a 
                    href="{{ $attachment['url'] }}" 
                    target="_blank"
                    class="text-gray-400 hover:text-orange-500 transition-colors duration-200"
                    title="Voir le fichier"
                >
                    <i class="fas fa-eye"></i>
                </a>
                <a 
                    href="{{ route('mediatheque.communiques.download', ['communique' => $record->id, 'attachment' => $attachment['id']]) }}" 
                    class="text-gray-400 hover:text-orange-500 transition-colors duration-200"
                    title="Télécharger le fichier"
                >
                    <i class="fas fa-download"></i>
                </a>
                <button 
                    type="button"
                    class="text-gray-400 hover:text-red-500 transition-colors duration-200 delete-attachment"
                    title="Supprimer le fichier"
                    data-url="{{ route('communiques.attachments.destroy', ['communique' => $record->id, 'attachment' => $attachment['id']]) }}"
                >
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la suppression d'une pièce jointe
    document.querySelectorAll('.delete-attachment').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce fichier ? Cette action est irréversible.')) {
                return;
            }
            
            const url = this.getAttribute('data-url');
            const attachmentItem = this.closest('[data-attachment-id]');
            const attachmentId = attachmentItem ? attachmentItem.getAttribute('data-attachment-id') : null;
            
            if (!url || !attachmentId) {
                console.error('URL ou ID de pièce jointe manquant');
                return;
            }
            
            // Afficher un indicateur de chargement
            const originalContent = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
            
            // Envoyer la requête de suppression
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la suppression du fichier');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Supprimer l'élément du DOM
                    if (attachmentItem) {
                        attachmentItem.remove();
                        
                        // Mettre à jour l'interface si nécessaire
                        const attachmentsContainer = document.querySelector('.attachments-container');
                        if (attachmentsContainer && attachmentsContainer.children.length === 0) {
                            // Rediriger ou masquer la section si plus de pièces jointes
                            window.location.reload();
                        }
                    }
                } else {
                    throw new Error(data.message || 'Erreur lors de la suppression du fichier');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la suppression du fichier : ' + error.message);
                this.innerHTML = originalContent;
                this.disabled = false;
            });
        });
    });
});
</script>
@endpush
