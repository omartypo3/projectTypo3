limit = 8;
$(document).ready(function () {
    var divID = '#gallery-photos';
    if ($("#gallery-photos:visible").length == 0)
        divID = '#gallery-videos';
    activetab(divID);
    showitems('#gallery-photos');
    $(".gallery-item:not(:has(.gallery__items__more))").filter(":visible").fancybox({
        helpers: {
            overlay: {
                opacity: 0.8,
                css: {'background-color': 'rgba(0,0,0,0.7)'}
            }
        },

    });
    $('#gallery-videos .fancybox-media').on('click', function () {
        $('.fancybox-media').fancybox(
            {
                type: "iframe",
                padding: 0,
                helpers: {
                    overlay: {
                        opacity: 0.8,
                        css: {'background-color': 'rgba(0,0,0,0.7)'}
                    }
                }
            }
        );
    });
});

$('.gallery-item').click(function (e) {
    e.preventDefault();
    //do other stuff when a click happens
});
$(document).on("click", ".gallery__items__more", function (e) {
    e.preventDefault();
    var divID = '#gallery-photos';
    if ($("#gallery-photos:visible").length == 0)
        divID = '#gallery-videos';

    var len = $(divID + " > .gallery-item-container").filter(":hidden").length
    var x = $(divID + " > .gallery-item-container").filter(":visible").length
    $(".gallery__items__more").remove();
    x = x + limit;

    $(divID + ' .gallery-item-container:lt(' + x + ')').show();
    len = len - limit;
    if (len <= limit) {
        $(divID + " > .gallery-item-container:nth-child(" + x + ") .gallery-item").append('<div class="gallery__items__more">+' + len + '</div>');
    } else
        $(divID + " > .gallery-item-container:nth-child(" + x + ") .gallery-item").append('<div class="gallery__items__more">+8</div>');
    if (len < 1)
        $(".gallery__items__more").remove();

    $(".gallery-item:not(:has(.gallery__items__more))").filter(":visible").fancybox({
        helpers: {
            overlay: {
                opacity: 0.8,
                css: {'background-color': 'rgba(0,0,0,0.7)'}
            }
        }
    });
});

$(".tab").on("click", "a", function (e) {
    e.preventDefault();
    var clickedBtnID = $(this).attr('href');
    var divID = clickedBtnID.substring(1, clickedBtnID.length);
    $('.tab > a').removeClass('active');
    $(this).addClass('active');
    $(".tab-content").hide();
    $("#" + divID).show();
    showitems("#" + divID)

});

function showitems(divId) {
    var len = $(divId + " > .gallery-item-container").filter(":hidden").length

    if (len) {
        var x = limit;
        len = len - limit;
        if (len < limit) {
            $(divId + " > .gallery-item-container:nth-child(" + x + ") .gallery-item").append('<div class="gallery__items__more">+' + len + '</div>');
        }
        else {
            $(divId + "> .gallery-item-container:nth-child(" + x + ") .gallery-item").append('<div class="gallery__items__more">+8</div>');
        }
        $(divId + ' .gallery-item-container:lt(' + x + ')').show();
    }


}
function activetab(divID) {
    $('.tab > a').removeClass('active');
    $('a[href="'+divID+'"]').addClass('active');
    $(".tab-content").hide();
    $(divID).show();
    showitems( divID)

}