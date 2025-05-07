(function ($) {
    "use strict";

    $(document).ready(function () {

        $(".homepage-slider").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            nav: true,
            dots: false,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive: {
                0: { items: 1, nav: false, loop: true },
                600: { items: 1, nav: true, loop: true },
                1000: { items: 1, nav: true, loop: true }
            }
        });


        // light box
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: { verticalFit: true }
        });

        // homepage slides animations
        $(".homepage-slider").on("translate.owl.carousel", function () {
            $(".hero-text-tablecell .subtitle").removeClass("animated fadeInUp").css({ 'opacity': '0' });
            $(".hero-text-tablecell h1").removeClass("animated fadeInUp").css({ 'opacity': '0', 'animation-delay': '0.3s' });
            $(".hero-btns").removeClass("animated fadeInUp").css({ 'opacity': '0', 'animation-delay': '0.5s' });
        });

        $(".homepage-slider").on("translated.owl.carousel", function () {
            $(".hero-text-tablecell .subtitle").addClass("animated fadeInUp").css({ 'opacity': '0' });
            $(".hero-text-tablecell h1").addClass("animated fadeInUp").css({ 'opacity': '0', 'animation-delay': '0.3s' });
            $(".hero-btns").addClass("animated fadeInUp").css({ 'opacity': '0', 'animation-delay': '0.5s' });
        });

        // stikcy js
        $("#sticker").sticky({ topSpacing: 0 });

        // mean menu
        $('.main-menu').meanmenu({
            meanMenuContainer: '.mobile-menu',
            meanScreenWidth: "992"
        });

    });

    // Loader fade out
    jQuery(window).on("load", function () {
        jQuery(".loader").fadeOut(1000);
    });

    window.setupShopInteractions = function () {
        // Isotope filtering
        $(".product-filters li").on('click', function () {
            $(".product-filters li").removeClass("active");
            $(this).addClass("active");
    
            var selector = $(this).attr('data-filter');
            $(".product-lists").isotope({ filter: selector });
        });
    
        // Isotope init
        $(".product-lists").isotope();
    
        // SPApp-compatible navigation to product detail
        $('.view-product-link').on('click', function (e) {
            e.preventDefault(); // prevent jumping
            var target = $(this).attr("href"); // like "#product1"
            window.location.hash = target; // this triggers SPApp to navigate
        });
    };
    

}(jQuery));
