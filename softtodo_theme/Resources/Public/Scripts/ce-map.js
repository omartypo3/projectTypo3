var initMapp={s:function(){var e=$("#gmap-element").data("longitude1"),t=$("#gmap-element").data("latitude1"),l=$("#gmap-element").data("longitude"),a=$("#gmap-element").data("latitude"),i=$("#gmap-element").data("text2"),n=$("#gmap-element").data("text1"),o=$("#gmap-element").data("text4"),s=$("#gmap-element").data("text3"),p=$("#gmap-element").data("icon"),r="<div id='content' class='map-infoWindow' style='color: black;'><h5 id='firstHeading' style='color: black;'>"+n+"</h5><div id='bodyContent'><p>"+s+"</p></div></div>",d="<div id='content' class='map-infoWindow' style='color: black;'><h5 id='firstHeading' style='color: black;'>"+i+"</h5><div id='bodyContent'><p>"+o+"</p></div></div>";$("#gmap-element").length&&(map=new GMaps({div:"#gmap-element",lat:41.43,lng:11.67,zoom:4,scrollwheel:!1,zoomControl:!1,mapTypeControl:!1,scaleControl:!1,streetViewControl:!1,rotateControl:!1}),map.addMarker({lat:a,lng:l,title:n,icon:p,infoWindow:{content:r,maxWidth:200}}),map.addMarker({lat:t,lng:e,title:i,icon:p,infoWindow:{content:d,maxWidth:200}}),map.setOptions({styles:[{featureType:"landscape",elementType:"all",stylers:[{color:"#d5d5d5"},{weight:3}]},{featureType:"landscape",elementType:"all",stylers:[{color:"#d5d5d5"},{weight:3}]},{featureType:"landscape",elementType:"geometry.stroke",stylers:[{color:"#465c64"},{weight:8}]},{featureType:"landscape.man_made",elementType:"all",stylers:[{visibility:"on"}]},{featureType:"landscape.man_made",elementType:"geometry.fill",stylers:[{visibility:"simplified"}]},{featureType:"poi.attraction",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"poi.government",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"poi.medical",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"poi.place_of_worship",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"poi.school",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"road.highway",elementType:"all",stylers:[{Hue:""},{saturation:-100},{lightness:48}]},{featureType:"road.highway.controlled_access",elementType:"all",stylers:[{Hue:""},{saturation:-100},{lightness:48}]},{featureType:"water",elementType:"all",stylers:[{color:"#60a5e2"}]}]}))}};