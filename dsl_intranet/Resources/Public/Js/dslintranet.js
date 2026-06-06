// JavaScript Document


var globalData = new Array();




$(document).bind("ajaxSend", function(){
	$(".ajaxLoading").show();
	$("body").addClass('ajaxRequestActive');

	
}).bind("ajaxComplete", function(){

	if($.active==1)	{
		$("body").removeClass('ajaxRequestActive');
		$(".ajaxLoading").hide();

	}
});

$( document ).ajaxError(function(event, jqxhr, settings, thrownError ) {
 
	
	
	if(thrownError){
		
		if(thrownError=="Not Found"){
			$('#page-top').remove();
			window.top.location.reload();
			return true;	
		}
		if(thrownError=="Service Unavailable"){
			$('#page-top').remove();
			window.top.location.reload();
			return true;	
		}
		if(thrownError!='abort'){
			
			/*
			
			$.colorbox({width:"80%", height:"80%", html:errorData, close:'<i class="fa fa-times-circle"></i>', className:'colorbox_background',overlayClose: false });*/
		}
	} 
});

$(document).ready(function() {

	
		$(document).bind('cbox_cleanup', function(){
			
			var editor = tinyMCE.get('auftragEditBeschreibung');
			if(editor) {
				editor.remove();
			}
			var editor2 = tinyMCE.get('auftragEditNotizenIntern');
			if(editor2) {
				editor2.remove();
			}
		});

		// Example of using an event listener and public method to build a primitive slideshow:
		$(document).bind('cbox_closed', function(){
			if(doAjaxEditRequest) doAjaxEditRequest.abort();
		});
		initAjaxCalls();
		
});


// Example of using an event listener and public method to build a primitive slideshow:
$(document).bind('cbox_complete', function(){
	
	
	if (typeof initTinyMceEditor == 'function'){
	
		initTinyMceEditor();
	}
	
 
});


var doAjaxEditRequest = false;
	
function reInitAjaxCalls(){
	$( ".doAjax").unbind( "click" );
	$( ".doAjaxEdit").unbind( "click" );
	$( ".doConfirmAjax").unbind( "click" );
	$( ".doConfirmUserAjax").unbind( "click" );
	
	$( ".content_container_toggle").unbind( "click" );
	

	initAjaxCalls();
	
	$('[data-toggle="tooltip"]').tooltip();
	
	
}


function initAjaxCalls(){
	
	
	
	
	$('.selectpickerInit').selectpicker({
		template: {
		  caret: '<span class="fa fa-pencil"></span>'
		}
	});
	
	
	
	
	$(".content_container_toggle").click(function() {
		$(this).toggleClass('content_closed');
		
		if( $(this).hasClass('content_closed') ){
			$(this).closest('.content_container_header').next().hide();
			$(this).closest('.content_container_header').css('marginBottom','10px');
		} else {
			$(this).closest('.content_container_header').next().show();
			$(this).closest('.content_container_header').css('marginBottom','0px');
		}
	
		return false;
	});
	
	
	$(".doConfirmAjax").confirm({
		title: "Bestätigung erforderlich",
		content: "Wollen Sie diesen Eintrag wirklich löschen?",
		closeAnimation: 'none',
		buttons: {
			ja: {
				text: 'Ja (löschen)',
				btnClass: 'btn-danger',
				keys: ['enter', 'shift'],
				action: function(){
					
						doAjaxClick(this.$target);
					
					
					
				}
			},
			nein: {
				text: 'Nein (abbrechen)',
				btnClass: 'btn-default',
				keys: ['enter', 'shift'],
				action: function(){
					
				}
			}
		},
		onOpenBefore: function () {
			
			if($(this.$target).attr("data-ajax-click-block")){
				this.close();
				return false;
			}
			if( $(this.$target).attr("data-ajax-action") == 'resetZeiteintraegeCounter'){
				if(!$(this.$target).hasClass('timeToSave')) this.close();
			}
		}
	});
	
	
	$(".doConfirmUserAjax").confirm({
		title: "Bestätigung erforderlich",
		content: '',
		buttons: {
			ja: {
				text: 'Ja (bestätigen)',
				btnClass: 'btn-warning',
				keys: ['enter', 'shift'],
				action: function(){
					doAjaxClick(this.$target);
				}
			},
			nein: {
				text: 'Nein (abbrechen)',
				btnClass: 'btn-default',
				keys: ['enter', 'shift'],
				action: function(){
					
				}
			}
		},
		
		onOpen: function () {
			$(this.$content).html( $(this.$target).attr('data-text') );
			$('.jconfirm-buttons .btn-warning').html( $(this.$target).attr('data-warning-button') );
			//btn-warning
			
			//console.log( $(this.$buttons.ja).text() );
			//console.log( $(this.$buttons) );
			//console.log($(this).$buttons.ja);
			//console.log($(this).$buttons.ja.text);

		}
	});
	
	
	

	$( ".doAjax" ).click(function(e) {
		//e.preventdefault();
		doAjaxClick(this);
		return false;
	});
	
	
	var doAjaxEditColorBoxWidth = false;
	$( ".doAjaxEdit" ).click(function(e) {
		//e.preventdefault();
		
		var action = $(this).attr("data-ajax-action");
		console.log('doajaxedit action:'+action);	
		if(action){
			switch (action) {
				case "saveStoppuhr":
					if(!$(this).hasClass('timeToSave')) return false;
			}
		}
		//saveStoppuhr

		
		var doAjaxEditColorBoxHeight = '100%';var doAjaxEditColorBoxWidth = '100%';
		if( $(this).data('colorbox-width') ) doAjaxEditColorBoxWidth = $(this).data('colorbox-width'); 
		if( $(this).data('colorbox-height') ) {
			var maxWindowsHeight = $( window ).height()-10;
			var colorBoxHeight = parseInt($(this).data('colorbox-height'));
			if(maxWindowsHeight < colorBoxHeight) doAjaxEditColorBoxHeight=maxWindowsHeight+'px';  else doAjaxEditColorBoxHeight = $(this).data('colorbox-height');	
		}
		

		$.colorbox({width:"10%", height:"10%", className:'colorbox_background',overlayClose: false});
		
		doAjaxEditRequest = $.get($(this).attr("href"), function(data) {
			
			if($(data).length>10){
				window.top.location.reload();
				return false;
			}

			$.colorbox({
				width:doAjaxEditColorBoxWidth, 
				height:doAjaxEditColorBoxHeight, 
				html:data, 
				fixed:true, 
				reposition:true, 
				close:'',
				className:'colorbox_background',
				onComplete: function(){ 
					//oncomplete
				},
				onCleanup:function(){
						console.log('colorbox close editform!!!!');
					console.log('cancel button existiert noch ?::: '+$( ".pressCancelBtnOnClose button.btn-abort" ).length);
					
					if($( ".pressCancelBtnOnClose button.btn-abort" ).length) $( ".pressCancelBtnOnClose button.btn-abort" ).click();
					//if($( "#cboxLoadedContent button.btn-abort" ).length) $( "#cboxLoadedContent button.btn-abort" ).click();
					//alert('onclearup');
 				 },
				overlayClose: false
			});
		
		});
		
		
	  return false;
	});
	
	

	$('.content-row .csc-default a').tooltip({placement:'top'});		
	$('.content-row .csc-default span').tooltip({placement:'top'});		

}

	
	


function dslIntranetAjaxCall(ajaxUrl,dataJson) {
	
    return $.ajax({
        url: ajaxUrl,
        data: dataJson,
		cache: false,
		success:function (data) {
		
			
		}
    });
}

function dslIntranetAjaxCallWait(ajaxUrl,dataJson) {
	
    return $.ajax({
        url: ajaxUrl,
        data: dataJson,
		async: false,
		cache: false,
		success:function (data) {
		
			
		}
    });
}



	
	


/*stoppuhr*/
function initStoppuhr(selector){
	
	
	if(stoppUhrenArr[selector+'_clock']) {
		stoppUhrenArr[selector+'_clock'].stop();
		$(selector+'_clock').html('').removeClass('flip-clock-wrapper');
		$(selector+' a.toggleStoppuhr').removeClass('aktiv');
	}
	
	
	stoppUhrenArr[selector+'_clock'] = $(selector+'_clock').FlipClock({
		clockFace: 'HourlyCounter',
		language: 'de',
		autoStart: false,
		callbacks: {
			interval: function() {
				/* this.factory.getTime().time; // sekunden */
				
				var checkToDestroy = false;
				if(!$(this.factory.$wrapper.selector).length) checkToDestroy=true; else if(!$(this.factory.$wrapper.selector).hasClass('flip-clock-wrapper')) checkToDestroy=true;
				//Achtung Uhr läuft noch im js, ist aber nicht initialisiert > vernichten 
				if(checkToDestroy) stoppUhrenArr[this.factory.$wrapper.selector].stop();
			},
			init: function(){ },
			start: function() { },
			stop: function() { }
		}
	});
	
	if($(selector+'_clock').hasClass('stoppuhr_init')){
		if($(selector+'_clock').data('kontingent')){
			stoppUhrenArr[selector+'_clock'].setTime($(selector+'_clock').data('kontingent'));
		}
		if($(selector+'_clock').data('zeitnahme')){
			$(selector+' a.toggleStoppuhr').addClass('aktiv');
			stoppUhrenArr[selector+'_clock'].start();
		}
		$(selector+'_clock').removeClass('stoppuhr_init');
	}
	
	checkStoppuhrToSave(selector);
	
	
}


function stopStoppuhr(selector,auftraegeUid){
	if(stoppUhrenArr[selector+'_clock']){
		if(stoppUhrenArr[selector+'_clock'].running){
			$(selector+' a.toggleStoppuhr').removeClass('aktiv');
			stoppUhrenArr[selector+'_clock'].stop();
			
		}
	}
	setTimerClass(auftraegeUid,'stop');
}

function toggleStoppuhr(selector){
	
	console.log('function toggleStoppuhr('+selector+')');
	
	
	if(stoppUhrenArr[selector+'_clock'].running){
		console.log('stoppuhrenarr running exists: '+selector+'_clock');

		var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'stopZeiteintrag',"tx_dslintranet_auftragsliste[uid]":$(selector).data('auftraege-uid'),"tx_dslintranet_auftragsliste[kontingent]":stoppUhrenArr[selector+'_clock'].getTime().time-1};
		dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
			console.log('ajaxdone 1');

			dataJson = JSON.parse(data);


			if(!dataJson['isValidToTrack']) return refreshProjektTabContent(dataJson['auftraegeUid']);//autostop aktiv auftrag neu laden!!
			
			stoppUhrenArr[selector+'_clock'].setTime(dataJson['kontingent']);
			stopStoppuhr(selector,dataJson['auftraegeUid']);
			
			
		});
		
		
	} else {
		
		
		//aktiver auftrag in den favoriten bei dem gerade die stoppuhr läuft
		var aktiverAuftragUid = parseInt( $('a.timerZeitnahmeAktiv').parent('li').attr('data-load-id') );
		
		console.log('else aktiverAuftrag in den Favoriten: aktiverAuftragUid:'+aktiverAuftragUid);
		
		//stoppuhr starten
		$(selector+' a.toggleStoppuhr').addClass('aktiv');
		
		
		var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'startZeiteintrag',"tx_dslintranet_auftragsliste[uid]":$(selector).data('auftraege-uid')};
		dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
			
			console.log('ajaxdone 2');
			dataJson = JSON.parse(data);
			
			console.log('autostop begin');
			if(!dataJson['isValidToTrack']) return refreshProjektTabContent(dataJson['auftraegeUid']);//autostop aktiv auftrag neu laden!!
			console.log('autostop ende');
			
			if(dataJson['PartialTabTitel']) {

				$( '#aufgaben_tabs>ul>li>a[href="#auftrag-show-'+dataJson['auftraegeUid']+'"]' ).html(dataJson['PartialTabTitel']);
				//#auftrag-show-337
			}
			
			stoppUhrenArr[selector+'_clock'].setTime(dataJson['kontingent']);
			stoppUhrenArr[selector+'_clock'].start();				
			
			if(dataJson['PropertiesToolbarCounterBtn']){
				$('#stoppuhr_'+dataJson['auftraegeUid']+' .table-toolbar-col-counter-btn').html(dataJson['PropertiesToolbarCounterBtn']);
				reInitAjaxCalls();
				
				//alert(dataJson['PropertiesToolbarCounterBtn']);	
			}
			
			setTimerClass(dataJson['auftraegeUid'],'start');

			checkStoppuhrToSave(selector); // abgelöst durch nächste zeile
			if(aktiverAuftragUid) {
				console.log('if(aktiverAuftragUid) ist wahr also stopStoppuhr und checkStoppuhrtosave');
				stopStoppuhr('#stoppuhr_'+aktiverAuftragUid,aktiverAuftragUid);
				checkStoppuhrToSave(selector); 
			} else console.log('kein aktiver auftrag');
			
			
		});

	}
	
	
}



function checkStoppuhrToSave(selector){
	
	console.log('function checkStoppuhrToSave('+selector+')');
	
	if(stoppUhrenArr[selector+'_clock'].getTime().time){
		$(selector+' a.saveStoppuhr').addClass('timeToSave');
		$(selector+' a.resetStoppuhr').addClass('timeToSave');
	} else {
		$(selector+' a.saveStoppuhr').removeClass('timeToSave');
		$(selector+' a.resetStoppuhr').removeClass('timeToSave');
	}
}	

function setTimerClass(uid,action){
	

	
	
	if(action=='start'){
		$('#aufgaben_tabs>ul a').removeClass('timerZeitnahmeAktiv');
		$('a[href$="#auftrag-show-'+uid+'"]').removeClass('timerZeitnahmePause');
		$('a[href$="#auftrag-show-'+uid+'"]').addClass('timerZeitnahmeAktiv');

	}
	if(action=='stop'){
		$('a[href$="#auftrag-show-'+uid+'"]').removeClass('timerZeitnahmeAktiv');
		$('a[href$="#auftrag-show-'+uid+'"]').addClass('timerZeitnahmePause');	
	}
	
	if(action=='reloadActive'){
		$('#aufgaben_tabs>ul a').removeClass('timerZeitnahmeAktiv');
		$('a[href$="#auftrag-show-'+uid+'"]').addClass('timerZeitnahmeAktiv');
	}
	if(action=='reloadPaused'){
		$('a[href$="#auftrag-show-'+uid+'"]').removeClass('timerZeitnahmeAktiv');
		$('a[href$="#auftrag-show-'+uid+'"]').addClass('timerZeitnahmePause');	
	}
	if(action=='reloadNone'){
		$('a[href$="#auftrag-show-'+uid+'"]').removeClass('timerZeitnahmeAktiv');
		$('a[href$="#auftrag-show-'+uid+'"]').removeClass('timerZeitnahmePause');	
	}


}
function refreshAuftragAktivitaet(el){
	var tabPanel = $(el).parents('.ui-tabs-panel').first();
	var uid = tabPanel.find('.auftraegeAktivitaetDatePicker').first().data('auftraege-uid');
	reloadAuftragAktivitaet(uid,$('#auftraegeAktivitaetDatePickerInput'+uid).val());
}

function reloadAuftragAktivitaet(uid,datum){
	
	
	

		$('.auftraegetabs_'+uid+'_aktivitaet_tab').addClass('tabAktivitaetReloads');

		var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'loadAktivitaet',"tx_dslintranet_auftragsliste[uid]":uid,"tx_dslintranet_auftragsliste[datum]":datum};
		dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
			dataJson = JSON.parse(data);
			
			$('#auftraegetabs_'+dataJson['uid']+'_aktivitaet_datum').html(dataJson['datum']);
			$('#auftraegetabs_'+dataJson['uid']+'_aktivitaet').html(dataJson['content']);
			
			$('.auftraegetabs_'+uid+'_aktivitaet_tab').removeClass('tabAktivitaetReloads');
			reInitAjaxCalls();
			

		});




}



/*Uhrzeit*/

(function ($) {

$.fn.simpleClock = function () {

    // Define weekdays and months
    var weekdays = ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"]
    var months = ["Jan", "Feb", "Mär", "Apr", "Mai", "Juni", "Juli", "Aug", "Sep", "Okt", "Nov", "Dez"];

    // getTime - Where the magic happens ...
    function getTime() {
      var date = new Date(),
      hour = date.getHours();
      return {
        day: weekdays[date.getDay()],
        date: date.getDate(),
        month: months[date.getMonth()],
        hour: appendZero(hour),
        minute: appendZero(date.getMinutes()),
        second: appendZero(date.getSeconds())
      };
    }

    // appendZero - If the number is less than 10, add a leading zero. 
    function appendZero(num) {
      if (num < 10) {
        return "0" + num;
      }
      return num;
    }

    // refreshTime - Build the clock.
    function refreshTime() {
      var now = getTime();
      $('#date').html(now.day + ', ' + now.date + '. ' + now.month);
      $('#time').html("<span class='hour'>" + now.hour + "</span>" + "<span class='minute'>" + now.minute + "</span>" + "<span class='second'>" + now.second + "</span>");
    }

    // Tick tock - Run the clock.
    refreshTime();
    setInterval(refreshTime, 1000);

  };
})(jQuery);


$(document).ready(function() {
    $("#clock").simpleClock();
});
  
  




/*Auftragsdetail*/


function initDateTimePicker(){
	
		
	/* Allgemeine Datepicker Definitionen */
	$('.formDatePicker').datetimepicker({
		lang:'de',
		i18n:{
		  de:{
		   months:[
			'Januar','Februar','März','April',
			'Mai','Juni','Juli','August',
			'September','Oktober','November','Dezember',
		   ],
		   dayOfWeek:[
			"So", "Mo", "Di", "Mi", 
			"Do", "Fr", "Sa",
		   ]
		  }
		},dayOfWeekStart:1,todayButton:false,datepicker:true,timepicker:false,format:'d.m.Y'
	});
		
	$('.formDateTimePicker').datetimepicker({
		
		lang:'de',
		i18n:{
		  de:{
		   months:[
			'Januar','Februar','März','April',
			'Mai','Juni','Juli','August',
			'September','Oktober','November','Dezember',
		   ],
		   dayOfWeek:[
			"So", "Mo", "Di", "Mi", 
			"Do", "Fr", "Sa",
		   ]
		  }
		},dayOfWeekStart:1,todayButton:false,datepicker:true,timepicker:true,format:'d.m.Y H:i'
	});
		
	

}
function initNumberFields(){
	$('.numberFieldPrice').numberField({
		ints: 4,
		floats: 2,
		separator: ","
	});
}
function initMultipleSelect(selector){

	$(selector).change(function() {
	
	
	}).multipleSelect({
		
		single: true,
		width: '350'
	});
	
	
}	
function initSpinner(){
	$( ".spinnerIntVal" ).spinner({
		numberFormat: "n",
		min: 0,
		change: function (event, ui ) {	spinnerIntValSet($(this)); },
		stop: function (event, ui ) { spinnerIntValSet($(this)); }
	});
	
	$( '.spinnerIntVal' ).each(function( index ) {
		if($(this).data('hiddenfieldtosave')) $(this).val($($(this).data('hiddenfieldtosave')).val());
	});
	function spinnerIntValSet(spinner){
		spinner.val(parseInt(spinner.val()));
		if(spinner.val()=='NaN' || spinner.val()==0) spinner.val('');
		$(spinner.data('hiddenfieldtosave')).val(spinner.val());
	}	
}






/* Auftragtabs */

function initAuftragsTab(auftraegeUid){
	
	setTimeout(function(){ 
		
		//auf Stoppuhr prüfen und initialisieren
		$( ".stoppuhr_init" ).each(function( index ) {
		 
		});
		
		console.log('auftraegeUid',auftraegeUid);
		console.log('auftraegeUidlength',$('#chart-area-phasen-'+auftraegeUid).length);

		if($('#chart-area-phasen-'+auftraegeUid).length>0){
		
			
			chartPhasenArr[auftraegeUid] = new Chart(document.getElementById("chart-area-phasen-"+auftraegeUid).getContext("2d"), 
				{
					type: 'doughnut',
					data: jQuery.parseJSON( $('#auftraegeSettingsPhasenJson'+auftraegeUid).val() ),
					options: {
						legend: {
							display: false
						},
						responsive: true,
						showTooltips: false,
						tooltips: { enabled: false }
						
					}
				}
			
			);
			
				
			
		}
	}, 500);
	
	
}



function getZeitraumForMinutes(minutenGesamt){
	
	var stunden = Math.floor(minutenGesamt/60);
	var minuten = Math.floor(minutenGesamt-(stunden*60));
	
	if(!stunden && !minuten) return 0;
	if(!stunden && minuten) return minuten+' Min';
	if(stunden && !minuten) return stunden+' Std';
	if(stunden && minuten) return stunden+' Std'+' '+minuten+' Min';
	
	return 'error';
}
function getZeitraumForMinutesShort(minutenGesamt){
	
	var stunden = Math.floor(minutenGesamt/60);
	var minuten = Math.floor(minutenGesamt-(stunden*60));
	

	var retString = '';
	if(stunden){
		if(stunden>9){
			retString=stunden;
		} else {
			retString='0'+stunden;
		}
	} else {
		retString='00';
	}
	retString=retString+':';
	if(minuten){
		if(minuten>9){
			retString=retString+''+minuten;
		} else {
			retString=retString+'0'+minuten;
		}
	} else {
		retString=retString+'00';
	}
	retString=retString+' h';
	return retString;

	if(!stunden && !minuten) return '00:00 h';
	if(!stunden && minuten) {
		return '00:'+minuten+' h';
	}
	if(stunden && !minuten) return stunden+' Std';
	if(stunden && minuten) return stunden+':'+' '+minuten+' h';
	
	return 'error';
}


function doAjaxClick(element){
	
	
	
	var action = $(element).attr("data-ajax-action");
	var selector = $(element).attr("data-ajax-selector");
	var id = $(element).attr("data-ajax-id");
	var selectorDataTable = $(element).attr("data-table");

	
	var href = '';
	var returnVar = false;
	if($(element).attr("data-href")) {
		href = $(element).attr("data-href");
		returnVar = true;
	} else href = $(element).attr("href");
	
	
	
	
	
	//aktionen vor dem ajax
	if(action){
		switch (action) {
			case "changeInAgenturvertrag":
				
				$('#agenturvertraegeList tr[data-av-uid="'+id+'"]').addClass('tabReloads');
			break;
			case "reloadPageAfterFinished":
				
				$('html').css('opacity',0.6);
				$('html').css('pointer-events','none');
			break;
			case "throwEvent":
				console.log(action);
				console.log($(element).attr("data-ajax-event"));
				console.log(selector);
				$(document).trigger($(element).attr("data-ajax-event"), {   action: 'before', selector: selector  });
				//console.log($(element).attr("data-ajax-event"));
			break;
			case "removeSelectorProjekte":
				$(  selector  ).remove();
				setProjekteCounter();
			break;	
			case "removeSelectorAgenturvertraege":
				$(  selector  ).remove();
				setAgenturvertraegeCounter();
			break;	
			case "toggleKundeDisable":
				
				$(element).children('.btn').toggleClass('active');

				var disable = 0;
				if($(element).children('.btn').hasClass('active')){

				} else {
					disable = 1;
				}
				
				var updateAjaxJson = {"tx_dslintranet_kundenliste[switch]":'toggleDisable',"tx_dslintranet_kundenliste[uid]":id,"tx_dslintranet_kundenliste[disable]":disable};

				dslIntranetAjaxCall(kundenAjaxUrl,updateAjaxJson).done(function (data  ) {

				
					
					
					dataJson = JSON.parse(data);
					var resArr = Array();
					$( $(dataJson["contentShow"]).find('td') ).each(function( index ) {		resArr[index] = $(this).html();  });
					$('#kundenList').DataTable().row( '#kundenListKunde_'+dataJson["uid"] ).data( resArr );

					reInitAjaxCalls();


				});
				
				
				
				returnVar = true;
				
			break;
			case "aufgabeChangeMitarbeiter":
				$('.clickedEvent').removeClass('clickedEvent');
				$('#wochenplanung_kalender .dropdown-menu').hide();
				
				$("#wp_aufgaben_uid_"+id).prepend('<i class="fa fa-spin fa-gear fa-fw"></i> ');
				$("#wp_aufgaben_uid_"+id+" .fc-title").css("left", "+=20");
				
			break;
			case "auftraegeStatusChange":
				
				console.log("auftraegeStatusChange");
				
				prepareTabReloads(id);
				$(selector).css('opacity',0.6);
				
				$('[data-auftrag-uid="'+id+'"]').attr('data-auftrag-status',$(element).data('status-new'));
				
				$('#select_listablage_auftrag_'+id+'_statuswechsel').selectpicker('val', '#listablage_auftrag_'+id+'_statuswechsel_'+$(element).data('status-new'));
				$('#select_list_auftrag_'+id+'_statuswechsel').selectpicker('val', '#list_auftrag_'+id+'_statuswechsel_'+$(element).data('status-new'));
				
			break;
			case "showKennwort":
				if($(selector+' .content').val()) {
				
					$(selector+' .content').val('');
					$(selector).removeClass('loading');
					$(selector+' .content').addClass('hide');
					return false;
				}
				$(selector).addClass('loading');
			
				
			break;

			case "toggleErledigt":
				$('#wp_aufgaben_uid_'+id).parent().toggleClass('erledigt');
			
			break;
			
			

			case "showAuftrag": 
				$('.kanbanWrapper').removeClass('kanbanActive');//falls die aufgabenplanung aktiv ist
				addProjektTab("auftrag-show-"+id);
				
				return false;
			break;
			case "setOpenAuftrag": 
				setOpenAuftrag(id,href);
				
				return false;
				
				
			break;

			case "deleteAufgabe":
			
				$('#wochenplanung_kalender').fullCalendar('removeEvents', id);/*achtung events werden neu gerendert / daher ist auch eine neue doAjax */
				
			break;
			
			case "removeSelector": 
			
				$(  selector  ).remove();
			break;
			
				
			
			
			case "removeSelectorWartungsvertraegeZeiteintraege":
				$(  selector  ).remove();				
			break;
			
			case "wartungCheckRechnung":
				$(selector).closest('div.panel.panel-default').addClass('tabReloads');
			
			break;
			case "wartungCheckZeitraum":
				$(selector).closest('div.panel.panel-default').addClass('tabReloads');
			break;
			
			case "removeSelectorZeiteintraege":
				$(selector).remove();	
			break;
			
			case "removeSelectorAuftraege":
				//entfernen evtl. bestehender DetailBtns in der Kalenderansicht
				$('li.showAuftragDetailBtn'+id).remove(); 
				
				//evtl entfernen wenn er in den favoriten war
				$('#favoritenAblageList tr[data-auftrag-uid='+id+'] .toggleAblage').click();
				
				closeProjektTab(id);
			break;
			case "showColorbox":
				$.colorbox({width:"10%", height:"10%", close:'<i class="fa fa-times-circle"></i>', className:'colorbox_background',overlayClose: false });
			break;
			case "removeSelectorHosting":
			case "hostingNextRechnung":
				$('#hostingList_processing').css( 'display','block'  );

				$('#hostingList').css('opacity',0.6);
				$('#hostingList').css('pointer-events','none');
			break;
				
			case "toggleDateienSichtbarkeit":
			
			case "removeSelectorDateien":
				$('#auftrag-show-'+id).addClass('tabReloads');
			break;	
			case "sendKundeninfoMailDatei":
				//selector z.B. #auftraegeProtokolleListAuftrag_1061
				//index.php?id=12&no_cache=1&tx_dslintranet_auftragsliste%5Buid%5D=1061&tx_dslintranet_auftragsliste%5Bswitch%5D=sendKundeninfoMailDatei&tx_dslintranet_auftragsliste%5Baction%5D=ajax&tx_dslintranet_auftragsliste%5Bcontroller%5D=Auftraege&cHash=03c074441f8fcb4c0815fd8c9bd62cb3
				$(selector).addClass('tabReloads');
			break;
			case "toggleSichtbarkeitDateien":
				
				//$(selector).addClass('tabReloads');
			break;
				
				
			case "removeSelectorDatatable":
				$(selectorDataTable).DataTable().rows( selector ).remove().draw();
			break;
			case "removeSelectorDatatableFavoritenAblage":
				$(selectorDataTable).DataTable().rows( selector ).remove().draw();
				$('.toggleAblage[data-auftrag="'+id+'"]').attr('data-ablage',0);
				
			break;
			
			case "toggleKundeninfoSichtbarkeit":
			case "sendKundeninfoMail":
				$(selector).fadeTo( "slow", 0.7 );
			break;				
			
			
			
				
			case "toggleZeiteintraegeSichtbarkeit":
				$(selector).parent().addClass('ajaxLoading');
			break;
			case "toggleAuftraegeSichtbarkeit":
				$(selector).parent().addClass('ajaxLoading');
			break;
			case "toggleAuftraegeSichtbarkeitBtn":
				/*$(selector).addClass('ajaxLoading');*/
			break;			
			
			case "removeWartungsvertraege":
				$('#wartungsvertraegeList tr[data-wv-uid="'+id+'"]').remove();

			break;
			case "removeSelectorDatatableAjaxSource":
			
				
				$(element).attr("data-ajax-click-block","true");
				
			break;
			
				
		}
		
	}

	
	if (typeof urlaubs_jahr !== 'undefined') {

	    href = href.replace("--ajaxReplace--urlaubs_jahr--", urlaubs_jahr);
	}
	if(href) {
		
	
		
		$.get(href, function(data) {

			//aktionen mit resultat
			switch (action) {
				case "sendKundeninfoMailRechnungInAgenturvertrag":
					console.log("sendKundeninfoMailRechnungInAgenturvertrag");
					dataJson = JSON.parse(data);
					if(dataJson["protokollePendingUid"]){
						showMailFormProtokollePending(dataJson["protokollePendingUid"]);
					}
				break;
				case "changeInAgenturvertrag":
					loadAgenturvertragContent(id);
					
					
				break;
				case "reloadPageAfterFinished":
					document.location.reload();
				break;	
				case "throwEvent":
					$(document).trigger($(element).attr("data-ajax-event"), {   action: 'finished', selector: selector , data: data  });
					//console.log($(element).attr("data-ajax-event"));
				break;
					
				case "removeSelectorDatatableAjaxSource":
					
					//klappt zwar aber es wird die komplette tabelle neu geladen und nicht nur die eine zeile entfernt
					//$(selectorDataTable).DataTable().rows( selector ).remove().draw();
					$(selector).remove();
				//	$(selectorDataTable).css('opacity',1);
				//	$(selectorDataTable+'_processing').hide();
				break;
				case "aufgabeChangeMitarbeiter":

					dataJson = JSON.parse(data);
					$('#wochenplanung_kalender').fullCalendar('removeEvents', dataJson['id']);
					$('#wochenplanung_kalender').fullCalendar('renderEvent',  dataJson);

				break;
				case "auftraegeStatusChange":
					console.log('auftraegeStatusChange');
					$(selector).css('opacity',1);
					dataJson = JSON.parse(data);
					//$(selector+' .kundeninfoDateTime').attr('title','gesendet an: '+);
					//console.log(dataJson);
					if($(element).data('status-new')==70){ //auftrag im tab schließen da er auf rechnung schreiben gesetzt wurde.
						
						if($('#aufgaben_tabs .ui-tabs-nav .ui-tabs-tab a[href="#auftrag-show-'+dataJson["uid"]+'"]').length) {
							
							$('#aufgaben_tabs .ui-tabs-nav .ui-tabs-tab a[href="#auftrag-show-'+dataJson["uid"]+'"]').find('.trackerToSaveLink').removeClass('trackerToSaveLink');
								
								$('#aufgaben_tabs .ui-tabs-nav .ui-tabs-tab a[href="#auftrag-show-'+dataJson["uid"]+'"]').next().click();
								dataTableReload();
								break;
							
						}
					}
					
					//console.log(dataJson["uid"]);
					
					if($('#aufgaben_tabs ul li a .auftraegeUid[data-auftraege-uid="'+dataJson["uid"]+'"]').length) {
						refreshProjektTabContent(dataJson["uid"]);
					}
					
					if(dataJson["protokollePendingUid"]) {
						showMailFormProtokollePending(dataJson["protokollePendingUid"]);
					}
					
					dataTableReload();
				
				break;
				case "showKennwort":
					$(selector).removeClass('loading');
					$(selector+' .content').removeClass('hide');
					$(selector+' .content').val(data);


				break;
				case "acceptUrlaub":
				case "refuseUrlaub":
					
					loadUrlaubs(urlaubs_jahr);
					dataTableReload();
				break;

				case "showColorbox":
					
					
					var doAjaxEditColorBoxHeight = '100%';var doAjaxEditColorBoxWidth = '100%';
					if( $(element).data('colorbox-width') ) doAjaxEditColorBoxWidth = $(element).data('colorbox-width'); 
					if( $(element).data('colorbox-height') ) {
						var maxWindowsHeight = $( window ).height()-10;
						var colorBoxHeight = parseInt($(element).data('colorbox-height'));
						if(maxWindowsHeight < colorBoxHeight) doAjaxEditColorBoxHeight=maxWindowsHeight+'px';  else doAjaxEditColorBoxHeight = $(element).data('colorbox-height');	
					}
					
					
					$.colorbox({width:doAjaxEditColorBoxWidth, height:doAjaxEditColorBoxHeight, html:data, close:'<i class="fa fa-times-circle"></i>', className:'colorbox_background',overlayClose: false });
				break;

				case "removeSelectorAuftraege"://eigentlich auftrag löschen

					if($('.refreshAuftragList'+id).length) dataTableReload();
					
				break;
					
				case "sendKundeninfoMailDatei":
					
					//alert('aftersend');
					
					if(data){
					
						dataJson = JSON.parse(data);
					//	console.log('selector:'+selector);
						if(dataJson["data"]){
							$(selectorDataTable).DataTable().row( selector ).data( dataJson["data"] );
							reInitAjaxCalls();
							reInitTitleEdit();
						}
						$(selector).removeClass('tabReloads');
						
					} else {
						//alert('Fehler ist aufgetreten: ERR0001.');
						refreshProjektTabContent(id);
					}
				break;
				case "toggleDateienSichtbarkeit":
					refreshProjektTabContent(id);
					
				break;	
				case "toggleSichtbarkeitDateien":

					dataJson = JSON.parse(data);
					
					if(dataJson["data"]){
					
					$(selectorDataTable).DataTable().row( selector ).data( dataJson["data"] );
						reInitAjaxCalls();
						reInitTitleEdit();
					}
					//$(selector).removeClass('tabReloads');
					
				break;
				case "removeSelectorDateien":
					$(selector).remove();
					refreshProjektTabContent(id);
				
				break;
				case "removeSelectorWartungsvertraegeZeiteintraege":
					loadWartungsvertragContent(id);
				break;
				case "wartungCheckRechnung":
					loadWartungsvertragContent(id);
				break;
				case "wartungCheckZeitraum":
					loadWartungsvertragContent(id);
				break;

				case "removeSelectorZeiteintraege":
					refreshProjektTabContent(id);
				break;
				
				case "resetZeiteintraegeCounter":
					refreshProjektTabContent(id);
				break;

				case "deleteUrlaub": /*noch genutzt??? bzw wird das im wochenkalender genutzt?*/
	
					loadUrlaubs(urlaubs_jahr);
					dataTableReload();
	

				break;
				case "removeSelectorHosting":
				case "hostingNextRechnung":
					dataTableReload();
				break;
				case "toggleAuftraegeSichtbarkeit":

					$(selector).parent().removeClass('ajaxLoading');
					if(data==1)	{
						$(selector).parent().addClass('aktiv'); 
					} else {
						$(selector).parent().removeClass('aktiv');
					}

				break;
				case "toggleZeiteintraegeSichtbarkeit":

					$(selector).parent().removeClass('ajaxLoading');
					if(data==1)	{
						$(selector).parent().addClass('aktiv'); 
					} else {
						$(selector).parent().removeClass('aktiv');
					}

				break;
				case "toggleAuftraegeSichtbarkeitBtn":
				case "toggleAuftraegeSichtbarkeitTextBtn":

					//$(selector).removeClass('ajaxLoading');
					if(data==1)	{
						$(selector).addClass('btnGruen'); 
					} else {
						$(selector).removeClass('btnGruen');
					}

				break;
					
				case "toggleKundeninfoSichtbarkeit":
				case "sendKundeninfoMail":
					if(isJsonString(data)){
						dataJson = JSON.parse(data);
						dataTableRowChange('#protokolleList'+dataJson["auftrag"],selector,dataJson["contentShow"]);
					}
					
				break;
				
				
				case "toggleErledigt":
					aufgabenKalender.fullCalendar( 'refetchEvents' );//da sonst beim verschieben die events wieder resetet werden
				
				break;

			}		
			
			$(element).removeAttr("data-ajax-click-block","true");
			
			if (typeof(dataJson) != "undefined"){
			//if(dataJson){
				if(dataJson["protokollePendingUid"]){
				//	console.log('Formular für den Versand von E-Mails öffnen falls dieses nicht bereits offen ist: dataJson["protokollePendingUid"]:'+dataJson["protokollePendingUid"]);
					showMailFormProtokollePending(dataJson["protokollePendingUid"]);

				}
				delete dataJson;
			}
				

		}).fail(function() {
			$(element).removeAttr("data-ajax-click-block","true");
			
			//console.log('!!!ajaxloadingERROR !!! ***************** '+href);
			//alert('woops'); // or whatever
		});
	
	}
	
	$(element).removeAttr("data-ajax-click-block","true");
	
	//$(element).attr("data-ajax-clicked","true");
	
	if(returnVar == false) {
		
		return false;
		
	}
	

}
/*function showMailFormProtokollePending(protokollePendingUid){
	console.log('showMailFormProtokollePending('+protokollePendingUid+')');
}*/

function dataTableRowChange(dtSelector,dtRowSelector,content){

	$(dtRowSelector).fadeTo( "fast", 1 );
	
	var resArr = Array();
	$( $(content).find('td') ).each(function( index ) {	

		if($(this).data('sort')) {
			resArr[index] = {"display":$(this).html(),"@data-sort":$(this).data('sort')};  
		} else {
			resArr[index] = $(this).html();  
		}
	});
	
	$(dtSelector).DataTable().row( dtRowSelector ).data( resArr );

	reInitAjaxCalls();

}

function dataTableRowAdd(dtSelector,content){
					
	$(dtSelector).DataTable().row.add( $(content) ).draw( true );

	reInitAjaxCalls();

}


function showNotAllowedToCloseAuftraegeTab(trackerToSave){

	$.confirm({
		title: "Offener Tracker!",
		content: "Wollen Sie die aufgezeichnete Zeit jetzt Stoppen & Speichern?",
		
		buttons: {
			ja: {
				text: 'Ja (speichern) <i class="fa fa-floppy-o"></i>',
				btnClass: 'btn-info',
				keys: ['enter', 'shift'],
				action: function(){
					trackerToSave.click();
					//doAjaxClick(this.$target);
				}
			},
			nein: {
				text: 'Nein (abbrechen)',
				btnClass: 'btn-default',
				keys: ['enter', 'shift'],
				action: function(){
					
				}
			}
		}
		
		
	});	
	
}

function pad(n){return n<10 ? '0'+n : n}


function validateFormInvalidHandler(validator){
	var errors = validator.numberOfInvalids();
	if (errors) {
	  var message = errors == 1
		? 'Fehler' 
		: 'Fehler';
		/*var message = errors == 1
		? 'Eine Eingabe ist Fehlerhaft und wurde hervorgehoben.'
		: 'Es traten ' + errors + ' Fehler auf. Die fehlerhaften Eingaben wurden hervorgehoben.';*/
	  $(".colorbox_footer .requiredMessageWrapper .requiredMessage").html(message);
	  $(".colorbox_footer .requiredMessageWrapper").show();
	} else {
	  $(".colorbox_footer .requiredMessageWrapper").hide();
	}
}
function validateFormInvalidHandlerReset(){
	$(".colorbox_footer .requiredMessageWrapper").hide();
}


function changedWindowHeight(){
	var headerHeight = parseInt($('body').css('padding-top'));
	 //$( "#window_sizes" ).html( "<center>"+$( window ).height()+' x<br> '+$( window ).width() + " px</center>" );
	 $( ".dsl-split-html" ).height($( window ).height()-headerHeight);
	 $( ".dsl-split-body" ).height($( window ).height()-headerHeight);
 	 $( ".dsl-split-html,.dsl-split-body" ).css('min-height',($( window ).height()-headerHeight)+'px');

	 if(!$( ".dsl-split-html" ).length) $( "body>.fsc-default.list:not(#c425,#c434,#c493,#c485,#c502,.noAutoHeight)" ).height($( window ).height()-headerHeight);

	 $( ".pageToolbarSetHeight" ).height($( window ).height()-headerHeight);
}

$(document).ready(function() {

	$('.pageToolbarButtonFirstGroup').each(function(){ $(this).appendTo('.pageToolbarContentFirstGroup'); });
	$('.pageToolbarButtonSecondGroup').each(function(){ $(this).appendTo('.pageToolbarContentSecondGroup'); });
	$('.pageToolbarButtonThirdGroup').each(function(){ $(this).appendTo('.pageToolbarContentThirdGroup'); });
	
	if($('.pageToolbarContentFirstGroup>a').length==0) $('.pageToolbarContentFirstGroup').remove();
	if($('.pageToolbarContentSecondGroup>a').length==0) $('.pageToolbarContentSecondGroup').remove();
	if($('.pageToolbarContentThirdGroup>a').length==0) $('.pageToolbarContentThirdGroup').remove();

	
	$( window ).resize(function() { changedWindowHeight(); });
	
	changedWindowHeight();
	
  var attrChangeTimeout = false;
  
  $('#bottom-component').attrchange({
    trackValues: true,
    /* enables tracking old and new values */
    callback: function(e) { //callback handler on DOM changes
      //log the events in the panel


	  
	  if(attrChangeTimeout) clearTimeout(attrChangeTimeout);
	  attrChangeTimeout = setTimeout(function(){

	  }, 2000);
	  
	  
    }
  });
	
	
});


function abortAuftraegeMitarbeiter(parentSelector){
	$(parentSelector+' .used').removeClass('used');
	$(parentSelector+' .usedDefault').addClass('used');
	$(parentSelector+' .usedDefault').removeClass('usedDefault');
	$(parentSelector).removeClass('edit');
}
function changeAuftraegeMitarbeiter(parentSelector){
	$(parentSelector+' .used').addClass('usedDefault');
	$(parentSelector).addClass('edit');
}

function toggleAuftraegeMitarbeiter(icon){

	var parentSelector = '#'+$(icon).closest('.mitarbeiterSet').attr('id');
	
	
		
	
	if($(parentSelector).hasClass('edit')) {
		
	
		if($(parentSelector).data('multiple')){
	
			if($(icon).hasClass('used')) $(icon).removeClass('used'); else $(icon).addClass('used');	
			if( $(parentSelector).children('.used').length>0) $( parentSelector + ' .btn-save' ).removeAttr('disabled'); else $( parentSelector + ' .btn-save').attr('disabled', 'disabled');
			
		} else {
	
			$(parentSelector+' .used').removeClass('used');
			$(icon).addClass('used');	
		}

	}
	
}
function setAuftraegeDateiTitel(parentSelector,id,titel){
	
	var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'updateDateiTitel',"tx_dslintranet_auftragsliste[uid]":id,"tx_dslintranet_auftragsliste[titel]":titel};
	dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
	
	
		
	});

}
function setDateiTitel(parentSelector,id,titel){
	
	
	var updateAjaxJson = {"tx_dslintranet_downloadcenter[switch]":'updateDateiTitel',"tx_dslintranet_downloadcenter[uid]":id,"tx_dslintranet_downloadcenter[titel]":titel};
	dslIntranetAjaxCall(dateienAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
	
	});

}
function setKundenAuftraegeDateiTitel(parentSelector,id,titel){

	var updateAjaxJson = {"tx_dslintranet_kundenlogin[switch]":'updateDateiTitel',"tx_dslintranet_kundenlogin[uid]":id,"tx_dslintranet_kundenlogin[titel]":titel};
	dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
	
	});

}
function setAuftraegeMitarbeiter(parentSelector,id){
	$(parentSelector).removeClass('edit');

	var mitarbeiter = '';
	$(parentSelector+' .userIcon.used').each(function() {
		if(mitarbeiter == '')  mitarbeiter = $( this ).data("mitarbeiter-uid"); else mitarbeiter = mitarbeiter+','+$( this ).data("mitarbeiter-uid");
	});
	
	$(parentSelector).children('.usedDefault').removeClass('usedDefault');
	
	
	var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'updateMitarbeiter',"tx_dslintranet_auftragsliste[uid]":id,"tx_dslintranet_auftragsliste[mitarbeiter]":mitarbeiter};
	dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
		
	});

}
function setAuftraegeAnsprechpartner(parentSelector,id){
	$(parentSelector).removeClass('edit');
	
	$(parentSelector).children('.usedDefault').removeClass('usedDefault');
	
	

	var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'updateAnsprechpartner',"tx_dslintranet_auftragsliste[uid]":id,"tx_dslintranet_auftragsliste[ansprechpartner]":$(parentSelector+' .userIcon.used').data("mitarbeiter-uid")};
	dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
	
		
	});

}


function closeAuftragTexteEditNotizenIntern(id){
	
	var editor = tinyMCE.get(id);
	var element = $('#'+id).closest('.inlineEditing');
	element.removeClass('tinyEdit');
	editor.remove();
	element.find('.titelInput').val(element.find('.titelInput').data('default'));
	
	if(element.find('.textSichtbarkeitInput').data('default')) element.find('.textSichtbarkeit').addClass('aktiv'); else  element.find('.textSichtbarkeit').removeClass('aktiv');
	
	$('#'+id).val( $('#'+id+'_temp').val() );
}

function saveAuftragTexteEditNotizenIntern(id){
	var editor = tinyMCE.get(id);
	var element = $('#'+id).closest('.inlineEditing');
			

	
	var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'updateNotizenIntern',"tx_dslintranet_auftragsliste[auftraege]":element.data('uid'),"tx_dslintranet_auftragsliste[textNotizenIntern]":editor.getContent()};
	
	dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data ) {
	
	});



	
	element.removeClass('tinyEdit');
	
	element.find('.beschreibungContent').html( editor.getContent() );


	editor.remove();
	$('#'+id+'_temp').val( $('#'+id).val() );
	
	
}
function closeAuftragTexteEditBeschreibung(id){
	var editor = tinyMCE.get(id);
	var element = $('#'+id).closest('.inlineEditing');
	element.removeClass('tinyEdit');
	editor.remove();
	element.find('.titelInput').val(element.find('.titelInput').data('default'));
	
	if(element.find('.textSichtbarkeitInput').data('default')) element.find('.textSichtbarkeit').addClass('aktiv'); else  element.find('.textSichtbarkeit').removeClass('aktiv');
	
	$('#'+id).val( $('#'+id+'_temp').val() );
}
function saveAuftragTexteEditBeschreibung(id){
	var editor = tinyMCE.get(id);
	var element = $('#'+id).closest('.inlineEditing');
			

	
	var sichtbarkeit = 0;
	if(element.find('.textSichtbarkeitInput').hasClass('btnGruen')) {
		sichtbarkeit=1;
		element.find('.textSichtbarkeitInput').data('default',1);
		element.find('.textSichtbarkeit').addClass('btnGruen');
	} else {
		element.find('.textSichtbarkeitInput').data('default','');
		element.find('.textSichtbarkeit').removeClass('btnGruen');
	}

	
	var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'updateTexte',"tx_dslintranet_auftragsliste[texte]":element.data('uid'),"tx_dslintranet_auftragsliste[textBeschreibung]":editor.getContent(),"tx_dslintranet_auftragsliste[textTitel]":element.find('.titelInput').val(),"tx_dslintranet_auftragsliste[sichtbarkeit]":sichtbarkeit};
	
	dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data ) {
	
	});



	element.find('.titelInput').data('default',element.find('.titelInput').val());
	element.removeClass('tinyEdit');
	element.find('.titelContent').html( element.find('.titelInput').val() );
	element.find('.beschreibungContent').html( editor.getContent() );


	editor.remove();
	$('#'+id+'_temp').val( $('#'+id).val() );
	
	
}

function saveAuftragTexteNewBeschreibung(id){
	var editor = tinyMCE.get(id);
	var element = $('#'+id).closest('.inlineEditing');
			


	var sichtbarkeit = 0;
	if(element.find('.textSichtbarkeitInput').hasClass('btnGruen')) {
		sichtbarkeit=1;
		element.find('.textSichtbarkeitInput').data('default',1);
		element.find('.textSichtbarkeit').addClass('btnGruen');
	} else {
		element.find('.textSichtbarkeitInput').data('default','');
		element.find('.textSichtbarkeit').removeClass('btnGruen');
	}
	
	
	
	//var sichtbarkeit = 0;
	//if(element.find('.textSichtbarkeitInput').hasClass('aktiv')) sichtbarkeit=1;
	
	
	var updateAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'addTexte',"tx_dslintranet_auftragsliste[auftraege]":element.data('uid'),"tx_dslintranet_auftragsliste[textBeschreibung]":editor.getContent(),"tx_dslintranet_auftragsliste[textTitel]":element.find('.titelInput').val(),"tx_dslintranet_auftragsliste[sichtbarkeit]":sichtbarkeit};
	
	dslIntranetAjaxCall(auftraegeAjaxUrl,updateAjaxJson).done(function (data ) {
		dataJson = JSON.parse(data);

		$('#auftragTexteEditBeschreibung_neu_'+dataJson['auftraegeUid']+'_panel').before(dataJson['contentShow']);
		reInitAjaxCalls();
		

	});

	closeAuftragTexteEditBeschreibung(id);
	
}


function initTinyMceEditorInline(btn){
	var container = $(btn).closest('.inlineEditing');
	//console.log(container.attr('class'));
	if(container.hasClass('tinyEdit')) return true;
	
	checkResetTinyMCS(container.find('textarea').attr('id'));
	
	var selectorTextarea = '#'+container.find('textarea').attr('id');
	
	
	
	container.addClass('tinyEdit');
	
	

	// Notice: The simple theme does not use all options some of them are limited to the advanced theme
	tinymce.init({
		mode : "exact",
/*		elements: "tx_dslintranet_auftragsliste[beschreibung]",*/
		selector: selectorTextarea,
		/*theme : "simple",*/
		language : "de",
		width : 'auto',
		height : 'auto',
		subfolder:"",
		menubar: '',
		plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons paste textcolor paste"
			],
		
		
  		paste_as_text: true,
		
		toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link removeformat code",
		
		/* - See more at: http://test.albertoperipolli.com/filemanager4tinymce/#sthash.11Dy60t1.dpuf*/
		content_css : "typo3conf/ext/dsl_intranet/Resources/Public/Styles/tinymce.css",
		browser_spellcheck: true,
		

		force_br_newlines : false,
		force_p_newlines : false,
		
		

		
		
	
		
		init_instance_callback : function(editor) {
			
	  	}

		
	});
	
	
	
}


function checkResetTinyMCS(id){
	
	if(tinymce.EditorManager.editors.length){

		
		$.each(tinymce.EditorManager.editors, function( index, editor ) {
		  	
			if(editor.id==id){
			
				var ed = tinymce.get(editor.id);
				if (ed) {
					try {
						ed.remove();
					} catch(e) {
						delete tinymce.editors[editor.id];
					}
				}
				
				
			}
			
		});
		
	} 
}


function prepareTabReloads(id){

	var selector = "auftrag-show-"+id;
	
	if(!$('#'+selector).hasClass('tabReloads')){

		$('#'+selector).addClass('tabReloads');

		$( '#aufgaben_tabs>ul>li>a[href="#'+selector+'"]' ).html(  '<i class="fa fa-cog fa-spin"></i> '+$.trim($( '#aufgaben_tabs>ul>li>a[href="#'+selector+'"]' ).html()) );

	}

}

// forceNumeric() plug-in implementation
 jQuery.fn.forceNumeric = function () {

	 return this.each(function () {
		 $(this).keydown(function (e) {
			 var key = e.which || e.keyCode;

			 if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
			 // numbers   
				 key >= 48 && key <= 57 ||
			 // Numeric keypad
				 key >= 96 && key <= 105 ||
			 // comma, period and minus, . on keypad
				key == 190 || key == 188 || key == 109 || key == 110 ||
			 // Backspace and Tab and Enter
				key == 8 || key == 9 || key == 13 ||
			 // Home and End
				key == 35 || key == 36 ||
			 // left and right arrows
				key == 37 || key == 39 ||
			 // Del and Ins
				key == 46 || key == 45)
				 return true;

			 return false;
		 });
	 });
 }
 
 
 function refreshSelectpickerOptgroups(selector){

	 $(selector).each(function() {
      
      var temp = $(this).selectpicker('val');

      $(this).selectpicker('deselectAll');
      $(this).selectpicker('val',temp);

      $(this).selectpicker('refresh');
    });
}

function setDiffTimeMinutes(element){


	var outputElement = $( $(element).data('difftime-selector')); 


	var begin = $(outputElement.data('difftime-start'));
	var end = $(outputElement.data('difftime-end'));

	var diff = moment.duration(end.val(), "HH:mm").asMinutes() - moment.duration(begin.val(), "HH:mm").asMinutes();
	if(diff<0) diff=diff*-1;


	var stunden = Math.floor(diff/60);
	var minuten = diff-(stunden*60);

	var ausgabe = '';
	if(stunden>1) ausgabe=ausgabe+stunden+' Stunden'
		else if(stunden>0) ausgabe=ausgabe+stunden+' Stunde'

	if(minuten>0){
	  if(stunden>0) ausgabe=ausgabe+' und ';

	  if(minuten>1) ausgabe=ausgabe+minuten+' Minuten'
	  	else ausgabe=ausgabe+minuten+' Minute'
	}

	outputElement.html(ausgabe);

}


function checkSelectPicker(selector){
	if($('#'+selector).val()) {
		$('#'+selector).addClass('valid');
		$('#'+selector).removeClass('invalid');
	} else {
		$('#'+selector).addClass('invalid');
		$('#'+selector).removeClass('valid');
	} 
	if($('#'+selector).hasClass('invalid')){
		$('[data-id="'+selector+'"]').addClass('invalid');
	} else {
		$('[data-id="'+selector+'"]').removeClass('invalid');
	}
}

function setFilterNotEmptyClass(selektor){
  $(selektor).each(function( index ) {
    if($(this).selectpicker('val')) $(this).parent().addClass('filterNotEmpty'); else $(this).parent().removeClass('filterNotEmpty');
  });
}

function calcStundensatz(preis,stunden){
  if(!stunden) return "...";
  return (preis/stunden).toFixed(2);
}


function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


function formatBytes(bytes,decimals) {
   if(bytes == 0) return '0 Bytes';
   var k = 1024,
       dm = decimals || 2,
       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
	var text = parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	
	text = text.replace('.', ',');
   return text;
}


function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}


function roundFloat(wert, dez) {
        wert = parseFloat(wert);
        if (!wert) return 0;
        dez = parseInt(dez);
        if (!dez) dez=0;

        var umrechnungsfaktor = Math.pow(10,dez);

        return Math.round(wert * umrechnungsfaktor) / umrechnungsfaktor;
}


// TinyMCE
function initTinyMceEditor(){

	checkResetTinyMCS('auftragEditNotizenIntern');
	checkResetTinyMCS('agenturvertragEditBeschreibung');
	checkResetTinyMCS('auftragEditBeschreibung');
	checkResetTinyMCS('hostingEditNotiz');
	checkResetTinyMCS('kundenEditNotizen');
	
	// Notice: The simple theme does not use all options some of them are limited to the advanced theme
	tinymce.init({
		mode : "exact",
		selector: "#auftragEditBeschreibung,#hostingEditNotiz,#agenturvertragEditBeschreibung,#auftragEditNotizenIntern,#kundenEditNotizen",
		language : "de",
		width : '100%',
		height : '250',
		subfolder:"",
		menubar: '',
		plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons paste textcolor paste"
			],
		paste_as_text: true,
		
		toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link removeformat",
		/*code*/
		/* - See more at: http://test.albertoperipolli.com/filemanager4tinymce/#sthash.11Dy60t1.dpuf*/
		content_css : "typo3conf/ext/dsl_intranet/Resources/Public/Styles/tinymce.css",
		browser_spellcheck: true,
		

		force_br_newlines : false,
		force_p_newlines : false,
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}

	});
	
}