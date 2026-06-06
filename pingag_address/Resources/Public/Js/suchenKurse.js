$(window).load(function() {
    if( $('form.registration #situation2').is(':checked') || $('form.registration #situation3').is(':checked') ) {
        $('.event-registration .event-registration-row.personaldata').show();
    } else {
        $('.event-registration .event-registration-row.personaldata').hide();
    }

    if( sessionStorage.getItem("personalDataChecked") == "true" ) {
        $('form.registration #personal').click();
    }
});


$(document).ready(function () {
    $('#suchen').on('click', function () {
        var art = $('#art').val();
        var zielgruppe = $('#zielgruppe').val();
        var kursthemen = $('#kursthemen').val();
        var sprache = $('#sprache').val();
        var $results = $('#accordionGroup .event-list-item');
        filterListKurse($results, art, zielgruppe, kursthemen, sprache);
        var count = $(".filterkurse .event-list-item").length;
        var invasible = $(".filterkurse .event-list-item:hidden").length;
        if (count == invasible) {
            $(".filterkurse .notFound").show();
        } else {
            $(".filterkurse .notFound").hide();
        }
        console.log(count);
        console.log(invasible);
    });

    $('input[name="tx_sfeventmgt_pieventregistration[registration][situation]"]').click(function(){
        if( $(this).val() == 's' ) {
            $('.event-registration .event-registration-row.personaldata').hide();
        } else {
            $('.event-registration .event-registration-row.personaldata').show();
        }
    });

    $('form.registration #personal').click(function(){
        if( $(this).is(':checked') ) {
            sessionStorage.setItem("personalDataChecked", "true");
        } else {
            sessionStorage.setItem("personalDataChecked", "false");
        } 
    });

    /*$('form.registration input[type="submit"]').on('submit', function(e){
        e.preventDefault();
        return false;
    });*/

    /*if ($('.tx-sf-event-mgt form input[name="tx_sfeventmgt_pieventregistration[registration][situation]"]:checked').val() == 's') {
        $(".personaldata ").hide();
        $("#personal").removeAttr("required");
        $(".personaldata .event-required").html("");
        $("#personal").removeAttr("aria-describedby");
    } else {
        $(".personaldata").show();
        $("#personal").attr("required", "true");
        $("#personal").attr("aria-describedby", "field-errors-registration.personal");
        $(".personaldata .event-required").html("*");
    }


    $('.tx-sf-event-mgt form input').on('change', function () {
        if ($('.tx-sf-event-mgt form input[name="tx_sfeventmgt_pieventregistration[registration][situation]"]:checked').val() == 's') {
            $(".personaldata ").hide();
            $("#personal").removeAttr("required");
            $("#personal").removeAttr("aria-describedby");
            $(".personaldata .event-required").html("");
        } else {
            $(".personaldata").show();
            $("#personal").attr("required", "true");
            $("#personal").attr("aria-describedby", "field-errors-registration.personal");
            $(".personaldata .event-required").html("*");
        }
    });*/

});

$(window).load(function () {
    /*if ($('.tx-sf-event-mgt form input[name="tx_sfeventmgt_pieventregistration[registration][situation]"]:checked').val() == 's') {
        $(".personaldata ").hide();
        $("#personal").removeAttr("required");
        $(".personaldata .event-required").html("");
        $("#personal").removeAttr("aria-describedby");
    } else {
        $(".personaldata").show();
        $("#personal").attr("required", "true");
        $(".personaldata .event-required").html("*");
        $("#personal").attr("aria-describedby", "field-errors-registration.personal");
    }

    if(location.search.indexOf("tx_sfeventmgt_pieventregistration") == 1) {

        if ($('.tx-sf-event-mgt form input[name="tx_sfeventmgt_pieventregistration[personaldata]"]:checked').val() == undefined) {
            if ($('html').attr('lang') == 'de-de') {
                $("<div class='field-errors' id='field-errors-registration.personal'><span class='error'>Der angegebene Wert ist leer.</span></div>").insertAfter(".personaldata label");
            }
            if ($('html').attr('lang') == 'fr-FR') {
                $("<div class='field-errors' id='field-errors-registration.personal'><span class='error'>La valeur spécifiée est vide.</span></div>").insertAfter(".personaldata label");
            }

        }
    }
        */

});


function filterListKurse($items, artID, zielgruppeID, kursthemenID, spracheID) {
    if (artID != 0) {
        $items.hide();
        $items.each(function (i, element) {
            if ($(element).attr('data-art') || $(element).attr('data-zielgruppe') || $(element).attr('data-kursthemen') || $(element).attr('data-sprache')) {
                var $arts = $(element).attr('data-art').replace(/ /g, '').split(',');
                var $zielgruppes = $(element).attr('data-zielgruppe').replace(/ /g, '').split(',');
                var $kursthemens = $(element).attr('data-kursthemen').replace(/ /g, '').split(',');
                var spraches = $(element).attr('data-sprache').replace(/ /g, '').split(',');
                if (artID != 0 && zielgruppeID == 0 && kursthemenID == 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1) {
                        $(element).fadeIn();
                    }
                }
                else if (artID != 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID == 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }
                else if (artID != 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }

                else if (artID != 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }
            }
        });
    } else if (zielgruppeID != 0) {
        $items.hide();

        $items.each(function (i, element) {
            if ($(element).attr('data-art') || $(element).attr('data-zielgruppe') || $(element).attr('data-kursthemen') || $(element).attr('data-sprache')) {

                var $arts = $(element).attr('data-art').replace(/ /g, '').split(',');
                var $zielgruppes = $(element).attr('data-zielgruppe').replace(/ /g, '').split(',');
                var $kursthemens = $(element).attr('data-kursthemen').replace(/ /g, '').split(',');
                var spraches = $(element).attr('data-sprache').replace(/ /g, '').split(',');
                if (artID == 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID == 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1) {
                        $(element).fadeIn();
                    }
                }
                else if (artID != 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }
                else if (artID != 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }

                else if (artID != 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }
            }
        });
    } else if (kursthemenID != 0) {
        $items.hide();

        $items.each(function (i, element) {
            if ($(element).attr('data-art') || $(element).attr('data-zielgruppe') || $(element).attr('data-kursthemen') || $(element).attr('data-sprache')) {

                var $arts = $(element).attr('data-art').replace(/ /g, '').split(',');
                var $zielgruppes = $(element).attr('data-zielgruppe').replace(/ /g, '').split(',');
                var $kursthemens = $(element).attr('data-kursthemen').replace(/ /g, '').split(',');
                var spraches = $(element).attr('data-sprache').replace(/ /g, '').split(',');
                if (artID == 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                }
                else if (artID != 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID == 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }
            }
        });
    } else if (spracheID != 0) {
        $items.hide();

        $items.each(function (i, element) {
            if ($(element).attr('data-art') || $(element).attr('data-zielgruppe') || $(element).attr('data-kursthemen') || $(element).attr('data-sprache')) {

                var $arts = $(element).attr('data-art').replace(/ /g, '').split(',');
                var $zielgruppes = $(element).attr('data-zielgruppe').replace(/ /g, '').split(',');
                var $kursthemens = $(element).attr('data-kursthemen').replace(/ /g, '').split(',');
                var spraches = $(element).attr('data-sprache').replace(/ /g, '').split(',');
                if (artID == 0 && zielgruppeID == 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }
                else if (artID != 0 && zielgruppeID == 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID != 0 && kursthemenID == 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID == 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID == 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                } else if (artID != 0 && zielgruppeID != 0 && kursthemenID != 0 && spracheID != 0) {
                    if ($.inArray(artID, $arts) > -1 && $.inArray(zielgruppeID, $zielgruppes) > -1 && $.inArray(kursthemenID, $kursthemens) > -1 && $.inArray(spracheID, spraches) > -1) {
                        $(element).fadeIn();
                    }
                }
            }
        });
    } else {
        $items.show();

    }
}
