

window.initMap = function(){
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 46.5233071, lng: 6.6294318},
        zoom: 13
    });

    var idInput = $("input[data-formengine-input-name$='[tx_wngcvcinews_address]']").attr("id");
    var input = /** @type {!HTMLInputElement} */(document.getElementById(idInput));

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        marker.setDraggable(true);

        $("input[data-formengine-input-name$='[tx_wngcvcinews_latitude]']").val(place.geometry.location.lat().toFixed(7));
        $("input[data-formengine-input-name$='[tx_wngcvcinews_longitude]']").val(place.geometry.location.lng().toFixed(7));
        $("input[data-formengine-input-name$='[tx_wngcvcinews_latitude]']").change();
        $("input[data-formengine-input-name$='[tx_wngcvcinews_longitude]']").change();
        $("input[data-formengine-input-name$='[tx_wngcvcinews_address]']").change();

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
    });


    google.maps.event.addListener(marker, 'dragend', function (evt) {
        //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        console.log(evt.latLng.lat());
        console.log(evt.latLng.lng());
        $("input[data-formengine-input-name$='[tx_wngcvcinews_latitude]']").val(evt.latLng.lat().toFixed(7));
        $("input[data-formengine-input-name$='[tx_wngcvcinews_longitude]']").val(evt.latLng.lng().toFixed(7));
        $("input[data-formengine-input-name$='[tx_wngcvcinews_latitude]']").change();
        $("input[data-formengine-input-name$='[tx_wngcvcinews_longitude]']").change();
    });

    var geocoder = new google.maps.Geocoder();
    geocodeAddress(geocoder, map);
}

function geocodeAddress(geocoder, resultsMap) {
    var address = "CVCI, Avenue d&#039;Ouchy 47, 1006 Lausanne";
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location
            });
        } else {
            //alert('Geocode was not successful for the following reason: ' + status);
            jQuery('#event-google-map').after(
                jQuery('<div></div>')
                    .attr('class', 'gm-error-box')
                    .html('No address found')
            );
        }
    });
}

