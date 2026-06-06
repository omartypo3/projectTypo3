var aufgabenElement = $('#aufgaben');
var aufgabenAjaxUrl = aufgabenElement.data('aufgabenAjaxUrl');
var auftraegeAjaxUrl = aufgabenElement.data('auftraegeAjaxUrl');
var eventsAjaxUrl = aufgabenElement.data('eventsAjaxUrl');

var slotDuration = '00:30:00';

var chartArr = new Object()
var chartPhasenArr = new Object()
var stoppUhrenArr = new Object()

var addEventSourceDone = false;

var eventSource = {
        url: eventsAjaxUrl,
        data: {
/*                aufgabenmitarbeiters: '',*/
            'tx_dslintranet_wochenlisteaufgabenplatzierung[aufgabenmitarbeiters]':''
        }
};
//eventSource.data['tx_dslintranet_wochenlisteaufgabenplatzierung[aufgabenmitarbeiters]'] = 'def';
function addEventSource(){

    if(!addEventSourceDone){
        addEventSourceDone = true;
        setEventSource(true);

        return true;
    }
    return false;
}
function setEventSource(addEventSource){


    if($( '.fc-mitarbeiter-button.fc-state-active' ).length){

        var mitarbeiterUids = [];
        $( '.fc-mitarbeiter-button.fc-state-active' ).each(function( index ) {
            //console.log( index + ": " + $( this ).data('mitarbeiter-uid') );
            mitarbeiterUids.push($( this ).data('mitarbeiter-uid'));
        });
        //console.log(mitarbeiterUids.join(','));

        eventSource.data['tx_dslintranet_wochenlisteaufgabenplatzierung[aufgabenmitarbeiters]'] = mitarbeiterUids.join(',');

    } else {
        eventSource.data['tx_dslintranet_wochenlisteaufgabenplatzierung[aufgabenmitarbeiters]'] = '';
//			eventSource.data.aufgabenmitarbeiters = '';
    }
    if(addEventSource){
        $('#wochenplanung_kalender').fullCalendar( 'addEventSource',  eventSource);
    } else {
        $('#wochenplanung_kalender').fullCalendar( 'refetchEvents' );
    }

}



function initDraggableAuftraege(){
    $('.auftraegeDraggable').each(function() {

        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            id: "auftraege_"+$(this).attr('data-id'),
            title: $.trim($(this).attr('data-title')), // use the element's text as the event title
            stick: true, // maintain when user navigates (see docs on the renderEvent method)
            editable: false,
            durationEditable: false,
            startEditable: false
        });
        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });
}
var aufgabenKalender = false;


var draggedEventIsAllDay;
var draggedEventType;

var mitarbeiterKalenderBtn = aufgabenElement.data('mitarbeiterKalenderBtn');

$(document).ready(function() {

    $(window).on('resize', Superclamp.reclampAll);
    initDraggableAuftraege();

    /* initialize the calendar
    -----------------------------------------------------------------*/

    //$('#wochenplanung_kalender').fullCalendar('option', 'contentHeight', 650);

    var fullCalendarSettings = {

        customButtons: {
            refetch: {
                icon: 'refetch',
                click: function() {
                    aufgabenKalender.fullCalendar( 'refetchEvents' );
                }
            }
        },
        textEscape: false,
        contentHeight: 400,

        selectable: true,
        selectHelper: true,
        select: function(start, end) {

            $.colorbox({width:"10%", height:"10%", close:'<i class="fa fa-times-circle"></i>', className:'colorbox_background'});

            var addAjaxJson = {
                "tx_dslintranet_wochenlisteaufgabenplatzierung[switch]":'newForm',
                "tx_dslintranet_wochenlisteaufgabenplatzierung[begin]":start._d,
                "tx_dslintranet_wochenlisteaufgabenplatzierung[end]":end._d
            };

            dslIntranetAjaxCall(aufgabenAjaxUrl,addAjaxJson).done(function (data) {


                var doAjaxEditColorBoxHeight = '';var doAjaxEditColorBoxWidth = '650px';
                var maxWindowsHeight = $( window ).height()-10;
                var colorBoxHeight = 800;
                if(maxWindowsHeight < colorBoxHeight) doAjaxEditColorBoxHeight=maxWindowsHeight+'px';  else doAjaxEditColorBoxHeight = '800px';

                $.colorbox({
                    width:doAjaxEditColorBoxWidth,
                    height:doAjaxEditColorBoxHeight,
                    html:data,
                    fixed:true,
                    reposition:true,
                    close:'<i class="fa fa-times-circle"></i>',
                    className:'colorbox_background',
                    onComplete: function(){
                        /*platzhalter wegen fluid Javascript Problem*/
                    }
                });
            });

        },

        /*dsl mitarbeiter1,mitarbeiter3,mitarbeiter6,mitarbeiter2218,mitarbeiter2341,mitarbeiter2272*/
        header: {
            left: 'prev,refetch,next today '+mitarbeiterKalenderBtn, /*+' icalAdd'*/
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        startParam: 'tx_dslintranet_wochenlisteaufgabenplatzierung[start]',
        endParam: 'tx_dslintranet_wochenlisteaufgabenplatzierung[end]',
        timezone: 'local',
        defaultView: 'agendaWeek',
        nowIndicator: true,
        weekNumbers: true,
        firstDay: 1,
        slotLabelFormat: 'H:mm',
        slotDuration: slotDuration,
        defaultTimedEventDuration: '00:30:00',
        forceEventDuration: true,
        timeFormat: 'H:mm',
        lang: 'de',
        hiddenDays: [ 0 ],
        dayNamesShort: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        minTime: "07:00:00",
        maxTime: "19:00:00",
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        eventReceive: function(event) {

            var addAjaxJson = {
                "tx_dslintranet_wochenlisteaufgabenplatzierung[switch]":'new',
                "tx_dslintranet_wochenlisteaufgabenplatzierung[auftragId]":event.id,
                "tx_dslintranet_wochenlisteaufgabenplatzierung[begin]":event.start._d,
                "tx_dslintranet_wochenlisteaufgabenplatzierung[end]":event.end._d
            };

            dslIntranetAjaxCall(aufgabenAjaxUrl,addAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {

                dataJson = JSON.parse(data);
                $('#wochenplanung_kalender').fullCalendar('removeEvents', event.id);
                $('#wochenplanung_kalender').fullCalendar( 'renderEvent',  dataJson);

            });

        },
        drop: function(date, jsEvent, ui) {
            /*platzhalter wegen fluid Javascript Problem*/
        },

        dragScroll:true,
        viewRender: function( view, element ){
            /*platzhalter wegen fluid Javascript Problem*/
        },
        eventRender: function(event, eventElement) {

            if(event.mitarbeiterUid) eventElement.attr('data-mitarbeiter-uid',event.mitarbeiterUid).addClass('mitarbeiterBackgroundColor');

            eventElement.find('.fc-title').attr('title',eventElement.find('.fc-title').text());

            if (event.type=="urlaub") { // allday

                if (event.kuerzel) eventElement.find('.fc-title').prepend(event.kuerzel);
                eventElement.find("div.fc-content").attr('id','wp_urlaubs_uids_'+event.id).addClass('wp_urlaubs_uids');
                eventElement.find("div.fc-content").prepend('&nbsp;');

            } else if(event.type=="extern") {
                eventElement.find("div.fc-content").prepend('&nbsp;');
                eventElement.find("div.fc-content").attr('id','wp_aufgaben_uid_'+event.id).addClass('wp_aufgaben_uids');
                eventElement.addClass('externerTerminBackgroundColor');
            } else {
                if (event.kuerzel) eventElement.find('.fc-title').prepend(event.kuerzel);

                var htmlButtons = new Array();
                var htmlMitarbeiterChange = new Array();

                if (event.auftrag_uid) htmlButtons[htmlButtons.length] = '<li class="showAuftragDetailBtn'+event.auftrag_uid+'"><a href="#" class="doAjax" data-ajax-id="'+event.auftrag_uid+'" data-ajax-action="showAuftrag"><i class="fa fa-search fa-fw"></i>&nbsp; Auftrag Anzeigen</a></li>';
                if (event.uri_delete) htmlButtons[htmlButtons.length] = '<li><a href="'+event.uri_delete+'" class="doConfirmAjax" data-ajax-id="'+event.id+'" data-ajax-action="deleteAufgabe"><i class="fa fa-trash-o fa-fw"></i>&nbsp; Aufgabe löschen</a></li>';

                if (event.uri_edit) {/*link aufgabe editieren*/
                    htmlButtons[htmlButtons.length] = '<li><a href="javascript:void(0);" data-colorbox-width="650px" data-colorbox-height="500px" data-href="'+event.uri_edit+'" class="doAjax" data-ajax-id="'+event.id+'" data-ajax-action="showColorbox"><i class="fa fa-edit fa-fw"></i>&nbsp; Aufgabe Bearbeiten</a></li>';
                    htmlButtons[htmlButtons.length] = '<li><a href="javascript:void(0);" data-href="'+event.uri_toggleErledigt+'" class="doAjax" data-ajax-id="'+event.id+'" data-ajax-action="toggleErledigt"><i class="fa fa-calendar-check-o fa-fw"></i>&nbsp; Aufgabe erledigt</a></li>';
                }


                var glyphicon = '';
                $.each(event.mitarbeiter, function(index, mitarbeiter) {
                    if(mitarbeiter.aktiv) glyphicon = '<i class="fa fa-check-square-o" aria-hidden="true"></i>'; else  glyphicon = '<i class="fa fa-square-o" aria-hidden="true"></i>';
                    htmlMitarbeiterChange[htmlMitarbeiterChange.length] = '<li><a class="doAjax" data-ajax-id="'+event.id+'" data-ajax-action="aufgabeChangeMitarbeiter" href="javascript:void(0);" data-href="'+mitarbeiter.uri+'">'+glyphicon+'&nbsp; <span class="text">'+mitarbeiter.initialien+'</span></a></li>';
                });

                eventElement.find("div.fc-content").attr('id','wp_aufgaben_uid_'+event.id).addClass('wp_aufgaben_uids');
console.log("event.erledigt",event.erledigt);
                if(event.erledigt == true) eventElement.addClass('erledigt');
                if(htmlButtons.length>0){
                    eventElement.find("div.fc-content").prepend('<div class="btn-group"><a class="fc-content-btn  dropdown-toggle" data-toggle="dropdown" href="#" id="wpAufgabe'+event.id+'"><i class="fa fa-calendar-o fa-fw"></i>&nbsp;<span class="fa fa-caret-down" title="Toggle dropdown menu"></span></a><ul class="dropdown dropdown-menu multi-level" aria-labelledby="wpAufgabe'+event.id+'">'+htmlButtons.join('')+'<li class="dropdown-submenu"><a tabindex="-1" href="javascript:void(0);" class="" onclick="return false;"><i class="fa fa-users fa-fw"></i>&nbsp; Zuweisung</a><ul class="dropdown-menu"></li>'+htmlMitarbeiterChange.join('')+'</ul></li><li class="divider"></li><li><a href="javascript:void(0);">Schließen</a></li></ul></div>');
                } else {

                    if (event.type){
                        //console.log('evtype...');

                    } else {
                        //normaler kalendereintrag!!
                        eventElement.find("div.fc-content").prepend('<i class="fa fa-spin fa-gear fa-fw"></i>&nbsp;');
                        eventElement.find("div.fc-content .fc-title").css("left", "+=20");
                    }
                }
            }

        },

        eventAfterAllRender: function( view ) {

            reInitAjaxCalls();

            $('.fc-bg').each(function() {

                $(this).prev().children('.fc-title').height($(this).height());
            });
            $('.fc-title').clamp();


            /*wird glaub nicht mehr gebraucht?*/
            $('.fc-event-container .fc-content').on('mouseover', function(){
                $(this).parent().addClass('is-hover');
            }).on('mouseout', function(){
                $(this).parent().removeClass('is-hover');
            });

        },
        eventResize: function(event, delta) {


            var updateAjaxJson = {
                "tx_dslintranet_wochenlisteaufgabenplatzierung[switch]":'update',
                "tx_dslintranet_wochenlisteaufgabenplatzierung[uid]":event.id,
                "tx_dslintranet_wochenlisteaufgabenplatzierung[end]":event.end._d
            };
            dslIntranetAjaxCall(aufgabenAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
                /*platzhalter wegen fluid Javascript Problem*/
            });

        },
        eventDragStop: function(event, jsEvent, ui, view) {
            /*platzhalter wegen fluid Javascript Problem*/
        },
        eventDragStart: function(ev) {
            draggedEventIsAllDay = ev.allDay;
            draggedEventType = ev.type;
        //	console.log(ev.type);

        },
        eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {



            if(event.allDay || draggedEventIsAllDay || draggedEventType) {
                revertFunc();
            } else {

                var updateAjaxJson = {
                    "tx_dslintranet_wochenlisteaufgabenplatzierung[switch]":'update',
                    "tx_dslintranet_wochenlisteaufgabenplatzierung[uid]":event.id,
                    "tx_dslintranet_wochenlisteaufgabenplatzierung[begin]":event.start._d,
                    "tx_dslintranet_wochenlisteaufgabenplatzierung[end]":event.end._d
                };
                dslIntranetAjaxCall(aufgabenAjaxUrl,updateAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
                    /*platzhalter wegen fluid Javascript Problem*/
                });
            }

            //}

        },
        eventMouseover: function(event, jsEvent, view) {
            /*platzhalter wegen fluid Javascript Problem*/
        },
        eventMouseout: function(event, jsEvent, view) {
            /*platzhalter wegen fluid Javascript Problem*/
        },
        eventClick: function(calEvent, jsEvent, view) {
            console.log('clicked');
            console.log(calEvent);
            console.log(calEvent.id);

            $('.clickedEvent').removeClass('clickedEvent');
            $('#wp_aufgaben_uid_'+calEvent.id).parent().addClass('clickedEvent');

            if($('#wp_aufgaben_uid_'+calEvent.id).parent().css("zIndex")==998) {
                $('#wpAufgabe'+calEvent.id).next('.dropdown-menu').toggle();
                $('#wpAufgabe'+calEvent.id).closest('.fc-event').attr('data-dropdown-display',$('#wpAufgabe'+calEvent.id).next('.dropdown-menu').css('display'));
                //alert($('#wpAufgabe'+calEvent.id).next('.dropdown-menu').css('display'));
            } else { // wenn das aktuell geklickte event sich noch nicht im vordergrund befindet

                $('#wochenplanung_kalender .dropdown-menu').hide();
                //$('[data-toggle="dropdown"]').parent().removeClass('open'); //evtl. geöffnete dropdowns schließen
                $('.wp_aufgaben_uids').parent().css("zIndex",10);
                $('#wp_aufgaben_uid_'+calEvent.id).parent().css("zIndex",998);
            }
            $('.fc-event-container').css("zIndex",1);
            $('#wp_aufgaben_uid_'+calEvent.id).closest('.fc-event-container').css("zIndex",998);

        }
    };

    var mitarbeiterExternCustomButtons = aufgabenElement.data('mitarbeiterExternCustomButtons');

    if(mitarbeiterExternCustomButtons) {
        mitarbeiterExternCustomButtons.split(',').forEach(function(mitarbeiter) {
            fullCalendarSettings['customButtons'][mitarbeiter] = {
                text: ' ',
                click: function() {
                    $(this).toggleClass('fc-state-active');

                    setEventSource(false);
                }
            };
        });
    }

    aufgabenKalender = $('#wochenplanung_kalender').fullCalendar(fullCalendarSettings);

    var mitarbeiterButtons = aufgabenElement.data('mitarbeiterButtons');
    if(mitarbeiterButtons) {
        mitarbeiterButtons.split(',').forEach(function(mitarbeiter) {
            var mitarbeiterObj = mitarbeiter.split(';');
            $('.fc-mitarbeiter'+mitarbeiterObj[0]+'-button').addClass('fc-mitarbeiter-button mitarbeiterBackgroundColor');

            $('.fc-mitarbeiter'+mitarbeiterObj[0]+'-button').attr('data-mitarbeiter-uid',mitarbeiterObj[0]).text(mitarbeiterObj[3]).attr('title',mitarbeiterObj[1] + ' / ' + mitarbeiterObj[2]);
        });
    }

    var aufgabenmitarbeiters = aufgabenElement.data('aufgabenmitarbeiters');
    if(aufgabenmitarbeiters) {
        aufgabenmitarbeiters.toString().split(',').forEach(function(activeMitarbeiter) {
            $('.fc-mitarbeiter'+activeMitarbeiter+'-button').addClass('fc-state-active');
        });
    }

});


$(document).click(function(event) {
    if(!$(event.target).hasClass('fc-title')) {
        $('#wochenplanung_kalender .dropdown-menu').hide();
        $('.clickedEvent').css("zIndex",10);
        $('.clickedEvent').removeClass('clickedEvent');
    }
});
    
function changeProjektTab(id,content) {
    console.log("1111",id)
    console.log("1112",content)
    var uid = $(content).find('.auftraegeUid').data('auftraege-uid');
    console.log("uid---------",uid);
    var zeitnahme = $(content).find('#stoppuhr_'+uid+'_clock').data('zeitnahme');
    var kontingent = $(content).find('#stoppuhr_'+uid+'_clock').data('kontingent');
    if(uid){
        $('input.auftraegeUid').remove();
    }
     $('#'+id).html(content);

    $( '#aufgaben_tabs>ul>li>a[href="#'+id+'"]' ).html( $(content).find('.shortTabTitel').html() );

    if(zeitnahme>0){
        setTimerClass(uid,'reloadActive');
    } else if(kontingent>0){
        setTimerClass(uid,'reloadPaused');
    } else {
        setTimerClass(uid,'reloadNone');
    }


    reInitAjaxCalls();
    refreshWochenplanerHeight();



}
function closeProjektTab(id){
    if( $( '#aufgaben_tabs>ul>li>a[href="#auftrag-show-'+id+'"]' ).length){
        $( '#aufgaben_tabs>ul>li>a[href="#auftrag-show-'+id+'"]' ).next().click();
    }
}
function addProjektTab(id){

    var dataLoadId = "0"+id;
    var auftragsUid = dataLoadId.replace( /0auftrag-show-/g, '' );
    var selector = 'auftrag-show-'+auftragsUid;

    if(!$("#"+selector).length) {

        var dataLoadId = "0"+selector;
        var auftragsUid = dataLoadId.replace( /0auftrag-show-/g, '' );
        
        var li = $( '<li data-load-id="'+auftragsUid+'"><a href="#'+selector+'"> ... wird geladen</a> <i class="bb-times"></i></li>' );//<i class="fa fa-cog fa-spin"></i> wird eh durch das tab aktivieren ergänzt
        
        $( '#aufgaben_tabs' ).find( ".ui-tabs-nav" ).first().append( li );
        $( "#aufgaben_tabs" ).append( '<div id="'+selector+'"><p><span class="ajaxLoading dark"><i class="fa fa-cog fa-spin"></i></span></p></div>' );
        $( "#aufgaben_tabs" ).tabs( "refresh" );
        
    }
    aktiviereProjektTab(selector);
}

function aktiviereProjektTab(id) {

    /*Tab herausfinden und aktivieren !!*/		
    $( "#aufgaben_tabs" ).tabs( "option", "active", $( '#aufgaben_tabs>ul>li>a[href="#'+id+'"]' ).parent().index() );
    refreshWochenplanerHeight();
}
function loadProjektTabContent(id) {
    var selector = '';
    if(parseInt(id)){
        selector = "auftrag-show-"+id;
    } else {
        selector = id;

    }


    var showAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'show',"tx_dslintranet_auftragsliste[uid]":id};

    dslIntranetAjaxCall(auftraegeAjaxUrl,showAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
        if(data=="error") {
            alert('Es gab einen Fehler mit den Berechtigungen, der Tab wird geschlossen!');
            closeAufgabenTab(id);
        } else {
            changeProjektTab(selector,data);
        }
    });
}

function refreshProjektTabContent(id){

    console.log('refreshProjektTabContent() in Templates/Aufgaben');

    globalData['auftrag-'+id+'-zeiteintraege-datatable-search'] = $('#zeiteintraegeList'+id).DataTable().search();
    globalData['auftrag-'+id+'-zeiteintraege-datatable-order'] = $('#zeiteintraegeList'+id).DataTable().order();

    prepareTabReloads(id);
    var selector = "auftrag-show-"+id;
    var datum = "";
    if($('#auftraegeAktivitaetDatePickerInput'+id).length){
        datum=$('#auftraegeAktivitaetDatePickerInput'+id).val();
        
    }
    var showAjaxJson = {"tx_dslintranet_auftragsliste[switch]":'show',"tx_dslintranet_auftragsliste[uid]":id,"tx_dslintranet_auftragsliste[aktivitaetsDatum]":datum};
    /*var activeTab = $( "#auftraegetabs_"+id ).tabs("option", "active") ;
	console.log("activeTab");
	console.log(activeTab);*/
    dslIntranetAjaxCall(auftraegeAjaxUrl,showAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
        if(data=="error") {
            alert('Es gab einen Fehler mit den Berechtigungen, der Tab wird geschlossen!');
            closeAufgabenTab(id);
        } else {
            changeProjektTab(selector,data);
            //$( "#auftraegetabs_"+id ).tabs("option", "active", activeTab);
            $('#'+selector).removeClass('tabReloads');
        }
    });
}



function closeAufgabenTab(uid){
    $( '#aufgaben_tabs>ul>li[aria-controls="auftrag-show-'+uid+'"]' ).remove();
    $( "#auftrag-show-"+uid ).remove();
    $( "#aufgaben_tabs" ).tabs( "refresh" );
}

var tabsActive = false;


$(document).ready(function() {
    $( "#aufgaben_tabs" ).tabs({
        activate: function( event, ui ) {
            if(ui.newTab.data('refresh-events')){
                refreshWochenplanerHeight();
                if(!addEventSource()) $('#wochenplanung_kalender').fullCalendar( 'refetchEvents' );
            }
            if(ui.newTab.data('load-id')){
                ui.newTab.children('a').html('<i class="fa fa-cog fa-spin"></i> '+ui.newTab.children('a').html());
                loadProjektTabContent(ui.newTab.data('load-id'));
                ui.newTab.data('load-id','');
            } else {
                if(ui.newTab.data('init')) {
                    initAuftragsTab(ui.newTab.data('init'));
                    ui.newTab.data('init','')
                }
                if($(ui.newTab.context).attr('id')!="ui-id-1"){ //wenn ein auftrag angeklickt wurde
                    dslIntranetAjaxCall(
                        auftraegeAjaxUrl,
                        {"tx_dslintranet_auftragsliste[switch]":'setGeoeffneterAuftrag',"tx_dslintranet_auftragsliste[uid]":$(ui.newTab.context).children('.auftraegeUid').data('auftraege-uid')}
                    ).done(function (data /* , textStatus, jqXHR */ ) {
                        /*platzhalter wegen fluid Javascript Problem*/
                    });
                } 
            }
            if($(ui.newTab.context).attr('id')!="ui-id-1"){
                //icons auftragplatzierung ausblenden

                //$('#aufgaben_tabs .auftraegeDraggable').hide();			
            } else {
                //icons auftragplatzierung	einblenden

                //$('#aufgaben_tabs .auftraegeDraggable').show();
                initDraggableAuftraege();
                
                //wegen bug bei aktivierung wochenplanung nach drag versuch eines kal+ icons
                $(window).trigger('resize');
                $('#wochenplanung_kalender').fullCalendar('rerenderEvents');
                refreshWochenplanerHeight();
            }
        
        }
        /*,active:false*/
            
    });
    
    $( "#aufgaben_tabs" ).tabs( "option", "active", $( "#aufgaben_tabs" ).data('active-tab') );

    
    if($( "#aufgaben_tabs" ).data('active-tab')==0 && !addEventSource()) {
        $('#wochenplanung_kalender').fullCalendar( 'refetchEvents' ); //falls wochenplanungstab vom startweg aktiv sein soll

    } else {
//		console.log('kein wochenplanung_kalenderaktiv!');			
    }
    $( "#aufgaben_tabs" ).on( "click", ".aufgaben_tabs_navigation i.bb-times", function() {
        var trackerToSave = $( this ).closest( "li" ).find('.trackerToSaveLink');
        if(trackerToSave.length) {
            //	trackerToSave.click();
            showNotAllowedToCloseAuftraegeTab(trackerToSave);
            return false;
        }
        var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
        $( "#" + panelId ).remove();
        $( "#aufgaben_tabs" ).tabs( "refresh" );
        
        /*Auftrag per Ajax aus den geöffneten Entfernen*/
        var closeAjaxJson = {
                "tx_dslintranet_wochenlisteaufgabenplatzierung[switch]":'closeAuftrag',
                "tx_dslintranet_wochenlisteaufgabenplatzierung[auftragId]":panelId
        };
        dslIntranetAjaxCall(aufgabenAjaxUrl,closeAjaxJson);
        refreshWochenplanerHeight();
    });
    
    $( "#aufgaben_tabs" ).bind( "keyup", function( event ) {
        if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
        var panelId = $( "#aufgaben_tabs" ).find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
        $( "#" + panelId ).remove();
        $( "#aufgaben_tabs" ).tabs( "refresh" );
        }
    });
});