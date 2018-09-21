$( window ).load(function() {
    $(".news .row div.article").each(function(i) {
        $(this).removeClass('removearticle').addClass('showarticle');
    });
});
$( document ).ready(function() {
	/*Filter dropdown month*/
	$(".news select")
	  .change(function () {
	  	var valmonth,valyear;
		 $("select.filtermonth option:selected").each(function() {
                valmonth = $( this ).val();
            });
            $("select.getall_years option:selected").each(function() {
                valyear= $( this ).val();
            });
            search(valmonth,valyear);
	  })
	  .change();
	 function search(selectmonth,selectyear){
		$(".news .row div.article").each(function(i) {
			var articlemonth = $(this).data("month");
			var articleyear = $(this).data("year");
			if(selectmonth == articlemonth && selectyear == articleyear){
				$(this).removeClass('removearticle').addClass('showarticle');
			}else{
				$(this).removeClass('showarticle').addClass('removearticle');
			}
		});
	 }
});
