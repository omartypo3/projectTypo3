function initMap() {

    markers = [];
    var uluru = {lat: 45.55, lng: 11.45};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        center: uluru
    });
    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;
    var input = document.getElementById('street');
    var autocomplete = new google.maps.places.Autocomplete(input);
    var lat = document.getElementById('latitude').value;
    var lon = document.getElementById('longitude').value;

    if(lat !='' && lon !='' )
    {
        map.setCenter(new google.maps.LatLng(lat,lon));
        var defaultpos = new google.maps.LatLng(lat,lon);
        var marker = new google.maps.Marker({
            position: defaultpos,
            map: map
        });
        markers.push(marker);

    }
    autocomplete.bindTo('bounds', map);
    autocomplete.setTypes(['address']);
    document.getElementById('street').addEventListener('focus', function () {
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {

                window.alert("No details available for input: '" + place.name + "'");
                return;
            }


            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            var marker = new google.maps.Marker({
                map: map
            });
            infowindow.setContent(place.formatted_address);
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);


            infowindow.open(map, marker);
            $("#streetnumber").val('');
            $("#street").val('');
            $("#city").val('');
            $("#country").val('');
            $("#zip").val('');
            var city = '';
            $.each(place.address_components, function (key, value) {

                if (TYPO3.jQuery.inArray("street_number", value.types) > -1) {
                    $("#streetnumber").val(value.long_name);
                }


                if (TYPO3.jQuery.inArray("route", value.types) > -1) {
                    if (value.long_name != "Unnamed Road") {
                        $("#street").val(value.long_name);
                    }
                }
                if (TYPO3.jQuery.inArray("locality", value.types) > -1) {
                    $("#city").val(value.long_name);
                    city = value.long_name;
                }

                if (TYPO3.jQuery.inArray("administrative_area_level_1", value.types) > -1 && city == "") {
                    $("#city").val(value.long_name);
                }



                if (TYPO3.jQuery.inArray("country", value.types) > -1) {
                    $("#country").val(value.long_name);
                }

                if (TYPO3.jQuery.inArray("postal_code", value.types) > -1) {
                    $("#zip").val(value.long_name);
                }


            });
            $("#latitude").val(marker.getPosition().lat());
            $("#longitude").val(marker.getPosition().lng());
            markers.push(marker);
        });
    });

    document.getElementById('city').addEventListener('blur', function () {
        if ($('#city').val() != '') {
            var zoom = 11;
            var inputid = 'city';
            geocodeAddress(geocoder, map, inputid, zoom);
        }
    });
    document.getElementById('country').addEventListener('blur', function () {
        if ($('#country').val() != '') {
            var inputid = 'country';
            geocodeAddress(geocoder, map, inputid, 4);
        }
    });

    google.maps.event.addListener(map, 'click', function (event) {
        setMapOnAll(null);
        var latlng = event.latLng
        geocoder.geocode({'location': latlng}, function (results, status) {
            if (status === 'OK') {

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                infowindow.setContent(results[0].formatted_address);
                markers.push(marker);
                infowindow.open(map, marker);
                $("#streetnumber").val('');
                $("#street").val('');
                $("#city").val('');
                $("#country").val('');
                $("#zip").val('');
                var city = '';
                $.each(results[0].address_components, function (key, value) {

                    if (TYPO3.jQuery.inArray("street_number", value.types) > -1) {
                        $("#streetnumber").val(value.long_name);
                    }

                    if (TYPO3.jQuery.inArray("route", value.types) > -1) {
                        if (value.long_name != "Unnamed Road") {
                            $("#street").val(value.long_name);
                        }
                    }

                    if (TYPO3.jQuery.inArray("locality", value.types) > -1) {
                        $("#city").val(value.long_name);
                        city = value.long_name;
                    }

                    if (TYPO3.jQuery.inArray("administrative_area_level_1", value.types) > -1 && city == "") {
                        $("#city").val(value.long_name);
                    }

                    if (TYPO3.jQuery.inArray("country", value.types) > -1) {
                        $("#country").val(value.long_name);
                    }

                    if (TYPO3.jQuery.inArray("postal_code", value.types) > -1) {
                        $("#zip").val(value.long_name);
                    }


                });
                $("#latitude").val(marker.getPosition().lat());
                $("#longitude").val(marker.getPosition().lng());

            } else {
                // window.alert('Geocoder failed due to: ' + status);
            }
        });
    });
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function geocodeAddress(geocoder, resultsMap, inputid, zoom) {
    var address = document.getElementById(inputid).value;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            resultsMap.setZoom(zoom);

        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}
TYPO3.jQuery(document).ready(function () {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});