$(document).ready(function () {
$('.multiple-buttons-media .tab:first-child').addClass('btn-orange');
$('.multiple-buttons-media .tab:first-child').removeClass('btn-white');
var divid = $('.multiple-buttons-media .tab:first-child').attr('href');
$('.media-content').hide();
$('#'+divid).show();
});
$('.multiple-buttons-media .tab').on("click", function (e) {
e.preventDefault();
    $('.multiple-buttons-media .tab').addClass('btn-white');
    $('.multiple-buttons-media .tab').removeClass('btn-orange');
    $(this).addClass('btn-orange');
    $(this).removeClass('btn-white');
    var divid = $(this).attr('href');
    $('.media-content').hide();
    $('#'+divid).show();
});