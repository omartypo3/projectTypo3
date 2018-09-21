var isMobile = window.matchMedia("only screen and (max-width: 767px)");
var widthmobile = 767 ;
var breakpoint = 1;

$(function () {
    /* BEGIN Search Block */

    $('input.form-control-search').on('change keyup ',function(e){
        $(".suchverlauf").remove();
        $.ajax({
            url: '/loadinsearch.html',
            dataType: 'html',
            success: function(data) {
         $('.search-filter').html(data );

            }
        });
    });


    $('.mobilesearch').on('click', function (event) {

        $(".rsag-search").height($( window ).height());
        $('[data-toggle="collapse"]').click();
        $('.rsag-search').slideDown();
        $('.form-control-search').focus();

    });
    $('a[href="#toggle-search"],  .rsag-search .input-group-btn > .close').on('click', function (event) {

        event.preventDefault();
        $('.rsag-language , .rsag-blocsize ').hide();
        $('.rsag-search .input-group > input').val('');
        $('.rsag-search').slideToggle("slow");

      $('.topmenulink li').removeClass('active');
      $('a[href="#toggle-search"]').closest('li').toggleClass('active');
        //While the popover is opened the main navigation should looks like hovered
        $scrollHeader = $('.scrollheader');
        hoverToggle($scrollHeader);
    });

    /* END Search Block */

    /* BEGIN Search Language */
    $('a[href="#toggle-language"],  .rsag-language .input-group-btn > .close').on('click', function (event) {
        event.preventDefault();
        $('.rsag-search , .rsag-blocsize').hide();
        $('.rsag-language .input-group > input').val('');
        $('.rsag-language').slideToggle("slow");
        $('.topmenulink li').removeClass('active');
        $('a[href="#toggle-language"]').closest('li').toggleClass('active');
        //While the popover is opened the main navigation should looks like hovered
        $scrollHeader = $('.scrollheader');
        hoverToggle($scrollHeader);
    });

    /* END Search Language */

    /* BEGIN Bloc Size */
    $('a[href="#toggle-blocsize"],  .rsag-blocsize .input-group-btn > .close').on('click', function (event) {
        event.preventDefault();
        $('.rsag-search , .rsag-language').hide();
        $('.rsag-blocsize').slideToggle("slow");
        $('.topmenulink li').removeClass('active');
        $('a[href="#toggle-blocsize"]').closest('li').toggleClass('active');
        //While the popover is opened the main navigation should looks like hovered
        $scrollHeader = $('.scrollheader');
        hoverToggle($scrollHeader);
    });

    /**
     * show the menu like if it was hovered, with white bg ...
     */
    function simulateHover($scrollHeaderElement) {
        $scrollHeaderElement.addClass("hovered-header");
    }

    /**
     * mouseout
     */
    function simulateHoverOut($scrollHeaderElement) {
        $scrollHeaderElement.removeClass("hovered-header");
    }

    /**
     * Toggle hover state
     * @param $scrollHeaderElement scrollHeader
     */
    function hoverToggle($scrollHeaderElement) {
        if (!$scrollHeaderElement.hasClass("hovered-header")) {
            simulateHover($scrollHeaderElement);
        } else {
            simulateHoverOut($scrollHeaderElement);
        }
    }

    /* END Bloc Size */


/* BEGIN - Close bloc Size , Search and  Language if I click anywhere */
if (!isMobile.matches) {
    $('div').on('focusout', function (e) {
        //console.log(e.target);
        if (!$(e.relatedTarget).hasClass("form-control-search") && !$(e.relatedTarget).hasClass("btn") && !$(e.target).hasClass("btn")  ) {
            //Click outside the the popover close it and remove the hover effect on the main navigation
            $('.rsag-search , .rsag-language , .rsag-blocsize').slideUp();
            simulateHoverOut($('.scrollheader'));
        }

    });

}
/* END - Close bloc Size , Search and  Language if I click anywhere */

/* BEGIN Bloc Menu */
$('.collapse').on('show.bs.collapse hide.bs.collapse', function(e) {
    e.preventDefault();
});



$('[data-toggle="collapse"]').on('click', function(e) {
    e.preventDefault();

    var bool = $(".navbar-toggle").attr('aria-expanded');

    if (bool == 'false' ){

        $(".navbar-toggle").attr('aria-expanded', true );
    }else {

        $(".navbar-toggle").attr('aria-expanded', false );
    }
    $("#navbar").toggleClass("inmenu");
    if (!$('#navbar-collapse-1').is(':visible'))
        $("#navbar-collapse-1").slideToggle();
    else $("#navbar-collapse-1").toggle();

    $($(this).data('target')).toggleClass('in');

});
  if (isMobile.matches) {
      $(".dropdown-menu > li > a  ").click(function () {

          x = $(this).attr("href");
          if (x == "#") {
              $(this).parent().find("ul").toggle();
              return false;
          }
      });
    }
    else {
      $('#navbar .navbar li.dropdown').hover(function() {
          if ($(window).width() > widthmobile )
              $(this).find('.dropdown-menu').first().stop(true, true).slideUp(0).slideDown('slow');
      }, function() {
          if ($(window).width() > widthmobile ){
              $(this).find('.dropdown-menu').first().stop(true, true).slideUp('slow');
              $(this).removeClass("open");
          }

      });
    }
    $(window).resize(function() {

    $('#navbar .navbar li.dropdown').hover(function() {
        if ($(window).width() > widthmobile )
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(0).slideDown('slow');
    }, function() {
        if ($(window).width() > widthmobile ){
            $(this).find('.dropdown-menu').first().stop(true, true).slideUp('slow');
            $(this).removeClass("open");
        }

    });


    });

/* END Bloc Menu */

/* BEGIN Bloc Footer */

$(".blocfooter h3 .icon").click(function (event) {
    event.preventDefault();
if ($(this).attr('data-icon')=="d")
    $(this).attr('data-icon',"b");
else
    $(this).attr('data-icon',"d");

$(this).parent().parent().find("form").slideToggle('slow');
 $(this).parent().parent().find("ul").slideToggle('slow');


});


/* Equalize the height of list items in the footer */
$(".list-container .list-column").matchHeight();


/* END Bloc Footer */
/* BEGIN Bloc Sidebar */
$("blockquote h3 .icon-rsag-round-arrow-1-bottom ").click(function () {

    $(this).toggleClass('rotate270');

    $(this).parent().parent().find(".blocanfahrt").slideToggle("200");
    $(this).parent().parent().find(".blocanmeldung").slideToggle("200");
    $(this).parent().parent().find(".offnungzeiten").slideToggle("200");

});
/* END Bloc Sidebar */
/* BEGIN - Load in page Pressemitteilungen the select List of all year */
for (i = new Date().getFullYear(); i > 2005; i--)
{
    $('.getall_years').append($('<option />').val(i).html(i));
}
/* END - Load in page Pressemitteilungen the select List of all year */



// Begin More info block

    $('.mehr-infos').on('click',function () {
        id=$(this).attr('id');
        if($(this).hasClass("opened")){
            $(this).parent().siblings("div").hide();
            $(this).removeClass("opened")
            $(this).siblings().find('div').attr('class', 'icon icon-rsag-round-arrow-1-right');
            $(this).html('Mehr Informationen');
        }else{
            $(this).parent().siblings("div").show();
            $(this).addClass("opened")
            $(this).siblings().find('div').attr('class', 'icon icon-rsag-round-arrow-1-top');
            $(this).html('Weniger Informationen');
        }
    });
    $( ".mehr-infos" ).trigger( "click" );

    // End More info block

});
/* BEGIN Bloc Google Maps */
var source, destination;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
google.maps.event.addDomListener(window, 'load', function () {
    new google.maps.places.SearchBox(document.getElementById('txtSource'));
    new google.maps.places.SearchBox(document.getElementById('txtDestination'));
    directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
});
if ($('#dvMap').length) {
 var mumbai = new google.maps.LatLng(53.5438044, 9.9889280);
    var mapOptions = {
        zoom: 7,
        center: mumbai ,

        //mapTypeId: 'satellite'
    };
 map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);

}

function GetRoute() {
 //   $('#dvMap , #dvPanel').css("position", "relative");

    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('dvPanel'));

    //*********DIRECTIONS AND ROUTE**********************//
    source = document.getElementById("txtSource").value;
    destination = document.getElementById("txtDestination").value;

    var request = {
        origin: source,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });

    //*********DISTANCE AND DURATION**********************//
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [source],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
            var distance = response.rows[0].elements[0].distance.text;
            var duration = response.rows[0].elements[0].duration.text;
            var dvDistance = document.getElementById("dvDistance");
            dvDistance.innerHTML = "";
            dvDistance.innerHTML += "Distance: " + distance + "<br />";
            dvDistance.innerHTML += "Duration:" + duration;

          //  $('#dvMap , #dvPanel').show(600);
        } else {
            alert("Unable to find the distance via road.");
        }
    });

}
/* END Bloc Google Maps */

/* BEGIN Home Js  */
function getticketitem(value) {

    $(".distancebetween , .geodate , .traget , .geodate_"+value+" td[data-id="+value+" ] ").hide(1000);
    var recentvalue = $(".ihreverb").html();
    $(".ihreverb").html( $(".ihreverb").attr("dataname-ticket")  );
    $(".ihreverb").attr("dataname-ticket" , recentvalue );
  $(" .geodate_"+value).addClass("no-padding-left-right");

    $(".geodate_"+value+" , .geodate_"+value+" .traget ,.itemticket ").show(1000);
 // console.log($('.itemticket').parent().closest('div').height());
 $("#dvMap").height( 1033 );
}


/* END Home Js */
/* BEGIN Bloc Scroll Header & Bloc sociaux */
/*
if ($(window).scrollTop() == 0 && !isMobile.matches ) {

        $('header.absoluteheader').hover(function () {
            if(!$('.scrollheader').hasClass("headerheight"))
                $('.scrollheader').addClass('fixed-header shaddow-header');
        },
        function () {
            if(!$('.scrollheader').hasClass("headerheight"))
                $('.scrollheader').removeClass('fixed-header shaddow-header');
        });
}*/
$(window).scroll(function(){

    if ($(window).scrollTop() >= breakpoint ) {
        if ($(".scrollsociaux").hasClass('fixed-sociaux')) {
            $('.scrollheader').addClass('fixed-header headerheight');
        }else {
            $('.scrollheader').addClass('fixed-header headerheight shaddow-header');
        }
    }
    else {
        $(".scrollheader").removeClass('fixed-header headerheight shaddow-header ');
    }

    if (!isMobile.matches && $(".scrollsociaux")[0]) {
        if ($(".scrollsociaux").offset().top  > 0) {
            var h= $(".fixed-header").height();
            if (parseFloat($(window).scrollTop()) > parseFloat($(".verganst").offset().top - h)) {
                if (!$(".scrollsociaux").hasClass('fixed-sociaux')) {
                    $('.scrollsociaux').slideDown('300').addClass('fixed-sociaux');

                    $('.scrollheader').removeClass('shaddow-header');
                }
            } else {

                if ($(".scrollsociaux").hasClass('fixed-sociaux')) {
                    $('.scrollsociaux').removeClass('fixed-sociaux');
                    $('.scrollheader').addClass('shaddow-header');
                }
            }

        } else {

            if ($(".scrollsociaux").hasClass('fixed-sociaux')) {
                $('.scrollsociaux').removeClass('fixed-sociaux');
                  $('.scrollheader').addClass('shaddow-header');
            }
        }
    }
});
/* END Bloc Scroll Header & Bloc sociaux  */

 /* BEGIN Bloc PRESS  */
$( document ).ready(function() {
 var widhtpress = $(".press-item").width() ;
 $(".press-item").height(widhtpress);

    $(".zone-selector").change(function () {
        console.log(this.value);
        $(".target-zone").attr('href', this.value);
    });

});
/* BEGIN Bloc PRESS  */

/* BEGIN Animation for Tabs */
if ($('.firstactive')[0]) {
$(".hometabs ul li:first-child").addClass("active");
$("#fahrplan").addClass("active animated fadeInDow");
$("#tab-search-centent").show();
}
$(function() {
    var b = "fadeInDow";
    var c;
    var a;
    d($(".nav-tabs a"), $(".tab-content"));

    function d(e, f, g) {
        e.click(function(i) {
            i.preventDefault();
            $(this).tab("show");
            var h = $(this).data("easein");
            if (c) {
                c.removeClass(a);
            }
            if (h) {
                f.find("div.active").addClass("animated " + h);
                a = h;
            } else {
                if (g) {
                    f.find("div.active").addClass("animated " + g);
                    a = g;
                } else {
                    f.find("div.active").addClass("animated " + b);
                    a = b;
                }
            }
            c = f.find("div.active");
        });
    }
    $("a[rel=popover]").popover().click(function(f) {
        f.preventDefault();
        if ($(this).data("easein") != undefined) {
            $(this).next().removeClass($(this).data("easein")).addClass("animated " + $(this).data("easein"));
        } else {
            $(this).next().addClass("animated " + b);
        }
    });
});
/* END Animation for Tabs */
/* Same width and height */
$(function() {
	var widthText = 0;
	$( ".imageWH-same-50" ).each(function( index ) {
		var width = $( this ).width();
		$( this ).css('height', width);
	}).matchHeight();
	$( ".imageWH-same-50 .press-item" ).each(function( index ) {
		var width1 = $( this ).width();
		$( this ).css('height', width1);
	});
});

$(window).resize(function() {
	$(function() {
        $( ".imageWH-same-50" ).each(function( index ) {
            var width = $( this ).width();
            $( this ).css('height', width);
        }).matchHeight();
        $( ".imageWH-same-50 .press-item" ).each(function( index ) {
            var width1 = $( this ).width();
            $( this ).css('height', width1);
        });
	});
});
/* Same width and height */

/* Show / hide Tabs of search */
$( ".tab-search-link" ).click(function() {
    if($(this).closest( "li" ).hasClass( "active" )){

        $("#tab-search-centent").slideToggle();
    }
    if ( $("#tab-search-centent").css('display') == 'none' ){
        $("#tab-search-centent").slideToggle();
    }
});
/* Show / hide Tabs of search */
/*
/* BEGIN Bloc Stick For Sidebar */
//$( '.sidebar' ).fixedsticky();
/* END Bloc Stick For Sidebar */


/* BEGIN Bloc Detect Navigator */
if(navigator.platform.match('Win') == null) {
    $(".registerbutton").addClass("noWindbutton");
    $(".circlenotif").addClass("noWindcirclenotif");
    $(".input-group.date .input-group-addon-1").addClass("noWindcalendaricon");
    $("#linie .optionline .icon").addClass("padding-top-8");
    $(".inputFont").addClass("padding-top-3");

}

/* END Bloc Detect Navigator */

/* BEGIN Bloc On Click Linie Icon */
$.fn.reverse = [].reverse;
$( "#linie .optionline " ).click(function() {
    $( "#linie .optionline" ).removeClass("absoluteposition").removeClass("active").css("right","").css("z-index","");
    $( "#linie .optionline label" ).hide();
    $(this).addClass("active").css("width","auto");
    $(this).find("label").animate({ width: 'show' } , 1000);
    $( "#linie .optionline" ).not(this).addClass("absoluteposition" );

    var collection = $("#linie .optionline").not(this).reverse();
    var coeff = 6 ;
    if (isMobile.matches) {coeff = 10; }
    collection.each(function(i) {
        //$(this).css("right",i*coeff+"%");
        $(this).animate({ right: i*coeff+"%"  } , 1000);
        $(this).css("z-index",i);
        $(this).css("width","auto");
    });

});

/* End Bloc On Click Linie Icon */