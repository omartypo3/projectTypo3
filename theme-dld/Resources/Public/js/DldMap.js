function initMap() {
    var mapElem = $('#dld-map');
    var lat = mapElem.attr('lat');
    var long = mapElem.attr('long');
    var markerImg = mapElem.attr('marker-image');
    var zoom = parseInt(mapElem.attr('zoom'));
    var mapProp = {
        center: new google.maps.LatLng(lat, long),
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true
    };

    var styles = [{
        "featureType": "water",
        "elementType": "geometry.fill",
        "stylers": [{"color": "#d3d3d3"}]
    }, {
        "featureType": "transit",
        "stylers": [{"color": "#808080"}, {"visibility": "off"}]
    }, {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [{"visibility": "on"}, {"color": "#b3b3b3"}]
    }, {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [{"color": "#ffffff"}]
    }, {
        "featureType": "road.local",
        "elementType": "geometry.fill",
        "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"weight": 1.8}]
    }, {
        "featureType": "road.local",
        "elementType": "geometry.stroke",
        "stylers": [{"color": "#d7d7d7"}]
    }, {
        "featureType": "poi",
        "elementType": "geometry.fill",
        "stylers": [{"visibility": "on"}, {"color": "#ebebeb"}]
    }, {
        "featureType": "administrative",
        "elementType": "geometry",
        "stylers": [{"color": "#a7a7a7"}]
    }, {
        "featureType": "road.arterial",
        "elementType": "geometry.fill",
        "stylers": [{"color": "#ffffff"}]
    }, {
        "featureType": "road.arterial",
        "elementType": "geometry.fill",
        "stylers": [{"color": "#ffffff"}]
    }, {
        "featureType": "landscape",
        "elementType": "geometry.fill",
        "stylers": [{"visibility": "on"}, {"color": "#dadada"}]
    }, {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [{"color": "#696969"}]
    }, {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [{"visibility": "on"}, {"color": "#737373"}]
    }, {
        "featureType": "poi",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "poi",
        "elementType": "labels",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "road.arterial",
        "elementType": "geometry.stroke",
        "stylers": [{"color": "#d6d6d6"}]
    }, {
        "featureType": "road",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "poi",
        "elementType": "geometry.fill",
        "stylers": [{"color": "#dadada"}]
    }];

    var map = new google.maps.Map(document.getElementById('dld-map'), mapProp);
    map.panBy(0, 80);
    map.setOptions({styles: styles});

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, long),
        map: map,
        icon: markerImg,
        zIndex: google.maps.Marker.MAX_ZINDEX + 1
    });




    map.addListener('dragstart', function () {
        $('.location-details').hide();
        $('#center-map').show();
    });

    $('#center-map').click(function () {
        //recenter map
        map.setCenter(new google.maps.LatLng(lat, long));
        map.setZoom(zoom);
        map.panBy(0, 80);

        $(this).hide();
        $('.location-details').show();
    });
}

google.maps.event.addDomListener(window, 'load', initMap);
