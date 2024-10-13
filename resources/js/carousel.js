$(() => {
    if ($('.owl-carousel').length === 0) return;
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive:{
            0: {items: 1},
            300: {items: 2},
            600: {items: 3},
            1000: {items: 5}
            }
    });
});
