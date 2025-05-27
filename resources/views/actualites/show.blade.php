@extends('layouts.app')

@section('title', $news->title . ' - RHDP')
@section('meta_description', $news->excerpt ?: Str::limit(strip_tags($news->content), 160))

@push('styles')
<style>
    /* Article Container */
    .article-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 0;
    }
    
    /* Article Header */
    .article-header {
        margin-bottom: 2.5rem;
    }
    
    .article-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #FF6B00;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }
    
    /* Article Meta */
    .article-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .meta-item i {
        color: #FF6B00;
    }
    
    .meta-category {
        color: #FF6B00;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .meta-category:hover {
        color: #e05e00;
        text-decoration: underline;
    }
    
    /* Article Featured Image */
    .article-featured-image-container {
        position: relative;
        margin-bottom: 2.5rem;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .article-featured-image {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
        display: block;
    }
    
    /* Article Content */
    .article-content {
        font-size: 1.125rem;
        line-height: 1.85;
        color: #333;
        padding: 0.5rem 0 2rem;
    }
    
    .article-content p {
        margin-bottom: 1.75rem;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        margin: 2.5rem 0;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .article-content h2, .article-content h3, .article-content h4 {
        color: #FF6B00;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        line-height: 1.3;
    }
    
    .article-content h2 {
        font-size: 1.75rem;
    }
    
    .article-content h3 {
        font-size: 1.5rem;
    }
    
    .article-content h4 {
        font-size: 1.25rem;
    }
    
    .article-content blockquote {
        border-left: 4px solid #FF6B00;
        padding: 1.25rem 1.5rem;
        background-color: #f8f9fa;
        margin: 2.5rem 0;
        font-style: italic;
        color: #495057;
        border-radius: 0 0.5rem 0.5rem 0;
    }
    
    .article-content ul, .article-content ol {
        margin: 1.5rem 0 2rem 1.25rem;
    }
    
    .article-content li {
        margin-bottom: 0.75rem;
        position: relative;
    }
    
    .article-content ul li::before {
        content: '';
        position: absolute;
        left: -1.25rem;
        top: 0.75rem;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #FF6B00;
    }
    
    /* Hide captions and filenames under images */
    .article-content img + figcaption,
    .article-content img + br + small,
    .article-content figure figcaption,
    .article-content figure + p > small,
    .article-content p > img + small,
    .article-content img + small {
        display: none !important;
    }
    
    /* Social Share */
    .social-share {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2.5rem 0;
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-radius: 0.75rem;
    }
    
    .share-label {
        font-weight: 600;
        color: #495057;
        margin-right: 0.5rem;
    }
    
    .share-buttons {
        display: flex;
        gap: 0.75rem;
    }
    
    .share-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f1f1f1;
        color: #495057;
        transition: all 0.2s ease;
    }
    
    .share-button:hover {
        background-color: #FF6B00;
        color: white;
        transform: translateY(-3px);
    }
    
    /* Related Articles */
    .related-articles {
        margin-top: 3rem;
        padding-top: 2rem;
        margin-bottom: 2rem;
        border-top: 1px solid #dee2e6;
    }
    
    .related-articles-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #FF6B00;
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
    }
    
    .related-articles-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: #FF6B00;
    }
    
    .related-article-card {
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }
    
    .related-article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .related-article-image {
        height: 200px;
        overflow: hidden;
    }
    
    .related-article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .related-article-card:hover .related-article-image img {
        transform: scale(1.05);
    }
    
    .related-article-content {
        padding: 1.25rem;
    }
    
    .related-article-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        transition: color 0.2s;
    }
    
    .related-article-card:hover .related-article-title {
        color: #FF6B00;
    }
    
    .related-article-date {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .related-article-link {
        color: #FF6B00;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: gap 0.2s;
    }
    
    .related-article-link:hover {
        gap: 0.75rem;
    }
    
    /* Back Button */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #FF6B00 !important;
        font-weight: 600;
        margin-bottom: 2rem;
        transition: gap 0.2s ease;
        text-decoration: none;
    }
    
    .back-button:hover {
        gap: 0.75rem;
        color: #e05e00 !important;
    }
    
    .back-button i {
        color: #FF6B00 !important;
        transition: transform 0.2s ease;
    }
    
    .back-button:hover i {
        transform: translateX(-3px);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .article-title {
            font-size: 2rem;
        }
        
        .article-meta {
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        
        .article-content {
            font-size: 1.05rem;
            line-height: 1.75;
        }
        
        .article-featured-image {
            max-height: 350px;
        }
        
        .social-share {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8 flex-grow-1">
    <div class="article-container">
        <a href="{{ route('actualites.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Retour aux actualités
        </a>
        
        <article>
            <header class="article-header">
                <h1 class="article-title">{{ $news->title }}</h1>
                <div class="article-meta">
                    <div class="meta-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $news->published_at->locale('fr')->isoFormat('LL') }}</span>
                    </div>
                    @if($news->category)
                    <div class="meta-item">
                        <i class="far fa-folder"></i>
                        <a href="{{ route('actualites.category', $news->category->slug) }}" class="meta-category">
                            {{ $news->category->name }}
                        </a>
                    </div>
                    @endif
                    <div class="meta-item">
                        <i class="far fa-clock"></i>
                        <span>{{ ceil(str_word_count(strip_tags($news->content)) / 200) }} min de lecture</span>
                    </div>
                </div>
            </header>

            @if($news->featured_image)
            <div class="article-featured-image-container">
                <img src="/storage/{{ $news->featured_image }}" 
                     alt="{{ $news->title }}" 
                     class="article-featured-image">
            </div>
            @endif

            <div class="article-content">
                {!! $news->content !!}
            </div>
            
            <div class="social-share">
                <div class="share-label">Partager cet article :</div>
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="share-button">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank" class="share-button">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}" target="_blank" class="share-button">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode($news->title) }}&body={{ urlencode(request()->url()) }}" class="share-button">
                        <i class="far fa-envelope"></i>
                    </a>
                </div>
            </div>
        </article>

    @if($relatedNews->count() > 0)
    <section class="related-articles">
        <h2 class="related-articles-title">Articles similaires</h2>
        <div class="row">
            @foreach($relatedNews as $article)
            <div class="col-md-4 mb-4 d-flex">
                <a href="{{ route('actualites.show', $article->slug) }}" class="related-article-card text-decoration-none w-100">
                    <div class="related-article-image">
                        @if($article->featured_image)
                            <img src="/storage/{{ $article->featured_image }}" 
                                 alt="{{ $article->title }}">
                        @else
                            <img src="{{ asset('images/le_RHDP_Côte_d_Ivoire.png') }}" 
                                 alt="Image par défaut">
                        @endif
                    </div>
                    <div class="related-article-content">
                        <h3 class="related-article-title">{{ Str::limit($article->title, 60) }}</h3>
                        <div class="related-article-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ $article->published_at->locale('fr')->isoFormat('LL') }}</span>
                        </div>
                        <div class="related-article-link">
                            Lire l'article <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif
    </div>
</div>

@endsection