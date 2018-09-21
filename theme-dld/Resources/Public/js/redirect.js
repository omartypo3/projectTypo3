$(document).ready(function () {
    var str = window.location.href;
    var pathArray = window.location.pathname.split('/');
    var segment_1 = pathArray[1];
    var segment_2 = pathArray[2];
    var n = str.includes("mydld");

    //if ((segment_2 != 'invitation')) {
     if (n && segment_2 != '') {
            var res = str.replace("mydld", "conference-application");
            window.location.href = res;
     }
    //}

    if (($("#dldredirect").val() != "1")) {
        $(".tx-femanager .femanager_show .mydld-container").eq(1).removeClass("invitedmsg");

    } else {

        $(".tx-femanager .femanager_show .mydld-container").eq(1).addClass("invitedmsg");


    }
});


