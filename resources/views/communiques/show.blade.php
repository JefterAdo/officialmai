@extends('layouts.app')

@section('title', $communique->title . ' | Communiqués | Médiathèque RHDP')

@push('styles')
<style>
    /* Définition explicite de la variable primary-color */
    :root {
        --primary-color: #FF6B00;
    }
    
    /* Styles spécifiques pour la page d'un communiqué */
    .communique-header {
        background-color: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 3px solid var(--primary-color);
    }
    
    .communique-title {
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    
    .communique-meta {
        color: #718096;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
    
    .document-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .document-embed {
        width: 100%;
        min-height: 70vh;
        border: none;
    }
    
    .document-actions {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #4a5568;
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: color 0.2s ease;
    }
    
    .btn-back:hover {
        color: var(--primary-color);
    }
    
    .document-description {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .document-download-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background-color: var(--primary-color) !important;
        color: white !important;
        border-radius: 0.375rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
        margin-top: 1rem;
        opacity: 1 !important;
        border: 1px solid var(--primary-color) !important;
    }
    
    .document-download-btn:hover {
        background-color: #d85a00 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(242, 140, 3, 0.2);
        color: white !important;
        border-color: #d85a00 !important;
    }
    
    .document-info {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        margin-bottom: 0.5rem;
    }
    
    .info-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }
    
    .info-value {
        color: #2d3748;
        font-size: 1rem;
    }
</style>
@endpush

@section('content')
<div class="communique-header">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('communiques.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Retour aux communiqués
        </a>
        <h1 class="text-3xl md:text-4xl font-bold communique-title">{{ $communique->title }}</h1>
        <div class="communique-meta">
            Publié le {{ $communique->published_at ? $communique->published_at->isoFormat('LL', 'fr') : 'Date non disponible' }}
        </div>
    </div>
</div>

<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-5xl mx-auto">
        @if($communique->content)
            <div class="document-description">
                <h2 class="text-xl font-semibold mb-3">À propos de ce communiqué</h2>
                <div class="prose max-w-none">
                    {!! $communique->content !!}
                </div>
            </div>
        @endif
        
        @if($communique->attachments->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Aucun fichier n'est associé à ce communiqué.
                        </p>
                    </div>
                </div>
            </div>
        @else
            @foreach($communique->attachments as $index => $attachment)
                <div class="document-container mb-8">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Pièce jointe #{{ $index + 1 }}</h3>
                        <a href="{{ route('communiques.show', ['slug' => $communique->slug, 'download' => 1, 'attachment' => $attachment->id]) }}" 
                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <i class="fas fa-download mr-1"></i>
                            Télécharger
                        </a>
                    </div>
                    
                    @if(in_array($attachment->file_type, ['pdf', 'application/pdf']))
                        <iframe 
                            src="{{ $attachment->full_url }}#toolbar=1&view=FitH" 
                            class="document-embed"
                            frameborder="0">
                        </iframe>
                    @elseif(in_array($attachment->file_type, ['jpg', 'jpeg', 'png', 'gif', 'image/jpeg', 'image/png', 'image/gif']))
                        <img 
                            src="{{ $attachment->full_url }}" 
                            alt="{{ $attachment->original_name }}" 
                            class="w-full h-auto">
                    @else
                        <div class="p-8 text-center">
                            <i class="fas fa-file-alt text-6xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-4">Ce type de fichier ne peut pas être prévisualisé.</p>
                            <p class="text-sm text-gray-500">{{ $attachment->original_name }}</p>
                        </div>
                    @endif
                    
                    <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                        <div class="flex flex-wrap items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                    {{ strtoupper($attachment->file_type) }}
                                </span>
                                <span>{{ $attachment->human_readable_size }}</span>
                            </div>
                            <div>
                                Téléchargé {{ $attachment->download_count }} {{ Str::plural('fois', $attachment->download_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        
        <div class="flex flex-wrap items-center justify-between mt-6">
            <a href="{{ route('communiques.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
            
            @if(!$communique->attachments->isEmpty() && $communique->attachments->count() >= 1)
                <div class="flex space-x-3">
                    <a href="{{ route('communiques.show', ['slug' => $communique->slug, 'download' => 1]) }}" 
                       class="document-download-btn">
                        <i class="fas fa-download"></i>
                        Télécharger tout (ZIP)
                    </a>
                </div>
            @endif
        </div>
        
        <div class="document-info mt-8">
            <h2 class="text-xl font-semibold mb-4">Informations</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nombre de fichiers</div>
                    <div class="info-value">{{ $communique->attachments->count() }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date de publication</div>
                    <div class="info-value">{{ $communique->published_at ? $communique->published_at->isoFormat('LL', 'fr') : 'Non spécifiée' }}</div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Le JavaScript pour forcer le téléchargement a été supprimé car géré côté serveur.
</script>
@endpush
