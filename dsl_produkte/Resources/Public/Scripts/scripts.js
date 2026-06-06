// JavaScript Document

	function initAjaxFields(){
		$('.filter_selector').change(function() {
			$('.filter_sortierung_selector_bottom').val($('.filter_sortierung_selector').val());
			$('.filter_perpage_selector_bottom').val($('.filter_perpage_selector').val());
			$('#form_filter').submit();
		});
		$('.filter_selector_bottom').change(function() {
			$('.filter_sortierung_selector').val($('.filter_sortierung_selector_bottom').val());
			$('.filter_perpage_selector').val($('.filter_perpage_selector_bottom').val());
			$('#form_filter').submit();
		});
		
		
		
		$('.paginate_ajax').click(function() {
			return doAjax($(this).attr('href'),false);
		});
		
		
		
		initAjaxFillPage();
		
		window.onpopstate =  function(event) {
			if(document.location.href != window.location.href) window.location.href = document.location.href;
		}
		
		/* Initialisierung Idealforms für selectbox der sortierung */
		/*$('form.idealforms').idealforms(  );*/
		

	}
	
	
	/*beim klicken in einer gruppe wird geprüft dass immer ein eintrag aktiv sein muß*/
	function checkFilterNotEmpty(selector){
		setFilterResetBtn();
		$('#form_filter').submit();
		return true;
	}
	
	function setFilterResetBtn(){
		
		$(".filter_label").prev('input').next(".filter_label").removeClass('active');
		$(".filter_label").prev('input:checked').next(".filter_label").addClass('active');
		
		
		if($('.filter_alle:checked').length > 0 ) {
			$('.filter_reset_outer').show(); 
		} else {
			$('.filter_reset_outer').hide();

		}
	}
	
	/*vorm absenden wird geprüft ob mindestens eine filteroption entfernt wurde um dem reload der seite mitzuteilen ob gefiltert werden muss*/
	function checkFilterSubmit(){

		
		$('.filter_sortierung').val($('.filter_sortierung_selector').val());
		$('.filter_perpage').val($('.filter_perpage_selector').val());

		
		return doAjax(false,$('#form_filter').serialize());

	}
	
	var zaehlerAjaxCache=0;
	function doAjax(urlString,form){
		
		zaehlerAjaxCache++;
		
		if($('.noAjax:checked').length) return true;
		
		if(urlString || form){
			
			if(ajaxRequest){
				ajaxRequest.abort();
			} 
			
			$('.ajax_loading').css('display','block');
			
//			$('.ajax_loading').show(500);
			$('.produkte_content').fadeTo( 'slow' , 0.6, function() {
				// Animation complete.
			});

			//console.log('function dojax()2');
			if(urlString){
				//console.log('function dojax()2.1');
				
				ajaxRequest = $.ajax({
					url: urlString,
					cache: false,
					type: "GET",
					success: function(data) {
						
						finishAjaxRequest(data);
					}
				});
			}
			if(form){
				
				console.log('formsubmit');
				//var stringTest = ajaxRequestUrl; 
//				console.log(ajaxRequestUrl.replace("&cHash", "zaehler"+zaehlerAjaxCache+"&cHash"));
				//console.log(stringTest.replace("&cHash", "abc&cHash"));
				//stringTest.replace("&cHash", "abc&cHash"); 
				//console.log(stringTest);
				var ajaxRequestUrlInc =  ajaxRequestUrl.replace("zaehlerajaxcache", "zaehler"+zaehlerAjaxCache+"&cHash");
				console.log(ajaxRequestUrlInc);
				ajaxRequest = $.ajax({
					url: ajaxRequestUrl,
					cache: false,
					data: form,
					type: "POST",
					success: function(data) {
						finishAjaxRequest(data);
					}
				});
				
				
			}	
			
			return false;
		
		}
		
		
		
	}

	
	function finishAjaxRequest(data){
		
//		console.log('ajaxfinished');
		ajaxRequest = false;
		$( ".produkte_content" ).html( $(data).find('.produkte_content').html() );
//		console.log('pushUri'+$(data).find('.pushUri').val());
		window.history.pushState({},'', $(data).find('.pushUri').val() );
		initAjaxFields();
//		$('.ajax_loading').hide(500);
$('.ajax_loading').css('display','none');		
		$('.produkte_content').fadeTo( 'slow' , 1, function() {
			// Animation complete.
		});
			
		
	}
	
	
	function ajaxFillMoreLinkCheckScrolling(){
		if($('#ajaxFillMoreLink').length){
	  
			var scroll = $(window).scrollTop();
			var offsetAjaxFillBtn = $('#ajaxFillMoreLink').offset();
			var windowHeight = $(window).height();
			var visibleFromTop = windowHeight+$(window).scrollTop();
			/*$('nav').html( 'ajaxFillMoreLink.scrollTop():'+offsetAjaxFillBtn.top 
			+' // window.scrolltop: '+$(window).scrollTop()+ ' // Windows Height '+windowHeight+ ' // gesamt: '+visibleFromTop+' // '+visibleFromTop+' > '+offsetAjaxFillBtn.top+''
			);*/
			if(visibleFromTop > offsetAjaxFillBtn.top){ //sobald der btn in den sichtbaren bereich rutscht
				$('#ajaxFillMoreLink').click();
			}
			
		}
	}		
	
	var ajaxFillPageArr = [];
	var ajaxFillPageIndex = 0;
	var ajaxFillLoading = false;
	
	function initAjaxFillPage(){
		
	
		if($('.ajaxFillPaginator ul.f3-widget-paginator li a').length){
			
//			console.log('length:'+$('.ajaxFillPaginator ul.f3-widget-paginator li a').length);
			
			var currentPage = $('.ajaxFillPaginator ul.f3-widget-paginator li.current span').text();
			
			ajaxFillPageArr = [];
			ajaxFillPageIndex = 0;	
			
			//#produkte_pagebrowser_ajax>ul>li:not(.current) a
			var zaehler=0;
			$('.ajaxFillPaginator ul.f3-widget-paginator li a').each(function(key,value) {
				
				if($(value).text()>currentPage){
					
					ajaxFillPageArr[zaehler] = $(value).attr('href');
					zaehler++;
				}
			});
			
			if(zaehler) {
			
		//		alert(ajaxFillPageArr);
				$('#ajaxFillMoreLinkWrapper').remove();
				
				$("<div />", {
					id : "ajaxFillMoreLinkWrapper",
					class : ""
				}).insertAfter('.produkte_content');//#productList
				
			
				
				$('#ajaxFillMoreLinkWrapper').html(
					$("<a />", {
						id : "ajaxFillMoreLink",
						class : "button",
						html : '<span class="text"><span class="lang_de">Produkte werden geladen</span><span class="lang_en">Loading, please wait...</span></span><span class="btnBefore"></span><span class="btnAfter"></span>'
					})
				);
				
				
				$('#ajaxFillMoreLink').click(function() {
					if(ajaxFillLoading) return false;
					
					ajaxFillLoading = true;
					$('#ajaxFillMoreLink').addClass("loading");
				
					$.get( ajaxFillPageArr[ajaxFillPageIndex], function( data ) {
	//	alert(ajaxFillPageArr[ajaxFillPageIndex]);
						var $newItems = $( $(data).find('#productList').html() );
						//$('#newsIsotope').isotope( 'insert', $newItems );
		//				alert($newItems);
						$( "#productList" ).append( $newItems );
						
		
						ajaxFillLoading = false;
						$('#ajaxFillMoreLink').removeClass("loading");
		
						ajaxFillPageIndex++;
					
						if(!ajaxFillPageArr[ajaxFillPageIndex]) $('#ajaxFillMoreLinkWrapper').remove();
		
					});
					
				
				});
								

				
				$(window).scroll(function() {  
					ajaxFillMoreLinkCheckScrolling();
				});
				ajaxFillMoreLinkCheckScrolling();
			}
		
		} else {
			$('#ajaxFillMoreLinkWrapper').remove();
		}
		
		
	}
		