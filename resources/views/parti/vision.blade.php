@extends('layouts.app')

    @section('title', 'Notre Vision Stratégique pour la Côte d\'Ivoire | Projet RHDP')

    @push('styles')
    <style>
        .vision-section {
            padding: 2.5rem 0;
            border-bottom: 1px solid #e9ecef; /* Light separator */
        }
        .vision-section:last-child {
            border-bottom: none;
        }
        .vision-section h2 {
            color: var(--bs-primary); /* Orange title */
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        .vision-section h2 i {
            font-size: 1.8rem; /* Slightly smaller icon */
            margin-right: 0.75rem;
            color: var(--bs-secondary); /* Green icon */
            width: 40px; /* Fixed width for alignment */
            text-align: center;
        }
        .vision-section ul {
            list-style: none;
            padding-left: 0;
        }
        .vision-section ul li::before {
            content: "\f00c"; /* Font Awesome check icon */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: var(--bs-secondary); /* Green check */
            margin-right: 0.5rem;
        }
    </style>
    @endpush

    @section('content')
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-primary mb-5 text-center">Notre Vision pour la Côte d'Ivoire</h1>

        <p class="lead text-gray-700 mb-8 text-center max-w-3xl mx-auto">
            Le RHDP porte une ambition forte : bâtir une Côte d'Ivoire réconciliée, unie dans sa diversité, résolument engagée sur la voie d'un développement économique accéléré, socialement inclusif et durable, dans la paix et la stabilité retrouvées.
        </p>

        <div class="vision-sections">

            <section class="vision-section">
                <h2><i class="fas fa-handshake"></i>Paix Durable et Cohésion Sociale Renforcée</h2>
                <p class="text-gray-700 mb-4">La paix n'est pas un vain mot, c'est notre préalable absolu. Notre vision est celle d'une nation où le dialogue prime sur la confrontation, où les blessures du passé sont pansées par la justice et la réconciliation, et où chaque Ivoirien se sent partie prenante d'un destin commun.</p>
                <ul>
                    <li>Renforcer les mécanismes de dialogue intercommunautaire et interreligieux.</li>
                    <li>Promouvoir une culture de la paix et de la tolérance à tous les niveaux de la société.</li>
                    <li>Garantir la sécurité pour tous sur l'ensemble du territoire national.</li>
                    <li>Assurer une justice équitable et accessible pour la réparation et la réconciliation.</li>
                </ul>
            </section>

            <section class="vision-section">
                <h2><i class="fas fa-landmark"></i>Démocratie Vivante et État de Droit</h2>
                <p class="text-gray-700 mb-4">Nous aspirons à une démocratie apaisée, où les institutions sont fortes et respectées, où les libertés fondamentales sont garanties, et où chaque citoyen peut participer pleinement à la vie publique.</p>
                <ul>
                    <li>Consolider l'indépendance de la justice et la bonne gouvernance.</li>
                    <li>Renforcer le rôle du Parlement et des collectivités locales.</li>
                    <li>Garantir des élections libres, transparentes et crédibles.</li>
                    <li>Protéger la liberté d'expression et la liberté de la presse.</li>
                </ul>
            </section>

            <section class="vision-section">
                <h2><i class="fas fa-chart-line"></i>Développement Économique Accéléré et Inclusif</h2>
                <p class="text-gray-700 mb-4">Notre objectif est de transformer structurellement notre économie pour créer massivement des emplois, réduire la pauvreté et assurer une prospérité partagée. Nous misons sur l'industrialisation, la modernisation de l'agriculture et le développement des services à forte valeur ajoutée.</p>
                <ul>
                    <li>Attirer les investissements privés nationaux et étrangers.</li>
                    <li>Soutenir l'entrepreneuriat, notamment des jeunes et des femmes.</li>
                    <li>Développer les infrastructures stratégiques (énergie, transport, numérique).</li>
                    <li>Promouvoir une agriculture durable et compétitive.</li>
                    <li>Assurer une gestion rigoureuse et transparente des finances publiques.</li>
                </ul>
                 {{-- Placeholder image --}}
                 {{-- <img src="/images/placeholder_economie.jpg" alt="Illustration développement économique" class="img-fluid rounded my-3"> --}}
            </section>

            <section class="vision-section">
                <h2><i class="fas fa-user-graduate"></i>Éducation de Qualité et Santé Accessible pour Tous</h2>
                <p class="text-gray-700 mb-4">Le capital humain est notre richesse la plus précieuse. Nous voulons garantir à chaque Ivoirien l'accès à une éducation de qualité, de la petite enfance à l'enseignement supérieur et à la formation professionnelle, ainsi qu'à des services de santé modernes et accessibles.</p>
                <ul>
                    <li>Améliorer la qualité de l'enseignement et les conditions d'apprentissage.</li>
                    <li>Développer la formation professionnelle en adéquation avec les besoins du marché du travail.</li>
                    <li>Renforcer l'offre de soins et la couverture sanitaire universelle (CMU).</li>
                    <li>Investir dans les infrastructures scolaires et sanitaires.</li>
                </ul>
            </section>

            <section class="vision-section">
                <h2><i class="fas fa-users"></i>Solidarité Nationale et Protection Sociale</h2>
                <p class="text-gray-700 mb-4">Une nation forte est une nation solidaire. Notre vision inclut le renforcement des mécanismes de protection sociale pour accompagner les plus vulnérables et garantir la dignité de chacun.</p>
                <ul>
                    <li>Étendre la couverture sociale aux travailleurs du secteur informel et agricole.</li>
                    <li>Mettre en place des programmes ciblés d'aide aux familles démunies.</li>
                    <li>Promouvoir l'autonomisation des femmes et l'égalité des chances.</li>
                    <li>Assurer une meilleure prise en charge des personnes âgées et handicapées.</li>
                </ul>
            </section>

             <section class="vision-section">
                <h2><i class="fas fa-gavel"></i>Promotion et Défense des Droits Humains</h2>
                <p class="text-gray-700 mb-4">Le respect des droits fondamentaux de chaque individu est au cœur de notre projet de société. Nous nous engageons à promouvoir et à défendre les droits humains sous toutes leurs formes.</p>
                <ul>
                    <li>Lutter contre toutes les formes de discrimination.</li>
                    <li>Renforcer la protection des droits des femmes et des enfants.</li>
                    <li>Garantir le respect des libertés civiles et politiques.</li>
                    <li>Coopérer avec les organisations nationales et internationales de défense des droits humains.</li>
                </ul>
            </section>

            <section class="vision-section bg-light p-5 rounded mt-5">
                <h2 class="text-secondary"><i class="fas fa-compass"></i>Un Héritage Vivant : L'Houphouëtisme comme Boussole</h2>
                <p class="text-gray-700 mb-4">Cette vision ambitieuse puise ses racines dans la pensée et l'action de Félix Houphouët-Boigny. L'Houphouëtisme, basé sur le pragmatisme, la recherche constante du dialogue, la primauté de la paix et le développement au service de l'homme, reste notre boussole.</p>
                <p class="text-gray-700">Nous adaptons cet héritage précieux aux réalités du XXIe siècle pour construire une Côte d'Ivoire fidèle à ses valeurs fondamentales et résolument tournée vers l'avenir.</p>
                 {{-- Placeholder image --}}
                 {{-- <img src="/images/placeholder_houphouet_vision.jpg" alt="Illustration héritage Houphouët-Boigny" class="img-fluid rounded my-3"> --}}
            </section>

            <section class="mt-8 text-center">
                <h3 class="text-xl font-semibold mb-4">Ensemble, pour une Côte d'Ivoire d'Espoir</h3>
                <p class="text-gray-700 max-w-2xl mx-auto">Le RHDP invite toutes les forces vives de la Nation à se joindre à cet élan pour réaliser ensemble cette vision d'une Côte d'Ivoire réconciliée, prospère et solidaire. C'est par notre unité et notre travail que nous bâtirons l'avenir radieux que mérite notre pays.</p>
            </section>

        </div>
    </main>
    @endsection
