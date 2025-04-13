@extends('layouts.app')

@section('title', 'Accueil - RHDP')

@section('content')
    <!-- Modern Hero Slider Section -->
    <section id="modernHeroSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" style="margin-bottom: -5px;">
        @php
            $slides = App\Models\Slide::where('is_active', true)->orderBy('order')->get();
        @endphp
        
        <div class="carousel-indicators">
            @foreach($slides as $index => $slide)
                <button type="button" data-bs-target="#modernHeroSlider" data-bs-slide-to="{{ $index }}" 
                    class="{{ $index === 0 ? 'active' : '' }}" 
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                    aria-label="Slide {{ $index + 1 }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }} slider-item" 
                    style="background-image: url('{{ asset($slide->image_path) }}');">
                    <div class="slider-overlay"></div>
                    <div class="container slider-content-container">
                        <div class="row justify-content-center text-center">
                            <div class="col-lg-9 slider-content" data-aos="fade-up">
                                <h2 class="slider-title">{{ $slide->title }}</h2>
                                <p class="slider-description">{{ $slide->description }}</p>
                                @if($slide->button_text)
                                    <div class="slider-cta-container mt-4">
                                        <a href="{{ $slide->button_link }}" class="btn btn-primary btn-lg slider-cta">
                                            {{ $slide->button_text }}
                                            @if(str_contains($slide->button_text, "J'adhère"))
                                                <i class="fas fa-user-plus ms-2"></i>
                                            @else
                                                <i class="fas fa-info-circle ms-2"></i>
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#modernHeroSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#modernHeroSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <!-- Flash Info Section -->
    @php
        $activeFlashInfos = App\Models\FlashInfo::where('is_active', true)->orderBy('display_order')->get();
        $displayMode = $activeFlashInfos->first()?->display_mode ?? 'static';
    @endphp
    
    @if($activeFlashInfos->isNotEmpty())
        <section class="bg-orange" style="margin-top: -5px;">
            <div class="container">
                <div class="flash-info-slider flash-info-{{ $displayMode }}">
                    <div class="flash-messages">
                        @foreach($activeFlashInfos as $index => $flashInfo)
                            <div class="flash-message-item @if($displayMode === 'fade' && $index === 0) active @endif">
                                <div class="d-flex align-items-center justify-content-start">
                                    <span class="flash-info-label me-4 text-white">
                                        <i class="fas fa-bullhorn"></i>
                                        <strong>Flash Info</strong>
                                    </span>
                                    <span class="flash-info-text text-white">{{ $flashInfo->message }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        @if($displayMode === 'fade')
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const messages = document.querySelectorAll('.flash-message-item');
                    let currentIndex = 0;

                    function showNextMessage() {
                        messages.forEach(msg => msg.classList.remove('active'));
                        messages[currentIndex].classList.add('active');
                        currentIndex = (currentIndex + 1) % messages.length;
                    }

                    setInterval(showNextMessage, 5000);
                });
            </script>
            @endpush
        @endif
    @endif

    <!-- Nos Valeurs Section -->
    <section class="bg-secondary py-5" data-aos="fade-up">
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

    <!-- Actualités Section -->
    <section class="content-inner-1 py-5" data-aos="fade-up">
        <div class="container">
            <div class="section-head text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <h5 class="sub-title text-primary">ACTUALITÉS</h5>
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
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 news-card">
                        <div class="card-img-top-wrapper">
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}">
                            @else
                                <img src="{{ asset('images/le_RHDP_Côte_d_Ivoire.png') }}" class="card-img-top" alt="Image par défaut">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text text-muted small">{{ $article->published_at->locale('fr')->isoFormat('LL') }}</p>
                            <p class="card-text flex-grow-1">{{ $article->excerpt ?: Str::limit(strip_tags($article->content), 150) }}</p>
                            <a href="{{ route('actualites.show', $article->slug) }}" class="btn btn-outline-primary mt-auto align-self-start">Lire la suite</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p>Aucune actualité n'est disponible pour le moment.</p>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('actualites.index') }}" class="btn btn-primary">Voir toutes les actualités</a>
            </div>
        </div>
    </section>

    <!-- Le Parti Section -->
    <section class="party-structure-section py-5" data-aos="fade-up">
        <div class="container">
            <div class="section-head text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <h5 class="sub-title text-primary">LE PARTI</h5>
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
                                <p class="president-title text-primary">Président du RHDP</p>
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
                        <p class="team-member-title text-primary">Vice-Président</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/kandia-camara.jpg') }}" class="img-fluid rounded-circle" alt="Vice-Présidente">
                        </div>
                        <h5 class="team-member-name">Mme Kandia Camara</h5>
                        <p class="team-member-title text-primary">Vice-Présidente</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                     <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/M. ABDALLAH TOIKEUSSE MABRI.jpg') }}" class="img-fluid rounded-circle" alt="Vice-Président">
                        </div>
                        <h5 class="team-member-name">M. Abdallah Toikeusse Mabri</h5>
                        <p class="team-member-title text-primary">Vice-Président</p>
                    </div>
                </div>
                <!-- Trésorier Général -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/Tene-Brahima-Ouattara.jpeg') }}" class="img-fluid rounded-circle" alt="Trésorier Général">
            </div>
                        <h5 class="team-member-name">M. Tene Birahima Ouattara</h5>
                        <p class="team-member-title text-primary">Trésorier Général</p>
                </div>
                </div>
                <!-- Porte-Paroles -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/Kobenan_Kouassi_Adjoumani.jpg') }}" class="img-fluid rounded-circle" alt="Porte-Parole Principal">
                        </div>
                        <h5 class="team-member-name">M. Kouassi Kobenan Adjoumani</h5>
                        <p class="team-member-title text-primary">Porte-Parole Principal</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/mamadou-toure.jpg') }}" class="img-fluid rounded-circle" alt="Porte-Parole Adjoint">
                        </div>
                        <h5 class="team-member-name">M. Mamadou Touré</h5>
                        <p class="team-member-title text-primary">Porte-Parole Adjoint</p>
                    </div>
                </div>
                <!-- Secrétaire Exécutif -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/cisse-bacongo.webp') }}" class="img-fluid rounded-circle" alt="Secrétaire Exécutif">
                        </div>
                        <h5 class="team-member-name">M. Bacongo Ibrahima Cisse</h5>
                        <p class="team-member-title text-primary">Secrétaire Exécutif</p>
                    </div>
                </div>
                <!-- Chargés de Mission -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team-member text-center">
                        <div class="team-member-img mb-3">
                            <img src="{{ asset('images/membres/directoire/felix-anoble.jpg') }}" class="img-fluid rounded-circle" alt="Chargé de Mission">
                        </div>
                        <h5 class="team-member-name">M. Félix Anoblé</h5>
                        <p class="team-member-title text-primary">Chargé de la Stratégie Électorale</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('parti.organisation') }}" class="btn btn-primary">Voir l'organigramme complet</a>
            </div>
        </div>
    </section>

    <!-- RHDP en Action Section -->
    <section class="content-inner bg-light py-5" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center" data-aos="fade-up" data-aos-delay="100">
                <!-- Left Column: Text and Achievement Cards -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-head mb-4">
                        <h5 class="sub-title text-primary">LE RHDP EN ACTION</h5>
                        <h2>Nos Réalisations</h2>
                    </div>
                    <p class="mb-4">Découvrez les actions concrètes menées par le RHDP pour le développement de la Côte d'Ivoire et le bien-être de ses citoyens.</p>
                    <a href="#" class="btn btn-primary mb-5">Voir le Bilan Détaillé</a>

                    <!-- Achievement Cards Grid -->
                    <div class="row g-3">
                        @php
                            $achievements = App\Models\Achievement::where('is_active', true)
                                ->orderBy('order')
                                ->get();
                        @endphp

                        @foreach($achievements as $achievement)
                            <div class="col-sm-6">
                                <div class="achievement-card">
                                    <div class="achievement-icon"><i class="{{ $achievement->icon }}"></i></div>
                                    <h5 class="achievement-title">{{ $achievement->title }}</h5>
                                    <p class="achievement-description">{{ $achievement->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Column: Illustration Image -->
                <div class="col-lg-6 d-none d-lg-flex align-items-stretch">
                    <div class="achievement-card achievement-image-container p-0">
                        @if($achievements->first() && $achievements->first()->image)
                            <img src="{{ asset('storage/' . $achievements->first()->image) }}" alt="Réalisation RHDP" class="achievement-image">
                        @else
                            <img src="{{ asset('images/Réalisations/484934009_1195425848609790_7082283896171234641_n.jpg') }}" alt="Réalisation RHDP" class="achievement-image">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rassemblement TV Section -->
    <section class="content-inner py-5" data-aos="fade-up">
        <div class="container">
             <div class="section-head text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <h5 class="sub-title text-primary">RASSEMBLEMENT TV</h5>
                <h2>Vidéos Récentes</h2>
            </div>
            <!-- Video Carousel -->
            <div class="owl-carousel owl-theme video-carousel">
                @forelse($latestVideos as $video)
                 <div class="item video-carousel-item">
                    <div class="card">
                            <a href="{{ route('mediatheque.videos.show', $video) }}" class="card-img-top-wrapper">
                                <img src="{{ $video->thumbnail }}" class="img-fluid" alt="{{ $video->title }}">
                             <span class="video-play-button"><i class="fas fa-play-circle"></i></span>
                                @if($video->duration)
                                    <span class="video-duration">{{ $video->duration }}</span>
                                @endif
                        </a>
                        <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($video->title, 80) }}</h6>
                                <small class="text-muted">{{ $video->published_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                </div>
                @empty
                 <div class="item video-carousel-item">
                     <div class="card">
                            <div class="card-body text-center">
                                <p>Aucune vidéo disponible pour le moment.</p>
                        </div>
                    </div>
                </div>
                @endforelse
                        </div>
            <div class="text-center mt-5">
                <a href="{{ route('mediatheque.videos') }}" class="btn btn-primary">Voir la médiathèque</a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-primary form-wrapper1 py-5" data-aos="fade-up">
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
                    <form class="dzForm">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <input name="dzEmail" required="required" type="email" class="form-control form-control-lg" placeholder="Entrez votre adresse mail">
                            </div>
                            <div class="col-md-4">
                                <button name="submit" value="Submit" type="submit" class="btn btn-dark btn-lg w-100">S'inscrire</button>
                            </div>
                        </div>
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
        background-color: #fd7e14;
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

    .slider-cta-container {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .slider-cta {
        padding: 1rem 2.5rem;
        font-size: 1.2rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .slider-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .slider-item {
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
        color: #FF8C00 !important; /* Orange color, !important to override potential conflicts */
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
        background-color: #FF8C00; /* Orange */
        color: #FFFFFF;
        border: none;
    }

    .hero-btn-primary:hover,
    .hero-btn-primary:focus {
        background-color: #E67E00; /* Darker orange */
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
    .flash-info-text {
        font-weight: 500;
        margin-left: 1rem; /* Space between label and text */
        /* Add animation here for marquee if needed */
        /* animation: marquee 20s linear infinite; */
    }

    /* Optional Marquee Animation */
    /* @keyframes marquee {
        0%   { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    } */
    /* Ensure container allows overflow for marquee */
    /* .flash-info-bar .container { overflow: hidden; } */
    /* .flash-info-text { display: inline-block; padding-left: 100%; } */


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
        color: #0d6efd; /* Bootstrap primary */
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
        border: 2px solid #FF8C00;
    }
    .president-image-wrapper {
        width: 200px;
        height: 200px;
        margin: 0 auto;
        border: 3px solid #FF8C00;
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
        color: #FF8C00;
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
        border: 2px solid #FF8C00;
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
        background-color: #FF8C00 !important;
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
</style>
@endpush

@push('scripts')
    <!-- Add custom scripts here if needed -->
@endpush

