// Custom JavaScript will go here

document.addEventListener("DOMContentLoaded", function () {
    // Example: Initialize Bootstrap tooltips if used
    // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //   return new bootstrap.Tooltip(tooltipTriggerEl)
    // })

    // Initialize Video Carousel
    $(".video-carousel").owlCarousel({
        loop: false, // Set to true if you want infinite loop
        margin: 30, // Space between items
        nav: true, // Show navigation arrows
        dots: true, // Show dots navigation
        responsive: {
            0: {
                items: 1, // Items on mobile
            },
            600: {
                items: 2, // Items on tablet
            },
            1000: {
                items: 3, // Items on desktop
            },
        },
    });

    // Initialize Animate On Scroll (AOS)
    AOS.init({
        duration: 800, // Animation duration
        once: true, // Only animate once
    });
});
