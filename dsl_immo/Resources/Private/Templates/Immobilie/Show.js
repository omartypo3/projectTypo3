// JavaScript Document



$(window).on('load', function(){ 
	
	
	initPropertyDetailSingleMaps();
	
	
	
	
	
//console.log('show.js onload');
	
	
});




function initPropertyDetailSingleMaps(){
   if(!geocoder){
     
	   geocoder = new google.maps.Geocoder();
   }
  
  
  if($('.property-detail-single-map').length){
    
    $('.property-detail-single-map').each(function (key, value) { 
    
   
      if(!$(value).data('lng') || !$(value).data('lat')){
       
        geocoder.geocode( { 'address': $(value).data('address')}, propertyDetailSingleMapsGeocodeCallback($(value)) );
      } else initPropertyDetailSingleMap($(value).attr('id'));
    });
  }
	
	
  
}
/*

if($('.property-search-home-map-immobilien').length){
    
    $('.property-detail-single-map').each(function (key, value) { 	
	} 
	
*/


function propertyDetailSingleMapsGeocodeCallback(value){
  
  return function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
  	
      //value
      //value.data('lng',results[0].geometry.location.lng())
	  $('#'+value.attr('id')).data('lat',results[0].geometry.location.lat());
      $('#'+value.attr('id')).data('lng',results[0].geometry.location.lng());
		
		
	  
      initPropertyDetailSingleMap(value.attr('id'));
    } else {
      console.log("Geocode was not successful for the following reason: " + status);
    }
  }
}
function initPropertyDetailSingleMap(selector) {
	
	
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
            zoom: 15,
            center: mapCenter,
            disableDefaultUI: false,
            scrollwheel: false,
            styles: mapStyles
        };
        var mapElement = document.getElementById(selector);
        var map = new google.maps.Map(mapElement, mapOptions);

	//var pictureLabel = document.createElement("img");
      //  pictureLabel.src = 'fileadmin/zoner/assets/img/property-types/apartment.png';
		//kartendetail aus wohnungsansicht raus
		var pictureLabel = '<img src="fileadmin/zoner/assets/img/property-types/apartment.png" style="max-width:100%;">';
		
        var markerPosition = new google.maps.LatLng(property.data('lat'),property.data('lng'));
		
        var marker = new MarkerWithLabel({
            position: markerPosition,
            map: map,
            icon: 'fileadmin/zoner/assets/img/marker.png',
            labelContent: pictureLabel,
            labelAnchor: new google.maps.Point(50, 0),
            labelClass: "marker-style"
        });
 
}
