@extends('layouts.app')

@section('title', 'Audio - RHDP')

@section('content')
<div class="page-banner" style="background-image: url('{{ asset('images/banner_placeholder_4.jpg') }}');"> {{-- Use a different placeholder --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white">Enregistrements Audio</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="#">Médiathèque</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Audio</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Écoutez le RHDP</h2>
            <p>Retrouvez les interventions, messages et extraits audio importants.</p>
        </div>

        {{-- List of Audio Recordings --}}
        {{-- In a real app, this data (title, speaker, date, file_url) would come from the database --}}
        <div class="row g-4">
            @php
                // Placeholder audio data
                // Replace '#' with actual audio file URLs (e.g., mp3, ogg)
                $audios = [
                    ['title' => 'Extrait du discours du Congrès', 'speaker' => 'Président du Parti', 'date' => '2022-07-23', 'url' => '#'],
                    ['title' => 'Message radio aux militants', 'speaker' => 'Secrétaire Exécutif', 'date' => '2023-09-05', 'url' => '#'],
                    ['title' => 'Interview sur l\'économie', 'speaker' => 'Ministre de l\'Économie', 'date' => '2023-10-18', 'url' => '#'],
                    ['title' => 'Point de presse hebdomadaire', 'speaker' => 'Porte-parole du Parti', 'date' => '2024-01-15', 'url' => '#'],
                ];
            @endphp

            @forelse ($audios as $audio)
            <div class="col-md-6">
                <div class="card shadow-sm audio-item">
                    <div class="card-body">
                        <h5 class="card-title">{{ $audio['title'] }}</h5>
                        <p class="card-text text-muted small mb-2">
                            Par : {{ $audio['speaker'] }} | Date : {{ \Carbon\Carbon::parse($audio['date'])->isoFormat('LL') }}
                        </p>
                        @if($audio['url'] != '#')
                            <audio controls class="w-100">
                                <source src="{{ $audio['url'] }}" type="audio/mpeg"> {{-- Adjust type if needed (e.g., audio/ogg) --}}
                                Votre navigateur ne supporte pas l'élément audio.
                            </audio>
                        @else
                            <p class="text-danger small">Fichier audio non disponible.</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center mb-0">Aucun enregistrement audio disponible pour le moment.</p>
            </div>
            @endforelse
        </div>

        {{-- Optional: Pagination --}}
        {{-- <nav aria-label="Page navigation example" class="mt-5"> ... </nav> --}}

    </div>
</section>
@endsection

@push('styles')
<style>
    .page-banner {
        padding: 80px 0;
        background-color: #f8f9fa; /* Fallback color */
        background-size: cover;
        background-position: center;
        text-align: center;
        position: relative;
    }
    .page-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
    }
    .page-banner .container {
        position: relative;
        z-index: 1;
    }
    .page-banner h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    .breadcrumb-item a {
        color: #adb5bd;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #ffffff;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: #adb5bd;
    }
    .section-padding {
        padding: 80px 0;
    }
    .section-title h2 {
        color: var(--bs-primary, #0050a0); /* Use primary color */
        font-weight: 700;
        margin-bottom: 15px;
    }
    .audio-item .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--bs-primary, #0050a0);
    }
    audio {
        margin-top: 10px;
    }
</style>
@endpush
