/**
 * Created by sebastiankoller on 19.08.15.
 */


(function (window) {



    var Dentnet = function (options) {

        /** javascript options object parameter with defaults */
        if (typeof options == 'object') {
            $.extend(true, this.options, options);
        }

        this.initAutocomplete();
        this.initGeocodeMe();
        this.initTabber();

        this.initGoogleMaps();
        this.initBootstrapSelects();
        this.initSurgeriesFilter();

        this.initLinkRows();

        this.initGallerySlider();
        this.initLightbox();

        this.initGoogleAnalytics();
        this.initNoEmptySearch();

        this.initCountUp();
        this.initModal();
        this.setSearchModal();

    };

    var p = Dentnet.prototype;

    p.options = {
        SelectPicker: {
            dom: 'select',
            options: {
                style: 'btn dropwdown-toggle dentnet_select',
                size: false
            }
        },
        GoogleMaps: {
            dom: 'gmap_canvas',
            options: {
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControlOptions: {
                    mapTypeIds: [
                        google.maps.MapTypeId.ROADMAP,
                        'dentnet_style'
                    ]
                },
                scrollwheel: false
            },
            style: [
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#e1eac6"
                        }
                    ]
                },
                {
                    featureType: "road",
                    elementType: "labels.text.stroke",
                    stylers: [
                        {
                            visibility: "on"
                        }
                    ]
                },
                {
                    featureType: "road",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#000000"
                        }
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry",
                    stylers: [
                        {
                            visibility: "off"
                        }
                    ]
                },
                {
                    featureType: "landscape.man_made",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#ffcda2"
                        }
                    ]
                }
            ]
        },
        tabber: {
            dom: '.js_phi_tabber'
        },
        autocomplete: {
            uri: '',
            token: ''
        },
        highestSaving: 0
    };
    p.currentSelectedValue = -1;
    p.currentEntryLength = 0;


    p.initGoogleMaps = function () {
        var that = this;

                google.maps.event.addDomListenerOnce(document.getElementsByClassName('js_phi_tabber map')[0], 'click', init_map);


        function init_map() {
            var mapCanvas = document.getElementById(that.options.GoogleMaps.dom);
            var latitude = mapCanvas.getAttribute('data-latitude');
            var longitude = mapCanvas.getAttribute('data-longitude');

            if (latitude == "") {
                var origin = window.location.search.substring(1).split("&")[0].split("=")[1];
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({address: origin}, function (results, status) {
                    console.log(status);
                    if (status == google.maps.GeocoderStatus.OK) {
                        latitude = results[0].geometry.location.lat();
                        longitude = results[0].geometry.location.lng();
                    }

                    $.extend(true, that.options.GoogleMaps.options, {
                        center: new google.maps.LatLng(latitude, longitude)
                    });
                    var map = new google.maps.Map(mapCanvas, that.options.GoogleMaps.options);

                });
            } else {

                $.extend(true, that.options.GoogleMaps.options, {
                    center: new google.maps.LatLng(latitude, longitude)
                });
                var map = new google.maps.Map(mapCanvas, that.options.GoogleMaps.options);


                marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(latitude, longitude),
                    icon: "../typo3conf/ext/dentnetsearch/Resources/Public/images/map.png"

                });

                setMapStyle(map);
                setMarkersForSurgeries(map);
            }

            function setMapStyle(map) {
                var styledMapOptions = {
                    name: 'DENT-NETÂ®'
                };

                var dentnetMapType = new google.maps.StyledMapType(
                    that.options.GoogleMaps.style, styledMapOptions
                );

                map.mapTypes.set('dentnet_style', dentnetMapType);
                map.setMapTypeId('dentnet_style');
            }

            function setMarkersForSurgeries(map) {

                $('.dentnet_listview li').each(function (index, element) {
                    if ($(element).data('latitude') !== undefined) {
                        var marker = new google.maps.Marker({
                            map: map,
                            position: new google.maps.LatLng($(element).data('latitude'), $(element).data('longitude')),
                            icon: "../typo3conf/ext/dentnetsearch/Resources/Public/images/map.png"
                        });

                        google.maps.event.addListener(marker, 'click', function () {
                            window.location = $(element).data("uri");
                        });
                    }
                });
            }
        }
    };

    p.initGeocodeMe = function () {
        if (document.getElementsByClassName('dentnet_geocodeMe').length > 0) {
            document.getElementsByClassName('dentnet_geocodeMe').item(0).addEventListener('click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        window.location.href = "zahnarztsuche?coords=" + position.coords.latitude + ";" + position.coords.longitude;
                    });
                } else {
                    alert('Ihr Browser unterstÃ¼tzt keine Geolocation.');
                }

            });
        }

    };

    p.initAutocomplete = function () {
        var that = this;
        var tmpTimeout;
        var time = 500;
        var searchInput = document.getElementById('dentnetsearch');
        var typeAHead = document.getElementById('typeAhead');
        if (searchInput !== null) {

            //searchInput.focus();

            typeAHead.addEventListener('mouseover', function (e) {
                var t = e.target;
                if (t.classList.contains('city-zip')) {
                    e.preventDefault();
                    searchInput.value = t.dataset.zip + ", " + t.dataset.city;
                }
            });
            typeAHead.addEventListener('click', function (e) {
                var t = e.target;
                if (t.classList.contains('city-zip')) {
                    searchInput.value = t.dataset.zip + ", " + t.dataset.city;
                    $('#dentnetsearch').val(t.dataset.zip + ", " + t.dataset.city);
                   // window.location.href = "search?q=" + t.dataset.zip + ", " + t.dataset.city;
                    $('#form_dentnetsearch').submit();
                }
            })
            searchInput.addEventListener('keyup', function (e) {
                var keyCode = e.which || e.keyCode;

                var lis = typeAHead.getElementsByTagName('li');
                for (var n = 0; n < lis.length; n++) {
                    lis[n].classList.remove('selected');
                }

                that.currentSelectedValue = that.currentSelectedValue < 0 ? that.currentEntryLength : that.currentSelectedValue >= that.currentEntryLength ? 0 : that.currentSelectedValue;
                switch (keyCode) {
                    case 39:
                    case 38:
                        that.currentSelectedValue--;
                        try {
                            lis[that.currentSelectedValue].classList.add('selected');
                            searchInput.value = lis[that.currentSelectedValue].dataset.zip + ", " + lis[that.currentSelectedValue].dataset.city;
                        } catch (e) {

                        }
                        return;
                        break;
                    case 37:
                    case 40:
                        that.currentSelectedValue++;

                        try {
                            lis[that.currentSelectedValue].classList.add('selected');
                        } catch (e) {

                        }
                        searchInput.value = lis[that.currentSelectedValue].dataset.zip + ", " + lis[that.currentSelectedValue].dataset.city;
                        return;
                        break;
                    case 13:
                        e.preventDefault();
                        searchInput.value = lis[that.currentSelectedValue].dataset.zip + ", " + lis[that.currentSelectedValue].dataset.city;
                        break;
                }
                try {

                } catch (e) {

                }


                if (typeAHead.innerHTML === "" && searchInput.value === "" && keyCode === 13) {
                    search(searchInput.value);
                }

                typeAHead.innerHTML = "";
                clearTimeout(tmpTimeout);
                var tVal = e.target.value;
                if (tVal === '') {
                    return;
                }
                tmpTimeout = setTimeout(function () {
                    var request = new XMLHttpRequest();
                    request.open("GET", that.options.autocomplete.uri + "surgeries/autocomplete?autocomplete=" + tVal);
                    request.setRequestHeader('Content-Type', 'application/json');
                    request.setRequestHeader('Accept', 'application/json');
                    request.setRequestHeader('Authorization', 'Bearer ' + that.options.autocomplete.token);

                    request.addEventListener('load', function (event) {
                        if (request === undefined && request.response === undefined) {
                            console.error('Could not connect to dentnetsearch');
                            return;
                        }
                        switch (request.status) {
                            case 200:
                                var data = JSON.parse(request.response).data;
                                that.currentSelectedValue = -1;
                                that.currentEntryLength = data.length;
                                for (var i = 0; i < data.length; i++) {
                                    var item = data[i];
                                    typeAHead.appendChild(that.buildListElements(item, searchInput.value));
                                }
                                break;
                            case 401:
                                console.error('Could not auth with dentnetsearch - Invalid or expired token');
                                break;
                            default:
                                console.error('There is an error on dentnetsearch');
                                break;
                        }
                    });
                    request.send();

                }, time)
            });

            searchInput.addEventListener('keydown', function () {
                clearTimeout(tmpTimeout);
            });
        }

    };

    p.buildListElements = function (data, query) {

        var reg = new RegExp(query, 'gi');

        var li = document.createElement('li');
        li.classList.add('city-zip');
        li.innerHTML = data.zip + ", " + data.city;
        li.dataset.zip = data.zip;
        li.dataset.city = data.city;

        var str = li.innerHTML.replace(reg, function (str) {
            return '<b>' + str + '</b>'
        });
        li.innerHTML = str;

        return li;
    };

    p.initTabber = function () {
        var that = this;
        $(this.options.tabber.dom).on('click', function () {
            var target = $(this).attr('data-target');
            $(that.options.tabber.dom).removeClass('active');
            $(this).addClass('active');
            $('.js_phi_tab').removeClass('active');
            $('.' + target).addClass('active');
        });
        $('.advanced-open').on('click',function(){
                $('.advanced-search').slideToggle( "slow" );
        });


    };


    p.initBootstrapSelects = function () {
        $(this.options.SelectPicker.dom).selectpicker(this.options.SelectPicker.options);
    };


    p.initSurgeriesFilter = function () {
        $('.picker').on('change', function () {
            var selected = $(this).find("option:selected").val();
            var getParams = window.location.search.split("&");
            var newSearch = [];
            for (var i = 0; i < getParams.length; i++) {
                var getParam = getParams[i].split("=");
                if (getParam[0] == $(this).find("option:selected").parent().attr('name')) {
                    getParam[1] = selected;
                }
                if (getParam[0] == 'start') {
                    getParam[1] = 0;
                }
                newSearch.push(getParam.join('='));
            }
            //newSearch.pop();
            //newSearch.push(selected)

            if (!window.location.origin) {
                window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
            }

            var linkMe = window.location.origin + window.location.pathname + newSearch.join('&');
            window.location = linkMe;
        })
    };


    /**
     * make a whole row, like insurances linkable
     */
    p.initLinkRows = function () {
        $(".js_linkrow").click(function () {
            window.document.location = $(this).data("href");
        });
    }





    p.initLightbox = function () {
        $(document).delegate('*[data-toggle="lightbox"]', 'click', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox()
            $(".ekko-lightbox").bind("click", function () {
                $(this).modal("hide")

            })

        });
    };




    p.initNoEmptySearch = function () {
        if (document.querySelectorAll('.dentnet_searchform') > 0) {
            document.querySelectorAll('.dentnet_searchform')[0].addEventListener('submit', function (event) {
                if (document.getElementById("dentnetsearch").value == "") {
                    event.preventDefault();
                    document.querySelector('.dentnet_noInput').style.display = 'block';
                    return false;
                }
            });
        }
    }


    p.initModal = function () {
        if (window.location.href.indexOf('#whatsappSparCheckModal') != -1) {
            $('#whatsappSparCheckModal').modal('show');
        }
    };

    p.initCountUp = function () {
        if (document.getElementById('countUpHome')) {
            var options = {
                useEasing: true,
                useGrouping: true,
                separator: '.',
                decimal: '.',
            };
            var countUp = new CountUp("countUpHome", 0, this.options.highestSaving, 0, 4, options);
            countUp.start();
        }

    };

    p.setSearchModal = function () {
        var clickElem = document.getElementById('openModel');
        console.log(clickElem)
        clickElem.addEventListener('click', function () {
            console.log('du versuchst mich zu Ã¶ffnen!');
            $('#search-refine').modal('show')
        });
    }

    window.Dentnet = Dentnet;


    var $_GET = {};
    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
        function decode(s) {
            return decodeURIComponent(s.split("+").join(" "));
        }


        $_GET[decode(arguments[1])] = decode(arguments[2]);
    });


}(window));