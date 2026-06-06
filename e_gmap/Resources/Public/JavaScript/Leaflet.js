function eGmapLoadMap(eGmap) {
    if($('#eGmapMap__' + eGmap['settings'].map.mapUniqId).length === 0) {
        return;
    }

    if(typeof eGmap['settings'].map.zoom.min === 'undefined') {
        eGmap['settings'].map.zoom.min = '0';
    }

    if(typeof eGmap['settings'].map.zoom.max === 'undefined') {
        eGmap['settings'].map.zoom.max = '0';
    }

    eGmap['map'] = L.map('eGmapMap__' + eGmap['settings'].map.mapUniqId, {
        minZoom: parseInt(eGmap['settings'].map.zoom.min),
        maxZoom: (eGmap['settings'].map.zoom.max != "0") ? parseInt(eGmap['settings'].map.zoom.max) : 18,
        scrollWheelZoom: (eGmap['settings'].map.zoom.molette != "0"),
        draggable:  (eGmap['settings'].map.draggable != "0")
    }).setView([parseFloat(eGmap['settings'].map.center.lat), parseFloat(eGmap['settings'].map.center.lng)], parseInt(eGmap['settings'].map.zoom.value));

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(eGmap['map']);

    if(eGmap['settings'].map.recherche.actif == "1" || eGmap['settings'].map.itineraire.actif == "1") {
        eGmap['geocoder'] = new L.Control.Geocoder.Nominatim();
    }

    if(eGmap['settings'].map.recherche.actif == "1") {
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
        eGmapItineraire(eGmap);
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
        eGmap['mc'] = L.markerClusterGroup();
        eGmap['marker'].forEach(function(element) {
            eGmap['mc'].addLayer(element);
        });
        eGmap['map'].addLayer(eGmap['mc']);

        /*if(eGmap['settings'].map.cluster.styles != "") {
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
        }*/
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
    eGmap['layers'][key] = omnivore.kml(kml.data).addTo(eGmap['map']);
}

function eGmapLoadPois(eGmap, backend){
    if(eGmap['pois'] && eGmap['pois'].poi){
        eGmap['bounds'] = new L.LatLngBounds();

        if(eGmap['pois'].poi.length>0){
            for(i=0;i<eGmap['pois'].poi.length;i++){
                eGmapLoadPoi(eGmap, eGmap['pois'].poi[i], backend);
            }
            if(eGmap['settings'].map.center.type == 'auto' && eGmap['bounds']){
                if(eGmap['settings'].map.zoom.value>0){
                    eGmap['map'].flyTo(eGmap['bounds'].getCenter());
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
                eGmap['map'].panTo(eGmap['marker'][0].getLatLng());
            } else {
                if(eGmapLoadInfosPoi(eGmap, 0, backend, '')){
                    eGmap['map'].panTo(eGmap['marker'][0].getLatLng());
                }
            }
        }
    }
}

function eGmapLoadPoi(eGmap, poi, backend){
    key = eGmap['marker'].length;

	if((typeof poi.lat !='string' && typeof poi.lat != 'number') || (typeof poi.lng != 'string' && typeof poi.lng != 'number')) {
        return;
    }

    if(parseFloat(poi.lat) == NaN || parseFloat(poi.lng) == NaN) {
        return;
    }

    position = [poi.lat, poi.lng];
    eGmap['marker'][key] = new L.Marker(position, {title: poi.title});
    eGmap['marker'][key].key = key;
    eGmap['marker'][key].infopoi = poi;
    if(poi.cats){
        eGmap['marker'][key].cats = poi.cats.split(",");
    }else{
        eGmap['marker'][key].cats = [];
    }

    eGmap['uidToKey'][poi.table + "_" + poi.uid] = key;

    if(poi.picto && poi.picto != ""){
        eGmap['marker'][key].setIcon(new L.Icon({iconUrl: "/" + poi.picto}));
    }

    eGmap['marker'][key].addTo(eGmap['map']);

    eGmap['marker'][key].on('click', function() {
        eGmapLoadInfosPoi(eGmap, this.key, backend, poi.table);
    });

    eGmap['bounds'].extend(L.latLng(poi.lat, poi.lng));
}

function eGmapLoadInfosPoi(eGmap, key, backend, table){
    if(!eGmap['marker'][key])
        return false;

    if(eGmap['marker'][key].popup){
        eGmap['map'].closePopup(eGmap['marker'][key].popup);
        eGmap['marker'][key].popup = false;
    }else{
        eGmap['marker'][key].popup = new L.Popup({}).setLatLng(eGmap['marker'][key].getLatLng());
        eGmap['marker'][key].popup.setContent(eGmap['settings'].map.loadingInfo);
        eGmap['marker'][key].popup.key = key;
        eGmap['marker'][key].popup.on('popupclose', function(){
            eGmap['marker'][this.key].popup = false;
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
                    key =  $(result).find("key").text();
                    tabs = $(result).find("tab");
                    if(tabs.length > 0){
                        $(result).find("tab").each(function(){
                            label =  $(this).find("label").text();
                            content =  $(this).find("content").text();
                            eGmap['marker'][key].popup.addTab(label, content);
                        });
                    } else {
                        content = $(result).find("content").text();
                        eGmap['marker'][key].popup.setContent(content);
                    }
                    eGmap['marker'][key].popup.openOn(eGmap['map']);

                    window.setTimeout(function() {
                        eGmap['map'].flyTo(eGmap['marker'][key].getLatLng());

                        $('.eGmapYAllerLink').click(function (e) {
                            e.preventDefault();
                            eGmapYAller(eGmap, $(this).attr('data-pos-latitude'), $(this).attr('data-pos-longitude'), $(this).attr('data-pos-address'))
                        });
                    }, 1000);
                },
                error: function(error) {
                    console.dir(error);
                    eGmap['map'].closePopup(eGmap['marker'][key].popup);
                    eGmap['marker'][key].popup = false;
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
                    content = '<div class="popup_content">'+content+'</div>';

                    content = $(content);
                    content.find('.moveButton').click(function() {
                        gestPoi(eGmap, uid, key, type, savePoint, title);
                    });

                    eGmap['marker'][key].popup.setContent(content.get(0));
                    window.setTimeout(function() {
                        editPoi(uid, table, $('#pageId').data('tab'));
                    }, 100);

                    eGmap['marker'][key].popup.openOn(eGmap['map']);
                },
                error: function(error) {
                    console.dir(error);
                    eGmap['map'].closePopup(eGmap['marker'][key].popup);
                    eGmap['marker'][key].popup = false;
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
    eGmap['geocoder'].geocode(address, function(results) {
        eGmap['boundResult'] = results[0].bbox;
        eGmap['map'].fitBounds(eGmap['boundResult']);

        if(eGmap['boundResultMarker']){
            eGmap['boundResultMarker'].setLatLng(results[0].center);
        }else {
            if (eGmap['settings'].view == "wizard") {
                eGmap['boundResultMarker'] = L.marker(results[0].center, {draggable: true}).addTo(eGmap['map']);
            } else if (eGmap['settings'].view == "module") {
                eGmap['boundResultMarker'] = L.marker(results[0].center, {draggable: false}).addTo(eGmap['map']);
                var position = eGmap['boundResultMarker'].getLatLng();
                eGmap['boundResultMarker'].removeFrom(eGmap['map']);
                eGmap['boundResultMarker'] = null;
                newPoiAct(eGmap, position);
                $('#lat').val(eGmap['boundResultMarker'].getLatLng().lat);
                $('#lng').val(eGmap['boundResultMarker'].getLatLng().lng);
                eGmapModuleCenter(eGmap);
                $("#createPoi").css('display', 'none');
                $("#createPoi").click(function () {
                    eGmapModuleCenter(eGmap);
                    $("#createPoi").css('display', 'none');
                    $("#poiGestionLabel").css('display', 'block');
                });
                $("#poiGestionLabel").css('display', 'block');
            } else {

                eGmap['boundResultMarker'] = L.marker(results[0].center).addTo(eGmap['map']);
            }
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
    eGmap['directionsService'] = new L.Routing.OSRMv1({language: 'fr'});
    eGmap['routeDisplay'] = null;
    eGmap['waypointDisplay'] = new L.Routing.Plan().addTo(eGmap['map']);

    $('#eGmapItineraire__' + eGmap['settings'].map.mapUniqId).submit(function(e){
        e.preventDefault();

        address1 = $('#eGmapAdress1__' + eGmap['settings'].map.mapUniqId).val();
        address2 = $('#eGmapAdress2__' + eGmap['settings'].map.mapUniqId).val();
        type = $('#eGmapType__' + eGmap['settings'].map.mapUniqId).val().toLowerCase();

        eGmap['geocoder'].geocode(address1, function(results) {
            startPosition = new L.Routing.Waypoint();
            startPosition.latLng = results[0].center;
            startPosition.name = address1;

            eGmap['geocoder'].geocode(address2, function(results) {
                endPosition = new L.Routing.Waypoint();
                endPosition.latLng = results[0].center;
                endPosition.name = address2;

                eGmap['directionsService'].route([startPosition, endPosition], function(errors, results) {
                    if(typeof(results) !== 'undefined' && typeof(results[0]) !== 'undefined') {
                        eGmap['waypointDisplay'].setWaypoints(results[0].waypoints);
                        if(eGmap['routeDisplay'] !== null) {
                            eGmap['map'].removeLayer(eGmap['routeDisplay']);
                        }
                        eGmap['routeDisplay'] = new L.Routing.Line(results[0]).addTo(eGmap['map']);
                        eGmap['map'].flyToBounds(eGmap['routeDisplay'].getBounds());

                        //Build instruction list
                        itinerairePanel = $('#eGmapItinerairePanel__' + eGmap['settings'].map.mapUniqId);

                        if(itinerairePanel.length > 0) {
                            li = $('<ul/>');
                            results[0].instructions.forEach(function(element) {
                                $('<li/>').text(element.text).appendTo(li);
                            });

                            itinerairePanel.find('ul').remove();
                            li.appendTo(itinerairePanel);
                        }
                    }
                });
            });
        });
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
        wizardCenter = new L.LatLng(lat , lng);
        eGmapWizardSetmarker(eGmap, wizardCenter);
    }

    eGmap['map'].on('click', function(e) {
        if(eGmap['boundResultMarker'] === 'undefined') {
            eGmapWizardSetmarker(eGmap, e.latLng);
        }
    });
}


function eGmapWizardSetmarker(eGmap, latLng){
    eGmap['map'].setView(latLng, 15);
    eGmap['boundResultMarker'] = L.marker(latLng, {draggable: true}).addTo(eGmap['map']);

    eGmapWizardSetAdress(eGmap);

    eGmap['boundResultMarker'].on('dragend', function() {
        eGmapWizardSetAdress(eGmap);
    });
}

function eGmapWizardSetAdress(eGmap){
    if(eGmap['boundResultMarker']){
        eGmap['geocoder'].reverse(eGmap['boundResultMarker'].getLatLng(), 1.0, function(results) {
            if(typeof(results[0]) !== undefined) {
                $('#eGmapAdress__' + eGmap['settings'].map.mapUniqId).val(results[0].name);
            }
        });
    }
}

function eGmapSearchSave(eGmap){
    if(eGmap['boundResultMarker']){
        latLng = eGmap['boundResultMarker'].getLatLng();

        window.opener.$("input[name$='" + eGmap['params'].latName + "']").val(latLng.lat);
        window.opener.$("input[name$='" + eGmap['params'].latName + "_hr']").val(latLng.lat);
        window.opener.$("input[data-formengine-input-name$='" + eGmap['params'].latName + "']").val(latLng.lat);
        window.opener.$("input[name$='" + eGmap['params'].lngName + "']").val(latLng.lng);
        window.opener.$("input[name$='" + eGmap['params'].lngName + "_hr']").val(latLng.lng);
        window.opener.$("input[data-formengine-input-name$='" + eGmap['params'].lngName + "']").val(latLng.lng);
    }
    window.close();
}

function eGmapModuleCenter(eGmap){
    eGmap['map'].on('click', function(e) {
        if(!eGmap['boundResultMarker']){
            newPoiAct(eGmap, e.latlng);
        }
    });
}

function newPoiAct(eGmap, event) {
    eGmap['boundResultMarker'] = new L.Marker([event.lat, event.lng], {draggable: true}).addTo(eGmap['map']);

    eGmapSetLocalizedPoi(eGmap);
}

function addWindowListenner(eGmap, infoWindow){
    document.getElementById("lat").value = eGmap['boundResultMarker'].getLatLng().lat;
    document.getElementById("lng").value = eGmap['boundResultMarker'].getLatLng().lng;
    eGmapWizardSetAdress(eGmap);

    var poi_move = false;

    infoWindow.on('remove', function() {
        $('#poiGestionLabel').css('display', 'none');
        $('#createPoi').css('display', 'block');
        eGmap['map'].off('click');
        if(!poi_move) {
            eGmap['boundResultMarker'].removeFrom(eGmap['map']);
            eGmap['boundResultMarker'] = null;
        }
    });

    eGmap['boundResultMarker'].on('dragstart', function() {
        poi_move = true;
        eGmap['map'].closePopup(infoWindow);
    });

    eGmap['boundResultMarker'].on("click", function(){
        infoWindow.openOn(eGmap['map']);
    });

    eGmap['boundResultMarker'].on("dragend", function() {
        document.getElementById("lat").value = eGmap['boundResultMarker'].getLatLng().lat;
        document.getElementById("lng").value = eGmap['boundResultMarker'].getLatLng().lng;
        eGmapSetLocalizedPoi(eGmap);
        poi_move = false;
    });

    document.getElementById("lat").value = eGmap['boundResultMarker'].getLatLng().lat;
    document.getElementById("lng").value = eGmap['boundResultMarker'].getLatLng().lng;
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
            infoWindow = new L.Popup({}).setLatLng(eGmap['boundResultMarker'].getLatLng());

            var formHtml = "<div style=\"text-align:center;\">";
            formHtml += "<form id=\"newPoiForm\" name=\"newPoiForm\" method=\"post\" action=\"#\">";
            formHtml += "<br /><br /><input id=\"submitButton\" type=\"button\" value=\""+data['text']+"\" onclick=\""+data['output']+"\" ><\/form><\/div>";
            infoWindow.setContent(formHtml);

            infoWindow.openOn(eGmap['map']);
            addWindowListenner(eGmap, infoWindow);
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
        endPosition = new L.Routing.Waypoint();
        endPosition.latLng = new L.LatLng(lat, lng);
        endPosition.name = adresse;

        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                if(eGmap['settings'].map.recherche.actif == "1") {
                    eGmapSearchReset(eGmap);
                }

                var type = eGmap['settings'].map.itineraire.type.toLowerCase();
                if(eGmap['settings'].map.itineraire.show == "1") {
                    type = $('#eGmapType__' + eGmap['settings'].map.mapUniqId).val().toLowerCase();
                }

                startPosition = new L.Routing.Waypoint();
                startPosition.latLng = new L.LatLng(position.coords.latitude, position.coords.longitude);

                eGmap['directionsService'].route([startPosition, endPosition], function(errors, results) {
                    if(typeof(results) !== 'undefined' && typeof(results[0]) !== 'undefined') {
                        eGmap['waypointDisplay'].setWaypoints(results[0].waypoints);
                        if(eGmap['routeDisplay'] !== null) {
                            eGmap['map'].removeLayer(eGmap['routeDisplay']);
                        }
                        eGmap['routeDisplay'] = new L.Routing.Line(results[0]).addTo(eGmap['map']);
                        eGmap['map'].flyToBounds(eGmap['routeDisplay'].getBounds());

                        //Build instruction list
                        itinerairePanel = $('#eGmapItinerairePanel__' + eGmap['settings'].map.mapUniqId);

                        if(itinerairePanel.length > 0) {
                            li = $('<ul/>');
                            results[0].instructions.forEach(function(element) {
                                $('<li/>').text(element.text).appendTo(li);
                            });

                            itinerairePanel.find('ul').remove();
                            li.appendTo(itinerairePanel);
                        }
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

    for(var i=0;i<eGmap['marker'].length;i++){
        var poi = eGmap['marker'][i];
        if(poi.cats.indexOf(idCat) >= 0){
            if(checked && eGmapIsNoLastCat(poi)){
                eGmapHidePoi(eGmap, poi);
            }else{
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
    poi.removeFrom(eGmap['map']);
    if(poi.popup){
        eGmap['map'].closePopup(poi.popup);
        poi.popup = false;
    }

    if(eGmap['settings'].poi.liste == "1") {
        var table = poi.infopoi.table;
        var uid = poi.infopoi.uid;
        var poiElem = $('#egmap_'+table+'_'+uid);
        poiElem.hide();

        if(eGmap['settings'].map.cluster.actif == "1") {
            eGmap['mc'].removeLayer(poi);
        }
    }
}

function eGmapShowPoi(eGmap, poi){
    poi.addTo(eGmap['map']);
    if(eGmap['settings'].poi.liste == "1") {
        var table = poi.infopoi.table;
        var uid = poi.infopoi.uid;
        var poiElem = $('#egmap_'+table+'_'+uid);
        poiElem.show();

        if(eGmap['settings'].map.cluster.actif == "1") {
            eGmap['mc'].addLayer(poi);
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
    eGmap['map'].on('move ', function() {
        var mapBounds = eGmap['map'].getBounds();
        for(var i=0;i<eGmap['marker'].length;i++){
            var poi = eGmap['marker'][i];
            if(mapBounds.contains(poi.getLatLng())){
                eGmapShowPoi(eGmap, poi);
            }else{
                eGmapHidePoi(eGmap, poi);
            }
        }
    });
}

function seePoi(eGmap, uid) {
    for(var i=0; i<eGmap['marker'].length; i++){
        if(eGmap['marker'][i]['infopoi']['uid'] == uid){
            var center = new L.LatLng(eGmap['marker'][i].getLatLng().lat, eGmap['marker'][i].getLatLng().lng);
            eGmap['map'].setView(center, 16);
        }
    }
}


function gestPoi(eGmap, uid, indexBulle, type, savePoint, title){
    var initialPosition = eGmap['marker'][indexBulle].getLatLng();

    eGmap['map'].closePopup(eGmap['marker'][indexBulle].popup);

    eGmap['marker'][indexBulle].dragging.enable();
    eGmap['marker'][indexBulle].setOpacity(0.5);
    var poi_move = false;

    eGmap['marker'][indexBulle].on('dragstart', function() {
        poi_move = true;
    });

    eGmap['marker'][indexBulle].on('dragend', function() {
        content = '<div><p>'+title+'</p><input type="button" value="' + savePoint + '"/></div>';
        content = $(content);
        content.find('input').click(function() {
            updatePoint(eGmap, uid, indexBulle, type, eGmap["marker"][indexBulle].getLatLng().lat, eGmap["marker"][indexBulle].getLatLng().lng);
        });

        eGmap['marker'][indexBulle].popup.setContent(content.get(0))
            .setLatLng(eGmap['marker'][indexBulle].getLatLng())
            .openOn(eGmap['map']);

        poi_move = false;
    });

    eGmap['marker'][indexBulle].popup.on('remove', function() {
        eGmap['marker'][indexBulle].setLatLng(initialPosition);
        eGmap['marker'][indexBulle].setOpacity(1.0);
        eGmap['marker'][indexBulle].dragging.disable();
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
            eGmap['marker'][key].popup.off('remove');
            eGmap['marker'][key].dragging.disable();
            eGmap['marker'][key].setOpacity(1.0);
            eGmap['map'].closePopup(eGmap['marker'][key].popup);

            eGmap['marker'][key].on('click', function() {
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
        eGmap['geocoder'].reverse(eGmap['boundResultMarker'].getLatLng(), 1.0, function(results) {
            if(typeof(results[0]) !== undefined) {
                adressComponents = results[0].name.split(', ');

                newPoi(
                    eGmap,
                    eGmap['boundResultMarker'].getLatLng().lat,
                    eGmap['boundResultMarker'].getLatLng().lng,
                    adressComponents[0] + ' ' + adressComponents[1],
                    adressComponents[adressComponents.length - 6],
                    adressComponents[adressComponents.length - 1],
                    adressComponents[adressComponents.length - 2],
                    $('#pageId').data('tab')
                );
            }
        });
    }
}