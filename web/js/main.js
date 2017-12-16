// OWL CAROUSEL

$(document).ready(function() {
    $('.owl-carousel').owlCarousel({
        autoplay: true,
        autoPlaySpeed: 5000,
        autoPlayTimeout: 5000,
        autoplayHoverPause: true,
        loop: true,
        rewindNav: true,
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items:3,
                nav: false
            },
            1000: {
                items:4,
                nav: false,
                loop: false,
                margin:30,
                dots: true
            }
        }
    })
})