@extends('layouts.app')

{{-- SEO Title --}}
@section('title', 'Chronologie de Félix Houphouët-Boigny | RHDP')

@push('styles')
<style>
body {
    font-family: 'Inter', sans-serif; /* Assuming Inter is available or a similar sans-serif font */
}

.timeline-container-rhdp {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 20px;
}

.timeline-header-rhdp h1 {
    color: #FF6B00; /* RHDP Orange */
    font-size: 2rem; /* 32px */
    font-weight: 700;
    margin-bottom: 0.5rem; /* 8px */
    text-align: left;
}

.timeline-header-rhdp p {
    color: #4B5563; /* Tailwind gray-600 */
    font-size: 0.875rem; /* 14px */
    margin-bottom: 2.5rem; /* 40px */
    text-align: left;
    max-width: 600px;
}
.timeline-rhdp {
    position: relative;
    padding: 20px 0;
}

.timeline-rhdp::before {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 0;
    bottom: 0;
    width: 3px;
    background-color: #FF6B00; /* RHDP Orange */
    border-radius: 2px;
}

.timeline-item-rhdp {
    position: relative;
    margin-bottom: 50px;
    width: 50%;
    padding: 10px 40px;
    box-sizing: border-box;
}

.timeline-item-rhdp:nth-child(odd) {
    left: 0;
    padding-right: 30px; /* Space from center line */
    text-align: right;
}

.timeline-item-rhdp:nth-child(even) {
    left: 50%;
    padding-left: 30px; /* Space from center line */
    text-align: left;
}

/* Marker on the timeline */
.timeline-item-rhdp::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: white;
    border: 4px solid #FF6B00; /* RHDP Orange */
    top: 20px; /* Adjust to align with content */
    z-index: 1;
}

.timeline-item-rhdp:nth-child(odd)::after {
    right: -8px; /* (16px / 2) */
    transform: translateX(50%);
}

.timeline-item-rhdp:nth-child(even)::after {
    left: -8px; /* (16px / 2) */
    transform: translateX(-50%);
}
.timeline-card-rhdp {
    background-color: #F9FAFB; /* Tailwind gray-50 */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    position: relative;
    border-left: 5px solid transparent; /* For alignment, will be overridden */
}

.timeline-item-rhdp:nth-child(odd) .timeline-card-rhdp {
    border-left: none;
    border-right: 5px solid #FF6B00; /* Orange border on the side facing the timeline */
}
.timeline-item-rhdp:nth-child(even) .timeline-card-rhdp {
    border-left: 5px solid #FF6B00; /* Orange border on the side facing the timeline */
}


.timeline-date-rhdp {
    display: block;
    font-size: 0.8rem; /* 12.8px */
    font-weight: 600;
    color: #FF6B00; /* RHDP Orange */
    margin-bottom: 8px;
}

.timeline-title-rhdp {
    font-size: 1.125rem; /* 18px */
    font-weight: 700;
    color: #10B981; /* Green color from image */
    margin-bottom: 8px;
}

.timeline-description-rhdp {
    font-size: 0.875rem; /* 14px */
    color: #374151; /* Tailwind gray-700 */
    line-height: 1.6;
}
/* Responsive adjustments */
@media screen and (max-width: 768px) {
    .timeline-rhdp::before {
        left: 8px; /* Move line to the left */
        transform: translateX(0);
    }

    .timeline-item-rhdp,
    .timeline-item-rhdp:nth-child(even) {
        width: 100%;
        left: 0;
        padding-left: 50px; /* Space for date and marker */
        padding-right: 15px;
        text-align: left;
    }
    
    .timeline-item-rhdp:nth-child(odd) {
        padding-left: 50px; /* Space for date and marker */
        text-align: left;
    }

    .timeline-item-rhdp::after,
    .timeline-item-rhdp:nth-child(even)::after,
    .timeline-item-rhdp:nth-child(odd)::after {
        left: 0px;
        transform: translateX(0);
    }

    .timeline-item-rhdp:nth-child(odd) .timeline-card-rhdp,
    .timeline-item-rhdp:nth-child(even) .timeline-card-rhdp {
        border-left: 5px solid #FF6B00;
        border-right: none;
    }
}
</style>
@endpush

@php
$timelineEvents = [
    ['date' => '1905', 'title' => 'Naissance', 'description' => 'Naissance officielle de Félix Houphouët-Boigny (date exacte débattue).'],
    ['date' => '1925', 'title' => 'Diplôme de médecine', 'description' => 'Obtient son diplôme de l\'École de médecine de l\'AOF à Dakar.'],
    ['date' => '1944', 'title' => 'Fondation du SAA', 'description' => 'Crée le Syndicat Agricole Africain pour défendre les planteurs africains.'],
    ['date' => '1945', 'title' => 'Élection comme député', 'description' => 'Élu député à l\'Assemblée constituante française.'],
    ['date' => '1946', 'title' => 'Création du PDCI-RDA', 'description' => 'Fonde le Parti Démocratique de Côte d\'Ivoire, section du Rassemblement Démocratique Africain.'],
    ['date' => '1956-1959', 'title' => 'Ministre en France', 'description' => 'Occupe plusieurs postes ministériels dans des gouvernements français.'],
    ['date' => '1958', 'title' => 'Communauté française', 'description' => 'Joue un rôle clé dans l\'adhésion de la Côte d\'Ivoire à la Communauté française.'],
    ['date' => '1960', 'title' => 'Indépendance', 'description' => 'Proclamation de l\'indépendance de la Côte d\'Ivoire. Devient le premier Président.'],
    ['date' => '1960-1970', 'title' => 'Miracle ivoirien', 'description' => 'Période de forte croissance économique et de stabilité politique.'],
    ['date' => '1983', 'title' => 'Nouvelle capitale', 'description' => 'Transfert de la capitale à Yamoussoukro, sa ville natale.'],
    ['date' => '1990', 'title' => 'Multipartisme', 'description' => 'Instauration du multipartisme en Côte d\'Ivoire.'],
    ['date' => '1993', 'title' => 'Décès', 'description' => 'Décède le 7 décembre après 33 ans de présidence.'],
];
@endphp

@section('content')
<div class="timeline-container-rhdp">
    <header class="timeline-header-rhdp">
        <h1>Chronologie de Félix Houphouët-Boigny</h1>
        <p>
            Retracez les moments marquants de la vie du "Père de la Nation ivoirienne", 
            depuis sa naissance jusqu'à son héritage politique et économique.
        </p>
    </header>

    <div class="timeline-rhdp">
        @foreach ($timelineEvents as $index => $event)
        <div class="timeline-item-rhdp">
            <div class="timeline-card-rhdp">
                <span class="timeline-date-rhdp">{{ $event['date'] }}</span>
                <h3 class="timeline-title-rhdp">{{ $event['title'] }}</h3>
                <p class="timeline-description-rhdp">{{ $event['description'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
