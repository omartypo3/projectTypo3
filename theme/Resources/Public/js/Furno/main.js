jQuery(document).ready(function($) {


/*
|--------------------------------------------------------------------------
| Global myTheme Obj / Variable Declaration
|--------------------------------------------------------------------------
|
|
|
*/

	var myTheme = {},
    $win = $( window );
	


/*
|--------------------------------------------------------------------------
| isotope
|--------------------------------------------------------------------------
|
|
|
*/		

	myTheme.Isotope = function () {
		
		// 3 column layout
		var isotopeContainer2 = $('.isotopeContainer');
		if( !isotopeContainer2.length || !jQuery().isotope ) return;
		var filterValue = $('.isotopeFilters').find('li.active').find('a').attr('data-filter');
		//$win.load(function(){
			isotopeContainer2.isotope({
				itemSelector: '.isotopeSelector',
				filter: filterValue
			});

			/*var filterValue = $('.isotopeFilters').find('li.active').find('a').attr('data-filter');
			isotopeContainer2.isotope({ filter: filterValue });*/

           //myTheme.ScrollToFix();

			$('.isotopeFilters').on( 'click', 'a', function(e) {
				$('.isotopeFilters').find('.active').removeClass('active');
				$(this).parent().addClass('active');
				var filterValue = $(this).attr('data-filter');
				isotopeContainer2.isotope({ filter: filterValue });
				e.preventDefault();
				//$('.furno-navigation').trigger('detach.ScrollToFixed');
				//myTheme.ScrollToFix();
			});
		//});		
	
	};
	
	

/*
|--------------------------------------------------------------------------
| Fancybox
|--------------------------------------------------------------------------
|
|
|
*/		

	myTheme.Fancybox = function () {
		$(".fancybox-iframe").fancybox({
	         transitionIn		: 'none',
			 transitionOut		: 'none',
			 type				: 'iframe',
			 scrolling   		: 'no',
			 padding          : [11, 11, 11, 11]
		});
		$(".fancybox-pop").each(function(){

			var fancyContent = $(this).find('.popup-wrapper').html();

			$(this).fancybox({
				afterLoad: function() {
					this.title = fancyContent;
				},
				helpers : {
					title: {
						type: 'inside'
					}
				},
				closeClick	: false,
				autoScale   :false,
				openEffect	: 'none',
				closeEffect	: 'none',
				padding   : [11, 11, 11, 11]
			});
		});

	
	};
	
		
/*
|--------------------------------------------------------------------------
| ScrollTOFIX
|--------------------------------------------------------------------------
|
|
|
*/
myTheme.ScrollToFix = 	function () {
		$('.furno-navigation').scrollToFixed({
			bottom: 0,
			top: 1000,
			limit: $('.furno-navigation').offset().top
		});

};

/*
|--------------------------------------------------------------------------
| Functions Initializers
|--------------------------------------------------------------------------
|
|
|
*/
	
	myTheme.Isotope();
	myTheme.Fancybox();
	
	// The "lazyLazy" instance of lazyload is used
	var lazyLazy = new LazyLoad({
	    // When the .horzContainer div enters the viewport...
	   callback_load: function(el) {
	   		myTheme.Isotope();
			myTheme.Fancybox();
	   }
	});


	$win.load(function(){
		$('.isotopeFilters').find('li a').removeClass('non-clickable');
	});

});
