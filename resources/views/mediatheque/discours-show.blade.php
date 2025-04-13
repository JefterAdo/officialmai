@extends('layouts.app')

@section('title', $speech->title . ' - RHDP')

@push('styles')
<style>
    .speech-header {
        background-color: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .speech-title {
        color: var(--bs-primary);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .speech-meta {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .speech-content {
        line-height: 1.8;
        color: #212529;
    }

    .media-section {
        margin: 2rem 0;
        padding: 2rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
    }

    .media-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--bs-primary);
    }

    .file-download {
        margin-top: 2rem;
        padding: 2rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
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
        background-color: var(--bs-primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .download-button:hover {
        background-color: var(--bs-primary-dark);
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
        color: var(--bs-primary);
    }

    .related-speeches {
        margin-top: 3rem;
        padding-top: 3rem;
        border-top: 1px solid #dee2e6;
    }

    .related-speech-card {
        transition: transform 0.3s ease;
    }

    .related-speech-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('content')
<main class="container py-5">
    <a href="{{ route('mediatheque.discours') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Retour aux discours
    </a>

    <article>
        <header class="speech-header">
            <div class="container">
                <h1 class="speech-title">{{ $speech->title }}</h1>
                <div class="speech-meta">
                    <div class="mb-2">
                        <strong>Par :</strong> {{ $speech->speaker }}
                    </div>
                    <div class="mb-2">
                        <strong>Date :</strong> {{ $speech->speech_date->locale('fr')->isoFormat('LL') }}
                    </div>
                    @if($speech->location)
                        <div>
                            <strong>Lieu :</strong> {{ $speech->location }}
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <div class="container">
            @if($speech->video_url)
                <div class="media-section">
                    <h2 class="media-title">Vidéo du discours</h2>
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ $speech->getYoutubeEmbedUrl() }}" 
                                title="{{ $speech->title }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                    </div>
                </div>
            @endif

            @if($speech->audio_url)
                <div class="media-section">
                    <h2 class="media-title">Audio du discours</h2>
                    <audio controls class="w-100">
                        <source src="{{ $speech->audio_url }}" type="audio/mpeg">
                        Votre navigateur ne supporte pas l'élément audio.
                    </audio>
                </div>
            @endif

            @if($speech->content)
                <div class="speech-content">
                    {!! $speech->content !!}
                </div>
            @endif

            @if($speech->file_path)
                <div class="file-download">
                    <h2 class="media-title">Télécharger le discours</h2>
                    <div class="file-info">
                        @php
                            $iconClass = match($speech->file_type) {
                                'pdf' => 'fas fa-file-pdf',
                                'docx' => 'fas fa-file-word',
                                'doc' => 'fas fa-file-word',
                                default => 'fas fa-file'
                            };
                        @endphp
                        <i class="{{ $iconClass }}"></i>
                        <div class="file-details">
                            <div>{{ strtoupper($speech->file_type) }}</div>
                            <div>{{ $speech->getHumanFileSize() }}</div>
                        </div>
                    </div>
                    <a href="{{ $speech->getFileUrl() }}" class="download-button" download>
                        <i class="fas fa-download"></i>
                        Télécharger
                    </a>
                </div>
            @endif
        </div>
    </article>

    @if($relatedSpeeches->isNotEmpty())
        <section class="related-speeches">
            <div class="container">
                <h2 class="h3 mb-4">Discours similaires</h2>
                <div class="row g-4">
                    @foreach($relatedSpeeches as $relatedSpeech)
                        <div class="col-md-4">
                            <div class="card h-100 related-speech-card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $relatedSpeech->title }}</h5>
                                    <p class="card-text speech-meta">
                                        {{ $relatedSpeech->speech_date->locale('fr')->isoFormat('LL') }}
                                    </p>
                                    <a href="{{ route('mediatheque.discours.show', $relatedSpeech->slug) }}" class="btn btn-outline-primary">
                                        Lire le discours
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@endsection 