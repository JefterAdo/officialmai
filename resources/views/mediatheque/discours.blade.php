@extends('layouts.app')

@section('title', 'Discours - RHDP')

@push('styles')
<style>
    .speech-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .speech-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .speech-meta {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .speech-excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #495057;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .file-info i {
        font-size: 1.25rem;
    }

    .video-badge, .audio-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
    }

    .video-badge {
        background-color: #FF6B00;
        color: white;
    }

    .audio-badge {
        background-color: #FF6B00;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container mt-5 mb-4">
    <div class="row">
        <div class="col-12 text-center">
            <h5 class="sub-title" style="color: #FF6B00;">MÉDIATHÈQUE</h5>
            <h1 class="section-title fw-bold mb-3" style="color: #FF6B00;">Discours Officiels</h1>
            <p class="section-subtitle lead text-muted">Retrouvez les discours marquants des figures clés du RHDP.</p>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <!-- Section title supprimé, déjà présent dans l'en-tête -->

        <div class="row g-4">
            @forelse($speeches as $speech)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 speech-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $speech->title }}</h5>
                            <div class="speech-meta mb-3">
                                <div><strong>Par :</strong> {{ $speech->speaker }}</div>
                                <div><strong>Date :</strong> {{ $speech->speech_date->locale('fr')->isoFormat('LL') }}</div>
                                @if($speech->location)
                                    <div><strong>Lieu :</strong> {{ $speech->location }}</div>
                                @endif
                            </div>

                            @if($speech->excerpt)
                                <p class="speech-excerpt mb-3">{{ $speech->excerpt }}</p>
                            @endif

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @if($speech->video_url)
                                    <span class="video-badge">
                                        <i class="fas fa-video me-1"></i> Vidéo
                                    </span>
                                @endif
                                @if($speech->audio_url)
                                    <span class="audio-badge">
                                        <i class="fas fa-microphone me-1"></i> Audio
                                    </span>
                                @endif
                            </div>

                            @if($speech->file_path)
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
                                    <span>{{ strtoupper($speech->file_type) }} - {{ $speech->getHumanFileSize() }}</span>
                                </div>
                            @endif

                            <div class="mt-3">
                                <a href="{{ route('mediatheque.discours.show', $speech->slug) }}" class="btn" style="color: #FF6B00; border: 1px solid #FF6B00; padding: 0.5rem 1rem; font-weight: 500;">
                                    Lire le discours <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Aucun discours n'est disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>

        @if($speeches->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $speeches->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
