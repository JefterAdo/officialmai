@extends('layouts.app')

@section('title', 'Textes Officiels | Médiathèque RHDP')

@push('styles')
<style>
    /* Styles spécifiques pour la page textes */
    .page-header {
        background-color: #f8f9fa;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-bottom: 3px solid var(--primary-color);
        position: relative;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('/images/pattern-bg.png');
        background-size: 200px;
        opacity: 0.05;
        z-index: 0;
    }
    
    .page-header h1 {
        color: var(--primary-color);
        position: relative;
        z-index: 1;
    }
    
    .document-table {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .document-table:hover {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    .document-row:hover {
        background-color: rgba(255, 107, 0, 0.05);
    }
    
    .download-btn {
        transition: all 0.3s ease;
    }
    
    .download-btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center" data-aos="fade-up">Textes Officiels du RHDP</h1>
    </div>
</div>

<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <section class="mb-12 text-center" data-aos="fade-up" data-aos-delay="100">
        <p class="text-lg text-gray-700 leading-relaxed max-w-3xl mx-auto">
            Bienvenue dans la section des textes officiels du RHDP. Vous trouverez ici les documents fondamentaux qui régissent notre parti, nos statuts, règlements, ainsi que d'autres publications importantes. Ces textes reflètent notre engagement envers la transparence, la démocratie et la bonne gouvernance.
        </p>
    </section>

    <section class="bg-white py-8" data-aos="fade-up" data-aos-delay="200">
        <div class="max-w-4xl mx-auto">
            <!-- Commentaire: Informations de débogage retirées -->
            
            @if($documents->count())
                <div class="document-table overflow-hidden rounded-lg shadow border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-orange-50">
                                <th scope="col" class="py-3 px-4 text-left text-sm font-semibold text-orange-700">Titre</th>
                                <th scope="col" class="py-3 px-4 text-left text-sm font-semibold text-orange-700">Type</th>
                                <th scope="col" class="py-3 px-4 text-center text-sm font-semibold text-orange-700">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $doc)
                                <tr class="document-row hover:bg-orange-50 transition-colors duration-150 ease-in-out">
                                    <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-800">{{ $doc->title }}</td>
                                    <td class="py-4 px-4 whitespace-nowrap capitalize text-gray-600">{{ str_replace('-', ' ', $doc->type) }}</td>
                                    <td class="py-4 px-4 whitespace-nowrap text-center">
                                        <div style="position: relative; display: inline-block;">
                                            <a href="{{ route('documents.download', ['slug' => $doc->slug]) }}" style="text-decoration: none; display: inline-block;">
                                                <div style="background-color: #FF6B00; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; display: inline-block; cursor: pointer; font-size: 14px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                    Télécharger
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">Pour toute question concernant ces documents, veuillez contacter le secrétariat du parti.</p>
                </div>
            @else
                <div class="text-center text-gray-500 py-12 bg-gray-50 rounded-lg border border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-4 text-xl font-medium mb-2">Aucun texte officiel disponible pour le moment.</p>
                    <p>Veuillez revenir ultérieurement pour consulter les publications.</p>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
