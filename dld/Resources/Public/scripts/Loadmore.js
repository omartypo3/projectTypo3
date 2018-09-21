$(function () {
    $(".speaker-item").slice(0, 8).addClass('display');
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".speaker-item:hidden").slice(0, 8).addClass('display');
        if ($(".speaker-item:hidden").length == 0) {
            $("#load").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
});

$('a[href=#top]').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 600);
    return false;
});

$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('.totop a').fadeIn();
    } else {
        $('.totop a').fadeOut();
    }
});
  
  
  
