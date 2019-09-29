$('.other_check input[type="text"]').attr("disabled",true);



$('.other_check input[type="checkbox"]').click(function(){
    if($(this).is(':checked')){
        console.log("checked");
        $(this).parent().parent().children('input[type="text"]').attr("disabled",false);
    }
    else{
        console.log("no checked");
        $(this).parent().parent().children('input[type="text"]').val('').attr("disabled",true);
    }
});