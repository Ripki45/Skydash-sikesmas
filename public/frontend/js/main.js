(function ($) {
    "use strict";

    //banner
    $(".banner-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        dots: true,
        loop: true,
        margin: 0,
        nav: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            0: {
                items: 1,
            },
            0: {
                items: 1,
            },
            0: {
                items: 1,
            },
        },
    });

    //layanan
    $(".layanan-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        loop: true,
        center: false,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
            },
            576: {
                items: 2,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            },
        },
    });

    //berita
    $(document).ready(function () {
        $(".berita-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 2000,
            margin: 26,
            loop: true,
            dots: false,
            responsive: {
                0: { items: 1 },
                768: { items: 1 },
                992: { items: 1 },
            },
        });
    });

    //sinergi
    $(document).ready(function () {
        // ... (script untuk banner, layanan, berita carousel yang sudah ada) ...

        // TAMBAHKAN INI: Inisialisasi Sinergi Program Carousel
        $(".sinergi-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            margin: 25,
            loop: true,
            center: false,
            dots: false,
            responsive: {
                0: { items: 2 },
                576: { items: 2 },
                768: { items: 3 },
                992: { items: 4 },
            },
        });
    });

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($("#spinner").length > 0) {
                $("#spinner").removeClass("show");
            }
        }, 1);
    };
    spinner(0);

    // Fixed Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".sticky-top").addClass("shadow-sm").css("top", "0px");
        } else {
            $(".sticky-top").removeClass("shadow-sm").css("top", "-200px");
        }
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".back-to-top").fadeIn("slow");
        } else {
            $(".back-to-top").fadeOut("slow");
        }
    });
    $(".back-to-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
        return false;
    });

    // Latest-news-carousel
    $(".latest-news-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>',
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            },
        },
    });

    // What's New carousel
    $(".whats-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>',
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 2,
            },
        },
    });

    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $(".btn-play").click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $("#videoModal").on("shown.bs.modal", function (e) {
            $("#video").attr(
                "src",
                $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0"
            );
        });

        $("#videoModal").on("hide.bs.modal", function (e) {
            $("#video").attr("src", $videoSrc);
        });
    });
})(jQuery);
