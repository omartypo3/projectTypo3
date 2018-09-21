$(document).ready(function (e) {
    $(".partners-list select").on("change",function (e) {
        $(this).addClass("selected");
    });
    var next = 0;
    var order = 'view';
    $("#videos-search, #company").on("keydown", function (event) {
        if (event.which == 13) {
            next = 0;
            loadAjaxDataYT('view', next);
            next++;
        }
    });
    $("#clear-filters").on("click", function (event) {
        next = 0;
        $('#videos-search').val('');
        $('#conference').val('');
        $('#speaker').val('');
        $('#company').val('');
        $('#category').val('');
        $('#duration').val('');
        loadAjaxDataYT('view', next);
    });
    $("#most_recent").on("click", function (event) {
        next = 0;
        order = 'RECENT';
        loadAjaxDataYT('RECENT', next);
        next++;
    });
    $("#most_viewed").on("click", function (event) {
        next = 0;
        loadAjaxDataYT('view', next);
        next++;
    });
    $("#more-videos").on("click", function (event) {
        next++;
        var controllerpath = $("#uriyt_hidden").val();
        var allData = {
            'tx_dld_dldyoutube[keyword]': $('#videos-search').val(),
            'tx_dld_dldyoutube[conference]': $('#conference').val(),
            'tx_dld_dldyoutube[speaker]': $('#speaker').val(),
            'tx_dld_dldyoutube[speakercompany]': $('#company').val(),
            'tx_dld_dldyoutube[topic]': $('#category').val(),
            'tx_dld_dldyoutube[duration]': $('#duration').val(),
            'tx_dld_dldyoutube[order]': order,
            'tx_dld_dldyoutube[pagecount]': next

        };

        $.ajax({
            type: 'POST',
            url: controllerpath,
            data: allData,
            success: function (data) {

               // $(".youtube-gallery").append($(data).find('.youtube-gallery .video-item'));
                if($("body").hasClass("notification-cc")){
                    console.log("hhhh");
                }else{
                    $(".youtube-gallery").append($(data).find('.youtube-gallery .video-item'));


                }
              if( $(data).find('#more-videos').length ==0){
                  $('#more-videos').hide();
              }
              else {
                      $('#more-videos').show();

              }

            },
        });
    });
    $("#conference, #speaker, #category, #duration  ").change(function () {
        next = 0;
        loadAjaxDataYT('view', next);
        next++;
    });


});


function loadAjaxDataYT(order, next) {
    var controllerpath = $("#uriyt_hidden").val();

    var allData = {
        'tx_dld_dldyoutube[keyword]': $('#videos-search').val(),
        'tx_dld_dldyoutube[conference]': $('#conference').val(),
        'tx_dld_dldyoutube[speaker]': $('#speaker').val(),
        'tx_dld_dldyoutube[speakercompany]': $('#company').val(),
        'tx_dld_dldyoutube[topic]': $('#category').val(),
        'tx_dld_dldyoutube[duration]': $('#duration').val(),
        'tx_dld_dldyoutube[order]': order,
        'tx_dld_dldyoutube[pagecount]': (next)

    }
    $.ajax({
        type: 'POST',
        url: controllerpath,
        data: allData,
        success: function (html) {
            console.log( $(html).find('#uriyt_hidden'));
            if($("body").hasClass("notification-cc")){

            }else{
                $(".youtube-gallery").html($(html).find('.youtube-gallery .video-item '));

            }
            if( $(html).find('#more-videos').length == 0){
                $('#more-videos').hide();
            }
            else {
                $('#more-videos').show();

            }
        }
    });
}