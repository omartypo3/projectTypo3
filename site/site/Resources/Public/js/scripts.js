if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = function (callback, thisArg) {
        thisArg = thisArg || window;
        for (var i = 0; i < this.length; i++) {
            callback.call(thisArg, this[i], i, this);
        }
    };
}
//==variables==//

//header
var logo = document.querySelector('.header-nav__logo');
var signet = document.querySelector('.header-nav__signet');
var headerLang = document.querySelector('.header-lang');
var langItems = document.querySelectorAll('.header-lang__item');
var chosenItem = document.getElementById('chosen-lang');

// nav
var navigation = document.querySelector('.navigation');
var ringNav = document.querySelector('.header__menu-icon');
var navOpenIcon = document.querySelector('.header__menu--open');
var navCloseIcon = document.querySelector('.header__menu--close');
var mql = window.matchMedia("(orientation: portrait)");

var navItems = document.querySelector('.navigation__items');
var navBg = document.querySelector('.navigation__bg');

//why inter buttons
var whyInterBtns = document.querySelector('.why-inter__buttons');

//scroll
var seeMoreBtn = document.querySelector('.local-scroll');
var seeMoreScrollDown = document.querySelector('.scroll-down');
var partnersSlider = document.querySelector('.sgeagles-partners__swiper');
var radialIndicators = document.querySelector('.radial-indicator');
var radialIndicatorsState = false;


//play video
var sgeaglesVideo = document.querySelector('.sgeagles__video');
var academyVideo = document.querySelector('.academy__video');

// IFRAME
var newsSrc = document.querySelectorAll('.newsroom-src');
var newsIframe = document.getElementById('newsroom__iframe');


// Detecting Mobile Devices
var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
var isTablet = {
    iOS: function () { return navigator.userAgent.match(/iPad|iPod/i); },
    Android: function () { return navigator.userAgent.match(/Android/i); },
    any: function () { return (isTablet.Android() || isTablet.iOS()); }
};


//==event listeners==//

// Event Listeners
eventlisteners();

//==functions==//
function eventlisteners() {
    document.addEventListener('DOMContentLoaded', () => {
        let headvisual = document.querySelector('.headvisual');
        if (headvisual) {
            headvisual.classList.add('scale-content-bg');
            if (isMobile.any() && (mql.matches)) {
                headvisual.classList.remove('scale-content-bg');
            }
        }
    })
    // Business section dynamic style
    document.addEventListener('DOMContentLoaded', dynamicBusinesscontent);
    // hide show language bar
    document.addEventListener('DOMContentLoaded', hideShowLangBar);
    //replace the choosen language
    document.addEventListener('DOMContentLoaded', langBar);
    // hide show elements on scroll
    document.addEventListener('scroll', hideShowOnScroll);
    // hide show academy section in scroll
    if (isMobile.any() && (mql.matches)) {
        document.addEventListener('scroll', secondSection);
    } else if (isTablet.any() && (mql.matches)) {
        document.addEventListener('DOMContentLoaded', secondSection);
    } else {
        document.addEventListener('scroll', secondSection);
    }

    // play sgeagles video
    if (sgeaglesVideo) {
        sgeaglesVideo.addEventListener('click', playVideoSgeagles);
    }
    // play academy video
    if (academyVideo) {
        academyVideo.addEventListener('click', playVideoAcademy);
    }
    //open nav menu


    if (ringNav.classList.contains('open-nav')) {
        navOpenIcon.addEventListener('click', openNav);
    } else {
         if (isMobile.any() && (mql.matches)) {
            navOpenIcon.addEventListener('click', openNav);
        } else {
            ringNav.addEventListener('click', openNav);
        }

    }




    //close nav menu
    navCloseIcon.addEventListener('click', closeNav);

    //scrolToWhyInter
    if (seeMoreScrollDown) {
        seeMoreScrollDown.addEventListener('click', scrolToWhyInter);
    }
}

function secondSection() {
    let scrolled = (document.documentElement && document.documentElement.scrollTop) ||
        document.body.scrollTop;
    //youth__img
    let interContentYouth = document.querySelector('.youth');
    let youthImg = document.querySelector('.youth__img');
    if ((interContentYouth) && (youthImg)) {
        if (scrolled > interContentYouth.offsetTop - 1100) youthImg.classList.add('to-top-img');
        else youthImg.classList.remove('to-top-img');
    }
    //youth academy
    let youthAcademy = document.querySelector('.youth-content-right');
    if ((interContentYouth) && (youthAcademy)) {
        if (scrolled > interContentYouth.offsetTop - 1100) youthAcademy.classList.add('to-left-img');
        else youthAcademy.classList.remove('to-left-img');
    }
};


function openNav() {
    setTimeout(() => {
        if (isMobile.any() && (mql.matches)) {
            setTimeout(() => {
                headerLang.classList.add('header-lang__column')
                headerLang.style.display = "flex";
            }, 400);
            langItems.forEach((item) => {
                item.style.display = "none";
            });
        }
        headerLang.style.display = "flex";
        navigation.style.display = "block";
        navOpenIcon.style.display = "none";
        ringNav.classList.add('open-nav');
        ringNav.classList.remove('close-nav');
        chosenItem.classList.remove('scrolledLang');
    }, 100)

    setTimeout(() => {
        navItems.classList.add('show-items');
        logo.style.display = "none";
        signet.style.display = "block";
        navCloseIcon.style.width = "0.2rem";
    }, 300)
    setTimeout(() => {
        navBg.classList.add('show-scale-bg');
    }, 400)
    setTimeout(() => {
        navCloseIcon.style.display = "block";
        ringNav.style.cursor = 'auto';
    }, 700)

}

function closeNav() {
    if (chosenItem.classList.contains('clicked')) {
        chosenItem.click();
    }
    setTimeout(() => {
        ringNav.classList.remove('open-nav');
        ringNav.classList.add('close-nav');
        navCloseIcon.style.width = "0";
    }, 400);
    setTimeout(() => {
        navItems.classList.remove('show-items');
        navBg.classList.remove('show-scale-bg');
        navigation.style.display = "none";
        navCloseIcon.style.display = "none";
    }, 800);
    setTimeout(() => {
        ringNav.style.cursor = 'pointer';
        if (isMobile.any() && (mql.matches)) {
            headerLang.style.display = "none";
        }
    }, 900);
    setTimeout(() => {
        navOpenIcon.style.display = "block";
        logo.style.display = "block";
        signet.style.display = "block";
    }, 1100);
}


function hideShowOnScroll() {
    let scrolled = (document.documentElement && document.documentElement.scrollTop) ||
        document.body.scrollTop;
    //Chosen lang
    var positionCI = chosenItem.offsetTop;
    if (scrolled > positionCI + 150) {
        chosenItem.classList.add('scrolledLang');
        langItems.forEach((item) => {
            item.classList.remove('show-items');
        });
    } else chosenItem.classList.remove('scrolledLang');
    if (ringNav.classList.contains('open-nav')) {
        chosenItem.classList.remove('scrolledLang');
    }

    //See more button 
    if (seeMoreBtn) {
        if (scrolled > positionCI + 250) {
            seeMoreBtn.classList.add('scrolled-see-more');
            whyInterBtns.classList.add('scale-in');
            whyInterBtns.classList.remove('scale-out');
        } else {
            seeMoreBtn.classList.remove('scrolled-see-more');
            whyInterBtns.classList.add('scale-out');
            whyInterBtns.classList.remove('scale-in');
        }
    }

    //Logo
    //     positionLogo = document.querySelector('.why-inter').offsetTop;
    let height = 50;
    if (isMobile.any() && (mql.matches)) {
        height = 20;
    }
    if (scrolled > positionCI + height) {
        logo.style.opacity = "0";
    } else {
        logo.style.opacity = "1";
    }
    if (ringNav.classList.contains('open-nav')) {
        logo.style.opacity = "0";
        signet.style.opacity = "1";
    }

    //Radial Indicators 
    let positionRadials = document.querySelector('.three-pillars');
    if (positionRadials) {
        if (scrolled > positionRadials.offsetTop + 1) {
            if (radialIndicatorsState == false) {
                showRadials();
                radialIndicatorsState = true;
            }
        }
    }

    // SGeagles video
    let positionSgeagles = document.querySelector('.quotes');
    if ((positionSgeagles) && (sgeaglesVideo)) {
        if (scrolled > positionSgeagles.offsetTop + 1) sgeaglesVideo.classList.add('scrolled-video');
        else sgeaglesVideo.classList.remove('scrolled-video');
    }
    // academy video
    let positionAcademy = document.querySelector('.intro-content');
    if ((positionAcademy) && (academyVideo)) {
        if (scrolled > positionAcademy.offsetTop + 100) academyVideo.classList.add('scrolled-video');
        else academyVideo.classList.remove('scrolled-video');
    }
    //partners slider
    let positionPartners = document.querySelector('.sgeagles__content');
    if ((positionPartners) && (partnersSlider)) {
        if (scrolled > positionPartners.offsetTop + 1) partnersSlider.style.opacity = "1";
        else partnersSlider.style.opacity = "0";
    }

    //inter country
    let interCountries = document.querySelector('.inter__countries');
    let interCountry = document.querySelectorAll('.inter-country');
    if (interCountry) {
        interCountry.forEach((country) => {
            if (interCountries) {
                if (scrolled > interCountries.offsetTop + 1250) country.classList.add('scale-show-bg');
                else country.classList.remove('scale-show-bg');
            }
        })
    }

    //tours & big slider animations on scroll
    const sliders = [{
        nextbtn: 'tours__btn--next',
        prevbtn: 'tours__btn--prev',
        parentSection: 'tours'
    },
    {
        nextbtn: 'big-slider__btn--next',
        prevbtn: 'big-slider__btn--prev',
        parentSection: 'big-slider'
    }
    ];
    sliders.map((slider) => {
        let nextBtnTours = document.querySelector(`.${slider.nextbtn}`);
        let prevBtnTours = document.querySelector(`.${slider.prevbtn}`);
        let parentSection = document.querySelector(`.${slider.parentSection}`);
        if ((parentSection) && (nextBtnTours) && (prevBtnTours)) {
            if (scrolled > parentSection.offsetTop - 600) {
                prevBtnTours.classList.add('to-left-prev');
                nextBtnTours.classList.add('to-right-next');
            } else {
                prevBtnTours.classList.remove('to-left-prev');
                nextBtnTours.classList.remove('to-right-next');
            }
        }
    })

    // players slider
    let playerImgs = document.querySelectorAll('.players-slider__slide img');
    let PlayersSlider = document.querySelector('.players-slider');
    if ((PlayersSlider) && (playerImgs)) {
        playerImgs.forEach((playerImg) => {
            if (scrolled > PlayersSlider.offsetTop - 850) playerImg.classList.add('player-img-show');
            else playerImg.classList.remove('player-img-show');
        });
    }
}

// language bar

// chosen language animation on click
chosenItem.addEventListener('click', () => {
    chosenItem.classList.toggle('clicked');
});

//function hide and show the language bar
function hideShowLangBar() {
    var langItem = langItems.forEach((item) => {
        chosenItem.addEventListener('click', (e) => {
            e.preventDefault();
            if (item.classList.contains('show-items')) {
                item.classList.add('hide-items');
                item.classList.remove('show-items');
                if (isMobile.any() && (mql.matches)) {
                    item.style.display = 'none';
                    ringNav.classList.remove('custom-margin');
                    navItems.classList.add('show-items');
                    
                }
            } else {
                item.classList.add('show-items');
                item.classList.remove('hide-items');
                if (isMobile.any() && (mql.matches)) {
                    item.style.display = 'flex';
                    ringNav.classList.add('custom-margin');
                    navItems.classList.remove('show-items');                   
                }
            }
            // if (isMobile.any() && (mql.matches)) {
            //     navItems.classList.toggle('hidden');
            // }
        })
    })
    return langItem;
}

//function replace the choosen language
function langBar() {
    var langItem = langItems.forEach((item) => {
        item.addEventListener('click', () => {
            // animate the language image
            item.classList.toggle('lang-active');
            // get chosen language variables
            let chosenImage = chosenItem.lastElementChild.firstElementChild.src;
            let chosenText = chosenItem.firstElementChild.textContent;
            let srcImage = item.lastElementChild.firstElementChild.src;
            let srcTexT = item.firstElementChild.textContent;
            setTimeout(() => {
                //minimize the icon
                langItems.forEach((item) => {
                    item.classList.remove('show-items');
                    item.classList.add('hide-items');
                    if (isMobile.any() && (mql.matches)) {
                        item.style.display = 'none';
                        ringNav.classList.remove('custom-margin');
                      
                    }
                });
            }, 500);
            setTimeout(() => {
                chosenItem.lastElementChild.firstElementChild.src = srcImage;
                item.lastElementChild.firstElementChild.src = chosenImage;
                chosenItem.firstElementChild.textContent = srcTexT;
                item.firstElementChild.textContent = chosenText;
                // hide other lang after choosing
            }, 800)
            setTimeout(() => {
                //minimize the icon
                chosenItem.classList.remove('clicked');
                if (isMobile.any() && (mql.matches)) {
                    navItems.classList.remove('hidden');
                    navCloseIcon.style.display = "block";
                }
            }, 1000);
        })
    })
    return langItem;
}


// radial indicators
function showRadials() {
    var indicators = {};
    var i = 0;
    while (document.getElementById('radial' + i)) {
        var element = document.getElementById('radial' + i);
        var initValue = document.getElementById('radial' + i + 'InitValue').textContent;
        var maxValue = document.getElementById('radial' + i + 'MaxValue').textContent;
        indicators['i' + i + '_1'] = radialIndicator(element, {
            maxValue: maxValue,
            barColor: '#000'
        });
        indicators['i' + i + '_1'].animate(initValue * 1);
        indicators['i' + i + '_2'] = radialIndicator(element, {
            maxValue: maxValue,
            barColor: 'rgba(0,0,0,0.5)',
            displayNumber: false
        });
        indicators['i' + i + '_2'].animate2(maxValue);
        i++;
    }
}

// sliders
var swiperQuotes = new Swiper('.quotes__slides', {
    slidesPerView: 1,
    loop: true,
    autoplay: {
        delay: 3000,
    },
    speed: 2000,
    initialSlide: 2,
    effect: 'fade',
    fadeEffect: {
        crossFade: true,
    },
    pagination: {
        el: '.slider__pagination',
        clickable: true
    },
    navigation: {
        nextEl: '.nav--next',
        prevEl: '.nav--prev'
    },
});

var swiperPartners = new Swiper('.sgeagles-partners__swiper', {
    initialSlide: 2,
    slidesPerView: 4,
    spaceBetween: 30,
    autoplay: {
        delay: 3000,
    },
    speed: 2000,
    pagination: {
        el: '.slider__pagination',
        clickable: true
    },
    navigation: {
        nextEl: '.nav--next',
        prevEl: '.nav--prev'
    },
    loop: true,
    breakpoints: {
        480: {
            slidesPerView: 1,
            spaceBetween: 30,
            centeredSlides: true,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 30,
            centeredSlides: true,
        }
    },
});

var swiperPlayers = new Swiper('.players-slider__slider', {
    freeMode: false,
    slidesPerView: 5,
    spaceBetween: 30,

    centeredSlides: true,
    initialSlide: 2,
    pagination: {
        el: '.players-slider__pagination',
        clickable: true
    },
    navigation: {
        nextEl: '.players-slider__btn--next',
        prevEl: '.players-slider__btn--prev'
    },
    loop: true,
    breakpoints: {
        480: {
            slidesPerView: 1,
            spaceBetween: 30,
            centeredSlides: true,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 60,
            centeredSlides: true
        }
    }

});
var swiperPillars = new Swiper('.three-pillars__slider', {
    loop: true,
    pagination: {
        el: '.slider__pagination',
        clickable: true
    },
    centeredSlides: true,
    navigation: {
        nextEl: '.nav--next',
        prevEl: '.nav--prev'
    },
    initialSlide: 2,
    breakpoints: {
        360: {
            slidesPerView: 1,
            spaceBetween: 20
        },
        480: {
            slidesPerView: 1.3,
            spaceBetween: 0,
        },
        768: {
            slidesPerView: 1.5,
            spaceBetween: 30,
        }
    }
});

// extract number from string

function sumDigitsFromString(str) {
    let nums = [];
    let sum = 0;
  
    for (let i = 0; i < str.length; i++) {
      if (!isNaN(Number(str[i]))) {
        nums.push(Number(str[i]));
      }
    }
    console.log(nums);
    for (let i = 0; i < nums.length; i++) {
      sum += nums[i];
    }
    return sum;
  }
  

// check partner slider slides number


var partnersSliderData = document.querySelector('.partners__slider .swiper-wrapper'),
    slidesNumber;
           if (partnersSliderData){
                if ( partnersSliderData.getAttribute('data-slider') > 5 ){
                    slidesNumber = 5 ;
                } else {
                    slidesNumber = partnersSliderData.getAttribute('data-slider') ;
                }
            }

document.addEventListener('DOMContentLoaded', () => {
    var partnersSliderBullets = document.querySelectorAll('.partners__pagination .swiper-pagination-bullet');

    partnersSliderBullets.forEach((bullet) => {
        if (    parseInt(sumDigitsFromString(bullet.getAttribute('aria-label'))) > 5  ){
            bullet.style.display = 'none';
        };
    });
})

// content page sliders
var swiperPartnersContent = new Swiper('.partners__slider', {
    slidesPerView: slidesNumber,
    freeMode: false,
    spaceBetween: 30,
    centeredSlides: false,
    pagination: {
        el: '.partners__pagination',
        clickable: true
    },
    navigation: {
        prevEl: '.partners__btn--prev',
        nextEl: '.partners__btn--next'
    },
   // initialSlide: 2,
    loop: true,
    breakpoints: {
        480: {
            slidesPerView: 1,
            spaceBetween: 30,
            centeredSlides: true
        }
    }

});

var swiperTours = new Swiper('.tours__slider', {
    slidesPerView: 1,
    effect: 'fade',
    fadeEffect: {
        crossFade: true,
    },
    autoplay: {
        delay: 3000,
    },
    speed: 2000,
    initialSlide: 2,
    pagination: {
        el: '.tours__pagination',
        clickable: true
    },
    navigation: {
        nextEl: '.nav--next-tours',
        prevEl: '.nav--prev-tours'
    },
    loop: true,
    // calculateHeight: true,
    autoHeight: true
});
document.addEventListener('DOMContentLoaded', () => {
    let prevCustomTours = document.querySelector('.nav--prev-custom-tours');
    let prevTours = document.querySelector('.nav--prev-tours');
    let nextCustomTours = document.querySelector('.nav--next-custom-tours');
    let nextTours = document.querySelector('.nav--next-tours');

    if ((prevCustomTours) && (prevTours)) {
        prevCustomTours.addEventListener('click', () => prevTours.click());
    }
    if ((nextCustomTours) && (nextTours)) {
        nextCustomTours.addEventListener('click', () => nextTours.click());
    }

})

var bigSlider = new Swiper('.big-slider__slider', {
    slidesPerView: 1,
    effect: 'fade',
    fadeEffect: {
        crossFade: true,
    },
    autoplay: {
        delay: 3000,
    },
    speed: 2000,
    pagination: {
        el: '.big-slider__pagination',
        clickable: true
    },
    initialSlide: 1,
    navigation: {
        nextEl: '.big-slider--next',
        prevEl: '.big-slider--prev'
    },
    loop: true
});


// videos 
function playVideoSgeagles() {

    if (sgeaglesVideo.paused == true) {
        sgeaglesVideo.play();
        sgeaglesVideo.innerHTML = "Pause";
    } else {
        sgeaglesVideo.pause();
        sgeaglesVideo.innerHTML = "Play";
    }
}

function playVideoAcademy() {    
    if (academyVideo.paused == true) {
        academyVideo.play();
        academyVideo.innerHTML = "Pause";
    } else {
        academyVideo.pause();
        academyVideo.innerHTML = "Play";
    }
}

// page scroll 
function scrolToWhyInter() {
    var whyInter = document.querySelector('.why-inter');
    whyInter.scrollIntoView({
        behavior: 'smooth'
    });
}

var scrollBullet = document.querySelectorAll('.scroll-to-sections__pagination span');
scrollBullet.forEach((item) => {
    item.addEventListener('click', () => {
        scrollBullet.forEach((item) => {
            if (item.classList.contains('swiper-pagination-bullet-active')) {
                item.classList.remove('swiper-pagination-bullet-active');
            };
        });
        item.classList.toggle('swiper-pagination-bullet-active');
    });
})

function scrollToSections() {
    const buttonnext = document.getElementById('next');
    const buttonprevious = document.getElementById('previous');

    const sections = ['intro',
        'why-inter',
        'three-pillars',
        'quotes',
        'sgeagles',
        'sgeagles2',
        'newsroom'
    ]
    sections.map((section) => {
        if (document.getElementById(section)) {
            document.getElementById(`${section}`).addEventListener('click', () => {
                document.querySelector(`.${section}`).scrollIntoView({
                    behavior: 'smooth'
                })
            });
        }
    });

    if (buttonnext) {
        buttonnext.addEventListener('click', function () {
            var spanactive = document.querySelector('.swiper-pagination-bullet-active');
            if (spanactive.nextElementSibling.classList.contains('swiper-pagination-bullet')) {
                document.querySelector('.swiper-pagination-bullet-active').classList.remove('swiper-pagination-bullet-active');
                spanactive.nextElementSibling.classList.add("swiper-pagination-bullet-active");
                document.querySelector(`.` + spanactive.nextElementSibling.id).scrollIntoView({
                    behavior: 'smooth'
                });
                if (spanactive.nextElementSibling.id == 'newsroom' || spanactive.nextElementSibling.id == 'three-pillars') {
                    document.querySelector('.scroll-to-sections__pagination').classList.add('black-pagination');
                } else {
                    document.querySelector('.scroll-to-sections__pagination').classList.remove('black-pagination');
                }
            }

        });

    }
    if (buttonprevious) {
        buttonprevious.addEventListener('click', function () {
            var spanactive = document.querySelector('.swiper-pagination-bullet-active');
            if (spanactive.previousElementSibling.classList.contains('swiper-pagination-bullet')) {
                if (spanactive.previousElementSibling.id == 'three-pillars') {
                    document.querySelector('.scroll-to-sections__pagination').classList.add('black-pagination');
                } else {
                    document.querySelector('.scroll-to-sections__pagination').classList.remove('black-pagination');
                }
                document.querySelector('.swiper-pagination-bullet-active').classList.remove('swiper-pagination-bullet-active');
                spanactive.previousElementSibling.classList.add("swiper-pagination-bullet-active");
                document.querySelector(`.` + spanactive.previousElementSibling.id).scrollIntoView({
                    behavior: 'smooth'
                });
            }

        });
    }


}
scrollToSections();

window.addEventListener('scroll', function () {
    var scrollTop = window.pageYOffset;
    var scrollPagination = document.querySelector('.scroll-to-sections__pagination');
    document.querySelectorAll('section').forEach((item) => {
        let topDistance = item.offsetTop;
        let activeBullet = document.querySelector('.scroll-to-sections__pagination .swiper-pagination-bullet-active');
        if ((parseInt(topDistance) - 500) < scrollTop) {
            if (activeBullet) {
                activeBullet.classList.remove('swiper-pagination-bullet-active');
            }
            if (document.getElementById(item.getAttribute('class'))) {
                document.getElementById(item.getAttribute('class')).classList.add('swiper-pagination-bullet-active');
            }
            if (item.getAttribute('class') == 'newsroom' || item.getAttribute('class') == 'three-pillars') {
                scrollPagination.classList.add('black-pagination');
            } else {
                if (scrollPagination) {
                    scrollPagination.classList.remove('black-pagination');
                }
            }
        }
    });
    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
        if (scrollPagination) {
            scrollPagination.classList.remove('black-pagination');
        }
    }
});

function dynamicBusinesscontent() {
    let businessTitle = document.querySelector('.business .business__title');
    if (businessTitle) {
        if (businessTitle.innerHTML == '') {
            document.querySelector('.business .image-content').classList.add('content-1');
            document.querySelector('.business .image-content').classList.remove('content-2');
        } else {
            document.querySelector('.business .image-content').classList.remove('content-1');
            document.querySelector('.business .image-content').classList.add('content-2');
        }
    }
}