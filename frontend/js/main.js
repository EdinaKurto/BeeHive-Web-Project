(function ($) {
    "use strict";

    $(document).ready(function () {

        // light box
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: { verticalFit: true }
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
            var target = $(this).attr("href"); 
            window.location.hash = target; // this triggers SPApp to navigate
        });
    };

}(jQuery));