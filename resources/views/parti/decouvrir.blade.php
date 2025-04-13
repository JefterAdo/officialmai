@extends('layouts.app')

    @section('title', 'Découvrir le RHDP - Histoire, Valeurs et Mission | Rassemblement des Houphouëtistes')

    @push('styles')
    <style>
        .value-block {
            background-color: #f8f9fa;
            border-left: 5px solid var(--bs-secondary);
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            transition: transform 0.3s ease;
        }
        .value-block:hover {
            transform: translateY(-5px);
        }
        .value-block h3 {
            color: var(--bs-secondary);
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .image-card {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .image-card:hover {
            transform: scale(1.02);
        }
        .image-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .section-divider {
            height: 4px;
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
            margin: 3rem 0;
            border-radius: 2px;
        }
        .hero-section {
            position: relative;
            padding: 3rem 0;
            background-color: #f8f9fa;
            border-radius: 1rem;
            overflow: hidden;
            margin-bottom: 3rem;
        }
        .hero-image {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            object-fit: cover;
            border-radius: 0 1rem 1rem 0;
        }
    </style>
    @endpush

    @section('content')
    <main class="container mx-auto px-4 py-8">
        <div class="hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 pe-lg-5">
                        <h1 class="text-3xl font-bold text-primary mb-4">Découvrir le RHDP</h1>
                        <p class="lead text-gray-700 mb-6">
                            Le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) est la force politique majeure engagée pour la stabilité, l'unité et le développement durable de la Côte d'Ivoire, fidèle à l'héritage du Président Félix Houphouët-Boigny.
                        </p>
                    </div>
                </div>
            </div>
            <img src="{{ asset('images/RHDP/photo_2025-04-05_19-08-05.jpg') }}" alt="RHDP Rassemblement" class="hero-image">
        </div>

        <div class="section-divider"></div>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-4">Nos Racines et Notre Histoire</h2>
            <div class="md:flex md:items-center">
                <div class="md:w-2/3 md:pr-8">
                    <p class="text-gray-700 mb-4">
                        Né de la volonté de rassembler les Ivoiriens autour des idéaux de paix et de dialogue prônés par le Père de la Nation, Félix Houphouët-Boigny, le RHDP incarne la continuité de sa vision pour une Côte d'Ivoire unie et prospère.
                    </p>
                    <div class="image-gallery">
                        <div class="image-card">
                            <img src="{{ asset('images/RHDP/photo_2025-04-05_19-09-46.jpg') }}" alt="Histoire du RHDP">
                        </div>
                        <div class="image-card">
                            <img src="{{ asset('images/RHDP/photo_2025-04-05_19-08-38.jpg') }}" alt="Rassemblement RHDP">
                        </div>
                    </div>
                    <p class="text-gray-700 mt-4">
                        Depuis sa création en 2005, le RHDP a su naviguer à travers les tumultes politiques et sociaux pour devenir une force majeure dans le paysage politique ivoirien. Ce parti, sous la direction éclairée de SEM. Alassane Ouattara, incarne l'espoir d'une Côte d'Ivoire unie, prospère et démocratique.
                    </p>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-4">Nos Valeurs Fondamentales</h2>
            <div class="image-gallery mb-5">
                <div class="image-card">
                    <img src="{{ asset('images/RHDP/photo_2025-04-05_19-10-40.jpg') }}" alt="Valeurs du RHDP">
                </div>
                <div class="image-card">
                    <img src="{{ asset('images/RHDP/photo_2025-04-05_19-06-55.jpg') }}" alt="Unité RHDP">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="value-block">
                    <h3><i class="fas fa-hands-helping me-2"></i>Paix & Dialogue</h3>
                    <p>La recherche constante du consensus et de la paix par le dialogue est notre priorité absolue.</p>
                </div>
                <div class="value-block">
                    <h3><i class="fas fa-users me-2"></i>Unité & Rassemblement</h3>
                    <p>Nous croyons en la force de l'unité nationale et du rassemblement de toutes les composantes de la société.</p>
                </div>
                <div class="value-block">
                    <h3><i class="fas fa-briefcase me-2"></i>Travail & Développement</h3>
                    <p>Le travail acharné est la clé du progrès économique et social pour tous les Ivoiriens.</p>
                </div>
                <div class="value-block">
                    <h3><i class="fas fa-heart me-2"></i>Solidarité</h3>
                    <p>Nous promouvons une société plus juste et solidaire, où personne n'est laissé pour compte.</p>
                </div>
                <div class="value-block">
                    <h3><i class="fas fa-balance-scale me-2"></i>Démocratie & État de Droit</h3>
                    <p>Nous sommes attachés aux principes démocratiques, au respect des institutions et des libertés.</p>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-4">Notre Mission Aujourd'hui</h2>
            <div class="md:flex md:items-center">
                <div class="md:w-1/3 mb-4 md:mb-0 md:mr-8">
                    <div class="image-card">
                        <img src="{{ asset('images/RHDP/photo_2025-04-05_19-10-22.jpg') }}" alt="Mission du RHDP" class="img-fluid rounded shadow-sm">
                    </div>
                </div>
                <div class="md:w-2/3">
                    <p class="text-gray-700 mb-4">
                        Aujourd'hui, le RHDP poursuit sa mission de bâtir une Côte d'Ivoire moderne, stable et prospère. Notre action se concentre sur la consolidation de la paix, la transformation économique, l'amélioration des conditions de vie de nos concitoyens et le renforcement de la cohésion sociale.
                    </p>
                    <div class="image-gallery">
                        <div class="image-card">
                            <img src="{{ asset('images/RHDP/photo_2025-04-05_19-06-50.jpg') }}" alt="Actions du RHDP">
                        </div>
                        <div class="image-card">
                            <img src="{{ asset('images/RHDP/photo_2025-04-05_19-06-45.jpg') }}" alt="Engagement RHDP">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection
