//Définition des options (ordre d'apparition et préfixe pour aller chercher les images)
/*$.fn.socialSharePrivacy.settings.order = ['facebook', 'twitter', 'mail'];
$.fn.socialSharePrivacy.settings.path_prefix = document.location.origin+'/typo3conf/ext/e_magineurs/Resources/Public/Plaine/';*/

jQuery(document).ready(function ($) {

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();


    $(".socialNetwork ul li").hover(function () { // Mouse over
        $(this).siblings('li').find('a').stop().fadeTo(300, 0.2);
        $(this).parent().siblings('li').find('a').stop().fadeTo(300, 0.3);
    }, function () { // Mouse out
        $(this).siblings('li').find('a').stop().fadeTo(300, 1);
        $(this).parent().siblings('li').find('a').stop().fadeTo(300, 1);
    });

    $(".downloadApplication ul li").hover(function () { // Mouse over
        $(this).siblings('li').stop().fadeTo(300, 0.2);
        $(this).parent().siblings('li').stop().fadeTo(300, 0.3);
    }, function () { // Mouse out
        $(this).siblings('li').stop().fadeTo(300, 1);
        $(this).parent().siblings('li').stop().fadeTo(300, 1);
    });

    $("#footer .socialNetwork ul li").hover(function () { // Mouse over
        $(this).siblings('li').stop().fadeTo(300, 0.2);
        $(this).parent().siblings('li').stop().fadeTo(300, 0.3);
    }, function () { // Mouse out
        $(this).siblings('li').stop().fadeTo(300, 1);
        $(this).parent().siblings('li').stop().fadeTo(300, 1);
    });

    $("#hautDePage").click(function () {
        $("html, body").animate({scrollTop: 0}, "slow");
    });

    /**********RECHERCHE***********/
    $("#search-icon").click(function () {
        $(this).toggleClass("active");
        $('#recherche-header').toggleClass("active");
        if ($('#recherche-header').hasClass('active')) {
            $(this).find('i').removeClass('icon-Search').addClass('icon-Close');
            $('#overlay-header').fadeIn(250);
            $('#recherche-header').slideDown(250);
            $('.menu-header-right li').css('opacity', '0.1');
            $('.menu-header-right li:last').css('opacity', '1');
            $('#searchform').focus();
        } else {
            $(this).find('i').removeClass('icon-Close').addClass('icon-Search');
            $('#overlay-header').fadeOut(250);
            $('#recherche-header').slideUp(250);
            $('.menu-header-right li').css('opacity', '1');
        }
    });

    $('.frame-default a[href*="#"]').click(function () {
        var the_id = $(this).attr("href");
        var the_id = the_id.substring(the_id.indexOf('#') + 1);
        var coordonnees = $('#' + the_id).offset().top;
        coordonnees = coordonnees - 100;
        $('html, body').animate({
            scrollTop: coordonnees
        }, 'slow');
        return false;
    });


    $('.powermail_fieldwrap_votresignalementconcernemontrerchamps .radio:nth-last-child(2) .powermail_radio').on('change', function () {
        $('.powermail_fieldwrap_siautreprecisezchampacacher ').show();
    });

    // NEWSLETTER POPUP

    const $newsletterPopup = $('.newsletter-popup');
    const $body = $('body');

    if ($newsletterPopup.length > 0) {
        if (!localStorage.getItem('newsletterPopup')) {
            $newsletterPopup.addClass('is-open');
            $body.addClass('is-overflow-hidden');
        }
    }

    $newsletterPopup.find('.newsletter-popup__close').on('click', function() {
        $newsletterPopup.removeClass('is-open');
        $body.removeClass('is-overflow-hidden');
        localStorage.setItem('newsletterPopup', 'true');
    });

    $('.js-form').on('submit', function(e) {
        e.preventDefault();

        localStorage.setItem('newsletterPopup', 'true');

        var form = this;

        setTimeout(function() {
            $body.removeClass('is-overflow-hidden');
            form.submit();
        }, 100);
    });

});

$(".btnShare").click(function (e) {
    $(this).parent(".tools").next().toggleClass("visible");
});

//Email webPage
function emailCurrentPage() {
    window.location.href = "mailto:?subject=" + document.title + "&body=" + escape(window.location.href);
}

//Partage social
var titre = $('title').text();
var description = $('meta[name=description]').attr("content");
var keywords = $('meta[name=keywords]').attr("content");

function shareFacebook() {
    window.open("https://www.facebook.com/sharer/sharer.php?u=" + escape(window.location.href), '',
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
}

function shareTwitter() {
    window.open("https://twitter.com/intent/tweet?&url=" + escape(window.location.href) + "&text=" + titre, '',
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
}

function shareGoogle() {
    window.open("https://plus.google.com/share?url=" + window.location.href, '',
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
}

function shareLinkedin() {
    var link = "https://www.linkedin.com/shareArticle?mini=true&url=" + window.location.href + "&title=" + document.title + "&summary=" + description;
    link = encodeURI(link);
    window.open(link, '',
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
}

function sharePinterest() {
    window.open("https://www.pinterest.com/pin/create/button/?url=" + window.location.href + "&description=" + description, '',
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
}

//Iframe mobile change height
function changeIframe(selector) {
    const elements = [...document.querySelectorAll(selector)];

    if (elements.length) {
        elements.forEach((el) => {
            const heightMobileValue = el.getAttribute('data-mob-height');
            const heightTabletValue = el.getAttribute('data-tablet-height');

            if (heightTabletValue && window.innerWidth <= 1024 && window.innerWidth >= 768) {
                el.style.height = heightTabletValue + 'px';
            } else if (heightMobileValue && window.innerWidth <= 767) {
                el.style.height = heightMobileValue + 'px';
            } else {
                el.style.height = '';
            }
        });
    }
}

window.addEventListener("resize", () => changeIframe('iframe'));


//Konami Code ! Have Fun !
function activateCheats() {
    //$('*').css({"color": "#ffa1c2"});
    $('#header').css({"backgroundColor": "#ffa1c2"});

    $("img").each(function () {
        $(this).css({"opacity": "0"});
        $(this).parent().css({"background": "url('https://img00.deviantart.net/bf96/i/2017/111/f/c/crazy_unicorn_wallpaper_by_sophingers-d80p09f.jpg') no-repeat center"});
        $(this).parent().css({"background-size": "cover"});
    });

    $("video").each(function () {
        $(this).find('source').attr("src", "https://media.tenor.com/videos/790f796c7ad835b081ae1ae2c84f5de4/mp4");
    });

    gris_fonce = "rgb(38, 38, 38)";
    gris_clair = "rgb(51, 51, 51)";
    color_gris_font = "rgb(54, 54, 54)";
    color_vert = "rgb(125, 185, 0)";
    test2 = $('#header').css('backgroundColor');


    $("*").each(function () {
        color = $(this).css('color');
        bg = $(this).css('backgroundColor');
        if (color == color_gris_font) {
            $(this).css({"color": "#ffa1c2"});
        }
        if (color == color_vert) {
            $(this).css({"color": "#ffa1c2"});
        }
        if (bg == gris_fonce) {
            $(this).css({"backgroundColor": "#ffa1c2"});
        }
        if (bg == gris_clair) {
            $(this).css({"backgroundColor": "#ffa1c2"});
        }
    });
}

$('.searchAuto').keyup(function () {
    var searchedText = removeAccents($('.searchAuto').val().toLowerCase());
    //Pour chaque élément de la liste
    $(".list_street").each(function () {
        //Si le text entré est contenu dans l'élément on l'affiche, sinon on le masque
        if (removeAccents($(this).html().toLowerCase()).includes(searchedText)) {
            $(this).removeAttr('hidden');
        } else {
            $(this).attr('hidden', 'true');
        }
    });
});

//https://gist.github.com/alisterlf/3490957
function removeAccents(strAccents) {
    var strAccents = strAccents.split('');
    var strAccentsOut = new Array();
    var strAccentsLen = strAccents.length;
    var accents = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
    var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
    for (var y = 0; y < strAccentsLen; y++) {
        if (accents.indexOf(strAccents[y]) != -1) {
            strAccentsOut[y] = accentsOut.substr(accents.indexOf(strAccents[y]), 1);
        } else
            strAccentsOut[y] = strAccents[y];
    }
    strAccentsOut = strAccentsOut.join('');
    return strAccentsOut;
}


// datepicker
$.datepicker.setDefaults(
    {
        altField: "#datepicker",
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        dayNamesShort: ['Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
        dateFormat: 'dd/mm/yy',
        firstDay: 1
    }
);
if (document.getElementById("powermail_field_jourduconstat")) {
    $("#powermail_field_jourduconstat").datepicker({
        changeMonth: true,//this option for allowing user to select month
        changeYear: true, //this option for allowing user to select from year range
        yearRange: "c-110:c+10",
        maxDate: 0
    });
} else {
    $(".powermail_date").datepicker({
        changeMonth: true,//this option for allowing user to select month
        changeYear: true, //this option for allowing user to select from year range
        yearRange: "c-110:c+10",
    });
}

// Tables inside ce-textpic
const bodyTextItem = $('.ce-bodytext');
bodyTextItem.has('table').parent('.ce-textpic').addClass('-with-table');

bodyTextItem.each(function () {
    if ($(this).find('.text-center').length > 1) {
        $(this).addClass('-is-flex-row');
    }
    ;
})


//MAP carte du territoire

function isFE() {
    return window.location.href.indexOf('integration-migration') !== -1 || window.location.href.indexOf('localhost') !== -1;
};

if ($('#Map').length > 0) {

    function change_image(c) {
        if (isFE()) {
            $('#Map').attr('src', '/fileadmin/emagineurs/' + c + '.png');
        } else {
            $('#Map').attr('src', '/fileadmin/emagineurs/' + c + '.png');
        }
    }

    function hide_image() {
        if (isFE()) {
            $('#Map').attr('src', '/fileadmin/emagineurs/carto.png');
        } else {
            $('#Map').attr('src', '/fileadmin/emagineurs/carto.png');
        }
    }

    jQuery(document).ready(function ($) {
        $('img[usemap]').rwdImageMaps();
    });

}

// map for page-content ticket #270367

function hexToRgb(hex) {
    hex = hex.replace(/^#/, '');

    if (hex.length === 3) {
        hex = hex.split('').map(hexChar => hexChar + hexChar).join('');
    }

    const bigint = parseInt(hex, 16);
    const r = (bigint >> 16) & 255;
    const g = (bigint >> 8) & 255;
    const b = bigint & 255;

    return { r, g, b };
}

function getRelativeLuminance({ r, g, b }) {
    const RsRGB = r / 255;
    const GsRGB = g / 255;
    const BsRGB = b / 255;

    const R = RsRGB <= 0.03928 ? RsRGB / 12.92 : ((RsRGB + 0.055) / 1.055) ** 2.4;
    const G = GsRGB <= 0.03928 ? GsRGB / 12.92 : ((GsRGB + 0.055) / 1.055) ** 2.4;
    const B = BsRGB <= 0.03928 ? BsRGB / 12.92 : ((BsRGB + 0.055) / 1.055) ** 2.4;

    return 0.2126 * R + 0.7152 * G + 0.0722 * B;
}

function getContrastRatio(luminance1, luminance2) {
    const [lighter, darker] = [luminance1, luminance2].sort((a, b) => b - a);
    return (lighter + 0.05) / (darker + 0.05);
}

function getTextColor(backgroundColorHex) {
    const rgb = hexToRgb(backgroundColorHex);
    const bgLuminance = getRelativeLuminance(rgb);

    const blackLuminance = 0;
    const whiteLuminance = 1;

    const contrastWithBlack = getContrastRatio(bgLuminance, blackLuminance);
    const contrastWithWhite = getContrastRatio(bgLuminance, whiteLuminance);

    return contrastWithBlack >= contrastWithWhite ? '#000' : '#fff';
}

function centerMapAtMarkerWithOffset(map, markerCoords, zoomLevel = 0, paddingBottom = 0) {
    const mapSize = map.getSize();
    const offset = L.point(0, (mapSize.y / 2) - paddingBottom);
    const targetPoint = map.project(markerCoords, zoomLevel).subtract(offset);
    const targetLatLng = map.unproject(targetPoint, zoomLevel);
    map.setView(targetLatLng, zoomLevel);
}

const getMarkerSvg = (color) => `<svg xmlns="http://www.w3.org/2000/svg" width="42.472" height="54.625" viewBox="0 0 42.472 54.625" fill="${color}" stroke="${color}"><defs><radialGradient id="radial-gradient" cx="0.5" cy="0.5" r="0.5" gradientUnits="objectBoundingBox"><stop offset="0"/><stop offset="0.594" stop-opacity="0.341"/><stop offset="0.807" stop-opacity="0.129"/><stop offset="1" stop-opacity="0"/></radialGradient></defs><g transform="translate(1.869 0.5)"><g transform="translate(1.131 43.446)"><ellipse cx="18.236" cy="3.839" rx="18.236" ry="3.839" transform="translate(-0.001 0)" opacity="0.5" fill="url(#radial-gradient)" stroke="none"/><ellipse cx="5.759" cy="1.44" rx="5.759" ry="1.44" transform="translate(12.476 1.919)" opacity="0.5" fill="url(#radial-gradient)" stroke="none"/></g><g><path d="M118.881,223.591A19.315,19.315,0,1,0,90.9,240.85c3.616,2.064,6.03,4.876,8.668,9.272,2.631-4.385,5.027-7.2,8.637-9.256A19.312,19.312,0,0,0,118.881,223.591Z" transform="translate(-80.25 -204.275)" stroke="none" opacity="0.3"/><path d="M118.881,223.591A19.315,19.315,0,1,0,90.9,240.85c3.616,2.064,6.03,4.876,8.668,9.272,2.631-4.385,5.027-7.2,8.637-9.256A19.312,19.312,0,0,0,118.881,223.591Z" fill="none" transform="translate(-80.25 -204.275)" stroke-width="1"/><ellipse cx="14.293" cy="14.293" rx="14.293" ry="14.293" transform="translate(5.058 5.167)" stroke="none" stroke-miterlimit="10" stroke-width="1"/></g></g></svg>`;

document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('map');
    if (!mapElement) return;

    const img = new Image();
    img.src = mapElement.getAttribute('data-image');

    if (!img.src) return;

    const calculateMinZoom = ((imgWidth, imgHeight) => {
        const { offsetWidth, offsetHeight } = mapElement;
        const xRatio = offsetWidth / imgWidth;
        const yRatio = offsetHeight / imgHeight;

        return Math.max(xRatio, yRatio);
    });

    const initMap = () => {
        const { naturalWidth, naturalHeight } = img;
        const bounds = [[0,0], [naturalHeight, naturalWidth]];
        const minZoom = Math.log2(calculateMinZoom(naturalWidth, naturalHeight));

        const map = L.map('map', {
            crs: L.CRS.Simple,
            zoomControl: false,
            minZoom,
            maxZoom: minZoom + 5,
            detectRetina: true,
            maxBounds: bounds,
        });

        L.imageOverlay(img.src, bounds).addTo(map);
        map.fitBounds(bounds);

        const popup = L.popup({
            minWidth: 330,
            autoClose: false,
            closeOnClick: false,
        });

        popup.on('remove', (e) => {
            map.fitBounds(bounds);
            map.setMaxBounds(bounds);
        });

        const markerElements = document.querySelectorAll('#markers div');
        markerElements.forEach(element => {
            const coords = JSON.parse(element.getAttribute('data-coords'));
            const color = element.getAttribute('data-color');
            const tooltipContent = element.getAttribute('data-tooltip');
            const popupId = element.getAttribute('data-popup-id');
            const label = element.getAttribute('data-label');

            const icon = L.divIcon({
                className: 'marker-label',
                html: `
                    <div class="marker-label__wrapper">
                        ${getMarkerSvg(color)}
                        <div class="marker-label__label" style="background-color: ${color}; color: ${getTextColor(color)};">${label}</div>
                    </div>
                `,
                iconSize: [42, 54],
                iconAnchor: [21, 45],
            });

            const marker = L.marker(coords, { icon }).addTo(map);

            // Add tooltip with direction and offset
            marker.bindTooltip(tooltipContent, {
                direction: 'auto', // You can change this to 'bottom', 'left', 'right', 'center', 'auto'
                offset: L.point(20, -26), // Adjusts the tooltip position relative to the marker
                permanent: false, // If you want the tooltip to be always visible, set to true
                sticky: false, // If true, the tooltip will follow the mouse cursor
            });

            marker.on('click', function () {
                currentView = map.getBounds();
                map.setMaxBounds(null);

                const popupContent = document.getElementById(popupId).innerHTML;
                popup
                    .setLatLng(coords)
                    .setContent(popupContent)
                    .openOn(map);

                centerMapAtMarkerWithOffset(map, coords, 0, 40);
            });
        });
    }

    img.onload = initMap;
});

const swiper = new Swiper('.js-swiper-coverflow', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    simulateTouch: false,
    coverflowEffect: {
        rotate: 0,
        stretch: 80,
        depth: 303,
        modifier: 1,
        slideShadows: false,
    },
    pagination: {},
    navigation: {
        nextEl: '.editions-slider__control.is-next',
        prevEl: '.editions-slider__control.is-prev',
    },
    breakpoints: {
        320: {
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 0,
            },
        },
        768: {
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 0,
            },
        },
        1280: {
            coverflowEffect: {
                rotate: 0,
                stretch: 80,
                depth: 303,
                modifier: 1,
                slideShadows: false,
            },
        },
    },
});
