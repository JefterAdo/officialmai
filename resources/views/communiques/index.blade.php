@extends('layouts.app')

@section('title', 'Communiqués | Médiathèque RHDP')

@push('styles')
<style>
    /* Styles spécifiques pour la page des communiqués */
    .page-header {
        background-color: #f8f9fa;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-bottom: 3px solid var(--primary-color);
        position: relative;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('/images/pattern-bg.png');
        background-size: 200px;
        opacity: 0.05;
        z-index: 0;
    }
    
    .page-header h1 {
        color: var(--primary-color);
        position: relative;
        z-index: 1;
    }
    
    .communique-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .communique-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-color);
    }
    
    .document-preview {
        height: 200px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .document-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .document-preview .file-icon {
        font-size: 4rem;
        color: var(--primary-color);
    }
    
    .document-preview .file-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .communique-card:hover .file-overlay {
        opacity: 1;
    }
    
    .file-type-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background-color: var(--primary-color);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .document-info {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .document-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #1a202c;
    }
    
    .document-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
        font-size: 0.875rem;
        color: #718096;
    }
    
    .document-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-view, .btn-download {
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        transition: all 0.2s ease;
    }
    
    .btn-view {
        background-color: #f8f9fa;
        color: #4a5568;
        border: 1px solid #e2e8f0;
    }
    
    .btn-view:hover {
        background-color: #e2e8f0;
    }
    
    .btn-download {
        background-color: var(--primary-color);
        color: white;
        border: 1px solid var(--primary-color);
    }
    
    .btn-download:hover {
        background-color: darken(#f28c03, 10%);
        border-color: darken(#f28c03, 10%);
        color: white;
    }
    
    .no-communiques {
        text-align: center;
        padding: 3rem 0;
    }
    
    .no-communiques i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
    }
    
    .no-communiques h3 {
        color: #4a5568;
        margin-bottom: 0.5rem;
    }
    
    .no-communiques p {
        color: #718096;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center" data-aos="fade-up">Communiqués Officiels</h1>
    </div>
</div>

<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <section class="mb-12 text-center" data-aos="fade-up" data-aos-delay="100">
        <p class="text-lg text-gray-700 leading-relaxed max-w-3xl mx-auto">
            Retrouvez ici tous les communiqués officiels du RHDP. Restez informé des dernières déclarations, 
            prises de position et annonces importantes du parti.
        </p>
    </section>

    <section data-aos="fade-up" data-aos-delay="200">
        @if($communiques->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($communiques as $communique)
                    <div class="communique-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="document-preview">
                            @if($communique->file_type === 'pdf' || $communique->file_type === 'application/pdf')
                                <i class="fas fa-file-pdf file-icon"></i>
                                <img src="{{ asset('images/pdf-preview.jpg') }}" alt="Aperçu PDF" class="img-fluid">
                            @elseif(in_array($communique->file_type, ['jpg', 'jpeg', 'png', 'gif', 'image/jpeg', 'image/png', 'image/gif']))
                                <img src="{{ asset('storage/' . $communique->file_path) }}" alt="{{ $communique->title }}" class="img-fluid">
                            @else
                                <i class="fas fa-file-alt file-icon"></i>
                            @endif
                            
                            <div class="file-overlay">
                                <span class="text-white font-semibold">Voir le document</span>
                            </div>
                            
                            <span class="file-type-badge">
                                {{ strtoupper($communique->file_type) }}
                            </span>
                        </div>
                        
                        <div class="document-info">
                            <h3 class="document-title">{{ $communique->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($communique->content), 150) }}
                            </p>
                            
                            <div class="document-meta">
                                <span class="text-sm text-gray-500">
                                    {{ $communique->published_at ? $communique->published_at->format('d/m/Y') : 'Date non disponible' }}
                                </span>
                                
                                <div class="document-actions">
                                    <a href="{{ route('communiques.show', $communique->slug) }}" 
                                       class="btn-view"
                                       title="Voir le communiqué">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('communiques.show', $communique->slug) }}?download=1" 
                                       class="btn-download"
                                       title="Télécharger">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $communiques->links() }}
            </div>
        @else
            <div class="no-communiques bg-white rounded-lg shadow-sm p-8">
                <i class="far fa-newspaper"></i>
                <h3 class="text-xl font-semibold">Aucun communiqué disponible pour le moment</h3>
                <p>Revenez plus tard pour consulter nos prochains communiqués.</p>
            </div>
        @endif
    </section>
</main>
@endsection

@push('scripts')
<script>
    // Script pour gérer le chargement des aperçus PDF
    document.addEventListener('DOMContentLoaded', function() {
        // Ici, vous pourriez ajouter du JavaScript pour charger les aperçus PDF
        // en utilisant une bibliothèque comme PDF.js si nécessaire
    });
</script>
@endpush
