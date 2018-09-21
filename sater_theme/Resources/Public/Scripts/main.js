$(function() {
    $('.jcarousel')
        .jcarousel({
            // Core configuration goes here
        })
        .jcarouselAutoscroll({
            interval: 3000,
            target: '+=1',
            autostart: true,

        })
    ;
});
//read more
(function($, window, document, undefined) {
    "use strict";

    var el= $('.readmore'),
        clone= el.clone(),
        originalHtml= clone.html(),
        originalHeight= el.outerHeight(),
        Trunc = {
            moreLink: '<a href="#" class="readmore-toggle container" data-read="more">Read More<span class="icon-arrow-bottom"</span></a>',
            lessLink: '<a href="#" class="readmore-toggle container" data-read="less">Moins <span class="icon-arrow-top"></span></a>',
            addTrigger : function(){
                $('.article-readmore').append(this.moreLink);
            },
            truncateText : function( textBlock ) {
                while (textBlock.text().length > 190 ) {
                    textBlock.text(function(index, text) {
                        return text.replace(/\W*\s(\S)*$/, '...');
                    });
                }
            },
            replaceText: function ( textBlock, original ){
                return textBlock.html(original).height(originalHeight);
            }

        };
    Trunc.addTrigger();
    Trunc.truncateText(el);

    $(document).on('click', '[data-read]', function(e){
        e.preventDefault();

        if ($(this).data('read') == 'more'){
            Trunc.replaceText(el, originalHtml);
            $(this).replaceWith(Trunc.lessLink);

        } else if ($(this).data('read') == 'less') {
            Trunc.truncateText(el);
            $(this).replaceWith(Trunc.moreLink);
            el.css('height', '100%');
        }

    });

})(jQuery, window, document, undefined);




$('#produit,#connaissance').on('change',function() {
    thi=$(this).val();
    if(thi != 'agricole'){
        $('.produit').removeClass("showproduit");
    }
    link=$('option:selected', this).attr('goto');
   if(link){
         location.href=link;
    }else{
        $('.produit[parent='+thi+']').addClass("showproduit");
    }
});
$('#agricole').on('change',function() {
    link=$('option:selected', this).attr('goto');
    if(link) {
        location.href = link;
    }
});
$('#Country').on('change',function() {
    thi=$(this).val();
    console.log(thi);
    if(thi != 'Sfax' || thi != 'Tunis'){
        $('.city').removeClass("showcity");
    }
    if(thi == 'Sfax' || thi == 'Tunis'){
        $('.city[parent='+thi+']').addClass("showcity");
    }
});