/**var to check valid field */
valid = 0;
/**Text of the Required fiedl */
WrongMessageText = 'Feld bitte ausfüllen';

var form_sent = 'Das Formular wurde erfolgreich versendet.';
var form_is_sending = 'Mail wird versendet';

/**Detect lang of doc */
if ($('html').attr('lang')) {
    lang = $('html').attr('lang').toUpperCase();
    if (lang == 'FR') {
        WrongMessageText = 'Veuillez remplir la case';
        form_sent = 'Le formulaire a été envoyé';
        form_is_sending = 'Le courrier est envoyé';
    } else if (lang == 'EN') {
        WrongMessageText = 'Please fill in the field';
        form_sent = 'The form has been sent.';
        form_is_sending = 'Sending Mail';
    }
}

var markerArray = [];

function googleIsDefined() {
    return 'undefined' != typeof google;
}

function initAutocomplete() {
    var $mapSettings = $('#mapSettings');

    var styleArray;

    if ($mapSettings.data('map-style')) {
        styleArray = $mapSettings.data('map-style');
    } else {
        styleArray = [
            {
                featureType: 'landscape',
                stylers: [
                    {
                        hue: '#F1FF00',
                    },
                    {
                        saturation: -27.4,
                    },
                    {
                        lightness: 9.4,
                    },
                    {
                        gamma: 1,
                    },
                ],
            },
            {
                featureType: 'landscape.natural',
                elementType: 'labels.icon',
                stylers: [
                    {
                        visibility: 'off',
                    },
                ],
            },
            {
                featureType: 'poi',
                stylers: [
                    {
                        hue: '#9fff00',
                    },
                ],
            },
            {
                featureType: 'poi',
                elementType: 'labels',
                stylers: [
                    {
                        visibility: 'off',
                    },
                ],
            },
            {
                featureType: 'road.arterial',
                stylers: [
                    {
                        hue: '#00FF4F',
                    },
                    {
                        gamma: 1,
                    },
                ],
            },
            {
                featureType: 'road.highway',
                stylers: [
                    {
                        hue: '#0069b4',
                    },
                    {
                        saturation: -20,
                    },
                    {
                        lightness: 36.4,
                    },
                    {
                        gamma: 1,
                    },
                ],
            },
            {
                featureType: 'road.local',
                stylers: [
                    {
                        hue: '#FFB300',
                    },
                    {
                        saturation: -38,
                    },
                    {
                        lightness: 11.2,
                    },
                    {
                        gamma: 1,
                    },
                ],
            },
            {
                featureType: 'water',
                stylers: [
                    {
                        hue: '#0069b4',
                    },
                    {
                        saturation: 4.2,
                    },
                    {
                        lightness: -63.4,
                    },
                    {
                        gamma: 1,
                    },
                ],
            },
        ];
    }

    var mapCenter;
    if ($mapSettings.data('map-center')) {
        mapCenter = $mapSettings.data('map-center');
    } else {
        mapCenter = {
            lat: 47.3236106,
            lng: 8.8439009,
        };
    }


    map = new google.maps.Map(document.getElementById('gmap'), {
        center: mapCenter,
        zoom: 11,
        styles: styleArray,
        scrollwheel: false,
    });

    // Set max Zoom for fitBounds auto Zoom
    var maxZoom = 18;
    google.maps.event.addListener(map, 'zoom_changed', function () {
        zoomChangeBoundsListener = google.maps.event.addListener(
            map,
            'bounds_changed',
            function (event) {
                if (this.getZoom() > maxZoom) {
                    this.setZoom(maxZoom);
                }
                google.maps.event.removeListener(zoomChangeBoundsListener);
            }
        );
    });

    infoWindow = new google.maps.InfoWindow({});

    // Create the search box and link it to the UI element.
    var input = document.getElementById('location_form');
    var autocomplete = new google.maps.places.Autocomplete(input);

    // Set initial restrict to the greater list of countries.
    autocomplete.setComponentRestrictions({
        country: ['ch'],
    });

    // Specify only the data fields that are needed.
    autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementsByClassName(
        'info-window-prototype'
    );
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
    });

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if ($('#location_form').val().length == 0) {
            map.setCenter(mapCenter);
            map.setZoom(9);
            console.log('location search is empty', place);
        } else {
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
                map.setZoom(13);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }
        }

        bounds = map.getBounds();
        // bounds = Object.values(bounds);

        //console.log(bounds);
        //console.log(bounds);
        data_gmap = {
            tx_pingagaddress_mapshow: {
                useajax: 1,
                // minLattitude: bounds[0].g, /* - 0.0006 lat shows locations in search list that are halfway cut off on map */
                // maxlattitude: bounds[0].i, /* + 0.0006 lat shows locations in search list that are halfway cut off on map */
                // minLongitude: bounds[1].g, /* - 0.0006 long shows locations in search list that are halfway cut off on map */
                // maxLongitude: bounds[1].i, /* + 0.0006 long shows locations in search list that are halfway cut off on map */
                minLattitude:
                    bounds.getSouthWest().lat() -
                    0.0006 /* - 0.0006 lat shows locations in search list that are halfway cut off on map */,
                maxlattitude:
                //bounds[0].i +
                    bounds.getNorthEast().lat() +
                    0.0006 /* + 0.0006 lat shows locations in search list that are halfway cut off on map */,
                minLongitude:
                    bounds.getSouthWest().lng() -
                    0.0006 /* - 0.0006 long shows locations in search list that are halfway cut off on map */,
                maxLongitude:
                //bounds[1].i +
                    bounds.getNorthEast().lng() +
                    0.0006 /* + 0.0006 long shows locations in search list that are halfway cut off on map */,
                serviceuid:
                    $('.services_details_map').data('serviceuid') != undefined
                        ? $('.services_details_map').data('serviceuid')
                        : null,
                pagelocationdetail:
                    $('#pagedetaillocation').val() != undefined
                        ? $('#pagedetaillocation').val()
                        : '',
            },
        };

        // console.log("Suche nach Biel, Schweiz");
        // console.log("minLat " + bounds[0].i); // minLat 47.12044294043093
        // console.log("maxLat " + bounds[0].j); // maxLat 47.17881518953092
        // console.log("minLong " + bounds[1].i); // minLong 7.133338783480876
        // console.log("minLong " + bounds[1].j); // minLong 7.380531166293376

        findListByViewport(data_gmap);

        if (place.geometry) {
            marker.setPosition(place.geometry.location);
            marker.setVisible(false);
        }

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] &&
                    place.address_components[0].short_name) ||
                '',
                (place.address_components[1] &&
                    place.address_components[1].short_name) ||
                '',
                (place.address_components[2] &&
                    place.address_components[2].short_name) ||
                '',
            ].join(' ');
        }

        $("#locations .location p.email").each(function () {
            var change = $(this).html().replace('@', '(at)');
            $(this).html(change);
        });

        $(".infowindow-wrap p.email-infowindow").each(function () {
            var change = $(this).text().replace('@', '(at)');
            var content = "<a href='mailto:" + $(this).text() + "'>" + change + "</a>";
            $(this).html(content);
        });

        //infowindowContent.children['place-icon'].src = place.icon;
        //infowindowContent.children['place-name'].textContent = place.name;
        //infowindowContent.children['place-address'].textContent = address;
        // infowindow.open(map, marker);
    });

    $('#location_form_new,#zip_form_new,#umkreis_form_new').on("keyup", function () {
        $('#locations.digitalmap').removeClass("hide-on-start");

        infowindow.close();
        marker.setVisible(false);

        bounds = map.getBounds();
        // bounds = Object.values(bounds);

        //console.log(bounds);
        //console.log(bounds);
        data_gmap = {
            tx_pingagaddress_mapshow: {
                useajax: 1,
                inputValue: $('#location_form_new').val(),
                zipValue: $('#zip_form_new').val(),
                umkreisValue: $('#umkreis_form_new').val(),
                // minLattitude: bounds[0].g, /* - 0.0006 lat shows locations in search list that are halfway cut off on map */
                // maxlattitude: bounds[0].i, /* + 0.0006 lat shows locations in search list that are halfway cut off on map */
                // minLongitude: bounds[1].g, /* - 0.0006 long shows locations in search list that are halfway cut off on map */
                // maxLongitude: bounds[1].i, /* + 0.0006 long shows locations in search list that are halfway cut off on map */
                minLattitude:
                    bounds.getSouthWest().lat() -
                    0.0006 /* - 0.0006 lat shows locations in search list that are halfway cut off on map */,
                maxlattitude:
                //bounds[0].i +
                    bounds.getNorthEast().lat() +
                    0.0006 /* + 0.0006 lat shows locations in search list that are halfway cut off on map */,
                minLongitude:
                    bounds.getSouthWest().lng() -
                    0.0006 /* - 0.0006 long shows locations in search list that are halfway cut off on map */,
                maxLongitude:
                //bounds[1].i +
                    bounds.getNorthEast().lng() +
                    0.0006 /* + 0.0006 long shows locations in search list that are halfway cut off on map */,
                serviceuid:
                    $('.services_details_map').data('serviceuid') != undefined
                        ? $('.services_details_map').data('serviceuid')
                        : null,
                pagelocationdetail:
                    $('#pagedetaillocation').val() != undefined
                        ? $('#pagedetaillocation').val()
                        : '',
            },
        };

        //findListByViewport(data_gmap);
        url = $('.url_for_list_ajax_loaction').val();
        if ($('#location_form_new').val() != '' || $('#zip_form_new').val().length >= 4 || $('#umkreis_form_new').val() != '') {

            console.log($('#location_form_new').val());

            $.ajax({
                type: 'POST',
                url: url,
                data: data_gmap,
                success: function (data) {

                    $('.location-list').empty();
                    $('.location-list')
                        .hide()
                        .html($(data).find('.location-list'))
                        .fadeIn('slow');


                    //updateVisibleMarkers();

                    var $resultList = $('#locations');
                    var $results = $('#locations .location');
                    var $service = $('#category');
                    var $kantones = $('#kantonecategory');
                    var $angebotes = $('#angebote');
                    var $lebensalters = $('#lebensalter');

                    var i = new google.maps.LatLngBounds();
                    var markerIds = [];

                    $results.each(function (e, t) {
                       // updateVisibleMarkers();
                        var a = $(t),
                            n = window.location.origin + '/fileadmin/templates/img/marker.png';
                        markerIds.push(a.data('uid'));
                        //markerIds.push(a.attr('id'));
                        /*if (!a.data('lat') || !a.data('lng')) return !0;
                        a.data('marker-icon') && (n = a.data('marker-icon'));
                        var o = new google.maps.Marker({
                            id: a.data('uid'),
                            title: a.find('.info-window-prototype .title').text(),
                            infowindowContent: a.find('.info-window-prototype').html(),
                            position: {
                                lat: a.data('lat'),
                                lng: a.data('lng'),
                            },
                            map: map,
                            clickable: !0,
                            icon: n,
                        });
                        i.extend(o.getPosition()),
                            markerArray.push(o),
                            addInfoWindow(o),
                            addTooltip(o);*/
                    });
                    //  map.fitBounds(i);
                   //     console.log(markerIds);

                    console.log(markerIds);

                    updateMarkers(markerIds);
                    /*$('#locations .location').each(function (e, t) {

                        var a = $(t),
                            n = window.location.origin + '/fileadmin/templates/img/marker.png';

                        var validatelat = isValidLatitude(a.data('lat'));
                        var validatelng = isValidLongitude(a.data('lng'));
                        //if (!a.data('lat') || !a.data('lng') || validatelat || validatelng) return !0;

                        if (!a.data('lat') || !a.data('lng')) return !0;
                        if(validatelat && validatelng){
                            a.data('marker-icon') && (n = a.data('marker-icon'));

                            var o = new google.maps.Marker({
                                id: a.data('uid'),
                                title: a.find('.info-window-prototype .title').text(),
                                infowindowContent: a.find('.info-window-prototype').html(),
                                position: {
                                    lat: a.data('lat'),
                                    lng: a.data('lng'),
                                },
                                map: map,
                                clickable: !0,
                                icon: n,
                            });
                            i.extend(o.getPosition()),
                                markerArray.push(o),
                                addInfoWindow(o),
                                addTooltip(o);
                        }

                    });*/

                    //updateVisibleMarkers();

                    // START: New code for filtering dropdowns after search field
                    var serviceId = false;
                    if ($service.length) {
                        serviceId = getSelectedVal($service);
                    }
                    filterList($results, serviceId, getSelectedVal($kantones), 0, getSelectedVal($angebotes), getSelectedVal($lebensalters));
                    // END: New code for filtering dropdowns after search field

                    // START: New code for re-initializing Accordions after search field
                    var accordions = document.querySelectorAll('.accordion h5.accordion-title-wrapper');
                    accordions.forEach((accordionEl) => {
                        new Accordion(accordionEl);
                    });
                    var accordions2 = document.querySelectorAll('.accordion h3.event-title');
                    accordions2.forEach((accordionE2) => {
                        new Accordion(accordionE2);
                    });
                    var accordions3 = document.querySelectorAll('.accordion h3.accordion-title-wrapper');
                    accordions3.forEach((accordionE3) => {
                        new Accordion(accordionE3);
                    });
                    // END: New code for re-initializing Accordions after search field

                    $('#category,#kantonecategory,#angebote,#lebensalter').on('change', function (e) {
                        $resultList.show();
                        var serviceId = false;
                        if ($service.length) {
                            serviceId = getSelectedVal($service);
                        }
                        filterList($results, serviceId, getSelectedVal($kantones), 0, getSelectedVal($angebotes), getSelectedVal($lebensalters));
                        updateVisibleMarkers();
                    });


                    $(".infowindow-wrap p.email-infowindow, .location p.email-infowindow").each(function () {
                        var change = $(this).text().replace('@', '(at)');
                        var content = "<a href='mailto:" + $(this).text() + "'>" + change + "</a>";
                        $(this).html(content);
                    });



                },
                error: function (jqXHR, textStatus, errorThrow) {
                    console.log(errorThrow);
                },
            });

        } else {


            $('.location-list').empty();
            updateMarkers([]);
            /*mapCenter = {
                lat: 47.3236106,
                lng: 8.8439009,
            };
            map = new google.maps.Map(document.getElementById('gmap'), {
                center: mapCenter,
                zoom: 11,
                styles: styleArray,
                scrollwheel: false,
            });*/
        }
    });
}

function buildMarkers() {
    if (!googleIsDefined()) return 0;
    var i = new google.maps.LatLngBounds();
    /*var iconURLPrefix = 'https://maps.google.com/mapfiles/ms/icons/';

    var icons = [
        iconURLPrefix + 'red-dot.png',
        iconURLPrefix + 'green-dot.png',
        iconURLPrefix + 'blue-dot.png',
        iconURLPrefix + 'orange-dot.png',
        iconURLPrefix + 'purple-dot.png',
        iconURLPrefix + 'pink-dot.png',
        iconURLPrefix + 'yellow-dot.png'
    ]*/

    $('#locations .location:visible').each(function (e, t) {

        var a = $(t),
            n = window.location.origin + '/fileadmin/templates/img/marker.png';

        var validatelat = isValidLatitude(a.data('lat'));
        var validatelng = isValidLongitude(a.data('lng'));
        //if (!a.data('lat') || !a.data('lng') || validatelat || validatelng) return !0;

        if (!a.data('lat') || !a.data('lng')) return !0;
        if(validatelat && validatelng){
            a.data('marker-icon') && (n = a.data('marker-icon'));

            var o = new google.maps.Marker({
                id: a.data('uid'),
                title: a.find('.info-window-prototype .title').text(),
                infowindowContent: a.find('.info-window-prototype').html(),
                position: {
                    lat: a.data('lat'),
                    lng: a.data('lng'),
                },
                map: map,
                clickable: !0,
                icon: n,
            });
            i.extend(o.getPosition()),
                markerArray.push(o),
                addInfoWindow(o),
                addTooltip(o);
        }

    }),
        map.fitBounds(i);

    $('#category,#kantonecategory').on('change', function (e) {
        // markerArray = [];
        $('#locations .location:visible').each(function (e, t) {

            //var iconRandom = icons[Math.floor(Math.random() * icons.length)];
            var a = $(t),
                n = 'fileadmin/templates/img/marker.png';
            var validatelat = isValidLatitude(a.data('lat'));
            var validatelng = isValidLongitude(a.data('lng'));

            if (!a.data('lat') || !a.data('lng')) return !0;
            if(validatelat && validatelng) {
                a.data('marker-icon') && (n = a.data('marker-icon'));
                var o = new google.maps.Marker({
                    id: a.data('uid'),
                    title: a.find('.info-window-prototype .title').text(),
                    infowindowContent: a.find('.info-window-prototype').html(),
                    position: {
                        lat: a.data('lat'),
                        lng: a.data('lng'),
                    },
                    map: map,
                    clickable: !0,
                    icon: n,
                });
                i.extend(o.getPosition()),
                    markerArray.push(o),
                    addInfoWindow(o),
                    addTooltip(o);
            }
        }), map.fitBounds(i);


    });

    /*$('#kantonecategory').on('change', function (e) {
        $('#locations .location').each(function (e, t) {
            //var iconRandom = icons[Math.floor(Math.random() * icons.length)];
            var  a = $(t),
                n = 'fileadmin/templates/img/marker.png';
            //console.log( $('#locations .location:visible').length());
            if (!a.data('lat') || !a.data('lng')) return !0;

            a.data('marker-icon') && (n = a.data('marker-icon'));
             var o = new google.maps.Marker({
                id: a.data('uid'),
                title: a.find('.info-window-prototype .title').text(),
                infowindowContent: a.find('.info-window-prototype').html(),
                position: {
                    lat: a.data('lat'),
                    lng: a.data('lng'),
                },
                map: map,
                clickable: !0,
                icon: n,
            });
            console.log(markerArray.push(o));

            i.extend(o.getPosition()),
                markerArray.push(o),
                addInfoWindow(o),
                addTooltip(o);
        }),map.fitBounds(i);


    });*/
}

function addTooltip(e) {
    google.maps.event.addListener(e, 'mouseover', function () {
        infoWindow.setContent('<h3 id="gmapTooltip">' + e.title + '</h3>'),
            infoWindow.open(map, e);
    }),
        google.maps.event.addListener(e, 'mouseout', function () {
            -1 < infoWindow.getContent().indexOf('gmapTooltip') && infoWindow.close();
        });
}

function addInfoWindow(e, t, a) {
    google.maps.event.addListener(e, 'click', function () {
        infoWindow.setContent(e.infowindowContent),
            infoWindow.open(map, e),
            map.panTo(this.getPosition()),
            map.setZoom(13);
    });
}

function updateMarkersCallback(e) {
    for (
        var t = new google.maps.LatLngBounds(), a = 0;
        a < markerArray.length;
        a++
    ) {
        var n = markerArray[a];
        -1 < $.inArray(n.id, e)
            ? (n.setVisible(!0), t.extend(n.getPosition()))
            : n.setVisible(!1);
    }
    0 < e.length && map.fitBounds(t);
}

function updateMarkers(e) {
    // googleIsDefined()
    //     ? updateMarkersCallback(e)
    //     : setTimeout(function () {
    //         updateMarkersCallback(e);
    //     }, 500);
    setTimeout(function () {
        updateMarkersCallback(e);
    }, 500);
}

function recenterMap(e, t) {
    void 0 !== map &&
    map.setCenter({
        lat: e,
        lng: t,
    });
}

function findListByViewport(mapObj) {
    url = $('.url_for_list_ajax_loaction').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: mapObj,
        success: function (data) {

            $('.location-list').empty();
            $('.location-list')
                .hide()
                .html($(data).find('.location-list'))
                .fadeIn('slow');
            var markerArray = [];
            var $resultList = $('#locations');
            var $results = $('#locations .location');
            var $service = $('#category');
            var $kantones = $('#kantonecategory');
            var $angebotes = $('#angebote');
            var $lebensalters = $('#lebensalter');
            if (typeof google == 'undefined') {
                setTimeout(buildMarkers, 500);
            } else {
                console.log("test");
                buildMarkers();
            }
            $('#category,#kantonecategory,#angebote,#lebensalter').on('change', function (e) {
                $resultList.show();

                var serviceId = false;
                if ($service.length) {
                    serviceId = getSelectedVal($service);
                }

                filterList($results, serviceId, getSelectedVal($kantones), 0, getSelectedVal($angebotes), getSelectedVal($lebensalters));
                updateVisibleMarkers();
            });
            $("#locations .location p.email").each(function () {
                var change = $(this).html().replace('@', '(at)');
                $(this).html(change);
            });

            $(".infowindow-wrap p.email-infowindow").each(function () {
                var change = $(this).text().replace('@', '(at)');
                var content = "<a href='mailto:" + $(this).text() + "'>" + change + "</a>";
                $(this).html(content);
            });
        },
        error: function (jqXHR, textStatus, errorThrow) {
            console.log(errorThrow);
        },
    });
}

document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelectorAll('#gmap').length > 0) {
        if (document.querySelector('html').lang)
            lang = document.querySelector('html').lang;
        else lang = 'de';

        var js_file = document.createElement('script');
        js_file.type = 'text/javascript';
        js_file.src =
            'https://maps.googleapis.com/maps/api/js?callback=initAutocomplete&libraries=places&key=AIzaSyC-UbMBaw00h6-VTRr-DjLqPERBaSD3fQ0&language=' +
            lang;
        document.getElementsByTagName('head')[0].appendChild(js_file);
    }
});

$('.icon_search').keypress(function (e) {
    // console.log('ts');
});


$(document).on('click', '.search_icon', function () {
    url = $('.url_for_list_ajax_loaction').val();
    var data = {
        tx_pingagclicconnector_locations: {
            lat: 1,
            lng: 1,
        },
    };
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrow) {
            console.log(errorThrow);
        },
    });
});

/**Function to send mail */
$(document).on('submit', 'form[name="sendnewMailAjax"]', function () {
    wrongmessage = "<span class='wrong_ajax'>" + WrongMessageText + '</span>';
    $('form[name="sendnewMailAjax"] .required_field_ajax input').each(function (
        index,
        element
    ) {
        $parent = $(element).parent();
        $classrequired = $(element).parent().find('.required_text');
        value = $(element).val();

        if (value.length == 0) {
            if (!$classrequired.find('span').hasClass('wrong_ajax')) {
                valid += 1;
                $parent.find('.required_text').append(wrongmessage);
            }
        } else if (
            value.length > 0 &&
            $classrequired.find('span').hasClass('wrong_ajax') &&
            $(element).attr('type') != 'email' &&
            $(element).attr('type') != 'tel'
        ) {
            $classrequired.empty();
            valid -= 1;
        } else if (
            $(element).attr('type') == 'email' &&
            value.length > 0 &&
            !IsEmail(value) &&
            !$classrequired.find('span').hasClass('wrong_ajax')
        ) {
            $parent.find('.required_text').append(wrongmessage);
            valid += 1;
        } else if (
            $(element).attr('type') == 'email' &&
            value.length > 0 &&
            IsEmail(value) &&
            $classrequired.find('span').hasClass('wrong_ajax')
        ) {
            $classrequired.empty();
            valid -= 1;
        } else if (
            $(element).attr('type') == 'tel' &&
            value.length > 0 &&
            !$.isNumeric(value) &&
            !$classrequired.find('span').hasClass('wrong_ajax')
        ) {
            $parent.find('.required_text').append(wrongmessage);
            valid += 1;
        } else if (
            $(element).attr('type') == 'tel' &&
            value.length > 0 &&
            $.isNumeric(value) &&
            $classrequired.find('span').hasClass('wrong_ajax')
        ) {
            $classrequired.empty();
            valid -= 1;
        }
    });
    if (valid > 0) {
        return false;
    }
    ajaxindicatorstart(form_is_sending);
    text_success = 'Vielen Dank für Ihre Nachricht.';
    successMessage = "<div class='mail_sent'><p>" + text_success + '</p></div>';
    url = $('.url_for_send_amil_ajax_loaction').val();
    var data = {
        tx_pingagclicconnector_locations: {
            data: {
                name: $('input[name="surName"]').val(),
                vorname: $('input[name="firstName"]').val(),
                mail: $('input[name="mail"]').val(),
                phone: $('input[name="phone"]').val(),
                comment: $('textarea[name="comment"]').val(),
            },
            admin_mail: $('.admin_mail_ajax').val(),
        },
    };
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (data) {
            ajaxindicatorstop();
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: form_sent,
                showConfirmButton: false,
                timer: 1500,
            });
            $('form[name="sendnewMailAjax"]').replaceWith(successMessage);
        },
        error: function (jqXHR, textStatus, errorThrow) {
            console.log(errorThrow);
        },
    });
    return false;
});

$(document).on('click', '.box_to_map', function () {
    $('html, body').animate(
        {
            scrollTop: $('.services_details_map').offset().top,
        },
        500,
        'linear'
    );
});

//FUNCTION INDICATEUR
function ajaxindicatorstart(text) {
    if ($('body').find('#resultLoading').attr('id') != 'resultLoading') {
        $('body').append(
            '<div id="resultLoading" style="display:none"><div><img src="fileadmin/templates/img/Infinity.svg"><div>' +
            text +
            '</div></div><div class="bg"></div></div>'
        );
    }
    $('#resultLoading').css({
        width: '100%',
        height: '100%',
        position: 'fixed',
        'z-index': '10000000',
        top: '0',
        left: '0',
        right: '0',
        bottom: '0',
        margin: 'auto',
    });

    $('#resultLoading .bg').css({
        background: '#000000',
        opacity: '0.7',
        width: '100%',
        height: '100%',
        position: 'absolute',
        top: '0',
    });

    $('#resultLoading>div:first').css({
        width: '250px',
        height: '75px',
        'text-align': 'center',
        position: 'fixed',
        top: '0',
        left: '0',
        right: '0',
        bottom: '0',
        margin: 'auto',
        'font-size': '16px',
        'z-index': '10',
        color: '#ffffff',
    });

    $('#resultLoading .bg').height('100%');
    $('#resultLoading').fadeIn(300);
    $('body').css('cursor', 'wait');
}

//INDICATEUR STOP
function ajaxindicatorstop() {
    $('#resultLoading .bg').height('100%');
    $('#resultLoading').fadeOut(300);
    $('body').css('cursor', 'default');
}

function IsEmail(email) {
    var regex =
        /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return !regex.test(email) ? false : true;
}

$('.accordion-body').on('shown.bs.collapse', function () {
    $(this).siblings('.accordion-heading').addClass('openaccordion');
});

$('.accordion-body').on('hidden.bs.collapse', function () {
    $(this).siblings('.accordion-heading').removeClass('openaccordion');
});

input = document.getElementById('location_form');

(function pacSelectFirst(input) {
    // store the original event binding function
    if (input) {
        var _addEventListener = (input.addEventListener) ? input.addEventListener : input.attachEvent;

        function addEventListenerWrapper(type, listener) {
            // Simulate a 'down arrow' keypress on hitting 'return' when no pac suggestion is selected,
            // and then trigger the original listener.
            if (type == "keydown") {
                var orig_listener = listener;
                listener = function (event) {
                    var suggestion_selected = $(".pac-item-selected").length > 0;
                    if (event.which == 13 && !suggestion_selected) {
                        var simulated_downarrow = $.Event("keydown", {
                            keyCode: 40,
                            which: 40
                        });
                        orig_listener.apply(input, [simulated_downarrow]);
                    }

                    orig_listener.apply(input, [event]);
                };
            }

            _addEventListener.apply(input, [type, listener]);
        }

        input.addEventListener = addEventListenerWrapper;
        input.attachEvent = addEventListenerWrapper;
    }
})(input);



// DigitalMap: set center of Switzerland and zoom out to see whole Switzerland
$(window).load(function () {
    if($('body.digitalmap').length == 1) {
        map.setCenter({lat: 46.798449, lng: 8.231879});
        map.setZoom(8);
    }
});

function isValidLatitude(lat) {
    return typeof lat === 'number' && lat >= -90 && lat <= 90;
}

function isValidLongitude(lon) {
    return typeof lon === 'number' && lon >= -180 && lon <= 180;
}

