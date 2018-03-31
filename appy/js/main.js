/*jslint browser: true*/
/*global $, jQuery ,AOS*/


(function (jQuery) {

    "use strict";

    var $window = jQuery(window),
        $body = jQuery('body'),
        $appyMenu = jQuery('.appy-menu'),
        $testiSlider = jQuery('.testimonial-slider'),
        $screenShotsSlider = jQuery('.screenshots-slider'),
        $countUp = jQuery('.count-num span'),
        $teamSlider = jQuery('.team-slider'),
        $blogSlider = jQuery('.recent-blog-slider');


    /*START PRELOADER JS & REFRESH AOS*/
    $window.on('load', function () {
        jQuery('.preloader').delay(350).fadeOut('slow');
        AOS.refresh();
    });
    if(jQuery(window).width()>767)
    {
        jQuery('a.dropdown-toggle').removeAttr('data-toggle');
    }
     
    jQuery(window).resize(function() {
            if(jQuery(window).width()>767)
             {
               
                jQuery('a.dropdown-toggle').removeAttr('data-toggle');
             }
             else{
               
                jQuery('a.dropdown-toggle').attr("data-toggle", "dropdown");
             }
    });
    /*END PRELOADER JS & REFRESH AOS*/

        /*START AOS JS*/
        AOS.init({
            disable: 'mobile',
            once: true,
            duration: 600
        });
        /*END AOS JS*/

        /*START SCROLL SPY JS*/
        $body.scrollspy({
            target: '#main_menu'
        });
        /*END SCROLL SPY JS*/

        /*START MENU JS*/
        jQuery('.scroll-section a').on('click', function (e) {
            e.preventDefault();
            var anchor = jQuery(this);
            var ancAtt = jQuery(anchor.attr('href'));
            jQuery('html, body').stop().animate({
                scrollTop: ancAtt.offset().top
            }, 1000);
            
        });

        $window.scroll(function () {
            var currentLink = jQuery(this);
            if (jQuery(currentLink).scrollTop() > 0) {
                $appyMenu.addClass("sticky");
            } else {
                $appyMenu.removeClass("sticky");
            }
        });
        /*END MENU JS*/

        /*START TESTIMONIAL SLIDER JS*/
        if ($testiSlider.length > 0) {
            $testiSlider.owlCarousel({
                loop: true,
                margin: 10,
                items: 1,
                responsiveClass: true
            });
        }
        /*END TESTIMONIAL SLIDER JS*/

        /*START SCREENSHOTS SLIDER JS*/
        if ($screenShotsSlider.length > 0) {
            $screenShotsSlider.owlCarousel({
                loop: true,
                responsiveClass: true,
                nav: true,
                animateOut: 'slideOutLeft',
                animateIn: 'zoomIn',
                dots: false,
                autoplay: true,
                autoplayTimeout: 400000,
                smartSpeed: 500,
                navSpeed: 200,
                center: true,
                items: 1
            });
        }
        /*END SCREENSHOTS SLIDER JS*/

        /*START COUNTUP JS*/
        $countUp.counterUp({
            delay: 10,
            time: 1500
        });
        /*END COUNTUP JS*/

        /*START TEAM SLIDER JS*/
        if ($teamSlider.length > 0) {
            $teamSlider.owlCarousel({
                loop: false,
                margin: 30,
                dots: true,
                nav: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    1200: {
                        items: 4
                    }
                }
            });
        }
        /*END TEAM SLIDER JS*/

        /*RECENT BLOG SLIDER JS*/
        if ($blogSlider.length > 0) {
            $blogSlider.owlCarousel({
                loop: false,
                margin: 30,
                dots: true,
                nav: false,
                slideBy: 1,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    }
                }
            });
        }
        /*END RECENT BLOG SLIDER JS*/


    }(jQuery));


