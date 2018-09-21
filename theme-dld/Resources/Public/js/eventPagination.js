$(document).ready(function (e) {
    // var url =window.location.href;
    // if(url.search('#archive') > -1) {
    //     $('html, body').animate({
    //         scrollTop: $("#archive").offset().top - 100
    //     }, 0);
    // }
        var max = $('#showmore').attr("data-attr-max-page");
    if ( max <= 1) {
        $('#showmore').hide();
    }else {
        $('#showmore').click(function (e) {
            e.preventDefault();
           var next = $('#showmore').attr("data-attr-next-page"),
                max = $('#showmore').attr("data-attr-max-page"),
                city = $('#showmore').attr("data-attr-city");
            var controllerpath = $("#uri_hiddekpn").val();
            $.ajax({
                type: "POST",
                url: controllerpath,
                data: {'tx_dld_dldfront[offset]': (next-1), 'tx_dld_dldfront[city]': city},
                success: function (data) {
                    $('.mytest').append($(data).find('#conf'));
                    $('#showmore').attr("data-attr-next-page", ++next);
                    if (next > max) {
                        $('#showmore').hide();
                    }
                }
            });
        });
    }




});
//
// $(".grey").click(function(e) {
//     var url =window.location.href;
//     var href = $(this).attr('href');
//     if(href.search('#archive') > -1) {
//     if(url.search('#archive') > -1) {
//         e.preventDefault()
//     }
//         $('html, body').animate({
//             scrollTop: $("#archive").offset().top - 100
//         }, 0);
//     }
// });