$(document).ready(function () {
    $('.input-switch').click(function () {
        $(this).parent().children('.inputs').children('input[type="text"]')
            .each(function () {
                if ($(this).is(':visible')) {
                    $(this).hide();
                }
                else {
                    $(this).show();
                }

            });

    });
    var linkUser = '';
    $('.linkit').click(function () {
        linkUser = $(this).parent().find('.personLinkId').val();
        var fullName = $(this).siblings(".vorname").text() + ' ' + $(this).siblings(".name").text();
        $('#personConfrim').html(fullName);
        $('.toDelete--wrapper').show();
    });
    $('#bt_linkuser').click(function () {
        window.location.href = linkUser;
    });
    var linkevent = '';
    $('.deleteTermin').click(function () {
        linkevent = $('#deleteeventlink').val();
        $('#confirmMessage').show();
    });
    $('#bt_confirmevent').click(function () {
        window.location.href = linkevent;
    });
    $('#bt_cancelevent').click(function () {
        $('#confirmMessage').hide();
    });
    var downloadid = '';
    var downloaddelete = 0;
    $('body').on('click', '.removedownload-start', function () {
        var container = $(this).parents('li[class^="docsElemnt_"]');
        if (container.find(' input[id^="deleted_"]').length > 0) {
            //show modal
            downloadid = container.attr('class');
            downloaddelete = 1;
            $('#confirmMessage').show();
        } else {
            if (container.find('input[name="tx_faginstitutionmanagement_nextsteplogin[institution][document][]"]').length > 0) {
                // show modal
                if (container.find('input[name="tx_faginstitutionmanagement_nextsteplogin[institution][document][]"]').val() != "") {
                    downloadid = container.attr('class');
                    $('#confirmMessage').show();
                }
                else {
                    container.remove();
                }
            }
        }
    });

    $('#bt_canceld').click(function () {
        $('#confirmMessage').hide();
    });
    $('#bt_confirmdownload').click(function () {
        if (downloaddelete === 1) {
            $('.' + downloadid).find(' input[id^="deleted_"]').val("1");
            $('.' + downloadid).remove();
            $('#confirmMessage').hide();
        }
        if (downloaddelete === 0) {
            $('.' + downloadid).remove();
            $('#confirmMessage').hide();

        }
    });
    $('#opt_1294_0').change(function(){
        if($("#opt_1294_0").is(':checked')){
            $("#opt_1294_0").val("1");
        }else{
            $("#opt_1294_0").val("0");
        }
    });

    $('.verwalter').each(function(){
        var ver = $(this);
        var spanId;
        $(this).find(".sp-admin-right").each(function(){
            spanId = $(this).data("identar")
            if(ver.find('[data-identar='+spanId+']').length > 1) {
                console.log(spanId, ver.find('[data-identar='+spanId+']').length);
                ver.find('[data-identar='+spanId+']').not(':first-child').hide();
            }
        });
    });
   
  //  }

});
