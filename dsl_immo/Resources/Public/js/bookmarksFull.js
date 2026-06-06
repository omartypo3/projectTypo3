// JavaScript Document

$(function(){
	console.log('bookmarksFull.js');
	$('a.bookmarkAjax').click(function (event){ 
		 event.preventDefault(); 
		 $.ajax({
			url: $(this).attr('href')
			,success: function(response) {
				var data = JSON.parse(response);
			
				
				$('a.bookmarkAjax[data-uid="'+data.immobilie+'"]').data('bookmark-state',data.bookmarkState);
				if(data.bookmarkState=='added') {
					$('a.bookmarkAjax[data-uid="'+data.immobilie+'"]').addClass('bookmark-added');
					$( ".bookmark-sidebar-entries" ).prepend( $( data.content ) );

				} else {
					$('a.bookmarkAjax[data-uid="'+data.immobilie+'"]').removeClass('bookmark-added');
					$('.bookmark-sidebar-entry[data-uid="'+data.immobilie+'"]').remove();
				}
				
				if($('.bookmark-sidebar-entry').length){
					$('.bookmark-sidebar-entries').removeClass('empty');
				} else {
					$('.bookmark-sidebar-entries').addClass('empty');
				}
				
			}
		 })
		 return false; //for good measure
	});
	
	/*alle in merkliste  als aktiv markieren*/
	//$('.bookmark-sidebar-entry').each(function (key, value) { 
	   $('a.bookmarkAjax').data('bookmark-state','added').addClass('bookmark-added');
	//});


});