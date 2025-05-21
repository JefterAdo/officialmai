@extends('layouts.app')

@section('title', 'Vidéos - Rassemblement Web TV')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center">Vidéos du RHDP</h1>
            <p class="text-center lead">Les dernières vidéos de la chaîne Rassemblement Web TV</p>
        </div>
    </div>
    
    <!-- Conteneur où les vidéos YouTube seront chargées -->
    <div id="youtube-videos-container">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p>Chargement des vidéos...</p>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="https://www.youtube.com/@rassemblementwebtv5828" target="_blank" class="btn btn-primary">
                Voir toutes les vidéos sur YouTube
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/youtube-videos.js') }}"></script>
@endpush
