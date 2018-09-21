

$('#BewSelect').on('change', function()
{
    //alert($('#BewSelect').val());
    if($('#BewSelect').val()=="sonstiges"){
$('#hidden').show();
    }else{
        $('#hidden').hide();
    }
});