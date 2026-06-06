/* -------------------------------------------------------
[ Custom settings ]

01. Preloader
02. ScrollIt
03. Navbar
04. Sections background image from data background
05. Animations
06. Slider & Slider-fade
07. About owlCarousel
08. Yachts 1 owlCarousel
09. Yachts 2 owlCarousel
10. Yachts 3 owlCarousel
11. Yacht Detail 3 owlCarousel
12. Yacht Detail 4 owlCarousel
13. Destinations owlCarousel
14. Watersports owlCarousel
15. Services 2 owlCarousel
16. Services 4 owlCarousel
17. Testimonials owlCarousel
18. Blog 1 owlCarousel
19. Blog 2 owlCarousel
20. Blog 3 owlCarousel
21. Team owlCarousel
22. Clients owlCarousel
23. Accordion Box (for Faqs)
24. Isotope Active Masonry Gallery
25. Gallery Image owlCarousel
26. MagnificPopup Gallery
27. Smooth Scrolling
28. Scroll back to top
29. Select2
30. Datepicker
31. YouTubePopUp
32. Contact Form
33. Mouse effect

------------------------------------------------------- */
$(function () {
    "use strict";
    
    /* ======= Preloader ======= */
    $("#preloader").fadeOut(700);
    $(".preloader-bg").delay(700).fadeOut(700);
    var wind = $(window);
    
    
    /* ======= ScrollIt ======= */
    $.scrollIt({
        upKey: 38, // key code to navigate to the next section
        downKey: 40, // key code to navigate to the previous section
        easing: 'swing', // the easing function for animation
        scrollTime: 600, // how long (in ms) the animation takes
        activeClass: 'active', // class given to the active nav element
        onPageChange: null, // function(pageIndex) that is called when page is changed
        topOffset: -70 // offste (in px) for fixed top navigation
    });
    
    
    /* ======= Navbar ======= */
    // navbar scrolling background
    wind.on("scroll", function () {
        var bodyScroll = wind.scrollTop(),
            navbar = $(".navbar"),
            logo = $(".navbar .logo> img");
        if (bodyScroll > 100) {
            navbar.addClass("nav-scroll");
            logo.attr('src', '/typo3conf/ext/glos/Resources/Public/Images/logo-light.png');
        } else {
            navbar.removeClass("nav-scroll");
            logo.attr('src', '/typo3conf/ext/glos/Resources/Public/Images/logo.png');
        }
    });
    // close navbar-collapse when a  clicked
    $(".navbar-nav .dropdown-item a").on('click', function () {
        $(".navbar-collapse").removeClass("show");
    });
    $(".navbar-nav .dropdown-item a").on('click', function () {
        $(".navbar-collapse").removeClass("show");
    });
    

    /* ======= Sections background image from data background ======= */
    var pageSection = $(".bg-img, section");
    pageSection.each(function (indx) {
        if ($(this).attr("data-background")) {
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });
    
    
    /* ======= Animations ======= */
    var contentWayPoint = function () {
        var i = 0;
        $('.animate-box').waypoint(function (direction) {
            if (direction === 'down' && !$(this.element).hasClass('animated')) {
                i++;
                $(this.element).addClass('item-animate');
                setTimeout(function () {
                    $('body .animate-box.item-animate').each(function (k) {
                        var el = $(this);
                        setTimeout(function () {
                            var effect = el.data('animate-effect');
                            if (effect === 'fadeIn') {
                                el.addClass('fadeIn animated');
                            } else if (effect === 'fadeInLeft') {
                                el.addClass('fadeInLeft animated');
                            } else if (effect === 'fadeInRight') {
                                el.addClass('fadeInRight animated');
                            } else {
                                el.addClass('fadeInUp animated');
                            }
                            el.removeClass('item-animate');
                        }, k * 200, 'easeInOutExpo');
                    });
                }, 100);
            }
        }, {
            offset: '85%'
        });
    };
    $(function () {
        contentWayPoint();
    });
    
    
    /* ======= Slider & Slider-fade ======= */
    $(document).ready(function () {
        var owl = $('.header .owl-carousel');
        // Slider owlCarousel - (Inner Page Slider)
        $('.slider .owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            dots: true,
            margin: 0,
            autoplay: false,
            autoplayTimeout: 5000,
            nav: false,
            navText: ['<i class="ti-angle-left" aria-hidden="true"></i>', '<i class="ti-angle-right" aria-hidden="true"></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    dots: true
                },
                600: {
                    dots: true
                },
                1000: {
                    dots: true
                }
            }
        });
        // Slider owlCarousel (Homepage Slider)
        $('.slider-fade .owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            dots: true,
            margin: 0,
            autoplay: false,
            autoplayTimeout: 5000,
            animateOut: 'fadeOut',
            nav: true,
            navText: ['<i class="ti-angle-left" aria-hidden="true"></i>', '<i class="ti-angle-right" aria-hidden="true"></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    dots: false
                },
                600: {
                    dots: false
                },
                1000: {
                    dots: true
                }
            }
        });
        owl.on('changed.owl.carousel', function (event) {
            var item = event.item.index - 2; // Position of the current item
            $('span').removeClass('animated fadeInUp');
            $('h4').removeClass('animated fadeInUp');
            $('h1').removeClass('animated fadeInUp');
            $('p').removeClass('animated fadeInUp');
            $('.button-3').removeClass('animated fadeInUp');
            $('.button-4').removeClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('span').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('h4').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('h1').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('p').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('.button-3').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('.button-4').addClass('animated fadeInUp');
        });
    });
    
    
    /* ======= About owlCarousel ======= */
    $('.about .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: true,
        autoplayTimeout: 5000,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        dots: false,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    
    
    /* ======= Yachts 1 owlCarousel ======= */
    if ($(".yachts1-carousel").length) {
        $(".yachts1-carousel").owlCarousel({
            loop: true,
            margin: 30,
            autoHeight: false,
            autoplayTimeout: 5000,
            dots: true,
            nav: true,
            navText: ['<i class="ti-angle-left" aria-hidden="true"></i>', '<i class="ti-angle-right" aria-hidden="true"></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    dots: false,
                    nav: false,
                    items: 1,
                },
                600: {
                    dots: false,
                    nav: false,
                    items: 1,
                },
                1000: {
                    dots: false,
                    items: 1,
                }
            }
        });
    }
    
    
    /* ======= Yachts 2 owlCarousel ======= */
    $('.yachts2 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        nav: true,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    
    
    /* ======= Yachts 3 owlCarousel ======= */
    $('.yachts3 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1
            },
            1000: {
                items: 2
            }
        }
    });
    
    
    /* ======= Yacht Detail 3 owlCarousel ======= */
    $('.yacht-detail3 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        nav: true,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    
    
    /* ======= Yacht Detail 4 owlCarousel ======= */
    $('.yachts4 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        autoplayHoverPause: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    
    /* ======= Destinations owlCarousel ======= */
    $('.destinations .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        autoplayHoverPause: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });
    
    
    /* ======= Watersports owlCarousel ======= */
    $('.watersports .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    
    /* ======= Services 1 owlCarousel ======= */
    $('.services1 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: true,
        dots: true,
        nav: true,
        navText: ['<i class="ti-angle-left" aria-hidden="true"></i>', '<i class="ti-angle-right" aria-hidden="true"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    /* ======= Services 2 owlCarousel ======= */
    $('.services2 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    /* ======= Services 3 owlCarousel ======= */
    $('.services3 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        autoplayHoverPause: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    /* ======= Services 4 owlCarousel ======= */
    $('.services4 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: false,
        autoplayHoverPause: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    
    /* ======= Testimonials owlCarousel ======= */
    $('.testimonials .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        autoplayTimeout: 5000,
        dots: false,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    
    
    /* ======= Blog 1 owlCarousel ======= */
    $('.blog1 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        autoplayHoverPause: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    
    /* ======= Blog 2 owlCarousel ======= */
    $('.blog2 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        autoplayHoverPause: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    
    /* ======= Blog 3 owlCarousel ======= */
    $('.blog3 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        autoplayHoverPause: true,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    
    /* ======= Team owlCarousel ======= */
    $('.team .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        dots: true,
        mouseDrag: true,
        autoplay: false,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots: true
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    
    
    /* ======= Clients owlCarousel ======= */
    $('.clients .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: true,
        dots: false,
        nav: false,
        navText: ["<span class='lnr ti-angle-left'></span>", "<span class='lnr ti-angle-right'></span>"],
        responsiveClass: true,
        responsive: {
            0: {
                margin: 10,
                items: 3
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    });
    
    
    /* ======= Accordion Box (for Faqs) ======= */
    if ($(".accordion-box").length) {
        $(".accordion-box").on("click", ".acc-btn", function () {
            var outerBox = $(this).parents(".accordion-box");
            var target = $(this).parents(".accordion");
            if ($(this).next(".acc-content").is(":visible")) {
                //return false;
                $(this).removeClass("active");
                $(this).next(".acc-content").slideUp(300);
                $(outerBox).children(".accordion").removeClass("active-block");
            } else {
                $(outerBox).find(".accordion .acc-btn").removeClass("active");
                $(this).addClass("active");
                $(outerBox).children(".accordion").removeClass("active-block");
                $(outerBox).find(".accordion").children(".acc-content").slideUp(300);
                target.addClass("active-block");
                $(this).next(".acc-content").slideDown(300);
            }
        });
    }
    
    /* ======= Isotope Active Masonry Gallery ======= */
    $('.gallery-items').imagesLoaded(function () {
        // Add isotope on click filter function
        $('.gallery-filter li').on('click', function () {
            $(".gallery-filter li").removeClass("active");
            $(this).addClass("active");
            var selector = $(this).attr('data-filter');
            $(".gallery-items").isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
            return false;
        });
        $(".gallery-items").isotope({
            itemSelector: '.single-item',
            layoutMode: 'masonry',
        });
    });
    
    
    /* ======= Gallery Image owlCarousel ======= */
    if ($(".gallery-image-carousel").length) {
        $(".gallery-image-carousel").owlCarousel({
            loop: true,
            margin: 30,
            autoHeight: false,
            autoplayTimeout: 5000,
            dots: false,
            nav: true,
            navText: ['<i class="ti-angle-left" aria-hidden="true"></i>', '<i class="ti-angle-right" aria-hidden="true"></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    dots: false,
                    items: 1,
                },
                600: {
                    dots: false,
                    items: 1,
                },
                1000: {
                    dots: true,
                    items: 1,
                }
            }
        });
    }
    
    
    /* ======= MagnificPopup Gallery ======= */
    $('.gallery').magnificPopup({
        delegate: '.popimg',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
    $(".img-zoom").magnificPopup({
        type: "image",
        closeOnContentClick: !0,
        mainClass: "mfp-fade",
        gallery: {
            enabled: !0,
            navigateByImgClick: !0,
            preload: [0, 1]
        }
    })
    $('.magnific-youtube, .magnific-vimeo, .magnific-custom').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 300,
        preloader: false,
        fixedContentPos: false
    });
    
    
    /* ======= Smooth Scrolling ======= */
    $('a[href*="#"]')
        // Remove links that don't actually link to anything
        .not('[href="#"]').not('[href="#0"]').click(function (event) {
            // On-page links
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                // Figure out element to scroll to
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                // Does a scroll target exist?
                if (target.length) {
                    // Only prevent default if animation is actually gonna happen
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000, function () {
                        // Callback after animation
                        // Must change focus!
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) { // Checking if the target was focused
                            return false;
                        } else {
                            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                            $target.focus(); // Set focus again
                        };
                    });
                }
            }
        });
    
    /* ======= Scroll back to top ======= */
    var progressPath = document.querySelector('.progress-wrap path');
    var pathLength = progressPath.getTotalLength();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
    progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
    var updateProgress = function () {
        var scroll = $(window).scrollTop();
        var height = $(document).height() - $(window).height();
        var progress = pathLength - (scroll * pathLength / height);
        progressPath.style.strokeDashoffset = progress;
    }
    updateProgress();
    $(window).scroll(updateProgress);
    var offset = 150;
    var duration = 550;
    jQuery(window).on('scroll', function () {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.progress-wrap').addClass('active-progress');
        } else {
            jQuery('.progress-wrap').removeClass('active-progress');
        }
    });
    jQuery('.progress-wrap').on('click', function (event) {
        event.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, duration);
        return false;
    })
    
    
    /* ======= Select2 ======= */
    $('.select2').select2({
        minimumResultsForSearch: Infinity,
    });
    
    
    /* ======= Datepicker ======= */
    $(".datepicker").datepicker({
        orientation: "top"
    });
    
    
    /* ======= YouTubePopUp ======= */
    $("a.vid").YouTubePopUp();
    
    
    /* ======= Contact Form ======= */
    var form = $('.contact__form'),
        message = $('.contact__msg'),
        form_data;
    // success function
    function done_func(response) {
        message.fadeIn().removeClass('alert-danger').addClass('alert-success');
        message.text(response);
        setTimeout(function () {
            message.fadeOut();
        }, 2000);
        form.find('input:not([type="submit"]), textarea').val('');
    }
    // fail function
    function fail_func(data) {
        message.fadeIn().removeClass('alert-success').addClass('alert-success');
        message.text(data.responseText);
        setTimeout(function () {
            message.fadeOut();
        }, 2000);
    }
    form.submit(function (e) {
        e.preventDefault();
        form_data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form_data
        }).done(done_func).fail(fail_func);
    });
    
});

// Function to toggle the dropdown visibility
function toggleDropdown() {
    const dropdownMenu = document.getElementById('dropdownMenu');
    const isVisible = dropdownMenu.style.display === 'block';

    // Toggle dropdown visibility
    dropdownMenu.style.display = isVisible ? 'none' : 'block';
    
    
}


// Function to set the active language in the dropdown
function setActiveLanguage(element, flag, lang) {
    const selectedLanguage = document.getElementById('selectedLanguage');
    const selectedFlag = document.getElementById('selectedFlag');
    
    // Set the active language as the button's text and set the flag image
    selectedLanguage.innerHTML = `<img src="/fileadmin/flags/${flag}.svg" alt="$(lang)" class="flag-icon">` + element.querySelector('span').innerText;
    
    // Optionally, add active class to the clicked item and remove it from others
    const allItems = document.querySelectorAll('.dropdown-item');
    allItems.forEach(item => item.classList.remove('language-active'));
    element.classList.add('language-active');
    
    // Close the dropdown menu after selection
    document.getElementById('dropdownMenu').style.display = 'none';
}

// Close dropdown if clicked outside
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.language-toggle');
    if (!dropdown.contains(event.target)) {
        document.getElementById('dropdownMenu').style.display = 'none';
    }
});

// Set the default language when the page loads
window.onload = function() {
    const defaultLanguage = document.querySelector('.dropdown-item.language-active');
    if (defaultLanguage) {
        const selectedLanguage = document.getElementById('selectedLanguage');
        const selectedFlag = document.getElementById('selectedFlag');
        selectedLanguage.innerHTML = `<img src="/fileadmin/flags/${defaultLanguage.getAttribute('hreflang')}.svg" alt="${defaultLanguage.getAttribute('alt')}" class="flag-icon">` ;
    }
};


document.addEventListener('DOMContentLoaded', function () {
  const langBtn = document.getElementById('langBtn');
  const langMenu = document.getElementById('langMenu');

  // 1. Find active language on load
  const activeLink = langMenu.querySelector('.language-active');
  if (activeLink) {
    const activeLi = activeLink.closest('li');
    const flag = activeLi.dataset.flag;
    const lang = activeLi.dataset.lang;

    // set button to active flag
    langBtn.innerHTML = '<img src="/fileadmin/flags/' + flag + '.svg" alt="' + lang + '" class="flag-icon">';
  }

  // 2. Toggle menu when button clicked
  langBtn.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    langMenu.classList.toggle('show');
  });

  // 3. Close menu when clicking outside
  document.addEventListener('click', function () {
    langMenu.classList.remove('show');
  });
});
