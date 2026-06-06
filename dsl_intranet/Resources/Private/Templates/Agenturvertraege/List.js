var agenturvertraege = $('#agenturvertraege');

var agenturvertraegeCheckFileAjaxUrl = agenturvertraege.data('agenturvertraegeCheckFileAjaxUrl');

var agenturvertraegeAjaxUrl = agenturvertraege.data('ajaxUrl');
var agenturvertraegeShowUrl = agenturvertraege.data('showUrl');

var chartAgenturvertraegeArr = new Object();
var chartAgenturvertraegeJahrArr = new Object();
var chartAgenturvertraegeDiagrammArr = new Object();
var monateArr = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];

var clickEvt;
$(function() {
	
	var rangeMinDate = agenturvertraege.data('rangeMinDate');
	var rangeMaxDate = agenturvertraege.data('rangeMaxDate');
	
	moment.locale('de');
	
	$('input[name="daterange"]').daterangepicker({
		
		
		"showCustomRangeLabel": false,
		"applyClass": "hidden",
    	"cancelClass": "hidden",
		ranges: {
                
				
				[moment().format('YYYY')]: [moment().startOf('year'), moment().endOf('year')],
				[moment().subtract(1,'year').format('YYYY')]: [moment().subtract(1,'year').startOf('year'), moment().subtract(1,'year').endOf('year')],
				[moment().subtract(2,'year').format('YYYY')]: [moment().subtract(2,'year').startOf('year'), moment().subtract(2,'year').endOf('year')],
				[moment().subtract(3,'year').format('YYYY')]: [moment().subtract(3,'year').startOf('year'), moment().subtract(3,'year').endOf('year')],
				[moment().subtract(4,'year').format('YYYY')]: [moment().subtract(4,'year').startOf('year'), moment().subtract(4,'year').endOf('year')],
				[moment().subtract(5,'year').format('YYYY')]: [moment().subtract(5,'year').startOf('year'), moment().subtract(5,'year').endOf('year')],
				[moment().subtract(6,'year').format('YYYY')]: [moment().subtract(6,'year').startOf('year'), moment().subtract(6,'year').endOf('year')],
				[moment().subtract(7,'year').format('YYYY')]: [moment().subtract(7,'year').startOf('year'), moment().subtract(7,'year').endOf('year')],
				[moment().subtract(8,'year').format('YYYY')]: [moment().subtract(8,'year').startOf('year'), moment().subtract(8,'year').endOf('year')],
            },
		minDate: rangeMinDate,
		maxDate: rangeMaxDate,
		locale: {
			"format": "DD.MM.YYYY",
			"separator": " - ",
			"applyLabel": "Übernehmen",
			"cancelLabel": "Abbrechen",
			"fromLabel": "von",
			"toLabel": "bis",
			"customRangeLabel": "Benutzerdefiniert",
			"daysOfWeek": [
				"So",
				"Mo",
				"Di",
				"Mi",
				"Do",
				"Fr",
				"Sa"
			],
			
			"firstDay": 1
		},
	}, function(start, end, label) {
		
		
		//test
		
		
	}).on('apply.daterangepicker', function(ev, picker) {

		
		var start = moment(picker.startDate.format('YYYY-MM')+'-01');
		picker.startDate = start;
		
		
		var end = moment(picker.endDate.format('YYYY-MM')+'-01');
		picker.endDate = end;
		picker.endDate.add(1,'month');
		
		picker.endDate.subtract(1,'day');
		picker.updateView();
		picker.updateCalendars();
		
		$('input[name="daterange"]').val(picker.startDate.format('DD.MM.YYYY')+' - '+picker.endDate.format('DD.MM.YYYY'));
		
		
		
		
		var ajaxJson = {"tx_dslintranet_agenturvertragsliste[switch]":'setNewRange',"tx_dslintranet_agenturvertragsliste[start]":picker.startDate.format('DD.MM.YYYY'),"tx_dslintranet_agenturvertragsliste[end]":picker.endDate.format('DD.MM.YYYY')};


		dslIntranetAjaxCall(agenturvertraegeAjaxUrl,ajaxJson).done(function (data /* , textStatus, jqXHR */ ) {
			if(data=="error") {
				
				//test
			} else {
				$('.refreshFilterAgenturvertraege').click();
				
				/*aktualisierung von headlines*/		
				$( $(data).find('.refreshContent') ).each(function( index ) {
			
				  $( '.refreshContent[data-refresh-content="'+$( this ).attr('data-refresh-content')+'"]').html($( this ).html());
				});
				
				
			
			}
		});
		
		
	 
		return true;
	}).on('show.daterangepicker', function(ev, picker) {
		setTimeout(function(){ 
			$('.daterangeToggle').attr('data-show','true');
		}, 300);
		
	}).on('hide.daterangepicker', function(ev, picker) {
		setTimeout(function(){ 
			$('.daterangeToggle').attr('data-show','false');
		}, 300);	
		
	});
	
	
	
	$(".daterangeToggle").unbind( "click" );
	$('.daterangeToggle').click(function(event){
	  if($('.daterangeToggle').attr('data-show')!='true')  $('input[name="daterange"]').data('daterangepicker').toggle();
	});
	
});
/*Funkctionen für das Anlegen / Editieren von Agenturverträgen*/
function initAgenturvertraegeNewEditForm(){
	
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
	$( "#agenturvertraegeCreateForm button.confirm,#agenturvertraegeEditForm button.confirm" ).click(function() {
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
		console.log($(".stundenMonatlich").val());
		console.log($(this).val());
		var calcul = calcStundensatz($(".stundenMonatlich").val(),$(this).val());
		$('#agenturvertraegeFormularStundensatz').text(calcStundensatz($(".preisMonatlich").val(),$(this).val()));
		//$('#agenturvertraegeFormularStundensatz').text(calcul);
		$('#agenturvertraegeFormularStundensatz').text(calcStundensatz($(this).val(),$(".stundenMonatlich").val()));
		
		

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
		
		
		var calcul = calcStundensatz($(".preisMonatlich").val(),$(this).val());
		//$('#agenturvertragFormularStundensatz').text(calcStundensatz($(".preisMonatlich").val(),$(this).val()));
		$('#agenturvertraegeFormularStundensatz').text(calcul);

		
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
	
	
	
	$('#agenturvertraegeCreateForm').validate({
		invalidHandler: function(event, validator) { validateFormInvalidHandler(validator); },
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		ignore: ':hidden:not(".validator_required")', // Tells the validator to check the hidden select */
		errorClass: 'invalid',
		submitHandler: function(form) {


			var formData = new FormData();
			
			var	fileTypeError = false;
			
			files    = $('#agenturvertraegeCreateForm').find('#fileUploadDateien')[0].files;
			if(files.length != 0) {
				$.each(files, function(i, file) {

					if(file["type"] != 'application/pdf' ) {
						fileTypeError = true;
					}

					formData.append('tx_dslintranet_agenturvertragsliste[agenturvertraege][vertrag]', file);


				});
			} 

			if(fileTypeError) {
				
				$('.fileUploadTypen .required').removeClass('hidden');
				return false;
			} else {
				$('.fileUploadTypen .required').addClass('hidden');
			}


			params  = $('#agenturvertraegeCreateForm').serializeArray();
			$.each(params, function(i, val) {

				formData.append(val.name, val.value);
			});

			validateFormInvalidHandlerReset();
			$('#agenturvertraegeCreateForm').addClass('formSaves');

			$.ajax({
				url: $('#agenturvertraegeCreateForm').attr('action'),
				type: 'POST',
				data: formData,/*$('#auftraegeCreateForm').serialize(),*/
				contentType: false,
				processData: false,
				success: function(data) {

					$.colorbox.close();
					
					var dataJson = JSON.parse($(data).find('textarea#resultJson').val());

					$('#agenturvertraegeList').find('table').first().prepend( $(data).find("tbody#agenturvertragList"+dataJson.newUid).prop('outerHTML')  );
					initAccordionPanelAgenturvertraege("#agenturvertraegeAccordion a.panel-heading");
					reInitAjaxCalls();
					$("#agenturvertraegeAccordion #agenturvertragList"+dataJson.newUid+" a.panel-heading").click();
					
					

				}
			});





		}
	});

	
	$('#agenturvertraegeEditForm').validate({
		invalidHandler: function(event, validator) { validateFormInvalidHandler(validator); },
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		ignore: ':hidden:not(".validator_required")', // Tells the validator to check the hidden select */
		errorClass: 'invalid',
		submitHandler: function(form) {


			var formData = new FormData();


			//var formData = new FormData();

			var	fileTypeError = false;
			
			files    = $('#agenturvertraegeEditForm').find('#fileUploadDateien')[0].files;
			if(files.length != 0) {
				$.each(files, function(i, file) {

					if(file["type"] != 'application/pdf' ) {
						fileTypeError = true;
					}

					formData.append('tx_dslintranet_agenturvertragsliste[agenturvertraege][vertrag]', file);


				});
			} 

			if(fileTypeError) {

				$('.fileUploadTypen .required').removeClass('hidden');
				return false;
			} else {
				$('.fileUploadTypen .required').addClass('hidden');
			}

			params  = $('#agenturvertraegeEditForm').serializeArray();
			$.each(params, function(i, val) {

				formData.append(val.name, val.value);
			});
			
			validateFormInvalidHandlerReset();
			$('#agenturvertraegeEditForm').addClass('formSaves');
			
			$.ajax({
				url: $('#agenturvertraegeEditForm').attr('action'),
				type: 'POST',
				data: formData,/*$('#auftraegeCreateForm').serialize(),*/
				contentType: false,
				processData: false,
				success: function(data) {
					
					
					
					$.colorbox.close();
					
					var dataJson = JSON.parse($(data).find('textarea#resultJson').val());

					var openAfterReplace=false;
					if($( "tbody#agenturvertragList"+dataJson.editUid+">tr" ).first().hasClass('opened')) {
						openAfterReplace=true;
					}

					$( "tbody#agenturvertragList"+dataJson.editUid ).replaceWith( $(data).find("tbody#agenturvertragList"+dataJson.editUid).prop('outerHTML') );
					initAccordionPanelAgenturvertraege("#agenturvertraegeAccordion a.panel-heading");

					if(openAfterReplace){
						$("#agenturvertraegeAccordion #agenturvertragList"+dataJson.editUid+" a.panel-heading").click();
					}
					reInitAjaxCalls();
		
				}
			});





		}
	});	
	
}


function agenturvertraegeToggle(id){
	if($('#agenturvertraegeList tr[data-av-uid="'+id+'"].collapse').hasClass('in'))
		$('#agenturvertraegeList tr[data-av-uid="'+id+'"]').first().removeClass('opened'); 
			else $('#agenturvertraegeList tr[data-av-uid="'+id+'"]').first().addClass('opened'); 
}
function agenturvertraegeToggleContentLoad(id){
	if($('#agenturvertraegeList tr[data-av-uid="'+id+'"].collapse').hasClass('in'))
		$('#agenturvertraegeList tr[data-av-uid="'+id+'"]').first().addClass('opened'); 
			else $('#agenturvertraegeList tr[data-av-uid="'+id+'"]').first().removeClass('opened'); 
}


function initAccordionPanelAgenturvertraege(selector){
	$( selector ).unbind( "click" );
	$( selector).click(function() {

	  var tabPanel = $(this).parent().parent().next();

	  var avUid = tabPanel.data('av-uid');

	  var tabPanelContent = $("#agenturvertrag-show-"+avUid);


	  if(!tabPanelContent.html())  loadAgenturvertragContent(avUid);



	});
	
	setAgenturvertraegeCounter();
	
	//agenturvertraeges
}
function setAgenturvertraegeCounter(){
	$('#agenturvertragListEmpty').attr('data-agenturvertraege-counter',$("#agenturvertraegeAccordion a.panel-heading").length);
}
var testData = "";
function loadAgenturvertragContent(id){


	$('#agenturvertraegeList tr[data-av-uid="'+id+'"]').addClass('tabReloads');
	var showAjaxJson = {"tx_dslintranet_agenturvertragsliste[agenturvertraege]":id};/*"tx_dslintranet_agenturvertragsliste[switch]":'show',*/
	dslIntranetAjaxCall(agenturvertraegeShowUrl,showAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {

		
		/*aktualisierung von headlines*/		
		$( $(data).find('#content-list-row-headline').find('.refreshContent') ).each(function( index ) {
		  $( '.refreshContent[data-refresh-content="'+$( this ).attr('data-refresh-content')+'"]').html($( this ).html());
		});
		
		
		changeAgenturvertragContent(id,$(data).find('#content-show').html());
		
		

	});
}
function changeAgenturvertragContent(id,content){
	
		var selector = "agenturvertrag-show-"+id;
		var tabPanelContent = $("#"+selector);
		
		
		tabPanelContent.html(content);
	
		$('#agenturvertraegeList tr[data-av-uid="'+id+'"] .removeAfterLoadsContent').remove();
		agenturvertraegeToggleContentLoad(id);
		
	
		$('#agenturvertraegeList tr[data-av-uid="'+id+'"]').removeClass('tabReloads');
		reInitAjaxCalls();
	
	
	
		if(chartAgenturvertraegeArr[id]) chartAgenturvertraegeArr[id].destroy();
		if(chartAgenturvertraegeJahrArr[id]) chartAgenturvertraegeJahrArr[id].destroy();
		
		var tmpKontingent = parseInt($('#agenturvertrag'+id+'Properties').attr('data-kontingent'));
		var tmpKontingentUsed = parseInt($('#agenturvertrag'+id+'Properties').attr('data-kontingentUsed'));
	    //neu
	    var tmpKontingentUsedSchwebend = parseInt($('#agenturvertrag'+id+'Properties').attr('data-kontingentUsedSchwebend'));
		var tmpKontingentUsedAbgeschlossen = parseInt($('#agenturvertrag'+id+'Properties').attr('data-kontingentUsedAbgeschlossen'));
	
		
		if(document.getElementById("chart-area-agenturvertrag-"+id)){
	

			if(tmpKontingent<tmpKontingentUsed){
				var tmpOver = tmpKontingentUsed-tmpKontingent;
				
				var tmpDatasets = [{ 
								data:[tmpKontingentUsedAbgeschlossen,tmpKontingentUsedSchwebend,tmpOver],
								backgroundColor:["#14cb96","#f88324","#ff0000"],
								hoverBackgroundColor:["#14cb96","#f88324","#ff0000"],
								borderWidth:1
							}];
			} else {
				
				var tmpDatasets = [{ 
								data:[tmpKontingentUsed,(tmpKontingent-tmpKontingentUsed)],
								backgroundColor:["#14cb96","#c6c7c8"],
								hoverBackgroundColor:["#14cb96","#c6c7c8"],
								borderWidth:1
							}];
			}
		

		}
	
		//jahres kreisdiagramm
		var tmpKontingentJahr = parseInt($('#agenturvertrag'+id+'Properties').attr('data-kontingentJahr'));
		var tmpKontingentUsedJahr = parseInt($('#agenturvertrag'+id+'Properties').attr('data-kontingentUsedJahr'));
		var tmpJahrLabel = parseInt($('#agenturvertrag'+id+'Properties').attr('data-labelJahr'));
	
	
		if(tmpKontingentJahr<tmpKontingentUsedJahr){
			var tmpOverJahr = tmpKontingentUsedJahr-tmpKontingentJahr;
			var tmpDatasetsJahr = [{ 
							data:[tmpKontingentJahr,tmpOverJahr],
							backgroundColor:["#14cb96","#ff0000"],
							hoverBackgroundColor:["#14cb96","#ff0000"],
							borderWidth:1
						}];
		} else {

			var tmpDatasetsJahr = [{ 
							data:[tmpKontingentUsedJahr,(tmpKontingentJahr-tmpKontingentUsedJahr)],
							backgroundColor:["#14cb96","#c6c7c8"],
							hoverBackgroundColor:["#14cb96","#c6c7c8"],
							borderWidth:1
						}];
		}

		initAgenturvertragAuftraegeDataTable(id+'_schwebend');
		initAgenturvertragAuftraegeDataTable(id+'_abgeschlossen');
		initAgenturvertragRechnungenDataTable(id)

		var diagramm = $('#agenturvertrag'+id+'Properties').data('diagramm-json');
	
		if(typeof diagramm.monat != "undefined") {
	
			

			var color = Chart.helpers.color;
			var configDiagramm = {
				segmentShowStroke: false,
				type: 'bar',
				data: {
					/*labels: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],*/
					labels: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],

					datasets: [{
						type: 'bar',
						label: 'Handling',
						backgroundColor: color('rgb(201, 203, 207)').alpha(0.8).rgbString(),//grey
						borderColor: 'rgb(201, 203, 207)',//red
						borderWidth: 1,
						stack: 1,
						data: [

							diagramm.monat[1].kontingentHandlingJeMonat,diagramm.monat[2].kontingentHandlingJeMonat,diagramm.monat[3].kontingentHandlingJeMonat,diagramm.monat[4].kontingentHandlingJeMonat,diagramm.monat[5].kontingentHandlingJeMonat,diagramm.monat[6].kontingentHandlingJeMonat,diagramm.monat[7].kontingentHandlingJeMonat,diagramm.monat[8].kontingentHandlingJeMonat,diagramm.monat[9].kontingentHandlingJeMonat,diagramm.monat[10].kontingentHandlingJeMonat,diagramm.monat[11].kontingentHandlingJeMonat,diagramm.monat[12].kontingentHandlingJeMonat
						],
					},
					{
						type: 'bar',
						label: 'Abgeschlossen',
						backgroundColor: color('rgb(20, 203, 150)').alpha(0.8).rgbString(),
						borderColor: 'rgb(20, 203, 150)',
						borderWidth: 1,
						stack: 1,
						data: [

							diagramm.monat[1].kontingentAbgeschlossen,diagramm.monat[2].kontingentAbgeschlossen,diagramm.monat[3].kontingentAbgeschlossen,diagramm.monat[4].kontingentAbgeschlossen,diagramm.monat[5].kontingentAbgeschlossen,diagramm.monat[6].kontingentAbgeschlossen,diagramm.monat[7].kontingentAbgeschlossen,diagramm.monat[8].kontingentAbgeschlossen,diagramm.monat[9].kontingentAbgeschlossen,diagramm.monat[10].kontingentAbgeschlossen,diagramm.monat[11].kontingentAbgeschlossen,diagramm.monat[12].kontingentAbgeschlossen

						],
					},

					{
						type: 'bar',
						label: 'Schwebend',
						backgroundColor: color('rgb(248, 131, 36)').alpha(0.8).rgbString(),
						borderColor: 'rgb(248, 131, 36)',
						borderWidth: 1,
						border:false,
						stack: 1,
						data: [
							diagramm.monat[1].kontingentSchwebend,diagramm.monat[2].kontingentSchwebend,diagramm.monat[3].kontingentSchwebend,diagramm.monat[4].kontingentSchwebend,diagramm.monat[5].kontingentSchwebend,diagramm.monat[6].kontingentSchwebend,diagramm.monat[7].kontingentSchwebend,diagramm.monat[8].kontingentSchwebend,diagramm.monat[9].kontingentSchwebend,diagramm.monat[10].kontingentSchwebend,diagramm.monat[11].kontingentSchwebend,diagramm.monat[12].kontingentSchwebend
						],
					}, 
					{
						type: 'bar',
						label: 'Überschritten',
						backgroundColor: color('rgb(255, 0, 0)').alpha(0.8).rgbString(),
						borderColor: 'rgb(255, 0, 0)',
						borderWidth: 1,
						border:false,
						stack: 1,
						data: [
							diagramm.monat[1].kontingentUeberGesamt,diagramm.monat[2].kontingentUeberGesamt,diagramm.monat[3].kontingentUeberGesamt,diagramm.monat[4].kontingentUeberGesamt,diagramm.monat[5].kontingentUeberGesamt,diagramm.monat[6].kontingentUeberGesamt,diagramm.monat[7].kontingentUeberGesamt,diagramm.monat[8].kontingentUeberGesamt,diagramm.monat[9].kontingentUeberGesamt,diagramm.monat[10].kontingentUeberGesamt,diagramm.monat[11].kontingentUeberGesamt,diagramm.monat[12].kontingentUeberGesamt
						],
					}, 
					{
						type: 'line',
						label: 'Jahres Ø',
						backgroundColor: color('rgb(255, 255, 255)').alpha(0.5).rgbString(),//green
						borderColor: 'rgb(75, 192, 192)',//green
						borderWidth: 1,
						fill: false,
						cubicInterpolationMode: 'monotone',
						data: [
							diagramm.monat[1].avg,diagramm.monat[2].avg,diagramm.monat[3].avg,diagramm.monat[4].avg,diagramm.monat[5].avg,diagramm.monat[6].avg,diagramm.monat[7].avg,diagramm.monat[8].avg,diagramm.monat[9].avg,diagramm.monat[10].avg,diagramm.monat[11].avg,diagramm.monat[12].avg

						],
						yAxisID: 'y-axis-2'
					},{
						type: 'line',
						label: 'Maximal',
						backgroundColor: color('rgb(255, 255, 255)').alpha(0.8).rgbString(),//red
						borderColor: 'rgb(255, 0, 0)',//red
						borderWidth: 1,
						fill: false,
						cubicInterpolationMode: 'monotone',
						data: [
							diagramm.monat[1].kontingentJeMonat,diagramm.monat[2].kontingentJeMonat,diagramm.monat[3].kontingentJeMonat,diagramm.monat[4].kontingentJeMonat,diagramm.monat[5].kontingentJeMonat,diagramm.monat[6].kontingentJeMonat,diagramm.monat[7].kontingentJeMonat,diagramm.monat[8].kontingentJeMonat,diagramm.monat[9].kontingentJeMonat,diagramm.monat[10].kontingentJeMonat,diagramm.monat[11].kontingentJeMonat,diagramm.monat[12].kontingentJeMonat

						],
						yAxisID: 'y-axis-2'
					}]
				},
				options: {
					hover: {
					onHover: function(e, el) {
					  $("#chart-area-agenturvertrag-diagramm-"+id).css("cursor", el[0] ? "pointer" : "default");
					}
				  },
					events: ['click','mousemove','mouseout'],
					title: {
						display: true,
						text: 'Diagramm für das Abrechnungsjahr '+diagramm.jahr
					},
					tooltips: {
						mode: 'index',
						intersect: false,
						callbacks: {
							label: function(tooltipItem, data) {


								if(!getZeitraumForMinutes(tooltipItem.yLabel)) return '';

								var label = ' '+data.datasets[tooltipItem.datasetIndex].label || '';

								if (label) {
									label += ': ';
								}
								label += getZeitraumForMinutes(tooltipItem.yLabel);
								return label;
							},
							title: function(tooltipItem, data) {

								switch (tooltipItem[0].index) {
									case 0: return "Januar"; break;
									case 1: return "Februar"; break;
									case 2: return "März"; break;
									case 3: return "April"; break;
									case 4: return "Mai"; break;
									case 5: return "Juni"; break;
									case 6: return "Juli"; break;
									case 7: return "August"; break;
									case 8: return "September"; break;
									case 9: return "Oktober"; break;
									case 10: return "November"; break;
									case 11: return "Dezember"; break;
								}


								return "";
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
							stacked: true,
						}],
						yAxes: [{
							stacked: true,
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
									return value/60;
								},
								stepSize:diagramm.diagrammStepSize
							},
							scaleLabel: {
								display: true,
								labelString: 'Stunden'
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
	
			chartAgenturvertraegeDiagrammArr[id] = new Chart(document.getElementById("chart-area-agenturvertrag-diagramm-"+id).getContext("2d"), configDiagramm);


			document.getElementById("chart-area-agenturvertrag-diagramm-"+id).onclick = function(evt){   
				var activePoints = chartAgenturvertraegeDiagrammArr[id].getElementsAtEvent(evt);

				if(activePoints.length > 0){
					  //get the internal index of slice in pie chart
					  var clickedElementindex = activePoints[0]["_index"];

					  //get specific label by index 
					  var label = chartAgenturvertraegeDiagrammArr[id].data.labels[clickedElementindex];

					  //get value by index      
					  var value = chartAgenturvertraegeDiagrammArr[id].data.datasets[0].data[clickedElementindex];



						$('#agenturvertragAuftraegeList'+id+'_schwebend').DataTable().search( '##'+monateArr[clickedElementindex]+'##' ).draw();
						$('#agenturvertragAuftraegeList'+id+'_abgeschlossen').DataTable().search( '##'+monateArr[clickedElementindex]+'##' ).draw();
						$('#agenturvertragAuftraegeList'+id+'_schwebend_wrapper input[type="search"]').trigger('keyup');
						$('#agenturvertragAuftraegeList'+id+'_abgeschlossen_wrapper input[type="search"]').trigger('keyup');
					}

			}
			initPlusMinusChartBtn();
		}
		//(re)initDateiUpload
		
		var fileselect = $id("fileUploadDateienAgenturvertrag"+id),
			filedragWrapper = $id("filedragAgenturvertragWrapper"+id),
			submitbutton = $id("submitbuttonAgenturvertrag"+id);
				//filedrag = $id("filedragAgenturvertrag"+id),
		// file select
		fileselect.addEventListener("change", agenturVertraegeFileSelectWrapperHandler, false);

		// is XHR2 available?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {

			// file drop
			filedragWrapper.addEventListener("dragover", agenturVertraegeFileDragWrapperHover, false);
			filedragWrapper.addEventListener("dragleave", agenturVertraegeFileDragWrapperHover, false);
			filedragWrapper.addEventListener("drop", agenturVertraegeFileSelectWrapperHandler, false);
			
			// remove submit button
			submitbutton.style.display = "none";
			fileselect.style.display = "none";
		}

		$( "#filedragAgenturvertrag"+id ).click(function() {
		  $('#fileUploadDateienAgenturvertrag'+id).click();
		});
	
		
	}
function initAgenturvertragAuftraegeDataTable(id){
	$('#agenturvertragAuftraegeList'+id).DataTable({
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

	$('#agenturvertragAuftraegeList'+id+'_wrapper .clearFilter').on('click', function() {
		
		var tmpSelector = '#'+$(this).closest('.dataTables_wrapper').attr('id');

		setTimeout(function(){ 
			$(tmpSelector+' input[type="search"]').val('');
			$(tmpSelector+' .dataTable').DataTable().search( '' ).draw();
			$(tmpSelector+' .clearFilter').css('opacity',0);
		}, 10);
	}); 
	$('#agenturvertragAuftraegeList'+id+'_wrapper input[type="search"]').keyup(function() {
		var tmpSelector = '#'+$(this).closest('.dataTables_wrapper').attr('id');
		if($(tmpSelector+' input[type="search"]').val()){
			$(tmpSelector+' .clearFilter').css('opacity',1);
		} else {
			$(tmpSelector+' .clearFilter').css('opacity',0);
		}
	});
	$('#agenturvertragAuftraegeList'+id+'_wrapper .clearFilter').insertAfter('#agenturvertragAuftraegeList'+id+'_wrapper input[type="search"]');
	
}


function initAgenturvertragRechnungenDataTable(id){
	$('#agenturvertragRechnungenList'+id).DataTable({
		 "dom": '<"top"<"float_left addBtnContainer"><"float_left"i>f>rt<"bottom"><"clear">',
			
			"order": [[ 4, "desc" ]],
			"columnDefs": [
				{
					"targets": [ 0 ],
					"orderable": false
				},
				{
					"targets": [ 1 ],
					"width": "240px"
				},
				{
					"targets": [ 2 ],
					"width": "90px"
				},
				{
					"targets": [ 3 ],
					"width": "70px"
				},
				
				{
					"targets": [ 4 ],
					"width": "140px"
				},
				{
					"targets": [ 5 ],
					"searchable": false,
					"width": "140px"
				},
				{
					"targets": [ 6 ],
					"orderable": false,
					"width":'120px'
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
				
				
				
				$( '#'+$(this).attr('id')+'_addBtn'  ).detach().appendTo( '#'+$(this).attr('id')+'_wrapper .addBtnContainer' );
			
			}
	});

	$('#agenturvertragRechnungenList'+id+'_wrapper .clearFilter').on('click', function() {
		
		var tmpSelector = '#'+$(this).closest('.dataTables_wrapper').attr('id');

		setTimeout(function(){ 
			$(tmpSelector+' input[type="search"]').val('');
			$(tmpSelector+' .dataTable').DataTable().search( '' ).draw();
			$(tmpSelector+' .clearFilter').css('opacity',0);
		}, 10);
	}); 
	$('#agenturvertragRechnungenList'+id+'_wrapper input[type="search"]').keyup(function() {
		var tmpSelector = '#'+$(this).closest('.dataTables_wrapper').attr('id');
		if($(tmpSelector+' input[type="search"]').val()){
			$(tmpSelector+' .clearFilter').css('opacity',1);
		} else {
			$(tmpSelector+' .clearFilter').css('opacity',0);
		}
	});
	$('#agenturvertragRechnungenList'+id+'_wrapper .clearFilter').insertAfter('#agenturvertragRechnungenList'+id+'_wrapper input[type="search"]');
	
}
function setOpenAuftrag(id,href){

	var ajaxJson = {"tx_dslintranet_agenturvertragsliste[switch]":'setOpenAuftrag',"tx_dslintranet_agenturvertragsliste[auftrag]":id};


	dslIntranetAjaxCall(agenturvertraegeAjaxUrl,ajaxJson).done(function (data /* , textStatus, jqXHR */ ) {
	
		window.location.href = href;
		
	});
	
}


function initPlusMinusChartBtn(){

	$( ".chart-btn-add,.chart-btn-sub").unbind( "click" );
	$( ".chart-btn-add" ).click(function() {
	  var add = parseInt($(this).data("max-add"));
	  var uid = parseInt($(this).data("agenturvertrag-uid"));
	  var myChart = chartAgenturvertraegeDiagrammArr[uid];
	  var max = myChart.options.scales.yAxes[0].ticks.max;

	  max=max+add;
	  myChart.options.scales.yAxes[0].ticks.max = max;
	  myChart.options.scales.yAxes[1].ticks.max = max;
	  myChart.update();
	  return false;
	});
	$( ".chart-btn-sub" ).click(function() {
	  var sub = parseInt($(this).data("max-sub"));
	  var uid = parseInt($(this).data("agenturvertrag-uid"));
	  var myChart = chartAgenturvertraegeDiagrammArr[uid];
	  var max = myChart.options.scales.yAxes[0].ticks.max;
	  if(max>sub){
	  max=max-sub;
	  myChart.options.scales.yAxes[0].ticks.max = max;
	  myChart.options.scales.yAxes[1].ticks.max = max;
	  myChart.update();
	  }
	  return false;
	});

}

$(function() {
		initAccordionPanelAgenturvertraege("#agenturvertraegeAccordion a.panel-heading");
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


if (typeof $id == "undefined") { 
    // safe to use the function
	// getElementById
	function $id(id) {
		return document.getElementById(id);
	}
}

if (typeof Output == "undefined") { 
    // safe to use the function
	// output information
	function Output(msg) {
		var m = $id("messages");
		m.innerHTML = m.innerHTML+msg;
	}
}



function agenturVertraegeFileDragWrapperHover(e) {
//console.log('agenturVertraegeFileDragWrapperHover');
  //console.log(e.target.className);
  
  var wrapper = $(e.target).closest('.filedragWrapper')
  
	if(wrapper){

		
		e.stopPropagation();
		e.preventDefault();
    if(e.type == "dragover") $(wrapper).addClass('hover'); else $(wrapper).removeClass('hover')
		
	}
}

function agenturVertraegeFileSelectWrapperHandler(e) {
  agenturVertraegeFileDragWrapperHover(e);
	// fetch FileList object
	var files = e.target.files || e.dataTransfer.files;
	
	for (var i = 0, f; f = files[i]; i++) {
		agenturVertraegeSubmitDateiForm(f,'#'+$(e.target).closest('.filedragWrapper').find('.dateiUploadForm').attr('id'));

	}
	
}


var agenturVertraegePendingFiles = new Object();
var agenturVertraegeUploadCounter = 0;

function agenturVertraegeSubmitDateiForm(file,formSelector) {

		var fileMD5 = $.md5(file.name+file.type+file.size);

		if(agenturVertraegePendingFiles[fileMD5]) {
			return false;
		}

		if(file["type"] != 'application/pdf' 
			/*&& file["type"] != 'image/png' 
			&& file["type"] != 'image/jpeg'
			&& file["type"] != 'application/vnd.ms-excel'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
			&& file["type"] != 'application/msword'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'
			&& file["type"] != 'application/x-zip-compressed'
			&& file["type"] != 'video/mp4'
			&& file["type"] != 'video/quicktime'
		   && file["type"] != 'application/postscript'*/


		  ) {

			//console.log('filetype: '+file["name"]+' ('+file["type"]+') wird nicht unterstützt');
			
			
			return false;
		} 

		
		$('#uploadOverlay').show();
		$('body').addClass('filedragAbsolute');
	
	
		window.agenturvertragToRefresh = $(formSelector).closest('.filedragWrapper').attr('data-agenturvertrag-uid');

		agenturVertraegeUploadCounter++;

		Output(
			'<div data-unique-check="true" class="fileuploadPending"><hr><p>' + file.name +
			'&nbsp;<span class="proceedCont fileExists">(Datei existiert bereits)</span></p> <progress data-file-size="'+file.size+'" data-file-name="'+file.name+'" class="'+fileMD5+'" min="0" max="100" value="0">0% complete</progress>&nbsp;&nbsp;<span class="fileSizeRemainingWrapper"><span class="fileSizeRemaining">0% - '+formatBytes(file.size,1)+'</span> verbleibend</span><div class="proceedCont"><div class="vorhandeneDatei"></div><div class="btn-group"><a class="btn btn-warning" href="#" data-proceed-action="delete">Vorhandene überschreiben</a><a class="btn btn-warning btn-middle" href="#" data-proceed-action="rename">als Kopie hochladen</a><a class="btn btn-default" data-proceed-action="cancel" href="#">nicht hochladen</a></div></div></div>'
		);
	


		//video/mp4

// dateienUploadForm => dateienUploadFormAgenturvertrag{agenturvertrag.uid}
	
	
		var formData = new FormData();
	
		params  = $(formSelector).serializeArray();
	
		formData.append('tx_dslintranet_downloadcenter[newDateien][datei]', file);

		$.each(params, function(i, val) {
			formData.append(val.name, val.value);
		});

		agenturVertraegePendingFiles[fileMD5] = {formData:formData,url:$(formSelector).attr('action')}


		var checkAjaxJson = {"tx_dslintranet_downloadcenter[fileMD5]":fileMD5,"tx_dslintranet_downloadcenter[fileName]":file.name,"tx_dslintranet_downloadcenter[agenturvertrag]":window.agenturvertragToRefresh};
		dslIntranetAjaxCall(agenturvertraegeCheckFileAjaxUrl,checkAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {

			var dataJson = JSON.parse($(data).find('textarea#resultJson').val());
			
			if(dataJson["invalid"]){
				alert(dataJson["invalid"]);
				
				$('progress.'+dataJson["fileMD5"]).closest('.fileuploadPending').remove();
				delete agenturVertraegePendingFiles[dataJson["fileMD5"]];
				agenturVertraegeRefreshFileCounter();
				
			} else {
			
				if(dataJson.beginUpload){
	
					agenturVertraegeStartUpload(dataJson.fileMD5);
				} else {
					agenturVertraegeAskForProceed(dataJson.fileMD5);


					var progressBarSelector = 'progress.'+fileMD5;
					$(progressBarSelector).closest('.fileuploadPending').find('.vorhandeneDatei').html($(data).find('.vorhandeneDatei').html());

	

				}
			}
		});
		
		agenturVertraegeRefreshFileCounter();
	

		
	}

	function agenturVertraegeRefreshFileCounter(){
		var anzahlUploads = $('.fileuploadPending progress').length;
		var anzahlUploadsAbgeschlossen = $('.fileuploadPending progress[value="100"]').length;
		var anzahlUploadsAusstehend = anzahlUploads-anzahlUploadsAbgeschlossen;

		if(anzahlUploadsAusstehend>1) $('#uploadInformation').html(anzahlUploadsAusstehend+" Dateien werden hochgeladen"); else $('#uploadInformation').html(anzahlUploadsAusstehend+" Datei wird hochgeladen");

		if(anzahlUploadsAbgeschlossen==anzahlUploads) {
			
			// window.yourGlobalVariable = ...;
		
		  $('#uploadOverlay').hide();
		  $('body').removeClass('filedragAbsolute');
			
		  if(typeof agenturvertragToRefresh != "undefined") {
			  
			  
			  setTimeout(function(){ 
			  	loadAgenturvertragContent(agenturvertragToRefresh);
			  	delete agenturvertragToRefresh;
			  }, 1000);
			  
			  
		  }
		}
	}


	function agenturVertraegeAskForProceed(fileMD5){
		
		var progressBarSelector = 'progress.'+fileMD5;
		$(progressBarSelector).closest('.fileuploadPending').addClass('askForProceed');
		
		$(progressBarSelector).closest('.fileuploadPending').find( ".proceedCont .btn" ).bind( "click", function() {
		
			
			
			switch($(this).data('proceed-action')) {
				case 'rename':

					
					$(this).unbind( "click" );
					$(this).closest('.fileuploadPending').removeClass('askForProceed');
					agenturVertraegeStartUpload(fileMD5);
					break;
				case 'delete':
					agenturVertraegePendingFiles[fileMD5].formData.append('tx_dslintranet_downloadcenter[proceedAction]', 'delete');
					agenturVertraegePendingFiles[fileMD5].formData.append('tx_dslintranet_downloadcenter[fileName]', $(progressBarSelector).data('file-name'));
					$(this).unbind( "click" );
					$(this).closest('.fileuploadPending').removeClass('askForProceed');
					agenturVertraegeStartUpload(fileMD5);
					

					break;
				default:

					$(this).closest('.fileuploadPending').remove();
					delete agenturVertraegePendingFiles[fileMD5];
					agenturVertraegeRefreshFileCounter();
			}
			

			
		  	return false;
		});
		
	}

	function agenturVertraegeStartUpload(fileMD5){
		
	
		$.ajax({
			url: agenturVertraegePendingFiles[fileMD5].url,
			type: 'POST',
			data: agenturVertraegePendingFiles[fileMD5].formData,//$('#dateienUploadForm').serialize(),
			contentType: false,
			processData: false,
			success: function(data) {
				
				if(isJsonString(data)){
					dataJson = JSON.parse(data);
					if(dataJson["protokollePendingUid"]) {
						//benachrichtigung
						showMailFormProtokollePending(dataJson["protokollePendingUid"]);
					}

				}
			},
			xhr: function()
				  {

					var xhr = new window.XMLHttpRequest();
					var progressBarSelector = 'progress.'+fileMD5;

					xhr.upload.addEventListener("progress", function(evt){
					  if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						  $(progressBarSelector).val((percentComplete) * 100);
						  $(progressBarSelector).html( Math.ceil((percentComplete*100))+'% Abgeschlossen' );

						  if(percentComplete==1) {
							  $(progressBarSelector).closest('.fileuploadPending').remove();
							  delete agenturVertraegePendingFiles[fileMD5];
						  } else {
							  var remaining = evt.total-evt.loaded;
							  $(progressBarSelector).closest('.fileuploadPending').find('.fileSizeRemaining').html(Math.ceil((percentComplete*100))+'% - '+formatBytes(remaining,1));

						  }
						  
						  
						  agenturVertraegeRefreshFileCounter();
						  
					  }
					}, false);

					//Download progress
					xhr.addEventListener("progress", function(evt){

					  if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						//Do something with download progress

					  }
					}, false);
					return xhr;
				  }
		});
		
	}
