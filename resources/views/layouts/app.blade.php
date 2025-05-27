<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'RHDP')</title>

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome (CDN for icons, similar to template's las/flaticon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS (We will create this later) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Owl Carousel 2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Animate On Scroll (AOS) CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Header Styling */
        .main-navbar {
            position: sticky; /* Prioritized sticky positioning */
            top: 0;
            left: 0; /* Added for completeness with sticky, though width 100% usually covers */
            width: 100%;
            z-index: 1030; /* Ensure it's above most content, standard for navbars */
            transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            /* Initial transparent state */
            background-color: rgba(255, 255, 255, 0.8); /* White with 80% opacity */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px); /* Safari support */
            box-shadow: none; /* No shadow initially */
        }

        .main-navbar.navbar-scrolled {
            /* State when scrolled */
            background-color: #ffffff; /* Solid white */
            backdrop-filter: none; /* Remove blur */
            -webkit-backdrop-filter: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        /* Navigation Links Styling */
        .main-navbar .navbar-nav .nav-link {
            font-weight: 500;
            color: #FF6B00;
            position: relative;
            padding-bottom: 0.3rem;
            transition: color 0.2s ease;
        }

        .main-navbar .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: #FF6B00; /* Official orange underline */
            transition: width 0.3s ease-in-out;
        }

        .main-navbar .navbar-nav .nav-link:hover,
        .main-navbar .navbar-nav .nav-link:focus,
        .main-navbar .navbar-nav .nav-link.active {
            color: #FF6B00;
        }

        .main-navbar .navbar-nav .nav-link:hover::after,
        .main-navbar .navbar-nav .nav-link:focus::after,
        .main-navbar .navbar-nav .nav-link.active::after {
            width: 60%; /* Underline appears */
        }
         /* Ensure dropdown toggles also get hover effect */
        .main-navbar .navbar-nav .nav-item.dropdown:hover > .nav-link {
             color: #FF6B00;
        }
         .main-navbar .navbar-nav .nav-item.dropdown:hover > .nav-link::after {
             width: 60%;
         }


        /* J'adhère Button Styling */
        .btn-nav-adhere {
            background-color: #FF8C00; /* Orange */
            color: #FFFFFF !important; /* Ensure white text */
            border: none;
            padding: 0.6em 1.5em; /* Slightly smaller padding than hero */
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem; /* Slightly smaller font size */
            transition: all 0.2s ease-in-out;
            text-decoration: none; /* Remove underline if it's an <a> tag */
            display: inline-flex;
            align-items: center;
        }

        .btn-nav-adhere:hover,
        .btn-nav-adhere:focus {
            background-color: #E67E00; /* Darker orange */
            color: #FFFFFF !important;
            transform: scale(1.03);
            filter: brightness(110%);
            outline: 2px solid #FFDA63; /* Focus indicator */
            outline-offset: 2px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional subtle shadow on hover */
        }

        /* Adjust dropdown menu appearance if needed */
        .main-navbar .dropdown-menu {
            border-radius: 6px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .main-navbar .dropdown-item {
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
        .main-navbar .dropdown-item:hover,
        .main-navbar .dropdown-item:focus {
            background-color: #f8f9fa;
            color: #FF6B00;
        }

        .hover-orange:hover {
            color: var(--bs-primary) !important;
            transition: color 0.3s ease;
        }
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .social-icons a:hover {
            background-color: var(--bs-primary);
            transform: translateY(-2px);
        }

    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <!-- Added class 'main-navbar' and removed default Bootstrap bg/shadow classes -->
        <nav class="navbar navbar-expand-lg main-navbar">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <!-- RHDP Logo -->
                    <img src="{{ asset('images/rhdp_logo.png') }}" alt="RHDP Logo" style="height: 40px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    {{-- Removed ms-auto to potentially allow button separation --}}
                    <ul class="navbar-nav align-items-center w-100">
                        <!-- Navigation items based on RHDP content -->
                        <li class="nav-item">
                            {{-- Added active class handling (assuming '/' is home) --}}
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="/">Accueil</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="houphouetDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Houphouët
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="houphouetDropdown">
                                <li><a class="dropdown-item" href="{{ route('houphouet.biographie') }}">Biographie</a></li>
                                <li><a class="dropdown-item" href="{{ route('houphouet.chronologie') }}">Chronologie</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="presidentDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Le Président
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="presidentDropdown">
                                <li><a class="dropdown-item" href="{{ route('president.presentation') }}">Présentation</a></li>
                            </ul>
                        </li>
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="partiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Le Parti
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="partiDropdown">
                                <li><a class="dropdown-item" href="{{ route('parti.decouvrir') }}">Découvrir le RHDP</a></li>
                                <li><a class="dropdown-item" href="{{ route('parti.vision') }}">Notre Vision</a></li>
                                <li><a class="dropdown-item" href="{{ route('parti.organisation') }}">Organisation</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('actualites.*') ? 'active' : '' }}" href="#" id="actualitesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actualités
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="actualitesDropdown">
                                <li><a class="dropdown-item" href="{{ route('actualites.index') }}">Articles</a></li>
                                <li><a class="dropdown-item" href="{{ route('communiques.index') }}">Communiqués</a></li>
                            </ul>
                        </li>
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="militerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Militer
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="militerDropdown">
                                <li><a class="dropdown-item" href="{{ route('militer.adhesion') }}">J'adhère</a></li>
                                <li><a class="dropdown-item" href="{{ route('militer.propositions') }}">Je fais des propositions</a></li>
                            </ul>
                        </li>
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="mediaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Médiathèque
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="mediaDropdown">
                                <li><a class="dropdown-item" href="{{ route('communiques.index') }}">Communiqués</a></li>
                                <li><a class="dropdown-item" href="{{ route('mediatheque.textes') }}">Textes Officiels</a></li>
                                <li><a class="dropdown-item" href="{{ route('mediatheque.photos') }}">Photos</a></li>
                                <li><a class="dropdown-item" href="{{ route('mediatheque.videos') }}">Vidéos</a></li>
                                <li><a class="dropdown-item" href="{{ route('mediatheque.discours') }}">Discours</a></li>
                                <li><a class="dropdown-item" href="{{ route('mediatheque.audio') }}">Audio</a></li>
                            </ul>
                        </li>
                        {{-- Moved button to the end using ms-auto on the li --}}
                        <li class="nav-item ms-auto">
                             {{-- Added btn-nav-adhere class and removed default btn classes --}}
                             <a class="btn btn-nav-adhere" href="{{ route('militer.adhesion') }}">J'adhère</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="page-content bg-white flex-grow-1" style="min-height: calc(100vh - 120px); padding-top: 80px;">
        @yield('content')
    </main>

    <footer class="footer py-5 mt-auto" style="background-color: #000000; color: white; position:relative; bottom:0; width:100%; z-index:100;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary-600 mb-3">A PROPOS DE NOUS</h5>
                    <p class="mb-0">Le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP), uni pour le développement et la stabilité de la Côte d'Ivoire.</p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary-600 mb-3">MILITER</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ route('militer.adhesion') }}" class="text-white text-decoration-none hover-orange">J'adhère</a></li>
                        <li class="mb-2"><a href="{{ route('militer.propositions') }}" class="text-white text-decoration-none hover-orange">Je fais des propositions</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary-600 mb-3">NOUS CONTACTER</h5>
                    <p class="mb-3"><i class="fas fa-envelope me-2"></i>contact@rhdpofficiel.ci</p>
                    <h5 class="text-primary-600 mb-3">NOUS SUIVRE</h5>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/rhdpciv" class="text-white me-3 hover-orange"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="https://x.com/RhdpO" class="text-white me-3 hover-orange"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="https://www.tiktok.com/@rhdp_officiel" class="text-white me-3 hover-orange"><i class="fab fa-brands fa-tiktok fa-lg"></i></a>
                        <a href="https://www.youtube.com/@rassemblementwebtv5828" class="text-white hover-orange"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-4">
            
            <div class="text-center">
                <div class="mb-3">
                    <a href="{{ route('terms') }}" class="text-white text-decoration-none me-4 hover-orange">Conditions générales</a>
                    <a href="{{ route('privacy') }}" class="text-white text-decoration-none hover-orange">Politique de confidentialité</a>
                </div>
                <p class="text-gray-400 mb-0">  RHDP - Tous droits réservés</p>
            </div>
        </div>
    </footer>

    <!-- jQuery (Required for Owl Carousel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Owl Carousel 2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Animate On Scroll (AOS) JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        // Navbar scroll effect
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('.main-navbar');
            if (navbar) {
                const scrollThreshold = 50; // Pixels to scroll before changing navbar style

                const handleScroll = () => {
                    if (window.scrollY > scrollThreshold) {
                        navbar.classList.add('navbar-scrolled');
                    } else {
                        navbar.classList.remove('navbar-scrolled');
                    }
                };

                window.addEventListener('scroll', handleScroll);
                // Initial check in case the page loads already scrolled
                handleScroll();
            }

            // Initialize AOS
            AOS.init({
                duration: 800, // Animation duration
                once: true // Whether animation should happen only once - while scrolling down
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
