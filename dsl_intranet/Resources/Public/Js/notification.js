// JavaScript Document

var dslIntranetNotificationCheckAjaxTimeout = false;

function dslIntranetNotificationCheck(){
	
	//console.log('anzahl:'+$('.notification-item').length);
	
	
	dslIntranetNotificationCheckAjaxTimeout = setTimeout(function(){ dslIntranetNotificationCheckAjax('#notificationInit'); }, 10000);
	
}

function dslIntranetNotificationCheckAjax(selector){
	//console.log('dslIntranetNotificationCheckAjax');
	//console.log($(selector).data('reload-uri'));
	var jqxhrLoginCheck = $.get( $(selector).data('reload-uri'), function(data) {
		
		if($(data).find('#notificationInit').data('reload-uri')) {
			$('#notificationInit').data('reload-uri',$(data).find('#notificationInit').data('reload-uri'));
		}
		
		//console.log(data);
		//console.log('neueurl:'+$(data).find('#notificationInit').data('reload-uri'));
		//console.log('anahl elemente:'+$(data).find('.notification-item').length);
		
		//$(data).each()
		//var message = {'body':'Ihr Login ist verfallen! Sie wurden auf den Login weitergeleitet.'};
		
		
		$(data).find('.notification-item').each(function(){
		//  console.log(this);
		  var item = $(this);
		  //console.log(item.data('notification-titel'));
		  var message = {'titel':item.data('notification-titel'),'body':item.data('notification-body'),'icon':item.data('notification-icon')};
		  //console.log(message);
		  notifyMessage( message );
		});

		//$(data).find('.notification-item').clone().insertAfter( $('#notificationInit') );
		$(data).find('.notification-item').insertAfter( $('#notificationInit') );
		notificationInit();
		
		dslIntranetNotificationCheck();
		
		
	});
}

function setNotificationCounter(){
	var anzahl = $('.notification-item[data-notification-gelesen="0"]').length;
	if(anzahl>99) anzahl = 99;
	$('.notification-counter').attr('data-notification-ungelesen',anzahl);
	$('.notification-counter').text(anzahl);
	$('.notification-item-empty').attr('data-notification-anzahl',$('.notification-item').length);
	
	
}
function notificationInit(){
	
	
	$( ".notificationBtnDelete.doInit" ).click(function() {
		
	
		$.get( $(this).attr('href'));
		
		$(this).hide();
		$(this).closest('.notification-item').animate({height:'0px'},300,function(){this.remove();setNotificationCounter();});
		
		//$('.notification-item').animate({height:'110px'});
		//setNotificationCounter();
		return false;
	});
	
	
	//$( ".notificationBtnDetail").unbind( "click" );
	$( ".notificationBtnDetail.doInit" ).click(function() {
		
	 
	  if( $(this).closest('.notification-item').attr('data-notification-gelesen') == 0){
		  $.get( $(this).attr('href'));
		  $(this).closest('.notification-item').attr('data-notification-gelesen',1);
		  setNotificationCounter();
	  }
		
	  var parent = $(this).closest('.notification-item');
	  if(parent.data('notification-auftrag-uid')){
		if (typeof addProjektTab !== 'undefined' && $.isFunction(addProjektTab)) {
		  addProjektTab("auftrag-show-"+parent.data('notification-auftrag-uid'));
			//+reload!!
		}
	  }
	  $(this).trigger('blur');
		
	  return false;
	});
	$('.notificationBtnDetail.doInit,.notificationBtnDelete.doInit').removeClass('doInit');
	
	
	setNotificationCounter();
}
$(document).ready(function() {
	
	//console.log('notification init');	
	dslIntranetNotificationCheck();
	
	notificationInit();
	
	$( ".notificationBtnReadAll" ).click(function() {
		$.get( $(this).attr('href'));
		$('.notification-item').attr('data-notification-gelesen',1);
		setNotificationCounter();
		$(this).trigger('blur');
	  	return false;
	});
	
	
});