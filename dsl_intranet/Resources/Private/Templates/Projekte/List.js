var projekteElement = $('#projekte');
var agenturvertraegeCheckFileAjaxUrl = projekteElement.data('agenturvertraegeCheckFileAjaxUrl');

var projekteAjaxUrl = projekteElement.data('ajaxUrl');
var projekteShowUrl = projekteElement.data('showUrl');

var chartProjekteArr = new Object();
var chartProjekteJahrArr = new Object();
var chartProjekteDiagrammArr = new Object();

/*Funkctionen für das Anlegen / Editieren von Agenturverträgen*/
function initProjekteNewEditForm(){
	
	$('.validator_required').attr('required','required');

	
	$('.fullDatePicker').datetimepicker({
		locale: 'de',
		sideBySide: true,
		showTodayButton: true,
		showClear: true,
		showClose: true,
		toolbarPlacement: 'bottom',
		format: 'DD.MM.YYYY'
		
	});
	
	$( $(".fullDatePicker") ).each(function( index ) {
	  if($(this).find("input").val()) $(this).datetimepicker('show').datetimepicker('hide');
	});


	
	$('.selectpickerFormular').selectpicker().change(function() {
		if($(this).hasClass('validator_required')) checkSelectPicker($(this).attr('id'));

	});

	
	$('.animated').autosize({append: "\n"});
	

	/*formular init*/
	$( "#projekteCreateForm button.confirm,#projekteEditForm button.confirm" ).click(function() {
		checkSelectPicker('editKunde');
	});

	$.validator.messages.required = '<i class="fa fa-exclamation-circle"></i>';
	
	
	$(".preisMonatlich").TouchSpin({
		max: 99999,
		decimals: 2,
		prefix: '€',
		prefix_extraclass: 'input-sm',
		buttondown_class: 'hidden',
		buttonup_class: 'hidden',
		step: 5,
		forcestepdivisibility: 'none'
	}).change(function() {
		

		var value = $(this).val();

		if(value){
			value = parseFloat(value.replace(',','.')).toFixed(2);
		}

		if(value>0){
			$(this).val(value);
		} else {
			$(this).val('');
		}
		$('#agenturvertragFormularStundensatz').text(calcStundensatz($(this).val(),$(".stundenMonatlich").val()));
		
		

	}).focus(function() { $(this).select() });
	$(".preisMonatlich").trigger('change');
	
	$(".stundenMonatlich").TouchSpin({
		max: 99999,
		decimals: 2,
		prefix: 'h',
		prefix_extraclass: 'input-sm',
		buttondown_class: 'hidden',
		buttonup_class: 'hidden',
		step: 5,
		forcestepdivisibility: 'none'
	}).change(function() {
	

		var value = $(this).val();

		if(value){
			value = parseFloat(value.replace(',','.')).toFixed(2);
		}

		if(value>0){
			$(this).val(value);
		} else {
			$(this).val('');
		}
		
		
		$('#agenturvertragFormularStundensatz').text(calcStundensatz($(".preisMonatlich").val(),$(this).val()));

	}).focus(function() { $(this).select() });
	$(".stundenMonatlich").trigger('change');
	
	
	$(".preisMehraufwandStunde").TouchSpin({
		max: 99999,
		decimals: 2,
		prefix: '€',
		prefix_extraclass: 'input-sm',
		buttondown_class: 'hidden',
		buttonup_class: 'hidden',
		step: 5,
		forcestepdivisibility: 'none'
	}).change(function() {
		
		var value = $(this).val();

		if(value){
			value = parseFloat(value.replace(',','.')).toFixed(2);
		}

		if(value>0){
			$(this).val(value);
		} else {
			$(this).val('');
		}
		

	}).focus(function() { $(this).select() });
	$(".preisMehraufwandStunde").trigger('change');
	
	
	
	$('#projekteCreateForm').validate({
		invalidHandler: function(event, validator) { validateFormInvalidHandler(validator); },
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		ignore: ':hidden:not(".validator_required")', // Tells the validator to check the hidden select */
		errorClass: 'invalid',
		submitHandler: function(form) {


			var formData = new FormData();
			
			var	fileTypeError = false;
			
			files    = $('#projekteCreateForm').find('#fileUploadDateien')[0].files;
			if(files.length != 0) {
				$.each(files, function(i, file) {

					if(file["type"] != 'application/pdf' ) {
						fileTypeError = true;
					}

					formData.append('tx_dslintranet_projektliste[projekte][vertrag]', file);


				});
			} 

			if(fileTypeError) {
				
				$('.fileUploadTypen .required').removeClass('hidden');
				return false;
			} else {
				$('.fileUploadTypen .required').addClass('hidden');
			}


			params  = $('#projekteCreateForm').serializeArray();
			$.each(params, function(i, val) {

				formData.append(val.name, val.value);
			});

			validateFormInvalidHandlerReset();
			$('#projekteCreateForm').addClass('formSaves');

			$.ajax({
				url: $('#projekteCreateForm').attr('action'),
				type: 'POST',
				data: formData,/*$('#auftraegeCreateForm').serialize(),*/
				contentType: false,
				processData: false,
				success: function(data) {

					$.colorbox.close();
					
					var dataJson = JSON.parse($(data).find('textarea#resultJson').val());

					targetSelector = $(data).find('*[data-projekt-target-selector]').attr('data-projekt-target-selector');
					console.log('targetSelector: '+targetSelector);
					console.log('dataJson.newUid: '+dataJson.newUid);
					console.log('findindata: '+"tbody"+targetSelector+dataJson.newUid);

					$(targetSelector).find('table').first().prepend( $(data).find("tbody#projektList"+dataJson.newUid).prop('outerHTML')  );

					initProjektPanelAgenturvertraege();
					reInitAjaxCalls();
					
					$("#projekteAccordion #projektList"+dataJson.newUid+" a.panel-heading").click();
					
					

				}
			});

		}
	});

	console.log('projekteEditForm edit!!! init!!');
	$('#projekteEditForm').validate({
		invalidHandler: function(event, validator) { validateFormInvalidHandler(validator); },
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		ignore: ':hidden:not(".validator_required")', // Tells the validator to check the hidden select */
		errorClass: 'invalid',
		submitHandler: function(form) {

			
			var formData = new FormData();

			var	fileTypeError = false;
			
			files    = $('#projekteEditForm').find('#fileUploadDateien')[0].files;
			if(files.length != 0) {
				$.each(files, function(i, file) {

					if(file["type"] != 'application/pdf' ) {
						fileTypeError = true;
					}

					formData.append('tx_dslintranet_projektliste[projekte][vertrag]', file);


				});
			} 

			if(fileTypeError) {

				$('.fileUploadTypen .required').removeClass('hidden');
				return false;
			} else {
				$('.fileUploadTypen .required').addClass('hidden');
			}

			params  = $('#projekteEditForm').serializeArray();
			$.each(params, function(i, val) {

				formData.append(val.name, val.value);
			});
			
			validateFormInvalidHandlerReset();
			$('#projekteEditForm').addClass('formSaves');
			
			$.ajax({
				url: $('#projekteEditForm').attr('action'),
				type: 'POST',
				data: formData,/*$('#auftraegeCreateForm').serialize(),*/
				contentType: false,
				processData: false,
				success: function(data) {
					
					
					

					$.colorbox.close();
					
					var dataJson = JSON.parse($(data).find('textarea#resultJson').val());


					
					targetSelectorOld = $('#projektList'+dataJson.editUid).attr('data-projekt-target-selector');

					targetSelectorNew = $(data).find('*[data-projekt-target-selector]').attr('data-projekt-target-selector');
					console.log('savedAndEdited!!');
					console.log('targetargetSelectorOldSelector: '+targetSelectorOld);
					console.log('targetargetSelectorNewSelector: '+targetSelectorNew);
					console.log('dataJson.editUid: '+dataJson.editUid);
					console.log('findindata: '+"tbody"+targetSelectorNew+dataJson.editUid);


					var openAfterReplace=false;
					if($( "tbody#projektList"+dataJson.editUid+">tr" ).first().hasClass('opened')) {
						openAfterReplace=true;
					}
					console.log('!!! openAfterReplace: '+openAfterReplace);
					if(targetSelectorOld!=targetSelectorNew){

						$( "tbody#projektList"+dataJson.editUid ).remove();

						$(targetSelectorNew).find('table').first().prepend( $(data).find("tbody#projektList"+dataJson.editUid).prop('outerHTML')  );



					} else {
					
						$( "tbody#projektList"+dataJson.editUid ).replaceWith( 
							$(data).find("tbody#projektList"+dataJson.editUid).prop('outerHTML') 
						);
					}
					
					initProjektPanelAgenturvertraege();

					if(openAfterReplace){
						console.log('openAfterReplace: '+openAfterReplace);
						$(".projekteAccordionWrapper #projektList"+dataJson.editUid+" a.panel-heading").click();
					}
					reInitAjaxCalls();
					
					
				
		
				}
			});





		}
	});	
	
	$('.checkboxBtn').click(function(e) {
		if($(this).children('.btn').hasClass('active')){
			$(this).prev('.disableCheckbox').prop( "checked", false );
		} else {
			$(this).prev('.disableCheckbox').prop( "checked", true );
		}

	});

	
	
}


function projektToggle(id){
	console.log('projektToggle(id): '+id);

	if($('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"]').length) {
		console.log('offenes Projekt!!');
	} else {
		console.log('geschlossenes Projekt!!');
	}


	if($('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"].collapse').hasClass('in')){
		console.log('- if then');
		console.log('- - removeclass opened');
		$('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"]').first().removeClass('opened'); 
	} else {
		console.log('- if else');
		console.log('- - addclass opened');
		$('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"]').first().addClass('opened'); 
	}
}
function projektToggleContentLoad(id){
	console.log('projektToggleContentLoad(id): '+id);


	if($('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"].collapse').hasClass('in')){
		console.log('- if then');
		console.log('- - addclass opened');
		$('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"]').first().addClass('opened'); 
	} else {
		console.log('- if else');
		console.log('- - removeclass opened');
		$('#.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"]').first().removeClass('opened'); 
	}
}


function initProjektPanelAgenturvertraege(){//selector
	selector = ".projekteAccordionWrapper a.panel-heading";
	console.log('initAccordionPanelAgenturverträge click für selector: '+selector);
	$( selector ).unbind( "click" );
	$( selector).click(function() {
		console.log('---- ---- ----- - click auf accordion btn!!!');
	  var tabPanel = $(this).parent().parent().next();

	  var projektUid = tabPanel.data('projekt-uid');

	  var tabPanelContent = $("#projekt-show-"+projektUid);


	  if(!tabPanelContent.html()) {
		  console.log('inhalt laden !!');
		loadProjektContent(projektUid);
		  
	  } 



	});
	
	setProjekteCounter();
	
	//agenturvertraeges
}
function setProjekteCounter(){

 

	$( ".projekteAccordionWrapper" ).each(function( index ) {
		$('.projekteBodyEmpty',this).attr('data-projekte-counter',$("a.panel-heading", this).length);
  	});
}

function loadProjektContent(id){


	//$('#projekteList tr[data-projekt-uid="'+id+'"]').addClass('tabReloads');
	$('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"]').addClass('tabReloads');
	var showAjaxJson = {"tx_dslintranet_projektliste[projekte]":id};
	dslIntranetAjaxCall(projekteShowUrl,showAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
		
		/*aktualisierung von headlines*/		
		$( $(data).find('#content-list-row-headline').find('.refreshContent') ).each(function( index ) {
			console.log('- each setContent:');
			console.log($( this ).html());
			/*console.log('this.html()');*/
		  $( '.refreshContent[data-refresh-content="'+$( this ).attr('data-refresh-content')+'"]').html($( this ).html());
		});
		
		
		changeProjektContent(id,$(data).find('#content-show').html());
		
		

	});
}
//var tabPanelContentTemp = '';
function changeProjektContent(id,content){
	
		var selector = "projekt-show-"+id;
		var tabPanelContent = $("#"+selector);
		tabPanelContent.html(content);
			
			
		//$('#projekteList tr[data-projekt-uid="'+id+'"] .removeAfterLoadsContent').remove();
		$('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"] .removeAfterLoadsContent').remove();
		setTimeout(function() {
			projektToggleContentLoad(id);
		}, 400);


		//$('#projekteList tr[data-projekt-uid="'+id+'"]').removeClass('tabReloads');
		$('.projekteAccordionWrapper tr[data-projekt-uid="'+id+'"]').removeClass('tabReloads');
		reInitAjaxCalls();
	
		if(chartProjekteArr[id]) chartProjekteArr[id].destroy();
		
		var diagramm = $('#statistikDaten'+id+'Properties').data('diagramm-json');
		var yAxesLabel = 'Stunden';
		var configDiagramm = {
		//segmentShowStroke: false,
		type: 'bar',
		
		data: diagramm.data,
		options: {
			
			hover: {
				onHover: function(e, el) {
					console.log('hover');
				
				}
		  	},
		
			
			events: ['click','mousemove','mouseout'],
			title: {
				display: true,
				text: diagramm.titel
			},
			
			
			tooltips: {
				mode: 'index',
				intersect: false,
				callbacks: {
					label: function(tooltipItem, data) {
						if(tooltipItem.yLabel == 0) return false;
						var label = ' verbrauchte Zeit: ';
						label += getZeitraumForMinutes(tooltipItem.yLabel);
						return label;
					},
					title: function(tooltipItem, data) {
						return tooltipItem[0].xLabel;
					}
				}
			},
			legend: {
				position: 'bottom',	
				labels: {useLineStyle: true}
			},
			responsive: true,
			
			scales: {
				xAxes: [{
				//	stacked: true,
					ticks: {
						callback: function(value, index, values) {
							return value;
						},
					}
				}],
				yAxes: [{
					//stacked: true,
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						major: {
							fontStyle: 'bold',
							fontColor: '#FF0000'
						},
						min:0,
						max:diagramm.diagrammMax,
						callback: function(value, index, values) {
							//return value;
							//console.log('callback:'+activeStatistikView);
							return value/60;
							
							
						},
						stepSize:diagramm.diagrammStepSize
					},
					scaleLabel: {
						display: true,
						labelString: yAxesLabel
					}
				},
				{
					stacked: false,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						major: {
							fontStyle: 'bold',
							fontColor: '#FF0000'
						},
						min:0,
						max:diagramm.diagrammMax,
						callback: function(value, index, values) {
							return '';
						},
						stepSize:diagramm.diagrammStepSize
					},
					scaleLabel: {
						display: false,
						labelString: 'Minuten'
					}
				}]
				
			}
		}



	};
	
	if(chartProjekteArr[id]) chartProjekteArr[id].destroy();
	
	chartProjekteArr[id] = new Chart(document.getElementById("chart-area-projekt-diagramm-"+id).getContext("2d"), configDiagramm);

		initProjektAuftraegeDataTable(id+'');

	}
	function initProjektAuftraegeDataTable(id){
		$('#projekteAuftraegeList'+id).DataTable({
		 	"dom": '<"top"<"float_left addBtnContainer"><"float_left"i>f>rt<"bottom"><"clear">',
			
			"order": [[ 0, "desc" ]],
			"columnDefs": [
				{
					"targets": [ 0 ],
					"width":'70px'
				},
				{
					"targets": [ 1 ],
					"orderable": false
				},
				{
					"targets": [ 2 ],
					"width":'140px'
				},
				{
					"targets": [ 3 ],
					"width":'100px'
				},
				
				{
					"targets": [ 4 ],
					"visible": false,
					"searchable": false,
					
				},
				{
					"targets": [ 5 ],
					"width":'120px'
				},
				
				{
					"targets": [ 6 ],
					"visible":false
				}
				
			],
			paging: false,
			"language": {
				"decimal":        "",
				"emptyTable":     "Keine Daten gefunden",
				"info":           "Einträge: _TOTAL_ ",
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
			},
			drawCallback: function () {
				var api = this.api();
				
				$('#'+$(this).attr('id')+' .zeiteintraegeSum').text( getZeitraumForMinutes(api.column( 4,  {page:'current'} ).data().sum() ) );
				
				
				$( '#'+$(this).attr('id')+'_addBtn'  ).detach().appendTo( '#'+$(this).attr('id')+'_wrapper .addBtnContainer' );
			
			}
	});
	
	$('#projekteAuftraegeList'+id+'_wrapper .clearFilter').on('click', function() {
		
		var tmpSelector = '#'+$(this).closest('.dataTables_wrapper').attr('id');

		setTimeout(function(){ 
			$(tmpSelector+' input[type="search"]').val('');
			$(tmpSelector+' .dataTable').DataTable().search( '' ).draw();
			$(tmpSelector+' .clearFilter').css('opacity',0);
		}, 10);
	}); 
	$('#projekteAuftraegeList'+id+'_wrapper input[type="search"]').keyup(function() {
		var tmpSelector = '#'+$(this).closest('.dataTables_wrapper').attr('id');
		if($(tmpSelector+' input[type="search"]').val()){
			$(tmpSelector+' .clearFilter').css('opacity',1);
		} else {
			$(tmpSelector+' .clearFilter').css('opacity',0);
		}
	});
	$('#projekteAuftraegeList'+id+'_wrapper .clearFilter').insertAfter('#projekteAuftraegeList'+id+'_wrapper input[type="search"]');
	
}


function setOpenAuftrag(id,href){
	var ajaxJson = {"tx_dslintranet_projektliste[switch]":'setOpenAuftrag',"tx_dslintranet_projektliste[auftrag]":id};
	dslIntranetAjaxCall(projekteAjaxUrl,ajaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		window.location.href = href;
	});
}


$(function() {
	
	initProjektPanelAgenturvertraege();
});


$(function() {
	dataTable = $('#agenturvertragAuftraegeOhneZuordnungList').DataTable({
		 "dom": '<"top"<"float_left addBtnContainer"><"float_left"i>f>rt<"bottom"><"clear">',
			"order": [[ 0, "desc" ]],
			"columnDefs": [
				{
					"targets": [ 0 ],
					"width":'70px'
				},
				{
					"targets": [ 1 ],
					"orderable": false
				},
				{
					"targets": [ 2 ],
					"width":'140px'
				}
			],
			paging: false,
			"language": {
				"decimal":        "",
				"emptyTable":     "Keine Daten gefunden",
				"info":           "Einträge: _TOTAL_ ",
				"infoEmpty":      "Zeige 0 bis 0 von 0 Einträgen",
				"infoFiltered":   " von _MAX_ (gefiltert)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Zeige _MENU_ Einträge pro Seite",
				"loadingRecords": "Lädt...",
				"processing":     "Processing...",
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
	
	
	$('#agenturvertragAuftraegeOhneZuordnungList_wrapper .clearFilter').on('click', function() {
	  setTimeout(function(){ 
		$('#agenturvertragAuftraegeOhneZuordnungList_wrapper input[type="search"]').val('');
		dataTable.search( '' ).draw();
		$('#agenturvertragAuftraegeOhneZuordnungList_wrapper .clearFilter').css('opacity',0);
	  }, 10);
	}); 
	$('#agenturvertragAuftraegeOhneZuordnungList_wrapper input[type="search"]').keyup(function() {

		if($('#agenturvertragAuftraegeOhneZuordnungList_wrapper input[type="search"]').val()){
			$('#agenturvertragAuftraegeOhneZuordnungList_wrapper .clearFilter').css('opacity',1);
		} else {
			$('#agenturvertragAuftraegeOhneZuordnungList_wrapper .clearFilter').css('opacity',0);
		}
	});

	$('#agenturvertragAuftraegeOhneZuordnungList_wrapper .clearFilter').insertAfter('#agenturvertragAuftraegeOhneZuordnungList_wrapper input[type="search"]');
	
	
});

