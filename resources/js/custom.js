// Custom JavaScript for RHDP Website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdowns on hover
    const dropdowns = document.querySelectorAll('.dropdown-hover');
    
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function() {
            const dropdownMenu = this.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                const dropdownInstance = new bootstrap.Dropdown(this);
                dropdownInstance.show();
            }
        });
        
        dropdown.addEventListener('mouseleave', function() {
            const dropdownMenu = this.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                const dropdownInstance = bootstrap.Dropdown.getInstance(this);
                if (dropdownInstance) {
                    dropdownInstance.hide();
                }
            }
        });
    });
    
    // Add active class to current nav item
    const currentLocation = window.location.href;
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    navLinks.forEach(link => {
        if (link.href === currentLocation) {
            link.classList.add('active');
        }
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Add animation on scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.animate-on-scroll');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 100) {
                element.classList.add('animated');
            }
        });
    };
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on page load
});
