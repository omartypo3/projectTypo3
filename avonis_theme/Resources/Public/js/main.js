$(document).ready(function() {

    /*$('.youtube-popup').each(function() {
        ytwidth = $(this).find('.yt-image').width();
        ytoverlay = $(this).find('div.overlay');
        ytoverlay.css('width', ytwidth);
        if ($(this).hasClass('fce-boxed')) {
            $(this).css('width', ytwidth+40);
        };

    });*/
    /**
     * TODO 
     * View helper to test if the current page of product is active
    $('.sublevel-2 li').each(function(){

        var datalink=$(this).attr('data-link');
        product_id=findGetParameter('tx_wproducts_product_detail[product]');
        if(datalink.indexOf('tx_wproducts_product_detail[product]='+product_id)!=-1){
            $(this).addClass('active current');
        }
    });
    $('.icon-arrow-left .active').each(function(){
      $('.mp-level').attr('style','transform: translate3d(-100%, 0px, 0px) translate3d(-80px, 0px, 0px)');
      $(this).parents('.mp-level').addClass('mp-level-open mp-level-overlay').attr('style','');
      $(this).closest('.mp-level').removeClass('mp-level-overlay').attr('style','');
      var level=$(this).closest('.mp-level').data('level');
      console.Log(level);
     // menu._openMenu();
    });
     **/
    $( ".youtube-popup .csc-firstHeader" )
      .mouseenter(function() {
        parent=$(this).closest('.youtube-popup');
        parent.addClass('hovered');
      })
      .mouseleave(function() {
        parent=$(this).closest('.youtube-popup');
        parent.removeClass('hovered');
      })
      .click(function() {
         parent=$(this).closest('.youtube-popup');
         parent.find('a').trigger('click');
      });


    /**
     * Content selector
     */
    $("#content-selector-dropdown").change(function () {
        if($('select[name="template-contactform-service"] option[value="content-area-0"]').length){
            $('select[name="template-contactform-service"] option[value="content-area-0"]').remove();
        }
        var end = this.value;
        $('[id^="content-area-"]').hide();
        $('#'+end).fadeIn(500);
        //Simulate event resize to fix the isotope issue
        var evt = window.document.createEvent('UIEvents');
        evt.initUIEvent('resize', true, false, window, 0);
        window.dispatchEvent(evt);
    });

});

function alignPortfolioItemOverlay() {
    var portfolioItem = $('.portfolio-item');

    portfolioItem.each(function() {
        var element = $(this);
        if( element.find('.portfolio-desc').length > 0 ) {
            var portfolioOverlayHeight = element.outerHeight();
            var portfolioOverlayDescHeight = element.find('.portfolio-desc').outerHeight();
            var portfolioOverlayMiddleAlign = - ( portfolioOverlayHeight - portfolioOverlayDescHeight - 55 ) ;

            element.find('.portfolio-desc').css({ 'bottom': portfolioOverlayMiddleAlign });
            //element.find('.portfolio-desc').css({ 'height': '50%' });
        }
    });

}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}
