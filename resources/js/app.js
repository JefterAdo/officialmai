import "./bootstrap";
import "bootstrap";
import $ from 'jquery';
import 'owl.carousel';
import AOS from 'aos';
import '../css/app.css';

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

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Initialize Bootstrap dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl, {
            autoClose: true
        });
    });

    // Améliorer la gestion des sous-menus sur mobile
    if (window.innerWidth < 992) {
        // Sur mobile, on veut que le clic sur le dropdown-toggle ouvre le menu
        $('.dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).next('.dropdown-menu').toggleClass('show');
        });

        // Fermer les autres dropdowns lorsqu'un est ouvert
        $('.dropdown').on('show.bs.dropdown', function () {
            $('.dropdown-menu.show').not($(this).find('.dropdown-menu')).removeClass('show');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        if (window.innerWidth < 992) {
            var dropdowns = document.querySelectorAll('.dropdown-menu.show');
            var clickedOnDropdown = false;
            
            dropdowns.forEach(function (dropdown) {
                if (dropdown.contains(event.target) || dropdown.previousElementSibling === event.target) {
                    clickedOnDropdown = true;
                }
            });
            
            if (!clickedOnDropdown) {
                dropdowns.forEach(function(dropdown) {
                    dropdown.classList.remove('show');
                });
            }
        }
    });
});

// Add smooth scrolling to all links
$(document).ready(function(){
  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        window.location.hash = hash;
      });
    }
  });
});

// Add active class to current nav item and parent dropdown
$(document).ready(function(){
  var url = window.location.href;
  
  // Vérifier les liens de navigation
  $('.navbar-nav .nav-link').each(function() {
    if (this.href === url) {
      $(this).addClass('active');
      
      // Si c'est dans un dropdown, activer aussi le parent
      if ($(this).closest('.dropdown').length) {
        $(this).closest('.dropdown').find('.dropdown-toggle').addClass('active');
      }
    }
  });
  
  // Vérifier les liens dans les dropdowns
  $('.dropdown-item').each(function() {
    if (this.href === url) {
      $(this).addClass('active');
      // Activer le dropdown parent
      $(this).closest('.dropdown').find('.dropdown-toggle').addClass('active');
    }
  });
  
  // Vérifier si l'URL contient un segment qui correspond à un dropdown
  var segments = url.split('/');
  var lastSegment = segments[segments.length - 1];
  
  // Si on est sur une page de médiatheque
  if (url.includes('/mediatheque/')) {
    $('.dropdown-toggle#mediaDropdown').addClass('active');
  }
  
  // Si on est sur une page d'actualités
  if (url.includes('/actualites/')) {
    $('.dropdown-toggle#actualitesDropdown').addClass('active');
  }
});

// Add animation on scroll
$(window).scroll(function() {
  // Fade-in elements
  $('.fade-in').each(function() {
    var position = $(this).offset().top;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll + windowHeight > position) {
      $(this).addClass('visible');
    }
  });
  
  // Navbar scroll effect
  if ($(window).scrollTop() > 50) {
    $('.main-navbar').addClass('navbar-scrolled');
  } else {
    $('.main-navbar').removeClass('navbar-scrolled');
  }
});
