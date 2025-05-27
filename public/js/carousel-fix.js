/**
 * Script de carousel compatible avec Tailwind CSS
 * 
 * Cette implémentation utilise JavaScript vanilla pour créer un carousel 
 * sans dépendance à Bootstrap.
 */

class TailwindCarousel {
    constructor(element, options = {}) {
        this.carousel = element;
        if (!this.carousel) return;
        
        this.options = {
            interval: options.interval || 5000,
            wrap: options.wrap !== undefined ? options.wrap : true,
            keyboard: options.keyboard !== undefined ? options.keyboard : true,
            pause: options.pause || 'hover',
            autoplay: options.autoplay !== undefined ? options.autoplay : true
        };
        
        this.slides = Array.from(this.carousel.querySelectorAll('[data-carousel-item]'));
        if (!this.slides.length) {
            // Compatibilité avec l'ancienne structure
            this.slides = Array.from(this.carousel.querySelectorAll('.carousel-item'));
        }
        
        if (!this.slides.length) return;
        
        this.activeIndex = this.slides.findIndex(slide => 
            slide.classList.contains('active') || 
            !slide.hasAttribute('hidden')
        );
        
        if (this.activeIndex === -1) this.activeIndex = 0;
        
        // Configurer les contrôles
        this.prevButton = this.carousel.querySelector('[data-carousel-prev]') || 
                          this.carousel.querySelector('.carousel-control-prev');
        this.nextButton = this.carousel.querySelector('[data-carousel-next]') || 
                          this.carousel.querySelector('.carousel-control-next');
        
        this.indicators = Array.from(this.carousel.querySelectorAll('[data-carousel-indicator]') || 
                                     this.carousel.querySelectorAll('.carousel-indicators button'));
        
        this.init();
    }
    
    init() {
        console.log('Initialisation du carousel Tailwind...', this.slides.length, 'slides');
        
        // Définir le premier slide comme actif
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
    // Initialiser tous les carousels sur la page
    const carousels = document.querySelectorAll('[data-carousel]');
    
    if (carousels.length > 0) {
        carousels.forEach(carousel => {
            new TailwindCarousel(carousel, {
                interval: parseInt(carousel.dataset.interval || 5000),
                wrap: carousel.dataset.wrap !== 'false',
                keyboard: carousel.dataset.keyboard !== 'false',
                pause: carousel.dataset.pause || 'hover',
                autoplay: carousel.dataset.autoplay !== 'false'
            });
        });
    } else {
        // Support de l'ancien carousel
        const heroCarousel = document.getElementById('heroCarousel');
        if (heroCarousel) {
            new TailwindCarousel(heroCarousel);
        } else {
            console.warn('Aucun carousel trouvé sur la page');
        }
    }
});
