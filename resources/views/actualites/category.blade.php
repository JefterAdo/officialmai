@extends('layouts.app')

@section('title', $category->name . ' - Actualités RHDP')
@section('meta_description', 'Actualités du RHDP dans la catégorie ' . $category->name . '. ' . ($category->description ?: ''))

@push('styles')
<style>
    .news-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .news-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .news-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .news-preview-item {
        background-color: #fff;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .news-preview-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .news-image-placeholder {
        height: 200px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }

    .news-image-placeholder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .news-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .news-content h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .news-content h2 a {
        color: var(--bs-primary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .news-content h2 a:hover {
        color: #cc7a00;
    }

    .news-date {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .news-excerpt {
        color: #495057;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .read-more {
        color: var(--bs-secondary);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
        align-self: flex-start;
    }

    .read-more:hover {
        color: #2c6e38;
    }

    .pagination {
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination .page-item .page-link {
        color: var(--bs-primary);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<main class="container mx-auto px-4 py-8">
    <div class="mb-4">
        <a href="{{ route('actualites.index') }}" class="text-primary hover:text-primary-dark">
            <i class="fas fa-arrow-left mr-2"></i> Toutes les actualités
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-primary">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-gray-600 mt-2">{{ $category->description }}</p>
        @endif
    </div>

    <section id="news-list" class="news-grid">
        @forelse($news as $article)
        <article class="news-preview-item">
            <div class="news-image-placeholder">
                @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                @else
                    <i class="fas fa-image fa-3x"></i>
                @endif
            </div>
            <div class="news-content">
                <h2><a href="{{ route('actualites.show', $article->slug) }}">{{ $article->title }}</a></h2>
                <p class="news-date">
                    <time datetime="{{ $article->published_at->format('Y-m-d') }}">
                        {{ $article->published_at->locale('fr')->isoFormat('LL') }}
                    </time>
                </p>
                <p class="news-excerpt">{{ $article->excerpt ?: Str::limit(strip_tags($article->content), 150) }}</p>
                <a href="{{ route('actualites.show', $article->slug) }}" class="read-more">Lire la suite →</a>
            </div>
        </article>
        @empty
        <div class="col-12 text-center">
            <p>Aucune actualité n'est disponible dans cette catégorie pour le moment.</p>
        </div>
        @endforelse
    </section>

    @if($news->hasPages())
    <div class="mt-8">
        {{ $news->links() }}
    </div>
    @endif
</main>
@endsection 