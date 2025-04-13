@extends('layouts.app')

@section('title', 'Galeries Photos - RHDP')
@section('meta_description', 'Découvrez les albums photos des activités et événements du RHDP. Revivez en images les moments forts du Rassemblement des Houphouëtistes pour la Démocratie et la Paix.')

@push('styles')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        padding: 2rem 0;
    }
    
    .gallery-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    
    .gallery-thumbnail {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }
    
    .gallery-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-card:hover .gallery-thumbnail img {
        transform: scale(1.1);
    }
    
    .gallery-info {
        padding: 1.5rem;
    }
    
    .gallery-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .gallery-date {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .gallery-description {
        color: #555;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .gallery-count {
        color: #888;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-header {
        background-color: #f8f9fa;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
</style>
@endpush

@section('content')
<div class="section-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h5 class="sub-title text-primary">MÉDIATHÈQUE</h5>
                <h1 class="mb-4">Galeries Photos</h1>
                <p class="lead">Découvrez les moments forts du RHDP à travers nos galeries photos.</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @php
        $galleries = App\Models\Gallery::with(['images' => function($query) {
            $query->orderBy('order')->take(1);
        }])
        ->where('is_published', true)
        ->orderBy('event_date', 'desc')
        ->paginate(12);
    @endphp

    @if($galleries->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted">Aucune galerie n'est disponible pour le moment.</p>
        </div>
    @else
        <div class="gallery-grid">
            @foreach($galleries as $gallery)
                <a href="{{ route('mediatheque.photos.show', $gallery->slug) }}" class="text-decoration-none">
                    <div class="gallery-card">
                        <div class="gallery-thumbnail">
                            @if($gallery->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $gallery->images->first()->image_path) }}" 
                                     alt="{{ $gallery->title }}">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" 
                                     alt="Image par défaut">
                            @endif
                        </div>
                        <div class="gallery-info">
                            <h3 class="gallery-title">{{ $gallery->title }}</h3>
                            @if($gallery->event_date)
                                <div class="gallery-date">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ $gallery->event_date->format('d/m/Y') }}
                                </div>
                            @endif
                            @if($gallery->description)
                                <p class="gallery-description">{{ $gallery->description }}</p>
                            @endif
                            <div class="gallery-count">
                                <i class="fas fa-images"></i>
                                {{ $gallery->images->count() }} photos
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection