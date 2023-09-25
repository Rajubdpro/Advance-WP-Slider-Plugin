(function ($) {
    'use strict';
    new WOW().init();
 

    //======================Start-hero-slider-js=======================//

    var $hero = $('.hero-full');
    if ($hero.length > 0) {
        $('.hero-full').owlCarousel({
            autoplay: true,
            loop: true,
            nav: true,
            autoplay: true,
            autoplayTimeout: 8000,
            smartSpeed: 800,
            dots: true,
            navText: ['<span class="hero-slider-nav"><i class="fas fa-chevron-left"></i></i></i></span>', '<span class="hero-slider-nav"><i class="fas fa-chevron-right"></i></span>'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
            }
        });
    }
    //======================End-hero-slider-js=======================//

})(jQuery);