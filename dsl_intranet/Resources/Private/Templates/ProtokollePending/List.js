var protokollePending = $('#protokollePending');
var protokollePendingAjaxUrl = $('#protokollePending').data('ajaxUrl');
var protokollePendingEditUrl = $('#protokollePending').data('editUrl');

function showMailFormProtokollePending(protokollePendingUid) {

  if($('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').length) {
    $('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').prependTo($('#protokollePending'));
  } else {
    $('<div data-uid="'+protokollePendingUid+'"></div>').prependTo($('#protokollePending'));
    $('#protokollePending').prepend();
  }
  openMailFormProtokollePending();
}

function openMailFormProtokollePending() {
	//console.log('openMailFormProtokollePending!!')
  if($('#protokollePending>div').length) {
	  //console.log('openMailFormProtokollePending1!!')
    var protokollePendingToOpen = $('#protokollePending>div').first();

    if($('#protokollePending').data('popup-status')=='closed') {
		
	//	console.log('openMailFormProtokollePending2!!')
		
      $('#protokollePending').data('popup-status-opened-uid',protokollePendingToOpen.data('uid'));
      $('#protokollePending').data('popup-status','opened');
     
	  /*initialisierung statusbox*/
      var doAjaxEditColorBoxHeight = '900px';var doAjaxEditColorBoxWidth = '1000px';
      if( $(this).data('colorbox-width') ) doAjaxEditColorBoxWidth = $(this).data('colorbox-width'); 
      if( $(this).data('colorbox-height') ) {
        var maxWindowsHeight = $( window ).height()-10;
        var colorBoxHeight = parseInt($(this).data('colorbox-height'));
        if(maxWindowsHeight < colorBoxHeight) doAjaxEditColorBoxHeight=maxWindowsHeight+'px';  else doAjaxEditColorBoxHeight = $(this).data('colorbox-height');	
      }
      $.colorbox({width:"10%", height:"10%", className:'colorbox_background',overlayClose: false});

      var editAjaxJson = {"tx_dslintranet_protokollependingmailer[protokollePending]":protokollePendingToOpen.data('uid')};
      dslIntranetAjaxCall(protokollePendingEditUrl,editAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
	  
		console.log('openMailFormProtokollePending1!!')
        if($(data).length>10) {
          window.top.location.reload();
          return false;
        }
		console.log(data);
		  if($(data).find('input.protokollePendingMailSubject').val()){
			  console.log('open');
				
			  $.colorbox({
				  width:doAjaxEditColorBoxWidth, 
				  height:doAjaxEditColorBoxHeight, 
				  html:data, 
				  fixed:true, 
				  reposition:true, 
				  className:'colorbox_background',
				  onClosed:function(){
						closeMailFormProtokollePending();
 				  },
				  
				  
				  overlayClose: false
				});
		  } else {
			  console.log('close');
			  $('#protokollePending>div[data-uid="'+protokollePendingToOpen.data('uid')+'"]').remove()
			  closeMailFormProtokollePending();
			  $.colorbox.close();
		  }

	  });

    } else {
      openMailFormProtokollePendingRefreshHeader();
    }
  } else {$.colorbox.close();}
}

function protokollePendingClose(){
	$('#cboxClose').click();
	var uid = $('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[protokollePending]"]').val();
  	var closeAjaxJson = {"tx_dslintranet_protokollependingmailer[switch]":"protokollePendingClose",
						 "tx_dslintranet_protokollependingmailer[protokollePending]":uid};

      dslIntranetAjaxCall(protokollePendingAjaxUrl,closeAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
        protokollePendingComplete(uid);
      });
}

function closeMailFormProtokollePending(){
	$('#protokollePending').data('popup-status-opened-uid','');
    $('#protokollePending').data('popup-status','closed');
}
function openMailFormProtokollePendingRefreshHeader(){
	//  console.log('openMailFormProtokollePendingRefreshHeader()');
	//  console.log('anzahl in schleife:'+$('#protokollePending>div').length);
}

$(document).ready(function() {
    openMailFormProtokollePending();
});

function protokollePendingComplete(protokollePendingUid){

  if($('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').length){
    $('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').remove();
    closeMailFormProtokollePending();
  } 
  openMailFormProtokollePending();

}

function refreshPreviewOnChange(){
  $('.protokollePendingMailPreview').addClass('previewLoading');
  var uid = $('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[protokollePending]"]').val();
  var previewAjaxJson = {"tx_dslintranet_protokollependingmailer[switch]":"getMailPreview",
						 "tx_dslintranet_protokollependingmailer[protokollePending]":uid,
						"tx_dslintranet_protokollependingmailer[subject]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[subject]"]').val(),
						"tx_dslintranet_protokollependingmailer[mitteilung]":$('#protokollePendingEditForm textarea[name="tx_dslintranet_protokollependingmailer[mitteilung]"]').val(),
						"tx_dslintranet_protokollependingmailer[mailTo]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[mailTo]"]').val(),
						"tx_dslintranet_protokollependingmailer[kundeName]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[kundeName]"]').val(),
						"tx_dslintranet_protokollependingmailer[mailToCC]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[mailToCC]"]').val(),
						"tx_dslintranet_protokollependingmailer[fromName]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[fromName]"]').val(),
						"tx_dslintranet_protokollependingmailer[fromMail]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[fromMail]"]').val(),
						"tx_dslintranet_protokollependingmailer[kundeNameCC]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[kundeNameCC]"]').val()};
	dslIntranetAjaxCall(protokollePendingAjaxUrl,previewAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
		$('#protokollePendingMailPreviewHtml').html($(data).find('#protokollePendingMailPreviewHtml').html());
		$('#protokollePendingMailPreview').html($(data).find('#protokollePendingMailPreview').html());
		$('.protokollePendingMailPreview').removeClass('previewLoading');
	  });

}

function reOpenMailFormProtokollePending(){

	$.colorbox.close();
	setTimeout(function(){
		$('#protokollePending').data('popup-status-opened-uid','');
		$('#protokollePending').data('popup-status','closed');
		openMailFormProtokollePending();
	}, 1000);
}