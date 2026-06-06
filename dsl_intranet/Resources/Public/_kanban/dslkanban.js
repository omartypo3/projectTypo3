

function setMaxKanbanHeight(){
	/*jQuery( '.kanban-container .kanban-board' ).each(function( index ) {

	});*/
	var kanbanHeight = jQuery('.kanbanContent').height()-170;
	jQuery('.kanban-drag').css('max-height',kanbanHeight+'px');
}
$( window ).resize(function() {
	setMaxKanbanHeight();
});

/*
function bla() {
console.log('bla wurde aufgerufen');
setTimeout(bla, 3000);
}
setTimeout(bla, 3000);
console.log('hinter setTimeout');
*/
var scrollTimeoutX = false;
var scrollCont;
var scrollDirection;
var scrollAktiv = false;

function scrollContainerStart(cont,direction){
	scrollCont = cont;
	scrollDirection = direction;
	scrollAktiv = true;
	scrollTimeoutX = setTimeout(scrollContainer, 200);

}
function scrollContainer(){
	if(scrollAktiv == true){
		if(scrollDirection=='top') scrollCont.scrollTop( scrollCont.scrollTop()-40 );
		if(scrollDirection=='bottom') scrollCont.scrollTop( scrollCont.scrollTop()+40 );
		scrollTimeoutX = setTimeout(scrollContainer, 500);
	}
}

function scrollContainerStop(){
	scrollAktiv = false;
	if(scrollTimeoutX) clearTimeout(scrollTimeoutX);
}


//https://github.com/riktar/jkanban
//https://codepen.io/riktar/pen/KqZpgL
//var kanbanDsl;
    function reInitKanban(){
        if(kanbanDsl) kanbanDsl = false;
        jQuery('#myKanban').children().remove();
		initKanban();
		reInitAjaxCalls();//zur initialisierung der links zum auftrag
		setMaxKanbanHeight();
		showKanban();
		
	}
	function setKanbanBoardCounter(){

		jQuery('.kanban-board').each(function( index ) {
			var anzahl = jQuery('.kanban-item',this).length;
			if(anzahl) {
				jQuery('.kanban-title-board-counter',this).text(' - '+jQuery('.kanban-item',this).length);
			} else {
				jQuery('.kanban-title-board-counter',this).text('');
			}
		});
		
	}
	function showKanban(){
		setKanbanBoardCounter();
		$('.kanbanContent').removeClass('contentReloads');
	}
	function reInitKanbanBtn(){

/*
		jQuery('.kanban-item-show-auftrag').off("click");
		jQuery('.kanban-item-show-auftrag').on( "click", function() {
			$('.kanbanWrapper').removeClass('kanbanActive');
		});
		*/
		

		jQuery('.kanban-board[data-id="_projekte"] button.kanban-title-button').remove();

		jQuery('button.kanban-title-button').off("click");
		jQuery('button.kanban-title-button').html('<i class="bb-trashcan bb-lg" aria-hidden="true"></i>');

		jQuery('button.kanban-title-button').on( "click", function() {
			boardId =  jQuery( this ).closest('.kanban-board').attr('data-id');

			var items = [];
			jQuery.each( kanbanDsl.getBoardElements(boardId), function( index, value ){
				items.push(jQuery(value).attr('data-eid'));
			});
			for (i = 0; i < items.length; i++) {
				kanbanDsl.addForm('_projekte',kanbanDsl.findElement(items[i]));
			}

			kanbanDsl.removeBoard(boardId);
			deleteKanbanBoard(boardId);

		});
		jQuery('.kanban-board[data-id!="_projekte"] .kanban-title-board').on( "click", function() {
			boardId =  jQuery( this ).closest('.kanban-board').attr('data-id');
			var newTitle = prompt("Name der Liste", jQuery(this).text());
			if (newTitle!=jQuery(this).text()) if(newTitle != null) if(newTitle != ""){
				console.log('titel ändern!!');
				jQuery(this).text(newTitle);
				renameKanbanBoard(boardId,newTitle);
			}

		});

/*
		jQuery('header.kanban-board-header').on( "dragover", function() {
			console.log('mouseover / dragover');
		});
*/
		

	}
	function initKanban(){
		
		kanbanDsl = new jKanban({
			element : '#myKanban',
			gutter  : '10px',
			addItemButton    : true,        
			buttonContent:'x',
			click : function(el){
			/*	console.log(el.innerHTML);
				console.log(el.dataset.eid)*/
			},
			dragendBoard : function (el) {
		/*		console.log('dragendBoard');
				console.log(el);*/
				var boards = new Object();
				jQuery( '.kanban-container .kanban-board' ).each(function( index ) {
				/*	console.log(this);
					console.log(jQuery(this).attr('data-id'));
					console.log(jQuery(this).attr('data-order'));
*/
					boards[jQuery(this).attr('data-id')] = jQuery(this).attr('data-order');
				});


				$('.kanbanContent').addClass('contentReloads');
				$.post({
					url: splitpaneAjaxUrl,
					data: {"tx_dslintranet_splitpaneprojekte[switch]":'reorderKanbanBoards',"tx_dslintranet_splitpaneprojekte[boards]":boards},
					cache: false,
					success:function (data) {
						console.log('sucess');
					}
				}).done(function( data ) {
				//	console.log('done');
					//var changeBoardJson = JSON.parse($(data).find('textarea#resultJson').val());
					jQuery('#debugcontent').html($(data).find('#content').html());
					//console.log(changeBoardJson);

					showKanban();
				});


				//console.log(boards);
			},  
			dragEl : function (el, source) {
			/*	console.log('dragEl');
				console.log(el);
				console.log(source);*/
			},  
			dragendEl : function (el) {
			/*	console.log('dragendEl');
				console.log(el);*/
				scrollContainerStop();
			},
			dropEl : function (el, target, source, sibling) {
				
			/*	console.log('dropEl');
				console.log(jQuery(el).attr('data-eid'));*/
				
			/*	if(source!=target){
					console.log('von: '+jQuery(source).closest('.kanban-board').attr('data-id'));
					console.log('nach: '+jQuery(target).closest('.kanban-board').attr('data-id'));
				} else { 
					console.log('innerhalb: '+jQuery(target).closest('.kanban-board').attr('data-id'));
				}*/

				var boards = new Object();

				if(source){
					var sourceBoard = jQuery(source).closest('.kanban-board').attr('data-id');
					boards[sourceBoard] = [];
					jQuery.each( kanbanDsl.getBoardElements(sourceBoard), function( index, value ){
						boards[sourceBoard].push(jQuery(value).first().attr('data-eid'));
					});
				}
				if(target) if(target!=source){
					var targetBoard = jQuery(target).closest('.kanban-board').attr('data-id');
					boards[targetBoard] = [];
					jQuery.each( kanbanDsl.getBoardElements(targetBoard), function( index, value ){
						boards[targetBoard].push(jQuery(value).first().attr('data-eid'));
					});
				}
				

				$('.kanbanContent').addClass('contentReloads');
				$.post({
					url: splitpaneAjaxUrl,
					data: {"tx_dslintranet_splitpaneprojekte[switch]":'changeKanbanBoards',"tx_dslintranet_splitpaneprojekte[boards]":boards},
					cache: false,
					success:function (data) {
						console.log('sucess');
					}
				}).done(function( data ) {
					//console.log('done');
					var changeBoardJson = JSON.parse($(data).find('textarea#resultJson').val());
					jQuery('#debugcontent').html($(data).find('#content').html());
					//console.log(changeBoardJson);

					showKanban();
				});
/*
				$.post( "test.php", { name: "John", time: "2pm" })
				.done(function( data ) {
					alert( "Data Loaded: " + data );
				});
*/

/*
				console.log('boards:');
				console.log(boards);
				console.log(jQuery(boards).serialize());

				console.log(el);
				console.log(target);
				console.log(source);
				console.log(sibling);
*/
				/*$('.kanbanContent').addClass('contentReloads');
					dslIntranetAjaxCall(splitpaneAjaxUrl,{"tx_dslintranet_splitpaneprojekte[switch]":'renameKanbanBoard',"tx_dslintranet_splitpaneprojekte[boardId]":boardId,"tx_dslintranet_splitpaneprojekte[title]":title}).done(function (data) {
						
						
						
							
					//	console.log(data);
						var updateBoardJson = JSON.parse($(data).find('textarea#resultJson').val());

						jQuery('#debugcontent').html($(data).find('#content').html());

						
						console.log(updateBoardJson);

						if(updateBoardJson){
							console.log('updateBoardJson');
							
						}

						showKanban();
							
					});
				*/

				//return false;
			},
            boards  : dataKanbanJson.boards
			/*boards  :[
                
				{
					'id' : '_projekte',
					'title'  : 'Projekte',
					'class' : 'info',
					'item'  : [
						{
						'id':'task-1',
							'title':'Try drag me',
						},
						{
						'id':'task-2',
							'title':'Click me!!',
						}
					]
                },
                {
					'id' : '_todo',
					'title'  : 'Aufgabenliste',
					'class' : 'info',
					'item'  : [
						{
						'id':'task-3',
							'title':'Tr11y drag me',
						},
						{
						'id':'task-4',
							'title':'11Click me!!',
						}
					]
				},
				{
					'id' : '_working',
					'title'  : 'Working',
					'class' : 'warning',
					'item'  : [
						{
							'title':'Do Something!',
						},
						{
							'title':'Run?',
						}
					]
				},
				{
					'id' : '_done',
					'dragTo' : ['_working'],
					'title'  : 'Done (Drag only in Working)',
					'class' : 'success',
					'item'  : [
						{
							'title':'All right',
						},
						{
							'title':'Ok!',
						}
					]
				}
			]*/
		});

		var toDoButton = document.getElementById('addToDo');
		toDoButton.addEventListener('click',function(){
			kanbanDsl.addElement(
				'_projekte',
				{
					'id':'aufgabe-1',
					'title':'Test Add',
					'type':'auftrag'
				}
			);
		});

		var addBoardDefault = document.getElementById('addDefault');
		addBoardDefault.addEventListener('click', function () {
			kanbanDsl.addBoards(
				[{
					'id' : '_default',
					'title'  : 'Default (Can\'t drop in Done)',
					'dragTo':['_todo','_working'],
					'class' : 'error',
					'item'  : [
						{
							'title':'Default Item',
						},
						{
							'title':'Default Item 2',
						},
						{
							'title':'Default Item 3',
						}
					]
				}]
			)
		});

		var removeBoard = document.getElementById('removeBoard');
		removeBoard.addEventListener('click',function(){
			kanbanDsl.removeBoard('_done');
		});

		reInitKanbanBtn();

	}
	
    function toggleKanban(){
		$('.kanbanWrapper').toggleClass('kanbanActive');
		
		if($('.kanbanWrapper').hasClass('kanbanActive')){
			console.log('kanban aktiv!load/refresh kanban');
			console.log(splitpaneAjaxUrl);
			//load/refresh kanban
			refreshKanban();
	
		} else {
			console.log('kanban inaktiv!');
		}
	}



	function refreshKanban(){
		$('.kanbanContent').addClass('contentReloads');
		loadKanban();
		
	}
	function loadKanban(){
		dslIntranetAjaxCall(splitpaneAjaxUrl,{"tx_dslintranet_splitpaneprojekte[switch]":'loadKanban'}).done(function (data) {
            

			dataKanbanJson = JSON.parse($(data).find('textarea#resultJson').val());
			console.log(dataKanbanJson);
			jQuery('#debugcontent').html($(data).find('#content').html());
			reInitKanban();
			
			showKanban();

		});
	}

	function newKanbanBoard(){
	
		var title = prompt("Name der neuen Liste", "");
		if (title != null) if (title != '') {

			$('.kanbanContent').addClass('contentReloads');
			dslIntranetAjaxCall(splitpaneAjaxUrl,{"tx_dslintranet_splitpaneprojekte[switch]":'newKanbanBoard',"tx_dslintranet_splitpaneprojekte[title]":title}).done(function (data) {
			
				
            
				
				var newBoardJson = JSON.parse($(data).find('textarea#resultJson').val())
				console.log(newBoardJson);
				jQuery('#debugcontent').html($(data).find('#content').html());

				if(newBoardJson){
					kanbanDsl.addBoards(
						[newBoardJson]
					)
					reInitKanbanBtn();
				}

				showKanban();
				
			});

		}
	}

	function renameKanbanBoard(boardId,title){
	
	//	title=title+'HA';

		$('.kanbanContent').addClass('contentReloads');
		dslIntranetAjaxCall(splitpaneAjaxUrl,{"tx_dslintranet_splitpaneprojekte[switch]":'renameKanbanBoard',"tx_dslintranet_splitpaneprojekte[boardId]":boardId,"tx_dslintranet_splitpaneprojekte[title]":title}).done(function (data) {
			
			
            
				
		//	console.log(data);
			var updateBoardJson = JSON.parse($(data).find('textarea#resultJson').val());

			jQuery('#debugcontent').html($(data).find('#content').html());

			
			console.log(updateBoardJson);

			if(updateBoardJson){
				console.log('updateBoardJson');
				/*kanbanDsl.addBoards(
					[newBoardJson]
				)
				reInitKanbanBtn();*/
			}

			showKanban();
				
		});

		
	}

	function deleteKanbanBoard(boardId){
	
		
		console.log('deleteKanbanBoard('+boardId+')');
		$('.kanbanContent').addClass('contentReloads');
		dslIntranetAjaxCall(splitpaneAjaxUrl,{"tx_dslintranet_splitpaneprojekte[switch]":'deleteKanbanBoard',"tx_dslintranet_splitpaneprojekte[boardId]":boardId}).done(function (data) {
			
			
            
			console.log(data);
			var updateBoardJson = JSON.parse($(data).find('textarea#resultJson').val());
			jQuery('#debugcontent').html($(data).find('#content').html());
			console.log(updateBoardJson);

			if(updateBoardJson){
				console.log('updateBoardJson');
				/*kanbanDsl.addBoards(
					[newBoardJson]
				)
				reInitKanbanBtn();*/
			}

			showKanban();
				
		});

		
	}