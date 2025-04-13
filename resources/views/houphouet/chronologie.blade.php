@extends('layouts.app')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-orange-600 mb-6">Chronologie de Félix Houphouët-Boigny</h1>
    
    <p class="text-gray-700 mb-8">
        Retracez les moments marquants de la vie du "Père de la Nation ivoirienne", 
        depuis sa naissance jusqu'à son héritage politique et économique.
    </p>

    <div class="timeline">
        <!-- Timeline items will be added here -->
        <div class="timeline-item">
            <div class="timeline-date">1905</div>
            <div class="timeline-content">
                <h3>Naissance</h3>
                <p>Naissance officielle de Félix Houphouët-Boigny (date exacte débattue).</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1925</div>
            <div class="timeline-content">
                <h3>Diplôme de médecine</h3>
                <p>Obtient son diplôme de l'École de médecine de l'AOF à Dakar.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1944</div>
            <div class="timeline-content">
                <h3>Fondation du SAA</h3>
                <p>Crée le Syndicat Agricole Africain pour défendre les planteurs africains.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1945</div>
            <div class="timeline-content">
                <h3>Élection comme député</h3>
                <p>Élu député à l'Assemblée constituante française.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1946</div>
            <div class="timeline-content">
                <h3>Création du PDCI-RDA</h3>
                <p>Fonde le Parti Démocratique de Côte d'Ivoire, section du Rassemblement Démocratique Africain.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1956-1959</div>
            <div class="timeline-content">
                <h3>Ministre en France</h3>
                <p>Occupe plusieurs postes ministériels dans des gouvernements français.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1958</div>
            <div class="timeline-content">
                <h3>Communauté française</h3>
                <p>Joue un rôle clé dans l'adhésion de la Côte d'Ivoire à la Communauté française.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1960</div>
            <div class="timeline-content">
                <h3>Indépendance</h3>
                <p>Proclamation de l'indépendance de la Côte d'Ivoire. Devient le premier Président.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1960-1970</div>
            <div class="timeline-content">
                <h3>Miracle ivoirien</h3>
                <p>Période de forte croissance économique et de stabilité politique.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1983</div>
            <div class="timeline-content">
                <h3>Nouvelle capitale</h3>
                <p>Transfert de la capitale à Yamoussoukro, sa ville natale.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1990</div>
            <div class="timeline-content">
                <h3>Multipartisme</h3>
                <p>Instauration du multipartisme en Côte d'Ivoire.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-date">1993</div>
            <div class="timeline-content">
                <h3>Décès</h3>
                <p>Décède le 7 décembre après 33 ans de présidence.</p>
            </div>
        </div>
    </div>
</main>
@endsection
