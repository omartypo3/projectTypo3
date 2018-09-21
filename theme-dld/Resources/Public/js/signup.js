$(document).ready(function () {


    if ($(document).find("#user-not-found").length > 0) {
        $.session.set('popup-unf', 'true');
    } else if ($(document).find("#user-found").length > 0) {
        $.session.set('popup-uf', 'true');
    }

    if (window.location.href.indexOf("/mydld/?tx_felogin_pi1%5Bforgot%5D=1") > -1) {
        window.location.href = window.location.origin;
    }
    if (window.location.href.indexOf("/mydld/popup/?tx_felogin_pi1%5Bforgot%5D=1") > -1) {
        window.location.href = window.location.origin;
    }
    $("#registration-success").on("hidden.bs.modal", function () {
        location.replace(window.location.origin);
    });
    $("#submit-login").on("click", function (e) {
        $('#user1').val($('#user').val());
        $('#pass1').val($('#pass').val());

    });

    if (window.location.pathname == '/') {

        if ($.session.get('popup-uf') == "true") {

            $('#user-found-popup').modal({backdrop: 'static', keyboard: false});
            $.session.remove('popup-uf');
        }
        if ($.session.get('popup-unf') == "true") {
            $('#user-not-found-popup').modal({backdrop: 'static', keyboard: false});
            $.session.remove('popup-unf');
        }

    }

    $(".login").on("click", function (e) {
        e.preventDefault();
        var href = $(".login").attr('href');

        if(typeof href !== typeof undefined && href !== false){
            $("#sign-up-popup").empty();
        $.get(href, function (data) {
            $("#sign-up-popup ").html($(data).find(".tx-felogin-pi1 #sign-up-popup .modal-dialog"));

        });
        }
        $('#sign-up-popup').modal({backdrop: 'static', keyboard: false})
    });
    $('body').on("click", ".open-password-reminder", function (e) {
        e.preventDefault();
        $('#sign-up-popup').modal('hide');
        if (window.location.pathname == '/') {
            var href = $(this).find("a").attr('href');
        }
        else {
            var href = $("#forget-pwd").find("a").attr('href');
        }
        $("#forget-popup .modal-body").empty();
        $.get(href, function (data) {
            $("#forget-popup .modal-body").append($(data).find(".tx-felogin-pi1"));

        });
        $('#forget-popup').modal({backdrop: 'static', keyboard: false})
    });

    $(".signin").on("click", function () {
        window.top.location.href = window.top.location.origin+"/sign-up/";
    });
    $(".flash-close").on("click", function () {
        $('#complete-profile').modal('hide');
    });
    $(".popup-close").on("click", function () {
        $('#complete-profile').modal('hide');
    });
    $(".femanager_edit #femanager_field_submit").on("click", function () {
        $.session.set('popup-upc', 'true');
    });
    if ($(document).find(".profile-completed").length > 0 &&  $.session.get('popup-upc') == 'true') {
        $.session.remove('popup-upc');
        $('#complete-profile').modal({backdrop: 'static', keyboard: false})
    }
});
$(window).on('load', function () {
    if ($(document).find("#worng-password").length > 0) {
        // $('#sign-up-failed').modal('show');
        $('#sign-up-failed').modal({backdrop: 'static', keyboard: false})
    }
    if ($(".femanager_flashmessages").length > 0) {
        $('#registration-success').modal('show');
        $(".femanager_flashmessages").hide();
    }

});