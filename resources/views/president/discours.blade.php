@extends('layouts.app')

@section('title', 'Discours du Président - RHDP')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Discours, Citations et Messages</h1>
                    <p class="lead">Les mots et la vision du Président Alassane Ouattara</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtres Section -->
    <section class="py-4 bg-light border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <form class="d-flex">
                        <input type="search" class="form-control me-2" placeholder="Rechercher un discours...">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end mt-3 mt-md-0">
                        <select class="form-select me-2" style="max-width: 200px;">
                            <option value="">Toutes les années</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select>
                        <select class="form-select" style="max-width: 200px;">
                            <option value="">Tous les types</option>
                            <option value="discours">Discours</option>
                            <option value="messages">Messages</option>
                            <option value="citations">Citations</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Liste des Discours -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Discours Item -->
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary">Discours</span>
                                <small class="text-muted">6 janvier 2024</small>
                            </div>
                            <h3 class="card-title h5">Message à la Nation - Nouvel An 2024</h3>
                            <p class="card-text">
                                Discours du Nouvel An du Président Alassane Ouattara présentant sa vision et les perspectives pour l'année 2024.
                            </p>
                            <a href="#" class="btn btn-outline-primary">Lire le discours</a>
                        </div>
                    </div>
                </div>

                <!-- Citation Item -->
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary">Citation</span>
                                <small class="text-muted">Décembre 2023</small>
                            </div>
                            <h3 class="card-title h5">Sur l'Unité Nationale</h3>
                            <p class="card-text">
                                "L'unité nationale n'est pas une option, c'est notre force et notre avenir. 
                                Ensemble, nous bâtissons une Côte d'Ivoire plus forte et plus prospère."
                            </p>
                            <div class="text-end">
                                <small class="text-muted">- Congrès du RHDP, 2023</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Item -->
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary">Message</span>
                                <small class="text-muted">15 novembre 2023</small>
                            </div>
                            <h3 class="card-title h5">Message à la Jeunesse</h3>
                            <p class="card-text">
                                Message spécial du Président aux jeunes de Côte d'Ivoire sur l'importance de l'éducation 
                                et de la formation professionnelle.
                            </p>
                            <a href="#" class="btn btn-outline-primary">Lire le message</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
@endsection 