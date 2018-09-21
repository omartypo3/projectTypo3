(function($) {

    var $navigation = $('.sub-navigation-bar');
    // Create a clone of the menu, right next to original.
    $('.sub-navigation-bar').addClass('original').clone().insertAfter('.sub-navigation-bar').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();
    scrollIntervalID = setInterval(stickIt, 10);
    var orgElementPos = $('.original').offset();
    function stickIt() {

        if(orgElementPos == null ){
            orgElementTop = 0;
        }else {
            orgElementTop = orgElementPos.top;
        }
        if ($(window).scrollTop() >= (orgElementTop)) {
            orgElement = $('.original');
            coordsOrgElement = orgElement.offset();
            if(orgElementPos == null){
                leftOrgElement = 0;
            }
            else{
                leftOrgElement = coordsOrgElement.left;
            }


            widthOrgElement = orgElement.css('width');
            $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
            $('.original').css('visibility','hidden');
        } else {
            // not scrolled past the menu; only show the original menu.
            $('.cloned').hide();
            $('.original').css('visibility','visible');
        }
    }
})(jQuery);