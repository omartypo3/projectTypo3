var ablageAjaxUrl = $('#auftraege').data('ajaxUrl');


function toggleAuftragAblage(btn){

	var auftragUid = jQuery(btn).data('auftrag');
	
	if(jQuery(btn).attr('data-ablage')==1) {
		ablage = 0; 
		$('a[data-auftrag="'+auftragUid+'"]').removeClass('btnGruen');
		$('a[data-auftrag="'+auftragUid+'"]').addClass('notablage');
	
	} else {
		ablage = 1;
		$('a[data-auftrag="'+auftragUid+'"]').addClass('btnGruen');
		$('a[data-auftrag="'+auftragUid+'"]').removeClass('notablage');
	}
	
	
	$('a[data-auftrag="'+auftragUid+'"]').attr('data-ablage',ablage);
	
	
	
	var ajaxJson = {"tx_dslintranet_ablage[switch]":"toggleAuftrag", "tx_dslintranet_ablage[auftrag]":auftragUid, "tx_dslintranet_ablage[ablage]":ablage};
	dslIntranetAjaxCall(ablageAjaxUrl,ajaxJson).done(function (data /* , textStatus, jqXHR */ ) {
		
		jsonString = data.replace(/&quot;/g, '"');
		
		dataJson = JSON.parse(jsonString);
			
		
		$("#auftraegeListFavoritenAnzahl").html('('+dataJson.foundFavoriten+')');
			
		
		
	});
	
	
	$("#favoritenFilter").removeAttr('disabled');
	
}


