// JavaScript Document

 $(document).ready(function() {

	//alert('test');
	 
	 $('.kundenFormFilterSelectpicker').change(function() {
		$(this).parent().addClass('filterHighlighted');
		setFilterNotEmptyClass('.kundenFormFilterSelectpicker' );
		activateSubmitButton();
	});

	setFilterNotEmptyClass('.kundenFormFilterSelectpicker' );
	 
	 $('#kundenFilterForm').submit(function() {
		 
		 $('#saveFilter').attr('disabled','disabled');
		 $('#kundenListAnzahl').html('<span class="ajaxLoading"><i class="fa fa-cog fa-spin"></i></span>');
		 
		 
		$('#kundenList').css('opacity',0.6);
		$('#kundenList').css('pointer-events','none');
			
		
		
		
		 
		 
		 $.ajax({
                url: $('#kundenFilterForm').attr('action'),
                type: 'POST',
                data: $('#kundenFilterForm').serialize(),
                success: function(data) {
					
					console.log(data);
					
					$('#kundenFilterForm').find('.filterHighlighted').removeClass('filterHighlighted');
					//dataJson = JSON.parse(data);
					console.log('content:');
					
					console.log('--');
					var dataJson = JSON.parse($(data).find('textarea#resultJson').val());
					
					$('#kundenListAnzahl').html( '('+dataJson['found']+')' );
					
					
					$('#kundenFilterForm').appendTo('#kundenListFilter');
					$('#tableLegende').appendTo('#tableLegendeWrapper');
					
					dataTableKundenList.destroy();
					$('#kundenList').replaceWith(	$(data).find('#content').html() );
					//$('#kundenList').replaceWith(	$($(data).find('#content').html()) );
					dataTableKundenListInit();
					reInitAjaxCalls();
					
					$('#kundenList').css('opacity',1);			
					$('#kundenList').css('pointer-events','auto');			
					
					//dataTableReload();
					return false;

                }
            });
		 
		 console.log('submit');
		 	return false;
	 });
	 
	
	$("#deleteFilter").click(function() {
		$('#filter_aktiv').selectpicker('deselectAll');
		//$('#filter_statuss').selectpicker('val', 10);
		checkFilterResetButton();
	}); 
	 
	checkFilterResetButton();
	function checkFilterResetButton(){

		if(	!$("#filter_aktiv").selectpicker('val') && !$("#filter_login").selectpicker('val')){/* && $("#filter_statuss").selectpicker('val') == "10"*/
			$("#deleteFilter").hide();		
		} else 	$("#deleteFilter").show();
	}

	function activateSubmitButton(){
		$('#saveFilter').removeAttr('disabled');	
		checkFilterResetButton();
	}

	 
 });



/*Datatable*/

var dataTableKundenList = false;
	
$(document).ready(function() {
	dataTableKundenListInit();
});

function dataTableKundenListInit(){


	dataTableKundenList = $('#kundenList').DataTable({


		"rowCallback": function( row, data, index ) {
			$(row).attr('id','kundenListKunde_'+$(row).find("[data-table-callback-id]").data('table-callback-id'));
		},
		"dom": '<"row"<"col-sm-6"<"#kundenListFormWrapper">><"col-sm-6"f>>  <"row"<"col-sm-12"rt>><"row"<"col-sm-3"i><"col-sm-9"<"#kundenListLegendeWrapper">>>', 
		"order": [[ 2, "asc" ]],
		"columnDefs": [
			{
				"targets": [ 0 ],
				"width":'20px'
			},{
				"targets": [ 1 ],
				"width":'40px'
			},{
				"targets": [ 3 ],
				"width":'220px'
			},{
				"targets": [ 4 ],
				"width":'120px'
			},{
				"targets": [ 5,6,7,8,9 ],
				"width":'20px'
			},{
				"targets": [ 10 ],

				"width":'20px'
			},{
				"targets": [ 11 ],
				"orderable": false,
				"width":'185px'
			}
		],
		paging: false,
		"language": {
			"decimal":        "",
			"emptyTable":     "Keine Daten gefunden",
			"info":           "_TOTAL_ Kundeneinträge gefunden",
			"infoEmpty":      "Zeige 0 bis 0 von 0 Einträgen",
			"infoFiltered":   " von _MAX_ (gefiltert)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Zeige _MENU_ Einträge pro Seite",
			"loadingRecords": "Lädt...",
			"processing":     "Processing...",
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

	$('#kundenList_wrapper .clearFilter').on('click', function() {
	  setTimeout(function(){ 
		$('#kundenList_wrapper input[type="search"]').val('');
		dataTableKundenList.search( '' ).draw();
		$('#kundenList_wrapper .clearFilter').css('opacity',0);
	  }, 10);
	}); 
	$('#kundenList_wrapper input[type="search"]').keyup(function() {

		if($('#kundenList_wrapper input[type="search"]').val()){
			$('#kundenList_wrapper .clearFilter').css('opacity',1);
		} else {
			$('#kundenList_wrapper .clearFilter').css('opacity',0);
		}
	});
	$('#kundenList_wrapper .clearFilter').insertAfter('#kundenList_wrapper input[type="search"]');	
	
	$('#kundenFilterForm').appendTo('#kundenListFormWrapper');
	$('#tableLegende').appendTo('#kundenListLegendeWrapper');
	

}
