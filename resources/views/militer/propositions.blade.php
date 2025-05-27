@extends('layouts.app')

@section('title', 'Faites vos Propositions - RHDP')

@section('content')
<div class="page-banner" style="background-image: url('{{ asset('storage/images/militants.jpg') }}');">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white">Vos Idées Comptent</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="#">Militer</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Faites vos Propositions</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-5">
                    <h2>Partagez Vos Propositions</h2>
                    <p>Le RHDP est à l'écoute de ses militants et sympathisants. Vos idées sont essentielles pour construire ensemble l'avenir de la Côte d'Ivoire. Utilisez ce formulaire pour nous faire part de vos propositions, suggestions ou préoccupations.</p>
                </div>

                {{-- Placeholder for success/error messages --}}
                {{-- @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                {{-- In a real application, this form would submit to a controller --}}
                <div class="form-wrapper p-4 p-md-5 shadow-sm rounded bg-white">
                    <form action="#" method="POST">
                        @csrf {{-- Important for security --}}

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="nom" name="nom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Adresse Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Numéro de Téléphone</label>
                            <input type="tel" class="form-control form-control-lg" id="telephone" name="telephone">
                        </div>

                        <div class="mb-3">
                            <label for="sujet" class="form-label">Sujet de la Proposition <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="sujet" name="sujet" required>
                        </div>

                        <div class="mb-4">
                            <label for="proposition" class="form-label">Votre Proposition <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-lg" id="proposition" name="proposition" rows="6" required></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Soumettre ma Proposition</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Add specific styles for this page if needed */
    .page-banner {
        padding: 80px 0;
        background-color: #f8f9fa; /* Fallback color */
        background-size: cover;
        background-position: center;
        text-align: center;
        position: relative;
    }
    .page-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
    }
    .page-banner .container {
        position: relative;
        z-index: 1;
    }
    .page-banner h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    .breadcrumb-item a {
        color: #adb5bd;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #ffffff;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: #adb5bd;
    }
    .section-padding {
        padding: 80px 0;
    }
    .section-title h2 {
        color: #FF6B00; /* RHDP Orange */
        font-weight: 700;
        margin-bottom: 15px;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-wrapper {
        /* Styles applied via Bootstrap classes: p-4 p-md-5 shadow-sm rounded bg-white */
        /* Add any additional custom styles here if needed */
    }
    .form-control {
        border-color: #ced4da;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        padding: 0.75rem 1rem; /* Slightly larger padding */
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #FF6B00; /* RHDP Orange on focus */
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25); /* RHDP Orange shadow on focus */
    }
     .btn-primary {
          background-color: #FF6B00; /* RHDP Orange */
          border-color: #FF6B00; /* RHDP Orange */
          color: white;
          padding: 0.75rem 1.5rem;
          font-size: 1.1rem;
          font-weight: 600;
     }
      .btn-primary:hover {
          background-color: #e65c00; /* Darker Orange for hover */
          border-color: #cc5200; /* Darker Orange for hover */
          color: white;
      }
</style>
@endpush
