$(document).ready(function(){

	var mapContainer = $('.parterOuter .partnerMapContainer'),
	    iconWagner = 'fileadmin/template/img/pin_service.png',
	    iconWagnerHeadquarter = 'fileadmin/template/img/pin_dealer.png',
	    clusterImageSmall = 'fileadmin/template/img/pin_clustert.png',
	    clusterImageMid = 'fileadmin/template/img/pin_cluster_mid.png',
	    clusterImageBig = 'fileadmin/template/img/pin_cluster_long.png',
	    markerAll = [],
	    markerCluster,
		markerToCluster = [],
	    infowindow = new google.maps.InfoWindow({
            maxWidth: 370,
            pixelOffset: new google.maps.Size(-12, 0)

        }),
	    partnerItems = $('.partnerItems'),
	    initialLocation = new google.maps.LatLng(41.1289, -98.2883),
		locations,
		actualPosition,
		zip = $("#zip"),
		requestLat = 41.1289,
		requestLon = -98.2883,
		requestRadius = $("#radius"),
		spinerOptions = {
			lines: 13, // The number of lines to draw
			length: 40, // The length of each line
			width: 10, // The line thickness
			radius: 30, // The radius of the inner circle
			corners: 1, // Corner roundness (0..1)
			rotate: 0, // The rotation offset
			direction: 1, // 1: clockwise, -1: counterclockwise
			color: '#000', // #rgb or #rrggbb or array of colors
			speed: 1, // Rounds per second
			trail: 60, // Afterglow percentage
			shadow: false, // Whether to render a shadow
			hwaccel: false, // Whether to use hardware acceleration
			className: 'spinner', // The CSS class to assign to the spinner
			zIndex: 2e9, // The z-index (defaults to 2000000000)
			top: 'auto', // Top position relative to parent in px
			left: 'auto' // Left position relative to parent in px
		},
		spinerTarget = document.getElementById('map-spin-target'),
		spinner;

    if(mapContainer.length){

	    setSwitchState();

        var myOptions = {
            zoom:5,
            center: initialLocation,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            scaleControl: false
        };


	    if(geoPosition.init()) {
			geoPosition.getCurrentPosition(geoSuccess,geoError,{enableHighAccuracy:true});
	    } else {
			geoError();
	    }

	    var map = new google.maps.Map(mapContainer[0], myOptions);


    }

	$(document).on("submit", "#zip-search-form", function(e){
		e.preventDefault();
		callManually();
	})

	function geoError(){
		spinner.stop();
		alert("Your Device is not supported!");
	}

	function geoSuccess(position){

		spinner = new Spinner(spinerOptions).spin(spinerTarget);
		requestLat = position.coords.latitude;
		requestLon = position.coords.longitude;
		actualPosition = new google.maps.LatLng(requestLat,requestLon);
		requestLocations();
		resolveZip();
	}

	function callManually(){
		spinner = new Spinner(spinerOptions).spin(spinerTarget);
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({address: zip.val()}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				requestLat = results[0].geometry.location.lat();
				requestLon = results[0].geometry.location.lng();
				actualPosition = new google.maps.LatLng(requestLat,requestLon);
				clearAll();
				requestLocations();
			} else {
				spinner.stop();
				alert(address + ' not found');
			}
		});
	}

	function requestLocations(){

		var url = window.location,
			urllastChar = url.toString().substr(-1),
			paramMarker = '&';
		if (urllastChar == '/') {
			paramMarker = '?';
		}

		var url = url + paramMarker + "type=89657165"+ "&tx_wservice_ajax[lat]=" + requestLat + "&tx_wservice_ajax[lon]=" + requestLon + "&tx_wservice_ajax[radius]=" + requestRadius.val();

		$.ajax({
			dataType: "json",
			url: url,
			success: function(data){
				locations = data.locations;

				if(locations.length){
					$.each(locations, function(){
						var $this = this;
						addToList($this);
						addMarkers($this);
					});
				} else {
					partnerItems.append(
						"<div style='padding: 5px;'>" +
							"<h2>There are no results.</h2>" +
							"<p>Please change your search parameter.</p>" +
						"</div>"
					)
				}

				clusterMarkers();

				map.setCenter(actualPosition);
				map.setZoom(8);
				spinner.stop();

				checkSwitchState();
			},
			error: function(){
				spinner.stop();
				alert("Error! Please reload the Page!");
			}
		});
	}

    function addMarkers(pos) {
        var position = new google.maps.LatLng(pos.lat,pos.lng);

        var icon = iconWagner;

        // is sevice headquarter?
        if (pos.category == "3") {
        	icon = iconWagnerHeadquarter;
        }

	    var marker = new google.maps.Marker({
		    position: position,
		    map: map,
		    icon:icon
	    });

	    marker.setValues({catId: pos.category});
        markerAll[pos.uid] = marker;
	    markerToCluster.push(marker);

        google.maps.event.addListener(markerAll[pos.uid], "click", function(){
	        var $thisElem = $("#item-" + pos.uid);
	        addInfowindow($thisElem);
        });
    }

	function clusterMarkers(){
			var clusterOffset = [2.01, 24.5],
			clusterStyles = [{
				url: clusterImageSmall,
				height: 54,
				width: 84,
				anchor: clusterOffset,
				textColor: '#ffffff',
				textSize: 10
			}, {
				url: clusterImageMid,
				height: 54,
				width: 84,
				anchor: [2.4, 25.5],
				textColor: '#ffffff',
				textSize: 10
			}, {
				url: clusterImageBig,
				height: 54,
				width: 84,
				anchor: [2.5, 24],
				textColor: '#ffffff',
				textSize: 10
			}],
			mcOptions = {
				gridSize: 50,
				maxZoom: 10,
				styles:clusterStyles,
				ignoreHidden: true
			};
		markerCluster = new MarkerClusterer(map, markerToCluster, mcOptions);
	}

	function addToList(item) {
		var string = '<div id="item-'+ item.uid +'" class="partnerItem catid-' + item.category + ((item.boost == 1) ? ' boost' : '') + '" data-titantool-map-category="' + item.category + '">' +
						'<p class="partnerCompany">' + item.company + '</p>' +
						'<p class="partnerAddress">' + item.street + '<br/>' + item.city + ', &nbsp;' + item.country + ', &nbsp;' + item.zip + '<br/>' + item.additional + '</p>' +
                        '<p class="partnerPhone">' + item.phone + '</p>' +
						'<p class="partnerDistance">' + Math.round(item.distance) + ' mi.</p>' +
						'<div class="infoWindow">' +
							'<p class="partnerFax">' + item.fax + '</p>' +
							'<p class="partnerEmail">' + item.email + '</p>' +
							'<p class="partnerSite">' + item.website + '</p>' +
						'</div>' +
					'</div>',
		object = $('<div/>').html(string).contents();
		partnerItems.append(object);
		addClickHandler(object);
	};

    function addClickHandler(item){
        item.click(function(){
	        addInfowindow(item);
        });
    }

	function addInfowindow(item){
		var marker = markerAll[parseInt(item.attr("id").replace(/\D/g,''))];
		partnerItems.find('.active').removeClass('active');
		item.addClass('active');
		partnerItems.animate({
			scrollTop: item.offset().top + partnerItems.scrollTop() - 440
		}, 800);
		infowindow.close();
		infowindow.setContent(item.html());
		map.setCenter(marker.getPosition())
		map.setZoom(14);
		infowindow.open(map,marker);
	}

	function clearAll() {

		partnerItems.empty();

		$.each(markerToCluster, function() {
			markerCluster.removeMarker(this);
			this.setMap(null);
		});

		markerAll = [];
		markerToCluster = [];
	}

	function resolveZip() {
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({ 'latLng': actualPosition, 'region': 'North America' }, function (results) {
			zip.val(extractFromAdress(results[0].address_components, "postal_code"))
		});
	}

	function extractFromAdress(components, type){
		for (var i=0; i<components.length; i++)
			for (var j=0; j<components[i].types.length; j++)
				if (components[i].types[j]==type) return components[i].long_name;
		return "";
	}

	$("a#partnerList").click(function() {
        var partnerItems = $("div.partnerItems");
		if (partnerItems.is(":hidden")) {
			$(this).addClass("active");
            partnerItems.slideDown(500);
	    } else {
	    	$(this).removeClass("active");
            partnerItems.slideUp(500);
	    }
    });

	var categorySwitches = $("[name='category-switch']");
	categorySwitches.click(function(){
		checkSwitchState();
	});

	function setSwitchState(){
		var mode = getURLParameter('mode');
		if(mode == 'service'){$("#category-switch-3").trigger("click");}
		if(mode == 'dealer'){$("#category-switch-2").trigger("click");}
	};

    function checkSwitchState(){
		categorySwitches.each(function(){
			var $this = $(this),
				checked = $this.is(':checked'),
				category = $this.val();

			if(checked){
				$("[data-titantool-map-category='"+category+"']").show();
			} else {
				$("[data-titantool-map-category='"+category+"']").hide();
			}
			toggleMarker(category, checked);

		});

        // Boost entries (5 max) => DEACTIVATED (5/7/2014 - Bjoern Gottowik)
        //jQuery(".partnerItems div.boost:visible").slice(0,5).prependTo('.partnerItems');

		markerCluster.repaint();
    }

	function toggleMarker(catId, visible){
		$.each(markerToCluster, function() {
			if(this.get("catId") == catId){
				if(this.getVisible() && !visible){
					markerCluster.removeMarker(this);
				}
				if(!this.getVisible() && visible){
					markerCluster.addMarker(this);
				}
				this.setVisible(visible);
			}
		});
	}

	function getURLParameter(sParam) {
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++) {
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) {
				return sParameterName[1];
			}
		}
	}

});