(function($) {

        if ($('#gmap-element').length) {
            map = new GMaps({
                div: '#gmap-element',
                lat: 34.373752,
                lng: 9.172483,
                zoom: 6,
                scrollwheel: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false
            });

        }

})(jQuery);
