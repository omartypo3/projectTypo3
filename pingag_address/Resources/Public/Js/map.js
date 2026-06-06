function filterList($items, serviceId, kantonesId, adrId, angeboteId, lebensalterId) {

    $items.hide();

    var caseAddress = false;

    if (serviceId != 0) {
        $items.each(function (i, element) {
            var $adresIds = $(element).attr('id').split(',');

            if (serviceId !== false) {
                var $services = $(element).attr('data-services').split(',');

                if(adrId){
                    if ($.inArray(serviceId, $services) > -1 && $.inArray(adrId, $adresIds) > -1) {

                        $(element).attr("fadein", "true");

                        caseAddress = true;
                    }
                }
            }
        });
    }

    if (!caseAddress) {
        $items.each(function (i, element) {
            $(element).attr("fadein", "true");
        });
    }

    if (serviceId != 0 && serviceId != undefined) {
        $items.each(function (i, element) {
            var $services = $(element).attr('data-services').split(',');

            if ($.inArray(serviceId, $services) == -1) {
                if($(element).is("[fadein]")) {
                    $(element).removeAttr("fadein");
                }
            }
        });
    }

    if (kantonesId != 0 && kantonesId != undefined) {
        const regionSelected = getSelectedValOption($('#kantonecategory'));
        const regionMatches = [];
        const kantoneMatches = [];
    
        /*$items.each(function (i, element) {
            var $kantones = $(element).attr('data-kantones').split(',');
            var $regions = $(element).attr('data-regions');


          
            const shouldShow =
            $regions === regionSelected ||
            $kantones.includes(kantonesId);

            if (!shouldShow){
                if($(element).is("[fadein]")) {
                    $(element).removeAttr("fadein");
                }
            }
           
        });*/

        $items.each(function () {
            const $el = $(this);
            const kantones = $el.attr('data-kantones')?.split(',') || [];
            const region = $el.attr('data-regions');
            const id = $el.attr('id') || '';

            // reset
            $el.removeAttr('fadein');

            if (region === regionSelected) {
                regionMatches.push($el);
            } else if (kantones.includes(String(kantonesId))) {
                /*if (id.startsWith('adrw')) {
                    // 🔥 put adrw items at the beginning
                    kantoneMatches.unshift($el);
                }else {
                    kantoneMatches.push($el);
                }*/
                kantoneMatches.push($el);
            }
        });

        // container holding .location elements
        const $container = $items.parent();

        // 🔥 clear & re-append in correct order
        $container.append(regionMatches);
        $container.append(kantoneMatches);

        // show them
        [...regionMatches, ...kantoneMatches].forEach($el => {
            $el.attr('fadein', true);
        });

        
        
    }

    if (angeboteId != 0 && angeboteId != undefined) {
        $items.each(function (i, element) {
            var $angebotes = $(element).attr('data-angebote').split(',');

            if ($.inArray(angeboteId, $angebotes) == -1) {
                if($(element).is("[fadein]")) {
                    $(element).removeAttr("fadein");
                }
            }
        });
    }

    if (lebensalterId != 0 && lebensalterId != undefined) {
        $items.each(function (i, element) {
            var $lebensalters = $(element).attr('data-lebensalter').split(',');

            if ($.inArray(lebensalterId, $lebensalters) == -1) {
                if($(element).is("[fadein]")) {
                    $(element).removeAttr("fadein");
                }
            }
        });
    }

    var counter = 0;

    $items.each(function (i, element) {
        if( $(element).is("[fadein]") ) {
            $(element).fadeIn();
            $(element).removeAttr("fadein");
            counter++;

            var cssClass = (counter % 2 === 0) ? 'even' : 'odd';
            $(element).removeClass('even odd');
            $(element).addClass(cssClass);
        }
    });

    $('.counter-only-number').text(counter);

}



function getSelectedVal($select) {
    return $select.find('option:checked').val();
}

function getSelectedValOption($select) {
    return $select.find('option:checked').data('title');
}

function getSelected($select) {
    return $select.find('option:checked');
}

function updateVisibleMarkers() {
    var markerIds = [];
    $resultList.find('.location:visible').each(function (i, item) {
        markerIds.push($(item).data('uid'));
    });
    updateMarkers(markerIds);
}

function arrayUnique(a) {
    var temp = {};
    for (var i = 0; i < a.length; i++)
        temp[a[i]] = true;
    var r = [];
    for (var k in temp)
        r.push(k);
    return r;
}


var markerArray = [];
var $resultList = $('#locations');
var $results = $('#locations .location');
var $service = $('#category');
var $kantones = $('#kantonecategory');
var $angebotes = $('#angebote');
var $lebensalters = $('#lebensalter');

$(window).load(function () {

    if (typeof google == 'undefined') {
        setTimeout(buildMarkers, 500);
    } else {
        buildMarkers();
    }
    $('#category,#kantonecategory,#angebote,#lebensalter').on('change', function (e) {

        $('#locations.digitalmap').removeClass("hide-on-start");

        $resultList.show();

        var serviceId = false;
        if ($service.length) {
            serviceId = getSelectedVal($service);
        }

        filterList($results, serviceId, getSelectedVal($kantones),0 ,getSelectedVal($angebotes),getSelectedVal($lebensalters));
        updateVisibleMarkers();

    });





});

$(document).ready(function () {

    var url = location.href;
    var urlsplit = url.split("kontaktid=");
    var urlsplitAddr = url.split("&adr");
    if(urlsplit || urlsplitAddr){
        if( urlsplit[1]) {
            var removechash = urlsplit[1].split("&");
            $('#category').val(removechash[0]);
            filterList($results, removechash[0], getSelectedVal($kantones),0 ,getSelectedVal($angebotes),getSelectedVal($lebensalters));
        }
        if(urlsplitAddr[1]){
            var split = 'adr'+urlsplitAddr[1];
            filterList($results, removechash[0], getSelectedVal($kantones),split,getSelectedVal($angebotes),getSelectedVal($lebensalters));
        }
    }else{

        var $category = $('#category option:checked');
        if ($category.length && $category.val() != 0) {
            $('.intro-text').hide();
            $resultList.show();
            //filterList($results, getSelectedVal($service), getSelectedVal($kantones));
            filterList($results, getSelectedVal($service), getSelectedVal($kantones),'',getSelectedVal($angebotes),getSelectedVal($lebensalters));
        }
    }

});



