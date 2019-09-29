$(document).ready(function(){
	
	'use strict';

	// toggle active class on accordeons
	$('.tx-institution-management.display-mode-firm .panel-default .panel-heading > a, .tx-institution-management.display-mode-society .panel-default .panel-heading > a').click(function(){
		$(this).closest('.panel-default').toggleClass('active');
	})
});
