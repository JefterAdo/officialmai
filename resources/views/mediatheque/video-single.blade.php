@extends('layouts.app')

@section('title', $video['snippet']['title'] . ' - RHDP')
@section('meta_description', Str::limit($video['snippet']['description'], 160))

@section('content')
<section class="video-detail-section py-5">
    <div class="container">
        <!-- Vidéo principale -->
        <div class="row">
            <div class="col-lg-8">
                <div class="main-video-container mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ $video['id'] }}" 
                                title="{{ $video['snippet']['title'] }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                    </div>
                </div>
                
                <div class="video-info mb-4">
                    <h1 class="video-title h3 mb-3">{{ $video['snippet']['title'] }}</h1>
                    
                    <div class="video-meta d-flex flex-wrap align-items-center mb-3">
                        <div class="me-4 mb-2">
                            <i class="far fa-calendar-alt text-primary me-2"></i>
                            <span class="text-muted">Publié le {{ \Carbon\Carbon::parse($video['snippet']['publishedAt'])->format('d F Y') }}</span>
                        </div>
                        
                        @if(isset($video['statistics']['viewCount']))
                        <div class="me-4 mb-2">
                            <i class="far fa-eye text-primary me-2"></i>
                            <span class="text-muted">{{ number_format($video['statistics']['viewCount']) }} vues</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="video-description mb-4">
                        <h5 class="mb-3">Description</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($video['snippet']['description'])) !!}
                        </div>
                    </div>
                    
                    <div class="video-share mb-4">
                        <h5 class="mb-3">Partager</h5>
                        <div class="d-flex flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.youtube.com/watch?v={{ $video['id'] }}" 
                               target="_blank" 
                               class="btn btn-outline-primary me-2 mb-2">
                                <i class="fab fa-facebook-f me-2"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=https://www.youtube.com/watch?v={{ $video['id'] }}&text={{ urlencode($video['snippet']['title']) }}" 
                               target="_blank" 
                               class="btn btn-outline-info me-2 mb-2">
                                <i class="fab fa-twitter me-2"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($video['snippet']['title'] . ' - https://www.youtube.com/watch?v=' . $video['id']) }}" 
                               target="_blank" 
                               class="btn btn-outline-success me-2 mb-2">
                                <i class="fab fa-whatsapp me-2"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Vidéos connexes -->
            <div class="col-lg-4">
                <div class="related-videos">
                    <h4 class="mb-4">Vidéos similaires</h4>
                    
                    @if(!empty($relatedVideos))
                        @foreach($relatedVideos as $relatedVideo)
                            <div class="related-video-card mb-3">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <div class="related-thumbnail position-relative">
                                            <img src="{{ $relatedVideo['snippet']['thumbnails']['medium']['url'] }}" 
                                                 class="img-fluid rounded" 
                                                 alt="{{ $relatedVideo['snippet']['title'] }}">
                                            <div class="play-overlay">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body py-0 px-3">
                                            <h6 class="card-title mb-1">
                                                <a href="{{ route('mediatheque.videos.show', $relatedVideo['id']['videoId']) }}" 
                                                   class="text-decoration-none text-dark">
                                                    {{ Str::limit($relatedVideo['snippet']['title'], 50) }}
                                                </a>
                                            </h6>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($relatedVideo['snippet']['publishedAt'])->format('d F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            Aucune vidéo similaire disponible.
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('mediatheque.videos') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-th-large me-2"></i> Voir toutes les vidéos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .video-title {
        font-weight: 700;
        color: #333;
    }
    
    .video-meta {
        color: #6c757d;
    }
    
    .video-description {
        line-height: 1.6;
    }
    
    .related-thumbnail {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16 / 9;
    }
    
    .related-thumbnail img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    .play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .related-thumbnail:hover .play-overlay {
        opacity: 1;
    }
    
    .related-video-card {
        transition: transform 0.3s ease;
    }
    
    .related-video-card:hover {
        transform: translateY(-3px);
    }
</style>
@endpush
