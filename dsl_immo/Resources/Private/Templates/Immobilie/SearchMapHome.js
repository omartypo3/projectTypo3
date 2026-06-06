// JavaScript Document
{namespace v=FluidTYPO3\Vhs\ViewHelpers}
//alert('test');




var ajaxUrl = '<v:variable.get name="ajaxUrl" />';
var geocoderSearchHomeMap;
var geocoderSearchHomeMapMarkers = [];
var searchHomeMap;
var changeTimeout;
var initComplete;

var markerClusterTimeout;

function requestPreview(){

	if(changeTimeout) clearTimeout(changeTimeout);

	var formData = new FormData();
	$('#requestPreview').val(1);
	params  = $('#form-map-sale').serializeArray();
	$('#requestPreview').val('');
	$.each(params, function(i, val) {
		formData.append(val.name, val.value);
	});

	$('#search-map-submit-button').addClass('ajaxLoading');
	$('#search-map-submit-button').html($('#search-map-submit-button').data('value'));
	
	
	$.ajax({
		url: $('#form-map-sale').attr('action'),
		type: 'POST',
		data: params,/*$('#auftraegeCreateForm').serialize(),*/
		cache: false,
		success: function(data) {
			

			
			$('#search-map-submit-button').removeClass('ajaxLoading');
			
			var resultCont = $(data).find(".property-search-home-map-immobilien");
			
			$(".property-search-home-map-immobilien").html(resultCont.html());
			
			var wertFromNeu = resultCont.data('preis-from');
			var wertToNeu = resultCont.data('preis-to');
			if(wertFromNeu && wertToNeu){
				if(wertFromNeu+';'+wertToNeu!=$("#price-input-home").attr('data-from')+';'+$("#price-input-home").attr('data-to')){
					reInitPriceSliderHome(wertFromNeu,wertToNeu);
				}
			}
			
			var wertFromNeu = resultCont.data('flaeche-from');
			var wertToNeu = resultCont.data('flaeche-to');
			if(wertFromNeu && wertToNeu){
				if(wertFromNeu+';'+wertToNeu!=$("#flaeche-input-home").attr('data-from')+';'+$("#flaeche-input-home").attr('data-to')){
					reInitFlaecheSliderHome(wertFromNeu,wertToNeu);
				}
			}

			
			$(".property-search-home-map-immobilien").attr('data-preis-from',resultCont.data('preis-from')).attr('data-preis-to',resultCont.data('preis-to')).attr('data-flaeche-from',resultCont.data('flaeche-from')).attr('data-flaeche-to',resultCont.data('flaeche-to')).attr('data-max-results-for-sliders',resultCont.data('max-results-for-sliders'));
			
			
			
			
			initPropertySearchHomeMapsImmobilien();
			
			
		//	console.log(data);
		}
	});
		
}


var initComplete = false;

//console.log(ajaxUrl);


function reInitFlaecheSliderHome(from,to){
	initComplete=false;
	$("#flaeche-input-home").attr('data-from',from);
	$("#flaeche-input-home").attr('data-to',to);
	$("#flaeche-input-home").attr('value',from+';'+to);
	$("#flaecheFromTo").attr('value',from+';'+to);
	//console.log('setvalueFlaeche:'+from+';'+to);
	
	$("#flaeche-input-home").next('.jslider').remove();
	
	$("#flaeche-input-home").parent().html($("#flaeche-input-home").parent().html());
	//$("#flaeche-input-home").val(from+';'+to);
	initFlaecheSliderHome();
	
	
	
	/*
setTimeout(function(){
  $("#flaeche-input-home").slider("value", from, to);
}, 2500);*/
	initComplete=true;
	
}

function reInitPriceSliderHome(from,to){
	
	console.log('reInitPriceSliderHome('+from+','+to+')');
	
	initComplete=false;
	$("#price-input-home").attr('data-from',from);
	$("#price-input-home").attr('data-to',to);
	$("#price-input-home").attr('value',from+';'+to);	
	$("#preisFromTo").attr('value',from+';'+to);
	$("#price-input-home").next('.jslider').remove();

	
	
	$("#price-input-home").parent().html($("#price-input-home").parent().html());
//	$("#price-input-home").val(from+';'+to);
	
	initPriceSliderHome();
	console.log('set price from to: '+from+', '+to);
	
/*setTimeout(function(){
  $("#price-input-home").slider("value", from, to);
}, 2500);*/
	initComplete=true;
	
}
function initPriceSliderHome(){
	
	//console.log('--- function initPriceSliderHome');
	
	var $priceSliderHome = $("#price-input-home");
//	console.log('priceslider-from:'+$priceSliderHome.data('from'));
//	console.log('priceslider-to:'+$priceSliderHome.data('to'));
	if($priceSliderHome.attr('value')==";") $priceSliderHome.attr('value',$priceSliderHome.data('from')+';'+$priceSliderHome.data('to'));
	
	
	
    if($priceSliderHome.length > 0) {
		//alert('gr');
//		console.log('initPriceSliderHome.length >0');
        $priceSliderHome.slider({
            from: $priceSliderHome.data('from'),
            to: $priceSliderHome.data('to'),
            step: 1,
            round: 1,
            format: { format: '###,### €', locale: 'de' },
			onstatechange: function(event, ui) {
				//alert('onstatechange');
				// use ui.value to get a number
				// do your functions
//				console.log('initPriceSliderHome:onstatechange');
				if(initComplete) startChangeTimeout();
			}
			
        });
	
    }

}

function initFlaecheSliderHome(){
	
	
	
	var $flaecheSliderHome = $("#flaeche-input-home");
	//console.log('flaecheslider-from:'+$flaecheSliderHome.data('from'));
	//console.log('flaecheslider-to:'+$flaecheSliderHome.data('to'));
	if($flaecheSliderHome.attr('value')==";") $flaecheSliderHome.attr('value',$flaecheSliderHome.data('from')+';'+$flaecheSliderHome.data('to'));
    if($flaecheSliderHome.length > 0) {
		//alert('gr');
        $flaecheSliderHome.slider({
            from: $flaecheSliderHome.data('from'),
            to: $flaecheSliderHome.data('to'),
            step: 1,
            round: 1,
            format: { format: '###,### m²', locale: 'de' },
			onstatechange: function(event, ui) {
				//alert('onstatechange');
				// use ui.value to get a number
				// do your functions
				console.log('initFlächeSliderHome:onstatechange');
				if(initComplete) startChangeTimeout();
			}
			
        });
	
    }
	
	  
	
}

$(window).on('load', function(){ 
	initPropertySearchHomeMap();
	
	initPriceSliderHome();
	initFlaecheSliderHome()
	
	initComplete = true;
	
	$( '.previewOnChange' ).change(function() {
  		startChangeTimeout();
	});
	 $('select.previewOnChange').each(function( index ) {
	   if($(this).val()) $(this).next().addClass('selected-option-check');
	 });

});

function initPropertySearchHomeMap(){
  if(!geocoderSearchHomeMap) geocoderSearchHomeMap = new google.maps.Geocoder();
 
  if($('.property-search-home-map').length){
    $('.property-search-home-map').each(function( index ) {

		initPropertySearchHomeMaps($(this).attr('id'));
		initPropertySearchHomeMapsImmobilien();
    });
  }
  
}


var markerCluster;
var geocoderSearchHomeMapMarkers = [];
var geocoderSearchHomeMapActiveMarkers = [];
var clusterStyles = [
                {
                    url: 'fileadmin/zonerChild/assets/img/cluster.png',
                    height: 37,
                    width: 37
                }
            ];

function refreshMarkerCluster(){

	if(markerClusterTimeout) clearTimeout(markerClusterTimeout);
		if(markerCluster) markerCluster.setMap(null);
		clearMarkersSearchHomeMaps();
		geocoderSearchHomeMapActiveMarkers = [];

		Object.keys(geocoderSearchHomeMapMarkers).forEach(function (key) {
			if($('#'+key).length){
			  geocoderSearchHomeMapActiveMarkers.push(geocoderSearchHomeMapMarkers[key]);
			}
		});
		markerCluster = new MarkerClusterer(searchHomeMap, geocoderSearchHomeMapActiveMarkers, {styles: clusterStyles, maxZoom: 15});

}

function initPropertySearchHomeMaps(selector) {

   	var property = $('#'+selector);
	
	var subtractPosition = 0;
	var mapWrapper = $(selector+'.float');
	if (document.documentElement.clientWidth > 1200) {
		subtractPosition = 0.013;
	}
	if (document.documentElement.clientWidth < 1199) {
		subtractPosition = 0.006;
	}
	if (document.documentElement.clientWidth < 979) {
		subtractPosition = 0.001;
	}
	if (document.documentElement.clientWidth < 767) {
		subtractPosition = 0;
	}
	
	var mapCenter = new google.maps.LatLng(property.data('lat'),property.data('lng'));
	if ( $(selector).hasClass("float") ) {
		mapCenter = new google.maps.LatLng(property.data('lat'),property.data('lng') - subtractPosition);
		mapWrapper.css('width', mapWrapper.width() + mapWrapper.offset().left )
	}
	
	var mapOptions = {
		zoom: 14,
		center: mapCenter,
		disableDefaultUI: false,
		scrollwheel: false,
		styles: mapStyles
	};
	
	var mapElement = document.getElementById(selector);
	
	searchHomeMap = new google.maps.Map(mapElement, mapOptions);
	searchHomeMap.addListener('zoom_changed', function() {
		
		
		refreshMarkerCluster();
	});

	var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/hermes.svg" style="max-width:100%;">';/**/
	
	var pIcon = new google.maps.MarkerImage('fileadmin/zonerChild/assets/img/marker.png',null,null,null,new google.maps.Size(40, 49));
	
	var markerPosition = new google.maps.LatLng(property.data('lat'),property.data('lng'));

	var marker = new MarkerWithLabel({
		position: markerPosition,
		map: searchHomeMap,
		icon: pIcon,
		
		labelContent: pictureLabel,
		labelAnchor: new google.maps.Point(50, 0),
		labelClass: "marker-style"
	});

 
}

//var newMarkers = [];


function initPropertySearchHomeMapsImmobilien(){

	clearMarkersSearchHomeMaps();
	$('#search-map-submit-button').html($('#search-map-submit-button').data('value'));
	
	

	if($('.property-search-home-map-immobilien>div').length){
		

		
		$("#flaeche-input-home,#price-input-home").next('.jslider').removeClass('pointerEventsDisabled');
		//hier
		
    	$('#search-map-submit-button').removeAttr('disabled','disabled');
		
		
		
		$('#search-map-submit-button').html($('#search-map-submit-button').data('value')+' ('+$('.property-search-home-map-immobilien>div').length+')');
		
		$('.property-search-home-map-immobilien>div').each(function( index ) {
		 

			if(!$(this).data('lng') || !$(this).data('lat')){

				geocoderSearchHomeMap.geocode( { 'address': $(this).data('address')}, initPropertySearchHomeMapsImmobilienGeocodeCallback($(this).attr('id')) );
			} else {
				initPropertySearchHomeMapsImmobilienSetPin($(this).attr('id'));
			}
			
		});
		
		
	
	} else {
		//hier
		if($('.property-search-home-map-immobilien').attr('data-max-results-for-sliders')=='0') {
			console.log('deaktivieren!!');
			$("#flaeche-input-home,#price-input-home").next('.jslider').addClass('pointerEventsDisabled');
		}

		
		
		//$("#price-input-home").next('.jslider').addClass('pointerEventsDisabled');
		$('#search-map-submit-button').attr('disabled','disabled');
	}
}

function initPropertySearchHomeMapsImmobilienSetPin(id){
	//console.log('initPropertySearchHomeMapsImmobilienSetPin('+id+')');
	
	if(!geocoderSearchHomeMapMarkers[id]){
	
		var property = $('#'+id);

		if(property.data('search-objekt-typ') == 's1040'){
			var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/gewerbe-buero.svg" style="max-width:100%;">';
		} else if(property.data('search-objekt-typ') == 's1050'){
			var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/garage.svg" style="max-width:100%;">';
		} else if(property.data('search-objekt-typ') == 's1010'){
			var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/wohnung.svg" style="max-width:100%;">';
		} else if(property.data('search-objekt-typ') == 's1020'){
			var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/haus.svg" style="max-width:100%;">';
		} else if(property.data('search-objekt-typ') == 's1030'){
			var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/grundstueck.svg" style="max-width:100%;">';
		} else if(property.data('search-objekt-typ') == 's1060'){
			var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/wertanlage.svg" style="max-width:100%;">';
		} else {
			var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/wohnung.svg" style="max-width:100%;">';
		}
		

		var markerPosition = new google.maps.LatLng(property.data('lat'),property.data('lng'));


		var pIcon = new google.maps.MarkerImage('fileadmin/zonerChild/assets/img/marker.png',null,null,null,new google.maps.Size(40, 49));

		
		
		var marker = new MarkerWithLabel({
			position: markerPosition,
			map: null,//searchHomeMap,
			/*icon: 'fileadmin/zonerChild/assets/img/marker.png',*/
			icon: pIcon,
			labelContent: pictureLabel,
			labelAnchor: new google.maps.Point(50, 0),
			labelClass: "marker-style",
			id:id
		});
		marker.addListener('click', function() {

			location.href=$('#'+marker.id).data('uri-detail');

        });
		
		

		
		//geocoderSearchHomeMapMarkers.push(marker);
		geocoderSearchHomeMapMarkers[id]=marker;
	} else {
		if(!geocoderSearchHomeMapMarkers[id].getMap()){
//geocoderSearchHomeMapMarkers[id].setMap(searchHomeMap); // kann evtl weg
			
		}
	}
	
	refreshMarkerCluster()	
	
	//markerCluster = new MarkerClusterer(searchHomeMap, geocoderSearchHomeMapActiveMarkers, {styles: clusterStyles, maxZoom: 15});
	
}
function initPropertySearchHomeMapsImmobilienGeocodeCallback(id){
	//console.log('initPropertySearchHomeMapsImmobilienGeocodeCallback('+id+')');
	
	return function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {


		  $('#'+id).data('lat',results[0].geometry.location.lat());
		  $('#'+id).data('lng',results[0].geometry.location.lng());



		  initPropertySearchHomeMapsImmobilienSetPin(id);
		} else {
	//	  console.log("Geocode was not successful for the following reason: " + status);
		}
	  }
	
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkersSearchHomeMaps() {
	Object.keys(geocoderSearchHomeMapMarkers).forEach(function (key) {
		if(!$('#'+key).length)	geocoderSearchHomeMapMarkers[key].setMap(null);
	});
}



function startChangeTimeout(){
	if(changeTimeout) clearTimeout(changeTimeout);
	changeTimeout = setTimeout(function(){ requestPreview(); }, 500);
}

