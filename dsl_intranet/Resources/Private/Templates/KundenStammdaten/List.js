var kundenstammdatenAjaxUrl = $('#kundenStammdaten').data('ajaxUrl');


 $(document).ready(function() {
	
	 /* stammdaten änderung ****************************** */
	 
	 $('a#stammdatenSpeichernBtn').addClass('disabled');
	 
	 $( "#stammdatenaenderung" ).keyup(function() {
		$('a#stammdatenSpeichernBtn').removeClass('disabled');
	 });
	 
	 
	 $('form#stammdatenaenderung').validate({
		 errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		errorClass: 'invalid',
		submitHandler: function(form) {
			console.log('stammdatenänderung');
			
			$('a#stammdatenSpeichernBtn').addClass('disabled');
			
			$.ajax({
					url: kundenstammdatenAjaxUrl,
					type: 'POST',
					data: $('form#stammdatenaenderung').serialize(),
					
					success: function(data) {
						$('#wrapperKundendatenAjax').replaceWith( $(data) );
						//console.log(data);
						//if(data=="true"){
							
							//$('#passwortSpeichernAbbrechenBtn').click();
							$('#stammdatenGeaendert').fadeIn('fast').delay(5000).fadeOut('slow');
						//}
						
						/*setTimeout(function(){ 
							$('a#stammdatenSpeichernBtn').removeClass('disabled');
						}, 2000);*/
						
						
					}
			});
			
		},
		 rules: {
			'tx_dslintranet_kundenstammdaten[email]': {
				required: true,
				email: true,
				remote: {
					url: kundenstammdatenAjaxUrl,
					type: "post",
					data: {
					  'tx_dslintranet_kundenstammdaten[switch]': 'requestUpdateStammdatenCheckEmail',
					  'tx_dslintranet_kundenstammdaten[email]': function() {
						return $( "#email" ).val();
					  },
					  
					},
				  }
			},
			
			'tx_dslintranet_kundenstammdaten[email_confirm]': {
				equalTo: '[name="tx_dslintranet_kundenstammdaten[email]"]' // <- any valid jQuery selector
			},
			'tx_dslintranet_kundenstammdaten[datenschutz]': {
			 	required: true,
		 	}
		},
		 messages: {
		
			
			'tx_dslintranet_kundenstammdaten[email]': {
				remote: "bereits vergeben",
				email:"ungültig"
			},
			
			'tx_dslintranet_kundenstammdaten[email_confirm]': {
				equalTo: "wiederholen",
				
			}
		}
	 });
	 
	 $('a#stammdatenSpeichernBtn').click(function() {
		//$('a#passwortAendernBtn').parent().css('display','block');
		//$('form#stammdatenpasswortaenderung').css('display','none');
		
		$('form#stammdatenaenderung').submit();
		
		return false;
		
	});
	 
	 /* passwort änderung ****************************** */
	 
	 
	 
	 $('form#stammdatenpasswortaenderung').validate({
		
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		errorClass: 'invalid',
		submitHandler: function(form) {
			
			
			$.ajax({
					url: kundenstammdatenAjaxUrl,
					type: 'POST',
					data: $('form#stammdatenpasswortaenderung').serialize(),
					
					success: function(data) {
						
						if(data=="true"){
							
							$('#passwortSpeichernAbbrechenBtn').click();
							$('#passwortGeaendert').fadeIn('fast').delay(5000).fadeOut('slow');
						}
					}
			});
			
		},
		rules: {
			'tx_dslintranet_kundenstammdaten[password_alt]': {
				required: true,
				remote: {
					url: kundenstammdatenAjaxUrl,
					type: "post",
					data: {
					  'tx_dslintranet_kundenstammdaten[switch]': 'requestUpdatePasswortCheckOldPassword',
					  'tx_dslintranet_kundenstammdaten[password_alt]': function() {
						return $( "#password_alt" ).val();
					  }
					},
				  }
			},
			'tx_dslintranet_kundenstammdaten[password_neu]': {
				required: true,
				minlength: 6
			},
			'tx_dslintranet_kundenstammdaten[password_neu_confirm]': {
				equalTo: '[name="tx_dslintranet_kundenstammdaten[password_neu]"]' // <- any valid jQuery selector
			}
		},
		messages: {
		
			
			'tx_dslintranet_kundenstammdaten[password_alt]': {
				remote: "Passwort falsch"
			},
			'tx_dslintranet_kundenstammdaten[password_neu]': {
				minlength: "min. 6 Zeichen"
			},
			'tx_dslintranet_kundenstammdaten[password_neu_confirm]': {
				equalTo: "wiederholen",
				
			}
		}
	 });
	 
	$('#password_alt').attr('placeholder','Altes Passwort eingeben*').attr('required','required');
	$('#password_neu').attr('placeholder','Neues Passwort eingeben*').attr('required','required');
	$('#password_neu_confirm').attr('placeholder','Neues Passwort bestätigen*').attr('required','required');
	
	
	$( "a#passwortAendernBtn" ).click(function() {
  		resetFormStammdatenpasswortaenderung();
		$(this).parent().css('display','none');
		$('form#stammdatenpasswortaenderung').css('display','inline');
		/*
		if($(this).parent().css('display') == 'block'){ //formular zeigen und den btn ausblenden
			$(this).parent().css('display','none');
		} else { //formular ausblenden und den btn wieder einblenden
			$(this).parent().css('display','block');
		}*/
		
		return false;
	});
	
	$( "a#passwortSpeichernAbbrechenBtn" ).click(function() {
		$('a#passwortAendernBtn').parent().css('display','block');
		$('form#stammdatenpasswortaenderung').css('display','none');
		return false;
		
	});
	 
	$('a#passwortSpeichernBtn').click(function() {
		//$('a#passwortAendernBtn').parent().css('display','block');
		//$('form#stammdatenpasswortaenderung').css('display','none');
		
		$('form#stammdatenpasswortaenderung').submit();
		
		return false;
		
	});
	 
	function resetFormStammdatenpasswortaenderung(){
		 $('#password_alt,#password_neu,#password_neu_confirm').val('');
	}
	
	 
	 
	/* ****************************** */
	 
	checkToggleChildGroup();
	 
	$('.stammdatenToggleChange').change(function() {
	//	console.log('changed!!');
	//	console.log($(this).prop('checked'));
		
		/*if($(this).data('key')=="becomeInfoGlobal"){
			if($(this).prop('checked')){
				$('.becomeInfoGlobalChildGroup .stammdatenToggleChange').bootstrapToggle('enable');
				
			} else {
				$('.becomeInfoGlobalChildGroup .stammdatenToggleChange').bootstrapToggle('disable');
			}
		}*/
		checkToggleChildGroup();
		
		var ajaxJson = {"tx_dslintranet_kundenstammdaten[switch]":"toggleSwitch", "tx_dslintranet_kundenstammdaten[key]":$(this).data('key'), "tx_dslintranet_kundenstammdaten[value]":$(this).prop('checked')};
		if($(this).data('key')=="newsletter"){
			if($(this).prop('checked')){
				
				$('#emailNewsletterWrapper').removeClass('formInaktiv');
				$('#emailNewsletter').removeAttr('disabled','disabled');
				//$('#emailNewsletter').css('opacity',1);
			} else {
				$('#emailNewsletterWrapper').addClass('formInaktiv');
				$('#emailNewsletter').attr('disabled','disabled');
				//$('#emailNewsletter').css('opacity',0.5);
			}
		}
		dslIntranetAjaxCall(kundenstammdatenAjaxUrl,ajaxJson).done(function (data  ) {
			console.log(data);
		});
		
		
    });
	 
	/*formular für änderung*/
	$('.animated').autosize({append: "\n"});
	$('.validator_required').attr('required','required');
	 
	 
	 
	 
	 
	$.validator.messages.required = '<i class="fa fa-exclamation-circle"></i>';
	$.validator.messages.min = '<i class="fa fa-exclamation-circle"></i>';
	
	 $('.stammdatenaenderungFormSubmitted').hide();
			
	$('#stammdatenaenderung').validate({
		invalidHandler: function(event, validator) { validateFormInvalidHandler(validator); },
		errorPlacement: function(error, element) {
			//error.appendTo(element.parent());
		},
		/*
		kundenstammdaten
		rules: {
			'tx_dslintranet_auftragsliste[kontingent]': { required: true, min: 1 },
			'tx_dslintranet_auftragsliste[minutenUnzugewiesen]': { required: true,digits: true },
			'tx_dslintranet_auftragsliste[kontingentFail]': { required: true }
		},
		*/

		ignore: ':hidden:not(".validator_required")', // Tells the validator to check the hidden select */
		errorClass: 'invalid',
		submitHandler: function(form) {	
			console.log('submit');
			
			
			if($('#stammdatenaenderung').hasClass('formSaves'))	return false;
			$('#stammdatenaenderung').addClass('formSaves');
			$('#stammdatenaenderungText').css('opacity',0.5);
			console.log('submit22');
			$.ajax({
				url: $('#stammdatenaenderung').attr('action'),
				type: 'POST',
				data: $('#stammdatenaenderung').serialize(),
				success: function(data) {
					$('#stammdatenaenderungText').css('opacity',1);
					$('#stammdatenaenderung').removeClass('formSaves');
					
					$('.stammdatenaenderungForm').hide();
					$('.stammdatenaenderungFormSubmitted').show();
					
					
					$("#stammdatenaenderungText").val('');
					$('.stammdatenaenderungFormContent').html(data);
				}
			});
			/*
			if($('#zeiteintraegeCreateForm').hasClass('formSaves'))	return false;
			$('#zeiteintraegeCreateForm').addClass('formSaves');

			validateFormInvalidHandlerReset();



			$.ajax({
				url: $('#zeiteintraegeCreateForm').attr('action'),
				type: 'POST',
				data: $('#zeiteintraegeCreateForm').serialize(),
				success: function(data) {

					console.log(data);

					dataJson = JSON.parse(data);

					//reloadAuftragId('list',id);
					if(!dataJson["auftraegeUid"]) {
						console.log(dataJson);
						return true;
					} else {


						refreshProjektTabContent(dataJson["auftraegeUid"]);



						$.colorbox.close();
					}

					//$.colorbox.close();


				}
			});
*/

		}
	});
//	alert('noch nicht FERTIG!!!!');

 });


function setKundeNewsletterEmail(){
	
	
	if(!$('.stammdatenToggleChange[data-key="newsletter"]').prop('checked')) return false;
	
	console.log($('#emailNewsletter').val());
	console.log('setKundeNewsletterEmail');
	
	
	if(!$('#emailNewsletter').val()){
	   $('.stammdatenToggleChange[data-key="newsletter"]').bootstrapToggle('off')
	   }
	
	var ajaxJson = {"tx_dslintranet_kundenstammdaten[switch]":"setKundeNewsletterEmail", "tx_dslintranet_kundenstammdaten[email]":$('#emailNewsletter').val()};
/*	if($(this).data('key')=="newsletter"){
		if($(this).prop('checked')){

			$('#emailNewsletterWrapper').removeClass('formInaktiv');
			$('#emailNewsletter').removeAttr('disabled','disabled');
			//$('#emailNewsletter').css('opacity',1);
		} else {
			$('#emailNewsletterWrapper').addClass('formInaktiv');
			$('#emailNewsletter').attr('disabled','disabled');
			//$('#emailNewsletter').css('opacity',0.5);
		}
	}*/
	dslIntranetAjaxCall(kundenstammdatenAjaxUrl,ajaxJson).done(function (data  ) {
		console.log(data);
	});
	
	return false;
}


function checkToggleChildGroup(){
	if(!$('.stammdatenToggleChange[data-key="becomeInfoGlobal"]').prop('checked')){
		$('.becomeInfoGlobalChildGroup .stammdatenToggleChange').bootstrapToggle('disable');
		
	} else {
		$('.becomeInfoGlobalChildGroup .stammdatenToggleChange').bootstrapToggle('enable')
	}
}
	 