@extends('layouts.app')

@section('title', $news->title . ' - RHDP')
@section('meta_description', $news->excerpt ?: Str::limit(strip_tags($news->content), 160))

@push('styles')
<style>
    .article-content {
    line-height: 1.8;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;

        font-size: 1.1rem;
        line-height: 1.8;
        color: #495057;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem 0;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .article-content h2, .article-content h3, .article-content h4 {
        color: #FF6B00;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .article-content blockquote {
        border-left: 4px solid #FF6B00;
        padding: 1rem;
        background-color: #f8f9fa;
        margin: 2rem 0;
    }

    .article-content ul, .article-content ol {
        margin-bottom: 1rem;
    }

    .article-content li {
        margin-bottom: 0.5rem;
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .related-article-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 107, 0, 0.1) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .related-article-card:hover {
        transform: translateY(-5px);
        z-index: 1;
    }

    .related-article-card:hover::before {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8 flex-grow-1">
    <div class="mb-4">
        <a href="{{ route('actualites.index') }}" class="text-[#FF6B00] hover:text-[#e05e00] d-inline-flex align-items-center" style="color: #FF6B00 !important;">
            <i class="fas fa-arrow-left mr-2" style="color: #FF6B00 !important;"></i> Retour aux actualités
        </a>
    </div>

    <article class="mt-4">
        <header class="mb-8">
            <h1 class="text-4xl font-bold mb-4" style="color: #FF6B00;">{{ $news->title }}</h1>
            <div class="article-meta">
                <span class="mr-4">
                    <i class="far fa-calendar-alt mr-1"></i>
                    {{ $news->published_at->locale('fr')->isoFormat('LL') }}
                </span>
                @if($news->category)
                <span>
                    <i class="far fa-folder mr-1"></i>
                    <a href="{{ route('actualites.category', $news->category->slug) }}" class="text-[#FF6B00] hover:text-[#e05e00]">
                        {{ $news->category->name }}
                    </a>
                </span>
                @endif
            </div>
        </header>

        @if($news->featured_image)
        <img src="/storage/{{ $news->featured_image }}" 
             alt="{{ $news->title }}" 
             class="article-featured-image">
        @endif

        <div class="article-content">
            {!! $news->content !!}
        </div>
    </article>

    @if($relatedNews->count() > 0)
    <section class="related-articles">
        <h2 class="text-2xl font-bold mb-4" style="color: #FF6B00;">Articles similaires</h2>
        <div class="row">
            @foreach($relatedNews as $article)
            <div class="col-md-4 mb-4 d-flex">
                <a href="{{ route('actualites.show', $article->slug) }}" class="card related-article-card text-decoration-none w-100">
                    <div style="height: 200px; overflow: hidden;">
                        @if($article->featured_image)
                            <img src="/storage/{{ $article->featured_image }}" 
                                 alt="{{ $article->title }}"
                                 class="w-100 h-100 img-fluid"
                                 style="object-fit: cover; object-position: center;">
                        @else
                            <img src="{{ asset('images/le_RHDP_Côte_d_Ivoire.png') }}" 
                                 alt="Image par défaut"
                                 class="w-100 h-100 img-fluid"
                                 style="object-fit: cover; object-position: center;">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color: #FF6B00;">{{ Str::limit($article->title, 60) }}</h5>
                        <p class="card-text text-muted small mb-auto">{{ $article->published_at->locale('fr')->isoFormat('LL') }}</p>
                        <span class="btn btn-sm btn-outline-[#FF6B00] mt-3 align-self-start">Lire l'article</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>