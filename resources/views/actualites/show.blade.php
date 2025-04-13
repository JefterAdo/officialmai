@extends('layouts.app')

@section('title', $news->title . ' - RHDP')
@section('meta_description', $news->excerpt ?: Str::limit(strip_tags($news->content), 160))

@push('styles')
<style>
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem 0;
        border-radius: 0.5rem;
    }
    
    /* Masquer les légendes et noms de fichiers sous les images */
    .article-content img + figcaption,
    .article-content img + br + small,
    .article-content figure figcaption,
    .article-content figure + p > small,
    .article-content p > img + small,
    .article-content img + small {
        display: none !important;
    }

    .article-featured-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
    }

    .article-meta {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 2rem;
    }

    .related-articles {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid #dee2e6;
    }

    .related-article-card {
        height: 100%;
        transition: transform 0.3s ease;
    }

    .related-article-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('content')
<main class="container mx-auto px-4 py-8">
    <div class="mb-4">
        <a href="{{ route('actualites.index') }}" class="text-primary hover:text-primary-dark">
            <i class="fas fa-arrow-left mr-2"></i> Retour aux actualités
        </a>
    </div>

    <article>
        <header class="mb-8">
            <h1 class="text-4xl font-bold mb-4">{{ $news->title }}</h1>
            <div class="article-meta">
                <span class="mr-4">
                    <i class="far fa-calendar-alt mr-1"></i>
                    {{ $news->published_at->locale('fr')->isoFormat('LL') }}
                </span>
                @if($news->category)
                <span>
                    <i class="far fa-folder mr-1"></i>
                    <a href="{{ route('actualites.category', $news->category->slug) }}" class="text-primary hover:text-primary-dark">
                        {{ $news->category->name }}
                    </a>
                </span>
                @endif
            </div>
        </header>

        @if($news->featured_image)
        <img src="{{ asset('storage/' . $news->featured_image) }}" 
             alt="{{ $news->title }}" 
             class="article-featured-image">
        @endif

        <div class="article-content">
            {!! $news->content !!}
        </div>
    </article>

    @if($relatedNews->count() > 0)
    <section class="related-articles">
        <h2 class="text-2xl font-bold mb-4">Articles similaires</h2>
        <div class="row">
            @foreach($relatedNews as $article)
            <div class="col-md-4 mb-4">
                <div class="card related-article-card">
                    <div class="card-img-top-wrapper" style="height: 200px; overflow: hidden;">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="{{ $article->title }}"
                                 class="w-100 h-100"
                                 style="object-fit: cover;">
                        @else
                            <img src="{{ asset('images/le_RHDP_Côte_d_Ivoire.png') }}" 
                                 alt="Image par défaut"
                                 class="w-100 h-100"
                                 style="object-fit: cover;">
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text text-muted small">{{ $article->published_at->locale('fr')->isoFormat('LL') }}</p>
                        <a href="{{ route('actualites.show', $article->slug) }}" class="btn btn-outline-primary mt-3">Lire l'article</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</main>