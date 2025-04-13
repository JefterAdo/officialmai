import "./bootstrap";
import "bootstrap";
import "owl.carousel";
import AOS from "aos";
import "../css/app.css";

// Initialize AOS
AOS.init({
    duration: 800,
    easing: "ease-in-out",
    once: true,
});

// Initialize Owl Carousel
$(document).ready(function () {
    $(".video-carousel").owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });
});
