/**
 * Script de carousel optimisé pour RHDP
 * 
 * Cette implémentation utilise JavaScript vanilla pour créer un carousel robuste
 * qui fonctionne sans dépendance à Bootstrap tout en étant compatible avec sa structure.
 * Optimisé pour éviter les problèmes de rendu et de transition.
 */

class EnhancedCarousel {
    constructor(element, options = {}) {
        // Élément principal du carousel
        this.carousel = typeof element === 'string' ? document.querySelector(element) : element;
        if (!this.carousel) {
            console.error('Carousel element not found');
            return;
        }
        
        // Options avec valeurs par défaut
        this.options = {
            interval: options.interval || 5000,
            wrap: options.wrap !== undefined ? options.wrap : true,
            keyboard: options.keyboard !== undefined ? options.keyboard : true,
            pause: options.pause || 'hover',
            autoplay: options.autoplay !== undefined ? options.autoplay : true,
            transitionDuration: options.transitionDuration || 800
        };
        
        // Éléments du carousel
        this.slides = Array.from(this.carousel.querySelectorAll('[data-carousel-item]'));
        if (!this.slides.length) {
            // Compatibilité avec l'ancienne structure Bootstrap
            this.slides = Array.from(this.carousel.querySelectorAll('.carousel-item'));
        }
        
        if (!this.slides.length) {
            console.error('No slides found in carousel');
            return;
        }
        
        // Déterminer l'index actif
        this.activeIndex = this.slides.findIndex(slide => slide.classList.contains('active'));
        if (this.activeIndex === -1) this.activeIndex = 0;
        
        // Contrôles du carousel
        this.prevButton = this.carousel.querySelector('[data-carousel-prev]') || 
                          this.carousel.querySelector('.carousel-control-prev');
        this.nextButton = this.carousel.querySelector('[data-carousel-next]') || 
                          this.carousel.querySelector('.carousel-control-next');
        
        this.indicators = Array.from(this.carousel.querySelectorAll('[data-carousel-indicator]') || 
                                     this.carousel.querySelectorAll('.carousel-indicators button'));
        
        // Variables d'état
        this.isSliding = false;
        this.interval = null;
        this.touchStartX = 0;
        this.touchEndX = 0;
        
        this.init();
    }
    
    init() {
        console.log('Initialisation du carousel amélioré...', this.slides.length, 'slides');
        
        // Activer le premier slide et l'indicateur correspondant
        this.showSlide(this.activeIndex);
        
        // Configurer les contrôles
        if (this.prevButton) {
            this.prevButton.addEventListener('click', () => this.prev());
        }
        
        if (this.nextButton) {
            this.nextButton.addEventListener('click', () => this.next());
        }
        
        // Configurer les indicateurs
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => this.goTo(index));
        });
        
        // Configurer le clavier
        if (this.options.keyboard) {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') this.prev();
                if (e.key === 'ArrowRight') this.next();
            });
        }
        
        // Démarrer le défilement automatique
        if (this.options.autoplay) {
            this.cycle();
            
            if (this.options.pause === 'hover') {
                this.carousel.addEventListener('mouseenter', () => this.pause());
                this.carousel.addEventListener('mouseleave', () => this.cycle());
            }
        }
        
        console.log('Carousel Tailwind initialisé avec succès!');
    }
    
    showSlide(index) {
        // Gérer le débordement
        if (index < 0) {
            index = this.options.wrap ? this.slides.length - 1 : 0;
        } else if (index >= this.slides.length) {
            index = this.options.wrap ? 0 : this.slides.length - 1;
        }
        
        // Éviter de réafficher le même slide
        if (index === this.activeIndex) return;
        
        // Préparer le nouveau slide avant de masquer l'ancien
        // pour éviter les flashs blancs
        this.slides[index].style.opacity = '0';
        this.slides[index].removeAttribute('hidden');
        
        // Forcer un reflow pour que la transition s'applique correctement
        void this.slides[index].offsetHeight;
        
        // Appliquer la transition sur le nouveau slide
        this.slides[index].style.opacity = '1';
        this.slides[index].classList.add('active');
        
        // Mettre à jour les indicateurs
        if (this.indicators[index]) {
            this.indicators[index].setAttribute('aria-current', 'true');
            this.indicators[index].classList.add('active');
        }
        
        // Masquer l'ancien slide seulement après un délai
        const previousIndex = this.activeIndex;
        if (previousIndex !== null && previousIndex !== index) {
            setTimeout(() => {
                this.slides[previousIndex].classList.remove('active');
                this.slides[previousIndex].setAttribute('hidden', '');
                if (this.indicators[previousIndex]) {
                    this.indicators[previousIndex].setAttribute('aria-current', 'false');
                    this.indicators[previousIndex].classList.remove('active');
                }
            }, 600); // Légèrement plus long que la transition CSS
        }
        
        this.activeIndex = index;
    }
    
    next() {
        this.showSlide(this.activeIndex + 1);
    }
    
    prev() {
        this.showSlide(this.activeIndex - 1);
    }
    
    goTo(index) {
        this.showSlide(index);
    }
    
    cycle() {
        this.pause();
        this.interval = setInterval(() => this.next(), this.options.interval);
    }
    
    pause() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Détection et initialisation de tous les carousels
    const carousels = document.querySelectorAll('[data-carousel]');
    
    if (carousels.length > 0) {
        carousels.forEach(carousel => {
            new EnhancedCarousel(carousel, {
                interval: parseInt(carousel.dataset.interval || 5000),
                wrap: carousel.dataset.wrap !== 'false',
                keyboard: carousel.dataset.keyboard !== 'false',
                pause: carousel.dataset.pause || 'hover',
                autoplay: carousel.dataset.autoplay !== 'false',
                transitionDuration: parseInt(carousel.dataset.transitionDuration || 800)
            });
        });
        console.log(`${carousels.length} carousel(s) initialisé(s) avec succès`);
    } else {
        // Support de l'ancien carousel (par ID)
        const heroCarousel = document.getElementById('heroCarousel');
        if (heroCarousel) {
            new EnhancedCarousel(heroCarousel);
            console.log('Carousel héro initialisé avec succès');
        } else {
            console.warn('Aucun carousel détecté sur la page');
        }
    }

    // Vérifier si les images sont préchargées pour éviter les flashs blancs
    const preloadSliderImages = () => {
        const slides = document.querySelectorAll('.carousel-item-bg');
        slides.forEach(slide => {
            const bgUrl = slide.style.backgroundImage.replace(/url\(['"]+(.+)['"]\)/gi, '$1');
            if (bgUrl && bgUrl !== 'none') {
                const img = new Image();
                img.src = bgUrl;
            }
        });
    };
    preloadSliderImages();
});
