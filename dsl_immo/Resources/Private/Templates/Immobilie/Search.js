// JavaScript Document
{namespace v=FluidTYPO3\Vhs\ViewHelpers}
//alert('test');




var ajaxUrl = '<v:variable.get name="ajaxUrl" />';
var geocoderSearchHomeMap;
var geocoderSearchHomeMapMarkers = [];
var searchHomeMap;
var changeTimeout;
var initComplete;

function requestPreview(){
//	console.log('requestPreview()');
	if(changeTimeout) clearTimeout(changeTimeout);
//	console.log('function requestPreview');
	
	var formData = new FormData();
	$('#requestPreview').val(1);
	params  = $('#form-sidebar').serializeArray();
	$('#requestPreview').val('');
	$.each(params, function(i, val) {
		formData.append(val.name, val.value);
	});
	//formData.append('flaeche-from', $('flaeche-input-home').attr('data-from'));
	//formData.append('flaeche-to', $('flaeche-input-home').attr('data-to'));
	//formData.append('tx_dslimmosearch[test]', 'asdasd!!!!!!!!!!!!!!!');
	console.log('preview!!!');
//	console.log($('#form-map-sale').attr('action')+"&type=89658001");			
	
	$('#search-submit-button').addClass('ajaxLoading');
	$('#search-submit-button').html($('#search-submit-button').data('value'));
	
	
	$.ajax({
		url: $('#form-sidebar').attr('action'),
		type: 'POST',
		data: params,/*$('#auftraegeCreateForm').serialize(),*/
		cache: false,
		success: function(data) {
			
			//$("#anzahlFahrzeuge").text($(data).find("#fahrzeugeAnzahl").text());
			//console.log('anzahl:'+$(data).find(".property-search-home-map-immobilien>div").length);
			
			//alert($(".property-search-home-map-immobilien").data('preis-from'));
			
			$('#search-submit-button').removeClass('ajaxLoading');
			
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
			
			
			console.log('preis-from:'+resultCont.data('preis-from'));
			console.log('preis-to:'+resultCont.data('preis-to'));
			console.log('flaeche-from:'+resultCont.data('flaeche-from'));
			console.log('flaeche-to:'+resultCont.data('flaeche-to'));
			
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
	console.log('setvalueFlaeche:'+from+';'+to);
	
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
	
	console.log('--- function initPriceSliderHome');
	
	var $priceSliderHome = $("#price-input-home");
	console.log('priceslider-from:'+$priceSliderHome.data('from'));
	console.log('priceslider-to:'+$priceSliderHome.data('to'));
	if($priceSliderHome.attr('value')==";") $priceSliderHome.attr('value',$priceSliderHome.data('from')+';'+$priceSliderHome.data('to'));
	
	
	
    if($priceSliderHome.length > 0) {
		//alert('gr');
		console.log('initPriceSliderHome.length >0');
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
				console.log('initPriceSliderHome:onstatechange');
				if(initComplete) startChangeTimeout();
			}
			
        });
	
    }
	/*
	if($priceSliderHome.data('from') == $priceSliderHome.data('to')) {
		console.log('aaah preis ist gleich !!'+$priceSliderHome.data('from')+' == '+$priceSliderHome.data('to'));
		//$priceSliderHome.next('.jslider').addClass('pointerEventsDisabled'); 
		$priceSliderHome.next('.jslider').find('.jslider-bg .v').css('left','0%').css('width','100%');
		$priceSliderHome.next('.jslider').find('.jslider-pointer:not(.jslider-pointer-to)').css('left','0%');
		$priceSliderHome.next('.jslider').find('.jslider-pointer.jslider-pointer-to').css('left','100%');
		$priceSliderHome.next('.jslider').find('.jslider-value:not(.jslider-value-to)').css('left','0%').css('margin-left','0px').css('right','auto').css('visibility','visible');
		$priceSliderHome.next('.jslider').find('.jslider-value.jslider-value-to').css('left','auto').css('margin-left','0px').css('right','0px').css('visibility','visible');

	} //else $priceSliderHome.next('.jslider').removeClass('pointerEventsDisabled');*/
	
}

function initFlaecheSliderHome(){
	
	
	
	var $flaecheSliderHome = $("#flaeche-input-home");
	console.log('flaecheslider-from:'+$flaecheSliderHome.data('from'));
	console.log('flaecheslider-to:'+$flaecheSliderHome.data('to'));
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
	/*	$("#flaeche-input-home").on("change", function() {
			//wahrscheinlich nicht genutzt
		   alert($(this).val()); 
		});*/
		/*$priceSliderHome.on("slidestop", function(event, ui) {
			endPos = ui.value;

			if (startPos != endPos) {
				alert("foostuff"); 
			}

			startPos = endPos;
		});*/
    }
	
	/*
	if($flaecheSliderHome.data('from') == $flaecheSliderHome.data('to')) {
		$flaecheSliderHome.next('.jslider').addClass('pointerEventsDisabled'); 
		$flaecheSliderHome.next('.jslider').find('.jslider-bg .v').css('left','0%').css('width','100%');
		$flaecheSliderHome.next('.jslider').find('.jslider-pointer:not(.jslider-pointer-to)').css('left','0%');
		$flaecheSliderHome.next('.jslider').find('.jslider-pointer.jslider-pointer-to').css('left','100%');
		$flaecheSliderHome.next('.jslider').find('.jslider-value:not(.jslider-value-to)').css('left','0%').css('margin-left','0px').css('right','auto').css('visibility','visible');
		$flaecheSliderHome.next('.jslider').find('.jslider-value.jslider-value-to').css('left','auto').css('margin-left','0px').css('right','0px').css('visibility','visible');

	} else $flaecheSliderHome.next('.jslider').removeClass('pointerEventsDisabled');*/
	  
	
}

$(window).on('load', function(){ 
	initPropertySearchHomeMap();
	
	initPriceSliderHome();
	initFlaecheSliderHome()
	
	initComplete = true;
	//console.log('initComplete');
	
	/*bootstrapSelect.on('shown.bs.dropdown', function () {
		alert('blaaa');
        //dropDownMenu.removeClass('animation-fade-out');
        //dropDownMenu.addClass('animation-fade-in');
    });*/
	//$( 'select[name="tx_dslimmo_immosearch[gebiet]"],select[name="tx_dslimmo_immosearch[objektTyp]"],select[name="tx_dslimmo_immosearch[mieteKaufen]"]' )  class="previewOnChange"
	$( '.previewOnChange' ).change(function() {
  		startChangeTimeout();
//	  alert($('select[name="tx_dslimmo_immosearch[gebiet]"]').val());
	});
	 $('select.previewOnChange').each(function( index ) {
	   if($(this).val()) $(this).next().addClass('selected-option-check');
	 });
	//$( 'select[name="tx_dslimmo_immosearch[mieteKaufen]"]' ).next().addClass('selected-option-check');
	
	
	
	checkExtendedFilterStayActive();
	$('.more-filter-group .more-filter-open a,.more-filter-group .more-filter-close a').click(function() {
	  checkExtendedFilterStayActive();
	  console.log( "Handler for .click() called." );
	  $(this).closest('.more-filter-group').toggleClass('more-filter-active');
	  return false;
	});
	

});

function initPropertySearchHomeMap(){
  if(!geocoderSearchHomeMap) geocoderSearchHomeMap = new google.maps.Geocoder();
 
  if($('.property-search-home-map').length){
    $('.property-search-home-map').each(function( index ) {

   /*
      if(!$(value).data('lng') || !$(value).data('lat')){
       
        geocoderSearchHomeMap.geocode( { 'address': $(value).data('address')}, propertyDetailSingleMapsGeocodeCallback($(value)) );
      } else initPropertyDetailSingleMap(value.attr('id'));*/

		initPropertySearchHomeMaps($(this).attr('id'));
		initPropertySearchHomeMapsImmobilien();
    });
  }
  
}


function initPropertySearchHomeMaps(selector) {
  	//console.log('initPropertySearchHomeMaps('+selector+')');
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

	var pictureLabel = '<img src="fileadmin/zonerChild/assets/img/property-types/hermes.svg" style="max-width:100%;">';/**/
	
	var pIcon = new google.maps.MarkerImage('fileadmin/zonerChild/assets/img/marker.png',null,null,null,new google.maps.Size(40, 49));
	//pictureLabel='';
	
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


function initPropertySearchHomeMapsImmobilien(){
	clearMarkersSearchHomeMaps();
	$('#search-submit-button').html($('#search-submit-button').data('value'));
	
	
	
	if($('.property-search-home-map-immobilien>div').length){
		
		$("#flaeche-input-home,#price-input-home").next('.jslider').removeClass('pointerEventsDisabled');
		//hier
		
    	$('#search-submit-button').removeAttr('disabled','disabled');
		
		
		
		$('#search-submit-button').html($('#search-submit-button').data('value')+' ('+$('.property-search-home-map-immobilien>div').length+')');
		
		$('.property-search-home-map-immobilien>div').each(function( index ) {
		 
/*
			if(!$(this).data('lng') || !$(this).data('lat')){

				geocoderSearchHomeMap.geocode( { 'address': $(this).data('address')}, initPropertySearchHomeMapsImmobilienGeocodeCallback($(this).attr('id')) );
			} else {
				initPropertySearchHomeMapsImmobilienSetPin($(this).attr('id'));
				//initPropertyDetailSingleMap(value.attr('id'));
			}
			
		*/
			
		});
	} else {
		//hier
		if($('.property-search-home-map-immobilien').attr('data-max-results-for-sliders')=='0') {
			console.log('deaktivieren!!');
			$("#flaeche-input-home,#price-input-home").next('.jslider').addClass('pointerEventsDisabled');
		}
	//	if( ($('.property-search-home-map-immobilien').attr('data-flaeche-to')-$('.property-search-home-map-immobilien').attr('data-flaeche-from'))+($('.property-search-home-map-immobilien').attr('data-preis-to')-$('.property-search-home-map-immobilien').attr('data-preis-from'))==2) $("#flaeche-input-home,#price-input-home").next('.jslider').addClass('pointerEventsDisabled');
		
		
		//$("#price-input-home").next('.jslider').addClass('pointerEventsDisabled');
		$('#search-submit-button').attr('disabled','disabled');
	}
}

function initPropertySearchHomeMapsImmobilienSetPin(id){
	//console.log('initPropertySearchHomeMapsImmobilienSetPin('+id+')');
	
	if(!geocoderSearchHomeMapMarkers[id]){
	
		var property = $('#'+id);

//console.log('nutzungsart:'+property.data('nutzungs-art'));
//console.log('objekttyp:'+property.data('objekt-typ'));
		
		
		
		
		
		
		
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
		/*
			nutzungs_art.10 Wohnen
			nutzungs_art.20 Gewerbe
			nutzungs_art.30 Anlage
			nutzungs_art.40 WAZ
				*/
		
		//var pictureLabel = document.createElement("img");
		//pictureLabel.src = 'fileadmin/zoner/assets/img/property-types/apartment.png';

		

		//immobilienpins auf startseite
		//console.log(pictureLabel);

		var markerPosition = new google.maps.LatLng(property.data('lat'),property.data('lng'));


		var pIcon = new google.maps.MarkerImage('fileadmin/zonerChild/assets/img/marker.png',null,null,null,new google.maps.Size(40, 49));

		var marker = new MarkerWithLabel({
			position: markerPosition,
			map: searchHomeMap,
			/*icon: 'fileadmin/zonerChild/assets/img/marker.png',*/
			icon: pIcon,
			labelContent: pictureLabel,
			labelAnchor: new google.maps.Point(50, 0),
			labelClass: "marker-style",
			id:id
		});
		marker.addListener('click', function() {
			//console.log(marker.id);
			//console.log($('#'+marker.id).data('uri-detail'));
			location.href=$('#'+marker.id).data('uri-detail');
          //searchHomeMap.setZoom(18);
          //searchHomeMap.setCenter(marker.getPosition());
        });
		//geocoderSearchHomeMapMarkers.push(marker);
		geocoderSearchHomeMapMarkers[id]=marker;
	} else {
		if(!geocoderSearchHomeMapMarkers[id].getMap()){
			geocoderSearchHomeMapMarkers[id].setMap(searchHomeMap);
			
		}
	}
	
}
function initPropertySearchHomeMapsImmobilienGeocodeCallback(id){
	//console.log('initPropertySearchHomeMapsImmobilienGeocodeCallback('+id+')');
	
	return function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {

		  //value
		  //value.data('lng',results[0].geometry.location.lng())
		  $('#'+id).data('lat',results[0].geometry.location.lat());
		  $('#'+id).data('lng',results[0].geometry.location.lng());



		  initPropertySearchHomeMapsImmobilienSetPin(id);
		} else {
	//	  console.log("Geocode was not successful for the following reason: " + status);
		}
	  }
	
	//console.log('initPropertySearchHomeMapsImmobilienGeocodeCallback');
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkersSearchHomeMaps() {
	//setMapOnAll(null);
	Object.keys(geocoderSearchHomeMapMarkers).forEach(function (key) {
	   // do something with obj[key]
		if(!$('#'+key).length)	geocoderSearchHomeMapMarkers[key].setMap(null);
	});
	//for (var id in marker){
		//marker.setMap(null);
		/*if (target.hasOwnProperty(k)) {
			 alert("Key is " + k + ", value is" + target[k]);
		}*/
	//}
	
	/*for (var i = 0; i < geocoderSearchHomeMapMarkers.length; i++) {
	  geocoderSearchHomeMapMarkers[i].setMap(null);
	}*/
	//geocoderSearchHomeMapMarkers = [];
	
}



function startChangeTimeout(){
	//console.log('function startChangeTimeout');
	if(changeTimeout) clearTimeout(changeTimeout);
	changeTimeout = setTimeout(function(){ requestPreview(); }, 500);
}


function checkExtendedFilterStayActive(){
  $( '.extended-filter input.previewOnChange' ).each(function( index ) {
   console.log($(this).prop('checked')); 
    if($(this).prop('checked')) $(this).closest('.extended-filter').addClass('extended-filter-stay-active');
    else $(this).closest('.extended-filter').removeClass('extended-filter-stay-active');
  });
}

