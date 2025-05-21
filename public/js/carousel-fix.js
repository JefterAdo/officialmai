/**
 * Script de correction pour le carousel Bootstrap
 * 
 * Ce script initialise explicitement le carousel Bootstrap sur la page d'accueil
 * pour résoudre le problème d'affichage des slides.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser le carousel avec des options explicites
    const heroCarousel = document.getElementById('heroCarousel');
    
    if (heroCarousel) {
        console.log('Initialisation du carousel...');
        
        // Créer une instance de carousel avec des options explicites
        const carousel = new bootstrap.Carousel(heroCarousel, {
            interval: 5000,      // Temps entre les slides en millisecondes
            wrap: true,          // Boucler après le dernier slide
            keyboard: true,      // Permettre la navigation avec le clavier
            pause: 'hover',      // Mettre en pause au survol
            ride: 'carousel'     // Démarrer automatiquement
        });
        
        console.log('Carousel initialisé avec succès!');
        
        // Forcer le démarrage du carousel
        carousel.cycle();
        
        // Vérifier que tous les slides sont correctement configurés
        const slides = heroCarousel.querySelectorAll('.carousel-item');
        console.log(`Nombre de slides trouvés: ${slides.length}`);
        
        // Ajouter des gestionnaires d'événements pour les boutons de navigation
        const prevButton = heroCarousel.querySelector('.carousel-control-prev');
        const nextButton = heroCarousel.querySelector('.carousel-control-next');
        
        if (prevButton) {
            prevButton.addEventListener('click', function() {
                console.log('Bouton précédent cliqué');
                carousel.prev();
            });
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', function() {
                console.log('Bouton suivant cliqué');
                carousel.next();
            });
        }
    } else {
        console.warn('Carousel #heroCarousel non trouvé dans le DOM');
    }
});
