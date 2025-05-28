@extends('layouts.app')

@section('title', 'Trop de requêtes')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg mx-auto">
        <div class="flex items-center justify-center mb-6">
            <div class="bg-orange-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>
        
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Trop de requêtes</h1>
        
        <p class="text-gray-600 mb-6 text-center">
            Nous avons détecté un nombre inhabituel de requêtes depuis votre adresse IP.
            Pour des raisons de sécurité, veuillez patienter quelques instants avant de réessayer.
        </p>
        
        <div class="flex justify-center">
            <a href="{{ url()->previous() }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
                Retour
            </a>
        </div>
    </div>
</div>
@endsection
