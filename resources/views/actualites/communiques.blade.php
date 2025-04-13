@extends('layouts.app')

@section('title', 'Communiqués - RHDP | Communications Officielles du Parti')

@push('styles')
<style>
    .communique-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .communique-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .communique-item {
        background-color: #fff;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid #FF8C00;
    }

    .communique-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .communique-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .communique-content h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #FF8C00;
    }

    .communique-date {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .communique-excerpt {
        color: #495057;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .read-more {
        color: #28a745;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
        align-self: flex-start;
    }

    .read-more:hover {
        color: #2c6e38;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .file-info i {
        font-size: 1.25rem;
    }
</style>
@endpush

@section('content')
<main class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-primary mb-6">Communiqués Officiels du RHDP</h1>

    <section id="communiques-list" class="communique-grid">
        @forelse($communiques as $communique)
            <article class="communique-item">
                <div class="communique-content">
                    <h2>{{ $communique->title }}</h2>
                    <p class="communique-date">
                        <time datetime="{{ $communique->published_at->format('Y-m-d') }}">
                            {{ $communique->published_at->locale('fr')->isoFormat('LL') }}
                        </time>
                    </p>
                    @if($communique->content)
                        <p class="communique-excerpt">{{ Str::limit(strip_tags($communique->content), 150) }}</p>
                    @endif
                    
                    @if($communique->file_path)
                        <div class="file-info">
                            @php
                                $iconClass = match($communique->file_type) {
                                    'pdf' => 'fas fa-file-pdf',
                                    'docx' => 'fas fa-file-word',
                                    'doc' => 'fas fa-file-word',
                                    'image' => 'fas fa-file-image',
                                    default => 'fas fa-file'
                                };
                            @endphp
                            <i class="{{ $iconClass }}"></i>
                            <span>{{ strtoupper($communique->file_type) }} - {{ $communique->getHumanFileSize() }}</span>
                        </div>
                    @endif
                    
                    <a href="{{ route('actualites.communiques.show', $communique->slug) }}" class="read-more">
                        Lire le communiqué complet →
                    </a>
                </div>
            </article>
        @empty
            <div class="col-12 text-center">
                <p>Aucun communiqué n'est disponible pour le moment.</p>
            </div>
        @endforelse
    </section>

    @if($communiques->hasPages())
        <nav aria-label="Pagination des communiqués" class="mt-8">
            {{ $communiques->links() }}
        </nav>
    @endif
</main>
@endsection 