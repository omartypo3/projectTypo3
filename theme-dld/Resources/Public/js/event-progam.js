$(document).ready(function () {
    var date = $(".program-dates").find(".active").attr('id');
   /*
    if(date!=''){
        date = date.substring(4, date.length);
    }*/
    $(".day-schedule").hide();
    $("#" + date).show();
    $(this).find('table').each(function () {
        var table = $(this).find('tbody');
        var starttime = [];
        var tdl = table.find("tr:first td").length - 1;
        table.find('tr').each(function () {
            var tds = $(this).find('td'),
                productId = tds.eq(0).text();
            starttime.push($.trim(productId));
        });

        table.find('tr').each(function () {
            var tds = $(this).find('td');
            for (var i = 1; i < tdl; i++) {
                var td = tds.eq(i);
                var start = td.attr("data-attr-starttime"),
                    end = td.attr("data-attr-endtime");
                if (!td.hasClass('empty')) {
                    var startindex = $.inArray(start, starttime);
                    var endindex = $.inArray(end, starttime);
                    var rowsp;
                    if (endindex == -1) {
                        rowsp = starttime.length - startindex;
                    }
                    else {
                        rowsp = endindex - startindex;
                    }
                    td.attr('rowspan', rowsp);
                    if (rowsp > 1) {
                       var x=1;
                        var next = td.parent('tr').nextAll();
                        if (next) {
                            next.each(function () {

                                if(x==rowsp) {   return false;}
                                if ($(this).find('td').eq(i).hasClass('empty')) {
                                    $(this).find('td').eq(i).remove();
                                }
                                x++
                            });
                        }
                    }
                }
            }
        });
    });

});
$(document).on("click", ".program-day", function () {
    var clickedBtnID = $(this).attr('id');
    var tableID = clickedBtnID.substring(4, clickedBtnID.length);
    $('.program-day').removeClass('active');
    $("#" + clickedBtnID).addClass('active');
    $(".day-schedule").hide();
    $("#" + tableID).show();

});
