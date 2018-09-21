$(document).ready(function () {
    /*
     Can explicitly limit the services shown (https://www.addthis.com/services/list)
     However, if the user has an AddThis account, these can be overwritten :(
     */

    var next = 1;

    $(window).scroll(function () {
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
            var controllerpath = $("#uri_hidden").val();
            var allData = {
                'tx_dld_dldfront[names]': $('#names').val(),
                'tx_dld_dldfront[lastnames]': $('#lastnames').val(),
                'tx_dld_dldfront[company]': $('#company').val(),
                'tx_dld_dldfront[selectevent]': $('#selectevent').val(),
                'tx_dld_dldfront[offset]': (next)
            };
        $(".loading").show();
            $.ajax({
                type: "POST",
                url: controllerpath,
                data: allData,
                success: function (data) {

                    $(".loading").hide();
                    $('#speaker-list-new').append($(data).find('.speaker-item'));
                    next++;
                }
            });
        }
    });

    $(".saerching").click(function (e) {
        loadAjaxData();
        next = 1;
    });

    $("#selectevent").change(function () {
        loadAjaxData();
        next = 1;
    });

    $("#lastnames, #names, #company").on("keydown", function (event) {
        if (event.which == 13) {
            loadAjaxData();
            next = 1;
        }
    });

    $("#clear-filters").click(function () {
        $(".speakerlist")[0].reset();
        loadAjaxData();
        next = 1;
    });

    var addthis_config =
        {
            services_compact: "twitter,favorites"
        };
    //search bar handler
    $('#search-button').click(function () {
        var searchContainer = $('.search-container');
        var headerWrapper = $('.header-wrapper');

        if (searchContainer.hasClass('visible')) {
            if ($(window).width() > 360) {
                searchContainer.animate({top: -headerWrapper.height()}, "ease-in-out").promise().done(function () {
                    searchContainer.removeClass('visible');
                    $('#search-button').addClass('icon-search').removeClass('icon-close');
                });
            } else {
                searchContainer.animate({top: -75}, "ease-in-out").promise().done(function () {
                    searchContainer.removeClass('visible');
                    $('#search-button').addClass('icon-search').removeClass('icon-close');
                });
            }

        } else {
            searchContainer.animate({top: headerWrapper.height()}, "ease-in-out").promise().done(function () {
                searchContainer.addClass('visible');
                $('#search-button').removeClass('icon-search').addClass('icon-close');
            });
        }
    });

    //side-menu-trigger
    $('#side-menu-button').click(function () {

        if ($('#side-menu').hasClass('moving')) {
            return;
        }

        var isSideMenuOpened = $('#side-menu').hasClass('opened');
        var distance = $('#side-menu').outerWidth();
        var direction = isSideMenuOpened ? 1 : -1;
        var previousState = isSideMenuOpened ? 'opened' : 'closed';
        var transtionToState = isSideMenuOpened ? 'closed' : 'opened';
        var previousSideMenuButtonIcon = isSideMenuOpened ? 'icon-close' : 'icon-menu';
        var sideMenuButtonIcon = isSideMenuOpened ? 'icon-menu' : 'icon-close';

        $('#side-menu').addClass('moving');
        $('.side-menu-movable').animate({
            marginLeft: '+=' + distance * direction,
            marginRight: '+=' + distance * direction * (-1)
        }, 300, function () {
            $('#side-menu').removeClass('moving');
            $('#side-menu').removeClass(previousState);
            $('#side-menu').addClass(transtionToState);
            $('#side-menu-button').removeClass(previousSideMenuButtonIcon);
            $('#side-menu-button').addClass(sideMenuButtonIcon);
        });

    });


    //main big slider
    if ($('.main-big-slider').length) {
        $('.main-big-slider').slick({
            infinite: true,
            speed: 500,
            centerMode: true,
            variableWidth: true,
            cssEase: 'linear',
            focusOnSelect: false,
            accessibility: false
        });

        $('.main-big-slider .item.primary').each(function (i, el) {
            $(this).find('.secondary-small-slider').flickity({
                contain: true,
                pageDots: false,
                freeScroll: true,
                cellAlign: 'center'
            });

            $(this).find('.secondary-small-slider').on('mousedown touchstart', '.item', function (e) {
                e.stopPropagation();
                e.preventDefault();
            });

        })
    }


    //partners
    var partnersSlider = $('.partners-slider');
    if (partnersSlider.length) {
        if (partnersSlider.find('.item').length <= 6 && $(window).width() > 768) {
            // if (false){

            partnersSlider.addClass('no-slider');

            var centeredItem = Math.round(partnersSlider.find('.item').length / 2);
            partnersSlider.find('.item:nth-child(' + centeredItem + ')').addClass('is-selected');
            showPartnerDescription();

            partnersSlider.find('.item').click(function () {
                partnersSlider.find('.item').removeClass('is-selected');
                $(this).addClass('is-selected');
                showPartnerDescription();
            });

        } else {

            partnersSlider.flickity({
                autoPlay: true,
                wrapAround: true,
                pageDots: false,
                cellAlign: 'center',
                prevNextButtons: false
            });

            partnersSlider.on('scroll.flickity', function (event, progress) {
                showPartnerDescription();
            });

            partnersSlider.on('staticClick.flickity', function (event, pointer, cellElement, cellIndex) {
                if (!cellElement) {
                    return;
                }

                partnersSlider.flickity('select', cellIndex)
            })
        }
    }

    function showPartnerDescription() {
        var activePartnerLogo = partnersSlider.find('.item.is-selected');
        var activePartnerId = activePartnerLogo.find('.circle').attr('data-text-id');
        var activePartnerText = $('.partners-row .circle, .partners-description .text');
        activePartnerText.removeClass('active');
        $('.partners-description #' + activePartnerId).addClass('active');
    }

    //location
    function initMap() {
        var mapElem = $('#dld-map');
        var lat = mapElem.attr('lat');
        var long = mapElem.attr('long');
        var markerImg = mapElem.attr('marker-image');
        var zoom = parseInt(mapElem.attr('zoom'));
        var mapProp = {
            center: new google.maps.LatLng(lat, long),
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        };

        var styles = [{
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#d3d3d3"}]
        }, {
            "featureType": "transit",
            "stylers": [{"color": "#808080"}, {"visibility": "off"}]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{"visibility": "on"}, {"color": "#b3b3b3"}]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#ffffff"}]
        }, {
            "featureType": "road.local",
            "elementType": "geometry.fill",
            "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"weight": 1.8}]
        }, {
            "featureType": "road.local",
            "elementType": "geometry.stroke",
            "stylers": [{"color": "#d7d7d7"}]
        }, {
            "featureType": "poi",
            "elementType": "geometry.fill",
            "stylers": [{"visibility": "on"}, {"color": "#ebebeb"}]
        }, {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [{"color": "#a7a7a7"}]
        }, {
            "featureType": "road.arterial",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#ffffff"}]
        }, {
            "featureType": "road.arterial",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#ffffff"}]
        }, {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [{"visibility": "on"}, {"color": "#dadada"}]
        }, {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#696969"}]
        }, {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [{"visibility": "on"}, {"color": "#737373"}]
        }, {
            "featureType": "poi",
            "elementType": "labels.icon",
            "stylers": [{"visibility": "off"}]
        }, {
            "featureType": "poi",
            "elementType": "labels",
            "stylers": [{"visibility": "off"}]
        }, {
            "featureType": "road.arterial",
            "elementType": "geometry.stroke",
            "stylers": [{"color": "#d6d6d6"}]
        }, {
            "featureType": "road",
            "elementType": "labels.icon",
            "stylers": [{"visibility": "off"}]
        }, {
            "featureType": "poi",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#dadada"}]
        }];

        var map = new google.maps.Map(document.getElementById('dld-map'), mapProp);
        map.panBy(0, 80);
        map.setOptions({styles: styles});

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, long),
            map: map,
            icon: markerImg,
            zIndex: google.maps.Marker.MAX_ZINDEX + 1
        });


        map.addListener('dragstart', function () {
            $('.location-details').hide();
            $('#center-map').show();
        });

        $('#center-map').click(function () {
            //recenter map
            map.setCenter(new google.maps.LatLng(lat, long));
            map.setZoom(zoom);
            map.panBy(0, 80);

            $(this).hide();
            $('.location-details').show();
        });
    }


    if ($('.location-section').length) {
        google.maps.event.addDomListener(window, 'load', initMap);
    }


    if ($('.location-speakers-slider').length) {
        $('.location-speakers-slider').slick({
            variableWidth: true,
            arrows: false,
            infinite: true
        })
    }

    //events
    if ($('.events-slider').length) {
        $('.events-slider').slick({
            variableWidth: true,
            centerMode: true,
            arrows: false,
            infinite: true,
            slidesToShow: 3
        });

        $(".fancybox-media.enabled").fancybox({
            helpers: {
                media: !0
            },
            padding: 0,
            margin: [20, 60, 20, 60]
        });

        $('.fancybox-media').bind('click', function (e) {
            e.preventDefault();
        });

        // $('.item').mousedown(function(){
        //   $(this).append('<div class="stop-fancybox"></div>');
        // });
        //
        // $('.item').mouseup(function(){
        //   $(this).find('.stop-fancybox').remove();
        // });


    }

    //program
    if ($('.program-slider').length) {
        $('.program-slider').slick({
            arrows: true,
            infinite: true,
            speed: 500,
            slidesToShow: 3,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        })
    }

    //conference-slider
    if ($('.conference-slider').length) {
        $('.conference-slider').slick({
            arrows: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1
        });


        $('.conference-slider .item.primary').each(function (i, el) {
            $(this).find('.secondary-small-slider').slick({
                centerMode: true,
                arrows: true,
                infinite: true,
                slidesToShow: 7,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            centerMode: true,
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            centerMode: false,
                            slidesToShow: 2
                        }
                    }
                ]
            });

            $(this).find('.secondary-small-slider').on('mousedown touchstart', '.item', function (e) {
                e.stopPropagation();
                e.preventDefault();
            });

        })
    }

    if ($('.dld-logo').length) {
        $(window).paroller();
    }

    $(window).scroll(function () {
        if ($('.dld-logo').offset() != null) {
            console.log('offset-top: ' + $('.dld-logo').offset().top);
            console.log('wHeight: ' + parseInt($(window).height() / 2));
            if ($('.dld-logo').offset().top < parseInt($(window).height() / 2)) {
                $('.dld-logo').addClass('orange');
            } else {
                $('.dld-logo').removeClass('orange');
            }
        }

    });
    $(".tx-kesearch-pi1 .speakers").each(function () {
        if ($(this).find(".speaker").length == 0) {
            $(".titleofspeakers").hide();
            $(".speakers").removeClass("with-border");
        } else {
            $(".titleofspeakers").show();
        }
    });
    $(".tx-kesearch-pi1 .conferences-and-events").each(function () {
        if ($(this).find(".event").length == 0) {
            $(".titleofconference").hide();
            $(".conferences-and-events").removeClass("with-border");
        } else {
            $(".titleofconference").show();
        }
    });

    function clear() {
        var e = $(".all-speakers"),
            t = $(".all-speakers .speaker-item");
        e.masonry("remove", t), e.masonry("layout")
    }

    $(function () {
        $("#selectevent").change(function (e) {
            if ($("#selectevent").val() == 0) {
                $("#selectevent").removeClass("selected");
            } else {
                $("#selectevent").addClass("selected");
            }
            loadAjaxData();
            e.preventDefault();
        });
    });

    $(".links.apply-now-popup").click(function () {
        showApplicationAuthWindow();
    });

    function showApplicationAuthWindow() {
        $(".form-dialog.signin-or-signup.no-redirect").dialog({
            width: 550,
            modal: !0
        })
    }

    $(".ui-dialog-titlebar-close").click(function () {
        $(".ui-dialog-titlebar-close").addClass("bordericon");
    });
    /*type of content element incide containeur*/
    $("#content .frame-type-header").addClass("container");
    $("#content .frame-type-html").addClass("container");
    $("#content .frame-type-textmedia").addClass("container");
    $("#content .frame-type-textpic").addClass("container");
    $("#content .frame-type-text").addClass("container");
    $("#content .frame-type-image").addClass("container");
    $(".tx-femanager .femanager_show .mydld-container").last().addClass("invitedmsg");
    $(".hidedld #content  .tx-dld").last().addClass("invitedmsg");





    /*
     * Jquery Infinite Scroll

     */

    var documentLang = document.getElementsByTagName('html')[0].getAttribute('lang');
    var moreNews = "Load more »";
    if (documentLang == 'fr') {
        moreNews = "Afficher plus d'expériences";
    }
    if (documentLang == 'de') {
        moreNews = "Mehr";
    }
    $gridnewslist = $('.news-list-view.grid');
    $gridnewslist.masonry({
        itemSelector: '.box',
        columnWidth: 300,
        fitWidth: true
    });
    if ($('.news-list-view').length) {

        var ias = $.ias({
            container: '.news-list-view',
            item: '.article',
            pagination: '.page-navigation',
            next: '.next a',
            delay: 0,
        });
        //ias.masonry('reloadItems');
        ias.extension(new IASTriggerExtension({
            text: moreNews,
            html: '<div class="align-center load-more load"><a id="show-more" class="btn-big">{text}</a></div>'
        }));
        ias.extension(new IASSpinnerExtension({
            html: '<div class="ias-spinner" style="text-align: center;"><i class="fa fa-circle-o-notch fa-spin"></i></div>'
        }));


        ias.on('rendered', function (items) {
                $gridnewslist.masonry('reloadItems');
                $('.news-list-view.grid').masonry({
                    itemSelector: '.box',
                    columnWidth: 300,
                    fitWidth: true
                });

        })
    }


    var linksearch = window.location.href;
    var res = linksearch.split("tx_kesearch_pi1");
    if (res[1]) {
        var link = res[1].split("&");
        var linkfinal = link[0].split("=");
        var chaine = decodeURIComponent(linkfinal[1]);
        $("#ke_search_searchfield_sword").val(chaine);
    }
    $('.tab-swap-btn').click(function () {
        $gridnewslist = $('.news-list-view.grid');
        $gridnewslist.masonry({
            itemSelector: '.box',
            columnWidth: 300,
            fitWidth: true
        });
    });

    $('.privancy td').removeAttr('rowspan');
});
$(window).resize(function () {
    if ($(window).width() <= 1200) {
        $('#cc-notification').addClass("cc-mobile");
    }
});
$(window).on('load', function () {

    if ($(window).width() <= 1200) {
        $('#cc-notification').addClass("cc-mobile");
    }
    $(window).resize(function () {
        if ($(window).width() <= 1200) {
            $('#cc-notification').addClass("cc-mobile");
        }
    });

});

function gdbrcockie() {
    $("body").addClass("showgdbr notification");
}


function loadAjaxData() {
    var controllerpath = $("#uri_hidden").val();
    var allData = {
        'tx_dld_dldfront[names]': $('#names').val(),
        'tx_dld_dldfront[lastnames]': $('#lastnames').val(),
        'tx_dld_dldfront[company]': $('#company').val(),
        'tx_dld_dldfront[selectevent]': $('#selectevent').val()
    }
    $.ajax({
        type: 'POST',
        url: controllerpath,
        data: allData,
        success: function (html) {
            $("#speaker-list-new").html($(html).find('.speaker-item'));
            $("#speaker-list-new").each(function () {
                if ($(this).find(".speaker-item").length == 0) {
                    $("#no-speakers").show();
                } else {
                    $("#no-speakers").hide();
                }
            });
        },
    });
}