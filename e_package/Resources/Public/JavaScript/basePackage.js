(function($) {
	// Menu Plan de site
	$('.frame-type-menu_sitemap li ul li').has('ul').prepend('<span class="img_plansite"></span>').addClass('nivi');
	$('.nivi .img_plansite').click(function(){
		$(this).siblings('ul').slideToggle();
		$(this).toggleClass('niviclosed');
	});
	$('.unfold').find('span').click(function(){
		$(this).parent().toggleClass('plier');
		if ($(this).parent().hasClass('plier')){
			$('.unfold').find('span').addClass('active');
			$(this).removeClass('active');
			$('.img_plansite').addClass('niviclosed');
			$('.nivi ul').slideUp();
		} else{
			$('.unfold').find('span').addClass('active');
			$(this).removeClass('active');
			$(':first-child', this).addClass('active');
			$('.img_plansite').removeClass('niviclosed');
			$('.nivi ul').slideDown();
		}
	});


	// Tableau responsive
	//$('.contenttable').stacktable();

	// datepicker
	$.datepicker.setDefaults(
		{
			altField: "#datepicker",
			closeText: 'Fermer',
			prevText: 'Précédent',
			nextText: 'Suivant',
			currentText: 'text',
			monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
			dayNames: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
			dayNamesShort: ['Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.'],
			dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
			weekHeader: 'Sem.',
			dateFormat: 'dd/mm/yy',
			firstDay: 1
		}
	);

	//KONAMI CODE
	var allowedKeys = {
	  37: 'left',
	  38: 'up',
	  39: 'right',
	  40: 'down',
	  65: 'a',
	  66: 'b'
	};
	var konamiCode = ['up', 'up', 'down', 'down', 'left', 'right', 'left', 'right', 'b', 'a'];
	var konamiCodePosition = 0;
	document.addEventListener('keydown', function(e) {
		var key = allowedKeys[e.keyCode];
		var requiredKey = konamiCode[konamiCodePosition];
		if (key == requiredKey) {
			konamiCodePosition++;
			if (konamiCodePosition == konamiCode.length)
			activateCheats();
		} else {
			konamiCodePosition = 0;
		}
	});
})(jQuery);

// Effet sur label champ
function labelForm(champ){
	var focusable = false;
	var jQuerychamp=$(champ);
	var jQuerychLabel=jQuerychamp.find('label');
	var jQuerychText;
	if (jQuerychamp.find('input[type="text"]').length || jQuerychamp.find('input[type="password"]').length) {
		jQuerychText=jQuerychamp.find('input[type="text"]');
		if (jQuerychText.val() != ""){
			jQuerychLabel.hide();
		};
		jQuerychText.keypress(function(){
			jQuerychLabel.hide();
		});
		jQuerychLabel.hover(
			function() {
				jQuerychLabel.fadeTo(250, 0.3);
		  	}, function() {
		  		if(!focusable){
		  			jQuerychLabel.fadeTo(250, 1);
		  		}
		  	}
		);
		jQuerychText.focus(function(){
			if ($(this).val()==""){
				jQuerychLabel.fadeTo(250, 0.1);
			} else{
				jQuerychLabel.hide();
			}
			focusable = true;
		});
		jQuerychLabel.click(function(){
			jQuerychText.focus();
		});
		jQuerychText.blur(function(){
			if ($(this).val()==""){
				jQuerychLabel.fadeTo(250, 1);
			} else{
				jQuerychLabel.hide();
			}
			focusable = false;
		});
	}
}