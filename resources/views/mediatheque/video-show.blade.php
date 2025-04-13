@extends('layouts.app')

@section('title', $video->title . ' - RHDP')

@section('content')
<div class="page-banner" style="background-image: url('{{ asset('images/banner_placeholder_2.jpg') }}');">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white">{{ $video->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('mediatheque.videos') }}">Vidéos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($video->title, 30) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Lecteur vidéo -->
                <div class="video-player-wrapper mb-4">
                    <div class="ratio ratio-16x9">
                        @if($video->video_type === 'youtube')
                            <iframe 
                                src="https://www.youtube.com/embed/{{ $video->getVideoIdFromUrl() }}" 
                                title="{{ $video->title }}"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        @endif
                    </div>
                </div>

                <!-- Informations de la vidéo -->
                <div class="video-info mb-4">
                    <h2>{{ $video->title }}</h2>
                    <div class="video-meta text-muted mb-3">
                        <span><i class="far fa-calendar-alt"></i> {{ $video->published_at->format('d/m/Y') }}</span>
                        @if($video->duration)
                            <span class="ms-3"><i class="far fa-clock"></i> {{ $video->duration }}</span>
                        @endif
                    </div>
                    @if($video->description)
                        <div class="video-description">
                            {!! nl2br(e($video->description)) !!}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Vidéos similaires -->
                <div class="related-videos">
                    <h3 class="mb-4">Vidéos similaires</h3>
                    @foreach($relatedVideos as $relatedVideo)
                        <div class="video-item-small mb-3">
                            <a href="{{ route('mediatheque.videos.show', $relatedVideo) }}" class="d-flex text-decoration-none">
                                <div class="video-thumbnail-small position-relative">
                                    <img src="{{ $relatedVideo->thumbnail }}" 
                                         alt="Vignette: {{ $relatedVideo->title }}"
                                         class="img-fluid">
                                    @if($relatedVideo->duration)
                                        <span class="video-duration">{{ $relatedVideo->duration }}</span>
                                    @endif
                                </div>
                                <div class="video-info-small ms-3">
                                    <h6 class="mb-1">{{ Str::limit($relatedVideo->title, 60) }}</h6>
                                    <small class="text-muted">
                                        {{ $relatedVideo->published_at->format('d/m/Y') }}
                                    </small>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .video-player-wrapper {
        background-color: #000;
        border-radius: 8px;
        overflow: hidden;
    }
    .video-info h2 {
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }
    .video-description {
        white-space: pre-line;
        color: #666;
    }
    .video-item-small .video-thumbnail-small {
        width: 120px;
        height: 68px;
        overflow: hidden;
        border-radius: 4px;
    }
    .video-item-small .video-thumbnail-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .video-item-small .video-duration {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 1px 4px;
        border-radius: 2px;
        font-size: 0.7rem;
    }
    .video-item-small .video-info-small {
        flex: 1;
    }
    .video-item-small .video-info-small h6 {
        color: #333;
        font-size: 0.9rem;
        line-height: 1.3;
        margin-bottom: 0.3rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .video-item-small:hover .video-info-small h6 {
        color: var(--bs-primary);
    }
</style>
@endpush 