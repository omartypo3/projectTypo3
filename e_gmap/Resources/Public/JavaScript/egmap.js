function eGmapLoadMap(eGmap) {
    eGmap['map'] = new google.maps.Map(document.getElementById('eGmapMap__' + eGmap['settings'].map.mapUniqId),	{
        center: new google.maps.LatLng(eGmap['settings'].map.center.lat , eGmap['settings'].map.center.lng),
        zoom: parseInt(eGmap['settings'].map.zoom.value),
        minZoom: parseInt(eGmap['settings'].map.zoom.min),
        maxZoom: parseInt(eGmap['settings'].map.zoom.max),
        scrollwheel: (eGmap['settings'].map.zoom.molette != "0"),
        draggable:  (eGmap['settings'].map.draggable != "0"),
        zoomControl: (eGmap['settings'].map.zoom.actif != "0"),
        zoomControlOptions: (eGmap['settings'].map.zoom.position)?{position: google.maps.ControlPosition[eGmap['settings'].map.zoom.position]}:{},
        streetViewControl:  (eGmap['settings'].map.streetview.actif != "0"),
        streetViewControlOptions: (eGmap['settings'].map.streetview.position)?{position: google.maps.ControlPosition[eGmap['settings'].map.streetview.position]}:{},
        panControl:  (eGmap['settings'].map.deplacement.actif != "0"),
        panControlOptions: (eGmap['settings'].map.deplacement.position)?{position: google.maps.ControlPosition[eGmap['settings'].map.deplacement.position]}:{},
        mapTypeControl:  (eGmap['settings'].map.type.actif != "0"),
        mapTypeControlOptions: (eGmap['settings'].map.type.position)?{position: googlae.maps.ControlPosition[eGmap['settings'].map.type.position]}:{},
        mapTypeId:  (eGmap['settings'].map.type.defaut)?google.maps.MapTypeId[eGmap['settings'].map.type.defaut]:google.maps.MapTypeId.ROADMAP,
        overviewMapControl: false,
        rotateControl: false,
        scaleControl: false,
        styles: (eGmap['settings'].styles) ? eGmap['settings'].styles : null
    });

    if(eGmap['settings'].map.trafic == "1") {
        eGmap['trafficLayer'] = new google.maps.TrafficLayer();
        eGmap['trafficLayer'].setMap(eGmap['map']);
    }

    if(eGmap['settings'].map.recherche.actif == "1") {
        eGmap['geocoder'] = new google.maps.Geocoder();
        $('#eGmapRecherche__' + eGmap['settings'].map.mapUniqId).submit(function (e) {
            e.preventDefault();
            eGmapSearch(eGmap);
        });
    }

    if(typeof eGmap['settings'].poi !== 'undefined') {
        if (eGmap['settings'].poi.liste == "1") {
            $('.eGmapLoadInfosPoi__' + eGmap['settings'].map.mapUniqId).click(function (e) {
                e.preventDefault();
                var matches = $(this).attr('id').match(/^1_([A-Za-z0-9_]+)_([0-9]+)/)
                if (matches !== null) {
                    eGmapLoadInfosPoi(eGmap, eGmap['uidToKey'][matches[1] + "_" + matches[2]], "0", matches[1])
                }
            });
        }
    }

    if(eGmap['settings'].map.itineraire.actif == "1") {
        eGmap['directionsService'] = new google.maps.DirectionsService();
        eGmap['directionsDisplay'] = new google.maps.DirectionsRenderer();
        eGmap['directionsDisplay'].setMap(eGmap['map']);
        if(eGmap['settings'].map.itineraire.panel == "1") {
            eGmap['directionsDisplay'].setPanel(document.getElementById('eGmapItinerairePanel__' + eGmap['settings'].map.mapUniqId));
        }
        $('#eGmapItineraire__' + eGmap['settings'].map.mapUniqId).submit(function(e){
            e.preventDefault();
            eGmapItineraire(eGmap);
        });
    }

    if(eGmap['settings'].view == "wizard") {
        eGmapWizardCenter(eGmap);

        $('#eGmapSearchReset__' + eGmap['settings'].map.mapUniqId).click(function (e) {
            e.preventDefault();
            eGmapSearchReset(eGmap)
        });

        $('#eGmapSearchSave__' + eGmap['settings'].map.mapUniqId).click(function (e) {
            e.preventDefault();
            eGmapSearchSave(eGmap)
        });
    }

    if(eGmap['settings'].view == "module") {
        eGmapLoadPois(eGmap, 1);
        eGmapLoadKmls(eGmap);

        $(".ajaxPagination").click(function(e){
            e.preventDefault();
            var val = parseInt($(e.target).text());
            $("#poi_table .item").each(function(i){
                if(parseInt(i) > (val-1)*10 && parseInt(i) <= val*10) {
                    $(this).css('display', 'table-row');
                } else {
                    $(this).css('display', 'none');
                }
            });
        });

        $('.eGmapSeePoi').click(function (e) {
            e.preventDefault();
            seePoi(eGmap, $(this).attr('data-poi-uid'));
        });
    } else {
        eGmapLoadPois(eGmap, 0);
        eGmapLoadKmls(eGmap);
    }

    if(eGmap['settings'].map.cluster.actif == "1") {
        eGmap['mc'] = new MarkerClusterer( eGmap['map'],  eGmap['marker']);

        if(eGmap['settings'].cluster.styles != "") {
            eGmap['mc'].setStyles(eGmap['settings'].cluster.styles);
            eGmap['mc'].setCalculator(function(markers, numStyles) {
                var count = markers.length;
                var index = -1;
                var styles = eGmap['mc'].getStyles();
                for(i=0;i<numStyles;i++){
                    if(styles[i].min <= count && !styles[i].max){
                        index = i;
                    }
                    if(styles[i].min <= count && count <= styles[i].max){
                        index = i;
                    }
                }

                return {
                    text: count,
                    index: index
                };
            });
        }
    }

    if(typeof eGmap['settings'].cat !== 'undefined') {
        if (eGmap['settings'].cat.liste == "1") {
            eGmapCatInit(eGmap);
        }
    }

    if(typeof eGmap['settings'].poi !== 'undefined') {
        if (eGmap['settings'].poi.liste == "1") {
            eGmapPoiListeInit(eGmap);
        }
    }
}

function eGmapLoadKmls(eGmap){
    if(eGmap['kmls'] && eGmap['kmls'].kml){
        if(eGmap['kmls'].kml.length>0){
            for(i=0;i<eGmap['kmls'].kml.length;i++){
                eGmapLoadKml(eGmap, eGmap['kmls'].kml[i]);
            }
        }else{
            eGmapLoadKml(eGmap, eGmap['kmls'].kml);
        }
    }
}

function eGmapLoadKml(eGmap, kml){
    key = eGmap['layers'].length;
    eGmap['layers'][key] = new google.maps.KmlLayer({
        url: kml.data,
        preserveViewport: true,
        map: eGmap['map'],
        key: key,
        infokml: kml
    });
}

function eGmapLoadPois(eGmap, backend){
    if(eGmap['pois'] && eGmap['pois'].poi){
        eGmap['bounds'] = new google.maps.LatLngBounds();

        if(eGmap['pois'].poi.length>0){
            for(i=0;i<eGmap['pois'].poi.length;i++){
                eGmapLoadPoi(eGmap, eGmap['pois'].poi[i], backend);
            }
            if(eGmap['settings'].map.center.type == 'auto' && eGmap['bounds']){
                if(eGmap['settings'].map.zoom.value>0){
                    eGmap['map'].setCenter(eGmap['bounds'].getCenter());
                }else{
                    eGmap['map'].fitBounds(eGmap['bounds']);
                }
            }
            if(eGmap['settings'].map.forcePoi){
                if(eGmapLoadInfosPoi(eGmap, eGmap['uidToKey'][eGmap['settings'].map.forcePoi], backend, '')){
                    eGmap['map'].setCenter(eGmap['marker'][eGmap['uidToKey'][eGmap['settings'].map.forcePoi]].getPosition());
                }
            }
        }else{
            eGmapLoadPoi(eGmap, eGmap['pois'].poi, backend);

            if(eGmap['settings'].map.noBulle == "1") {
                eGmap['map'].setCenter(eGmap['marker'][0].getPosition());
            } else {
                if(eGmapLoadInfosPoi(eGmap, 0, backend, '')){
                    eGmap['map'].setCenter(eGmap['marker'][0].getPosition());
                }
            }
        }
    }
}

function eGmapLoadPoi(eGmap, poi, backend){
    key = eGmap['marker'].length;

	if((typeof poi.lat != 'string' && typeof poi.lat != 'number') || (typeof poi.lng != 'string' && typeof poi.lng != 'number')) {
        return;
    }

    if(parseFloat(poi.lat) == NaN || parseFloat(poi.lng) == NaN) {
        return;
    }

    position = new google.maps.LatLng(poi.lat, poi.lng);
    eGmap['marker'][key] = new google.maps.Marker({
        position: position,
        title: poi.title
    });

    eGmap['marker'][key].key = key;
    eGmap['marker'][key].infopoi = poi;
    if(poi.cats){
        eGmap['marker'][key].cats = poi.cats.split(",");
    }else{
        eGmap['marker'][key].cats = [];
    }
    eGmap['marker'][key].setMap(eGmap['map']);

    eGmap['uidToKey'][poi.table + "_" + poi.uid] = key;

    if(poi.picto && poi.picto != ""){
        eGmap['marker'][key].setIcon("/" + poi.picto);
    }

    google.maps.event.addListener(eGmap['marker'][key], 'click', function() {
        eGmapLoadInfosPoi(eGmap, this.key, backend, poi.table);
    });

    eGmap['bounds'].extend(position);
}

function eGmapLoadInfosPoi(eGmap, key, backend, table){
    if(typeof eGmap['marker'][key] === 'undefined')
        return false;

    if(eGmap['marker'][key].infowindow){
        eGmap['marker'][key].infowindow.close();
        eGmap['marker'][key].infowindow = false;
    }else{
        eGmap['marker'][key].infowindow = new google.maps.InfoWindow({
            content: eGmap['settings'].map.loadingInfo
        });

        eGmap['marker'][key].infowindow.key = key;

        eGmap['infoZIndex'] = (eGmap['infoZIndex'])?eGmap['infoZIndex']+1:6;
        eGmap['marker'][key].infowindow.setZIndex(eGmap['infoZIndex']);

        google.maps.event.addListener(eGmap['marker'][key].infowindow, 'closeclick', function(){
            eGmap['marker'][this.key].infowindow = false;
        });

        if(backend == "0"){
            $.ajax({
                type: 'POST',
                dataType: "xml",
                data: {
                    eID: 'eGmapInfoPoi',
                    id: eGmap['settings'].map.id,
                    uid: eGmap['marker'][key].infopoi.uid,
                    type: eGmap['marker'][key].infopoi.type,
                    key: key
                },
                success: function(result){
                    //key =  $(result).find("key").text();
                    tabs = $(result).find("tab");
                    if(tabs.length > 0){
                        $(result).find("tab").each(function(){
                            label =  $(this).find("label").text();
                            content =  $(this).find("content").text();
                            eGmap['marker'][key].infowindow.addTab(label, content);
                        });
                    } else {
                        content = $(result).find("content").text();
                        eGmap['marker'][key].infowindow.setContent(content);
                    }
                    eGmap['marker'][key].infowindow.open(eGmap['map'], eGmap['marker'][key]);
                    window.setTimeout(function() {
                        $('.eGmapYAllerLink').click(function (e) {
                            e.preventDefault();
                            eGmapYAller(eGmap, $(this).attr('data-pos-latitude'), $(this).attr('data-pos-longitude'), $(this).attr('data-pos-address'))
                        });
                    }, 1000);
                },
                error: function(error) {
                    console.dir(error);
                    eGmap['marker'][key].infowindow.close();
                    eGmap['marker'][key].infowindow = false;
                }
            });
        } else {
            $.ajax({
                url: TYPO3.settings.ajaxUrls['info_poi_backend'],
                type: 'POST',
                dataType: "xml",
                data: {
                    id: eGmap['settings'].map.id,
                    uid: eGmap['marker'][key].infopoi.uid,
                    type: eGmap['marker'][key].infopoi.type,
                    key: key
                },
                success: function(result) {
                    key =  $(result).find("key").text();
                    type =  $(result).find("type").text();
                    uid =  $(result).find("uid").text();
                    movePoint =  $(result).find("movePoint").text();
                    savePoint =  $(result).find("savePoint").text();
                    editPoint =  $(result).find("editPoint").text();
                    tabs = $(result).find("tab");
                    title = $(result).find("title").text();

                    content = '<p>'+title+'</p>';
                    content += '<input type="button" class="moveButton" name="'+uid+'_'+key+'" id="'+uid+'_'+key+'" value="'+movePoint+'">';
                    content += '<input type="button" class="editButton" name="'+uid+'_'+key+'" id="'+uid+'_'+key+'" onclick="data" value="'+editPoint+'">';
                    content = '<div class="infowindow_content">'+content+'</div>';

                    content = $(content);
                    content.find('.moveButton').click(function() {
                        gestPoi(eGmap, uid, key, type, savePoint, title);
                    });

                    eGmap['marker'][key].infowindow.setContent(content.get(0));
                    window.setTimeout(function() {
                        editPoi(uid, table, $('#pageId').data('tab'));
                    }, 100);
                    eGmap['marker'][key].infowindow.open(eGmap['map'], eGmap['marker'][key]);
                },
                error: function(error) {
                    console.dir(error);
                    eGmap['marker'][key].infowindow.close();
                    eGmap['marker'][key].infowindow = false;
                }
            });
        }
    }
    return true;
}

function eGmapSearch(eGmap){
    if(eGmap['settings'].map.itineraire.actif == "1") {
        eGmapItineraireReset(eGmap);
    }

    var address = $('#eGmapAdress__' + eGmap['settings'].map.mapUniqId).val();
    eGmap['geocoder'].geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            eGmap['boundResult'] = results[0].geometry.bounds;
            if(!eGmap['boundResult']){
                eGmap['boundResult'] = new google.maps.LatLngBounds(
                    results[0].geometry.viewport.getSouthWest(),
                    results[0].geometry.viewport.getNorthEast()
                );
            }

            eGmap['map'].fitBounds(eGmap['boundResult']);

            if(eGmap['boundResultMarker']){
                eGmap['boundResultMarker'].setPosition(eGmap['boundResult'].getCenter());
            }else{
                eGmap['boundResultMarker'] = new google.maps.Marker({
                    map: eGmap['map'],
                    position: eGmap['boundResult'].getCenter()
                });

                if(eGmap['settings'].view == "wizard") {
                    eGmap['boundResultMarker'].setDraggable(true);
                }

                if(eGmap['settings'].view == "module") {
                    var position = eGmap['boundResultMarker'].getPosition();
                    eGmap['boundResultMarker'].setMap(null);
                    eGmap['boundResultMarker'] = null;
                    newPoiAct(eGmap, position);
                    $('#lat').val(eGmap['boundResultMarker'].getPosition().lat());
                    $('#lng').val(eGmap['boundResultMarker'].getPosition().lng());
                    eGmapModuleCenter(eGmap);
                    $("#createPoi").css('display', 'none');
                    $("#createPoi").click(function(){
                        eGmapModuleCenter(eGmap);
                        $("#createPoi").css('display', 'none');
                        $("#poiGestionLabel").css('display', 'block');
                    });
                    $("#poiGestionLabel").css('display', 'block');
                }
            }
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function eGmapSearchReset(eGmap){
    $('#eGmapAdress__' + eGmap['settings'].map.mapUniqId).val('');
    if(eGmap['boundResultMarker']){
        eGmap['boundResultMarker'].setMap(null);
        eGmap['boundResultMarker'] = null;
    }
}

function eGmapItineraire(eGmap){
    if(eGmap['settings'].map.recherche.actif == "1") {
        eGmapSearchReset(eGmap);
    }

    var address1 = $('#eGmapAdress1__' + eGmap['settings'].map.mapUniqId).val();
    var address2 = $('#eGmapAdress2__' + eGmap['settings'].map.mapUniqId).val();
    var type = eGmap['settings'].map.itineraire.type;
    if(eGmap['settings'].map.itineraire.show == "1") {
        type = $('#eGmapType__' + eGmap['settings'].map.mapUniqId).val();
    }
    type = type?google.maps.TravelMode[type]:null;

    var request = {
        origin: address1,
        destination: address2,
        travelMode: type
    };
    eGmap['directionsService'].route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            eGmap['directionsDisplay'].setDirections(response);
        }
    });
}

function eGmapItineraireReset(eGmap){
    $('#eGmapAdress1__' + eGmap['settings'].map.mapUniqId).val('');
    $('#eGmapAdress2__' + eGmap['settings'].map.mapUniqId).val('');
    if(eGmap['settings'].map.itineraire.show == "1") {
        $('#eGmapType__' + eGmap['settings'].map.mapUniqId + ' option[value="' + eGmap['settings'].map.itineraire.type + '"]').prop('selected', true);
    }

    if(eGmap['directionsDisplay']){
        eGmap['directionsDisplay'].setDirections({routes:[]});
    }
}

function eGmapWizardCenter(eGmap){
    myForm = window.opener.document[eGmap['params'].formName];
    lat = myForm[eGmap['params'].latName].value;
    lng = myForm[eGmap['params'].lngName].value;
    if(lat && lng){
        wizardCenter = new google.maps.LatLng(lat , lng);
        eGmapWizardSetmarker(eGmap, wizardCenter);
    }

    google.maps.event.addListener(eGmap['map'], 'click', function(e) {
        if(eGmap['boundResultMarker'] === 'undefined') {
            eGmapWizardSetmarker(eGmap, e.latLng);
        }
    });
}


function eGmapWizardSetmarker(eGmap, latLng){
    eGmap['map'].setCenter(latLng);

    eGmap['boundResultMarker'] = new google.maps.Marker({
        map: eGmap['map'],
        position: latLng,
        draggable: true
    });

    eGmapWizardSetAdress(eGmap);

    google.maps.event.addListener(eGmap['boundResultMarker'], 'dragend', function() {
        eGmapWizardSetAdress(eGmap);
    });
}

function eGmapWizardSetAdress(eGmap){
    if(eGmap['boundResultMarker']){
        eGmap['geocoder'].geocode( { 'latLng': eGmap['boundResultMarker'].getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK && results[0]) {
                $('#eGmapAdress__' + eGmap['settings'].map.mapUniqId).val(results[0].formatted_address);
            }
        });
    }
}

function eGmapSearchSave(eGmap){
    if(eGmap['boundResultMarker']){
        latLng = eGmap['boundResultMarker'].getPosition();

        window.opener.$("input[name$='" + eGmap['params'].latName + "']").val(latLng.lat());
        window.opener.$("input[name$='" + eGmap['params'].latName + "_hr']").val(latLng.lat());
        window.opener.$("input[data-formengine-input-name$='" + eGmap['params'].latName + "']").val(latLng.lat());
        window.opener.$("input[name$='" + eGmap['params'].lngName + "']").val(latLng.lng());
        window.opener.$("input[name$='" + eGmap['params'].lngName + "_hr']").val(latLng.lng());
        window.opener.$("input[data-formengine-input-name$='" + eGmap['params'].lngName + "']").val(latLng.lng());
    }
    window.close();
}

function eGmapModuleCenter(eGmap){
    google.maps.event.addListener(eGmap['map'], 'click', function(e) {
        if(!eGmap['boundResultMarker']){
            newPoiAct(eGmap, e.latLng);
        }
    });
}

function newPoiAct(eGmap, event) {
    eGmap['boundResultMarker'] = new google.maps.Marker({
        map: eGmap['map'],
        position: event,
        draggable: true
    });
    eGmapSetLocalizedPoi(eGmap);
}

function addWindowListenner(eGmap){
    document.getElementById("lat").value = eGmap['boundResultMarker'].getPosition().lat();
    document.getElementById("lng").value = eGmap['boundResultMarker'].getPosition().lng();
    eGmapWizardSetAdress(eGmap);

    var poi_move = false;

    google.maps.event.addListener(infoWindow, "closeclick", function() {
        $('#poiGestionLabel').css('display', 'none');
        $('#createPoi').css('display', 'block');
        google.maps.event.clearListeners(eGmap['map'], 'click');
        if(!poi_move) {
            eGmap['boundResultMarker'].setMap(null);
            eGmap['boundResultMarker'] = null;
        }
    });

    google.maps.event.addListener(eGmap['boundResultMarker'], "dragstart", function() {
        poi_move = true;
        infoWindow.close();
    });

    google.maps.event.addListener(eGmap['boundResultMarker'], "click", function(){
        infoWindow.open(eGmap['map'], eGmap['boundResultMarker']);
    });

    google.maps.event.addListener(eGmap['boundResultMarker'], "dragend", function() {
        document.getElementById("lat").value = eGmap['boundResultMarker'].getPosition().lat();
        document.getElementById("lng").value = eGmap['boundResultMarker'].getPosition().lng();
        eGmapSetLocalizedPoi(eGmap);
        poi_move = false;
    });

    document.getElementById("lat").value = eGmap['boundResultMarker'].getPosition().lat();
    document.getElementById("lng").value = eGmap['boundResultMarker'].getPosition().lng();
}

function newPoi(eGmap, lat, lng, address, city, country, code, pageId){
    $.ajax({
        url: TYPO3.settings.ajaxUrls['new_poi'],
        type: 'POST',
        dataType: "json",
        data: {
            lat:lat,
            lng:lng,
            address:address,
            city:city,
            code:code,
            country:country,
            pageId:pageId
        },
        success: function(data){
            var formHtml = "<div style=\"text-align:center;\">";
            formHtml += "<form id=\"newPoiForm\" name=\"newPoiForm\" method=\"post\" action=\"#\">";
            formHtml += "<br /><br /><input id=\"submitButton\" type=\"button\" value=\""+data['text']+"\" onclick=\""+data['output']+"\" ><\/form><\/div>";
            infoWindow = new google.maps.InfoWindow({
                content: formHtml
            });
            infoWindow.open(eGmap['map'], eGmap['boundResultMarker']);
            addWindowListenner(eGmap);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function editPoi(uid, table, pageId){
    $.ajax({
        url: TYPO3.settings.ajaxUrls['edit_poi'],
        type: 'POST',
        data: {
            uid:uid,
            table:table,
            pageId:pageId
        },
        success: function(data){
            $('.editButton').attr('onclick', data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function eGmapYAller(eGmap, lat, lng, adresse){
    if(eGmap['directionsService']){
        maDestination = new google.maps.LatLng(lat, lng);

        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {

                if(eGmap['settings'].map.recherche.actif == "1") {
                    eGmapSearchReset(eGmap);
                }

                var type = eGmap['settings'].map.itineraire.type;
                if(eGmap['settings'].map.itineraire.show == "1") {
                    type = $('#eGmapType__' + eGmap['settings'].map.mapUniqId).val();
                }
                type = type ? google.maps.TravelMode[type] : null;

                var maPosition = new google.maps.LatLng(
                    position.coords.latitude,
                    position.coords.longitude
                );

                var request = {
                    origin: maPosition,
                    destination: maDestination,
                    travelMode: type
                };
                eGmap['directionsService'].route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        eGmap['directionsDisplay'].setDirections(response);
                    }
                });
            });
        }
    }

    destField = $('#eGmapAdress2__' + eGmap['settings'].map.mapUniqId);
    if(destField.length){
        destField.val(adresse);
    }
    return false;
}



function eGmapCatInit(eGmap){
    $('.egmap_cat').click(function(){
        console.log("TRY");
        console.log(eGmap);
        eGmapCatCheck(eGmap, this);
    });
    $('.egmapcat_kmls').click(function(){
        eGmapKmlsCheck(eGmap, this);
    });

    if(eGmap['settings'].cat.check != "1") {
        $('.egmap_cat_racine').click();
    }

    eGmapCatCheckAllInit(eGmap);
}

function eGmapCatCheck(eGmap, elem){
    var infos = $(elem).attr('id').split('_');
    var idCat = infos[1];
    elem = infos[2];
    var input = $('#egmapcat_'+idCat+'_input');
    var checked = input.prop('checked');

    if(elem != 'input'){
        input.prop('checked', !checked);
    }else{
        checked = !checked;
    }

    console.log(eGmap['marker']);  

    for(var i=0;i<eGmap['marker'].length;i++){
        var poi = eGmap['marker'][i];
        console.log(poi.cats.indexOf(idCat));  
        console.log(poi);  

        if(poi.cats.indexOf(idCat) >= 0){
            if(checked && eGmapIsNoLastCat(poi)){
                console.log("HIDE");  
                eGmapHidePoi(eGmap, poi);
            }else{
                console.log("SHOW");  
                eGmapShowPoi(eGmap, poi);
            }
        }
    }

    var childs =  $('.egmap_child_'+idCat);
    if(childs.length){
        childs.prev().prop('checked', checked);
        childs.click();
    }
}

function eGmapIsNoLastCat(poi){
    for(var i=0;i<poi.cats.length;i++){
        var idCat = poi.cats[i];
        if($('#egmapcat_'+idCat+'_input').prop('checked')){
            return false;
        }
    }
    return true;
}

function eGmapHidePoi(eGmap, poi){
    poi.setVisible(false);
    if(poi.infowindow){
        poi.infowindow.close();
        poi.infowindow = false;
    }

    if(eGmap['settings'].poi.liste == "1") {
        var table = poi.infopoi.table;
        var uid = poi.infopoi.uid;
        var poiElem = $('#egmap_'+table+'_'+uid);
        poiElem.hide();

        if(eGmap['settings'].map.cluster.actif == "1") {
            eGmap['mc'].removeMarker(poi);
        }
    }
}

function eGmapShowPoi(eGmap, poi){
    poi.setVisible(true);
    if(eGmap['settings'].poi.liste == "1") {
        var table = poi.infopoi.table;
        var uid = poi.infopoi.uid;
        var poiElem = $('#egmap_'+table+'_'+uid);
        poiElem.show();

        if(eGmap['settings'].map.cluster.actif == "1") {
            eGmap['mc'].addMarker(poi);
        }
    }
}

function eGmapKmlsCheck(eGmap, elem){
    var infos = $(elem).attr('id').split('_');
    elem = infos[2];
    var input = $('#egmapcat_kmls_input__' + eGmap['settings'].map.mapUniqId);
    var checked = input.prop('checked');

    if(elem != 'input'){
        input.prop('checked', !checked);
    }else{
        checked = !checked;
    }

    for(var i=0;i<eGmap['layers'].length;i++){
        if(checked){
            eGmap['layers'][i].setMap(null);
        }else{
            eGmap['layers'][i].setMap(eGmap['map']);
        }
    }
}

function eGmapCatCheckAllInit(eGmap){
    var checkAll = eGmap['labels']['check'];
    var uncheckAll = eGmap['labels']['uncheck'];
    $('#eGmapCheckAll__' + eGmap['settings'].map.mapUniqId).click(function(){
        var thisButton = $(this);
        if(thisButton.hasClass('allchecked')){
            $(this).parent().find('input:checkbox').prop('checked',true);
            $(this).parent().find('input:checkbox').click();
            thisButton.val(checkAll).removeClass('allchecked').addClass('allunchecked');
        }else{
            $(this).parent().find('input:checkbox').prop('checked',false);
            $(this).parent().find('input:checkbox').click();
            thisButton.val(uncheckAll).addClass('allchecked').removeClass('allunchecked');
        }
    });
}

function eGmapPoiListeInit(eGmap) {
    google.maps.event.addListener(eGmap['map'], 'bounds_changed', function() {
        var mapBounds = eGmap['map'].getBounds();
        for(var i=0;i<eGmap['marker'].length;i++){
            var poi = eGmap['marker'][i];
            if(mapBounds.contains(poi.getPosition())){
                eGmapShowPoi(eGmap, poi);
            }else{
                eGmapHidePoi(eGmap, poi);
            }
        }
    });
}

function seePoi(eGmap, uid) {
                console.log(eGmap['marker']);

    for(var i=0; i< eGmap['marker'].length; i++){
        if(eGmap['marker'][i]['infopoi']['uid'] == uid){
            var center = new google.maps.LatLng(eGmap['marker'][i].getPosition().lat(), eGmap['marker'][i].getPosition().lng());
            eGmap['map'].setCenter(center);
            eGmap['map'].setZoom(16);
        }
    }
}


function gestPoi(eGmap, uid, indexBulle, type, savePoint, title){
    var initialPosition = eGmap['marker'][indexBulle].getPosition();

    eGmap['marker'][indexBulle].infowindow.close();
    eGmap['marker'][indexBulle].setDraggable(true);
    eGmap['marker'][indexBulle].setAnimation(google.maps.Animation.BOUNCE);
    var poi_move = false;

    google.maps.event.addListener(eGmap['marker'][indexBulle], "dragstart", function() {
        poi_move = true;
    });

    google.maps.event.addListener(eGmap['marker'][indexBulle], "dragend", function() {
        content = '<div><p>'+title+'</p><input type="button" value="' + savePoint + '"/></div>';
        content = $(content);
        content.find('input').click(function() {
            updatePoint(eGmap, uid, indexBulle, type, eGmap["marker"][indexBulle].getPosition().lat(), eGmap["marker"][indexBulle].getPosition().lng());
        });

        if(eGmap['marker'][indexBulle].infowindow !== 'undefined') {
            eGmap['marker'][indexBulle].infowindow.close();
        }

        eGmap['marker'][indexBulle].infowindow = new google.maps.InfoWindow({
            content: content.get(0)
        });
        eGmap['marker'][indexBulle].infowindow.open(eGmap["map"], eGmap["marker"][indexBulle]);

        poi_move = false;
    });

    movePoiListener = google.maps.event.addListener(eGmap, "click", function() {
        if(poi_move == false) {
            undoLatLng(gmarkers[uid], indexBulle, uid);
            google.maps.event.removeListener(movePoiListener);
        }
    });

    google.maps.event.addListener(eGmap['marker'][indexBulle].infowindow, 'closeclick', function(e){
        eGmap['marker'][indexBulle].setPosition(initialPosition);
        eGmap['marker'][indexBulle].setAnimation(null);
        eGmap['marker'][indexBulle].setDraggable(false);
    });

}

function updatePoint(eGmap, uid, key, type, lat, lng) {
    $.ajax({
        url: TYPO3.settings.ajaxUrls['update_poi'],
        type: 'POST',
        data: {
            uid: uid,
            type: type,
            lat: lat,
            lng: lng,
            key: key
        },
        success: function(){
            eGmap['marker'][key].setDraggable(false);
            eGmap['marker'][key].setAnimation(null);
            eGmap['marker'][key].infowindow.close();
            google.maps.event.addListener(eGmap['marker'][key], 'click', function() {
                eGmapLoadInfosPoi(eGmap, this.key, 1, '');
            });
        },
        error: function(error) {
            console.dir(error);
        }
    });
}

function eGmapSetLocalizedPoi(eGmap){
    if(eGmap['boundResultMarker']){
        eGmap['geocoder'].geocode( { 'latLng': eGmap['boundResultMarker'].getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK && results[0]) {
                newPoi(
                    eGmap,
                    eGmap['boundResultMarker'].getPosition().lat(),
                    eGmap['boundResultMarker'].getPosition().lng(),
                    results[0]['address_components']['0']['long_name'],
                    results[0]['address_components']['1']['long_name'],
                    results[0]['address_components']['4']['long_name'],
                    results[0]['address_components']['5']['long_name'],
                    $('#pageId').data('tab')
                );
            }
        });
    }
}