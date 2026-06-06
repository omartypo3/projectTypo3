var hostingElement = $('#hosting');
var ajaxUrl = hostingElement.data('ajaxUrl');

var hoveredHostingGroup = false;
var clearHover = false;

function setHoveredHostingGroup(uid){
    $("#hostingList tbody tr").removeClass('hovered');
    $('#hostingList tbody tr[data-hostinguid="' + uid + '"]').addClass('hovered');
}
function clearHoveredHostingGroup(){
    $("#hostingList tbody tr").removeClass('hovered');

}
function initHostingGroups(){
    $('#hostingList tbody tr').each(function( index ) {

        $(this).attr('data-hostinguid',$(this).find('span.hostingUid').text());
        
        $( this ).hover(
            function() {
                clearTimeout(clearHover);
                if(hoveredHostingGroup!=$(this).data('hostinguid')){
                    //setnewhovergroup
                    hoveredHostingGroup=$(this).data('hostinguid');
                    setHoveredHostingGroup(hoveredHostingGroup);
                }
                
            }, function() {
                clearHover = setTimeout(function(){ clearHoveredHostingGroup(); }, 1000);
            }
        );
            
    });
}

$(document).ready(function() {
    
    
    $('.auftraegeFormFilterSelectpicker').change(function() {
        $(this).parent().addClass('filterHighlighted');
        setFilterNotEmptyClass('.auftraegeFormFilterSelectpicker' );
        activateSubmitButton();
    });
    setFilterNotEmptyClass('.auftraegeFormFilterSelectpicker' );
    
    
    $('#hostingFilterForm').submit(function() {
        
        $('#saveFilter').attr('disabled','disabled');
        
        $('#hostingListAnzahl').html('<span class="ajaxLoading"><i class="fa fa-cog fa-spin"></i></span>');

        $.ajax({
            url: $('#hostingFilterForm').attr('action'),
            type: 'POST',
            data: $('#hostingFilterForm').serialize(),
            success: function(data) {
                
                $('#hostingFilterForm').find('.filterHighlighted').removeClass('filterHighlighted');
                
                $('#hostingListAnzahl').html( $(data).find('#hostingListAnzahl').html() );
                    
                
                dataTableReload();
                return false;
                


            }
        });
        
        return false;
    });


    $("#deleteFilter").click(function() {
        $('#filter_kundens').selectpicker('deselectAll');
        $('#filter_statuss').selectpicker('val', 10);
        checkFilterResetButton();
    });

    checkFilterResetButton();
    function checkFilterResetButton(){

        if(	!$("#filter_kundens").selectpicker('val') && $("#filter_statuss").selectpicker('val') == "10"){
            $("#deleteFilter").hide();		
        } else 	$("#deleteFilter").show();
    }

    function activateSubmitButton(){
        $('#saveFilter').removeAttr('disabled');	
        checkFilterResetButton();
    }
});


    var dataTable = false;

    function dataTableReload(){
    //nutzung wenn filter gesetzt wird

    dataTable.ajax.url(ajaxUrl+'&tx_dslintranet_hostingliste%5Bswitch%5D=hostingList').load();

    }

    function dataTableInit(){
        //return false;
        
        dataTable = $('#hostingList').DataTable({
            
            
            "dom": '<"top"f>rt<"bottom"><"clear">', 			
            
            "pageLength": 999,
            "order": [3,'asc'],
            "processing": true,
            "serverSide": true,
            "ajax": ajaxUrl+'&tx_dslintranet_hostingliste%5Bswitch%5D=hostingList',/*&jahr='+urlaubs_jahr,*/
            /*"data": function ( d ) {
                return $.extend( {}, d, {
                "jahr": 2017
                } );
            },*/
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "orderable": false
                },
                {
                    "targets": [ 1 ],
                    "orderable": false,
                    "width": "90px"
                },
                {
                    "targets": [ 2 ],
                    "orderable": false,
                    "width": "130px"
                },
                {
                    "targets": [ 4 ],
                    "orderable": false,
                    "width": "100px"
                },
                {
                    "targets": [ 5 ],
                    "orderable": false,
                    "width": "50px"
                },
                {
                    "targets": [ 6 ],
                    "orderable": false,
                    "visible": false
                },
                {
                    "targets": [ 7 ],
                    "orderable": false,
                    "width": "50px"
                },
                {
                    "targets": [ 8 ],
                    "orderable": false,
                    "width": "60px"
                },
                {
                    "targets": [ 9 ],
                    "orderable": false,
                    "width": "70px"
                },
                {
                    "targets": [ 10 ],
                    "orderable": false,
                    "width": "40px"
                }
                
            ],
            "language": {
                "decimal":        "",
                "emptyTable":     "Keine Daten gefunden",
                "info":           "Zeigt _TOTAL_ Pakete",/*"Zeige _START_ bis _END_ von _TOTAL_ Einträgen",*/
                "infoEmpty":      "Keine Einträge",
                "infoFiltered":   "(gefiltert von _MAX_ Paketen)",
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
            },
            drawCallback: function () {
                
                
                initHostingGroups();
                
                var api = this.api();
                //$('#'+$(this).attr('id')+' .monatlichSum').text( api.column( 4,  {page:'current'} ).data().sum() );

                // alert( api.column( 6,  {page:'current'} ).data().sum() );
                var summe = parseInt(api.column( 6,  {page:'current'} ).data().sum());
                $('.monatlichSum').text( summe );
                $('.anzahlDomains').text( $('.hostingDomainPreview').length );
                
                $('.anzahlPakete').text( $('.hostingPaketCounter').length );
                $('.anzahlZusatzleistungen').text( $('.zusatzLeistungCounter').length );
                
            
                
                
                
            }
        });

        $('#hostingList_wrapper .clearFilter').on('click', function() {
            setTimeout(function(){ 
            $('#hostingList_wrapper input[type="search"]').val('');
            dataTable.search( '' ).draw();
            $('#hostingList_wrapper .clearFilter').css('opacity',0);
            }, 10);
        }); 
        $('#hostingList_wrapper input[type="search"]').keyup(function() {
            
            if($('#hostingList_wrapper input[type="search"]').val()){
                $('#hostingList_wrapper .clearFilter').css('opacity',1);
            } else {
                $('#hostingList_wrapper .clearFilter').css('opacity',0);
            }
        });
        
        $('#hostingList_wrapper .clearFilter').insertAfter('#hostingList_wrapper input[type="search"]');
    }



    $(document).ready(function() {

    dataTableInit();

    $('#hostingList').on( 'draw.dt', function () {
        reInitAjaxCalls();

    }).on( 'processing.dt', function ( e, settings, processing ) {
        
        if(processing){

            $('#hostingList').css('opacity',0.6);
            $('#hostingList').css('pointer-events','none');
        } else {

            $('#hostingList').css('opacity',1);			
            $('#hostingList').css('pointer-events','auto');			
        }
        
    }).on('preXhr.dt', function ( e, settings, data ) {
        /*platzhalter wegen fluid Javascript Problem*/
    }).on('xhr.dt', function ( e, settings, json, xhr ) {
        /*platzhalter wegen fluid Javascript Problem*/
    });

    });