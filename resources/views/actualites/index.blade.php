@extends('layouts.app')

    @section('title', 'Actualités - RHDP | Dernières Nouvelles du Parti')
    @section('meta_description', 'Restez informé des dernières actualités, communiqués et événements du RHDP. Toutes les nouvelles du Rassemblement des Houphouëtistes pour la Démocratie et la Paix.')

    @push('styles')
    <style>
        .news-grid {
            display: grid;
            grid-template-columns: 1fr; /* 1 colonne par défaut (mobile) */
            gap: 2rem;
        }

        @media (min-width: 768px) { /* Tablette et plus */
            .news-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 colonnes */
            }
        }

        @media (min-width: 1024px) { /* Desktop */
            .news-grid {
                grid-template-columns: repeat(3, 1fr); /* 3 colonnes */
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
            background-color: #e9ecef; /* Placeholder color */
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
            flex-grow: 1; /* Permet au contenu de remplir l'espace */
            display: flex;
            flex-direction: column;
        }

        .news-content h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .news-content h2 a {
            color: var(--bs-primary); /* Orange title link */
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .news-content h2 a:hover {
            color: #cc7a00; /* Darker orange */
        }

        .news-date {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .news-excerpt {
            color: #495057;
            margin-bottom: 1rem;
            flex-grow: 1; /* Pousse le lien "Lire la suite" vers le bas */
        }

        .read-more {
            color: var(--bs-secondary); /* Green link */
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
            align-self: flex-start; /* Aligne le lien en bas à gauche */
        }
        .read-more:hover {
            color: #2c6e38; /* Darker green */
        }

        /* Pagination Styles (Basic Bootstrap structure) */
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
        <h1 class="text-3xl font-bold text-primary mb-6">Actualités du RHDP</h1>

        @if($categories->count() > 0)
        <div class="categories-filter mb-6">
            <h2 class="text-xl mb-3">Catégories</h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('actualites.index') }}" class="btn btn-sm {{ request()->routeIs('actualites.index') && !request()->category ? 'btn-primary' : 'btn-outline-primary' }}">
                    Toutes
                </a>
                @foreach($categories as $category)
                <a href="{{ route('actualites.category', $category->slug) }}" 
                   class="btn btn-sm {{ request()->category == $category->slug ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

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
                <p>Aucune actualité n'est disponible pour le moment.</p>
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
