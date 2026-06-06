// Global fix: Sanitize location.hash to prevent jQuery selector errors with query params
(function() {
	if (window.location.hash && window.location.hash.indexOf('?') !== -1) {
		var hash = window.location.hash;
		var hashParts = hash.split('?');
		if (hashParts[0]) {
			history.replaceState(null, null, window.location.pathname + window.location.search + hashParts[0]);
		}
	}
})();

// Global fix: Make touch and wheel events non-passive to allow preventDefault()
(function() {
	if (!window || !EventTarget) return;
	var passiveEvents = ['touchstart', 'touchmove', 'touchend', 'wheel', 'mousewheel'];
	var originalAddEventListener = EventTarget.prototype.addEventListener;
	EventTarget.prototype.addEventListener = function(type, listener, options) {
		if (passiveEvents.indexOf(type.toLowerCase()) !== -1 && options !== true && (typeof options !== 'object' || options.passive !== true)) {
			var opts = typeof options === 'boolean' ? { capture: options } : (typeof options === 'object' && options ? {} : {});
			if (typeof options === 'object' && options) for (var k in options) if (options.hasOwnProperty(k)) opts[k] = options[k];
			opts.passive = false;
			options = opts;
		}
		return originalAddEventListener.call(this, type, listener, options);
	};
})();

jQuery(document).ready(function($){




/*================*/
    /*scrool fluide */
/*================*/

/*var smoothScroll = {
    speed: 0,
    delay: 20, // en ms
    timer: null,
    scrollSpeed: 6,
    inertia: 0.955,
    init: function(){
        this.setEventsListeners();
    },
    setEventsListeners: function(){
        var me = this;
        $(document).bind('DOMMouseScroll mousewheel', function(e){
            me.setSpeed(e.originalEvent);
        });
     },
    setSpeed: function(e){
        var direction = e.detail ? -e.detail : e.wheelDelta;
        this.speed += direction < 0 ? -this.scrollSpeed : this.scrollSpeed;
        if(this.timer == null){
            this.timer = setTimeout(this.smoothScroll, this.delay, this);
        }
        e.preventDefault();
    },
    smoothScroll: function(scope){
        var self = scope;
        self.speed *= self.inertia;

        //scroll de la fenettre
        var currScrollTop = $(window).scrollTop();
        $(window).scrollTop(currScrollTop-self.speed);

        //scrool du menu
        var currScrollTop = $(".frame-type-menu_principal").scrollTop();
        $(".frame-type-menu_principal").scrollTop(currScrollTop-self.speed);


        if(self.speed < self.inertia && self.speed > -self.inertia){
            self.speed = 0;
            clearTimeout(self.timer);
            self.timer = null;
        }else{
            self.timer = setTimeout(self.smoothScroll, self.delay, self);
        }
    }
}

smoothScroll.init();*/


  //popup gmap
$('.lien_geoloc a').each(function(i,item){
    var url = jQuery(this).attr('href');
    if(url.indexOf('?') == -1){
        jQuery(this).attr('href',url+'?type=100');
    }
    else{
        jQuery(this).attr('href',url+'&type=100');
    }
});
$(".lien_geoloc a").fancybox({
    type:'iframe',
    animationEffect : "zoom-in-out"
});

$(".lien_geoloc_agenda a").fancybox({
  type:'inline',
  animationEffect : "zoom-in-out"
});


$("[data-fancybox], .fancybox").fancybox({
    afterLoad : function(instance, slide) {
        if (slide.$slide.find('img')) {
            slide.$slide.find('img').attr("alt", slide.opts.$orig.data('alt'));
        }
    }
});
    // Social Share Privacy
    $('.socialShare').socialSharePrivacy({
        //Stockage en local des activations par défaut
        perma_option: true,
        set_perma_option: function (service_name) {
            localStorage.setItem('socialSharePrivacy_'+service_name, 'perma_on');
        },
        del_perma_option: function (service_name) {
            localStorage.removeItem('socialSharePrivacy_'+service_name);
        },
        get_perma_options: null,
        get_perma_option: function (service_name) {
            return localStorage.getItem('socialSharePrivacy_'+service_name) === 'perma_on';
        }
    });

    $(".powermailDatepicker").datepicker({
        changeMonth: true,//this option for allowing user to select month
        changeYear: true, //this option for allowing user to select from year range
        dateFormat: "dd/mm/yy"
    });
    $("#news-maximumDate").datepicker({
        changeMonth: true,//this option for allowing user to select month
        changeYear: true, //this option for allowing user to select from year range
        dateFormat: "dd/mm/yy"
    });
    $("#news-minimumDate").datepicker({
        changeMonth: true,//this option for allowing user to select month
        changeYear: true, //this option for allowing user to select from year range
        dateFormat: "dd/mm/yy"
    });

    /*Retrouver une ancre dans une url*/
   /* function getUrlHash(){
    if( window.location.hash ){
    var locationHash = window.location.hash;
    var coordonnees = $(locationHash).offset().top;
        coordonnees = coordonnees - 200;
        $('html, body').animate({
            scrollTop:coordonnees
        }, 'slow');
    }
    return false;
}
getUrlHash();*/

// Surcharge input file
$('.powermail_fieldwrap_type_file').children(".powermail_field").append( $('<p class="file-return"></p>') );
$('.powermail_file ').change(function() { // au changement de l'input
    var cheminFichier = this.value; // on recupère la valeur du fichier
    var nomFichier = cheminFichier.substring(cheminFichier.lastIndexOf("\\") + 1, cheminFichier.length); // on slipt la string pour ne récupérer que le nom
    $(this).parent().find(".file-return").html(nomFichier); // on insère la valeur dans la balise p
});

    /*************PLIE DEPLIE***********/
    $(".openCloseTitle").each(function( index ){
        $(this).attr('aria-expanded', 'false');
        $(this).next('div').addClass('collapse');
    });

    $(".openTitle").each(function( index ) {
    $(this).next('div').slideToggle(350, function(){
            $(this).toggleClass('openBody');
        });
    });

    // BLocs pliés dépliés
    $(document).on('click', '.openCloseTitle', function() {
        $(this).toggleClass('openTitle');
        $(this).hasClass('openTitle') ? $(this).attr('aria-expanded', 'true') : $(this).attr('aria-expanded', 'false');
        $(this).next('div').slideToggle(350, function(){
            $(this).toggleClass('openBody open');
        });
    });

    if($('.ariane').length){
    $('.menuFil').each(function() {
        if($(this).find('li').length <= 1){
            $(this).parent().removeClass('item').find('> a').removeClass('openFil');
        }
    });
}
$('.ariane').find('.item > a').click(function(event) {
    event.preventDefault();
    $(this).toggleClass('active');
    if($(this).parent().find('> ul').is(':visible')){
        $(this).parent().find('.menuFil').slideUp(350);
    }else{
        $('.ariane').find('.item > ul').slideUp(350);
        $(this).parent().find('.menuFil').slideDown(350);
    }
});

var ariane = $('.ariane > ul > li:nth-child(2) span').text();
$('.ariane > ul > li:nth-child(2)').empty();
$('.ariane > ul > li:nth-child(2)').text(ariane);
$(".ce-bodytext a:not(.icon)").addClass('underline');
$("#tx-solr-search-functions").appendTo(".content_left");


if ( $( "h3.choississez-la-dans-la-liste-ci-dessous" ).length ) {
    $("h2.entete").hide();
    $('html, body').animate({
                    scrollTop:$( "h3.choississez-la-dans-la-liste-ci-dessous" ).offset().top - 150
                }, 'slow');
    }
if ( $( ".entete_dechet" ).length ) {
    $(".entete_dechet").append($("#obtenir-mon-calendrier-de-collecte").parents(".frame"));
    $("h2.entete").hide();
    $("h2.entete_dechet").show();

    $('html, body').animate({
                    scrollTop:$( ".entete_dechet" ).offset().top - 100
                }, 'slow');
    }


/*================*/
/*iframe redimension */
/*================*/



 if($('iframe').length >0 ){
    function rezise_iframe(){
        $( "iframe" ).each(function() {
           iframeSizeH = $(this).height();
           iframeSizeW = $(this).width();
           ratio = iframeSizeH/iframeSizeW;

           sizeScreenW = $(".content-center")[0] ? $(".content-center").width() : $("#contentPage").width();
           newSizeH = sizeScreenW * ratio;

           $(this).css({"width": sizeScreenW});

            $(this).removeAttr("width");
        });
    }

    rezise_iframe();
    $(window).resize(function(){
        rezise_iframe();
    });
 }

        var hash = document.location.hash.replace('#', '');
        // Fix: Remove query parameters from hash to prevent jQuery selector errors
        if (hash && hash.indexOf('?') !== -1) {
            hash = hash.split('?')[0];
        }
        if (hash){
            if($('#' + hash + ' > .openCloseTitle').length){
            $('html, body').animate({
                    scrollTop: $('#' + hash + ' > .openCloseTitle').offset().top - 200
                }, 500);
        }
    }

    $("input[name*='ville]']").change(function(){
        var max= 1;
        if( $("input[name*='ville]']:checked").length == max ){
            $("input[name*='ville]']").attr('disabled', 'disabled');
            $("input[name*='ville]']:checked").removeAttr('disabled');
        }else{
            $("input[name*='ville]']").removeAttr('disabled');
        }
    });

    // Prevent occurring "space" in email input FF

    const emailInput = document.querySelectorAll('input[type="email"]');

    const preventSpaceKey = (event) => {
        if (event.keyCode == 32) {
            event.preventDefault();
        }
    };

    const trimSpaces = (event) => {
        const inputValue = event.target.value;
        event.target.value = inputValue.replaceAll(' ', '');
    };

    emailInput.forEach(item => {
        item.addEventListener('change', e => trimSpaces(e));
        item.addEventListener('keydown', e => preventSpaceKey(e));
    });
});




/*================*/
/*Solr pagination */
/*================*/


var href = $('#solr-pagination .last').children('a').attr('href');
if (href === undefined || href === null) {

}
else {
        base_url = window.location.origin;
        nbr_results = $(".result-found").attr("nombre_de_resultats");
        results_per_page = $( "#content_solr li.results-entry" ).length;
        nbr_pages = Math.ceil(nbr_results / results_per_page);
        pages_limite = nbr_pages - 1;
        $('#tx-solr-search').append('<div id="next_page">Afficher plus de résultats</div>');

}

click_ok =1;
 $(window).scroll(function(event){
    if($('#next_page').length >0 ){
        limiteTop = $('#next_page').offset().top - $(window).height() +250;
        $(window).resize(function(){
            limiteTop = $('#next_page').offset().top - $(window).height() +250;
        });

        if(click_ok==1){
            windowScroll = $(window).scrollTop();
            if( windowScroll >= limiteTop )
            {
                $('#next_page').trigger("click");
                click_ok = 0;
                setTimeout( function() { click_ok = 1 }, 1000);
            }
        }
    }
});


page = 1;
$("#next_page").click(function(){
    page++;
    if (nbr_pages == page) {
        $('#tx-solr-search').append('<div id="temp-load" text-align: center;"></div>');
        var loaderPath = '../Images/loader.gif';
        for (var s = document.getElementsByTagName('script'), i = s.length; i--;) if (s[i].src && s[i].src.indexOf('scriptPage.js') !== -1) { loaderPath = s[i].src.replace('/JavaScript/scriptPage.js', '/Images/loader.gif'); break; }
        $('#temp-load').append('<span style="width:100%; text-align: center; display: inline-block; position: relative"><img style="display: inline-block; position: relative;" src="'+loaderPath+'" alt="" /></span>');

        var url = window.location.href;
        new_url= url+'&tx_solr%5Bpage%5D=' + page + ' .results-entry';

        $('#temp-load').load(new_url, function(){
            $( "#temp-load li.results-entry" ).each(function() {
              $('#content_solr').append($(this));
              $('#temp-load').remove();
            });
            $('#next_page').remove();
        });
    }
    else {
        $('#tx-solr-search').append('<div id="temp-load"></div>');
        var loaderPath = '../Images/loader.gif';
        for (var s = document.getElementsByTagName('script'), i = s.length; i--;) if (s[i].src && s[i].src.indexOf('scriptPage.js') !== -1) { loaderPath = s[i].src.replace('/JavaScript/scriptPage.js', '/Images/loader.gif'); break; }
        $('#temp-load').append('<span style="width:100%; text-align: center; display: inline-block; position: relative"><img style="display: inline-block; position: relative;" src="'+loaderPath+'" alt="" /></span>');

        var url = window.location.href;
        new_url= url+'&tx_solr%5Bpage%5D=' + page + ' .results-entry';
        console.log( new_url);

        $('#temp-load').load(new_url, function(){
            $( "#temp-load li.results-entry" ).each(function() {
              $('#content_solr').append($(this));
              $('#temp-load').remove();
            });
        });
    }
});


