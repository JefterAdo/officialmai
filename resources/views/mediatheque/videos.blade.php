@extends('layouts.app')

@section('title', 'Galerie Vidéos - RHDP')
@section('meta_description', 'Découvrez les discours, événements et messages importants du RHDP en vidéo')

@section('content')
<section class="video-gallery-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h5 class="sub-title" style="color: #FF6B00;">MÉDIATHÈQUE</h5>
            <h1 class="section-title fw-bold mb-3" style="color: #FF6B00;">Vidéos du RHDP</h1>
            <p class="section-subtitle lead text-muted">Découvrez les discours, événements et messages importants du parti en vidéo.</p>
        </div>

        <div class="row g-4 mb-4">
            @forelse ($videos as $video)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="video-thumbnail-card h-100 shadow rounded overflow-hidden border-0 transition-all card-hover-effect">
                        <div class="video-thumbnail position-relative">
                            <img src="{{ $video['snippet']['thumbnails']['high']['url'] }}" 
                                 class="w-100 img-fluid" 
                                 alt="Vignette: {{ $video['snippet']['title'] }}">
                            <a href="{{ route('mediatheque.videos.show', $video['id']['videoId']) }}" 
                               class="play-btn-wrapper" 
                               aria-label="Lancer la vidéo {{ $video['snippet']['title'] }}">
                                <div class="play-btn-circle" style="background-color: #FF6B00;">
                                    <i class="fas fa-play"></i>
                                </div>
                            </a>
                            <div class="video-duration position-absolute bottom-0 right-0 bg-dark text-white px-2 py-1 m-2 rounded-pill small">
                                <i class="fas fa-clock me-1"></i> YouTube
                            </div>
                        </div>
                        <div class="video-content p-3">
                            <h5 class="video-title mb-2 fw-bold" style="color: #FF6B00;">{{ Str::limit($video['snippet']['title'], 60) }}</h5>
                            <div class="video-description mb-2 small text-muted">
                                {{ Str::limit($video['snippet']['description'] ?? 'Vidéo officielle du RHDP', 100) }}
                            </div>
                            <div class="video-meta d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($video['snippet']['publishedAt'])->format('d/m/Y') }}</span>
                                <a href="{{ route('mediatheque.videos.show', $video['id']['videoId']) }}" class="btn btn-sm" style="color: #FF6B00; border: 1px solid #FF6B00;">Voir <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <div class="empty-state-icon mb-3">
                            <i class="fas fa-video fa-3x text-muted"></i>
                        </div>
                        <h4 class="empty-state-title">Aucune vidéo disponible</h4>
                        <p class="empty-state-description text-muted">Les vidéos seront disponibles prochainement. Revenez bientôt !</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="https://www.youtube.com/@rassemblementwebtv5828" target="_blank" class="btn" style="color: #FF6B00; border: 1px solid #FF6B00; padding: 0.5rem 1rem; font-weight: 500;">
                Voir toutes les vidéos sur YouTube <i class="fas fa-external-link-alt ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- Optional: Bootstrap Modal for playing videos --}}
{{-- <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Vidéo RHDP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Responsive iframe container -->
                <div class="ratio ratio-16x9">
                    <iframe class="embed-responsive-item" src="" id="videoFrame" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@push('styles')
<style>
    .video-gallery-section {
        padding: 3rem 0;
        background-color: #f8f9fa;
    }
    
    .play-btn-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.3);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .video-thumbnail-card:hover .play-btn-wrapper {
        opacity: 1;
    }
    
    .play-btn-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #FF6B00;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: transform 0.3s ease;
    }
    
    .play-btn-circle:hover {
        transform: scale(1.1);
    }
    
    .video-thumbnail img {
        transition: transform 0.5s ease;
    }
    
    .video-thumbnail-card:hover img {
        transform: scale(1.05);
    }
    
    .page-banner {
        padding: 80px 0;
        background-color: #fd7e14;
        background-size: cover;
        background-position: center;
        text-align: center;
        position: relative;
    }
    .page-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
    }
    .page-banner .container {
        position: relative;
        z-index: 1;
    }
    .page-banner h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        justify-content: center;
    }
    .breadcrumb-item a {
        color: #e9ecef;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #ffffff;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: #adb5bd;
    }
    
    /* Video Gallery Styles */
    .section-title {
        color: var(--bs-primary, #fd7e14);
        position: relative;
        margin-bottom: 1rem;
    }
    .section-subtitle {
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Styles pour les miniatures */
    .video-thumbnail-card {
        background-color: #fff;
        transition: all 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
    }
    .video-thumbnail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .video-thumbnail {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16 / 9;
    }
    .video-thumbnail img {
        transition: transform 0.5s ease;
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    .video-thumbnail-card:hover .video-thumbnail img {
        transform: scale(1.05);
    }
    
    .play-btn-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .video-thumbnail-card:hover .play-btn-wrapper {
        opacity: 1;
    }
    
    .play-btn-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--bs-primary, #fd7e14);
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 1rem;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }
    .play-btn-circle:hover {
        transform: scale(1.1);
        background-color: #e67512;
    }
    
    .video-content {
        padding: 10px;
        background-color: #fff;
    }
    
    .video-title {
        font-size: 0.9rem;
        line-height: 1.3;
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
        height: 2.6rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .video-meta {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .video-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .video-title {
        font-weight: 600;
        color: #212529;
        line-height: 1.4;
    }
    
    .video-meta {
        color: #6c757d;
    }
    
    .video-description {
        line-height: 1.5;
    }
    
    .empty-state {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    .empty-state-icon {
        color: #adb5bd;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
{{-- Script to handle modal video source (if using modal approach) --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var videoModal = document.getElementById('videoModal');
        var videoFrame = document.getElementById('videoFrame');

        videoModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            var videoSrc = button.getAttribute('data-bs-src');
            // Update the modal's content.
            videoFrame.setAttribute('src', videoSrc + "?autoplay=1"); // Add autoplay
        });

        videoModal.addEventListener('hide.bs.modal', function (event) {
            // Stop video playback when modal is closed
            videoFrame.setAttribute('src', '');
        });
    });
</script> --}}
@endpush