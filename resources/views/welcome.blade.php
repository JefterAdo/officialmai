@extends('layouts.app')

@section('title', 'Accueil - RHDP')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    $slides = App\Models\Slide::where('is_active', true)->orderBy('order')->get();
@endphp

@section('content')
    <!-- Slider classique réintégré -->
    @include('components.home.slider-alt')

    <!-- Section Flash Info modernisée -->
    @if(isset($flashInfos) && $flashInfos->isNotEmpty())
        <section class="flash-info-bar position-relative" style="background: #f28c03; border-radius: 1rem; box-shadow: 0 4px 16px rgba(0,0,0,0.08); margin: 2rem 0; overflow:hidden;">
            <div class="container py-2 d-flex align-items-center justify-content-center position-relative" style="min-height:48px;">
                <span class="flash-info-label d-inline-flex align-items-center px-3 py-1 me-3 position-absolute start-0 top-50 translate-middle-y flash-info-mask" style="background:#f28c03; color:#fff; font-weight:700; border-radius:2rem; font-size:1.1rem; letter-spacing:0.05em; z-index:2; box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    <i class="fas fa-bullhorn me-2" style="font-size:1.3em; color:#fff200;"></i> Flash Info
                </span>
                <div class="w-100" style="overflow:hidden; position: relative;">
                    <div style="width: 100%; overflow: hidden;">
                        <div class="flash-info-wrapper" style="display: inline-block; white-space: nowrap; padding: 0 20px;">
                            <!-- Premier passage du texte -->
                            <span class="flash-info-text-inner-animated d-inline-block">
                                @foreach($flashInfos as $index => $flashInfo)
                                    {{ $flashInfo->message }}
                                    @if(!$loop->last)
                                        <span class="mx-3" style="font-weight:bold;">—</span>
                                    @endif
                                @endforeach
                            </span>
                            <!-- Dupliquer le contenu pour une transition fluide -->
                            <span class="flash-info-text-inner-animated d-inline-block">
                                @foreach($flashInfos as $index => $flashInfo)
                                    {{ $flashInfo->message }}
                                    @if(!$loop->last)
                                        <span class="mx-3" style="font-weight:bold;">—</span>
                                    @endif
                                @endforeach
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Actualités Section -->
    <section class="content-inner-1 py-5" data-aos="fade-up">
        <div class="container">
            <div class="section-head text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <h5 class="sub-title" style="color: #f28c03;">ACTUALITÉS</h5>
                <h2>Dernières Nouvelles du Parti</h2>
            </div>
            <div class="row">
                @php
                    $latestNews = App\Models\News::with('category')
                        ->where('is_published', true)
                        ->orderBy('published_at', 'desc')
                        ->take(3)
                        ->get();
                @endphp

                @forelse($latestNews as $article)
                <div class="col-lg-4 col-md-6 mb-4 d-flex">
                    <div class="card news-card border-0 shadow-sm w-100" style="display: flex; flex-direction: column; height: 100%;">
                        <div class="card-img-top-wrapper position-relative" style="height: 160px; overflow: hidden; flex-shrink: 0;">
                            @if($article->featured_image)
                                <img src="/storage/{{ $article->featured_image }}" 
                                     class="h-100 w-100" 
                                     style="object-fit: cover; transition: transform 0.3s ease;"
                                     alt="{{ $article->title }}">
                            @else
                                <img src="{{ asset('images/le_RHDP_Côte_d_Ivoire.png') }}" 
                                     class="h-100 w-100"
                                     style="object-fit: contain; padding: 20px; background: #f8f9fa;"
                                     alt="Image par défaut">
                            @endif
                            @if($article->category)
                            <div class="position-absolute top-3 start-3">
                                <span class="badge" style="background-color: #f28c03; font-size: 0.7rem; padding: 0.35em 0.65em;">
                                    {{ $article->category->name }}
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-3" style="flex: 1 0 auto;">
                            <div class="d-flex align-items-center mb-2" style="font-size: 0.75rem; color: #6c757d;">
                                <span>
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $article->published_at->locale('fr')->isoFormat('LL') }}
                                </span>
                                <span class="mx-2">•</span>
                                <span>
                                    <i class="far fa-clock me-1"></i>
                                    {{ $article->formatted_reading_time }}
                                </span>
                            </div>
                            <h5 class="card-title mb-1" style="font-size: 1.05rem; font-weight: 600; line-height: 1.4; margin: 0; padding: 0; min-height: 2.8em;">
                                @php
                                    $maxWords = 18;
                                    $title = $article->clean_title;
                                    // Découpage du titre en mots en préservant les guillemets et autres caractères spéciaux
                                    $words = preg_split('/\s+/u', $title);
                                    $truncated = implode(' ', array_slice($words, 0, $maxWords));
                                    if (count($words) > $maxWords) {
                                        $truncated .= '...';
                                    }
                                @endphp
                                {!! htmlspecialchars($truncated, ENT_QUOTES, 'UTF-8', false) !!}
                            </h5>
                            <p class="text-muted small mb-2" style="font-size: 0.85rem; line-height: 1.4;">
                                @php
                                    $description = !empty($article->meta_description) 
                                        ? $article->meta_description 
                                        : Str::limit(strip_tags($article->content), 160);
                                @endphp
                                {{ $description }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('actualites.show', $article->slug) }}" class="btn btn-sm" style="background-color: #f28c03; border-color: #f28c03; color: white; font-size: 0.8rem; font-weight: 500; padding: 0.3rem 0.8rem;">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                                <div class="d-flex align-items-center" style="font-size: 0.8rem; color: #6c757d;">
                                    <span class="me-2">Par RHDP</span>
                                    <img src="{{ asset('images/rhdp_logo.png') }}" 
                                         style="width: 24px; height: 24px; object-fit: contain;"
                                         alt="Logo RHDP">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Aucune actualité disponible pour le moment.
                    </div>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('actualites.index') }}" class="btn" style="background-color: #f28c03; border-color: #f28c03; color: white;">
                    Voir toutes les actualités
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Nos Valeurs Section -->
    <section class="py-5" style="background-color: #f28c03;" data-aos="fade-up">
        <div class="container">
            <div class="section-head text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <h5 class="sub-title text-white">NOS VALEURS</h5>
                <h2 class="text-white">Les Piliers de Notre Engagement</h2>
            </div>
            <div class="row g-4 justify-content-center">
                <!-- Value Item 1: Paix -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-dove"></i>
                        </div>
                        <h4 class="value-title">Paix & Cohésion</h4>
                        <p class="value-description">Promouvoir l'unité nationale et la réconciliation pour un avenir serein.</p>
                    </div>
                </div>
                <!-- Value Item 2: Démocratie -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-person-booth"></i>
                        </div>
                        <h4 class="value-title">Démocratie</h4>
                        <p class="value-description">Renforcer les institutions républicaines et garantir les libertés fondamentales.</p>
                    </div>
                </div>
                <!-- Value Item 3: Développement -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h4 class="value-title">Développement</h4>
                        <p class="value-description">Accélérer la croissance économique et améliorer les conditions de vie.</p>
                    </div>
                </div>
                <!-- Value Item 4: Éducation/Santé -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-book-medical"></i>
                        </div>
                        <h4 class="value-title">Éducation & Santé</h4>
                        <p class="value-description">Assurer l'accès à une éducation de qualité et à des soins pour tous.</p>
                    </div>
                </div>
                <!-- Value Item 5: Solidarité -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-people-group"></i>
                        </div>
                        <h4 class="value-title">Solidarité</h4>
                        <p class="value-description">Lutter contre les inégalités et soutenir les plus vulnérables.</p>
                    </div>
                </div>
                <!-- Value Item 6: Droits Humains -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <h4 class="value-title">Droits Humains</h4>
                        <p class="value-description">Protéger et promouvoir les droits de chaque citoyen.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Le Parti Section -->
    <section class="party-structure-section py-5" data-aos="fade-up">
        <div class="container">
            <div class="section-head text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <h5 class="sub-title" style="color: #f28c03;">LE PARTI</h5>
                <h2>Notre Organisation</h2>
                <p>Une structure solide au service de la Côte d'Ivoire.</p>
            </div>

            <!-- Président en avant -->
            <div class="president-highlight mb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <a href="{{ route('president.presentation') }}" class="text-decoration-none">
                            <div class="president-card text-center">
                                <div class="president-image-wrapper mb-4">
                                    <img src="{{ asset('images/membres/Alassane_Outtara.png') }}" class="img-fluid rounded-circle" alt="Président du Parti">
                                </div>
                                <h3 class="president-name">SEM Alassane Ouattara</h3>
                                <p class="president-title" style="color: #f28c03;">Président du RHDP</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Direction -->
            <div class="row justify-content-center g-4">
                <!-- Vice-Présidents -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/beugre.webp') }}" class="img-fluid rounded-circle" alt="Vice-Président">
                        </div>
                        <h5 class="team-member-name">M. Robert Beugré Mambé</h5>
                        <p class="team-member-title" style="color: #f28c03;">Vice-Président</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/kandia-camara.jpg') }}" class="img-fluid rounded-circle" alt="Vice-Présidente">
                        </div>
                        <h5 class="team-member-name">Mme Kandia Camara</h5>
                        <p class="team-member-title" style="color: #f28c03;">Vice-Présidente</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                     <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/M. ABDALLAH TOIKEUSSE MABRI.jpg') }}" class="img-fluid rounded-circle" alt="Vice-Président">
                        </div>
                        <h5 class="team-member-name">M. Abdallah Toikeusse Mabri</h5>
                        <p class="team-member-title" style="color: #f28c03;">Vice-Président</p>
                    </div>
                </div>
                <!-- Trésorier Général -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/Tene-Brahima-Ouattara.jpeg') }}" class="img-fluid rounded-circle" alt="Trésorier Général">
            </div>
                        <h5 class="team-member-name">M. Tene Birahima Ouattara</h5>
                        <p class="team-member-title" style="color: #f28c03;">Trésorier Général</p>
                </div>
                </div>
                <!-- Porte-Paroles -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/Kobenan_Kouassi_Adjoumani.jpg') }}" class="img-fluid rounded-circle" alt="Porte-Parole Principal">
                        </div>
                        <h5 class="team-member-name">M. Kouassi Kobenan Adjoumani</h5>
                        <p class="team-member-title" style="color: #f28c03;">Porte-Parole Principal</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/mamadou-toure.jpg') }}" class="img-fluid rounded-circle" alt="Porte-Parole Adjoint">
                        </div>
                        <h5 class="team-member-name">M. Mamadou Touré</h5>
                        <p class="team-member-title" style="color: #f28c03;">Porte-Parole Adjoint</p>
                    </div>
                </div>
                <!-- Secrétaire Exécutif -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/cisse-bacongo.webp') }}" class="img-fluid rounded-circle" alt="Secrétaire Exécutif">
                        </div>
                        <h5 class="team-member-name">M. Bacongo Ibrahima Cisse</h5>
                        <p class="team-member-title" style="color: #f28c03;">Secrétaire Exécutif</p>
                    </div>
                </div>
                <!-- Chargés de Mission -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/felix-anoble.jpg') }}" class="img-fluid rounded-circle" alt="Chargé de Mission">
                        </div>
                        <h5 class="team-member-name">M. Félix Anoblé</h5>
                        <p class="team-member-title" style="color: #f28c03;">Chargé de la Stratégie Électorale</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('parti.organisation') }}" class="btn btn-primary">Voir l'organigramme complet</a>
            </div>
        </div>
    </section>

    <!-- Nos Réalisations Section -->
    <section class="achievements-section py-5" data-aos="fade-up">
        <div class="container">
            <div class="section-head text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <h5 class="sub-title" style="color: #f28c03;">LE RHDP EN ACTION</h5>
                <h2>Nos Réalisations</h2>
                <p class="mt-3">Découvrez les actions concrètes menées par le RHDP pour le développement de la Côte d'Ivoire et le bien-être de ses citoyens.</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                @php
                    $achievements = App\Models\Achievement::where('is_active', true)
                        ->orderBy('order')
                        ->get();
                @endphp

                @forelse($achievements as $achievement)
                    <div class="col-lg-4 col-md-6">
                        <div class="achievement-card h-100 text-center p-4 bg-white shadow-sm rounded">
                            <div class="achievement-icon mb-3">
                                <i class="{{ $achievement->icon }}"></i>
                            </div>
                            <h4 class="achievement-title mb-3">{{ $achievement->title }}</h4>
                            <p class="achievement-description text-muted">{{ $achievement->description }}</p>
                        </div>
                    </div>
                @empty
                    <!-- Réalisations par défaut si aucune n'est définie dans l'admin -->
                    <div class="col-lg-4 col-md-6">
                        <div class="achievement-card h-100 text-center p-4 bg-white shadow-sm rounded">
                            <div class="achievement-icon mb-3">
                                <i class="fas fa-road-bridge"></i>
                            </div>
                            <h4 class="achievement-title mb-3">Infrastructures</h4>
                            <p class="achievement-description text-muted">Routes, ponts, et projets structurants.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="achievement-card h-100 text-center p-4 bg-white shadow-sm rounded">
                            <div class="achievement-icon mb-3">
                                <i class="fas fa-school"></i>
                            </div>
                            <h4 class="achievement-title mb-3">Éducation</h4>
                            <p class="achievement-description text-muted">Construction et réhabilitation d'écoles.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="achievement-card h-100 text-center p-4 bg-white shadow-sm rounded">
                            <div class="achievement-icon mb-3">
                                <i class="fas fa-hospital"></i>
                            </div>
                            <h4 class="achievement-title mb-3">Santé</h4>
                            <p class="achievement-description text-muted">Accès aux soins et couverture maladie.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="achievement-card h-100 text-center p-4 bg-white shadow-sm rounded">
                            <div class="achievement-icon mb-3">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <h4 class="achievement-title mb-3">Économie</h4>
                            <p class="achievement-description text-muted">Croissance soutenue et investissements.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="achievement-card h-100 text-center p-4 bg-white shadow-sm rounded">
                            <div class="achievement-icon mb-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4 class="achievement-title mb-3">Sécurité</h4>
                            <p class="achievement-description text-muted">Paix retrouvée et sécurité renforcée.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="achievement-card h-100 text-center p-4 bg-white shadow-sm rounded">
                            <div class="achievement-icon mb-3">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h4 class="achievement-title mb-3">Emploi</h4>
                            <p class="achievement-description text-muted">Programmes pour l'emploi des jeunes.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary">Voir le Bilan Détaillé</a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5" style="background-color: #f28c03;" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-4 text-white mb-4 mb-lg-0">
                     <div class="section-head mb-0">
                        <h5 class="sub-title text-white">NEWSLETTER</h5>
                        <h2 class="title text-white">Inscrivez-vous</h2>
                        <p>Recevez toutes les informations et actualités de votre parti.</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="dzForm">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <input name="email" required="required" type="email" class="form-control form-control-lg" placeholder="Entrez votre adresse mail">
                            </div>
                            <div class="col-md-4">
                                <button name="submit" value="Submit" type="submit" class="btn btn-dark btn-lg w-100">S'inscrire</button>
                            </div>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->has('email'))
                            <div class="alert alert-danger mt-3">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Prevent white flash during loading */
    body {
        background-color: #f28c03;
    }
    
    /* Style pour les images du slider */
    .slider-bg-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    /* Modern Hero Slider Styles */
    #modernHeroSlider {
        margin: 0;
        padding: 0;
        line-height: 0;
    }

    .slider-item {
        position: relative;
        height: 80vh;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .slider-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    .slider-content-container {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
        max-width: 800px;
        margin: 0 auto;
    }

    .slider-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .slider-description {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
            height: 60vh;
        }

        .slider-title {
            font-size: 2.5rem;
        }

        .slider-description {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .slider-item {
            height: 50vh;
        }

        .slider-title {
            font-size: 2rem;
        }

        .slider-description {
            font-size: 1rem;
        }
    }

    /* Hero Banner Styles */
    .hero-banner-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 3;
        width: 90%; /* Adjust width as needed */
        max-width: 1200px; /* Optional max-width */
        border-radius: 10px;
        overflow: hidden; /* Ensures gradient stays within bounds */
        background-image: url('{{ asset('images/Alassane Ouattara_Président.jpg') }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        color: #FFFFFF; /* Default text color */
    }

    .hero-banner-overlay {
        /* Gradient overlay */
        background: linear-gradient(to top right, rgba(45, 45, 45, 0.85), rgba(45, 45, 45, 0.4)); /* #2d2d2d at 85% to 40% opacity */
        padding: 3rem 2rem; /* Default padding */
        border-radius: 10px; /* Match parent */
        height: 100%;
        display: flex;
        align-items: center; /* Vertically center content */
    }

    .hero-banner-inner-content {
        width: 100%;
    }

    .hero-subtitle {
        color: #f28c03; /* Orange color, !important to override potential conflicts */
        font-size: 1.1em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }

    .hero-title {
        color: #FFFFFF;
        font-size: clamp(2.5rem, 6vw, 4.5rem); /* Fluid font size */
        font-weight: 700; /* Bold */
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    .hero-description {
        color: #FFFFFF;
        font-size: 1.15em;
        font-weight: 400;
        max-width: 60ch; /* Limit width for readability */
        margin-bottom: 2.5rem;
    }

    .hero-cta-container {
        display: flex;
        gap: 1rem; /* Space between buttons */
        flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
        align-items: center; /* Align items vertically */
    }

    .hero-btn-primary,
    .hero-btn-secondary {
        font-size: 1rem;
        font-weight: 600;
        padding: 0.8em 2em;
        border-radius: 6px;
        transition: all 0.2s ease-in-out;
        display: inline-flex; /* Align icon and text */
        align-items: center;
        justify-content: center;
        text-decoration: none; /* Remove underline from links styled as buttons */
    }

    .hero-btn-primary {
        background-color: #f28c03; /* Orange RHDP */
        color: #FFFFFF;
        border: none;
    }

    .hero-btn-primary:hover,
    .hero-btn-primary:focus {
        background-color: #e67e00; /* Darker orange RHDP */
        color: #FFFFFF;
        transform: scale(1.03);
        filter: brightness(110%);
        outline: 2px solid #FFDA63; /* Clear focus indicator */
        outline-offset: 2px;
    }

    .hero-btn-secondary {
        background-color: transparent;
        color: #FFFFFF;
        border: 2px solid #FFFFFF;
    }

    .hero-btn-secondary:hover,
    .hero-btn-secondary:focus {
        background-color: #FFFFFF;
        color: #2d2d2d; /* Dark text on white background */
        border-color: #FFFFFF;
        outline: 2px solid #FFDA63; /* Clear focus indicator */
         outline-offset: 1px; /* Adjust offset for border */
    }

    .hero-btn-primary i,
    .hero-btn-secondary i {
        margin-left: 0.5em;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .hero-banner-container {
            width: 95%; /* Slightly wider on mobile */
        }
        .hero-banner-overlay {
            padding: 2rem 1rem; /* Reduced padding on mobile */
        }
        .hero-text-column {
            text-align: center !important; /* Force center alignment */
        }
        .hero-description {
            max-width: 90%; /* Allow slightly wider text */
            margin-left: auto;
            margin-right: auto;
        }
        .hero-cta-container {
            justify-content: center; /* Center buttons */
            flex-direction: column; /* Stack buttons */
            width: 100%;
        }
        .hero-btn-primary,
        .hero-btn-secondary {
            width: 80%; /* Make buttons wider */
            margin-bottom: 0.5rem; /* Add space when stacked */
        }
         .hero-btn-primary:last-child,
         .hero-btn-secondary:last-child {
             margin-bottom: 0;
         }
    }


    /* Flash Info Bar Styles */
    .flash-info-bar {
        /* Using example green gradient - adjust colors as needed */
        background: linear-gradient(90deg, #006400, #2E8B57); /* DarkGreen to SeaGreen */
        color: #FFFFFF;
        padding: 0.6rem 1.5rem; /* Adjusted padding */
        position: relative; /* Needed if using marquee later */
        z-index: 2; /* Ensure it's above carousel if needed */
        overflow: hidden; /* For potential marquee */
    }
    .flash-info-bar .container {
        display: flex;
        align-items: center;
        flex-wrap: nowrap; /* Prevent wrapping for now */
        white-space: nowrap; /* Prevent wrapping for now */
        overflow: hidden; /* Assure que le texte qui sort est caché */
    }
    .flash-info-label {
        font-weight: 600; /* Bolder label */
        display: inline-flex;
        align-items: center;
        flex-shrink: 0; /* Prevent label from shrinking */
    }
    .flash-info-label i {
        font-size: 1.1em; /* Slightly larger icon */
        margin-right: 0.5rem; /* Space after icon */
        color: #FFEB3B; /* Example: Yellow icon color */
    }
    /* Styles pour le conteneur wrapper */
    .flash-info-text {
        font-weight: 500; /* La graisse de la police peut rester sur le wrapper */
        margin-left: 1rem; /* Espace après le label "FLASH INFO" */
        display: inline-block; /* Se comporte comme un bloc mais s'insère dans le flux inline */
        overflow: hidden; /* TRÈS IMPORTANT: ceci va clipper l'enfant animé */
        vertical-align: middle; /* Pour un meilleur alignement vertical avec le label */
        position: relative; /* Bon pour contenir des enfants transformés/animés */
        /* flex-grow: 1; /* Optionnel: si vous voulez qu'il prenne toute la place restante */
        /* min-width: 0; /* Optionnel: avec flex-grow pour gérer le débordement */
    }

    /* Styles pour le texte animé réel à l'intérieur du wrapper */
    .flash-info-text-inner-animated {
        display: inline-block; /* Nécessaire pour que la transformation fonctionne et que la largeur s'adapte au contenu */
        white-space: nowrap; /* Garde tous les messages sur une seule ligne */
        animation: marquee 35s linear infinite; /* L'animation de défilement */
    }

    /* Marquee Animation */
    @keyframes marquee {
        0%   { transform: translateX(0); }   /* Commence visible, juste après le label */
        100% { transform: translateX(-100%); } /* Se déplace de sa propre largeur vers la gauche */
    }
    /* Ensure container allows overflow for marquee */
    .flash-info-bar .container { 
        /* overflow: hidden; /* Optionnel: si vous voulez clipper strictement au conteneur */ 
    }
    /* .flash-info-text { display: inline-block; padding-left: 100%; } */ /* Déjà intégré ci-dessus */


    /* Other existing styles */
    .main-bnr-two {
        position: relative;
        color: #fff; /* Ensure text is visible on background */
    }
    .main-bnr-two::before { /* Optional overlay */
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4); /* Dark overlay */
        z-index: 1;
    }
    .main-bnr-two .container {
        position: relative;
        z-index: 2;
    }
    .video-btn {
        /* Style the play button */
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        padding: 10px 15px;
        color: white;
        transition: background 0.3s ease;
    }
    .video-btn:hover {
        background: rgba(0,0,0,0.8);
        color: #f28c03; /* Orange RHDP */
    }
    .card-img-top img {
        aspect-ratio: 16 / 9;
        object-fit: cover;
    }
    /* Ensure carousel images are visible and adjust height */
    #heroCarousel .carousel-item {
        height: 55vh; /* Reduced height slightly */
        min-height: 380px; /* Adjusted min-height */
        background-size: cover;
        background-position: center center;
    }
    /* Removed unnecessary styles for flash-info */

    .president-highlight {
        position: relative;
        margin-bottom: 4rem;
    }
    .president-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 2px solid #f28c03;
    }
    .president-image-wrapper {
        width: 200px;
        height: 200px;
        margin: 0 auto;
        border: 3px solid #f28c03;
        border-radius: 50%;
        overflow: hidden;
        padding: 5px;
    }
    .president-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .president-name {
        font-size: 2rem;
        font-weight: 700;
        color: #f28c03;
        margin-bottom: 0.5rem;
    }
    .president-title {
        font-size: 1.2rem;
        font-weight: 600;
    }
    .team-member {
        background: #fff;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    .team-member:hover {
        transform: translateY(-5px);
    }
    .team-member-img {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border: 2px solid #f28c03;
        border-radius: 50%;
        overflow: hidden;
        padding: 3px;
    }
    .team-member-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .team-member-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .team-member-title {
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Styles pour la section Nos Valeurs */
    .values-section {
        background-color: #f28c03 !important;
        padding: 80px 0;
    }

    .value-item {
        padding: 30px 20px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .value-icon {
        font-size: 3rem;
        margin-bottom: 20px;
        color: white;
    }

    .value-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: white;
        font-weight: 600;
    }

    .value-description {
        color: white;
        font-size: 1rem;
        line-height: 1.6;
    }

    .value-item:hover {
        transform: translateY(-5px);
    }

    .value-item:hover .value-icon {
        transform: scale(1.1);
    }
    
    /* Styles pour la section Nos Réalisations */
    .achievements-section {
        background-color: #f8f9fa;
        padding: 80px 0;
    }
    
    .achievement-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 30px 20px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .achievement-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .achievement-icon {
        font-size: 3rem;
        margin-bottom: 20px;
        color: #FF8C00;
        transition: all 0.3s ease;
        height: 80px;
        width: 80px;
        line-height: 80px;
        border-radius: 50%;
        background-color: rgba(255, 140, 0, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .achievement-card:hover .achievement-icon {
        transform: scale(1.1);
        background-color: rgba(255, 140, 0, 0.2);
    }
    
    .achievement-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }
    
    .achievement-description {
        color: #6c757d;
        font-size: 1rem;
        line-height: 1.6;
    }

    .flash-info-mask {
        background: #f28c03 !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: absolute;
        left: 2rem;
        z-index: 2;
    }
    .flash-info-bar {
        position: relative;
        overflow: hidden;
    }
    .flash-info-text-inner-animated {
        transition: transform 0.5s cubic-bezier(0.4,0,0.2,1), opacity 0.4s;
    }
</style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashWrapper = document.querySelector('.flash-info-wrapper');
            const flashText = document.querySelector('.flash-info-text-inner-animated');
            
            if (!flashWrapper || !flashText) return;
            
            // Fonction pour gérer l'animation de défilement
            function animateFlashInfo() {
                const container = flashWrapper.parentElement.parentElement;
                const containerWidth = container.offsetWidth;
                const textWidth = flashText.offsetWidth;
                
                // Si le texte est plus large que le conteneur, on active le défilement
                if (textWidth > containerWidth) {
                    const duration = (textWidth / 30) * 1000; // Vitesse de défilement (px/s)
                    
                    // Réinitialiser la position
                    flashWrapper.style.transition = 'none';
                    flashWrapper.style.transform = 'translateX(0)';
                    
                    // Forcer un recalcul du style pour appliquer la réinitialisation
                    void flashWrapper.offsetWidth;
                    
                    // Démarrer l'animation
                    flashWrapper.style.transition = `transform ${duration}ms linear`;
                    flashWrapper.style.transform = `translateX(-${textWidth}px)`;
                    
                    // Réinitialiser l'animation une fois terminée
                    setTimeout(() => {
                        // Réinitialiser sans transition pour éviter les clignotements
                        flashWrapper.style.transition = 'none';
                        flashWrapper.style.transform = 'translateX(0)';
                        // Démarrer une nouvelle animation après un court délai
                        setTimeout(animateFlashInfo, 20);
                    }, duration);
                }
            }
            
            // Attendre que les polices soient chargées avant de calculer les dimensions
            document.fonts.ready.then(() => {
                // Démarrer l'animation après un court délai
                setTimeout(animateFlashInfo, 1000);
                
                // Redémarrer l'animation lors du redimensionnement de la fenêtre
                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => {
                        // Réinitialiser l'animation
                        flashWrapper.style.transition = 'none';
                        flashWrapper.style.transform = 'translateX(0)';
                        // Redémarrer après un court délai
                        setTimeout(animateFlashInfo, 100);
                    }, 250);
                });
            });
        });
    </script>
    
    <!-- Script de correction pour le carousel -->
    <script src="{{ asset('js/carousel-fix.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser tous les carousels Tailwind sur la page
        const carousels = document.querySelectorAll('[data-carousel]');
        carousels.forEach(carousel => {
            new TailwindCarousel(carousel, {
                interval: 5000,
                autoplay: true,
                wrap: true
            });
        });
        
        console.log('Carousels initialisés:', carousels.length);
    });
    </script>
@endpush
