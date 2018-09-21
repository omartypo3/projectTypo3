<?php
namespace Wng\WngCvciNews\UserFunc;

class GoogleMaps
{
    /**
     * @param array $PA
     * @param array $fObj
     * @return string
     */
    public function generateMap($PA, $fObj) {
        $formField = '
        <style>
            /* Always set the map height explicitly to define the size of the div
            * element that contains the map. */
            #map {
                height: 300px;
            }
        </style>
    <div id="map"></div>

    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById(\'map\'), {
          center: {lat: 46.5233071, lng: 6.6294318},
          zoom: 13
        });

        //var input = /** @type {!HTMLInputElement} */(document.getElementById(\'pac-input\'));
        var idInput = $("input[data-formengine-input-name$=\'[tx_wngcvcinews_address]\']").attr("id");
        console.log(idInput);
        var input = /** @type {!HTMLInputElement} */(document.getElementById(idInput));

        //var types = document.getElementById(\'type-selector\');
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo(\'bounds\', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener(\'place_changed\', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: \'" + place.name + "\'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          //marker.setIcon(/** @type {google.maps.Icon} */({
          //  url: place.icon,
          //  size: new google.maps.Size(71, 71),
          //  origin: new google.maps.Point(0, 0),
          //  anchor: new google.maps.Point(17, 34),
          //  scaledSize: new google.maps.Size(35, 35)
          //}));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
          marker.setDraggable(true);

          $("input[data-formengine-input-name$=\'[tx_wngcvcinews_latitude]\']").val(place.geometry.location.lat().toFixed(7));
          $("input[data-formengine-input-name$=\'[tx_wngcvcinews_longitude]\']").val(place.geometry.location.lng().toFixed(7));
          $("input[data-formengine-input-name$=\'[tx_wngcvcinews_latitude]\']").change();
          $("input[data-formengine-input-name$=\'[tx_wngcvcinews_longitude]\']").change();
          $("input[data-formengine-input-name$=\'[tx_wngcvcinews_address]\']").change();

          var address = \'\';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || \'\'),
              (place.address_components[1] && place.address_components[1].short_name || \'\'),
              (place.address_components[2] && place.address_components[2].short_name || \'\')
            ].join(\' \');
          }

          infowindow.setContent(\'<div><strong>\' + place.name + \'</strong><br>\' + address);
          infowindow.open(map, marker);
        });
/*
        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener(\'click\', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener(\'changetype-all\', []);
        setupClickListener(\'changetype-address\', [\'address\']);
        setupClickListener(\'changetype-establishment\', [\'establishment\']);
        setupClickListener(\'changetype-geocode\', [\'geocode\']);
*/



        google.maps.event.addListener(marker, \'dragend\', function (evt) {
            //document.getElementById(\'current\').innerHTML = \'<p>Marker dropped: Current Lat: \' + evt.latLng.lat().toFixed(3) + \' Current Lng: \' + evt.latLng.lng().toFixed(3) + \'</p>\';
            console.log(evt.latLng.lat());
            console.log(evt.latLng.lng());
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_latitude]\']").val(evt.latLng.lat().toFixed(7));
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_longitude]\']").val(evt.latLng.lng().toFixed(7));
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_latitude]\']").change();
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_longitude]\']").change();
        });

        if($("input[name$=\'[tx_wngcvcinews_latitude]\']").val() && $("input[name$=\'[tx_wngcvcinews_longitude]\']").val()) {
            var geocoder = new google.maps.Geocoder();
            geocodeAddress(geocoder, map);
        }

        //google.maps.event.trigger(map, \'resize\');

        $(\'a[aria-controls$=-10]\').on(\'click\', function (e) {
         setTimeout(function() {
            console.log("test");
             //google.maps.event.trigger(map, \'resize\');
             //map.setCenter(new google.maps.LatLng(46.5233071, 6.6294318));
             google.maps.event.trigger(map, \'resize\');
             initMap(); // google map init function
            console.log("end");
            }, 1000);
        });
      }

      function geocodeAddress(geocoder, resultsMap) {
            console.log($("input[name$=\'[tx_wngcvcinews_latitude]\']").val());
            console.log($("input[name$=\'[tx_wngcvcinews_longitude]\']").val());
            var latlng = {lat: parseFloat($("input[name$=\'[tx_wngcvcinews_latitude]\']").val()), lng: parseFloat($("input[name$=\'[tx_wngcvcinews_longitude]\']").val())};
            geocoder.geocode({\'location\': latlng}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    resultsMap.setCenter(results[0].geometry.location);
                    resultsMap.setZoom(17);
                    var marker = new google.maps.Marker({
                        map: resultsMap,
                        position: results[0].geometry.location
                    });
                    marker.setVisible(true);
                    marker.setDraggable(true);

        google.maps.event.addListener(marker, \'dragend\', function (evt) {
            //document.getElementById(\'current\').innerHTML = \'<p>Marker dropped: Current Lat: \' + evt.latLng.lat().toFixed(3) + \' Current Lng: \' + evt.latLng.lng().toFixed(3) + \'</p>\';
            console.log(evt.latLng.lat());
            console.log(evt.latLng.lng());
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_latitude]\']").val(evt.latLng.lat().toFixed(7));
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_longitude]\']").val(evt.latLng.lng().toFixed(7));
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_latitude]\']").change();
            $("input[data-formengine-input-name$=\'[tx_wngcvcinews_longitude]\']").change();
        });
                } else {
                    //alert(\'Geocode was not successful for the following reason: \' + status);
                    $("<p>No address found</p>" ).insertBefore("#map");
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOXAO2Axwlp5r4Ic6aerOrH1zb8nmSybU&libraries=places&callback=initMap&language=fr"></script>
        ';

        return $formField;
    }
}