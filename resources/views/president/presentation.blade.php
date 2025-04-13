@extends('layouts.app')

@section('title', 'Le Président - RHDP')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Alassane Ouattara</h1>
                    <p class="lead mb-4">Un leader visionnaire, bâtisseur de la Côte d'Ivoire moderne</p>
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <div class="h2 fw-bold mb-0">12+</div>
                            <small>Années de leadership</small>
                        </div>
                        <div class="me-4">
                            <div class="h2 fw-bold mb-0">8%</div>
                            <small>Croissance moyenne</small>
                        </div>
                        <div>
                            <div class="h2 fw-bold mb-0">37%</div>
                            <small>Réduction pauvreté</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="{{ asset('images/president/president-portrait.jpg') }}" alt="Président Alassane Ouattara" class="img-fluid rounded-3 shadow-lg">
                        <div class="position-absolute bottom-0 end-0 bg-primary p-3 rounded-top-start">
                            <h6 class="text-white mb-0">Président de la République</h6>
                            <small class="text-white-50">Depuis 2011</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="content-text" data-aos="fade-up">
                        <p class="lead fw-bold text-primary">
                            Depuis son accession à la magistrature suprême en 2011, le Président Alassane Ouattara a insufflé 
                            une dynamique de transformation sans précédent en Côte d'Ivoire.
                        </p>
                        <p>
                            Son leadership exceptionnel, alliant vision stratégique et rigueur économique, a permis de consolider 
                            la paix, de relancer l'économie et de moderniser le pays, faisant de lui un bâtisseur infatigable 
                            et un digne héritier des idéaux de Félix Houphouët-Boigny.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Gallery Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="position-relative image-hover-effect">
                        <img src="{{ asset('images/president/president-ceremonie.jpg') }}" alt="Le Président" class="img-fluid rounded-3 shadow-sm">
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="position-relative image-hover-effect">
                        <img src="{{ asset('images/president/president-discours.jpg') }}" alt="Le Président" class="img-fluid rounded-3 shadow-sm">
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="position-relative image-hover-effect">
                        <img src="{{ asset('images/president/president-bureau.jpg') }}" alt="Le Président" class="img-fluid rounded-3 shadow-sm">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Parcours Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-6 fw-bold mb-4">Un parcours exemplaire au service de la nation</h2>
                    <div class="content-text">
                        <p>
                            Économiste de formation, Alassane Ouattara a forgé son expertise au sein d'institutions financières 
                            internationales prestigieuses telles que le Fonds monétaire international (FMI) et la Banque Centrale 
                            des États de l'Afrique de l'Ouest (BCEAO).
                        </p>
                        <p>
                            Son ascension fulgurante, de Directeur de la Recherche à Gouverneur de la BCEAO, témoigne de sa 
                            compétence et de sa vision. En 1990, le Président Félix Houphouët-Boigny, conscient de son talent, 
                            le nomme Premier Ministre, poste qu'il occupe jusqu'en 1993.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-badge bg-primary">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>1990-1993</h5>
                                <p>Premier Ministre de Côte d'Ivoire</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-badge bg-primary">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>1988-1990</h5>
                                <p>Gouverneur de la BCEAO</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-badge bg-primary">
                                <i class="fas fa-landmark"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>1984-1988</h5>
                                <p>Directeur Général Adjoint du FMI</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Réalisations Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="display-6 fw-bold text-center mb-5">Une vision transformatrice</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-balance-scale fa-2x"></i>
                            </div>
                            <h4 class="card-title h5">Paix et Stabilité</h4>
                            <p class="card-text">
                                Restauration de la paix et de la sécurité sur l'ensemble du territoire, politique de 
                                réconciliation nationale et rétablissement de la confiance.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <h4 class="card-title h5">Croissance Économique</h4>
                            <p class="card-text">
                                Taux de croissance annuel moyen du PIB de 8% (2012-2019), réduction significative du taux 
                                de pauvreté de 51% à 37%.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-city fa-2x"></i>
                            </div>
                            <h4 class="card-title h5">Infrastructures Modernes</h4>
                            <p class="card-text">
                                Réalisation de projets majeurs comme le Pont Alassane Ouattara, des barrages hydroélectriques 
                                et la modernisation des infrastructures.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0" data-aos="fade-left">
                    <h2 class="display-6 fw-bold mb-4">L'héritier fidèle de l'Houphouëtisme</h2>
                    <div class="content-text">
                        <p>
                            Alassane Ouattara incarne les valeurs cardinales de l'Houphouëtisme : la paix, le dialogue, 
                            l'unité nationale, le travail acharné et le développement économique au service de tous.
                        </p>
                        <p>
                            Son leadership est marqué par une vision à long terme, une rigueur exemplaire et une compétence 
                            économique saluée mondialement. En tant que Président du RHDP, il a su rassembler la grande famille 
                            politique houphouëtiste.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="achievement-card bg-white p-4 rounded-3 shadow-sm text-center">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-handshake fa-2x"></i>
                                </div>
                                <h5>Dialogue</h5>
                                <p class="small mb-0">Promotion de la paix et de l'unité nationale</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="achievement-card bg-white p-4 rounded-3 shadow-sm text-center">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <h5>Rassemblement</h5>
                                <p class="small mb-0">Unification de la famille houphouëtiste</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="achievement-card bg-white p-4 rounded-3 shadow-sm text-center">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-globe-africa fa-2x"></i>
                                </div>
                                <h5>Rayonnement</h5>
                                <p class="small mb-0">Leadership régional et international</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="achievement-card bg-white p-4 rounded-3 shadow-sm text-center">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-building fa-2x"></i>
                                </div>
                                <h5>Développement</h5>
                                <p class="small mb-0">Modernisation et croissance économique</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Citation Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center" data-aos="fade-up">
                    <i class="fas fa-quote-left fa-3x mb-3"></i>
                    <blockquote class="blockquote">
                        <p class="mb-4 h4">
                            "Le Président Alassane Ouattara se distingue comme un bâtisseur infatigable, un visionnaire 
                            dont les actions ont profondément transformé la Côte d'Ivoire."
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 50px;
        }
        .timeline-badge {
            position: absolute;
            left: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            text-align: center;
            line-height: 36px;
            color: white;
        }
        .timeline-content {
            background: white;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .achievement-card {
            height: 100%;
            transition: transform 0.3s ease;
        }
        .achievement-card:hover {
            transform: translateY(-5px);
        }
        .image-hover-effect {
            overflow: hidden;
            border-radius: 0.3rem;
        }
        .image-hover-effect img {
            transition: transform 0.5s ease;
        }
        .image-hover-effect:hover img {
            transform: scale(1.05);
        }
        .image-overlay {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0.3rem;
            text-align: center;
            transition: opacity 0.3s ease;
        }
        .image-hover-effect:hover .image-overlay {
            opacity: 1;
        }
    </style>
@endsection 