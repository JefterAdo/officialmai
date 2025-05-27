@extends('layouts.app')

    @section('title', 'Adhérer au RHDP - Rejoignez le Rassemblement des Houphouëtistes')
    @section('meta_description', 'Découvrez comment devenir membre du RHDP et participez activement à la construction d\'une Côte d\'Ivoire unie et prospère. Suivez notre processus d\'adhésion simple.')

    @push('styles')
    <style>
        /* Hero Section */
        .adhesion-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/storage/slides/RHDP adhésion.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            border-radius: 0.5rem;
            margin-bottom: 3rem;
        }
        
        .adhesion-hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .adhesion-hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }
        
        /* Process Steps */
        .process-section {
            padding: 3rem 0;
        }
        
        .process-title {
            color: #FF6B00;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .process-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: #FF6B00;
        }
        
        .step-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 4rem;
        }
        
        .step-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            flex: 1;
            min-width: 300px;
            max-width: 350px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .step-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .step-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background-color: #FF6B00;
        }
        
        .step-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: #FF6B00;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            border-radius: 50%;
            margin-bottom: 1.5rem;
        }
        
        .step-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .step-description {
            color: #555;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        /* Documents Section */
        .documents-section {
            background-color: #f8f9fa;
            padding: 3rem 2rem;
            border-radius: 0.75rem;
            margin-bottom: 3rem;
        }
        
        .documents-title {
            color: #FF6B00;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .document-list {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .document-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
        }
        
        .document-icon {
            color: #FF6B00;
            font-size: 1.25rem;
            flex-shrink: 0;
            margin-top: 0.25rem;
        }
        
        /* Benefits Section */
        .benefits-section {
            padding: 3rem 0;
        }
        
        .benefits-title {
            color: #FF6B00;
            font-size: 1.75rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .benefits-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }
        
        .benefit-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
        }
        
        .benefit-icon {
            font-size: 2.5rem;
            color: #FF6B00;
            margin-bottom: 1.5rem;
        }
        
        .benefit-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .benefit-description {
            color: #555;
            line-height: 1.6;
        }
        
        /* CTA Section */
        .cta-section {
            text-align: center;
            padding: 3rem 0;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #FF6B00;
            color: white;
            font-weight: 700;
            padding: 1rem 2.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            border: 2px solid #FF6B00;
        }
        
        .cta-button:hover {
            background-color: white;
            color: #FF6B00;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 107, 0, 0.2);
        }
        
        .cta-note {
            margin-top: 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Contact Info */
        .contact-info {
            margin-top: 3rem;
            text-align: center;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 0.75rem;
        }
        
        .contact-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .contact-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-top: 1.5rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .contact-icon {
            color: #FF6B00;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .adhesion-hero {
                padding: 3rem 1rem;
            }
            
            .adhesion-hero h1 {
                font-size: 2rem;
            }
            
            .process-title, .benefits-title {
                font-size: 1.5rem;
            }
            
            .step-card, .benefit-card {
                min-width: 100%;
            }
            
            .contact-details {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
        }
    </style>
    @endpush

    @section('content')
    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="adhesion-hero">
            <h1>Rejoignez le RHDP</h1>
            <p>Devenez membre du Rassemblement des Houphouëtistes pour la Démocratie et la Paix et contribuez activement à la construction d'une Côte d'Ivoire unie, solidaire et prospère. Votre engagement est essentiel pour porter haut les valeurs de paix, de dialogue et de développement.</p>
        </div>
        
        <!-- Process Section -->
        <section class="process-section">
            <h2 class="process-title">Comment adhérer au RHDP ?</h2>
            <div class="step-container">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Inscription au Comité de Base</h3>
                    <p class="step-description">Veuillez vous inscrire au sein d'un comité de base dans votre Secrétariat Départemental.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Obtention du numéro E-Militant</h3>
                    <p class="step-description">Veuillez remplir les formulaires pour l'obtention d'un numéro E-Militant.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Participation aux activités</h3>
                    <p class="step-description">Une fois le numéro E-Militant obtenu, vous pouvez désormais participer aux activités du parti.</p>
                </div>
            </div>
        </section>
        
        <!-- Documents Section -->
        <section class="documents-section">
            <h2 class="documents-title">Documents nécessaires pour l'adhésion</h2>
            
            <div class="document-list">
                <div class="document-item">
                    <i class="fas fa-check-circle document-icon"></i>
                    <div>Une photocopie de votre pièce d'identité nationale ou passeport en cours de validité</div>
                </div>
                
                <div class="document-item">
                    <i class="fas fa-check-circle document-icon"></i>
                    <div>Deux photos d'identité récentes (format 35x45mm, fond blanc)</div>
                </div>
                

            </div>
        </section>
        
        <!-- Benefits Section -->
        <section class="benefits-section">
            <h2 class="benefits-title">Pourquoi rejoindre le RHDP ?</h2>
            
            <div class="benefits-container">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="benefit-title">Communauté engagée</h3>
                    <p class="benefit-description">Rejoignez une communauté de militants engagés pour le développement de la Côte d'Ivoire.</p>
                </div>
                

            </div>
            
            <div class="benefits-container mt-4">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="benefit-title">Formation politique</h3>
                    <p class="benefit-description">Accédez à des formations et des ressources pour développer vos compétences politiques.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="benefit-title">Contribuer aux idées</h3>
                    <p class="benefit-description">Apportez vos idées et solutions pour relever les défis auxquels notre pays fait face.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="benefit-title">Impact social</h3>
                    <p class="benefit-description">Participez à des actions sociales et communautaires pour améliorer la vie des Ivoiriens.</p>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="cta-section">
            <a href="#" class="cta-button" download>Télécharger le formulaire d'adhésion</a>
            <p class="cta-note">Le formulaire peut également être retiré dans toutes les sections locales du RHDP.</p>
            
            <div class="contact-info">
                <h3 class="contact-title">Pour plus d'informations</h3>
                <p>Si vous avez des questions concernant le processus d'adhésion, n'hésitez pas à nous contacter :</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-phone contact-icon"></i>
                        <span>+225 27 22 44 XX XX</span>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt contact-icon"></i>
                        <span>Siège du RHDP, Cocody, Abidjan</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection
