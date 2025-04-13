@extends('layouts.app')

@section('title', $gallery->title . ' - Galerie Photos RHDP')

@push('styles')
<style>
    .gallery-header {
        background-color: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem 0;
    }
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover {
        transform: scale(1.02);
    }
    .gallery-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.75rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .gallery-caption {
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<div class="gallery-header">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-primary mb-3">{{ $gallery->title }}</h1>
        @if($gallery->event_date)
            <p class="text-gray-600 mb-3">
                <i class="fas fa-calendar-alt mr-2"></i>
                {{ $gallery->event_date->format('d/m/Y') }}
            </p>
        @endif
        @if($gallery->description)
            <p class="text-gray-700">{{ $gallery->description }}</p>
        @endif
    </div>
</div>

<div class="container mx-auto px-4 pb-8">
    @if($gallery->images->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-600">Aucune image n'est disponible dans cette galerie.</p>
        </div>
    @else
        <div class="gallery-grid">
            @foreach($gallery->images as $image)
                <div class="gallery-item">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="{{ $image->caption ?? $gallery->title }}"
                         class="gallery-image"
                         data-lightbox="gallery"
                         data-title="{{ $image->caption ?? '' }}">
                    @if($image->caption)
                        <div class="gallery-caption">
                            {{ $image->caption }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8">
        <a href="{{ route('mediatheque.photos') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour aux galeries
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@endpush 