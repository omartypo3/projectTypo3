{namespace v=FluidTYPO3\Vhs\ViewHelpers}// JavaScript Document

var protokollePendingAjaxUrl = '<v:variable.get name="ajaxUrl" />';
var protokollePendingEditUrl = '<v:variable.get name="editUrl" />';

function showMailFormProtokollePending(protokollePendingUid) <f:format.raw>{</f:format.raw>

  if($('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').length) <f:format.raw>{</f:format.raw>
    $('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').prependTo($('#protokollePending'));
  } else <f:format.raw>{</f:format.raw>
    $('<div data-uid="'+protokollePendingUid+'"></div>').prependTo($('#protokollePending'));
    $('#protokollePending').prepend();
  }
  openMailFormProtokollePending();
}

function openMailFormProtokollePending() <f:format.raw>{</f:format.raw>
	//console.log('openMailFormProtokollePending!!')
  if($('#protokollePending>div').length) <f:format.raw>{</f:format.raw>
	  //console.log('openMailFormProtokollePending1!!')
    var protokollePendingToOpen = $('#protokollePending>div').first();

    if($('#protokollePending').data('popup-status')=='closed') <f:format.raw>{</f:format.raw>
		
	//	console.log('openMailFormProtokollePending2!!')
		
      $('#protokollePending').data('popup-status-opened-uid',protokollePendingToOpen.data('uid'));
      $('#protokollePending').data('popup-status','opened');
     
	  /*initialisierung statusbox*/
      var doAjaxEditColorBoxHeight = '900px';var doAjaxEditColorBoxWidth = '1000px';
      if( $(this).data('colorbox-width') ) doAjaxEditColorBoxWidth = $(this).data('colorbox-width'); 
      if( $(this).data('colorbox-height') ) <f:format.raw>{</f:format.raw>
        var maxWindowsHeight = $( window ).height()-10;
        var colorBoxHeight = parseInt($(this).data('colorbox-height'));
        if(maxWindowsHeight < colorBoxHeight) doAjaxEditColorBoxHeight=maxWindowsHeight+'px';  else doAjaxEditColorBoxHeight = $(this).data('colorbox-height');	
      }
      $.colorbox(<f:format.raw>{</f:format.raw>width:"10%", height:"10%", className:'colorbox_background',overlayClose: false});

      var editAjaxJson = {"tx_dslintranet_protokollependingmailer[protokollePending]":protokollePendingToOpen.data('uid')};
      dslIntranetAjaxCall(protokollePendingEditUrl,editAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
	  
		console.log('openMailFormProtokollePending1!!')
        if($(data).length>10) <f:format.raw>{</f:format.raw>
          window.top.location.reload();
          return false;
        }
		console.log(data);
		  if($(data).find('input.protokollePendingMailSubject').val()){
			  console.log('open');
	//		console.log('openMailFormProtokollePending1!!')  console.log($(data).find('input.protokollePendingMailSubject').val());
				
			  $.colorbox(<f:format.raw>{</f:format.raw>
				  width:doAjaxEditColorBoxWidth, 
				  height:doAjaxEditColorBoxHeight, 
				  html:data, 
				  fixed:true, 
				  reposition:true, 
				
				  className:'colorbox_background',
				  onComplete: function()<f:format.raw>{</f:format.raw>
//console.log('oncolplete');
				  },
				  onClosed:function()<f:format.raw>{</f:format.raw>
						closeMailFormProtokollePending();
 				  },
				  
				  
				  overlayClose: false
				});
		  } else <f:format.raw>{</f:format.raw>
			  console.log('close');
			  $('#protokollePending>div[data-uid="'+protokollePendingToOpen.data('uid')+'"]').remove()
			  closeMailFormProtokollePending();
			  $.colorbox.close();
		  }

	  });

    } else <f:format.raw>{</f:format.raw>
      openMailFormProtokollePendingRefreshHeader();
    }
  } else {$.colorbox.close();}
}

function protokollePendingClose()<f:format.raw>{</f:format.raw>
	$('#cboxClose').click();
	var uid = $('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[protokollePending]"]').val();
  	var closeAjaxJson = {"tx_dslintranet_protokollependingmailer[switch]":"protokollePendingClose",
						 "tx_dslintranet_protokollependingmailer[protokollePending]":uid};

      dslIntranetAjaxCall(protokollePendingAjaxUrl,closeAjaxJson).done(function (data /* , textStatus, jqXHR */ ) <f:format.raw>{</f:format.raw>
        protokollePendingComplete(uid);
      });
}

function closeMailFormProtokollePending()<f:format.raw>{</f:format.raw>
	$('#protokollePending').data('popup-status-opened-uid','');
    $('#protokollePending').data('popup-status','closed');
}
function openMailFormProtokollePendingRefreshHeader()<f:format.raw>{</f:format.raw>
	//  console.log('openMailFormProtokollePendingRefreshHeader()');
	//  console.log('anzahl in schleife:'+$('#protokollePending>div').length);
}

$(document).ready(function() <f:format.raw>{</f:format.raw>
    openMailFormProtokollePending();
});

function protokollePendingComplete(protokollePendingUid)<f:format.raw>{</f:format.raw>

  if($('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').length)<f:format.raw>{</f:format.raw>
    $('#protokollePending>div[data-uid="'+protokollePendingUid+'"]').remove();
    closeMailFormProtokollePending();
  } 
  openMailFormProtokollePending();

}

function refreshPreviewOnChange()<f:format.raw>{</f:format.raw>
  $('.protokollePendingMailPreview').addClass('previewLoading');
  var uid = $('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[protokollePending]"]').val();
  var previewAjaxJson = <f:format.raw>{</f:format.raw>"tx_dslintranet_protokollependingmailer[switch]":"getMailPreview",
						 "tx_dslintranet_protokollependingmailer[protokollePending]":uid,
						"tx_dslintranet_protokollependingmailer[subject]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[subject]"]').val(),
						"tx_dslintranet_protokollependingmailer[mitteilung]":$('#protokollePendingEditForm textarea[name="tx_dslintranet_protokollependingmailer[mitteilung]"]').val(),
						"tx_dslintranet_protokollependingmailer[mailTo]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[mailTo]"]').val(),
						"tx_dslintranet_protokollependingmailer[kundeName]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[kundeName]"]').val(),
						"tx_dslintranet_protokollependingmailer[mailToCC]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[mailToCC]"]').val(),
						"tx_dslintranet_protokollependingmailer[fromName]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[fromName]"]').val(),
						"tx_dslintranet_protokollependingmailer[fromMail]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[fromMail]"]').val(),
						"tx_dslintranet_protokollependingmailer[kundeNameCC]":$('#protokollePendingEditForm input[name="tx_dslintranet_protokollependingmailer[kundeNameCC]"]').val()};
	dslIntranetAjaxCall(protokollePendingAjaxUrl,previewAjaxJson).done(function (data /* , textStatus, jqXHR */ ) <f:format.raw>{</f:format.raw>
		$('#protokollePendingMailPreviewHtml').html($(data).find('#protokollePendingMailPreviewHtml').html());
		$('#protokollePendingMailPreview').html($(data).find('#protokollePendingMailPreview').html());
		$('.protokollePendingMailPreview').removeClass('previewLoading');
	  });

}

function reOpenMailFormProtokollePending()<f:format.raw>{</f:format.raw>

	$.colorbox.close();
	setTimeout(function()<f:format.raw>{</f:format.raw>
		$('#protokollePending').data('popup-status-opened-uid','');
		$('#protokollePending').data('popup-status','closed');
		openMailFormProtokollePending();
	}, 1000);
}