@extends('layouts.app')

    @section('title', 'Actualités - RHDP | Dernières Nouvelles du Parti')
    @section('meta_description', 'Restez informé des dernières actualités, communiqués et événements du RHDP. Toutes les nouvelles du Rassemblement des Houphouëtistes pour la Démocratie et la Paix.')

    @push('styles')
    <style>
        .news-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 1rem;
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
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
        }
        .news-preview-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .news-image-placeholder {
            height: 200px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            position: relative;
        }
        .news-image-placeholder::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1) 0%, rgba(255, 107, 0, 0.05) 100%);
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
            gap: 0.75rem;
        }

        .news-content h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .news-content h2 a {
            color: #FF6B00;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .news-content h2 a:hover {
            color: #e05e00;
            text-decoration: underline;
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
            color: #FF6B00;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .read-more:hover {
            color: #e05e00;
            text-decoration: underline;
        }

        /* Pagination Styles (Basic Bootstrap structure) */
        .pagination {
            justify-content: center;
            margin-top: 3rem;
        }
        .pagination .page-item .page-link {
             color: #FF6B00;
             border: 1px solid #FF6B00;
        }
        .pagination .page-item .page-link:hover {
             background-color: #fff3e6;
        }
        .pagination .page-item.active .page-link {
             background-color: #FF6B00;
             border-color: #FF6B00;
             color: white;
         }
         .pagination .page-item.disabled .page-link {
             color: #6c757d;
         }
    </style>
    @endpush

    @section('content')
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-[#FF6B00] mb-6">Actualités du RHDP</h1>

        @if($categories->count() > 0)
        <div class="categories-filter mb-12 p-6 bg-gray-50 rounded-lg border border-gray-200">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Filtrer par catégorie</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('actualites.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request()->routeIs('actualites.index') && !request()->category ? 'bg-[#FF6B00] text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-100' }}">
                    Toutes les actualités
                </a>
                @foreach($categories as $category)
                @if(!in_array(strtolower($category->name), ['communiqués', 'communiques', 'documents']))
                <a href="{{ route('actualites.category', $category->slug) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request()->category == $category->slug ? 'bg-[#FF6B00] text-white' : 'bg-[#FF6B00]/10 text-[#FF6B00] border border-[#FF6B00]/50 hover:bg-[#FF6B00]/10' }}" style="color: #FF6B00; border-color: #FF6B00;">
                    <span class="flex items-center gap-2">
                        {{ $category->name }}
                        <span class="bg-[#FF6B00]/10 px-2 py-0.5 rounded-full text-xs font-medium" style="color: #FF6B00; background-color: rgba(255, 107, 0, 0.1);">
                            {{ $category->news_count ?? 0 }}
                        </span>
                    </span>
                </a>
                @endif
                @endforeach
            </div>
        </div>
        @endif

        <section id="news-list" class="news-grid">
            @forelse($news as $article)
            <article class="news-preview-item">
                <div class="news-image-placeholder">
                    @if($article->featured_image)
                        <img src="/storage/{{ $article->featured_image }}" alt="{{ $article->title }}">
                    @else
                        <i class="fas fa-image fa-3x"></i>
                    @endif
                </div>
                <div class="news-content">
                    <div class="flex flex-wrap gap-2 mb-2">
                        @if($article->category && !in_array(strtolower($article->category->name), ['communiqués', 'communiques', 'documents']))
                        <span class="px-3 py-1 bg-[#FF6B00] text-white text-xs font-medium rounded-full">
                            {{ $article->category->name }}
                        </span>
                        @endif
                        <span class="text-gray-500 text-sm">
                            <i class="far fa-calendar-alt mr-1"></i>
                            <time datetime="{{ $article->published_at->format('Y-m-d') }}">
                                {{ $article->published_at->locale('fr')->isoFormat('LL') }}
                            </time>
                        </span>
                    </div>
                    <h2 class="text-xl font-bold mb-2">
                        <a href="{{ route('actualites.show', $article->slug) }}" class="hover:text-[#e05e00]">{{ $article->title }}</a>
                    </h2>
                    @if($article->meta_description)
                        <p class="news-excerpt text-gray-700 mb-3">{{ $article->meta_description }}</p>
                    @else
                        <p class="news-excerpt text-gray-700 mb-3">{{ Str::limit(strip_tags($article->content), 160) }}</p>
                    @endif
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
