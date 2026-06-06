// JavaScript Document



 $(document).ready(function() {
	
	 reInitShortcutButtons();

 });

function reInitShortcutButtons(){
	$( ".shortcutButton").unbind( "click" );
	$( ".shortcutButton" ).bind( "click", function() {
	  var tabType = $(this).data('shortcut-type');
	  var parentTr = $(this).closest('tr[data-wv-uid]');
	  var auftragsDetailTr = parentTr.next();
	  if(!parentTr.hasClass('opened')){
		console.log('muss erst geöffnet werden');
		$('#wartungsvertrag-show-'+parentTr.data('wv-uid')+'-headline').click();
		console.log('öffnen des tab wurde veranlasst');
	  }

	  activateAuftragsDetailTab('#auftraegetabs_'+parentTr.data('wv-uid'),tabType,auftragsDetailTr);

	  return false;
	});
}


function activateAuftragsDetailTab(tabSelector,tabType,auftragsDetailTr){
		if(auftragsDetailTr.hasClass('tabReloads')){
		  setTimeout(function(){ activateAuftragsDetailTab(tabSelector,tabType,auftragsDetailTr); }, 100);
		} else {
		  $( tabSelector ).tabs( "option", "active", $( tabSelector+'>ul>li[data-type="'+tabType+'"]' ).index());
		  $('html, body').animate({
			  scrollTop: $(tabSelector).offset().top
		  }, 500);
		}
	}