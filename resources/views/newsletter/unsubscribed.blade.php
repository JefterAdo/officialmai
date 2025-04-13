@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
        <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>

        <h2 class="text-2xl font-bold mb-4">Désinscription confirmée</h2>
        
        <p class="text-gray-600 mb-6">
            Vous avez été désinscrit de notre newsletter avec succès. Nous sommes désolés de vous voir partir !
        </p>

        <p class="text-gray-600">
            Si vous changez d'avis, vous pouvez toujours vous 
            <a href="{{ route('newsletter.form') }}" class="text-blue-500 hover:text-blue-700">
                réinscrire ici
            </a>.
        </p>
    </div>
</div>
@endsection 