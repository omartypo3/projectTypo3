var settingsElement = $('#mitarbeiter-settings');
var ajaxUrl = settingsElement.data('ajaxUrl');
		
		$('.btn-toggle').click(function() {
			$(this).find('.btn').toggleClass('active');  

			if ($(this).find('.btn-primary').size()>0) {
				$(this).find('.btn').toggleClass('btn-primary');
			}
			if ($(this).find('.btn-danger').size()>0) {
				$(this).find('.btn').toggleClass('btn-danger');
			}
			if ($(this).find('.btn-success').size()>0) {
				$(this).find('.btn').toggleClass('btn-success');
			}
			if ($(this).find('.btn-info').size()>0) {
				$(this).find('.btn').toggleClass('btn-info');
			}

			$(this).find('.btn').toggleClass('btn-default');
			console.log($(this).data('settings-key'));
			console.log($(this).find('.btn.active').data('settings-value'));
			console.log(ajaxUrl);
			
			var updateAjaxJson = {
				"tx_dslintranet_mitarbeiter[key]":$(this).data('settings-key'),
				"tx_dslintranet_mitarbeiter[value]":$(this).find('.btn.active').data('settings-value')
			};
			console.log(updateAjaxJson);
			dslIntranetAjaxCall(ajaxUrl,updateAjaxJson).done(function (data) {
				console.log('ajaxDone');
			});
		
		});