events = [];
$(document).ready(function () {

    $('#keyword').on('keyup', function (event) {
        event.preventDefault();
        var url = $('#eventsurl').val();
        var keyword = $('#keyword').val();

        var allData = {
            'tx_contactform_feevents[keyword]': keyword
        };

        $.ajax({
            type: 'POST',
            url: url,
            data: allData,
            success: function (data) {

                $(".tx_contactform").html($(data).find('.tx_contactform').html());
                $.each(events, function (key, value) {
                    $(".toexport[value=" + value + "]").prop("checked", true);
                });
            }
        });
    });
});
$(document).on('change', '.toexport', function () {
    if ($(this).is(':checked')) {
        events.push($(this).val());
    }
    else {
        var idx = events.indexOf($(this).val());

        events.splice(idx, 1);

    }

    if (events.length >0) {

        $('#export').prop("disabled",false);
    }
    else {
        $('#export').prop("disabled",true);
    }
});
$(document).on('click', '#export', function () {

    $.ajax({
        url: $('#exporturl').val(),
        data: {'tx_contactform_feevents[events]': events},
        type: 'POST',
        success: function (data) {
            if ($(data).find('#exportid').attr('href')) {
                window.open($(data).find('#exportid').attr('href'));
            }

        }
    });
});


$(function() {
    $('.datepicker').datepicker({
        autoHide: true,
        zIndex: 2048,
        format: 'dd/mm/yyyy'
    });
});