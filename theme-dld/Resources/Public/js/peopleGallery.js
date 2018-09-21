$(document).ready(function () {

    $('.description-container a').each(function () {
        $(this).attr("rel", "nofollow")
    })
    $('.media-list article:first-child').addClass(' active');
    $('.thumbnail').on('click', function (e) {
        var href = $(this).siblings(".zoom-fullscreen").attr('href');
        $('.clearfix').removeClass('active');
        $(this).parent().addClass('active');
        $('.big-media-container').show();
        $('.media-gallery-info-box').show();
        $('#ytvid').remove();
        e.preventDefault();
        $('.big-media-container').css("background-image", "url('" + href + "')");
        $('.media-gallery-info-box > .conference-name').text($(this).siblings(".info-box").find(".conference-name").text());
        $('.media-gallery-info-box > .second-line .title').text($(this).siblings(".info-box").find(".title").text());
        $('.media-gallery-info-box > .second-line .speakers').text($(this).siblings(".info-box").find(".speaker").text());
    });

    var galleryid = '.zoom-fullscreen' //Gallery ID
    var buttonid = '.zoombutton' //Button ID


    jQuery(buttonid).on('click', function (e) {
        e.preventDefault()
        jQuery(galleryid + ' img').first().trigger('click')
    })


    $('.playbutton').on('click', function (e) {
        $('.big-media-container').hide();
        $('.media-gallery-info-box').hide();
        var vidid = $('.media-list article.active').data('id');
        $('<div id="video-player-movie-container"></div>').appendTo('.big-media-preloader');
        $('<iframe>', {
            src: 'http://www.youtube.com/embed/' + vidid + '?modestbranding=1&amp;hd=1',
            id: 'ytvid',
            frameborder: 0,
            scrolling: 'no',
        }).appendTo('#video-player-movie-container');
        e.preventDefault()
    });
});
