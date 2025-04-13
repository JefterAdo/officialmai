@extends('layouts.app')

{{-- SEO Title --}}
@section('title', 'Biographie de Félix Houphouët-Boigny - Père de la Nation Ivoirienne | RHDP')

{{-- Optional: Add Meta Description (Requires layout modification or a package) --}}
{{-- @section('meta_description', 'Découvrez la vie et l\'héritage de Félix Houphouët-Boigny, premier Président de la Côte d\'Ivoire et figure emblématique du RHDP. Son parcours, de ses débuts à la présidence.') --}}

@section('content')

<div class="container content-inner py-5">
    <div class="row">
        {{-- Main Content Area --}}
        <div class="col-lg-9">
            <article>
                <header class="mb-4">
                    <h1 class="display-5 fw-bold text-primary mb-3">Biographie de Félix Houphouët-Boigny</h1>
                    <p class="lead">
                        Découvrez le parcours exceptionnel de Félix Houphouët-Boigny, premier Président de la Côte d'Ivoire, architecte de l'indépendance et père fondateur de la nation moderne. Son héritage de paix, d'unité et de dialogue continue d'inspirer le RHDP.
                    </p>
                </header>

                <figure class="figure float-md-end ms-md-4 mb-3" style="max-width: 400px;">
                    <img src="{{ asset('images/Felix_Houphouet/Felix_Houphouet.jpg') }}" class="figure-img img-fluid rounded shadow" alt="Portrait de Félix Houphouët-Boigny">
                    <figcaption class="figure-caption text-center">Félix Houphouët-Boigny, le "Sage de l'Afrique".</figcaption>
                </figure>

                <section class="mb-5">
                    <h2 class="h3 fw-semibold mb-3">Jeunesse et Formation</h2>
                    <p>
                        Félix Houphouët-Boigny, né Dia Houphouët le 18 octobre 1905 à N'Gokro (future Yamoussoukro), est issu d'une illustre famille baoulé. Fils de chef, il reçoit une éducation traditionnelle avant d'intégrer l'école primaire de Bingerville. Brillant élève, il est admis à l'École de médecine de Dakar en 1919, devenant major de sa promotion en 1925. Comme médecin auxiliaire, il se distingue par son dévouement envers les populations rurales, ce qui forgera son engagement futur.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="h3 fw-semibold mb-3">Débuts en Politique et Lutte Syndicale</h2>
                    <p>
                        Confronté aux injustices du système colonial, notamment envers les planteurs africains, il fonde en 1944 le Syndicat Agricole Africain (SAA). Ce mouvement devient rapidement une force politique majeure. Élu député à l'Assemblée constituante française en 1945, il œuvre activement pour l'abolition du travail forcé, obtenant gain de cause avec la loi du 11 avril 1946, dite "loi Houphouët-Boigny". Cette victoire historique consolide sa position comme leader incontesté du mouvement nationaliste ivoirien.
                    </p>
                </section>

                <figure class="figure float-md-start me-md-4 mb-3" style="max-width: 450px;">
                    <img src="{{ asset('images/Felix_Houphouet/Félix HOUPHOUËT-BOIGNY le 03 Mai 1976 à Paris ( France ).jpg') }}" class="figure-img img-fluid rounded shadow" alt="Houphouët-Boigny lors d'un discours à Paris">
                    <figcaption class="figure-caption text-center">Félix Houphouët-Boigny lors d'une visite officielle à Paris, le 3 mai 1976.</figcaption>
                </figure>

                <section class="mb-5">
                    <h2 class="h3 fw-semibold mb-3">Vers l'Indépendance</h2>
                    <p>
                        En 1946, Houphouët-Boigny cofonde le Rassemblement Démocratique Africain (RDA), premier grand mouvement panafricain francophone. Après une alliance initiale avec le Parti Communiste Français, il opte en 1950 pour une stratégie de coopération avec la France. Ministre dans plusieurs gouvernements français (1956-1959), il négocie habilement l'autonomie progressive des colonies. Architecte de la Communauté Franco-Africaine (1958), il conduit finalement la Côte d'Ivoire à l'indépendance le 7 août 1960, tout en maintenant des relations privilégiées avec l'ancienne métropole.
                    </p>
                </section>

                <figure class="figure text-center d-block my-5" style="max-width: 100%;">
                    <img src="{{ asset('images/Felix_Houphouet/Presi.jpg') }}" class="figure-img img-fluid rounded shadow" alt="Félix Houphouët-Boigny, Président de la République">
                    <figcaption class="figure-caption text-center">Félix Houphouët-Boigny, Premier Président de la République de Côte d'Ivoire (1960-1993).</figcaption>
                </figure>

                <section class="mb-5">
                    <h2 class="h3 fw-semibold mb-3">La Présidence (1960-1993)</h2>
                    <p>
                        Premier Président de la République indépendante, Houphouët-Boigny bâtit un État stable autour du PDCI-RDA, parti unique de fait. Son règne voit l'émergence du "Miracle Ivoirien" (1960-1980), avec une croissance annuelle moyenne de 7%, portée par les cultures d'exportation (cacao, café). Il modernise les infrastructures (autoroutes, barrage de Kossou) et crée des institutions prestigieuses comme l'Université Félix-Houphouët-Boigny. Sur la scène internationale, il joue un rôle de médiateur dans plusieurs conflits africains et accueille le sommet de l'OUA en 1963. Sa politique de dialogue avec l'Afrique du Sud de l'apartheid, bien que critiquée, s'inscrit dans sa vision de résolution pacifique des conflits. En 1983, il transfère la capitale politique à Yamoussoukro, sa ville natale, où il fait construire la Basilique Notre-Dame-de-la-Paix.
                    </p>
                </section>

                <section class="mb-5">
                    <h2 class="h3 fw-semibold mb-3">Héritage et Philosophie (Paix, Unité, Dialogue)</h2>
                    <p>
                        L'héritage politique d'Houphouët-Boigny se résume en trois piliers fondamentaux : la paix ("La paix n'est pas un mot, c'est un comportement"), l'unité nationale ("Un seul peuple, une seule nation") et le dialogue ("Mieux vaut s'asseoir autour d'une table que de s'affronter sur un champ de bataille"). Ces principes ont permis à la Côte d'Ivoire de rester stable pendant trois décennies malgré sa diversité ethnique et religieuse. Le RHDP, en tant qu'héritier de cette philosophie, continue de promouvoir ces valeurs à travers ses actions politiques et son engagement pour la cohésion sociale. L'Houphouëtisme influence toujours la politique ivoirienne contemporaine, notamment à travers la recherche permanente du consensus et la priorité donnée au développement économique comme facteur de stabilité.
                    </p>
                     <figure class="figure text-center d-block my-4">
                        <img src="{{ asset('images/Felix_Houphouet/Felix_Houphoet_Boigny_paix.jpg') }}" class="figure-img img-fluid rounded shadow" style="max-width: 500px;" alt="Félix Houphouët-Boigny, artisan de la paix">
                        <figcaption class="figure-caption">Félix Houphouët-Boigny, l'artisan de la paix et du dialogue en Côte d'Ivoire.</figcaption>
                    </figure>
                </section>

                <section class="mb-5">
                    <h2 class="h3 fw-semibold mb-3">Fin de vie</h2>
                    <p>
                        Dans les années 1990, la santé déclinante d'Houphouët-Boigny soulève la question cruciale de sa succession. Malgré son hospitalisation en France en 1993, il maintient une activité politique réduite mais symbolique, comme sa dernière apparition publique le 7 octobre 1993 pour l'inauguration de l'ambassade d'Israël. Son décès le 7 décembre 1993 à Yamoussoukro, à l'âge de 88 ans, provoque une émotion nationale et internationale. Ses funérailles officielles le 11 février 1994 rassemblent des dizaines de chefs d'État et de délégations étrangères. Inhumé dans un mausolée spécialement construit à Yamoussoukro, sa disparition marque la fin d'une ère politique et ouvre une période d'incertitude quant à la pérennité de son modèle de gouvernance. Son héritage continue cependant de structurer profondément la vie politique ivoirienne, comme en témoigne la référence constante à l'"Houphouëtisme" dans le débat public contemporain.
                    </p>
                </section>

            </article>
        </div>

        {{-- Sidebar Area --}}
        <div class="col-lg-3">
            <aside class="sticky-top" style="top: 100px;"> {{-- Adjust top offset based on navbar height --}}
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic text-primary">Faits Marquants</h4>
                    <ul class="list-unstyled mb-0">
                        <li><strong>1905:</strong> Naissance à N'Gokro</li>
                        <li><strong>1944:</strong> Fondation du SAA</li>
                        <li><strong>1946:</strong> Co-fondateur du RDA</li>
                        <li><strong>1960:</strong> Indépendance de la Côte d'Ivoire</li>
                        <li><strong>1960-1993:</strong> Président de la République</li>
                        <li><strong>1983:</strong> Yamoussoukro devient capitale</li>
                        <li><strong>1993:</strong> Décès à Yamoussoukro</li>
                    </ul>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic text-primary">Explorer Plus</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none">Chronologie Détaillée</a></li>
                        <li><a href="#" class="text-decoration-none">Discours Emblématiques</a></li>
                        <li><a href="#" class="text-decoration-none">Citations Célèbres</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Styles généraux pour la page biographie */
    article header .lead {
        font-size: 1.1rem;
        color: #6c757d;
    }

    article section h2 {
        color: var(--bs-secondary);
        border-bottom: 2px solid var(--bs-primary);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem !important;
    }

    /* Styles pour les images et figures */
    .figure {
        transition: transform 0.3s ease-in-out;
    }

    .figure:hover {
        transform: scale(1.02);
    }

    .figure-img {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
    }

    .figure-caption {
        margin-top: 0.75rem;
        font-style: italic;
        font-size: 0.9rem;
        color: #495057;
    }

    /* Styles pour la sidebar */
    aside {
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    aside h4 {
        margin-bottom: 1rem;
        color: var(--bs-primary);
        border-bottom: 2px solid var(--bs-primary);
        padding-bottom: 0.5rem;
    }

    aside ul li {
        margin-bottom: 0.75rem;
        padding-left: 1rem;
        position: relative;
    }

    aside ul li::before {
        content: "•";
        color: var(--bs-primary);
        position: absolute;
        left: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .figure.float-md-start,
        .figure.float-md-end {
            float: none !important;
            margin: 1rem auto !important;
            max-width: 100% !important;
        }

        .figure-img {
            width: 100%;
        }
    }
</style>
@endpush
