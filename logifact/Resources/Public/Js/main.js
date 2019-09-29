var item_width3 = 215;
$(window).load(function () {
    $('.flexslider').flexslider(
        {
            animation: "fade",
            slideDirection: "horizontal",
            slideshow: true,
            slideshowSpeed: 7000,
            animationDuration: 600,
            controlNav: false,
            directionNav: true,
            keyboardNav: true,
            mousewheel: false,
            prevText: "Zurück",
            nextText: "Weiter",
            pausePlay: false,
            pauseText: "Pause",
            playText: "Abspielen",
            randomize: false,
            animationLoop: true,
            pauseOnHover: true

        });


    var sliders = $(document).find('.camaliga_start');
    if (sliders) {
        $.each(sliders, function (key, value) {

            $('#' + value.id).camaliga({
                auto_slide: 0,	// auto slide?
                hover_pause: 0,	// pause on hover?
                auto_slide_seconds: 5000, // auto slide in milliseconds
                infinite: 1,	// infinite carousel? Then you need at least n+2 elements!
                item_width: item_width3,	// item width of the li-element. Only needed if li has a padding>0 or margin>0
                li_name: 'li.carousel_li',	// only needed, if you use ul,li in the element itself
                left_scroll: '.camaliga_left_scroll',	// only needed, if you want to change the arrow at the first element when infinite=0 (class camaliga_first will be added)
                right_scroll: '.camaliga_right_scroll'	// only needed, if you want to change the arrow at the last element when infinite=0 (class camaliga_last will be added)
            });
        });
    }

});
// width of an item with width, padding and margin left + right
$(document).ready(function () {
    $('.camaliga_left_scroll a').on('click', function (e) {
        e.preventDefault();
        var slider = $(e.target).closest('.tx-camaliga').find('.camaliga_start');

        slider.data('camaliga').slideTo('left');
    });
    $('.camaliga_right_scroll a').on('click', function (e) {
        e.preventDefault();
        var slider = $(e.target).closest('.tx-camaliga').find('.camaliga_start');
        slider.data('camaliga').slideTo('right');
    });

    $(".jfmulticontent_c156").anythingSlider({
        buildNavigation: false,
        buildStartStop: false,
        pauseOnHover: true,
        allowRapidChange: true,
        autoPlay: true,
        delay: 5000
    });
    $(".tx-jfmulticontent-tabs").tabs(
        {
            active: 0,
            heightStyle: 'auto',
            hide: {effect: 'fadeOut'},
            show: {effect: 'fadeIn', easing: 'swing'}
        }
    );

    /*var map = L.map('mapid', {
        center: [latitude, longitude],
        zoom: 15
    });*/

  /*  L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([latitude, longitude]).addTo(map);
    if (window.location.pathname == '/') {
        $("nav a:first-child").addClass("hauptnavi_aktuell");
    }*/

    initMap();
   

});


function initMap() {
    var latitude = parseFloat($("#mapid").data("latitude"));
    var longitude = parseFloat($("#mapid").data("longitude"));
    var map;
    map = new google.maps.Map(document.getElementById('mapid'), {
        center: {lat:latitude, lng: longitude},
        zoom: 16
    });
    var beachMarker = new google.maps.Marker({
        position: {lat: latitude, lng: longitude},
        map: map
    });
}