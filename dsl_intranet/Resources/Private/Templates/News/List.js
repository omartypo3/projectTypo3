// JavaScript Document

console.log('list.js');


$(function() {
	
	
	$(document).on('updateNews', function(e, opts) {
		console.log('updateNews');
		console.log(opts);
		if(opts.action == 'before'){
			$(opts.selector).css({ opacity: 0.5 });
	  	} else {
			console.log('finished!!!');
			console.log('ahhh fehler');
			
			var content = $(opts.data).find("#newsListContent").children().first();
			console.log(content.attr('id'));
			$('#'+content.attr('id')).replaceWith( content );

			reInitAjaxCalls();
			
			//$(opts.selector).remove();
	  	}
	});
		

	$(document).on('deleteNews', function(e, opts) {
		console.log(opts);
		if(opts.action == 'before'){
			$(opts.selector).css({ opacity: 0.5 });
		} else {
			$(opts.selector).remove();
		}
	});
	
  // Add an event listener.
  $(document).on('newsFormInit', function(e, opts) {
	  
	  $('.validator_required').attr('required','required');
	  
	  console.log('sichtbarkeitCheckboxInit');
	  //gilt für sichtbarkeit + countdown
	  $.each( $('.sichtbarkeitCheckbox:checked'), function( key, value ) {
		$(this).next().children().addClass('active');
	  });
	  $('.sichtbarkeitCheckboxBtn').click(function(e) {
		if($(this).children('.btn').hasClass('active')){
			$(this).prev('.sichtbarkeitCheckbox').prop( "checked", false );
		} else {
			$(this).prev('.sichtbarkeitCheckbox').prop( "checked", true );
		}
	  });
	  
	  
	  
	  $('.fullDateTimePicker').datetimepicker({
			locale: 'de',
			/*sideBySide: true,*/
			showTodayButton: true,
			showClear: true,
			showClose: true,
			toolbarPlacement: 'bottom'
		});

	  console.log(opts);
	  
	  $.validator.messages.required = '<i class="fa fa-exclamation-circle"></i>';
	 
	  $(opts.formSelector).validate({
			invalidHandler: function(event, validator) { validateFormInvalidHandler(validator); },
			errorPlacement: function(error, element) {
				error.appendTo(element.parent());
			},
			ignore: ':hidden:not(".validator_required")', // Tells the validator to check the hidden select */
			errorClass: 'invalid',
			submitHandler: function(form) {
				
							
				
				console.log('submit: '+opts.action);		
				//return false;
				
				
				var fileTypeError = false;
				var formData = new FormData();
				params  = $(opts.formSelector).serializeArray();
				files    = $(opts.formSelector).find('#fileUploadDateien')[0].files;
				if(files.length != 0) {
					
               		$.each(files, function(i, file) {
						
						if(file["type"] != 'image/png' && file["type"] != 'image/jpeg') {
							fileTypeError = true;
						} else formData.append('tx_dslintranet_news[news][datei]', file);
						
					});
				} 
				
				if(fileTypeError) {
					console.log('falscher dateityp');
					return false;
				}
				
				
				
				if($(opts.formSelector).hasClass('formSaves'))	return false;
				$(opts.formSelector).addClass('formSaves');

				validateFormInvalidHandlerReset();

				$.each(params, function(i, val) {
/*					if(val.name=='tx_dslintranet_news[newNews]') {
						console.log('gefunden!: tx_dslintranet_news[newNews]');
						formData.append('tx_dslintranet_news[news]', val.value);
					} else {*/
						formData.append(val.name, val.value);
					/*}*/
				});
				console.log(opts);
				if(opts.action=="edit"){
					//$(opts.formSelector).data('news');
					console.log('updateNewsbefore');
					
					$(document).trigger('updateNews', {   action: 'before', selector:'#newsList_'+$(opts.formSelector).data('news') });
					$.colorbox.close();
				}


				
				$.ajax({
					url: $(opts.formSelector).attr('action'),
					type: 'POST',
					data: formData,/*$(opts.formSelector).serialize(),*/
					contentType: false,
			        processData: false,
					success: function(data) {

						console.log(data);

						$.colorbox.close();
					
							var dataJson = JSON.parse($(data).find('textarea#resultJson').val());
							console.log(dataJson);


							
							if(opts.action=="new"){
								var content = $(data).find("#newsListContent").children().first();
								$('#newsListWrapper').prepend( content );	
							} else {
							//	console.log(content.attr('id'));
								//$('#'+content.attr('id')).replaceWith( content );
								
								$(document).trigger('updateNews', {   action: 'finished', data: data  });
								
								
							}


							reInitAjaxCalls();
						
						console.log('submitfertig: '+opts.action);
						
						/*dataJson = JSON.parse(data);

						//reloadAuftragId('list',id);
						if(!dataJson["auftraegeUid"]) {
							console.log(dataJson);
							return true;
						} else {


							refreshProjektTabContent(dataJson["auftraegeUid"]);



							$.colorbox.close();
						}
*/
						//$.colorbox.close();


					}
				});
				
				
		  	}
		});
    
  });
	
	
 
});