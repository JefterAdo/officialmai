@extends('layouts.app')

    @section('title', 'Adhérer au RHDP - Rejoignez le Rassemblement des Houphouëtistes')
    {{-- @section('meta_description', 'Devenez membre du RHDP et participez activement à la construction d\'une Côte d\'Ivoire unie et prospère. Remplissez le formulaire d\'adhésion.') --}}

    @push('styles')
    <style>
        #adhesion-form .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        #adhesion-form .form-control,
        #adhesion-form .form-select {
            margin-bottom: 1rem; /* Space below each field */
        }
        #adhesion-form .form-check-label {
            font-size: 0.9rem;
        }
        #adhesion-form .required-field label::after {
            content: " *";
            color: red;
        }
        .captcha-placeholder {
            background-color: #e9ecef;
            border: 1px dashed #ced4da;
            padding: 2rem;
            text-align: center;
            color: #6c757d;
            margin-bottom: 1.5rem;
            border-radius: 0.25rem;
        }
        .privacy-notice {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 1.5rem;
        }
    </style>
    @endpush

    @section('content')
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto"> {{-- Center content --}}
            <h1 class="text-3xl font-bold text-primary mb-4 text-center">Devenez Membre du RHDP</h1>

            <p class="text-gray-700 mb-6 text-center">
                Rejoignez le Rassemblement des Houphouëtistes pour la Démocratie et la Paix et contribuez activement à la construction d'une Côte d'Ivoire unie, solidaire et prospère. Votre engagement est essentiel pour porter haut les valeurs de paix, de dialogue et de développement héritées du Président Félix Houphouët-Boigny.
            </p>

            <form id="adhesion-form" action="#" method="POST" class="bg-white p-6 rounded shadow-md border border-gray-200">
                {{-- CSRF Token Placeholder - Important for Laravel forms --}}
                {{-- @csrf --}}
                <p class="text-danger text-sm mb-4">Les champs marqués d'un * sont obligatoires.</p>

                <div class="row">
                    <div class="col-md-4 mb-3 required-field">
                        <label for="civilite" class="form-label">Civilité</label>
                        <select class="form-select" id="civilite" name="civilite" required>
                            <option selected disabled value="">Choisir...</option>
                            <option value="M.">M.</option>
                            <option value="Mme">Mme</option>
                            <option value="Mlle">Mlle</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3 required-field">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                </div>

                <div class="mb-3 required-field">
                    <label for="prenoms" class="form-label">Prénom(s)</label>
                    <input type="text" class="form-control" id="prenoms" name="prenoms" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                        <input type="text" class="form-control" id="lieu_naissance" name="lieu_naissance">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse complète</label>
                    <textarea class="form-control" id="adresse" name="adresse" rows="3"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3 required-field">
                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    <div class="col-md-6 mb-3 required-field">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="profession" class="form-label">Profession</label>
                    <input type="text" class="form-control" id="profession" name="profession">
                </div>

                <div class="mb-4 required-field">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="engagementCheck" name="engagement" required>
                        <label class="form-check-label" for="engagementCheck">
                            Je déclare avoir pris connaissance des <a href="{{ route('parti.organisation') }}#textes" target="_blank" class="text-primary">statuts et du règlement intérieur</a> du RHDP et j'adhère à ses valeurs.*
                        </label>
                    </div>
                </div>

                {{-- CAPTCHA Placeholder --}}
                <div class="captcha-placeholder mb-4">
                    <p>Espace réservé pour le CAPTCHA (ex: Google reCAPTCHA)</p>
                    <small>Ceci est nécessaire pour prévenir les soumissions automatisées.</small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5">Envoyer ma demande d'adhésion</button>
                </div>

            </form>

            <p class="privacy-notice text-center mt-4">
                Vos informations personnelles seront traitées avec la plus grande confidentialité, conformément à notre politique de protection des données. Après soumission, votre demande sera examinée par les instances compétentes du parti. Vous serez contacté(e) prochainement.
            </p>
        </div>
    </main>
    @endsection
