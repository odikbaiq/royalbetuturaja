(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Initiate the wowjs
    new WOW().init();


    // Fixed Navbar
    $(window).scroll(function () {
        if ($(window).width() < 992) {
            if ($(this).scrollTop() > 45) {
                $('.fixed-top').addClass('bg-white shadow');
            } else {
                $('.fixed-top').removeClass('bg-white shadow');
            }
        } else {
            if ($(this).scrollTop() > 45) {
                $('.fixed-top').addClass('bg-white shadow').css('top', -45);
            } else {
                $('.fixed-top').removeClass('bg-white shadow').css('top', 0);
            }
        }
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        loop: true,
        center: true,
        dots: true,
        nav: true,
        navText : [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });

    //galeri
        $(document).ready(function() {
        // Hilangkan paksa preloader jika masih ada setelah 1 detik
        setTimeout(function() {
            $('#spinner').removeClass('show');
        }, 1000);

        // Fungsi Filter
        $('.filter-btn').click(function() {
            const value = $(this).attr('data-filter');

            // Toggle Class Active Tombol
            $('.filter-btn').removeClass('active btn-dark text-white').addClass('btn-outline-dark');
            $(this).addClass('active btn-dark text-white').removeClass('btn-outline-dark');

            if (value == 'all') {
                $('.gallery-item').show(400);
            } else {
                $('.gallery-item').not('.' + value).hide(400);
                $('.gallery-item').filter('.' + value).show(400);
            }
        });
    });

    function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    const icon = el.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        input.type = "password";
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
}

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
})(jQuery);

