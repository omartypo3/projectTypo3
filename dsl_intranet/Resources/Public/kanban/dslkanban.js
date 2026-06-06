

$( document ).ready(function() {

    var kanbanResizeTimeout;
	var kanbanElement = $('#kanban');
var ajaxUrl = kanbanElement.data('ajaxUrl');

var minRightWidthKanban = 615;
var dragTempType = '';
var dragTempText = '';
var dragTempKanbanBoardId = '';

    $( "#node_104" ).unbind( "click");
    $( "#node_104" ).on( "click", function(e) {
        e.preventDefault();

        var size = maxColorBoxSize();

        $.colorbox({
            initialWidth:200,
            initialHeight:200,
            width:size.width,
            height:size.height,
            close:'',
            className:'colorbox_kanban',
            overlayClose: false,
            reposition: false,
            href: ajaxUrl+'&'+encodeURIComponent('tx_dslintranet_kanban[switch]')+'='+encodeURIComponent('loadKanban'),
            onComplete:function() {
                resizeColorbox();
                $('div.kanban-split-pane').kanbanSplitPane();
                $('#kanban-left-component').attrchange({
                    trackValues: true,
                    callback: function(e) { //callback handler on DOM changes
                        if(!checkMinKanbanRight()){
                            if(kanbanResizeTimeout) clearTimeout(kanbanResizeTimeout);
                            kanbanResizeTimeout = setTimeout(function(){
                                $.post({
                                    url: ajaxUrl,
                                    data: {"tx_dslintranet_kanban[switch]":'resizeKanban',"tx_dslintranet_kanban[styles]":{left:$('#kanban-left-component').attr('style'),divider:$('#kanban-divider').attr('style'),right:$('#kanban-right-component').attr('style')}},
                                    cache: false,
                                    success:function (data) {
                                    }
                                })

                            }, 500);


                        }

                    }
                });


                initKanbanFilterStatuss();


                showKanban();

            },
            title: function(){
                return 'Kanban';
            }

        });

        return false;

    });

    $( window ).resize(function() {
        resizeColorbox();
        checkMinKanbanRight();
       // setKanbanMinMaxHeight();
    });

});

function checkMinKanbanRight(){

    return false;
}



function resizeColorbox(){
    if($('.colorbox_kanban').length){
        if($('.colorbox_kanban').css('display')!='none'){
            if($('.colorbox_kanban #cboxLoadingOverlay').css('display')!='block'){
                var size = maxColorBoxSize();
                $.colorbox.resize({height:size.height,width:size.width});
            }
        }
    }
}
function maxColorBoxSize(){

    var maxWindowsHeight = $( window ).height()-40;
    var maxWindowsWidth = $( window ).width()-40;

    var colorBoxHeight = parseInt(maxWindowsHeight*0.9);
    var colorBoxWidth = parseInt(maxWindowsWidth*0.9);

    var freiraumHorizontal = maxWindowsWidth-colorBoxWidth;
    var freiraumVertikal = maxWindowsHeight-colorBoxHeight;

    var freiraumMax = 5;

    if(freiraumHorizontal>freiraumMax) colorBoxWidth = maxWindowsWidth-freiraumMax;
    if(freiraumVertikal>freiraumMax) colorBoxHeight = maxWindowsHeight-freiraumMax;

    return {width:colorBoxWidth, height:colorBoxHeight};
}

function kanbanActiveMitarbeiter(){
    mitarbeiterUid = jQuery('.mitarbeiter-selector .mitarbeiter-button.mitarbeiter-button-active').attr('data-mitarbeiter-uid');

    return mitarbeiterUid;
}


function refreshKanban(){
    // I added those 2 lignes because ajaxUrl is not defined !!!
    var kanbanElement = $('#kanban');
    var ajaxUrl = kanbanElement.data('ajaxUrl');

    $('.kanban-pretty-split-pane-frame').addClass('contentReloads');


    $.post({
        url: ajaxUrl,
        data: {"tx_dslintranet_kanban[switch]":'loadKanbanContent',"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
        cache: false,
        success:function (data) {

            jQuery('#kanbanBoardsWrapper').html($(data).find('#kanbanBoardsContent').html());
            jQuery('#kanbanProjekteWrapper').html($(data).find('#kanbanProjekteContent').html());


            jQuery('#kanban-board-btn-wrapper').attr('data-kanban-boards',jQuery('.kanban-wrapper').attr('data-kanban-boards'));
            initKanbanFilterStatuss();
            if(kanbanItemSearchStatus){
                jQuery('#kanban_filter_statuss').selectpicker('val', kanbanItemSearchStatus);
            } else {

            }



            if(kanbanItemSearchVal){
                jQuery('#kanban-item-search-volltextsuche').val(kanbanItemSearchVal);//.change();
            } else {

            }

            if(kanbanItemSearchStatus || kanbanItemSearchVal){
                kanbanItemSearch();
            }



            showKanban();
        }
    });

  }
/* Kanban Auftrag zwischen ausgeblendet und zur verfügung stehenden einträgen toggeln*/
function toggleKanbanAuftrag(item){


    $('.kanban-pretty-split-pane-frame').addClass('contentReloads');

    if(item.parent().hasClass('kanban-auftraege-ausgeblendet')){ // verschieben in eingeblendet

        $.post({//"tx_dslintranet_kanban[mitarbeiter]":'xxx'
            url: ajaxUrl,
            data: {"tx_dslintranet_kanban[switch]":'toggleKanbanAuftragFromAusgeblendet',"tx_dslintranet_kanban[item]":item.attr('data-kanban-item-uid'),"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
            cache: false,
            success:function (data) {

                refreshKanban();

            }
        });



    } else { // verschieben in ausgeblendet

        auftragUid = jQuery(item).find('*[data-auftrag-uid]').attr('data-auftrag-uid');

        $.post({//"tx_dslintranet_kanban[mitarbeiter]":'xxx'
            url: ajaxUrl,
            data: {"tx_dslintranet_kanban[switch]":'toggleKanbanAuftragToAusgeblendet',"tx_dslintranet_kanban[item]":{auftragUid:auftragUid},"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
            cache: false,
            success:function (data) {


                dataKanbanJson = JSON.parse($(data).find('textarea#resultJson').val());

                if(dataKanbanJson.newKanbanItemUid){
                    item.attr('data-kanban-item-uid',dataKanbanJson.newKanbanItemUid);
                }

                jQuery('.kanban-auftraege-ausgeblendet').prepend(item);
                showKanban();
            }
        });


    }
}
  /* Kanban Item in die ausgeblendete Liste schieben*/
function removeKanbanItem(item){
    kanbanItemUid = item.attr('data-kanban-item-uid');

    $('.kanban-pretty-split-pane-frame').addClass('contentReloads');

    $.post({
        url: ajaxUrl,
        data: {"tx_dslintranet_kanban[switch]":'removeKanbanItem',"tx_dslintranet_kanban[item]":kanbanItemUid,"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
        cache: false,
        success:function (data) {

            dataKanbanJson = JSON.parse($(data).find('textarea#resultJson').val());
            if(dataKanbanJson.newKanbanItemUid){
                item.attr('data-kanban-item-uid',dataKanbanJson.newKanbanItemUid);
            } else {
                item.attr('data-kanban-item-uid','');
            }

            jQuery('.kanban-auftraege-ausgeblendet').prepend(item);
            //jQuery('.kanban-auftraege').append(item);
            showKanban();
        }
    });

    //ev.target.appendChild(item);
}

function saveKanbanItem(targetId){
    auftragUid = jQuery('#'+targetId+' *[data-auftrag-uid]').attr('data-auftrag-uid');
    boardUid = jQuery('#'+targetId).closest('*[data-board-uid').attr('data-board-uid');

    if(auftragUid && boardUid){

        prevKanbanItemUid = jQuery('#'+targetId).prev().attr('data-kanban-item-uid');

        $.post({
            url: ajaxUrl,
            data: {"tx_dslintranet_kanban[switch]":'saveKanbanItem',"tx_dslintranet_kanban[item]":{auftragUid:auftragUid,boardUid:boardUid,prevKanbanItemUid:prevKanbanItemUid},"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
            cache: false,
            success:function (data) {
                if($(data).find('textarea#resultJson').val()){
                    dataKanbanJson = JSON.parse($(data).find('textarea#resultJson').val());
                    if(dataKanbanJson.newKanbanItemUid){
                        jQuery('#'+targetId).attr('data-kanban-item-uid',dataKanbanJson.newKanbanItemUid);
                    }
                }
               jQuery('#kanbanBoardsWrapper').html($(data).find('#kanbanBoardsContent').html());
               jQuery('#kanbanProjekteWrapper').html($(data).find('#kanbanProjekteContent').html());
            }
        });
    }

}
    function showKanban(){
        // I added those 2 lignes because ajaxUrl is not defined !!!
        var kanbanElement = $('#kanban');
        var ajaxUrl = kanbanElement.data('ajaxUrl');

        $('.kanban-pretty-split-pane-frame').removeClass('contentReloads');
        kanbanItemSearch();
        reInitAjaxCalls();//zur initialisierung der links zum auftrag

        jQuery(".kanban-item").off("dblclick");
        jQuery(".kanban-item").dblclick(function() {

            if(jQuery(this).find('.kanban-item-show-auftrag').length){

                jQuery(this).find('.kanban-item-show-auftrag').click();
                var auftragSelector = jQuery(this).attr('id');

                jQuery(this).find('.gesamt-item-details').addClass('gesamt-item-details-dblclickeffekt');

                //.animate({ backgroundColor: "red" }, "fast");
                setTimeout(function(){
                    jQuery('#'+auftragSelector).find('.gesamt-item-details').removeClass('gesamt-item-details-dblclickeffekt');
                }, 500);

                jQuery(this).find('.board-item-details').addClass('board-item-details-dblclickeffekt');//.animate({ backgroundColor: "red" }, "fast");
                setTimeout(function(){
                    jQuery('#'+auftragSelector).find('.board-item-details').removeClass('board-item-details-dblclickeffekt');
                }, 500);
            }

        });

        jQuery(".kanban-board:not(.kanban-board-fixiert) .kanban-board-header").off("dblclick");
        jQuery(".kanban-board:not(.kanban-board-fixiert) .kanban-board-header").dblclick(function() {


            kanbanBoardTitel = prompt('Name der Liste:', jQuery(this).html());

            if (kanbanBoardTitel && kanbanBoardTitel != jQuery(this).html() && kanbanBoardTitel != '') {
                jQuery(this).html(kanbanBoardTitel)

                $.post({
                    url: ajaxUrl,
                    data: {"tx_dslintranet_kanban[switch]":'changeKanbanBoardTitle',"tx_dslintranet_kanban[board]":jQuery(this).closest('.kanban-board').attr('data-board-uid'),"tx_dslintranet_kanban[titel]":kanbanBoardTitel,"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
                    cache: false,
                    success:function (data) {
                    }
                });


            }


        });



	}
/*dragndrop*/

  function allowDropOnBoard(ev) {
      if(dragTempType == 'kanbanItem') {
          ev.preventDefault();
      }
      if(dragTempType == 'kanbanBoard') {
        if(!jQuery('#'+ev.target.id).closest('.kanban-board').hasClass('kanban-board-fixiert'))  {
            jQuery('.board-dragover-sort').removeClass('board-dragover-sort');
            jQuery('#'+ev.target.id).closest('.kanban-board').addClass('board-dragover-sort');

            ev.preventDefault();
        }
      }
  }


  function dragKanbanItem(ev) {
    jQuery('.kanban-wrapper').addClass('board-item-drag-active');
    ev.dataTransfer.setData("text", ev.target.id);
    ev.dataTransfer.setData("type", 'kanbanItem');
    dragTempType = 'kanbanItem';
  }


  function dragEndKanbanItem(ev) {
    jQuery('.kanban-wrapper').removeClass('board-item-drag-active');
    dropFinished();


  }

  function dropOnBoardEnd(ev) {
    ev.preventDefault();
    jQuery('#'+ev.dataTransfer.getData("text")).insertBefore('#'+ev.target.parentNode.id);
    dropFinished();
    saveKanbanItem(ev.dataTransfer.getData("text"));
  }

  function dropOnBoardOuterEnd(ev) {

    if(dragTempType=='kanbanBoard'){

        ev.preventDefault();

        sortSource = jQuery('#'+ev.dataTransfer.getData("text"));
        if(!jQuery(ev.target).hasClass('kanban-board')){
            sortTarget = jQuery(ev.target).closest('.kanban-board');
        } else {
            sortTarget = jQuery(ev.target);
        }

        dropFinished();
        sortKanbanBoard(sortSource,sortTarget);

        return true;
    }

    if(jQuery(ev.target).hasClass('kanban-item')){// || jQuery(ev.target).hasClass('board-item')
        ev.preventDefault();
        return;
    }

    if(dragTempType=='kanbanItem'){



        ev.preventDefault();
        if(!jQuery(ev.target).hasClass('kanban-board')){
            jQuery('#'+ev.dataTransfer.getData("text")).insertBefore(  jQuery(ev.target).closest(".kanban-board").find(".kanban-item-platzhalter")  );

        } else {
            jQuery('#'+ev.dataTransfer.getData("text")).insertBefore(  jQuery(ev.target).find(".kanban-item-platzhalter")  );
        }

        dropFinished();
        saveKanbanItem(ev.dataTransfer.getData("text"));
    }
  }
function sortKanbanBoard(sortSource,sortTarget){
    // I added those 2 lignes because ajaxUrl is not defined !!!
    var kanbanElement = $('#kanban');
    var ajaxUrl = kanbanElement.data('ajaxUrl');

    if(sortTarget.is(':last-child')){
        $.post({
            url: ajaxUrl,
            data: {"tx_dslintranet_kanban[switch]":'moveKanbanBoardToLast',"tx_dslintranet_kanban[item]":{boardUid:sortSource.attr('data-board-uid')},"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
            cache: false,
            success:function (data) {

            }
        });
        sortSource.insertAfter(  sortTarget  );
    } else {
        $.post({
            url: ajaxUrl,
            data: {"tx_dslintranet_kanban[switch]":'sortKanbanBoard',"tx_dslintranet_kanban[item]":{sourceBoardUid:sortSource.attr('data-board-uid'),targetBoardUid:sortTarget.attr('data-board-uid')},"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
            cache: false,
            success:function (data) {

            }
        });
        sortSource.insertBefore(  sortTarget  );
    }

}
  function dropOnKanbanItem(ev) {


    if(dragTempType!='kanbanItem'){
        ev.preventDefault();
        return;
    }

      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");

      jQuery( document.getElementById(data) ).insertBefore( '#'+ev.target.id );
      dropFinished();
      saveKanbanItem(ev.dataTransfer.getData("text"));


  }

  function dragOverKanbanItem(ev) {

    if(dragTempType == 'kanbanItem') {
    //if(ev.dataTransfer.getData("type") == 'kanbanItem') {

        jQuery('.board-dragover').removeClass('board-dragover');
        jQuery('.kanban-item-dragover').removeClass('kanban-item-dragover');//erst alle anderen entfernen

        if(!jQuery('#'+ev.target.id).closest('.kanban-wrapper').length) return false;//abblocken wenn es sich um ein NICHT platziertes element handelt

        jQuery('#'+ev.target.id+'.kanban-item').addClass('kanban-item-dragover');


        ev.preventDefault();
    }
  }
  function dropFinished(){
    jQuery('.board-dragover').removeClass('board-dragover');
    jQuery('.kanban-item-platzhalter-dragover').removeClass('kanban-item-platzhalter-dragover');
    jQuery('.kanban-item-dragover').removeClass('kanban-item-dragover');
    jQuery('.board-dragover-sort').removeClass('board-dragover-sort');
  }


function kanbanChangeMitarbeiter(uid){
    jQuery('.mitarbeiter-selector .mitarbeiter-button-active').removeClass('mitarbeiter-button-active');
    jQuery('.mitarbeiter-selector .mitarbeiter-button[data-mitarbeiter-uid="'+uid+'"]').addClass('mitarbeiter-button-active');
    refreshKanban();
}


$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});



var kanbanItemSearchTimeout;
var kanbanItemSearchVal;
var kanbanItemSearchStatus;


function kanbanItemSearch(){
    kanbanItemSearchVal = jQuery('#kanban-item-search-volltextsuche').val();

    kanbanItemSearchStatus = jQuery('#kanban_filter_statuss').val();


    if(kanbanItemSearchVal){
        jQuery('#kanban-item-search-volltextsuche').addClass('search-active');
    } else {
        jQuery('#kanban-item-search-volltextsuche').removeClass('search-active');
    }

    if(kanbanItemSearchTimeout) clearTimeout(kanbanItemSearchTimeout);
    kanbanItemSearchTimeout = setTimeout(function(){
        if(kanbanItemSearchVal || kanbanItemSearchStatus){
            jQuery("#kanbanProjekteWrapper .kanban-item-search" ).addClass("kanban-item-search-hidden");


            if(kanbanItemSearchStatus){
                jQuery.each(kanbanItemSearchStatus, function( index, value ) {
                    jQuery("#kanbanProjekteWrapper .kanban-item-search div.filter-kanban-projekte-status:contains('S"+value+"S')" ).closest(".kanban-item-search").removeClass("kanban-item-search-hidden");
                });
                if(kanbanItemSearchVal){
                    jQuery("#kanbanProjekteWrapper .kanban-item-search div.filter-kanban-projekte-search:not(:contains('"+kanbanItemSearchVal+"'))" ).closest(".kanban-item-search").addClass("kanban-item-search-hidden");
                }
            } else {

                if(kanbanItemSearchVal){

                    jQuery("#kanbanProjekteWrapper .kanban-item-search div.filter-kanban-projekte-search:contains('"+kanbanItemSearchVal+"')" ).closest(".kanban-item-search").removeClass("kanban-item-search-hidden");
                }
            }



        } else {
            jQuery("#kanbanProjekteWrapper .kanban-item-search-hidden" ).removeClass("kanban-item-search-hidden");
        }

        jQuery("#kanbanProjekteWrapper .kanban-auftraege").attr('data-counter-visible',jQuery("#kanbanProjekteWrapper .kanban-auftraege .kanban-item-search:not(.kanban-item-search-hidden)" ).length);

        jQuery("#kanbanProjekteWrapper .kanban-auftraege-ausgeblendet-wrapper").attr('data-counter-visible',jQuery("#kanbanProjekteWrapper .kanban-auftraege-ausgeblendet .kanban-item-search:not(.kanban-item-search-hidden)" ).length);

    }, 300);

}


function initKanbanFilterStatuss(){
    $('#kanban_filter_statuss').selectpicker();
    $('#kanban_filter_statuss').change(function() {
        kanbanItemSearch();
    });
}


function toggleListeNeuForm(){


    if($('#kanban-board-btn-wrapper').attr('data-kanban-boards')==6){
        alert('Die maximale Anzahl an Listen ist erreicht.');
        return false;
    }

    $('#kanban-board-btn-wrapper').toggleClass('show-liste-neu-form');
    if($('#kanban-board-btn-wrapper').hasClass('show-liste-neu-form')){
        $('#kanban-liste-neu-name').val('').focus();
    }
}

function listeNeuAnlegen(){
    // I added those 2 lignes because ajaxUrl is not defined !!!
    var kanbanElement = $('#kanban');
    var ajaxUrl = kanbanElement.data('ajaxUrl');
    if($('#kanban-liste-neu-name').val()){
        toggleListeNeuForm();
        $('.kanban-pretty-split-pane-frame').addClass('contentReloads');

        $.post({
            url: ajaxUrl,
            data: {"tx_dslintranet_kanban[switch]":'addKanbanBoard',"tx_dslintranet_kanban[titel]":$('#kanban-liste-neu-name').val(),"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
            cache: false,
            success:function (data) {
                refreshKanban();
            }
        });


    }
}




function dragKanbanBoard(ev) {

    if(jQuery(ev.target).hasClass('kanban-board')){
        jQuery('#kanban-board-btn-wrapper').addClass('show-kanban-liste-delete');
        ev.dataTransfer.setData("text", ev.target.id);
        ev.dataTransfer.setData("type", 'kanbanBoard');
        dragTempType = 'kanbanBoard';
        ev.dataTransfer.setData("kanbanBoardId", jQuery(ev.target).attr('data-board-uid'));

    }


  }

function dragEndKanbanBoard(ev) {
    jQuery('#kanban-board-btn-wrapper').removeClass('show-kanban-liste-delete');
    jQuery('.board-dragover-sort').removeClass('board-dragover-sort');

  }

  function allowDropOnDeleteKanbanBoard(ev) {
    if(dragTempType == 'kanbanBoard') ev.preventDefault();
  }
  function dropOnDeleteKanbanBoard(ev) {
      // I added those 2 lignes because ajaxUrl is not defined !!!
      var kanbanElement = $('#kanban');
      var ajaxUrl = kanbanElement.data('ajaxUrl');

    $('.kanban-pretty-split-pane-frame').addClass('contentReloads');

    $.post({
        url: ajaxUrl,
        data: {"tx_dslintranet_kanban[switch]":'deleteKanbanBoard',"tx_dslintranet_kanban[board]":ev.dataTransfer.getData("kanbanBoardId"),"tx_dslintranet_kanban[mitarbeiter]":kanbanActiveMitarbeiter()},
        cache: false,
        success:function (data) {
            refreshKanban();

        }
    });

  }