var urlaubElement = $("#urlaub");
var urlaubAjaxUrl = urlaubElement.data('urlaubAjaxUrl');
var urlaubListUrl = urlaubElement.data('urlaubListUrl');


$(document).ready(function() {
    $("#split-pane-headline-content").detach().appendTo('#split-pane-headline');
});


var date = new Date();

var urlaubs_jahr = urlaubElement.data('jahr');

$(document).ready(function() {

    highlightClicks();

    $('#urlaubJahr').text(urlaubs_jahr);


    $('#urlaub_prev').click(function() {
        urlaubs_jahr--;
        setUrlaubsjahr(urlaubs_jahr);
    });

    //fc-state-hove
    $('#urlaub_next').click(function() {
        urlaubs_jahr++;
        setUrlaubsjahr(urlaubs_jahr);
    });

    $('#urlaub_refresh').click(function() {
        setUrlaubsjahr(urlaubs_jahr);
    });

    $('#urlaub_prev,#urlaub_next').on('mouseover', function(){
        $(this).addClass('fc-state-hover');
    }).on('mouseout', function(){
        $(this).removeClass('fc-state-hover');
    });


});

function highlightClicks(){
    $( "li.markHighlightinTable").unbind( "click" );

    $( "li.markHighlightinTable" ).click(function() {

        $('tr[data-urlaub-uid]').removeClass('highlight');
        $('tr[data-urlaub-uid="'+$(this).data('urlaub-uid')+'"]').addClass('highlight');
    });
}
function setUrlaubsjahr(jahr){

    $('#urlaubJahr').text(urlaubs_jahr);

    loadUrlaubs(jahr);

}

function loadUrlaubs(jahr){
    console.log('loadUrlaubs('+jahr+')');

    dataTableReload();

    $('#kalenderContent,#userLegendeContent').css('opacity',0.6);
    $('#kalenderContent,#userLegendeContent').css('pointer-events','none');

    var selectAjaxJson = {"tx_dslintranet_urlaubsliste[jahr]":jahr};
    dslIntranetAjaxCall(urlaubListUrl,selectAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
        console.log(data);
        console.log('loaded');

        $('#kalenderContent').html($(data).find('#kalenderContent').html());
        $('#userLegendeContent').html($(data).find('#userLegendeContent').html());
        $('#kalenderContent,#userLegendeContent').css('opacity',1);
        $('#kalenderContent,#userLegendeContent').css('pointer-events','auto');

        highlightClicks();

    });
}



var dataTable = false;

function dataTableReload(){

    dataTable.ajax.url(urlaubAjaxUrl+'&tx_dslintranet_urlaubsliste%5Bswitch%5D=urlaubList&jahr='+urlaubs_jahr).load();
}

function dataTableInit(){
    //return false;

    dataTable = $('#urlaubList').DataTable({


        "dom": '<"top"<"float_left"i>f>rt<"bottom"><"clear">',

        "pageLength": 999,
        "order": [1,'desc'],
        "processing": true,
        "serverSide": true,
        "ajax": urlaubAjaxUrl+'&tx_dslintranet_urlaubsliste%5Bswitch%5D=urlaubList&jahr='+urlaubs_jahr,
        /*"data": function ( d ) {
          return $.extend( {}, d, {
            "jahr": 2017
          } );
        },*/
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "orderable": false,
                "width":'10px'

            },
            {
                "targets": [ 1 ],
                "orderable": true,
                "width":'120px'
            },

            {
                "targets": [ 2 ],
                "visible": true,
                "orderable": false

            },
            {
                "targets": [ 3 ],
                "visible": true,
                "orderable": false,
                "width":'30px'
            },
            {
                "targets": [ 4 ],
                "visible": true,
                "orderable": true,
                "width":'70px'
            },
            {
                "targets": [ 5 ],
                "visible": true,
                "orderable": false,
                "width":'120px'
            }
        ],
        "language": {
            "decimal":        "",
            "emptyTable":     "Keine Daten gefunden",
            "info":           "Zeigt _TOTAL_ Einträge",/*"Zeige _START_ bis _END_ von _TOTAL_ Einträgen",*/
            "infoEmpty":      "Keine Einträge",
            "infoFiltered":   "(gefiltert von _MAX_ Einträgen)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "_MENU_ &nbsp;&nbsp;pro Seite",
            "loadingRecords": "Lädt...",
            "processing":     '<i class="fa fa-cog fa-spin"></i>',
            "search":         '<a class="btn tableBtnSuche" aria-label="Suche"><i class="fa fa-lg fa-search" aria-hidden="true"></i></a><a class="clearFilter"><i class="fa fa-lg fa-times"></i></a>',
            "searchPlaceholder": "Suche",
            "zeroRecords":    "Keine Ergebnisse gefunden",
            "paginate": {
                "first":      "Erste",
                "last":       "Letzte",
                "next":       "Nächste",
                "previous":   "Vorhergehende"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });

    $('#urlaubList_wrapper .clearFilter').on('click', function() {
        setTimeout(function(){
            $('#urlaubList_wrapper input[type="search"]').val('');
            dataTable.search( '' ).draw();
            $('#urlaubList_wrapper .clearFilter').css('opacity',0);
        }, 10);
    });
    $('#urlaubList_wrapper input[type="search"]').keyup(function() {

        if($('#urlaubList_wrapper input[type="search"]').val()){
            $('#urlaubList_wrapper .clearFilter').css('opacity',1);
        } else {
            $('#urlaubList_wrapper .clearFilter').css('opacity',0);
        }
    });
    $('#urlaubList_wrapper .clearFilter').insertAfter('#urlaubList_wrapper input[type="search"]');
}

$(document).ready(function() {

    dataTableInit();

    $('#urlaubList').on( 'draw.dt', function () {


        reInitAjaxCalls();

        $( '[data-urlaub-status="30"]' ).closest('tr').addClass('abgelehnt');
        $( "span[data-urlaub-uid]" ).each(function( index ) {

            $(this).closest('tr').attr('data-urlaub-uid',$(this).data('urlaub-uid'));
            $(this).removeAttr('data-urlaub-uid');
        });
    } ).on( 'processing.dt', function ( e, settings, processing ) {

        if(processing){
            $('#urlaubList').css('opacity',0.6);
            $('#urlaubList').css('pointer-events','none');

        } else {
            $('#urlaubList').css('opacity',1);
            $('#urlaubList').css('pointer-events','auto');
        }
        // $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
    } );

});