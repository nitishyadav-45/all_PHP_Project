$(document).ready(function() {
    "use strict";

    // Preloader
    $(window).on('load', function() {
        $('#loader').fadeOut('slow');
    });

    // Navbar Scroll Effect
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
            $('.back-to-top').addClass('active');
        } else {
            $('.navbar').removeClass('scrolled');
            $('.back-to-top').removeClass('active');
        }
    });

    // Smooth Scrolling
    $('a.nav-link, a.btn').on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });

    // Progress Bar Animation on Scroll
    var skillSection = $('#skills');
    if (skillSection.length > 0) {
        $(window).scroll(function() {
            var hT = skillSection.offset().top,
                hH = skillSection.outerHeight(),
                wH = $(window).height(),
                wS = $(this).scrollTop();
            if (wS > (hT + hH - wH)) {
                $('.progress-bar').each(function() {
                    $(this).css("width", $(this).attr("data-width"));
                });
            }
        });
    }

    // Theme Toggle
    $('#theme-toggle').on('click', function() {
        var body = $('body');
        var icon = $(this).find('i');
        
        if (body.attr('data-theme') === 'dark') {
            body.removeAttr('data-theme');
            icon.removeClass('fa-sun').addClass('fa-moon');
            localStorage.setItem('theme', 'light');
        } else {
            body.attr('data-theme', 'dark');
            icon.removeClass('fa-moon').addClass('fa-sun');
            localStorage.setItem('theme', 'dark');
        }
    });

    // Load saved theme
    if (localStorage.getItem('theme') === 'dark') {
        $('body').attr('data-theme', 'dark');
        $('#theme-toggle i').removeClass('fa-moon').addClass('fa-sun');
    }
});
