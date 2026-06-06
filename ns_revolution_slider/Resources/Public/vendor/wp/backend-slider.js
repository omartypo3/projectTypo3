define(['jquery'], function ($) {
    'use strict';

    $(function () {
        var values = $('[class*="revslider-sliders-plugin-"] .revslider_values').val().split(",");
        if(values.length > 0){
            $.each(values, function(i, e){
                $('li[data-id="'+e+'"]').addClass('active');
            });
        }
        $('.revslider-selectionHolder').on('click', function(){
            var el = $(this);
            var holder = $(el.closest('div'));
            var valuesTarget = $('input.revslider_values', holder);

            if($('li.active', holder).length == 0){
                valuesTarget.val('');
            }
            el.toggleClass('active');

            var values = valuesTarget.val();
            if(el.hasClass('active')){
                valuesTarget.val( values + ',' + el.data('id') + ','  );
            } else {
                valuesTarget.val( values.replace(el.data('id') + '', '') );
            }
            valuesTarget.val( valuesTarget.val().replace(/,\s*$/, "") );
            valuesTarget.val( valuesTarget.val().replace(/^,*/, "") );
            valuesTarget.val( valuesTarget.val().replace(/,{2,}/, ",") );
        });
        $('img.svg').each(function(){
            var $img = $(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');
            $.get(imgURL, function(data) {
                var $svg = $(data).find('svg');
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }
                $svg = $svg.removeAttr('xmlns:a');
                if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                    $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'));
                }
                $img.replaceWith($svg);
            }, 'xml');
        });
    });
});
