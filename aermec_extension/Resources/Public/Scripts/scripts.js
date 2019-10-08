$( document ).ready(function() {
	$('.navi1 > li:nth-child(2)').after($('.aermec_item_menu').html());
	$('.mob.header > .navcontent > nav >  ul > li:nth-child(2)').after($('.aermec_item_menu').html());
	
	
	$('.aermec_item_menu').html('');


	if($(".aermec_item_show").length){
		$("#content").append($(".aermec_item_show").html());
		$(".aermec_item_show").html('');
	}
	
	
	$(".tx-aermec-extension").hide();

	
	
	
	
});