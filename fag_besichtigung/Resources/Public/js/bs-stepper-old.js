/*!
 * bsStepper v1.5.0 (https://github.com/Johann-S/bs-stepper)
 * Copyright 2018 - 2019 Johann-S <johann.servoire@gmail.com>
 * Licensed under MIT (https://github.com/Johann-S/bs-stepper/blob/master/LICENSE)
 */



(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
        typeof define === 'function' && define.amd ? define(factory) :
            (global = global || self, global.Stepper = factory());
}(this, function () {
    'use strict';

    function _extends() {
        _extends = Object.assign || function (target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];

                for (var key in source) {
                    if (Object.prototype.hasOwnProperty.call(source, key)) {
                        target[key] = source[key];
                    }
                }
            }

            return target;
        };

        return _extends.apply(this, arguments);
    }

    var matches = window.Element.prototype.matches;

    var closest = function closest(element, selector) {
        return element.closest(selector);
    };

    var WinEvent = function WinEvent(inType, params) {
        return new window.Event(inType, params);
    };

    var createCustomEvent = function createCustomEvent(eventName, params) {
        var cEvent = new window.CustomEvent(eventName, params);
        return cEvent;
    };

    /* istanbul ignore next */


    function polyfill() {
        if (!window.Element.prototype.matches) {
            matches = window.Element.prototype.msMatchesSelector || window.Element.prototype.webkitMatchesSelector;
        }

        if (!window.Element.prototype.closest) {
            closest = function closest(element, selector) {
                if (!document.documentElement.contains(element)) {
                    return null;
                }

                do {
                    if (matches.call(element, selector)) {
                        return element;
                    }

                    element = element.parentElement || element.parentNode;
                } while (element !== null && element.nodeType === 1);

                return null;
            };
        }

        if (!window.Event || typeof window.Event !== 'function') {
            WinEvent = function WinEvent(inType, params) {
                params = params || {};
                var e = document.createEvent('Event');
                e.initEvent(inType, Boolean(params.bubbles), Boolean(params.cancelable));
                return e;
            };
        }

        if (typeof window.CustomEvent !== 'function') {
            var originPreventDefault = window.Event.prototype.preventDefault;

            createCustomEvent = function createCustomEvent(eventName, params) {
                var evt = document.createEvent('CustomEvent');
                params = params || {
                    bubbles: false,
                    cancelable: false,
                    detail: null
                };
                evt.initCustomEvent(eventName, params.bubbles, params.cancelable, params.detail);

                evt.preventDefault = function () {
                    if (!this.cancelable) {
                        return;
                    }

                    originPreventDefault.call(this);
                    Object.defineProperty(this, 'defaultPrevented', {
                        get: function get() {
                            return true;
                        }
                    });
                };

                return evt;
            };
        }
    }

    polyfill();

    var MILLISECONDS_MULTIPLIER = 1000;
    var Selectors = {
        STEPS: '.step',
        TRIGGER: '.step-trigger',
        STEPPER: '.bs-stepper'
    };
    var ClassName = {
        ACTIVE: 'active',
        LINEAR: 'linear',
        BLOCK: 'dstepper-block',
        NONE: 'dstepper-none',
        FADE: 'fade'
    };
    var transitionEndEvent = 'transitionend';
    var customProperty = 'bsStepper';

    var show = function show(stepperNode, indexStep) {
        var stepper = stepperNode[customProperty];

        if (stepper._steps[indexStep].classList.contains(ClassName.ACTIVE) || stepper._stepsContents[indexStep].classList.contains(ClassName.ACTIVE)) {
            return;
        }

        var showEvent = createCustomEvent('show.bs-stepper', {
            cancelable: true,
            detail: {
                indexStep: indexStep
            }
        });
        stepperNode.dispatchEvent(showEvent);

        var activeStep = stepper._steps.filter(function (step) {
            return step.classList.contains(ClassName.ACTIVE);
        });

        var activeContent = stepper._stepsContents.filter(function (content) {
            return content.classList.contains(ClassName.ACTIVE);
        });

        if (showEvent.defaultPrevented) {
            return;
        }

        if (activeStep.length) {
            activeStep[0].classList.remove(ClassName.ACTIVE);
        }

        if (activeContent.length) {
            activeContent[0].classList.remove(ClassName.ACTIVE);
            activeContent[0].classList.remove(ClassName.BLOCK);
        }

        showStep(stepperNode, stepper._steps[indexStep], stepper._steps);
        showContent(stepperNode, stepper._stepsContents[indexStep], stepper._stepsContents, activeContent);
    };

    var showStep = function showStep(stepperNode, step, stepList) {
        stepList.forEach(function (step) {
            var trigger = step.querySelector(Selectors.TRIGGER);
            trigger.setAttribute('aria-selected', 'false'); // if stepper is in linear mode, set disabled attribute on the trigger

            if (stepperNode.classList.contains(ClassName.LINEAR)) {
                trigger.setAttribute('disabled', 'disabled');
            }
        });
        step.classList.add(ClassName.ACTIVE);
        var currentTrigger = step.querySelector(Selectors.TRIGGER);
        currentTrigger.setAttribute('aria-selected', 'true'); // if stepper is in linear mode, remove disabled attribute on current

        if (stepperNode.classList.contains(ClassName.LINEAR)) {
            currentTrigger.removeAttribute('disabled');
        }
    };

    var showContent = function showContent(stepperNode, content, contentList, activeContent) {
        var shownEvent = createCustomEvent('shown.bs-stepper', {
            cancelable: true,
            detail: {
                indexStep: contentList.indexOf(content)
            }
        });

        function complete() {
            content.classList.add(ClassName.BLOCK);
            content.removeEventListener(transitionEndEvent, complete);
            stepperNode.dispatchEvent(shownEvent);
        }

        if (content.classList.contains(ClassName.FADE)) {
            content.classList.remove(ClassName.NONE);
            var duration = getTransitionDurationFromElement(content);
            content.addEventListener(transitionEndEvent, complete);

            if (activeContent.length) {
                activeContent[0].classList.add(ClassName.NONE);
            }

            content.classList.add(ClassName.ACTIVE);
            emulateTransitionEnd(content, duration);
        } else {
            content.classList.add(ClassName.ACTIVE);
            stepperNode.dispatchEvent(shownEvent);
        }
    };

    var getTransitionDurationFromElement = function getTransitionDurationFromElement(element) {
        if (!element) {
            return 0;
        } // Get transition-duration of the element


        var transitionDuration = window.getComputedStyle(element).transitionDuration;
        var floatTransitionDuration = parseFloat(transitionDuration); // Return 0 if element or transition duration is not found

        if (!floatTransitionDuration) {
            return 0;
        } // If multiple durations are defined, take the first


        transitionDuration = transitionDuration.split(',')[0];
        return parseFloat(transitionDuration) * MILLISECONDS_MULTIPLIER;
    };

    var emulateTransitionEnd = function emulateTransitionEnd(element, duration) {
        var called = false;
        var durationPadding = 5;
        var emulatedDuration = duration + durationPadding;

        function listener() {
            called = true;
            element.removeEventListener(transitionEndEvent, listener);
        }

        element.addEventListener(transitionEndEvent, listener);
        window.setTimeout(function () {
            if (!called) {
                element.dispatchEvent(WinEvent(transitionEndEvent));
            }

            element.removeEventListener(transitionEndEvent, listener);
        }, emulatedDuration);
    };

    var detectAnimation = function detectAnimation(contentList, animation) {
        if (animation) {
            contentList.forEach(function (content) {
                content.classList.add(ClassName.FADE);
                content.classList.add(ClassName.NONE);
            });
        }
    };

    function clickStepLinearListener(event) {
        event.preventDefault();
    }

    function clickStepNonLinearListener(event) {
        event.preventDefault();
        var step = closest(event.target, Selectors.STEPS);
        var stepperNode = closest(step, Selectors.STEPPER);
        var stepper = stepperNode[customProperty];

        var stepIndex = stepper._steps.indexOf(step);

        stepper._currentIndex = stepIndex;
        show(stepperNode, stepIndex);
    }

    var DEFAULT_OPTIONS = {
        linear: true,
        animation: false
    };

    var Stepper =
        /*#__PURE__*/
        function () {
            function Stepper(element, _options) {
                var _this = this;

                if (_options === void 0) {
                    _options = {};
                }

                this._element = element;
                this._currentIndex = 0;
                this._stepsContents = [];
                this._steps = [].slice.call(this._element.querySelectorAll(Selectors.STEPS)).filter(function (step) {
                    return step.hasAttribute('data-target');
                });

                this._steps.forEach(function (step) {
                    _this._stepsContents.push(_this._element.querySelector(step.getAttribute('data-target')));
                });

                this.options = _extends({}, DEFAULT_OPTIONS, _options);

                if (this.options.linear) {
                    this._element.classList.add(ClassName.LINEAR);
                }

                detectAnimation(this._stepsContents, this.options.animation);

                this._setLinkListeners();

                Object.defineProperty(this._element, customProperty, {
                    value: this,
                    writable: true
                });

                if (this._steps.length) {
                    show(this._element, this._currentIndex);
                }
            } // Private


            var _proto = Stepper.prototype;

            _proto._setLinkListeners = function _setLinkListeners() {
                var _this2 = this;

                this._steps.forEach(function (step) {
                    var trigger = step.querySelector(Selectors.TRIGGER);

                    if (_this2.options.linear) {
                        trigger.addEventListener('click', clickStepLinearListener);
                    } else {
                        trigger.addEventListener('click', clickStepNonLinearListener);
                    }
                });
            } // Public
            ;

            _proto.next = function next() {
                this._currentIndex = this._currentIndex + 1 <= this._steps.length - 1 ? this._currentIndex + 1 : this._steps.length - 1;
                show(this._element, this._currentIndex);
            };

            _proto.previous = function previous() {
                this._currentIndex = this._currentIndex - 1 >= 0 ? this._currentIndex - 1 : 0;
                show(this._element, this._currentIndex);
            };

            _proto.to = function to(stepNumber) {
                var tempIndex = stepNumber - 1;
                this._currentIndex = tempIndex >= 0 && tempIndex < this._steps.length ? tempIndex : 0;
                show(this._element, this._currentIndex);
            };

            _proto.reset = function reset() {
                this._currentIndex = 0;
                show(this._element, this._currentIndex);
            };

            _proto.destroy = function destroy() {
                var _this3 = this;

                this._steps.forEach(function (step) {
                    var trigger = step.querySelector(Selectors.TRIGGER);

                    if (_this3.options.linear) {
                        trigger.removeEventListener('click', clickStepLinearListener);
                    } else {
                        trigger.removeEventListener('click', clickStepNonLinearListener);
                    }
                });

                this._element[customProperty] = undefined;
                this._element = undefined;
                this._currentIndex = undefined;
                this._steps = undefined;
                this._stepsContents = undefined;
            };

            return Stepper;
        }();

    return Stepper;

}));
//# sourceMappingURL=bs-stepper.js.map
$(document).ready(function () {
    var events = [];
    $('#export').on('click', function () {
        console.log($('#exporturl').val());
        $.ajax({
            url: $('#exporturl').val(),
            data: {'tx_fagbesichtigung_besichtigung[events]': events},
            type: 'POST',
            success: function (data) {
                if ($(data).find('#exportid').attr('href')) {
                    window.open($(data).find('#exportid').attr('href'));
                }

            }
        });
    });
});
if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = function (callback, thisArg) {
        thisArg = thisArg || window;
        for (var i = 0; i < this.length; i++) {
            callback.call(thisArg, this[i], i, this);
        }
    };
}

var stepper1Node = document.querySelector('#stepper1');
var stepper1 = new Stepper(stepper1Node);
document.querySelectorAll('.next').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        stepper1.next();
    });
});

document.querySelectorAll('.next-slide').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        // stepper1.next();
    });

});

var step2Free = document.querySelector('#step-1-2-free'),
    step2Private = document.querySelector('#step-1-2-private'),
    step3Free = document.querySelector('#step-1-3-free'),
    step31Private = document.querySelector('#step-1-3-1-private'),
    step32Private = document.querySelector('#step-1-3-2-private'),
    cardsBtnNext = document.querySelector('.cards__btn--next'),
    radiosDateCards = document.querySelectorAll('.dbtn'),
    firstPanel = document.querySelector('.dbtn-panel-title'),
    panelTitle = document.querySelectorAll('.panel-title'),
    radios = document.getElementsByName('rbtn'),
    latestStep = document.querySelector('.latest-step');


document.addEventListener('DOMContentLoaded', eventListeners);

function eventListeners() {

    var firstYearTab = document.querySelector('.tablinks:first-child');
    if (firstYearTab) {
        firstYearTab.className += " active";
    }
    fillSlider();
    dateBlocActive();
    changeDateFormat();
    initFilter();
    autoSortLabels();
    changeDateFormatStep2();

     jQuery(".years-filtre__month").on("click", function(){
        jQuery(".years-filtre__month").removeClass("active");
        jQuery(this).addClass("active");
      
     });
     filterSelection((new Date().getMonth() + 1))

    // document.querySelectorAll('.dbtn-panel-title').forEach(function(panel){
    //     panel.addEventListener('click',function(){
    //             var myNextSibling = panel.parentElement.parentElement.nextElementSibling;
    //             myNextSibling.classList.add('in');
        
    //     })
    // })

}
if ( (window.location.href.indexOf("unsuccessful%5D=true") != -1) || (window.location.href.indexOf("unsuccessful]=true") != -1) ) {
    var stepper = new Stepper(document.querySelector('.bs-stepper'))
    stepper.to(3);
    document.getElementById('step-1-3-1-private').style.display = 'block';
    getLocalStorage();
    }

function myLocalStorage(){
    localStorage.setItem("personen", document.querySelector('#step-1-3-1-private .Anzahl-personen-input').value);
    localStorage.setItem("personen max", document.querySelector('#step-1-3-1-private .Anzahl-personen-input').getAttribute('max'));
    localStorage.setItem("gruppenname", document.querySelector('#step-1-3-1-private .gruppenname').value);    
    localStorage.setItem("vorname", document.querySelector('#step-1-3-1-private .vorname').value);
    localStorage.setItem("name", document.querySelector('#step-1-3-1-private .name').value);
    localStorage.setItem("funktion", document.querySelector('#step-1-3-1-private .funktion').value);
    localStorage.setItem("strasse", document.querySelector('#step-1-3-1-private .strasse').value);
    localStorage.setItem("ortPLZ", document.querySelector('#step-1-3-1-private .ortPLZ').value);
    localStorage.setItem("email", document.querySelector('#step-1-3-1-private .email').value);
    localStorage.setItem("telefon", document.querySelector('#step-1-3-1-private .telefon').value);
    localStorage.setItem("bemerkung", document.querySelector('#step-1-3-1-private .bemerkung').value);
    localStorage.setItem("datum", document.querySelector('#step-1-3-1-private .datum').value);
}

function getLocalStorage(){
    document.getElementById("gruppentyp-second").value = 2;
    document.querySelector('#step-1-3-1-private .Anzahl-personen-input').value = localStorage.getItem('ourInput');
    document.querySelector('#step-1-3-1-private .Anzahl-personen-input').value = localStorage.getItem('personen');
    document.querySelector('#step-1-3-1-private .gruppenname').value = localStorage.getItem('gruppenname');
    document.querySelector('#step-1-3-1-private .vorname').value = localStorage.getItem('vorname');
    document.querySelector('#step-1-3-1-private .name').value = localStorage.getItem('name');
    document.querySelector('#step-1-3-1-private .funktion').value = localStorage.getItem('funktion');
    document.querySelector('#step-1-3-1-private .strasse').value = localStorage.getItem('strasse');
    document.querySelector('#step-1-3-1-private .ortPLZ').value = localStorage.getItem('ortPLZ');
    document.querySelector('#step-1-3-1-private .email').value = localStorage.getItem('email');
    document.querySelector('#step-1-3-1-private .telefon').value = localStorage.getItem('telefon');
    document.querySelector('#step-1-3-1-private .bemerkung').value = localStorage.getItem('bemerkung');
    document.querySelector('#step-1-3-1-private .datum').value = localStorage.getItem('datum');
    document.querySelector('.payement-error-msg .age-error-msg2').style.display = "block";

    var target = document.querySelector('#step-1-3-1-private [name="tx_fagbesichtigung_besichtigung[newAnfrage][anrede]"]');
    for (var i = 0, length = target.length; i < length; i++) {
        if ( target[i].value ==  localStorage.getItem("Anrede") ) {
            target[i].createAttribute('checked');
        }
    }
   
    document.querySelector('#step-1-3-1-private .Anzahl-personen-input').setAttribute('max',localStorage.getItem('personen max'));

    var btnAttr = latestStep.getAttribute('data-kosten');
    latestStep.innerHTML="Besichtigung buchen für CHF "+btnAttr+".-";
   
}


function initFilter() {
    var actualMonthAndYear =   (new Date().getMonth() + 1)  + '' +  new Date().getFullYear(),
    activeFilterBtn = document.querySelectorAll('.years-filtre__month');

    activeFilterBtn.forEach(function (btn) {
        if (btn.getAttribute('onclick').indexOf('filterSelection(' + actualMonthAndYear + ')') > -1) {
            btn.classList.add('active');
        }     
    });
}

function dateBlocActive() {

    var checkedBtn = document.querySelectorAll('.dbtn');
    checkedBtn.forEach(function (btn) {
        btn.addEventListener('change', function (e) {
            var CheckedBtn = document.querySelector('.dbtn:checked');
            var notCheckedBtns = document.querySelectorAll('.dbtn:not(:checked)');
            CheckedBtn.parentElement.lastElementChild.classList.add('date-bloc--active');
            notCheckedBtns.forEach(function (notCheckedBtn) {
                notCheckedBtn.parentElement.lastElementChild.classList.remove('date-bloc--active');
            });
            document.querySelector('.second-step-btn').setAttribute('onclick', 'stepper1.next()');
            document.querySelectorAll(".datum").forEach(function (datum) {
                datum.value = e.target.getAttribute('data-dateid');
                maxValue(datum.value);
            });
        })
    })
}


function maxValue(props) {
    document.querySelectorAll('.array').forEach(function (oneArray) {
        var obj = JSON.parse(oneArray.getAttribute('data-array'));
        obj.forEach(function (id) {
            if (props == id.uid) {
                var scope1 = document.querySelector('.free-input'),
                    scope2 = document.querySelector('.private1-input'),
                    scope3 = document.querySelector('.private2-input');
                if (scope1) {
                    scope1.setAttribute('max', id.max);
                }
                if (scope2) {
                    scope2.setAttribute('max', id.max);
                }
                if (scope3) {
                    scope3.setAttribute('max', id.max);

                }

            }
        })
    })
}

for (var i = 0, length = radios.length; i < length; i++) {
    radios[i].addEventListener('change', function (e) {
        switch (e.target.getAttribute('data-title')) {
            case 'Für Einzelpersonen':
                document.getElementById('1-1').style.display = 'block';
                document.getElementById('2-1').style.display = 'none';
                document.getElementById('3-1').style.display = 'none';
                document.getElementById("gruppentyp-first").value = e.target.getAttribute('data-id');
                break;
            case 'Für Gruppen':
                document.getElementById('1-1').style.display = 'none';
                document.getElementById('2-1').style.display = 'block';
                document.getElementById('3-1').style.display = 'none';
                document.getElementById("gruppentyp-second").value = e.target.getAttribute('data-id');

                break;
            case 'Für Schulklassen':
                document.getElementById('1-1').style.display = 'none';
                document.getElementById('2-1').style.display = 'none';
                document.getElementById('3-1').style.display = 'block';
                document.getElementById("gruppentyp-third").value = e.target.getAttribute('data-id');
                break;
            default:
                break;
        }
    });
}

cardsBtnNext.addEventListener('click', function () {
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            switch (radios[i].getAttribute('data-title')) {
                case 'Für Einzelpersonen':
                    step2Free.style.display = 'block';
                    step3Free.style.display = 'block';
                    stepper1.next();
                    break;
                case 'Für Gruppen':
                    step2Private.style.display = 'block';
                    step31Private.style.display = 'block';
                    radiosDateCards.forEach(function (btn) { 
                        var attr = btn.getAttribute('data-kosten');
                        if (attr){
                        btn.nextElementSibling.lastElementChild.innerHTML="Kosten: CHF "+attr+"";
                        }
                        })
                        var btnAttr = latestStep.getAttribute('data-kosten');
                        latestStep.innerHTML="Besichtigung buchen für CHF "+btnAttr+".-";
                    document.querySelector('.custom-lead').innerHTML="«Die private Führung kostet pauschal 150 Franken. Die maximale Teilnehmerzahl beträgt 20 Personen pro Zeitfenster. Sie können pro Führung maximal zwei Zeitfenster mit einer maximalen Teilnehmerzahl von 40 Personen buchen.»";
                    stepper1.next();
                    var swiper = new Swiper('.swiper-container', {
                        slidesPerView: 7,
                        spaceBetween: 15,
                        centeredSlides: false,
                        freeMode: false,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        loopFillGroupWithBlank: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        },
                        breakpoints: {
                            768: {
                                slidesPerView: 5,
                                spaceBetween: -40,
                                centeredSlides: false
                            },
                            480: {
                                slidesPerView: 4,
                                spaceBetween: -40,
                                centeredSlides: false
                            }

                        }
                    });
                    break;
                case 'Für Schulklassen':
                    step2Private.style.display = 'block';
                    step32Private.style.display = 'block';
                    document.querySelector('.custom-lead').innerHTML="«Die private Führung ist für Schulklassen mit einem Durchschnittsalter unter 18 Jahren. Die maximale Teilnehmerzahl beträgt 20 Personen pro Zeitfenster. Sie können pro Führung maximal zwei Zeitfenster mit einer maximalen Teilnehmerzahl von 40 Personen buchen.»";
                    stepper1.next();
                    var swiper = new Swiper('.swiper-container', {
                        slidesPerView: 7,
                        spaceBetween: 15,
                        centeredSlides: false,
                        freeMode: false,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        loopFillGroupWithBlank: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        },
                        breakpoints: {
                            768: {
                                slidesPerView: 5,
                                spaceBetween: -40,
                                centeredSlides: false
                            },
                            480: {
                                slidesPerView: 4,
                                spaceBetween: -40,
                                centeredSlides: false
                            }
                        }
                    });
                    break;
                default:
                    break;
            }
            // only one radio can be logically checked, don't check the rest
            break;
        }
    }

});

function reload() {
    stepper1.previous();
    location.reload();
}

var anzahlP = document.querySelectorAll('.Anzahl-personen-input'),
    ageErrorMsg = document.querySelectorAll('.age-error-msg'),
    Durch = document.querySelector('.durchschnittsalter-input'),
    durchErrorMsg = document.querySelector('.durch-error-msg');


anzahlP.forEach(function (anzahl) {
    anzahl.addEventListener('input', function () {
        if (parseInt(anzahl.value) > parseInt(anzahl.getAttribute('max'))) {
            ageErrorMsg.forEach(function (msg) {
                msg.style.display = 'block';
            });
        }
        else {
            ageErrorMsg.forEach(function (msg) {
                msg.style.display = 'none';
            });
        }
        if (parseInt(anzahl.value) < 1) {
            anzahl.value = "";
        }


    });
});

if (Durch) {
    Durch.addEventListener('input', function () {
        if (parseInt(Durch.value) > 18) {
            durchErrorMsg.style.display = 'block';
        }
        else {
            durchErrorMsg.style.display = 'none';
        }        

    });
}

document.querySelectorAll('.previous').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        stepper1.previous();
    });
});


function thisYear(evt, year) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(year).style.display = "block";
    evt.currentTarget.className += " active";
}

function fillSlider() {
    var actualYear = new Date().getFullYear(),
        nextYear = actualYear + 1,
        Years = [actualYear, nextYear],
        theMonths = [
            {m: "Jan", id: 1},
            {m: "Feb", id: 2},
            {m: "Mär", id: 3},
            {m: "Apr", id: 4},
            {m: "Mai", id: 5},
            {m: "Jun", id: 6},
            {m: "Jul", id: 7},
            {m: "Aug", id: 8},
            {m: "Sep", id: 9},
            {m: "Okt", id: 10},
            {m: "Nov", id: 11},
            {m: "Dez", id: 12}
        ],
        mainWrapper = document.querySelector('.swiper-wrapper'),
        html = '';
    for (i = 0; i < Years.length; i++) {
        for (j = 0; j < 12; j++) {
            html += '<div class="swiper-slide">';
            html += '<button  class="years-filtre__month btn" onclick="filterSelection(' + theMonths[j].id + '' + Years[i] + ')">' + theMonths[j].m + '</br> ' + Years[i] + '</button>';
            html += '</div>';
        }
        ;
    }
    ;
    mainWrapper.innerHTML = html;
};

function formatDate(date) {
    var monthNames = [
        "Januar", "Februar", "März",
        "April", "Mai", "Juni", "Juli",
        "August", "September", "Oktober",
        "November", "Dezember"
    ];
    var days = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];

    var day = date.getDate();
    var monthIndex = date.getMonth();
    var weekDay = days[date.getDay()];

    return weekDay + ' ' + day + '. ' + monthNames[monthIndex];
}

function convertDateForIos(date) {
    var arr = date.split(/[- :]/);
    date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
    return date;
}

function changeDateFormat() {
    radiosDateCards.forEach(function (btn) {
        var attr = btn.getAttribute('data-date'),     
            format = formatDate(new Date(attr)),  
            theTitle = btn.nextElementSibling;

         if (theTitle.classList.contains('dbtn-card-title')) {
            theTitle.innerHTML = format;
         }
        
    });
}

function changeDateFormatStep2() {
    panelTitle.forEach(function (btn) {
       var attr = btn.getAttribute('data-date'),  
            format = formatDate(new Date(attr)),
            theTitle = btn.firstElementChild;
        if (theTitle.classList.contains('dbtn-panel-title')) {
            theTitle.firstElementChild.innerHTML = format;
        }
    });
}

// function initAccordionsStyle() {
//    var   firstPanel = document.querySelector('.dbtn-panel-title');
//    var myNextSibling = firstPanel.parentElement.parentElement.nextElementSibling;
//     if (firstPanel.classList.contains('collapsed')) {
//         firstPanel.classList.remove('collapsed');
//         firstPanel.setAttribute('aria-expanded', 'true'); 
//      } else {
//         firstPanel.classList.add('collapsed');
//         firstPanel.setAttribute('aria-expanded', 'false'); 
//         myNextSibling.classList.remove('in');

//      }
//     myNextSibling.classList.add('in');
       
// }
// initAccordionsStyle();

// filter 

filterSelection("all")

function filterSelection(c) {
     var  i,
      x = document.getElementsByClassName("filterDiv");
    if ( c == "all") c = "";
    // Add the "show" class (display:block) to the filtered elements, and remove the "show" class from the elements that are not selected
    for (i = 0; i < x.length; i++) {        
        w3RemoveClass(x[i], "show");
       if (x[i].className.indexOf(c) > -1) {           
        w3AddClass(x[i], "show");
        // if class out exist delete   
         }       
        }
        document.querySelectorAll('.show').forEach(function(sh){
            sh.lastElementChild.classList.remove('in');
        })
       document.querySelector('.show').lastElementChild.classList.add('in');
        document.querySelector('.show').lastElementChild.style.height = '272px';
   
}


// Show filtered elements
function w3AddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        if (arr1.indexOf(arr2[i]) == -1) {
            element.className += " " + arr2[i];
        }
    }
}

// Hide elements that are not selected
function w3RemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);
        }
    }
    element.className = arr1.join(" ");
}

function autoSortLabels() {
    var labels = document.querySelectorAll('.years-filtre__year');
    for (i = 0; i < labels.length; i++) {
        var yearSort = labels[i].innerHTML;
        sortLabels(".tabs-for-sort" + yearSort);
    }

}

function sortLabels(props) {
    var list, i, switching, b, shouldSwitch;
    list = document.querySelector(props);
    switching = true;
    while (switching) {
        switching = false;
        b = list.querySelectorAll(props + ">div");
        for (i = 0; i < (b.length - 1); i++) {
            shouldSwitch = false;
            if (b[i].firstElementChild.firstElementChild.getAttribute('data-date') > b[i + 1].firstElementChild.firstElementChild.getAttribute('data-date')) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            b[i].parentNode.insertBefore(b[i + 1], b[i]);
            switching = true;
        }
    }
}

function sortPrivate() {
    var i, switching, b, shouldSwitch;
     switching = true;
    while (switching) {
        switching = false;
        b = document.querySelectorAll('.panel-group>div');
        for (i = 0; i < (b.length - 1); i++) {
            shouldSwitch = false;
            if (b[i].firstElementChild.firstElementChild.getAttribute('data-date') > b[i + 1].firstElementChild.firstElementChild.getAttribute('data-date')) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            b[i].parentNode.insertBefore(b[i + 1], b[i]);
            switching = true;
        }
    }
}
sortPrivate();

document.querySelector('.latest-step').addEventListener('click', function (e) {
    e.preventDefault();
    var myForm = document.querySelectorAll('.custom-form');
    myForm.forEach(function (form) {
        var myTarget = form.firstElementChild.firstElementChild.lastElementChild.lastElementChild.lastElementChild.previousElementSibling;
        switch (form.style.display) {
            case 'block':
                myLocalStorage();
                myTarget.click();
                break;
            default:
                break;
        }
    })

})


	 function hasHtml5Validation () {
		return typeof document.createElement('input').checkValidity === 'function';
	}
	if (hasHtml5Validation()) {
		$('form').submit(function (e) {
		if (!this.checkValidity()) {
			e.preventDefault();
			$(this).addClass('invalid');
		} else {
			$(this).removeClass('invalid');
		}
		});
	}
