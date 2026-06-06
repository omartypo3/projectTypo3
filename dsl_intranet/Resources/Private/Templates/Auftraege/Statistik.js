var statistikElement = $("#statistik");
var statistikAjaxUrl = statistikElement.data('ajaxUrl');

var zaehlerStatistik = 0;

var chartAreaStatistikDiagramm = false;
var activeStatistikView = 'Woche';
var activeDateTimePicker = '';
var lastAutoHideDateTimePicker = '';

function toggleDateTimePicker(active){
	console.clear();
	console.log('---------------');
	console.log('toggleDateTimePicker('+active+')');
	console.log('activeDateTimePicker war: '+activeDateTimePicker+'');
	console.log('lastAutoHideDateTimePicker: '+lastAutoHideDateTimePicker+'');

	if(lastAutoHideDateTimePicker!='')  {
		if(lastAutoHideDateTimePicker == active){
			lastAutoHideDateTimePicker = '';
			return false;
		}
	}

	if(activeDateTimePicker!='') {

		console.log('if('+activeDateTimePicker+'!='+active+')');
		if(activeDateTimePicker!=active){
			console.log('anderer link');
			$('#statistikDatePicker'+activeDateTimePicker+' .input-group-addon').click();
			$('#statistikDatePicker'+active+' .input-group-addon').click();
			activeDateTimePicker = active;
		} else {
			//wenn es der gleiche ist
			console.log('aktuellen schließen! ('+active+')');
			$('#statistikDatePicker'+active+' .input-group-addon').click();
		}
	} else {
		console.log('DTP jetzt aktivieren: '+active);
		$('#statistikDatePicker'+active+' .input-group-addon').click();
		activeDateTimePicker =  active;
	}
	console.log('activeDateTimePicker ist jetzt: '+activeDateTimePicker);
}
function showStatistikView(active){

	console.log('show');

	activeStatistikView = active;
	$('.statistikWrapperactive').removeClass('statistikWrapperactive');
	$('.statistikDatePicker'+active+'Wrapper').addClass('statistikWrapperactive');

	if(chartAreaStatistikDiagramm) {
		chartAreaStatistikDiagramm.destroy();	
	}
	$('.chart-area-statistik-diagramm-loading').show();
	
	var ajaxJson = {"tx_dslintranet_statistik[switch]":"statistik", "tx_dslintranet_statistik[type]":active, "tx_dslintranet_statistik[date]":$('input[name="statistikDatePicker'+active+'Input"]').val()};
	dslIntranetAjaxCall(statistikAjaxUrl,ajaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
		if(isJsonString(data)){
			dataJson = JSON.parse(data);
			$('#statistikDatenProperties').data('diagramm-json',dataJson);
			initStatistikChart();
		}
		
	});
}


var rangeMinDate = new moment(statistikElement.data('rangeMinDate'));
var rangeMaxDate = new moment(statistikElement.data('rangeMaxDate'));

var statistikDatePickerWoche = false;

$(function() {
	
	moment.locale('de');

	moment.updateLocale('de', {
	  week: { dow: 1 }
	});
	
	$("#statistikDatePickerWoche").datetimepicker({
		format: 'DD.MM.YYYY',
		locale: 'de',
		minDate: rangeMinDate,
		maxDate: rangeMaxDate,
		keepInvalid: true
		
	}).on('dp.update', function (e) {
		console.log('statistikDatePickerWoche dp.update!!');
	}).on('dp.change', function (e) {
		
		console.log('statistikDatePickerWoche dp.change!!');
		console.log(e.date.isoWeekday());
		if(e.date.isoWeekday() == 7){//sonntag
			e.date.subtract(6, 'days');
		}
		$('input[name="statistikDatePickerWocheInput"]').val(e.date.day(1).format("DD.MM.YYYY"));
		
		
		$('input[name="statistikDatePickerJahrInput"]').val(e.date.format("YYYY"));
		$('input[name="statistikDatePickerMonatJahrInput"]').val(e.date.format("MMMM YYYY"));

		showStatistikView('Woche');
		
	}).on('dp.show', function (e) {
		console.log('statistikDatePickerWoche dp.show!!');
	}).on('dp.hide', function (e) {
		console.log('statistikDatePickerWoche dp.hide!!');
		console.log('activeDateTimePicker löschen / war: '+activeDateTimePicker);
		activeDateTimePicker = '';
		lastAutoHideDateTimePicker = 'Woche';
		setTimeout(function(){ lastAutoHideDateTimePicker=''; }, 300);
	});
	
	$('#statistikDatePickerMonatJahr').datetimepicker({
		viewMode: 'years',
		format: 'MMMM YYYY',
		locale: 'de',
		minDate: rangeMinDate,
		maxDate: rangeMaxDate,
	}).on('dp.change', function (e) {
		$('input[name="statistikDatePickerWocheInput"]').val(e.date.day(1).format("DD.MM.YYYY"));
		$('input[name="statistikDatePickerJahrInput"]').val(e.date.day(1).format("YYYY"));
		showStatistikView('MonatJahr');
	}).on('dp.hide', function (e) {
		activeDateTimePicker = '';
		lastAutoHideDateTimePicker = 'MonatJahr';
		setTimeout(function(){ lastAutoHideDateTimePicker=''; }, 300);
	});

	$('#statistikDatePickerJahr').datetimepicker({
		viewMode: 'years',
		format: 'YYYY',
		locale: 'de',
		minDate: rangeMinDate,
		maxDate: rangeMaxDate,
	}).on('dp.change', function (e) {
		$('input[name="statistikDatePickerMonatJahrInput"]').val(e.date.day(1).format("MMMM YYYY"));

		showStatistikView('Jahr');
	}).on('dp.hide', function (e) {
		activeDateTimePicker = '';
		lastAutoHideDateTimePicker = 'Jahr';
		setTimeout(function(){ lastAutoHideDateTimePicker=''; }, 300);
	});

	var wochenanfang = new moment(statistikElement.data('rangeMaxDate'));
	if(wochenanfang.isoWeekday() == 7){//sonntag
		wochenanfang.subtract(1, 'week');
	} 

	$('input[name="statistikDatePickerWocheInput"]').val(wochenanfang.day(1).format('DD.MM.YYYY'));

	initStatistikChart();
});



function initStatistikChart(){
	var diagramm = $('#statistikDatenProperties').data('diagramm-json');
	
	var yAxesLabel = 'Stunden';
	if(activeStatistikView == 'Jahr') yAxesLabel = 'Tage';
	
	var configDiagramm = {
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
				text: diagramm.titel,
				fontSize:30,
				padding:30
			},
			tooltips: {
				mode: 'index',
				intersect: false,
				callbacks: {
					label: function(tooltipItem, data) {
						
						if(data.datasets[tooltipItem.datasetIndex].label == "100%" || data.datasets[tooltipItem.datasetIndex].label == "50%") return false;
					
						
						if(!tooltipItem.yLabel) return false;
						var label = ' '+data.datasets[tooltipItem.datasetIndex].label || '';

						if (label) {
							label += ': ';
						}
						label += getZeitraumForMinutesShort(tooltipItem.yLabel);
						return label;
					},
					title: function(tooltipItem, data) {


						return tooltipItem[0].xLabel;


					}
				}
			},
			legend: {	
				position: 'bottom',	
				labels: {useLineStyle: true},
				labels: {
					filter:function(legendItem, data) {


						if(legendItem.text=='100%') {
							return false;
						}
						if(legendItem.text=='50%') {
							return false;
						}


						minutenMa = data.datasets[legendItem.datasetIndex].data.reduce(function (accumulator, currentValue) {
							return accumulator + currentValue;
						  }, 0);
						
						if(minutenMa){
							legendItem.text= legendItem.text+' - '+getZeitraumForMinutesShort(minutenMa);
						}
						return true;
					},
				},
			},
			responsive: true,
			
			scales: {
				yAxes: [{
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
							if(activeStatistikView == 'Jahr'){
								return value/60/8;
							} else return value/60;
							
							
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
	
	if(chartAreaStatistikDiagramm) {
		chartAreaStatistikDiagramm.destroy();
	}

	chartAreaStatistikDiagramm = new Chart(document.getElementById("chart-area-statistik-diagramm").getContext("2d"), configDiagramm);
	zaehlerStatistik++;
	$('.chart-area-statistik-diagramm-loading').hide();
}