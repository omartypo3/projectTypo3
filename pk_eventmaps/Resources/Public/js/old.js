
$(document).ready(function () {
    /*
     ***************
     * VARIABLES
     ***************
     */
    var windowWith = $(window).width(),
        startZoom = 6,
        streets = [],
        ListHtml = "",
        html = "",
        isLocated = false,
        goMapDefaultConfiguration = {
            zoom: startZoom,
            panControl: true,
            mapTypeControl: false,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE
            },
            scaleControl: true,
            streetViewControl: false,
            overviewMapControl: false,
            maptype: 'ROADMAP',
            hideByClick: true,
            oneInfoWindow: true
        };

    var initFilterMarker = function() {
        var jets = new Jets({
            searchTag: '#gmapSearch',
            contentTag: '#retailerAddressesContent',
            manualContentHandling: function(tag) {
                var city, zip, street;
                var cityRaw = $(tag).find('.retailerCity');

                if (cityRaw.length > 0) {
                    cityRaw = cityRaw[0].textContent;
                    city = cityRaw.substring(cityRaw.indexOf(' ') + 1);
                    zip = cityRaw.substring(0, cityRaw.indexOf(' '));
                    street = $(tag).find('.retailerStreet')[0].textContent;
                }

                var ret = city && city + ' ' + zip + ' ' + street || '';

                return ret;
            }
        });
    };

    /**
     * GET JSON DATA
     */
    function getMarker(url) {
        var data = {};

        if (product.length > 0)
        {
            $.extend(data, {product: product});
        }

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            data: data,
            success: function(retailers_jsn) {
                setMarker(retailers_jsn);
                // brauchen wir vielleicht später noch mal
                // initFilterMarker();
            }
        });
    }

    /**
     * set Marker on Map and List
     */
    function setMarker(data){
        $.goMap.showHideMarkerByGroup('marker', false);
        var ListHtml='';
        if(data.length > 0) {
            for (var i = 0, l = data.length; i < l; i++) {
                var markers = data[i];
                //Set Marker ICON

                if (markers.ambassador == true) {
                    markerMapIcon = gmapImgLink + "pin-red_sm.png";
                    markerListIcon = '<img src="' + gmapImgLink + 'pin-red.png" alt="Marker" />';
                }
                else {
                    markerMapIcon = gmapImgLink + "pin-gray_sm.png";
                    markerListIcon = '<img src="' + gmapImgLink + 'pin-gray.png" alt="Marker" />';
                }

                var markerHtml = buildListHTML(markers);

                //Create Marker on Map
                $.goMap.createMarker({
                    latitude: markers.latitude,
                    longitude: markers.longitude,
                    id: "markerId" + markers.id,
                    group: 'marker',
                    icon: markerMapIcon,
                    visible: true,
                    html: {
                        content: markerHtml
                    }
                });

                //Set Marker in List
                ListHtml += markerHtml;

                streets.push({ value: markers.address1});


            }//END FOR

            $.goMap.fitBounds('visible');
            $($.goMap.markers).each(function(i,marker){
                $.goMap.createListener({type:'marker', marker:marker}, 'click', function() {
                    var actZoom = $.goMap.map.getZoom(),
                        position = $($.goMap.mapId).data(marker).position;
                    if(actZoom < startZoom+5){
                        $.goMap.setMap({zoom: startZoom+5 });
                    }

                    $.goMap.map.panTo(position);
                    if( $('#retailerAddressesContent').find('#'+marker).hasClass('active') ){
                        $('#retailerAddressesContent').find('#'+marker).removeClass('active');
                    }else{
                        $('.makerList').removeClass('active');
                        $('#retailerAddressesContent').find('#'+marker).addClass('active');
                        $('#retailerAddressesContainer').getNiceScroll().doScrollPos(0, $('#'+marker).position().top);
                    }
                });
            });
        }else{
            ListHtml = buildListErrorHTML();
        }
        $('#retailerAddressesContent').html(ListHtml);
        $("#retailerAddressesContainer").getNiceScroll().resize()
    }

    /**
     * buildListHTML(markers)
     * Build the HTML Block for infowindow
     *
     * @param  {Array} markers
     * @returns {String} html
     */
    function buildListHTML(markers){
        html = "";
        html += '<address class="makerList" id="markerId'+ markers.id +'">';
        html += '    <div class="markerClose"><i class="fa fa-times"></i> </div>';
        html += '    <div class="markerImage">';
        html +=         markerListIcon;
        if(markers.distance  != undefined && markers.distance  != null) {
            html += '<span class="distance">' + htmlKmDistance.replace("%s", Number((markers.distance).toFixed(1))) + "</span>";
        }
        html += '    </div>';
        html += '    <div class="addressInformations">';
        html += '            <span class="retailerName">'+ markers.name +'</span>';
        if (markers.ambassador == true) {
            html += '            <span class="retailerTyp">' + htmlAmbassador + '</span>';
        }else{
            if (markers.classification == 3) {
                html += '       <span class="whiteIcon"></span><span class="whiteIcon"></span><span class="whiteIcon"></span>';
            }
            if (markers.classification == 2) {
                html += '       <span class="whiteIcon"></span><span class="whiteIcon"></span><span class="grayIcon"></span>';
            }
            if (markers.classification == 1) {
                html += '       <span class="whiteIcon"></span><span class="grayIcon"></span><span class="grayIcon"></span>';
            }
        }
        html += '            <span class="retailerStreet">'+ markers.address1 + '</span>';
        html += '            <span class="retailerCity">'+ markers.zip + ' '+ markers.city +'</span>';
        if(markers.telefone  != undefined && markers.telefone  != null){
            html += '            <span class="retailerContactFon"> ' + $_txtTel + ' '+ markers.telefone + '</span>';
        }
        if(markers.telefax != undefined && markers.telefax  != null){
            html += '            <span class="retailerContactFax"> ' + $_txtFax + ' '+ markers.telefax + '</span>';
        }
        if(markers.email != undefined && markers.email  != null){
            html += '            <a href="mailto:' + markers.email + '" class="retailerContactMail"> ' + $_txtEmail + '</a>';
        }
        if(markers.web != undefined && markers.web  != null){
            html += '            <a href="http://'+markers.web+'" title="'+ markers.name +'" target="_blank" rel="nofollow">'+ markers.web +'</a>';
        }

        //console.log(markers);

        html += '    </div>';
        html += '<div class="rout"><a target="_blank" href="' + gmapUrl + '?saddr&daddr='+markers.address1.trim().split(' ').join('+')+'+'+ markers.zip.trim()+'+'+markers.city.trim()+'" >' + htmlRouteCalc + ' <i class="fa fa-chevron-right"></i> </a></div>';
        html += '</address>';
        html += '<div class="clearfix"></div>';

        return html
    }

    /**
     * buildListErrorHTML()
     * Build the Error HTML Block for List, if no Marker found
     *
     * @returns {String} html
     */
    function buildListErrorHTML(){

        html = '';
        html += '<div class="errorAdress">';
        html += '   <h3>'+$_txtNoDealer+'</h3>';
        html += "<p>" + htmlNoDealers.replace("%s", $('#gmapSearchArea').val()) + "</p>";
        html += '   <p class="searchNew"> <a href="#">';
        if($('#gmapSearchArea').val() < 20){
            html += '   <span id="sArea20" class="col-md-6"><i class="fa fa-chevron-circle-right"></i> 20km</span>';
        }
        if($('#gmapSearchArea').val() < 50){
            html += '   <span id="sArea50" class="col-md-6"><i class="fa fa-chevron-circle-right"></i> 50km</span>';
        }
        if($('#gmapSearchArea').val() < 100){
            html += '   <span id="sArea100" class="col-md-6"><i class="fa fa-chevron-circle-right"></i> 100km</span>';
        }
        if($('#gmapSearchArea').val() < 150){
            html += '   <span id="sArea150" class="col-md-6"><i class="fa fa-chevron-circle-right"></i> 150km</span>';
        }
        html += '   <span id="sArea200" class="col-md-6"><i class="fa fa-chevron-circle-right"></i> 200km</span>';

        html += '   </a></p>';
        html += '</div>';
        html += '<div class="clearfix"></div>';

        return html
    }

    /**
     *
     * @param rad
     */
    function search(rad){
        if(rad != $('#gmapSearchArea').val() && rad != 0){
            $('#gmapSearchArea').val(rad);
        }
        var address = $("#gmapSearch").val();
        if(address.length <= 1){
            setReset = true;
        }else{
            setReset = false;
        }

        $.ajax({
            url:"//maps.googleapis.com/maps/api/geocode/json?address=" + encodeURIComponent(address + ' ' + startCountry),
            type: "POST",
            success: function(res) {

                // Prevent old marker info on map
                //$.goMap.clearMarkers();

                $.each($.goMap.markers , function(index, value) {
                    if($(value).length) {
                        $.goMap.removeMarker(value);
                    }
                });

                if(res.results[0] != undefined && setReset == false){
                    if(rad == 0){
                        rad = $('#gmapSearchArea').val();
                    };
                    getMarker(retailerSearchUrl+'?centerLat='+res.results[0].geometry.location.lat+'&centerLng='+res.results[0].geometry.location.lng+'&radius='+rad);
                    $.goMap.setMap({latitude:res.results[0].geometry.location.lat, longitude: res.results[0].geometry.location.lng});
                }else if(setReset == true){
                    getMarker(retailerSearchUrl);
                    $('#gmapSearchArea').val(10);
                }else{
                    ListHtml = buildListErrorHTML();
                    $('#retailerAddressesContent').html(ListHtml);
                    $("#retailerAddressesContainer").getNiceScroll().resize();
                }

                if( windowWith < 1024 ){
                    $('html, body').animate({
                        scrollTop: $('#mobileSwitch').offset().top
                    }, 1000);
                }
            }
        });
    }

    /**
     *
     * @returns {*|jQuery}
     * @constructor
     */
    $.fn.ToggleInputValue = function(){
        return $(this).each(function(){
            var Input = $(this);
            var default_value = Input.val();

            Input.focus(function() {
                if(Input.val() == default_value) Input.val("");
            }).blur(function(){
                if(Input.val().length == 0) Input.val(default_value);
            });
        });
    };

    /**
     ***************
     * EVENTS
     ***************
     */
    $(".makerList").live('click',function(){
        var actZoom = $.goMap.map.getZoom(),
            marker = $(this).attr('id'),
            position = $($.goMap.mapId).data(marker).position;

        if(actZoom < startZoom+5){
            $.goMap.setMap({zoom: startZoom+5 });
        }
        $.goMap.map.panTo(position);
        google.maps.event.trigger($($.goMap.mapId).data(marker), 'click');
    });

    //
    $('.searchNew a span').live('click', function(){
        search( $(this).attr('id').replace('sArea','') );
        return false;
    });

    //INPUT  & SEARCH
    $('.focusme').ToggleInputValue();

    //Umkreissuche
    $("#search_map").click(function() {
        if($("#gmapSearch").val() == "")
            alert($_txtEnterAddress);
        else {
            search(0);
        };
        return false;
    });

    $('.accordionHeadline').click(function() {
        $('.accordionHeadline').removeClass('on');
        $('.accordionContent').slideUp('normal');
        $('.accordionHeadline i').attr('class','fa fa-chevron-down right');
        if($(this).next().is(':hidden') == true) {
            $(this).addClass('on');
            $(this).next().slideDown('normal');
            $('.accordionHeadline i').attr('class','fa fa-chevron-up right');
        }
    });

    /**
     * OLD SCRIPT FROM SW – Mobile Switch function
     */

    $("#mobileSwitchMap, #mobileSwitchAddresses").bind("click", function () {
        $(this).addClass("activeTab").siblings("span").removeClass("activeTab")
    });
    $("#mobileSwitchAddresses").bind("click", function () {
        $("#retailerBoxSlideLine").animate({left: "0"}, 500)
    });
    $("#mobileSwitchMap").bind("click", function () {
        $("#retailerBoxSlideLine").animate({left: "-" + $("#retailerAddressesAndMap").width()})
    });
    $("#retailerAddressesContainer").niceScroll("#retailerAddressesScrollableContent", {
        boxzoom: false,
        background: "#4d116e",
        autohidemode: false,
        scrollspeed: 30,
        mousescrollstep: 10,
        bouncescroll: false,
        dblclickzoom: false,
        gesturezoom: false
    });
    $(window).on("resize", function () {
        $("#retailerBoxSlideLine").removeAttr("style");
        $("#mobileSwitchMap").addClass("activeTab");
        $("#mobileSwitchAddresses").removeClass("activeTab");
        $(this).getNiceScroll().resize()
    });

    /**
     **********************
     * GoMap Initialization
     **********************
     */

    function initGoMap(pos){

        $("#map_canvas").goMap( goMapDefaultConfiguration );

        if(pos){
            getMarker(retailerSearchUrl + '?centerLat=' + pos.lat + '&centerLng=' + pos.lng + '&radius=' + 20);
        } else {
            getMarker(retailerSearchUrl);
        }
        isLocated = true;
    }

    function initDefaultMap() {
        // add to config
        goMapDefaultConfiguration.address = startCountry;
        initGoMap(false);
    }

    function initLocaleMap(pos) {
        // add to config
        goMapDefaultConfiguration.latitude =  pos.lat;
        goMapDefaultConfiguration.longitude =  pos.lng;
        goMapDefaultConfiguration.zoom =  startZoom+6;
        initGoMap(pos);
    }

    /**
     ***************
     * START SCRIPT
     ***************
     */

    if(gmapLocationActive) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                initLocaleMap({
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                });
            }, function () {
                // User or Browser doesn't accept Geolocation
            });
        }
    }

    if(!isLocated) {
        initDefaultMap();
    }

    //clear Input
    $('.clearInput').click(function(){
        $('#gmapSearch').val('').focus();
        search(0);
    });

});