events = [];
$(document).ready(function () {

    $('#psearch').on('submit', function (event) {
        event.preventDefault();
        var url = $('#urlParticipants').val();
        var keyword = $('#searchParticipants').val();

        var allData = {
            'tx_contactform_fecontactform[keyword]': keyword
        };
        if (keyword) {
            $.ajax({
                type: 'POST',
                url: url,
                data: allData,
                cache: false,
                success: function (data) {
                    $(".content").html($(data).find('#participants').html());
                },
            });

        }
    });
});

