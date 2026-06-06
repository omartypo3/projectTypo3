//Définition des options (ordre d'apparition et préfixe pour aller chercher les images)
$.fn.socialSharePrivacy.settings.order = ['facebook', 'twitter', 'gplus', 'mail'];
$.fn.socialSharePrivacy.settings.path_prefix = document.location.origin + '../';

(function($) {
	// Ouverture des images en lightbox
	$("[data-fancybox], .fancybox").fancybox({
		// Options will go here
	});
	// Social Share Privacy
	$('.socialShare').socialSharePrivacy({
		//Stockage en local des activations par défaut
		perma_option: true,
		set_perma_option: function (service_name) {
			localStorage.setItem('socialSharePrivacy_'+service_name, 'perma_on');
		},
		del_perma_option: function (service_name) {
			localStorage.removeItem('socialSharePrivacy_'+service_name);
		},
		get_perma_options: null,
		get_perma_option: function (service_name) {
			return localStorage.getItem('socialSharePrivacy_'+service_name) === 'perma_on';
		}
	});
	$('#menuSite .niveau1 > a').click(function(e){
		e.preventDefault();
		if($(this).parent().hasClass('active')){
			$('#menuSite .niveau1').removeClass('active');
		}
		else{
			$('#menuSite .niveau1').removeClass('active');
			$(this).parent().toggleClass('active');
			$([document.documentElement, document.body]).animate({
	        scrollTop: $(this).parent().offset().top}, 500);
		}
		
	})
	// Effet transprance label
	labelForm(".searchForm");

	$(".powermailDatepicker").datepicker({
		changeMonth: true,//this option for allowing user to select month
		changeYear: true, //this option for allowing user to select from year range
		dateFormat: "dd/mm/yy"
	});
	$("#news-maximumDate").datepicker({
		changeMonth: true,//this option for allowing user to select month
		changeYear: true, //this option for allowing user to select from year range
		dateFormat: "dd/mm/yy"
	});
	$("#news-minimumDate").datepicker({
		changeMonth: true,//this option for allowing user to select month
		changeYear: true, //this option for allowing user to select from year range
		dateFormat: "dd/mm/yy"
	});

	// Surcharge input file
    $('.powermail_fieldwrap_type_file').children(".powermail_field").append( $('<p class="file-return"></p>') );
    $('.powermail_file ').change(function() { // au changement de l'input
        var cheminFichier = this.value; // on recupère la valeur du fichier
        var nomFichier = cheminFichier.substring(cheminFichier.lastIndexOf("\\") + 1, cheminFichier.length); // on slipt la string pour ne récupérer que le nom
        $(this).parent().find(".file-return").html(nomFichier); // on insère la valeur dans la balise p
    });

$('#btn_page_up').click(function() { // Au clic sur un élément
    speed = 400; // Durée de l'animation (en ms)
    $('html, body').animate({ scrollTop: 0}, speed, 'swing' ); // Go
    return false;
});

	$(document).ready(function() {
		if($('#tx-solr-search-functions').length){
			$('#tx-solr-search-functions').prependTo($('.content_right'));
		}
	});
	$('#navToggle').click(function(){
		$('#case_cadre_menu').toggleClass('active');
	})



})(jQuery);
//Konami Code ! Have Fun !
function activateCheats() {
    $.fancybox.open({
        width: '60%',
        type: 'iframe',
        autoPlay: true,
        src: 'https://www.youtube.com/watch?v=u5Ho1trvlro?autoplay=1'
    });
}
