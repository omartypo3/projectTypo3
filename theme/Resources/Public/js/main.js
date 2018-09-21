jQuery(document).ready( function($){

    /**
     * Show/Hide Language menu
     */
    jQuery('.language-select').hoverIntent({
        over: function () {
            jQuery('.language-menu').addClass('show', 500)
        },
        out: function () {
            jQuery('.language-menu').removeClass('show', 500)
        }
    });
    jQuery('.language-select .language-selector').click(function(event) {
        event.preventDefault();
    });

    $('#google-map1').gMap({

        address: 'Melbourne, Australia',
        maptype: 'ROADMAP',
        zoom: 14,
        markers: [
            {
                address: "Melbourne, Australia"
            }
        ],
        doubleclickzoom: false,
        controls: {
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false
        }
    });
    
});