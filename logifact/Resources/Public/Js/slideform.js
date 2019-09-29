function open_panel()
{
slideIt();
var a=document.getElementById("sidebar");
a.setAttribute("id","sidebar1");
a.setAttribute("onclick","close_panel()");
}

function slideIt()
{
	var slidingDiv = document.getElementById("slider_contact");
	var stopPosition = -1;
	
	if (parseInt(slidingDiv.style.right) < stopPosition )
	{
		slidingDiv.style.right = parseInt(slidingDiv.style.right) + 9 + "px";
		setTimeout(slideIt, 1);	
	}
}
	
function close_panel(){
slideIn();
a=document.getElementById("sidebar1");
a.setAttribute("id","sidebar");
a.setAttribute("onclick","open_panel()");
}

function slideIn()
{
	var slidingDiv = document.getElementById("slider_contact");
	var stopPosition = -342;
	
	if (parseInt(slidingDiv.style.right) > stopPosition )
	{
		slidingDiv.style.right = parseInt(slidingDiv.style.right) - 9 + "px";
		setTimeout(slideIn, 1);	
	}
}

$(document).ready(function($){
	$('#slider_contact #field-2').attr('placeholder', 'Name');
	$('#slider_contact #field-3').attr('placeholder', 'Telefonnummer');
	$('#slider_contact #field-4').attr('placeholder', 'Wunschtermin (TT/MM)');
	$('#slider_contact #field-10').attr('placeholder', 'Name');
	$('#slider_contact #field-11').attr('placeholder', 'Telefonnummer');
	$('#slider_contact #field-12').attr('placeholder', 'Wunschtermin (TT/MM)');
});