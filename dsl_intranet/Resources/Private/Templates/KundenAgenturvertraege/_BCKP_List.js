{namespace v=FluidTYPO3\Vhs\ViewHelpers}// JavaScript Document


var agenturvertraegeAjaxUrl = '<v:variable.get name="ajaxUrl" />';
var agenturvertraegeShowUrl = '<v:variable.get name="showUrl" />';

var chartAgenturvertraegeArr = new Object();
var chartAgenturvertraegeJahrArr = new Object();
var chartAgenturvertraegeDiagrammArr = new Object();
var monateArr = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];


var clickEvt;

var avJahr;



$(function() {
	
	var rangeMinDate = "01.{v:variable.get(name: 'range.minDate') -> f:format.date(format: 'm.Y')}";
	var rangeMaxDate = "31.{v:variable.get(name: 'range.maxDate') -> f:format.date(format: 'm.Y')}";
	
	avJahr = "01/{v:variable.get(name: 'range.maxDate') -> f:format.date(format: 'Y')}";
	
	
	
	moment.locale('de');
	
	

/*
var fechaFin = new Date();
var FromEndDate = new Date();
var ToEndDate = new Date();
*/


	//$('input[name="month"]').datetimepicker({
	$('input[name="month"]').daterangepicker({
		
		
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
		
		//$('#daterange').data('daterangepicker').setStartDate('03/01/2014');
	  
		
		avJahr = '01/'+start.format('YYYY');
		
		
	}).on('apply.daterangepicker', function(ev, picker) {
		

		var ajaxJson = {"tx_dslintranet_kundenagenturvertraege[switch]":'setNewRange',"tx_dslintranet_kundenagenturvertraege[month]":avJahr};
		

		dslIntranetAjaxCall(agenturvertraegeAjaxUrl,ajaxJson).done(function (data /* , textStatus, jqXHR */ ) {
			
		

			if(data=="error") {
			
					//closeAufgabenTab(id);
				} else {
					$('.refreshFilterAgenturvertraege').click();

					//aktualisierung von headlines
					$( $(data).find('.refreshContent') ).each(function( index ) {
					
					  $( '.refreshContent[data-refresh-content="'+$( this ).attr('data-refresh-content')+'"]').html($( this ).html());
					});


				
				}

		});


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
	  if($('.daterangeToggle').attr('data-show')!='true')  $('input[name="month"]').data('daterangepicker').toggle();
	});

		
	
});


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
	
	//var activeTab = $( "#agenturvertraegetabs_"+id ).tabs( "option", "active");
	$('#agenturvertraegeList tr[data-av-uid="'+id+'"]').addClass('tabReloads');
	var showAjaxJson = {"tx_dslintranet_kundenagenturvertraege[kundenAgenturvertraege]":id,"tx_dslintranet_kundenagenturvertraege[month]":avJahr};/*"tx_dslintranet_agenturvertragsliste[switch]":'show',*/
	dslIntranetAjaxCall(agenturvertraegeShowUrl,showAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		testData = data;
		
/*aktualisierung von headlines*/		
$( $(data).find('#content-list-row-headline').find('.refreshContent') ).each(function( index ) {
  $( '.refreshContent[data-refresh-content="'+$( this ).attr('data-refresh-content')+'"]').html($( this ).html());
});
		
		
		changeAgenturvertragContent(id,$(data).find('#content-show').html());
		
		
		//$("#agenturvertraegetabs_"+id).tabs({ active: activeTab }); 
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
	
	
	/*alter block*/
		
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
								data:[tmpKontingent,tmpOver],
								backgroundColor:["#14cb96","#ff0000"],
								hoverBackgroundColor:["#14cb96","#ff0000"],
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
							//return '';
							
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

				  /* other stuff that requires slice's label and value */
					

					$('#agenturvertragAuftraegeList'+id+'_schwebend').DataTable().search( '##'+monateArr[clickedElementindex]+'##' ).draw();
					$('#agenturvertragAuftraegeList'+id+'_abgeschlossen').DataTable().search( '##'+monateArr[clickedElementindex]+'##' ).draw();
					$('#agenturvertragAuftraegeList'+id+'_schwebend_wrapper input[type="search"]').trigger('keyup');
					$('#agenturvertragAuftraegeList'+id+'_abgeschlossen_wrapper input[type="search"]').trigger('keyup');
				}

		}
		initPlusMinusChartBtn();
		
		
		
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
					"width":'150px'
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
					"width":'140px'
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
			
			"order": [[ 0, "desc" ]],
			"columnDefs": [
				{
					"targets": [ 0 ],
					"orderable": true,
					"width": "50px"
				},
				
				
				{
					"targets": [ 1 ],
					"width": "350px"
				},
				{
					"targets": [ 2 ],
					"visible": true
				},
				{
					"targets": [ 3 ],
					"width": "120px"
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
				//test
						
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
	alert('gibt es hier nicht!!');
	
	
}

$(function() {
	initAccordionPanelAgenturvertraege("#agenturvertraegeAccordion a.panel-heading");
	
	//wenn es nur 1 AV gibt soll dieser geöffnet werden.
	if(jQuery('.agenturvertragToggleBtn').length==1){
	  jQuery('.agenturvertragToggleBtn').click();
	}

});