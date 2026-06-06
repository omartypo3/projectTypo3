/* ========================*/
/* Scroll automatique partie2*/
/* ========================*/

WindowsSizeW = $(window).width();

if(WindowsSizeW>1300){
	$(function() {
		$("#header").addClass('menuSection1');
	$.scrollify({
	    section : ".screen-section",
	    sectionName : "section-name",
	    interstitialSection : "",
	    easing: "easeOutExpo",
	    scrollSpeed: 1100,
	    offset : 0,
	    scrollbars: true,
	    standardScrollElements: "",
	    setHeights: true,
	    overflowScroll: true,
	    updateHash: false,
	    touchScroll:true,
		before:function(index, sections) {
			if(index == 0){
				$("#header").addClass('menuSection1');
			}else{
				$("#header").removeClass('menuSection1');
			}
		   /* var sno = index+1;
		    $(".screen-section").removeClass("sectioncolor");
		    $(".screen-section:nth-child("+sno+")").addClass("sectioncolor");*/
		    },
		    after:function(index, sections) {
		   /* var sno = index+1;
		    $(".screen-section").removeClass("sectioncolor");
		    $(".screen-section:nth-child("+sno+")").addClass("sectioncolor");*/
		    },
	    afterResize:function() {},
	    afterRender:function() {}
	  });
	});
}


if(WindowsSizeW<1300){
	 	part1 = $('.poster_video');
		limiteTop1 = part1.height()-44;
	 	$(window).trigger('scroll');
	    $(window).scroll(function(event){
	        windowScroll = $(window).scrollTop();
	        if( windowScroll >= limiteTop1 )
			{
				$("#header").removeClass('menuSection1');
	        }
			else
			{
	            $("#header").addClass('menuSection1');
	        }
	    });
}


/* ========================*/
/* Bouger bouton "toute l'actu" au dessus de twitter*/
/* ========================*/
WindowsSizeW = $(window).width();

if(WindowsSizeW<550){

$( ".block_twitter" ).before( $( ".home_part2>.frame:nth-last-child(1)" ) );
//$( ".home_part2 .frame:nth-last-child(2),.home_part2 .frame:nth-last-child(3)" ).before( $( ".home_part2 .frame:nth-last-child(1)" ) );

}


/* ========================*/
/* Suppression de la video en mobile et affichage du poster*/
/* ========================*/
if(WindowsSizeW<550){
	if($('video').length >0 ){
		$("video").each(function(){
	        $(this).remove();
	    });
	}
}

