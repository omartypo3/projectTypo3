$(document).ready(function () {

    //// LIST VIEW ////
    var $realEstateView = $('.real-estate-list-wrap');
    var isLoading = false;

    function submitFilter(event) {
        if (isLoading) {
            return false;
        }
        isLoading = true;
        $realEstateView.addClass('loading');

        var $filter = $realEstateView.find('.real-estate-filter form');
        var url = $filter.attr('action');
        var viewSelector = '.real-estate-list-wrap';

        saveFilterState($filter);

        $.post(url, $filter.serialize(), function (response) {
            var $newList = $(response).find(viewSelector);
            $(viewSelector).html($newList.html());
            setupListView();
            $realEstateView.removeClass('loading');
            isLoading = false;
            autocompleteLocations("0");

        });

    }

    function saveFilterState($filter) {
        var formFields = {};
        $filter.find('[name^="tx_pingagrealestate_list[filter]"]').each(function (i, field) {
            var fieldName = $(field).attr('name').replace('tx_pingagrealestate_list[filter][', '');
            fieldName = fieldName.replace(']', '');

            console.log(fieldName, $(this));
            if (fieldName.indexOf('[]')) {
                fieldName = fieldName.replace('[]', '');
                if (!formFields[fieldName]) {
                    formFields[fieldName] = [];
                }
                if($(field).is(':checked')){
                    formFields[fieldName].push({property: $(field).val()});
                }
            } else {
                formFields[fieldName] = $(field).val();
            }
        });
        var formFieldsString = JSON.stringify(formFields);


        $.removeCookie('realEstateFilterState');
        $.cookie('realEstateFilterState', formFieldsString, {expires: 1, path: '/'});
    }

    function setupListView() {
        $('.lazyload[data-src]').Lazy();

        // range slider
        $(".range-slider").each(function (i, slider) {
            var $minField = $(slider).find('.range-slider-min'),
                $maxField = $(slider).find('.range-slider-max'),
                min = $(slider).data('min'),
                max = $(slider).data('max'),
                step = $(slider).data('step');

            if (typeof step === 'undefined') {
                step = 1;
            }

            function setHandleValues($slider) {
                var values = $slider.slider("values");
                $slider.find('.min .value').text(values[0].toLocaleString('de-CH'));
                $slider.find('.max .value').text(values[1].toLocaleString('de-CH'));
            }

            $(slider).slider({
                range: true,
                min: min,
                max: max,
                values: [$minField.val(), $maxField.val()],
                step: step,
                change: function (event, ui) {
                    $minField.val(ui.values[0]);
                    $maxField.val(ui.values[1]);
                    setHandleValues($(this));
                    submitFilter();
                },
				slide: function(event,ui){
					 $(this).find('.min .value').text(ui.values[0].toLocaleString('de-CH'));
					 $(this).find('.max .value').text(ui.values[1].toLocaleString('de-CH'));  
				},
                create: function () {
                    setHandleValues($(this));
                }
            });
        });

        // checkbox
        $(".checkbox-outter input[type=checkbox]").each(function () {
            var b = $(this);
            b.addClass("checkbox"), $('<span class="checkbox"></span>').insertAfter(b), b.is(":checked") && b.next("span.checkbox").addClass("on"), b.fadeTo(0, 0), b.change(function () {
                b.next("span.checkbox").toggleClass("on")
            });
        });

        //
        $('.range-slider .value').each(function (index, element) {
            var breite = $(this).width() / 2;
            $(this).css('left', -breite + 3);
        });
    }

    setupListView();

    $realEstateView.on('click', '.offer-type-select .option', function () {
        var value = $(this).data('value');
        $(this).parent().find('input').val(value);

        $('.offer-type-select .option.active').removeClass('active');
        $(this).addClass('active');
        submitFilter();
    });

    $realEstateView.on('click', '.extended-block .toggle', function () {
        $realEstateView.find('.extended-block').toggleClass('in');
        var showExtendedState = ($('#showExtendedState').val() == 1) ? 0 : 1;
        $('#showExtendedState').val(showExtendedState);
    });

   // $realEstateView.on('blur', 'input', submitFilter);
   // $realEstateView.on('change', 'select, .searchTerm, input.checkbox', submitFilter);
    $realEstateView.on('click', '.submit', submitFilter);
/*
    $realEstateView.on('input', '.searchTerm', function (e) {
        var searchString = $(this).val();

      //  var locations = geoinfo.searchLocations(searchString);
       // console.log(locations);




    });
*/
    $('.tab-nav a').on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('href'),
            $tab = $(target);

        $('.tab-nav a').not(this).removeClass('active');
        $(this).addClass('active');

        $('.tabs .tab').not($tab).removeClass('in');
        $tab.addClass('in');
    });

    function setupRadioButtons() {
        $("input[type=radio]").each(function () {
            var b = $(this);
            b.addClass("radiobutton"), $('<span class="radiobutton"></span>').insertAfter(b), b.is(":checked") && b.next("span.radiobutton").addClass("on"), b.fadeTo(0, 0), b.change(function () {
                $("span.radiobutton").removeClass("on"), b.next("span.radiobutton").addClass("on")
            })
        })
    }

    $.ajaxSetup({
        beforeSend: function (request) {
            request.setRequestHeader("HTTP_X_REQUESTED_WITH", 'xmlhttprequest');
        },
    });

    $('.real-estate-contact-wrap').on('submit', '.contact-form', function (e) {
        e.preventDefault();
        var $form = $(this);
        var $wrap = $form.parents('.real-estate-contact-wrap');
        $.post($form.attr('action'), $form.serialize(), function (response) {
            $wrap.html($(response).find('.real-estate-contact-wrap').html());
            setupRadioButtons();
        });
    });
});

$(window).load(function () {
	//// SHOW VIEW ////
    $('.image-slider').slick({
        adaptiveHeight: true,
    });
});

// google maps
function initRealEstateMap() {
    var address = $('#real-estate-map').data('address');

    var map = new google.maps.Map(document.getElementById('real-estate-map'), {
        center: {lat: 47.311501, lng: 8.8137018},
        zoom: 11,
        disableDefaultUI: true,
        zoomControl: true
    });
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({'address': address}, function (results, status) {
        if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            map.setZoom(14);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        } else {
            console.warn('Geocode was not successful for the following reason: ' + status);
        }
    });
}


