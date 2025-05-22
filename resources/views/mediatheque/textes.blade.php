@extends('layouts.app')

@section('title', 'Textes Officiels | Médiathèque RHDP')

@push('styles')
<style>
    /* Styles spécifiques si nécessaires, sinon Tailwind gère la majorité */
    .page-header {
        background-color: #f8f9fa; /* Ou une couleur de fond thématique */
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 3px solid #FF8C00;
    }
    .page-header h1 {
        color: #FF8C00;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center">Textes Officiels du RHDP</h1>
    </div>
</div>

<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <section class="mb-12 text-center">
        <p class="text-lg text-gray-700 leading-relaxed max-w-3xl mx-auto">
            Bienvenue dans la section des textes officiels du RHDP. Vous trouverez ici les documents fondamentaux qui régissent notre parti, nos statuts, règlements, ainsi que d'autres publications importantes. Ces textes reflètent notre engagement envers la transparence, la démocratie et la bonne gouvernance.
        </p>
    </section>

    <section class="bg-white py-8">
        <div class="max-w-4xl mx-auto">
            @if($documents->count())
                <div class="overflow-hidden rounded-lg shadow border border-gray-200">
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
                                <tr class="hover:bg-orange-50 transition-colors duration-150 ease-in-out">
                                    <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-800">{{ $doc->title }}</td>
                                    <td class="py-4 px-4 whitespace-nowrap capitalize text-gray-600">{{ str_replace('-', ' ', $doc->type) }}</td>
                                    <td class="py-4 px-4 whitespace-nowrap text-center">
                                        <a href="{{ route('documents.download', $doc->slug) }}"
                                           class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-150 ease-in-out">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            <span>Télécharger</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-gray-500 py-12 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xl mb-2">Aucun texte officiel disponible pour le moment.</p>
                    <p>Veuillez revenir ultérieurement pour consulter les publications.</p>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
