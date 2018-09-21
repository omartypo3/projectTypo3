jQuery(document).ready( function($){

    // isAutoplaySupported(callback);
    // Test if HTML5 video autoplay is supported
    var isAutoplaySupported = function(callback) {
        // Is the callback a function?
        if (typeof callback !== 'function') {
            console.log('isAutoplaySupported: Callback must be a function!');
            return false;
        }
        // Check if sessionStorage exist for autoplaySupported,
        // if so we don't need to check for support again
        if (!sessionStorage.autoplaySupported) {
            // Create video element to test autoplay
            var video = document.createElement('video');
            video.autoplay = true;
            video.src = 'data:video/mp4;base64,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';
            video.load();
            video.style.display = 'none';
            video.playing = false;
            video.play();
            // Check if video plays
            video.onplay = function() {
                this.playing = true;
            };
            // Video has loaded, check autoplay support
            video.oncanplay = function() {
                if (video.playing) {
                    sessionStorage.autoplaySupported = 'true';
                    callback(true);
                } else {
                    sessionStorage.autoplaySupported = 'false';
                    callback(false);
                }
            };
        } else {
            // We've already tested for support
            // use sessionStorage.autoplaySupported
            if (sessionStorage.autoplaySupported === 'true') {
                callback(true);
            } else {
                callback(false);
            }
        }
    }

    //section-box fix images showing

    $('#content .white-background .section.section-box .row').each(function() {
        var nbr = $(this).find(".col-md-3.col-sm-6.box-item");
        var foundsectionlink = $(this).find(".section-link");
        if(foundsectionlink){
             $('#content .white-background .section.section-box .section-link').css({"height":"initial"});
        }
        if(nbr.length > 3){
            $('#content .white-background .section.section-box').addClass("showimagesbox");
        }

    });


    /**
     * Add a class to the slider container if the active slide is a video
     */
    function checkVideoSlide(){
        if( jQuery('.slider-video').parent().hasClass('swiper-slide-active') ){
            jQuery('#slider').addClass('video-slide-active');
        }else{
            jQuery('#slider').removeClass('video-slide-active');
        }
    }
    checkVideoSlide();
    jQuery("body").on('DOMSubtreeModified', "#slider", function() {
        checkVideoSlide();
    });

    /**
     * Video Mute button
     */
    $("video").prop('muted', true);

    $(".mute-video").click(function () {
        if ($("video").prop('muted')) {
            $("video").prop('muted', false);
            $(this).addClass('unmute-video');

        } else {
            $("video").prop('muted', true);
            $(this).removeClass('unmute-video');
        }
    });

    /**
     * Show the poster if the video is not playable
     */
    isAutoplaySupported(function(supported) {
        if (supported) {
            $(".mute-video").show();
            $('video').attr({'autoplay':'true'});
        }else{
            $("video").each(function() {
                /*var poster = $(this).attr('poster-off');
                $(this).attr('poster', poster);*/
                $(this).attr({'autoplay':'false'});
            });
        }
    });

    /**
     * Image Lazyload
     */
    $('.lazy').lazy({
        beforeLoad: function(element){
            fixImageHeight(element);
        }
    });
    $('.lazy-with-loader').lazy({
        beforeLoad: function(element){
            element.addClass('loading');
            fixImageHeight(element);
        },
        afterLoad: function(element) {
            element.removeClass('loading');
        }
    });
    $(window).resize(function() {
        fixImageHeight($('.lazy'));
    });

    function fixImageHeight(element){
        var elH = element.attr('height');
        var elW = element.outerWidth() + 100;
        if ($(window).width() < elW) {
            element.css({ height: 'auto' });
        }
        else {
            element.css({ height: elH });
        }
    }
    /**
     * Materialliste table fix
     */
    materiallisteTable();
    $(window).resize(function() {
        materiallisteTable();
    });
    function materiallisteTable(){
        var tableWidth = $('#Materialliste .contenttable').width();
        $('#Materialliste .contenttable').width(tableWidth - 2);
    }
    /**
     * Slideshow height
     */
    function fixSlideshowHeight() {
        var oW = 1900, oH= 580;
        if($('#slider').hasClass('video-slide-active')){
            var oW = 1855, oH= 870;
        }
        var newW = $(window).width();
        var newH = (newW * oH) / oW;
        var newHcontainers = (newW * oH) / oW;
        var newHW = (newW * oH) / oW;;

        var caption = $('.swiper-slide-active').find('.slider-caption');
        if(caption.length > 0 && $(window).width() < 767){
            var captionH = caption.height();
            newH = newH + captionH;
            newHW =  newHW + captionH + 50;
            newHcontainers = newHcontainers + captionH + 50;
        }
        newH = newH + 'px';
        newHW = newHW + 'px';
        newHcontainers = newHcontainers + 'px';

        if($('#slider').hasClass('video-slide-active')){
            newH = '100%';
            newHW = '100%';
            newHcontainers = '100%';
            //Fix for iPhone 5s
            $('#content').addClass('video-slide-exist');
        } 
        if($(window).width() < 280){
                newH = '100%';
                newHW = '100%';
                newHcontainers = '100%';
        }
        
        if(($(window).width() == 768) || ($(window).width() == 767)){
                newH = '100%';
                newHW = '100%';
                newHcontainers = '100%';
        }
        $("#slider.swiper_wrapper").attr('style', 'height: ' + newH + ' !important');       
        $("#wrapper #slider.swiper_wrapper").attr('style', 'height: ' + newHW + ' !important');
        $(".containers #slider.swiper_wrapper").attr('style', 'height: ' + newHcontainers + ' !important');
    }

    $('.swiper-wrapper').AttributeObserver('style', function(oldValue, newValue){
        fixSlideshowHeight()
    }, 300);

    fixSlideshowHeight();
    $(window).on('resize', function(){
        fixSlideshowHeight();
    });

});


$(window).load(function() {

    /**
     * Show image caption on hover
     */
    function showHoverBoxContentText(){
        //Init

        var maxH = 0;
        if ($(window).width() <= 990){
            $('.box-content.text-inside').closest('.section-link').each(function () {
                containerH = $(this).outerHeight();
                textH = $(this).find('.text-inside').outerHeight(true);
                $(this).find('.text-inside').stop().animate({"top": containerH - textH}, 1000);
            });
        }
        if($(window).width() > 990){
            var headingHighestHeight = 0;
            $('.box-content.text-inside').closest('.section-link').each(function () {
                var headingHeight = $(this).find('.fce-title').height();
                if(headingHeight > headingHighestHeight){
                    headingHighestHeight = headingHeight + 33;
                }
            });
            $('.box-content.text-inside').closest('.section-link').each(function () {
                var headingHeight = $(this).find('.fce-title').height();
                var marginBottom = headingHighestHeight - headingHeight - 22;
                $(this).find('.fce-title').css('margin-bottom', marginBottom);
                var h = $(this).parent('.box-item').outerHeight();
                var h2 = parseInt($(this).parent('.box-item').getStyle('height'));
                if(h > h2){
                    $(this).parent('.box-item').css("min-height", h2);
                }
                if(h > maxH){
                    maxH = h - headingHighestHeight;
                }
                if(h2 <= 240){
                    maxH = h2 - headingHighestHeight;
                }
                $(this).find('.text-inside').stop().animate({"top": maxH}, 1000);

                $(this).mouseover(function(){
                    /*var textHeight = $('.fce-text').outerHeight(true) - ($('.fce-text').outerHeight(true) - $('.fce-text').outerHeight()) / 2 - 5;
                    $(this).find('.text-inside').stop().animate({"top": maxH - textHeight}, 1000);*/
                    var containerH = $(this).outerHeight();
                    var textH = $(this).find('.text-inside').outerHeight(true);
                    $(this).find('.text-inside').stop().animate({"top": containerH - textH}, 1000);
                });
                $(this).mouseout(function(){
                    $(this).find('.text-inside').stop().animate({"top": maxH}, 1500);
                });
            });
        }

        //Text crop
        $('.box-content.text-inside').dotdotdot({
            ellipsis	: '... ',
            wrap		: 'word',
            fallbackToLetter: true,
        });
    }
    showHoverBoxContentText();
    $(window).on('resize', function(){
        showHoverBoxContentText();
    });
    // instance of lazyload is used 
    var lazyLazy = new LazyLoad({
       callback_load: function(el) {
            // ...instantiate a new LazyLoad on it
           showHoverBoxContentText();
        }
    });
});

jQuery.fn.extend({
    // get style attributes that were set on the first element of the jQuery object
    getStyle: function (prop) {
        var elem = this[0];
        var actuallySetStyles = {};
        for (var i = 0; i < elem.style.length; i++) {
            var key = elem.style[i];
            if (prop == key)
                return elem.style[key];
            actuallySetStyles[key] = elem.style[key];
        }
        if (!prop)
            return actuallySetStyles;
    }
});


/****************************************************************
 * Wagner-2214-Integration powermail ======   START   ===========
 *****************************************************************
 * code loads only if the .tx-powermail class exists on a div
 * so hopefully it doesn't load for no purpose on every page
 *****************************************************************/
if ($('.tx-powermail').length > 0) {
    /*
    * Function to add bt-flabels__float to powermail input, floating labels
    */
    (function($) {
        'use strict';
        if ($("form").hasClass("powermail_form")){
            var floatingLabel;
            floatingLabel = function(onload) {
                var $input;
                $input = $(this);
                if (onload) {
                    $.each($('.powermail_fieldwrap'), function(index, value) {
                        var $current_input;
                        $current_input = $(value);
                        if ($current_input.val()) {
                            $current_input.closest('.powermail_fieldwrap').addClass('bt-flabels__float');
                        }
                    });
                }

                setTimeout((function() {
                    if ($input.val()) {
                        $input.closest('.powermail_fieldwrap').addClass('bt-flabels__float');
                    } else {
                        $input.closest('.powermail_fieldwrap').removeClass('bt-flabels__float');
                    }
                }), 1);
            };

            $('.powermail_fieldwrap input[type="text"], input[type="email"], textarea, select, input[type="tel"]').keydown(floatingLabel);
            $('.powermail_fieldwrap input[type="text"], input[type="email"], textarea, select, input[type="tel"]').change(floatingLabel);

            window.addEventListener('load', floatingLabel(true), false);
            $('.powermail_form').parsley().on('form:error', function() {
                $.each(this.fields, function(key, field) {
                    if (field.validationResult !== true) {
                        field.$element.closest('.powermail_fieldwrap').addClass('bt-flabels__error');
                    }
                });
            });

            $('.powermail_form').parsley().on('field:validated', function() {
                if (this.validationResult === true) {
                    this.$element.closest('.powermail_fieldwrap').removeClass('bt-flabels__error');
                } else {
                    this.$element.closest('.powermail_fieldwrap').addClass('bt-flabels__error');
                }
            });
        }
    })(jQuery);
    /*
    * Another small function to make the textarea auro resize
    * made to work only on powermail textarea (.powermail_textarea.form-control)
    */
    $('.powermail_textarea.form-control').each(function () {
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    /*
    * change the input[type=submit] to button, copying the value so as to be modular
    * this is for the main powermail form, the confirmation has different classes
    */
    var powermail_prim_button_class = ".powermail_form .powermail_fieldset .powermail_fieldwrap_type_submit .col-sm-10.col-sm-offset-2 .btn.btn-primary";
    var $powermail_prim_button = $(powermail_prim_button_class);
    var $powermail_button_value = $powermail_prim_button.val();
    $powermail_prim_button.hide();
    $powermail_prim_button.after("<button class='btn btn-primary' disabled='disabled' type='submit'>" + $powermail_button_value + "</button>");

    /*
    * change the input[type=submit] to button, copying the value for modularity
    * this is for the powermail confirmation page, the main form has different classes
    */
    var $powermail_confirm_danger_button = $(".tx-powermail .powermail_confirmation .btn-danger");
    var $powermail_confirm_prim_button = $(".tx-powermail .powermail_confirmation .btn-primary");
    var $powermail_confirm_prim_value = $powermail_confirm_prim_button.val();
    var $powermail_confirm_danger_value = $powermail_confirm_danger_button.val();
    $powermail_confirm_danger_button.hide();
    $powermail_confirm_prim_button.hide();
    $powermail_confirm_danger_button.after("<button data-powermail-form-ajax='confirmation' class='btn btn-danger' type='submit'>" + $powermail_confirm_danger_value + "</button>");
    $powermail_confirm_prim_button.after("<button data-powermail-form-ajax='submit' class='btn btn-primary' type='submit'>" + $powermail_confirm_prim_value + "</button>");

    /*
    * Linking the AGBs and Datenschutz to their respective checkboxes
    * modular function that takes the text in the Title field (in the powermail backend),
    * adds the link from the Description field (powermail backend) to it,
    * adds this linked text to the Options field (powermail backend) text, replacing
    * the word identical to the title.
    * Title field must be identical to text in the options field,
    * description field must not be empty
    */
    $('.powermail_fieldwrap_type_check').each(function() {
        // taking the link from the description field
        var $check_link = $('label', this).attr('title');
        if ($check_link != '' ) {
            // taking the text that it's suppossed to be linked from the title field
            var $placeholder = $('.control-label.col-sm-2', this).text().replace('*', '').trim();
            // putting them together into a link
            var $placeholder_link = '<a href="' + $check_link + '" target="_blank">' + $placeholder + '</a>';
            // small function that takes the text from the options field
            var $check_label = $('.checkbox label', this).contents().filter(function () {
                return this.nodeType === 3;
            }).text();
            // second variable to hold the modified version of the field
            var $check_after = $check_label.replace($placeholder, $placeholder_link);
            // replacing the old text with the new linked text
            $('.checkbox label', this).contents().filter(function () {
                return this.nodeType == 3 && $.trim(this.textContent);
            }).replaceWith($check_after);
        }
    });

    /*
    * set maxlength and minlength for textareas. values taken from the parsley attribute, because powermail.
    * it does not allow users to go over the max anymore, meaning no double labels, also no extra parsley error
    * for too many characters
    */
    $('.powermail_textarea').each(function (){
        var textarea_length = $(this).attr('data-parsley-length').replace(']', '').replace('[', '').replace(' ', '').split(',');
        $(this).attr('minlength', textarea_length[0]).attr('maxlength', textarea_length[1]);
    });

    /*
    * recaptcha disables submit button until resolved and when it expires
    * no resolved recaptcha, no submit button.
    */

    var recaptcha_validation_fix = function (response) {
        $(powermail_prim_button_class).removeAttr('disabled');
    }
    var recaptcha_validation_expired = function (response) {
        $(powermail_prim_button_class).attr('disabled', 'disabled');
    }
    $('.g-recaptcha').attr('data-callback', 'recaptcha_validation_fix').attr('data-expired-callback', 'recaptcha_validation_expired');
}
/****************************************************************
 * Wagner-2214-Integration powermail ==========   END   =========
 *****************************************************************/