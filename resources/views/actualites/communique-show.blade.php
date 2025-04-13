@extends('layouts.app')

@section('title', $communique->title . ' - RHDP')

@push('styles')
<style>
    .communique-header {
        background-color: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .communique-title {
        color: #FF8C00;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .communique-meta {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .communique-content {
        line-height: 1.8;
        color: #212529;
    }
    
    /* Masquer les noms de fichiers et légendes d'images */
    .communique-content img + figcaption,
    .communique-content img + br + small,
    .communique-content figure figcaption,
    .communique-content figure + p > small,
    .communique-content p > img + small,
    .communique-content p > small:has(+ img),
    .communique-content img + small,
    .communique-content img + p > small,
    .communique-content img + a,
    .communique-content img + .image-name,
    .communique-content p:has(> img) + p:has(> small) {
        display: none !important;
    }
    
    /* S'assurer que les images sont bien affichées */
    .communique-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem 0;
        border-radius: 0.5rem;
    }

    .file-download {
        margin-top: 2rem;
        padding: 2rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
    }

    .file-download-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #FF8C00;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .file-info i {
        font-size: 2rem;
        color: #6c757d;
    }

    .file-details {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .download-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #FF8C00;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .download-button:hover {
        background-color: #e67e00;
        color: white;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        text-decoration: none;
        margin-bottom: 2rem;
    }

    .back-link:hover {
        color: #FF8C00;
    }
</style>
@endpush

@section('content')
<main class="container mx-auto px-4 py-8">
    <a href="{{ route('actualites.communiques') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Retour aux communiqués
    </a>

    <article>
        <header class="communique-header">
            <div class="container">
                <h1 class="communique-title">{{ $communique->title }}</h1>
                <div class="communique-meta">
                    Publié le {{ $communique->published_at->locale('fr')->isoFormat('LL') }}
                </div>
            </div>
        </header>

        <div class="container">
            @if($communique->content)
                <div class="communique-content">
                    {!! $communique->content !!}
                </div>
            @endif

            @if($communique->file_path)
                <div class="file-download">
                    <h2 class="file-download-title">Télécharger le communiqué</h2>
                    <div class="file-info">
                        @php
                            $iconClass = match($communique->file_type) {
                                'pdf' => 'fas fa-file-pdf',
                                'docx' => 'fas fa-file-word',
                                'doc' => 'fas fa-file-word',
                                'image' => 'fas fa-file-image',
                                default => 'fas fa-file'
                            };
                        @endphp
                        <i class="{{ $iconClass }}"></i>
                        <div class="file-details">
                            <div>{{ strtoupper($communique->file_type) }}</div>
                            <div>{{ $communique->getHumanFileSize() }}</div>
                        </div>
                    </div>
                    <a href="{{ $communique->getFileUrl() }}" class="download-button" download>
                        <i class="fas fa-download"></i>
                        Télécharger
                    </a>
                </div>
            @endif
        </div>
    </article>
</main>