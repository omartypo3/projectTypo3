/* BEGIN Bloc Datetimepicker */
var currentDate = new Date();

$('.datetimepicker').datetimepicker({
    defaultDate: currentDate,
    minDate: currentDate,
    allowInputToggle: true,
    // autoclose: false,
    showTodayButton: true,
    format:'dd, DD.MM.YYYY  [ab] HH:mm [Uhr]' ,
    widgetPositioning:{
        horizontal: 'auto',
        vertical: 'bottom'
    },
    sideBySide: true,
    inline: false ,
    locale: 'de',
    icons: {

        previous: 'icon icon-rsag-round-arrow-1-left',
        next: 'icon icon-rsag-round-arrow-1-right',

    },
});
/* END Bloc Datetimepicker */

/* BEGIN Bloc Selectpicker */
$('.selectpicker').selectpicker();
/* END Bloc Selectpicker */

/* BEGIN Bloc OwlCarousel In Homepage */
if ($('.owl-carouselHome').length) {
    var owl = $('.owl-carouselHome');
    owl.owlCarousel({
        nav: true,

        navText: ["<div class='icon icon-rsag-round-arrow-1-left'></div>","<div class='icon icon-rsag-round-arrow-1-right'></div>"],
        loop: true,
        margin: 10,
        responsiveClass: 'owl-responsive' ,
        responsive: {
            0: {
                items: 1,
                nav: true,
                loop: false,
                margin: 20
            },
            768: {
                items: 3,
                nav: true,
                loop: false,
                margin: 20
            },
            1000: {
                items:3,
                nav: true,
                loop: false,
                margin: 20
            }
        }

    })

}

/* END Bloc OwlCarousel In Homepage */


/* BEGIN Bloc Scroll On Pressemitteilungen Page */
(function ( $ ) {

    var pertime=0;

    var win = $(window);
    var footerheight = parseInt($("footer").height() ) +  parseInt($(".margin-bottom-60").css("margin-bottom")  +  parseInt($(".pressitem:last-child").height() ) )  ;

    $("#loadingpressium").css("bottom",footerheight) ;


// Each time the user scrolls
    win.scroll(function() {


        if (pertime < 7 &&  $("#posts")[0] ) {
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - footerheight ) {
                $('#loadingpressium').show();


                pertime ++ ;
                $.ajax({
                    url: '/loadpost.html',
                    dataType: 'html',
                    success: function(html) {

                        setTimeout(function(){
                            $('#posts').append(html );
                            $.fn.matchHeight._apply('.item');
                            $.fn.matchHeight._maintainScroll = true;
                            $('#loadingpressium').hide(); }, 200);
                    }
                });


            }
        }else {
            setTimeout(function(){

                $.ajax({
                    url: '/typo3conf/ext/rsag_theme/Resources/Public/static/nomoreposts.html',
                    dataType: 'html',
                    success: function(html) {
                        $('#loadingpressium').html(html).show() ;
                    }
                });



            }, 2000);
            setTimeout(function(){  	$('#loadingpressium').remove() ; }, 4000);
        }


    });


}( jQuery ));

/* END Bloc Scroll On Pressemitteilungen Page */

$( ".events li a " ).click(function(e) {

    var d = $(this).attr("itemdate") ;

    $( ".blocyear .item" ).each(function(i) {

        if ( String($( this).text().replace(/\s/g, '')) == String(d.replace(/\s/g, '')) ){

            $( ".blocyear .item " ).removeClass("activeyear");
            $( ".blocyear .item " ).eq( i).addClass("activeyear");

            owltimeline.trigger('to.owl.carousel', [i,500]);
            return false;
        }
    });

});
/* END Bloc Timeline On Geschichte Page */
/* BEGIN En CHANGE SELECT On Download Page */
$( ".filterdownloawd" ).change(function() {
    var selectedfilter = $( ".filterdownloawd" ).val();
    if ( selectedfilter ==""){
        $(".download-item ,.parentdownload").show();
    }else {
        $( ".parentdownload " ).show();
        $(".download-item ").hide();

        $( ".parentdownload " ).each(function( index ) {
            var hide = true  ;
            $( this).children('.download-item').each(function( i ) {
                if ($( this).attr("data-content") == selectedfilter ){
                    hide = false  ;
                    $( this).show();
                }
            });
            if (hide == true){
                $( this).hide();
            }
        });

    }
});
/* END En CHANGE SELECT On Download Page */
// apply matchHeight to each posts items

$('#posts').find('.item').matchHeight({ });

// apply matchHeight to each posts
// items

(function($){
    var owlTimeline = $(".owl-carousel");
    owlTimeline.owlCarousel({
        items: 1,
        loop:false,
        nav: true,
        navText: ['<a href="#0" class="prev">Prev </a>', '<a href="#0" class="next">Next </a>'],
        startPosition: 'URLHash',
        center:true
    });

    owlTimeline.on('changed.owl.carousel', function(event) {
        clearActive();
        setActiveDate();
    });


    $('.cd-horizontal-timeline .owl-item ol[data-hash]').each(function(){
        var dateNumber = $(this).find('li').length;
        $(this).find('li').width(100/dateNumber+"%");
    });

    $('.cd-horizontal-timeline .owl-item ol[data-hash] li a[data-date]').click(function(){
        unSelect();
        $(this).addClass('selected');
        var date = $(this).data('date');
        var events = $('.events-content li[data-date="'+date+'"]');
        if (events.length == 1) {
            events.addClass('selected')
        }
    })

    function unSelect() {
        $('.cd-horizontal-timeline .owl-item ol[data-hash] li a[data-date]').removeClass('selected');
        $('.events-content li[data-date]').removeClass('selected');
    }

    function clearActive() {
        $('.timeline-key-dates .item').removeClass('activeyear');
        $(this).addClass('activeyear');
    }

    function setActiveDate() {
        var dots = $('.owl-dots .owl-dot');
        var activeIndex = dots.index($('.owl-dots .owl-dot.active'));
        $('.timeline-key-dates .item').eq(activeIndex).addClass('activeyear');
    }
    setActiveDate();

    //Reverse position of source and destination fields
    $('.doublefleche').click(function(){
        $("#addressFrom").swap("#addressTo");
        $("#addressFrom").toggleClass("margin-toplg-30").toggleClass("margin-bottom-xs-1");
        $("#addressTo").toggleClass("margin-toplg-30").toggleClass("margin-bottom-xs-1");
    });


    $(document).on('click','#get-mylocation',function(e){
        e.preventDefault();
        console.log("localization...");

        /* Chrome need SSL! */
        var is_chrome = /chrom(e|ium)/.test( navigator.userAgent.toLowerCase() );
        var is_ssl    = 'https:' == document.location.protocol;
        if( is_chrome && ! is_ssl ){
            return false;
        }

        /* HTML5 Geolocation */
        navigator.geolocation.getCurrentPosition(
            function( position ){ // success cb

                /* Current Coordinate */
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                var google_map_pos = new google.maps.LatLng( lat, lng );

                /* Use Geocoder to get address */
                var google_maps_geocoder = new google.maps.Geocoder();
                google_maps_geocoder.geocode(
                    { 'latLng': google_map_pos },
                    function( results, status ) {
                        if ( status == google.maps.GeocoderStatus.OK && results[0] ) {
                            console.log( results[0].formatted_address );
                        }
                    }
                );
            },
            function(){ // fail cb
            }
        );
    });

}(jQuery));

jQuery.fn.swap = function(b) {
    b = jQuery(b)[0];
    var a = this[0],
        a2 = a.cloneNode(true),
        b2 = b.cloneNode(true),
        stack = this;

    a.parentNode.replaceChild(b2, a);
    b.parentNode.replaceChild(a2, b);

    stack[0] = a2;
    return this.pushStack( stack );
};
/* BEGIN OPTION On Modal */

$( ".confirmoption" ).click(function() {
    var options ="";
var i = 0;
    $( ".checkoptionen" ).each(function( index ) {
        if($(this).is(":checked")==true){

            if (i==0) options = $(this).attr("data-name");
                else
            options = options+", "+$(this).attr("data-name");

            i ++ ;
        }

    });

 if( $( "#unbegrenzt").val() > 0 ){
     if(options=="")
         options = $( "#unbegrenzt").attr("data-name")+" "+$( "#unbegrenzt option:selected").text();
     else
         options =  options = options+", "+$( "#unbegrenzt").attr("data-name")+" "+$( "#unbegrenzt option:selected ").text();
      }
    if( $( "#normal").val() > 0 ){
        if(options=="")
            options = $( "#normal").attr("data-name")+" "+$( "#normal option:selected").text();
        else
            options =  options = options+", "+$( "#normal").attr("data-name")+" "+$( "#normal option:selected ").text();
    }
if(options=="")
    $(".optionsresults").hide();
else{
    $(".optionsresults span").html(options).show();
    $(".optionsresults").show();
}
});
$( ".resetoption" ).click(function() {
    $( ".checkoptionen" ).eq(0).prop( "checked", true );
    $( ".checkoptionen" ).eq(1).prop( "checked", false );
    $( ".checkoptionen" ).eq(2).prop( "checked", true );
    $( "#unbegrenzt ,#normal" ).val(0);
});
/* END OPTION On Modal */












