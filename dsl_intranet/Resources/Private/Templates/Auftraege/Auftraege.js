var auftraege = $('#auftraege');
var auftraegeListOrder = auftraege.data('order').split(",");

if(auftraegeListOrder) {
    auftraegeListOrder[0] = parseInt(auftraegeListOrder[0]);
    auftraegeListOrder[1] = auftraegeListOrder[1].replace(/['"]+/g, '');
}

var dataTable = false;

function dataTableReload() {
    $('#auftraegeList').DataTable().ajax.reload();
}

function dataTableInit() {
    console.log(auftraegeListOrder);
    console.log(auftraegeAjaxUrl);
    dataTable = $('#auftraegeList').on('xhr.dt', function ( e, settings, json, xhr ) {

        if(!json) {
            $('#page-top').remove();

            setTimeout(function(){ window.top.location.reload(); }, 10000);
            return false;
        }

    }).on( 'init.dt', function () {
        $('#filterGroupContent').contents().appendTo('#filterGroup');
        $('#filterGroupContent').remove();
    }).DataTable({
        "lengthMenu": [ [50, 100, -1], [50, 100, "Alle"] ],
        "pageLength": 100,
        "order": [auftraegeListOrder],
        "dom": '<"row"<"col-sm-6"l><"col-sm-6 inlineBlockRight"f<"#filterGroup">>><"row"<"col-sm-12"rt>><"row"<"col-sm-5"i><"col-sm-7"p>>',
        "processing": true,
        "serverSide": true,
        "ajax": auftraegeAjaxUrl+'&tx_dslintranet_auftragsliste%5Bswitch%5D=auftraegeList',


        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(9, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    console.log(group);
                    if (last || group != '') {//keinem Projekt zugeordnet
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="10">' + group + '</td></tr>' /* style="background-color:rgba(51, 51, 51,0.6) !important;color:#fff;"*/
                        );
                    }

                    last = group;
                }
            } );
        },

        "columnDefs": [
            {
                "targets": [ 0 ],
                "searchable": false,
                "orderable": false,
                "width": "40px"
            },
            {
                "targets": [ 1 ],
                "orderable": true,
                "width": "45px"
            },
            {
                "targets": [ 2 ],
                "visible": true,
                "searchable": true,
                "width": "20px"

            },

            {
                "targets": [ 3 ],
                "orderable": true,


            },
            {
                "targets": [ 4 ],
                "orderable": true,
                "width": "90px"
            },

            {
                "targets": [ 5 ],
                "orderable": false,
                "width": "30px"
            },
            {
                "targets": [ 6 ],
                "width": "80px",
                "orderable": false,

            },
            {
                "targets": [ 7 ],
                "orderable": true,
                "width": "165px"
            },
            {
                "targets": [ 8 ],
                "orderable": false,
                "width": "88px"
            },
            {
                "targets": [ 9 ],
                "visible": false,
                "searchable": true,
            }
        ],
        "language": {
            "decimal":        "",
            "emptyTable":     "Keine Daten gefunden",
            "info":           "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
            "infoEmpty":      "Zeige 0 bis 0 von 0 Einträgen",
            "infoFiltered":   "(gefiltert von _MAX_ Einträgen)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "_MENU_ &nbsp;&nbsp;pro Seite",
            "loadingRecords": "Lädt...",
            "processing":     '<i class="fa fa-cog fa-spin"></i>',
            "search":         '<a class="btn tableBtnSuche" aria-label="Suche"><i class="bb-search bb-lg" aria-hidden="true"></i></a><a class="clearFilter"><i class="bb-times bb-lg"></i></a>',
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

    $('#auftraegeList_wrapper .clearFilter').on('click', function() {
        setTimeout(function(){
            $('#auftraegeList_wrapper input[type="search"]').val('');
            dataTable.search( '' ).draw();
            $('#auftraegeList_wrapper .clearFilter').css('opacity',0);
        }, 10);
    });
    $('#auftraegeList_wrapper input[type="search"]').keyup(function() {

        if($('#auftraegeList_wrapper input[type="search"]').val()){
            $('#auftraegeList_wrapper .clearFilter').css('opacity',1);
        } else {
            $('#auftraegeList_wrapper .clearFilter').css('opacity',0);
        }
    });

    $('#auftraegeList_wrapper .clearFilter').insertAfter('#auftraegeList_wrapper input[type="search"]');

}



function activateSubmitButton(){
//console.log('ion activateSubmitButton()');
    $('#saveFilter').removeAttr('disabled');
    checkFilterResetButton();
}
function checkFilterResetButton(){



    var selectpickerJoin = '';
    if($("#filter_statuss").selectpicker('val')) selectpickerJoin = $("#filter_statuss").selectpicker('val').join(',');

    if(	!$("#filter_favoriten").prop( "checked") &&

        !$("#filter_prioritaets").selectpicker('val') &&
        !$("#filter_kundens").selectpicker('val') &&
        !$("#filter_auftragsartens").selectpicker('val') &&
        !$("#filter_mitarbeiters").selectpicker('val') &&

        selectpickerJoin == "10,20,30,40,50,60"){

        $("#deleteFilter").hide();

    } else 	$("#deleteFilter").show();
}

$(document).ready(function() {

   // dataTableInit(auftraegeAjaxUrl);
    dataTableInit();
   //console.log(auftraegeAjaxUrl);
	

    $('#auftraegeList').on( 'draw.dt', function () {


        reInitAjaxCalls();
        initDraggableAuftraege();
    } ).on( 'processing.dt', function ( e, settings, processing ) {

        if(processing){
            $('#auftraegeList').css('opacity',0.6);
            $('#auftraegeList').css('pointer-events','none');

        } else {
            $('#auftraegeList').css('opacity',1);
            $('#auftraegeList').css('pointer-events','auto');
        }

    } );




    $('.auftraegeFormFilterSelectpicker').change(function() {
        $(this).parent().addClass('filterHighlighted');
        setFilterNotEmptyClass('.auftraegeFormFilterSelectpicker' );

        activateSubmitButton();
    });
    setFilterNotEmptyClass('.auftraegeFormFilterSelectpicker' );





    $('#auftraegeFilterForm').submit(function() {
        //console.log('#saveFilter set to disabled in submit before');
        $('#saveFilter').attr('disabled','disabled');
        //console.log('#saveFilter set to disabled in submit after');


        setFavoritenButtonStatus();

        $('#auftraegeListAnzahl').html('<span class="ajaxLoading"><i class="fa fa-cog fa-spin"></i></span>');
        $('#auftraegeListFavoritenAnzahl').html('<span class="ajaxLoading"><i class="fa fa-cog fa-spin"></i></span>');




        $.ajax({
            url: $('#auftraegeFilterForm').attr('action'),
            type: 'POST',
            data: $('#auftraegeFilterForm').serialize(),
            success: function(data) {

                $('#auftraegeFilterForm').find('.filterHighlighted').removeClass('filterHighlighted');

                dataJson = JSON.parse(data);


                $('#auftraegeListAnzahl').html( '('+dataJson['found']+')' );
                $('#auftraegeListFavoritenAnzahl').html( '('+dataJson['foundFavoriten']+')' );


                dataTableReload();
                return false;




            }
        });

        return false;
    });



    $("#deleteFilter").click(function() {

        $('#filter_prioritaets').selectpicker('deselectAll');
        $('#filter_kundens option').removeAttr('selected');
        $('#filter_kundens').selectpicker('deselectAll');
        $("#filter_auftragsartens").selectpicker("deselectAll");
        $("#filter_mitarbeiters").selectpicker("deselectAll");


//		$("#filter_statuss").multipleSelect("setSelects", [20,30,40,50,60]);
        $('#filter_statuss').selectpicker('val', [10,20,30,40,50,60]);

        $("#filter_favoriten").prop( "checked", '' );

        $('#favoritenFilter').removeAttr('disabled');

        checkFilterResetButton();

        //return false;
    });

    $('#saveFilter').attr('disabled','disabled');


    checkFilterResetButton();


    /*Änderung der Alles Auswählen Funktion beim filter status*/
    $('#filter_statuss').prev().find('button.actions-btn.bs-select-all').click(function() {
        $('#filter_statuss').selectpicker('val', [10,20,30,40,50,60]);

        checkFilterResetButton();
        activateSubmitButton();

        return false;
    });



    $('#filter_statuss').prev().find('ul.dropdown-menu li').unbind( "dblclick" );
    $('#filter_statuss').prev().find('ul.dropdown-menu li').dblclick(function(e) {




        tmpIndex = $(this).data('original-index')+1;
        $('#filter_statuss').selectpicker('val', [$('#filter_statuss option:nth-child('+tmpIndex+')').val()]);

        checkFilterResetButton();
        activateSubmitButton();

        return false;

    });


});




$( document ).ready(function() {

    if($("#filter_favoriten").prop( "checked")) {
        $("#favoritenFilter").attr('disabled','disabled');
        activateSubmitButton();
    }

    $( "#favoritenFilter" ).bind( "click", function() {
        $("#filter_favoriten").prop( "checked", true );
        $('#auftraegeFilterForm').submit();
    });
    $("#saveFilter").click(function() {
        $("#filter_favoriten").prop( "checked", false );
        $('#favoritenFilter').removeAttr('disabled');
    });
	
	if($(".toggleAblage").data("ablage") == '1'){
		$(".bb-star-empty").hide();
		$(".bb-star-filled").show();
	}else{
		$(".bb-star-empty").show();
		$(".bb-star-filled").hide();
	}
});


function setFavoritenButtonStatus(){
    if($("#filter_favoriten").prop( "checked")){
        $("#favoritenFilter").attr('disabled','disabled');
        activateSubmitButton();
    } else {
        $("#favoritenFilter").removeAttr('disabled');
    }
}


$( "#printDataTable" ).bind( "click", function() {

    var win=null;

    win = window.open();
    self.focus();

    win.document.open();

    win.document.write('<'+'html'+'><'+'head'+'>');
    win.document.write('<title>DSL Aufträge</title>');

    win.document.write('<'+'style'+'>');

    win.document.write('body, th, td { font-family: Verdana; font-size: 8pt;text-align:left;}  .clear {clear: both;}');
    win.document.write('table {border:1px solid #000; border-bottom:0px; }');
    win.document.write('table th { background-color: #d8d8d8;}tr:nth-child(even) {background: #f1f1f1}');
    win.document.write('th, td { padding: 3px; border-bottom: 1px solid #000;border-left: 0.25 solid #adadad;} th:first-child, td:first-child {border-left:0px}');
    win.document.write('a{text-decoration:none;color:inherit;}');
    win.document.write('ul.kommalist,ul.kommalist li{ padding:0px;margin:0px;list-style-type:none;display:inline; }');
    win.document.write('ul.kommalist li:not(:first-child):before { content: "," " "; }');
    win.document.write('.hidden,.bootstrap-select .dropdown-menu,.bootstrap-select .selectpicker{display:none;} .bootstrap-select button{width:100%;}');
    win.document.write('#auftraegeList td:last-child,#auftraegeList td:first-child,#auftraegeList th:last-child,#auftraegeList th:first-child { display:none; }');

    win.document.write('ul.spacerlist,ul.spacerlist li,ul.kommalist,ul.kommalist li,ul.buttonlist,ul.buttonlist li{padding:0px;margin:0px;list-style-type:none;display:inline;} ');
    win.document.write('ul.kommalist li:not(:first-child):before { content: "," " "; } ');

    var content = $("#auftraegeList").parent();
    content.find('a').attr('href','#');

    win.document.write('<'+'/'+'style'+'><'+'/'+'head'+'><'+'body'+'>');
    win.document.write(content.html());
    win.document.write('<'+'p'+'>');
    win.document.write('Aufträge // https://intranet.dsl-factory.de // '+new Date().toLocaleString()+' Uhr');
    win.document.write('<'+'/'+'p'+'>');
    win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
    win.document.close();
    win.print();


});