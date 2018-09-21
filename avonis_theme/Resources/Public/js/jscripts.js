/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 *
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

    'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

    function classReg( className ) {
        return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
    }

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
    var hasClass, addClass, removeClass;

    if ( 'classList' in document.documentElement ) {
        hasClass = function( elem, c ) {
            return elem.classList.contains( c );
        };
        addClass = function( elem, c ) {
            elem.classList.add( c );
        };
        removeClass = function( elem, c ) {
            elem.classList.remove( c );
        };
    }
    else {
        hasClass = function( elem, c ) {
            return classReg( c ).test( elem.className );
        };
        addClass = function( elem, c ) {
            if ( !hasClass( elem, c ) ) {
                elem.className = elem.className + ' ' + c;
            }
        };
        removeClass = function( elem, c ) {
            elem.className = elem.className.replace( classReg( c ), ' ' );
        };
    }

    function toggleClass( elem, c ) {
        var fn = hasClass( elem, c ) ? removeClass : addClass;
        fn( elem, c );
    }

    var classie = {
        // full names
        hasClass: hasClass,
        addClass: addClass,
        removeClass: removeClass,
        toggleClass: toggleClass,
        // short names
        has: hasClass,
        add: addClass,
        remove: removeClass,
        toggle: toggleClass
    };

// transport
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( classie );
    } else {
        // browser global
        window.classie = classie;
    }

})( window );
function initGmaps(){
    var mapCont = $('#map_canvas');
    if(mapCont.length != 0){
        var myOptions = {
            zoom:6,
            center:new google.maps.LatLng(44.999206, -93.459859),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            scaleControl: false
        };
        map = new google.maps.Map(mapCont[0], myOptions);
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(44.999206, -93.459859),
            icon: 'fileadmin/template/img/icon-map-location.png'
        });
        infowindow = new google.maps.InfoWindow({
            content: "<b>Titan Tool Inc.</b><br>1770 Fernbrook Lane<br>Plymouth, MN 55447"
        });
        google.maps.event.addListener(marker, "click", function(){
            infowindow.open(map,marker);
        });
    }
}
initGmaps();
function JBCountDown(settings) {
    var glob = settings;

    function deg(deg) {
        return (Math.PI/180)*deg - (Math.PI/180)*90
    }

    glob.total   = Math.floor((glob.endDate - glob.startDate)/86400);
    glob.days    = Math.floor((glob.endDate - glob.now ) / 86400);
    glob.hours   = 24 - Math.floor(((glob.endDate - glob.now) % 86400) / 3600);
    glob.minutes = 60 - Math.floor((((glob.endDate - glob.now) % 86400) % 3600) / 60) ;
    glob.seconds = 60 - Math.floor((glob.endDate - glob.now) % 86400 % 3600 % 60);

    if (glob.now >= glob.endDate) {
        return;
    }

    var clock = {
        set: {
            days: function(){
                var cdays = $("#canvas_days").get(0);
                var ctx = cdays.getContext("2d");
                ctx.clearRect(0, 0, cdays.width, cdays.height);
                ctx.beginPath();
                ctx.strokeStyle = glob.daysColor;

                ctx.shadowBlur    = 10;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 0;
                ctx.shadowColor = glob.daysGlow;

                ctx.arc(94/2,94/2,85/2, deg(0), deg((360/glob.total)*(glob.total - glob.days)));
                ctx.lineWidth = 17/2;
                ctx.stroke();
                $(".clock_days .val").text(glob.days);
            },

            hours: function(){
                var cHr = $("#canvas_hours").get(0);
                var ctx = cHr.getContext("2d");
                ctx.clearRect(0, 0, cHr.width, cHr.height);
                ctx.beginPath();
                ctx.strokeStyle = glob.hoursColor;

                ctx.shadowBlur    = 10;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 0;
                ctx.shadowColor = glob.hoursGlow;

                ctx.arc(94/2,94/2,85/2, deg(0), deg(15*glob.hours));
                ctx.lineWidth = 17/2;
                ctx.stroke();
                $(".clock_hours .val").text(24 - glob.hours);
            },

            minutes : function(){
                var cMin = $("#canvas_minutes").get(0);
                var ctx = cMin.getContext("2d");
                ctx.clearRect(0, 0, cMin.width, cMin.height);
                ctx.beginPath();
                ctx.strokeStyle = glob.minutesColor;

                ctx.shadowBlur    = 10;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 0;
                ctx.shadowColor = glob.minutesGlow;

                ctx.arc(94/2,94/2,85/2, deg(0), deg(6*glob.minutes));
                ctx.lineWidth = 17/2;
                ctx.stroke();
                $(".clock_minutes .val").text(60 - glob.minutes);
            },
            seconds: function(){
                var cSec = $("#canvas_seconds").get(0);
                var ctx = cSec.getContext("2d");
                ctx.clearRect(0, 0, cSec.width, cSec.height);
                ctx.beginPath();
                ctx.strokeStyle = glob.secondsColor;

                ctx.shadowBlur    = 10;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 0;
                ctx.shadowColor = glob.secondsGlow;

                ctx.arc(94/2,94/2,85/2, deg(0), deg(6*glob.seconds));
                ctx.lineWidth = 17/2;
                ctx.stroke();

                $(".clock_seconds .val").text(60 - glob.seconds);
            }
        },

        start: function(){
            /* Seconds */
            var cdown = setInterval(function(){
                if ( glob.seconds > 59 ) {
                    if (60 - glob.minutes == 0 && 24 - glob.hours == 0 && glob.days == 0) {
                        clearInterval(cdown);

                        /* Countdown is complete */

                        return;
                    }
                    glob.seconds = 1;
                    if (glob.minutes > 59) {
                        glob.minutes = 1;
                        clock.set.minutes();
                        if (glob.hours > 23) {
                            glob.hours = 1;
                            if (glob.days > 0) {
                                glob.days--;
                                clock.set.days();
                            }
                        } else {
                            glob.hours++;
                        }
                        clock.set.hours();
                    } else {
                        glob.minutes++;
                    }
                    clock.set.minutes();
                } else {
                    glob.seconds++;
                }
                clock.set.seconds();
            },1000);
        }
    }
    clock.set.seconds();
    clock.set.minutes();
    clock.set.hours();
    clock.set.days();
    clock.start();
}
/* Modernizr 2.6.2 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransforms3d-shiv-cssclasses-teststyles-testprop-testallprops-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function z(a){j.cssText=a}function A(a,b){return z(m.join(a+";")+(b||""))}function B(a,b){return typeof a===b}function C(a,b){return!!~(""+a).indexOf(b)}function D(a,b){for(var d in a){var e=a[d];if(!C(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function E(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:B(f,"function")?f.bind(d||b):f}return!1}function F(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+o.join(d+" ")+d).split(" ");return B(b,"string")||B(b,"undefined")?D(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),E(e,b,c))}var d="2.6.2",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={},r={},s={},t=[],u=t.slice,v,w=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},x={}.hasOwnProperty,y;!B(x,"undefined")&&!B(x.call,"undefined")?y=function(a,b){return x.call(a,b)}:y=function(a,b){return b in a&&B(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=u.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(u.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(u.call(arguments)))};return e}),q.csstransforms3d=function(){var a=!!F("perspective");return a&&"webkitPerspective"in g.style&&w("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(b,c){a=b.offsetLeft===9&&b.offsetHeight===3}),a};for(var G in q)y(q,G)&&(v=G.toLowerCase(),e[v]=q[G](),t.push((e[v]?"":"no-")+v));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)y(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},z(""),i=k=null,function(a,b){function k(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function l(){var a=r.elements;return typeof a=="string"?a.split(" "):a}function m(a){var b=i[a[g]];return b||(b={},h++,a[g]=h,i[h]=b),b}function n(a,c,f){c||(c=b);if(j)return c.createElement(a);f||(f=m(c));var g;return f.cache[a]?g=f.cache[a].cloneNode():e.test(a)?g=(f.cache[a]=f.createElem(a)).cloneNode():g=f.createElem(a),g.canHaveChildren&&!d.test(a)?f.frag.appendChild(g):g}function o(a,c){a||(a=b);if(j)return a.createDocumentFragment();c=c||m(a);var d=c.frag.cloneNode(),e=0,f=l(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function p(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return r.shivMethods?n(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+l().join().replace(/\w+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(r,b.frag)}function q(a){a||(a=b);var c=m(a);return r.shivCSS&&!f&&!c.hasCSS&&(c.hasCSS=!!k(a,"article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")),j||p(a,c),a}var c=a.html5||{},d=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,e=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,f,g="_html5shiv",h=0,i={},j;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",f="hidden"in a,j=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){f=!0,j=!0}})();var r={elements:c.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:c.shivCSS!==!1,supportsUnknownElements:j,shivMethods:c.shivMethods!==!1,type:"default",shivDocument:q,createElement:n,createDocumentFragment:o};a.html5=r,q(b)}(this,b),e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.testProp=function(a){return D([a])},e.testAllProps=F,e.testStyles=w,g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+t.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};

(function(){var d=null;function e(a){return function(b){this[a]=b}}function h(a){return function(){return this[a]}}var j;
    function k(a,b,c){this.extend(k,google.maps.OverlayView);this.c=a;this.a=[];this.f=[];this.ca=[53,56,66,78,90];this.j=[];this.A=!1;c=c||{};this.g=c.gridSize||60;this.l=c.minimumClusterSize||2;this.J=c.maxZoom||d;this.j=c.styles||[];this.X=c.imagePath||this.Q;this.W=c.imageExtension||this.P;this.O=!0;if(c.zoomOnClick!=void 0)this.O=c.zoomOnClick;this.r=!1;if(c.averageCenter!=void 0)this.r=c.averageCenter;l(this);this.setMap(a);this.K=this.c.getZoom();var f=this;google.maps.event.addListener(this.c,
        "zoom_changed",function(){var a=f.c.getZoom();if(f.K!=a)f.K=a,f.m()});google.maps.event.addListener(this.c,"idle",function(){f.i()});b&&b.length&&this.C(b,!1)}j=k.prototype;j.Q="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m";j.P="png";j.extend=function(a,b){return function(a){for(var b in a.prototype)this.prototype[b]=a.prototype[b];return this}.apply(a,[b])};j.onAdd=function(){if(!this.A)this.A=!0,n(this)};j.draw=function(){};
    function l(a){if(!a.j.length)for(var b=0,c;c=a.ca[b];b++)a.j.push({url:a.X+(b+1)+"."+a.W,height:c,width:c})}j.S=function(){for(var a=this.o(),b=new google.maps.LatLngBounds,c=0,f;f=a[c];c++)b.extend(f.getPosition());this.c.fitBounds(b)};j.z=h("j");j.o=h("a");j.V=function(){return this.a.length};j.ba=e("J");j.I=h("J");j.G=function(a,b){for(var c=0,f=a.length,g=f;g!==0;)g=parseInt(g/10,10),c++;c=Math.min(c,b);return{text:f,index:c}};j.$=e("G");j.H=h("G");
    j.C=function(a,b){for(var c=0,f;f=a[c];c++)q(this,f);b||this.i()};function q(a,b){b.s=!1;b.draggable&&google.maps.event.addListener(b,"dragend",function(){b.s=!1;a.L()});a.a.push(b)}j.q=function(a,b){q(this,a);b||this.i()};function r(a,b){var c=-1;if(a.a.indexOf)c=a.a.indexOf(b);else for(var f=0,g;g=a.a[f];f++)if(g==b){c=f;break}if(c==-1)return!1;b.setMap(d);a.a.splice(c,1);return!0}j.Y=function(a,b){var c=r(this,a);return!b&&c?(this.m(),this.i(),!0):!1};
    j.Z=function(a,b){for(var c=!1,f=0,g;g=a[f];f++)g=r(this,g),c=c||g;if(!b&&c)return this.m(),this.i(),!0};j.U=function(){return this.f.length};j.getMap=h("c");j.setMap=e("c");j.w=h("g");j.aa=e("g");
    j.v=function(a){var b=this.getProjection(),c=new google.maps.LatLng(a.getNorthEast().lat(),a.getNorthEast().lng()),f=new google.maps.LatLng(a.getSouthWest().lat(),a.getSouthWest().lng()),c=b.fromLatLngToDivPixel(c);c.x+=this.g;c.y-=this.g;f=b.fromLatLngToDivPixel(f);f.x-=this.g;f.y+=this.g;c=b.fromDivPixelToLatLng(c);b=b.fromDivPixelToLatLng(f);a.extend(c);a.extend(b);return a};j.R=function(){this.m(!0);this.a=[]};
    j.m=function(a){for(var b=0,c;c=this.f[b];b++)c.remove();for(b=0;c=this.a[b];b++)c.s=!1,a&&c.setMap(d);this.f=[]};j.L=function(){var a=this.f.slice();this.f.length=0;this.m();this.i();window.setTimeout(function(){for(var b=0,c;c=a[b];b++)c.remove()},0)};j.i=function(){n(this)};
    function n(a){if(a.A)for(var b=a.v(new google.maps.LatLngBounds(a.c.getBounds().getSouthWest(),a.c.getBounds().getNorthEast())),c=0,f;f=a.a[c];c++)if(!f.s&&b.contains(f.getPosition())){for(var g=a,u=4E4,o=d,v=0,m=void 0;m=g.f[v];v++){var i=m.getCenter();if(i){var p=f.getPosition();if(!i||!p)i=0;else var w=(p.lat()-i.lat())*Math.PI/180,x=(p.lng()-i.lng())*Math.PI/180,i=Math.sin(w/2)*Math.sin(w/2)+Math.cos(i.lat()*Math.PI/180)*Math.cos(p.lat()*Math.PI/180)*Math.sin(x/2)*Math.sin(x/2),i=6371*2*Math.atan2(Math.sqrt(i),
        Math.sqrt(1-i));i<u&&(u=i,o=m)}}o&&o.F.contains(f.getPosition())?o.q(f):(m=new s(g),m.q(f),g.f.push(m))}}function s(a){this.k=a;this.c=a.getMap();this.g=a.w();this.l=a.l;this.r=a.r;this.d=d;this.a=[];this.F=d;this.n=new t(this,a.z(),a.w())}j=s.prototype;
    j.q=function(a){var b;a:if(this.a.indexOf)b=this.a.indexOf(a)!=-1;else{b=0;for(var c;c=this.a[b];b++)if(c==a){b=!0;break a}b=!1}if(b)return!1;if(this.d){if(this.r)c=this.a.length+1,b=(this.d.lat()*(c-1)+a.getPosition().lat())/c,c=(this.d.lng()*(c-1)+a.getPosition().lng())/c,this.d=new google.maps.LatLng(b,c),y(this)}else this.d=a.getPosition(),y(this);a.s=!0;this.a.push(a);b=this.a.length;b<this.l&&a.getMap()!=this.c&&a.setMap(this.c);if(b==this.l)for(c=0;c<b;c++)this.a[c].setMap(d);b>=this.l&&a.setMap(d);
        a=this.c.getZoom();if((b=this.k.I())&&a>b)for(a=0;b=this.a[a];a++)b.setMap(this.c);else if(this.a.length<this.l)z(this.n);else{b=this.k.H()(this.a,this.k.z().length);this.n.setCenter(this.d);a=this.n;a.B=b;a.ga=b.text;a.ea=b.index;if(a.b)a.b.innerHTML=b.text;b=Math.max(0,a.B.index-1);b=Math.min(a.j.length-1,b);b=a.j[b];a.da=b.url;a.h=b.height;a.p=b.width;a.M=b.textColor;a.e=b.anchor;a.N=b.textSize;a.D=b.backgroundPosition;this.n.show()}return!0};
    j.getBounds=function(){for(var a=new google.maps.LatLngBounds(this.d,this.d),b=this.o(),c=0,f;f=b[c];c++)a.extend(f.getPosition());return a};j.remove=function(){this.n.remove();this.a.length=0;delete this.a};j.T=function(){return this.a.length};j.o=h("a");j.getCenter=h("d");function y(a){a.F=a.k.v(new google.maps.LatLngBounds(a.d,a.d))}j.getMap=h("c");
    function t(a,b,c){a.k.extend(t,google.maps.OverlayView);this.j=b;this.fa=c||0;this.u=a;this.d=d;this.c=a.getMap();this.B=this.b=d;this.t=!1;this.setMap(this.c)}j=t.prototype;
    j.onAdd=function(){this.b=document.createElement("DIV");if(this.t)this.b.style.cssText=A(this,B(this,this.d)),this.b.innerHTML=this.B.text;this.getPanes().overlayMouseTarget.appendChild(this.b);var a=this;google.maps.event.addDomListener(this.b,"click",function(){var b=a.u.k;google.maps.event.trigger(b,"clusterclick",a.u);b.O&&a.c.fitBounds(a.u.getBounds())})};function B(a,b){var c=a.getProjection().fromLatLngToDivPixel(b);c.x-=parseInt(a.p/2,10);c.y-=parseInt(a.h/2,10);return c}
    j.draw=function(){if(this.t){var a=B(this,this.d);this.b.style.top=a.y+"px";this.b.style.left=a.x+"px"}};function z(a){if(a.b)a.b.style.display="none";a.t=!1}j.show=function(){if(this.b)this.b.style.cssText=A(this,B(this,this.d)),this.b.style.display="";this.t=!0};j.remove=function(){this.setMap(d)};j.onRemove=function(){if(this.b&&this.b.parentNode)z(this),this.b.parentNode.removeChild(this.b),this.b=d};j.setCenter=e("d");
    function A(a,b){var c=[];c.push("background-image:url("+a.da+");");c.push("background-position:"+(a.D?a.D:"0 0")+";");typeof a.e==="object"?(typeof a.e[0]==="number"&&a.e[0]>0&&a.e[0]<a.h?c.push("height:"+(a.h-a.e[0])+"px; padding-top:"+a.e[0]+"px;"):c.push("height:"+a.h+"px; line-height:"+a.h+"px;"),typeof a.e[1]==="number"&&a.e[1]>0&&a.e[1]<a.p?c.push("width:"+(a.p-a.e[1])+"px; padding-left:"+a.e[1]+"px;"):c.push("width:"+a.p+"px; text-align:center;")):c.push("height:"+a.h+"px; line-height:"+a.h+
        "px; width:"+a.p+"px; text-align:center;");c.push("cursor:pointer; top:"+b.y+"px; left:"+b.x+"px; color:"+(a.M?a.M:"black")+"; position:absolute; font-size:"+(a.N?a.N:11)+"px; font-family:Arial,sans-serif; font-weight:bold");return c.join("")}window.MarkerClusterer=k;k.prototype.addMarker=k.prototype.q;k.prototype.addMarkers=k.prototype.C;k.prototype.clearMarkers=k.prototype.R;k.prototype.fitMapToMarkers=k.prototype.S;k.prototype.getCalculator=k.prototype.H;k.prototype.getGridSize=k.prototype.w;
    k.prototype.getExtendedBounds=k.prototype.v;k.prototype.getMap=k.prototype.getMap;k.prototype.getMarkers=k.prototype.o;k.prototype.getMaxZoom=k.prototype.I;k.prototype.getStyles=k.prototype.z;k.prototype.getTotalClusters=k.prototype.U;k.prototype.getTotalMarkers=k.prototype.V;k.prototype.redraw=k.prototype.i;k.prototype.removeMarker=k.prototype.Y;k.prototype.removeMarkers=k.prototype.Z;k.prototype.resetViewport=k.prototype.m;k.prototype.repaint=k.prototype.L;k.prototype.setCalculator=k.prototype.$;
    k.prototype.setGridSize=k.prototype.aa;k.prototype.setMaxZoom=k.prototype.ba;k.prototype.onAdd=k.prototype.onAdd;k.prototype.draw=k.prototype.draw;s.prototype.getCenter=s.prototype.getCenter;s.prototype.getSize=s.prototype.T;s.prototype.getMarkers=s.prototype.o;t.prototype.onAdd=t.prototype.onAdd;t.prototype.draw=t.prototype.draw;t.prototype.onRemove=t.prototype.onRemove;
})();

// Sticky Plugin v1.0.0 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Created: 2/14/2011
// Date: 2/12/2012
// Website: http://labs.anthonygarand.com/sticky
// Description: Makes an element on the page stick on the screen as you scroll
//       It will only set the 'top' and 'position' of your element, you
//       might need to adjust the width in some cases.

(function($) {
    var defaults = {
            topSpacing: 0,
            bottomSpacing: 0,
            className: 'is-sticky',
            wrapperClassName: 'sticky-wrapper',
            center: false,
            getWidthFrom: ''
        },
        $window = $(window),
        $document = $(document),
        sticked = [],
        windowHeight = $window.height(),
        scroller = function() {
            var scrollTop = $window.scrollTop(),
                documentHeight = $document.height(),
                dwh = documentHeight - windowHeight,
                extra = (scrollTop > dwh) ? dwh - scrollTop : 0;

            for (var i = 0; i < sticked.length; i++) {
                var s = sticked[i],
                    elementTop = s.stickyWrapper.offset().top,
                    etse = elementTop - s.topSpacing - extra;

                if (scrollTop <= etse) {
                    if (s.currentTop !== null) {
                        s.stickyElement
                            .css('position', '')
                            .css('top', '');
                        s.stickyElement.parent().removeClass(s.className);
                        s.currentTop = null;
                    }
                }
                else {
                    var newTop = documentHeight - s.stickyElement.outerHeight()
                        - s.topSpacing - s.bottomSpacing - scrollTop - extra;
                    if (newTop < 0) {
                        newTop = newTop + s.topSpacing;
                    } else {
                        newTop = s.topSpacing;
                    }
                    if (s.currentTop != newTop) {
                        s.stickyElement
                            .css('position', 'fixed')
                            .css('top', newTop);

                        if (typeof s.getWidthFrom !== 'undefined') {
                            s.stickyElement.css('width', $(s.getWidthFrom).width());
                        }

                        s.stickyElement.parent().addClass(s.className);
                        s.currentTop = newTop;
                    }
                }
            }
        },
        resizer = function() {
            windowHeight = $window.height();
        },
        methods = {
            init: function(options) {
                var o = $.extend(defaults, options);
                return this.each(function() {
                    var stickyElement = $(this);

                    var stickyId = stickyElement.attr('id');
                    var wrapper = $('<div></div>')
                        .attr('id', stickyId + '-sticky-wrapper')
                        .addClass(o.wrapperClassName);
                    stickyElement.wrapAll(wrapper);

                    if (o.center) {
                        stickyElement.parent().css({width:stickyElement.outerWidth(),marginLeft:"auto",marginRight:"auto"});
                    }

                    if (stickyElement.css("float") == "right") {
                        stickyElement.css({"float":"none"}).parent().css({"float":"right"});
                    }

                    var stickyWrapper = stickyElement.parent();
                    stickyWrapper.css('height', stickyElement.outerHeight());
                    sticked.push({
                        topSpacing: o.topSpacing,
                        bottomSpacing: o.bottomSpacing,
                        stickyElement: stickyElement,
                        currentTop: null,
                        stickyWrapper: stickyWrapper,
                        className: o.className,
                        getWidthFrom: o.getWidthFrom
                    });
                });
            },
            update: scroller
        };

    // should be more efficient than using $window.scroll(scroller) and $window.resize(resizer):
    if (window.addEventListener) {
        window.addEventListener('scroll', scroller, false);
        window.addEventListener('resize', resizer, false);
    } else if (window.attachEvent) {
        window.attachEvent('onscroll', scroller);
        window.attachEvent('onresize', resizer);
    }

    $.fn.sticky = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.sticky');
        }
    };
    $(function() {
        setTimeout(scroller, 0);
    });
})(jQuery);


(function ($) {
    $.fn.tipTip = function (options) {
        var defaults = {activation: "hover", keepAlive: false, maxWidth: "200px", edgeOffset: 3, defaultPosition: "bottom", delay: 400, fadeIn: 200, fadeOut: 200, attribute: "title", content: false, enter: function () {
        }, exit: function () {
        }};
        var opts = $.extend(defaults, options);
        if ($("#tiptip_holder").length <= 0) {
            var tiptip_holder = $('<div id="tiptip_holder" style="max-width:' + opts.maxWidth + ';"></div>');
            var tiptip_content = $('<div id="tiptip_content"></div>');
            var tiptip_arrow = $('<div id="tiptip_arrow"></div>');
            var tiptip_closer = $('<span class="closeTipp"></span>');
            $("body").append(tiptip_holder.html(tiptip_content).prepend(tiptip_arrow.html('<div id="tiptip_arrow_inner"></div>')));
        } else {
            var tiptip_holder = $("#tiptip_holder");
            var tiptip_closer = $(".closeTipp");
            var tiptip_content = $("#tiptip_content");
            var tiptip_arrow = $("#tiptip_arrow");
        }
        return this.each(function () {

            var org_elem = $(this);
            if (opts.content) {
                var org_title = opts.content;
            } else {
                var org_title = org_elem.attr(opts.attribute);
            }

            if (org_title != "") {
                if (!opts.content) {
                    org_elem.removeAttr(opts.attribute);
                }

                var timeout = false;

                if (opts.activation == "hover") {

                    org_elem.hover(function() {
                        active_tiptip();
                    }, function() {
                        if(!opts.keepAlive) { deactive_tiptip(); }
                    });

                    if(opts.keepAlive) {
                        tiptip_holder.hover(function() {}, function() { deactive_tiptip(); });
                        tiptip_closer.hover(function() { deactive_tiptip(); });
                    }
                } else {
                    if (opts.activation == "focus") {
                        org_elem.focus(function () {
                            active_tiptip();
                        }).blur(function () {
                            deactive_tiptip();
                        });
                    } else {
                        if (opts.activation == "click") {
                            org_elem.click(function () {
                                active_tiptip();
                                return false;
                            }).hover(function () {
                            }, function () {
                                if (!opts.keepAlive) {
                                    deactive_tiptip();
                                }
                            });
                            if (opts.keepAlive) {
                                tiptip_holder.hover(function () {
                                }, function () {
                                    deactive_tiptip();
                                });
                            }
                        }
                    }
                }
                function active_tiptip() {

                    opts.enter.call(this);
                    tiptip_content.html(org_title);
                    tiptip_holder.hide().removeAttr("class").css("margin", "0");
                    tiptip_arrow.removeAttr("style");
                    var top = parseInt(org_elem.offset()["top"]);
                    var left = parseInt(org_elem.offset()["left"]);
                    var org_width = parseInt(org_elem.outerWidth());
                    var org_height = parseInt(org_elem.outerHeight());
                    var tip_w = tiptip_holder.outerWidth();
                    var tip_h = tiptip_holder.outerHeight();
                    var w_compare = Math.round((org_width - tip_w) / 2);
                    var h_compare = Math.round((org_height - tip_h) / 2);
                    var marg_left = Math.round(left + w_compare);
                    var marg_top = Math.round(top + org_height + opts.edgeOffset);
                    var t_class = "";
                    var arrow_top = "";
                    var arrow_left = Math.round(tip_w - 12) / 2;
                    if (opts.defaultPosition == "bottom") {
                        t_class = "_bottom";
                    } else {
                        if (opts.defaultPosition == "top") {
                            t_class = "_top";
                        } else {
                            if (opts.defaultPosition == "left") {
                                t_class = "_left";
                            } else {
                                if (opts.defaultPosition == "right") {
                                    t_class = "_right";
                                }
                            }
                        }
                    }
                    var right_compare = (w_compare + left) < parseInt($(window).scrollLeft());
                    var left_compare = (tip_w + left) > parseInt($(window).width());
                    if ((right_compare && w_compare < 0) || (t_class == "_right" && !left_compare) || (t_class == "_left" && left < (tip_w + opts.edgeOffset + 5))) {
                        t_class = "_right";
                        arrow_top = Math.round(tip_h - 13) / 2;
                        arrow_left = -12;
                        marg_left = Math.round(left + org_width + opts.edgeOffset);
                        marg_top = Math.round(top + h_compare);
                    } else {
                        if ((left_compare && w_compare < 0) || (t_class == "_left" && !right_compare)) {
                            t_class = "_left";
                            arrow_top = Math.round(tip_h - 13) / 2;
                            arrow_left = Math.round(tip_w);
                            marg_left = Math.round(left - (tip_w + opts.edgeOffset + 5));
                            marg_top = Math.round(top + h_compare);
                        }
                    }
                    var top_compare = (top + org_height + opts.edgeOffset + tip_h + 8) > parseInt($(window).height() + $(window).scrollTop());
                    var bottom_compare = ((top + org_height) - (opts.edgeOffset + tip_h + 8)) < 0;
                    if (top_compare || (t_class == "_bottom" && top_compare) || (t_class == "_top" && !bottom_compare)) {
                        if (t_class == "_top" || t_class == "_bottom") {
                            t_class = "_top";
                        } else {
                            t_class = t_class + "_top";
                        }
                        arrow_top = tip_h;
                        marg_top = Math.round(top - (tip_h + 5 + opts.edgeOffset));
                    } else {
                        if (bottom_compare | (t_class == "_top" && bottom_compare) || (t_class == "_bottom" && !top_compare)) {
                            if (t_class == "_top" || t_class == "_bottom") {
                                t_class = "_bottom";
                            } else {
                                t_class = t_class + "_bottom";
                            }
                            arrow_top = -12;
                            marg_top = Math.round(top + org_height + opts.edgeOffset);
                        }
                    }
                    if (t_class == "_right_top" || t_class == "_left_top") {
                        marg_top = marg_top + 5;
                    } else {
                        if (t_class == "_right_bottom" || t_class == "_left_bottom") {
                            marg_top = marg_top - 5;
                        }
                    }
                    if (t_class == "_left_top" || t_class == "_left_bottom") {
                        marg_left = marg_left + 5;
                    }
                    tiptip_arrow.css({"margin-left": arrow_left + "px", "margin-top": arrow_top + "px"});
                    tiptip_holder.css({"margin-left": marg_left + "px", "margin-top": marg_top + "px"}).attr("class", "tip" + t_class);
                    if (timeout) {
                        clearTimeout(timeout);
                    }
                    timeout = setTimeout(function () {
                        tiptip_holder.stop(true, true).fadeIn(opts.fadeIn);
                    }, opts.delay);
                }

                function deactive_tiptip() {
                    opts.exit.call(this);
                    if (timeout) {
                        clearTimeout(timeout);
                    }
                    tiptip_holder.fadeOut(opts.fadeOut);
                }
            }
        });
    };
})(jQuery);

/*

 Quicksand 1.3

 Reorder and filter items with a nice shuffling animation.

 Copyright (c) 2010 Jacek Galanciak (razorjack.net) and agilope.com
 Big thanks for Piotr Petrus (riddle.pl) for deep code review and wonderful docs & demos.

 Dual licensed under the MIT and GPL version 2 licenses.
 http://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt
 http://github.com/jquery/jquery/blob/master/GPL-LICENSE.txt

 Project site: http://razorjack.net/quicksand
 Github site: http://github.com/razorjack/quicksand

 */

(function($) {
    $.fn.quicksand = function(collection, customOptions) {
        var options = {
            duration : 750,
            easing : 'swing',
            attribute : 'data-id',        // attribute to recognize same items within source and dest
            adjustHeight : 'auto',        // 'dynamic' animates height during shuffling (slow), 'auto' adjusts it
            // before or after the animation, false leaves height constant
            adjustWidth : 'auto',         // 'dynamic' animates width during shuffling (slow),
            // 'auto' adjusts it before or after the animation, false leaves width constant
            useScaling : false,           // enable it if you're using scaling effect
            enhancement : function(c) {}, // Visual enhacement (eg. font replacement) function for cloned elements
            selector : '> *',
            atomic : false,
            dx : 0,
            dy : 0,
            maxWidth : 0,
            retainExisting : true         // disable if you want the collection of items to be replaced completely by incoming items.
        };
        $.extend(options, customOptions);

        // Got IE and want scaling effect? Kiss my ass.
        if (navigator.appName == 'Microsoft Internet Explorer' || (typeof ($.fn.scale) == 'undefined')) {
            options.useScaling = false;
        }

        var callbackFunction;
        if (typeof (arguments[1]) == 'function') {
            callbackFunction = arguments[1];
        } else if (typeof (arguments[2] == 'function')) {
            callbackFunction = arguments[2];
        }

        return this.each(function(i) {
            var val;
            var animationQueue = []; // used to store all the animation params before starting the animation;
            // solves initial animation slowdowns
            var $collection;
            if (typeof(options.attribute) == 'function') {
                $collection = $(collection);
            } else {
                $collection = $(collection).filter('[' + options.attribute + ']').clone(); // destination (target) collection
            }
            var $sourceParent = $(this); // source, the visible container of source collection
            var sourceHeight = $(this).css('height'); // used to keep height and document flow during the animation
            var sourceWidth = $(this).css('width'); // used to keep  width and document flow during the animation
            var destHeight, destWidth;
            var adjustHeightOnCallback = false;
            var adjustWidthOnCallback = false;
            var offset = $($sourceParent).offset(); // offset of visible container, used in animation calculations
            var offsets = []; // coordinates of every source collection item
            var $source = $(this).find(options.selector); // source collection items
            var width = $($source).innerWidth(); // need for the responsive design

            // Replace the collection and quit if IE6
            /*if (navigator.appName && parseInt($.browser.version, 10) < 7) {
             $sourceParent.html('').append($collection);
             return;
             }*/

            // Gets called when any animation is finished
            var postCallbackPerformed = 0; // prevents the function from being called more than one time
            var postCallback = function() {
                $(this).css('margin', '').css('position', '').css('top', '').css('left', '').css('opacity', '');
                if (!postCallbackPerformed) {
                    postCallbackPerformed = 1;

                    if (!options.atomic) {
                        // hack: used to be: $sourceParent.html($dest.html());
                        // put target HTML into visible source container
                        // but new webkit builds cause flickering when replacing the collections
                        var $toDelete = $sourceParent.find(options.selector);
                        if (!options.retainExisting) {
                            $sourceParent.prepend($dest.find(options.selector));
                            $toDelete.remove();
                        } else {
                            // Avoid replacing elements because we may have already altered items in significant
                            // ways and it would be bad to have to do it again. (i.e. lazy load images)
                            // But $dest holds the correct ordering. So we must re-sequence items in $sourceParent to match.
                            var $keepElements = $([]);
                            $dest.find(options.selector).each(function(i) {
                                var $matchedElement = $([]);
                                if (typeof (options.attribute) == 'function') {
                                    var val = options.attribute($(this));
                                    $toDelete.each(function() {
                                        if (options.attribute(this) == val) {
                                            $matchedElement = $(this);
                                            return false;
                                        }
                                    });
                                } else {
                                    $matchedElement = $toDelete.filter(
                                        '[' + options.attribute + '="'+
                                            $(this).attr(options.attribute) + '"]');
                                }
                                if ($matchedElement.length > 0) {
                                    // There is a matching element in the $toDelete list and in $dest
                                    // list, so make sure it is in the right location within $sourceParent
                                    // and put it in the list of elements we need to not delete.
                                    $keepElements = $keepElements.add($matchedElement);
                                    if (i === 0) {
                                        $sourceParent.prepend($matchedElement);
                                    } else {
                                        $matchedElement.insertAfter($sourceParent.find(options.selector).get(i - 1));
                                    }
                                }
                            });
                            // Remove whatever is remaining from the DOM
                            $toDelete.not($keepElements).remove();
                        }

                        if (adjustHeightOnCallback) {
                            $sourceParent.css('height', destHeight);
                        }
                        if (adjustWidthOnCallback) {
                            $sourceParent.css('width', sourceWidth);
                        }
                    }
                    options.enhancement($sourceParent); // Perform custom visual enhancements on a newly replaced collection
                    if (typeof callbackFunction == 'function') {
                        callbackFunction.call(this);
                    }
                }

                if (false === options.adjustHeight) {
                    $sourceParent.css('height', 'auto');
                }

                if (false === options.adjustWidth) {
                    $sourceParent.css('width', 'auto');
                }
            };

            // Position: relative situations
            var $correctionParent = $sourceParent.offsetParent();
            var correctionOffset = $correctionParent.offset();
            if ($correctionParent.css('position') == 'relative') {
                if ($correctionParent.get(0).nodeName.toLowerCase() != 'body') {
                    correctionOffset.top += (parseFloat($correctionParent.css('border-top-width')) || 0);
                    correctionOffset.left += (parseFloat($correctionParent.css('border-left-width')) || 0);
                }
            } else {
                correctionOffset.top -= (parseFloat($correctionParent.css('border-top-width')) || 0);
                correctionOffset.left -= (parseFloat($correctionParent.css('border-left-width')) || 0);
                correctionOffset.top -= (parseFloat($correctionParent.css('margin-top')) || 0);
                correctionOffset.left -= (parseFloat($correctionParent.css('margin-left')) || 0);
            }

            // perform custom corrections from options (use when Quicksand fails to detect proper correction)
            if (isNaN(correctionOffset.left)) {
                correctionOffset.left = 0;
            }
            if (isNaN(correctionOffset.top)) {
                correctionOffset.top = 0;
            }

            correctionOffset.left -= options.dx;
            correctionOffset.top -= options.dy;

            // keeps nodes after source container, holding their position
            $sourceParent.css('height', $(this).height());
            $sourceParent.css('width', $(this).width());

            // get positions of source collections
            $source.each(function(i) {
                offsets[i] = $(this).offset();
            });

            // stops previous animations on source container
            $(this).stop();
            var dx = 0;
            var dy = 0;
            $source.each(function(i) {
                $(this).stop(); // stop animation of collection items
                var rawObj = $(this).get(0);
                if (rawObj.style.position == 'absolute') {
                    dx = -options.dx;
                    dy = -options.dy;
                } else {
                    dx = options.dx;
                    dy = options.dy;
                }

                rawObj.style.position = 'absolute';
                rawObj.style.margin = '0';

                if (!options.adjustWidth) {
                    rawObj.style.width = (width + 'px'); // sets the width to the current element
                    // with even if it has been changed
                    // by a responsive design
                }

                rawObj.style.top = (offsets[i].top- parseFloat(rawObj.style.marginTop) - correctionOffset.top + dy) + 'px';
                rawObj.style.left = (offsets[i].left- parseFloat(rawObj.style.marginLeft) - correctionOffset.left + dx) + 'px';

                if (options.maxWidth > 0 && offsets[i].left > options.maxWidth) {
                    rawObj.style.display = 'none';
                }
            });

            // create temporary container with destination collection
            var $dest = $($sourceParent).clone();
            var rawDest = $dest.get(0);
            rawDest.innerHTML = '';
            rawDest.setAttribute('id', '');
            rawDest.style.height = 'auto';
            rawDest.style.width = $sourceParent.width() + 'px';
            $dest.append($collection);
            // Inserts node into HTML. Note that the node is under visible source container in the exactly same position
            // The browser render all the items without showing them (opacity: 0.0) No offset calculations are needed,
            // the browser just extracts position from underlayered destination items and sets animation to destination positions.
            $dest.insertBefore($sourceParent);
            $dest.css('opacity', 0.0);
            rawDest.style.zIndex = -1;

            rawDest.style.margin = '0';
            rawDest.style.position = 'absolute';
            rawDest.style.top = offset.top - correctionOffset.top + 'px';
            rawDest.style.left = offset.left - correctionOffset.left + 'px';

            if (options.adjustHeight === 'dynamic') {
                // If destination container has different height than source container the height can be animated,
                // adjusting it to destination height
                $sourceParent.animate({ height : $dest.height() }, options.duration, options.easing);
            } else if (options.adjustHeight === 'auto') {
                destHeight = $dest.height();
                if (parseFloat(sourceHeight) < parseFloat(destHeight)) {
                    // Adjust the height now so that the items don't move out of the container
                    $sourceParent.css('height', destHeight);
                } else {
                    // Adjust later, on callback
                    adjustHeightOnCallback = true;
                }
            }

            if (options.adjustWidth === 'dynamic') {
                // If destination container has different width than source container the width can be animated,
                // adjusting it to destination width
                $sourceParent.animate({ width : $dest.width() }, options.duration, options.easing);
            } else if (options.adjustWidth === 'auto') {
                destWidth = $dest.width();
                if (parseFloat(sourceWidth) < parseFloat(destWidth)) {
                    // Adjust the height now so that the items don't move out of the container
                    $sourceParent.css('width', destWidth);
                } else {
                    // Adjust later, on callback
                    adjustWidthOnCallback = true;
                }
            }

            // Now it's time to do shuffling animation. First of all, we need to identify same elements within
            // source and destination collections
            $source.each(function(i) {
                var destElement = [];
                if (typeof (options.attribute) == 'function') {
                    val = options.attribute($(this));
                    $collection.each(function() {
                        if (options.attribute(this) == val) {
                            destElement = $(this);
                            return false;
                        }
                    });
                } else {
                    destElement = $collection.filter('[' + options.attribute + '="' + $(this).attr(options.attribute) + '"]');
                }
                if (destElement.length) {
                    // The item is both in source and destination collections. It it's under different position, let's move it
                    if (!options.useScaling) {
                        animationQueue.push({
                            element : $(this), dest : destElement,
                            style : {
                                top : $(this).offset().top,
                                left : $(this).offset().left,
                                opacity : ""
                            },
                            animation : {
                                top : destElement.offset().top - correctionOffset.top,
                                left : destElement.offset().left - correctionOffset.left,
                                opacity : 1.0
                            }
                        });
                    } else {
                        animationQueue.push({
                            element : $(this), dest : destElement,
                            style : {
                                top : $(this).offset().top,
                                left : $(this).offset().left,
                                opacity : ""
                            },
                            animation : {
                                top : destElement.offset().top - correctionOffset.top,
                                left : destElement.offset().left - correctionOffset.left,
                                opacity : 1.0,
                                scale : '1.0'
                            }
                        });
                    }
                } else {
                    // The item from source collection is not present in destination collections.  Let's remove it
                    if (!options.useScaling) {
                        animationQueue.push({
                            element : $(this),
                            style : {
                                top : $(this).offset().top,
                                left : $(this).offset().left,
                                opacity : ""
                            },
                            animation : {
                                opacity : '0.0'
                            }
                        });
                    } else {
                        animationQueue.push({
                            element : $(this),
                            animation : {
                                opacity : '0.0',
                                style : {
                                    top : $(this).offset().top,
                                    left : $(this).offset().left,
                                    opacity : ""
                                },
                                scale : '0.0'
                            }
                        });
                    }
                }
            });

            $collection.each(function(i) {
                // Grab all items from target collection not present in visible source collection
                var sourceElement = [];
                var destElement = [];
                if (typeof (options.attribute) == 'function') {
                    val = options.attribute($(this));
                    $source.each(function() {
                        if (options.attribute(this) == val) {
                            sourceElement = $(this);
                            return false;
                        }
                    });

                    $collection.each(function() {
                        if (options.attribute(this) == val) {
                            destElement = $(this);
                            return false;
                        }
                    });
                } else {
                    sourceElement = $source.filter('[' + options.attribute + '="' + $(this).attr(options.attribute) + '"]');
                    destElement = $collection.filter('[' + options.attribute + '="' + $(this).attr(options.attribute) + '"]');
                }

                var animationOptions;
                if (sourceElement.length === 0 && destElement.length > 0) {

                    // No such element in source collection...
                    if (!options.useScaling) {
                        animationOptions = {opacity : '1.0'};
                    } else {
                        animationOptions = {opacity : '1.0', scale : '1.0'};
                    }

                    // Let's create it
                    var d = destElement.clone();
                    var rawDestElement = d.get(0);
                    rawDestElement.style.position = 'absolute';
                    rawDestElement.style.margin = '0';

                    if (!options.adjustWidth) {
                        // sets the width to the current element with even if it has been changed by a responsive design
                        rawDestElement.style.width = width + 'px';
                    }

                    rawDestElement.style.top = destElement.offset().top - correctionOffset.top + 'px';
                    rawDestElement.style.left = destElement.offset().left - correctionOffset.left + 'px';

                    d.css('opacity', 0.0); // IE

                    if (options.useScaling) {
                        d.css('transform', 'scale(0.0)');
                    }
                    d.appendTo($sourceParent);

                    if (options.maxWidth === 0 || destElement.offset().left < options.maxWidth) {
                        animationQueue.push({element : $(d), dest : destElement,animation : animationOptions});
                    }
                }
            });

            $dest.remove();
            if (!options.atomic) {
                options.enhancement($sourceParent); // Perform custom visual enhancements during the animation
                for (i = 0; i < animationQueue.length; i++) {
                    animationQueue[i].element.animate(animationQueue[i].animation, options.duration, options.easing, postCallback);
                }
            } else {
                $toDelete = $sourceParent.find(options.selector);
                $sourceParent.prepend($dest.find(options.selector));
                for (i = 0; i < animationQueue.length; i++) {
                    if (animationQueue[i].dest && animationQueue[i].style) {
                        var destElement = animationQueue[i].dest;
                        var destOffset = destElement.offset();

                        destElement.css({
                            position : 'relative',
                            top : (animationQueue[i].style.top - destOffset.top),
                            left : (animationQueue[i].style.left - destOffset.left)
                        });

                        destElement.animate({top : "0", left : "0"},
                            options.duration,
                            options.easing,
                            postCallback);
                    } else {
                        animationQueue[i].element.animate(animationQueue[i].animation,
                            options.duration,
                            options.easing,
                            postCallback);
                    }
                }
                $toDelete.remove();
            }
        });
    };
})(jQuery);

/*
 * jQuery EasyTabs plugin 3.1.1
 *
 * Copyright (c) 2010-2011 Steve Schwartz (JangoSteve)
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Date: Tue Jan 26 16:30:00 2012 -0500
 */
( function($) {

    $.easytabs = function(container, options) {

        // Attach to plugin anything that should be available via
        // the $container.data('easytabs') object
        var plugin = this,
            $container = $(container),

            defaults = {
                animate: true,
                panelActiveClass: "active",
                tabActiveClass: "active",
                defaultTab: "li:first-child",
                animationSpeed: "normal",
                tabs: "> ul > li",
                updateHash: true,
                cycle: false,
                collapsible: false,
                collapsedClass: "collapsed",
                collapsedByDefault: true,
                uiTabs: false,
                transitionIn: 'fadeIn',
                transitionOut: 'fadeOut',
                transitionInEasing: 'swing',
                transitionOutEasing: 'swing',
                transitionCollapse: 'slideUp',
                transitionUncollapse: 'slideDown',
                transitionCollapseEasing: 'swing',
                transitionUncollapseEasing: 'swing',
                containerClass: "",
                tabsClass: "",
                tabClass: "",
                panelClass: "",
                cache: true,
                panelContext: $container
            },

        // Internal instance variables
        // (not available via easytabs object)
            $defaultTab,
            $defaultTabLink,
            transitions,
            lastHash,
            skipUpdateToHash,
            animationSpeeds = {
                fast: 200,
                normal: 400,
                slow: 600
            },

        // Shorthand variable so that we don't need to call
        // plugin.settings throughout the plugin code
            settings;

        // =============================================================
        // Functions available via easytabs object
        // =============================================================

        plugin.init = function() {

            plugin.settings = settings = $.extend({}, defaults, options);

            // Add jQuery UI's crazy class names to markup,
            // so that markup will match theme CSS
            if ( settings.uiTabs ) {
                settings.tabActiveClass = 'ui-tabs-selected';
                settings.containerClass = 'ui-tabs ui-widget ui-widget-content ui-corner-all';
                settings.tabsClass = 'ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all';
                settings.tabClass = 'ui-state-default ui-corner-top';
                settings.panelClass = 'ui-tabs-panel ui-widget-content ui-corner-bottom';
            }

            // If collapsible is true and defaultTab specified, assume user wants defaultTab showing (not collapsed)
            if ( settings.collapsible && options.defaultTab !== undefined && options.collpasedByDefault === undefined ) {
                settings.collapsedByDefault = false;
            }

            // Convert 'normal', 'fast', and 'slow' animation speed settings to their respective speed in milliseconds
            if ( typeof(settings.animationSpeed) === 'string' ) {
                settings.animationSpeed = animationSpeeds[settings.animationSpeed];
            }

            $('a.anchor').remove().prependTo('body');

            // Store easytabs object on container so we can easily set
            // properties throughout
            $container.data('easytabs', {});

            plugin.setTransitions();

            plugin.getTabs();

            addClasses();

            setDefaultTab();

            bindToTabClicks();

            initHashChange();

            initCycle();

            // Append data-easytabs HTML attribute to make easy to query for
            // easytabs instances via CSS pseudo-selector
            $container.attr('data-easytabs', true);
        };

        // Set transitions for switching between tabs based on options.
        // Could be used to update transitions if settings are changes.
        plugin.setTransitions = function() {
            transitions = ( settings.animate ) ? {
                show: settings.transitionIn,
                hide: settings.transitionOut,
                speed: settings.animationSpeed,
                collapse: settings.transitionCollapse,
                uncollapse: settings.transitionUncollapse,
                halfSpeed: settings.animationSpeed / 2
            } :
            {
                show: "show",
                hide: "hide",
                speed: 0,
                collapse: "hide",
                uncollapse: "show",
                halfSpeed: 0
            };
        };

        // Find and instantiate tabs and panels.
        // Could be used to reset tab and panel collection if markup is
        // modified.
        plugin.getTabs = function() {
            var $matchingPanel;

            // Find the initial set of elements matching the setting.tabs
            // CSS selector within the container
            plugin.tabs = $container.find(settings.tabs),

                // Instantiate panels as empty jquery object
                plugin.panels = $(),

                plugin.tabs.each(function(){
                    var $tab = $(this),
                        $a = $tab.children('a'),

                    // targetId is the ID of the panel, which is either the
                    // `href` attribute for non-ajax tabs, or in the
                    // `data-target` attribute for ajax tabs since the `href` is
                    // the ajax URL
                        targetId = $tab.children('a').data('target');

                    $tab.data('easytabs', {});

                    // If the tab has a `data-target` attribute, and is thus an ajax tab
                    if ( targetId !== undefined && targetId !== null ) {
                        $tab.data('easytabs').ajax = $a.attr('href');
                    } else {
                        targetId = $a.attr('href');
                    }
                    targetId = targetId.match(/#([^\?]+)/)[0].substr(1);

                    $matchingPanel = settings.panelContext.find("#" + targetId);

                    // If tab has a matching panel, add it to panels
                    if ( $matchingPanel.length ) {

                        // Store panel height before hiding
                        $matchingPanel.data('easytabs', {
                            position: $matchingPanel.css('position'),
                            visibility: $matchingPanel.css('visibility')
                        });

                        // Don't hide panel if it's active (allows `getTabs` to be called manually to re-instantiate tab collection)
                        $matchingPanel.not(settings.panelActiveClass).hide();

                        plugin.panels = plugin.panels.add($matchingPanel);

                        $tab.data('easytabs').panel = $matchingPanel;

                        // Otherwise, remove tab from tabs collection
                    } else {
                        plugin.tabs = plugin.tabs.not($tab);
                    }
                });
        };

        // Select tab and fire callback
        plugin.selectTab = function($clicked, callback) {
            var url = window.location,
                hash = url.hash.match(/^[^\?]*/)[0],
                $targetPanel = $clicked.parent().data('easytabs').panel,
                ajaxUrl = $clicked.parent().data('easytabs').ajax;

            // Tab is collapsible and active => toggle collapsed state
            if( settings.collapsible && ! skipUpdateToHash && ($clicked.hasClass(settings.tabActiveClass) || $clicked.hasClass(settings.collapsedClass)) ) {
                plugin.toggleTabCollapse($clicked, $targetPanel, ajaxUrl, callback);

                // Tab is not active and panel is not active => select tab
            } else if( ! $clicked.hasClass(settings.tabActiveClass) || ! $targetPanel.hasClass(settings.panelActiveClass) ){
                activateTab($clicked, $targetPanel, ajaxUrl, callback);

                // Cache is disabled => reload (e.g reload an ajax tab).
            } else if ( ! settings.cache ){
                activateTab($clicked, $targetPanel, ajaxUrl, callback);
            }

        };

        // Toggle tab collapsed state and fire callback
        plugin.toggleTabCollapse = function($clicked, $targetPanel, ajaxUrl, callback) {
            plugin.panels.stop(true,true);

            if( fire($container,"easytabs:before", [$clicked, $targetPanel, settings]) ){
                plugin.tabs.filter("." + settings.tabActiveClass).removeClass(settings.tabActiveClass).children().removeClass(settings.tabActiveClass);

                // If panel is collapsed, uncollapse it
                if( $clicked.hasClass(settings.collapsedClass) ){

                    // If ajax panel and not already cached
                    if( ajaxUrl && (!settings.cache || !$clicked.parent().data('easytabs').cached) ) {
                        $container.trigger('easytabs:ajax:beforeSend', [$clicked, $targetPanel]);

                        $targetPanel.load(ajaxUrl, function(response, status, xhr){
                            $clicked.parent().data('easytabs').cached = true;
                            $container.trigger('easytabs:ajax:complete', [$clicked, $targetPanel, response, status, xhr]);
                        });
                    }

                    // Update CSS classes of tab and panel
                    $clicked.parent()
                        .removeClass(settings.collapsedClass)
                        .addClass(settings.tabActiveClass)
                        .children()
                        .removeClass(settings.collapsedClass)
                        .addClass(settings.tabActiveClass);

                    $targetPanel
                        .addClass(settings.panelActiveClass)
                        [transitions.uncollapse](transitions.speed, settings.transitionUncollapseEasing, function(){
                        $container.trigger('easytabs:midTransition', [$clicked, $targetPanel, settings]);
                        if(typeof callback == 'function') callback();
                    });

                    // Otherwise, collapse it
                } else {

                    // Update CSS classes of tab and panel
                    $clicked.addClass(settings.collapsedClass)
                        .parent()
                        .addClass(settings.collapsedClass);

                    $targetPanel
                        .removeClass(settings.panelActiveClass)
                        [transitions.collapse](transitions.speed, settings.transitionCollapseEasing, function(){
                        $container.trigger("easytabs:midTransition", [$clicked, $targetPanel, settings]);
                        if(typeof callback == 'function') callback();
                    });
                }
            }
        };


        // Find tab with target panel matching value
        plugin.matchTab = function(hash) {
            return plugin.tabs.find("[href='" + hash + "'],[data-target='" + hash + "']").first();
        };

        // Find panel with `id` matching value
        plugin.matchInPanel = function(hash) {
            return ( hash ? plugin.panels.filter(':has(' + hash + ')').first() : [] );
        };

        // Select matching tab when URL hash changes
        plugin.selectTabFromHashChange = function() {
            var hash = window.location.hash.match(/^[^\?]*/)[0],
                $tab = plugin.matchTab(hash),
                $panel;

            if ( settings.updateHash ) {

                // If hash directly matches tab
                if( $tab.length ){
                    skipUpdateToHash = true;
                    plugin.selectTab( $tab );

                } else {
                    $panel = plugin.matchInPanel(hash);

                    // If panel contains element matching hash
                    if ( $panel.length ) {
                        hash = '#' + $panel.attr('id');
                        $tab = plugin.matchTab(hash);
                        skipUpdateToHash = true;
                        plugin.selectTab( $tab );

                        // If default tab is not active...
                    } else if ( ! $defaultTab.hasClass(settings.tabActiveClass) && ! settings.cycle ) {

                        // ...and hash is blank or matches a parent of the tab container or
                        // if the last tab (before the hash updated) was one of the other tabs in this container.
                        if ( hash === '' || plugin.matchTab(lastHash).length || $container.closest(hash).length ) {
                            skipUpdateToHash = true;
                            plugin.selectTab( $defaultTabLink );
                        }
                    }
                }
            }
        };

        // Cycle through tabs
        plugin.cycleTabs = function(tabNumber){
            if(settings.cycle){
                tabNumber = tabNumber % plugin.tabs.length;
                $tab = $( plugin.tabs[tabNumber] ).children("a").first();
                skipUpdateToHash = true;
                plugin.selectTab( $tab, function() {
                    setTimeout(function(){ plugin.cycleTabs(tabNumber + 1); }, settings.cycle);
                });
            }
        };

        // Convenient public methods
        plugin.publicMethods = {
            select: function(tabSelector){
                var $tab;

                // Find tab container that matches selector (like 'li#tab-one' which contains tab link)
                if ( ($tab = plugin.tabs.filter(tabSelector)).length === 0 ) {

                    // Find direct tab link that matches href (like 'a[href="#panel-1"]')
                    if ( ($tab = plugin.tabs.find("a[href='" + tabSelector + "']")).length === 0 ) {

                        // Find direct tab link that matches selector (like 'a#tab-1')
                        if ( ($tab = plugin.tabs.find("a" + tabSelector)).length === 0 ) {

                            // Find direct tab link that matches data-target (lik 'a[data-target="#panel-1"]')
                            if ( ($tab = plugin.tabs.find("[data-target='" + tabSelector + "']")).length === 0 ) {

                                // Find direct tab link that ends in the matching href (like 'a[href$="#panel-1"]', which would also match http://example.com/currentpage/#panel-1)
                                if ( ($tab = plugin.tabs.find("a[href$='" + tabSelector + "']")).length === 0 ) {

                                    $.error('Tab \'' + tabSelector + '\' does not exist in tab set');
                                }
                            }
                        }
                    }
                } else {
                    // Select the child tab link, since the first option finds the tab container (like <li>)
                    $tab = $tab.children("a").first();
                }
                plugin.selectTab($tab);
            }
        };

        // =============================================================
        // Private functions
        // =============================================================

        // Triggers an event on an element and returns the event result
        var fire = function(obj, name, data) {
            var event = $.Event(name);
            obj.trigger(event, data);
            return event.result !== false;
        }

        // Add CSS classes to markup (if specified), called by init
        var addClasses = function() {
            $container.addClass(settings.containerClass);
            plugin.tabs.parent().addClass(settings.tabsClass);
            plugin.tabs.addClass(settings.tabClass);
            plugin.panels.addClass(settings.panelClass);
        };

        // Set the default tab, whether from hash (bookmarked) or option,
        // called by init
        var setDefaultTab = function(){
            var hash = window.location.hash.match(/^[^\?]*/)[0],
                $selectedTab = plugin.matchTab(hash).parent(),
                $panel;

            // If hash directly matches one of the tabs, active on page-load
            if( $selectedTab.length === 1 ){
                $defaultTab = $selectedTab;
                settings.cycle = false;

            } else {
                $panel = plugin.matchInPanel(hash);

                // If one of the panels contains the element matching the hash,
                // make it active on page-load
                if ( $panel.length ) {
                    hash = '#' + $panel.attr('id');
                    $defaultTab = plugin.matchTab(hash).parent();

                    // Otherwise, make the default tab the one that's active on page-load
                } else {
                    $defaultTab = plugin.tabs.parent().find(settings.defaultTab);
                    if ( $defaultTab.length === 0 ) {
                        $.error("The specified default tab ('" + settings.defaultTab + "') could not be found in the tab set.");
                    }
                }
            }

            $defaultTabLink = $defaultTab.children("a").first();

            activateDefaultTab($selectedTab);
        };

        // Activate defaultTab (or collapse by default), called by setDefaultTab
        var activateDefaultTab = function($selectedTab) {
            var defaultPanel,
                defaultAjaxUrl;

            if ( settings.collapsible && $selectedTab.length === 0 && settings.collapsedByDefault ) {
                $defaultTab
                    .addClass(settings.collapsedClass)
                    .children()
                    .addClass(settings.collapsedClass);

            } else {

                defaultPanel = $( $defaultTab.data('easytabs').panel );
                defaultAjaxUrl = $defaultTab.data('easytabs').ajax;

                if ( defaultAjaxUrl && (!settings.cache || !$defaultTab.data('easytabs').cached) ) {
                    $container.trigger('easytabs:ajax:beforeSend', [$defaultTabLink, defaultPanel]);
                    defaultPanel.load(defaultAjaxUrl, function(response, status, xhr){
                        $defaultTab.data('easytabs').cached = true;
                        $container.trigger('easytabs:ajax:complete', [$defaultTabLink, defaultPanel, response, status, xhr]);
                    });
                }

                $defaultTab.data('easytabs').panel
                    .show()
                    .addClass(settings.panelActiveClass);

                $defaultTab
                    .addClass(settings.tabActiveClass)
                    .children()
                    .addClass(settings.tabActiveClass);
            }
        };

        // Bind tab-select funtionality to namespaced click event, called by
        // init
        var bindToTabClicks = function() {
            plugin.tabs.children("a").bind("click.easytabs", function(e) {

                // Stop cycling when a tab is clicked
                settings.cycle = false;

                // Hash will be updated when tab is clicked,
                // don't cause tab to re-select when hash-change event is fired
                skipUpdateToHash = false;

                // Select the panel for the clicked tab
                plugin.selectTab( $(this) );

                // Don't follow the link to the anchor
                e.preventDefault();
            });
        };

        // Activate a given tab/panel, called from plugin.selectTab:
        //
        //   * fire `easytabs:before` hook
        //   * get ajax if new tab is an uncached ajax tab
        //   * animate out previously-active panel
        //   * fire `easytabs:midTransition` hook
        //   * update URL hash
        //   * animate in newly-active panel
        //   * update CSS classes for inactive and active tabs/panels
        //
        // TODO: This could probably be broken out into many more modular
        // functions
        var activateTab = function($clicked, $targetPanel, ajaxUrl, callback) {
            plugin.panels.stop(true,true);

            if( fire($container,"easytabs:before", [$clicked, $targetPanel, settings]) ){
                var $visiblePanel = plugin.panels.filter(":visible"),
                    $panelContainer = $targetPanel.parent(),
                    targetHeight,
                    visibleHeight,
                    heightDifference,
                    showPanel,
                    hash = window.location.hash.match(/^[^\?]*/)[0];

                if (settings.animate) {
                    targetHeight = getHeightForHidden($targetPanel);
                    visibleHeight = $visiblePanel.length ? setAndReturnHeight($visiblePanel) : 0;
                    heightDifference = targetHeight - visibleHeight;
                }

                // Set lastHash to help indicate if defaultTab should be
                // activated across multiple tab instances.
                lastHash = hash;

                // TODO: Move this function elsewhere
                showPanel = function() {
                    // At this point, the previous panel is hidden, and the new one will be selected
                    $container.trigger("easytabs:midTransition", [$clicked, $targetPanel, settings]);

                    // Gracefully animate between panels of differing heights, start height change animation *after* panel change if panel needs to contract,
                    // so that there is no chance of making the visible panel overflowing the height of the target panel
                    if (settings.animate && settings.transitionIn == 'fadeIn') {
                        if (heightDifference < 0)
                            $panelContainer.animate({
                                height: $panelContainer.height() + heightDifference
                            }, transitions.halfSpeed ).css({ 'min-height': '' });
                    }

                    if ( settings.updateHash && ! skipUpdateToHash ) {
                        //window.location = url.toString().replace((url.pathname + hash), (url.pathname + $clicked.attr("href")));
                        // Not sure why this behaves so differently, but it's more straight forward and seems to have less side-effects
                        window.location.hash = '#' + $targetPanel.attr('id');
                    } else {
                        skipUpdateToHash = false;
                    }

                    $targetPanel
                        [transitions.show](transitions.speed, settings.transitionInEasing, function(){
                        $panelContainer.css({height: '', 'min-height': ''}); // After the transition, unset the height
                        $container.trigger("easytabs:after", [$clicked, $targetPanel, settings]);
                        // callback only gets called if selectTab actually does something, since it's inside the if block
                        if(typeof callback == 'function'){
                            callback();
                        }
                    });
                };

                if ( ajaxUrl && (!settings.cache || !$clicked.parent().data('easytabs').cached) ) {
                    $container.trigger('easytabs:ajax:beforeSend', [$clicked, $targetPanel]);
                    $targetPanel.load(ajaxUrl, function(response, status, xhr){
                        $clicked.parent().data('easytabs').cached = true;
                        $container.trigger('easytabs:ajax:complete', [$clicked, $targetPanel, response, status, xhr]);
                    });
                }

                // Gracefully animate between panels of differing heights, start height change animation *before* panel change if panel needs to expand,
                // so that there is no chance of making the target panel overflowing the height of the visible panel
                if( settings.animate && settings.transitionOut == 'fadeOut' ) {
                    if( heightDifference > 0 ) {
                        $panelContainer.animate({
                            height: ( $panelContainer.height() + heightDifference )
                        }, transitions.halfSpeed );
                    } else {
                        // Prevent height jumping before height transition is triggered at midTransition
                        $panelContainer.css({ 'min-height': $panelContainer.height() });
                    }
                }

                // Change the active tab *first* to provide immediate feedback when the user clicks
                plugin.tabs.filter("." + settings.tabActiveClass).removeClass(settings.tabActiveClass).children().removeClass(settings.tabActiveClass);
                plugin.tabs.filter("." + settings.collapsedClass).removeClass(settings.collapsedClass).children().removeClass(settings.collapsedClass);
                $clicked.parent().addClass(settings.tabActiveClass).children().addClass(settings.tabActiveClass);

                plugin.panels.filter("." + settings.panelActiveClass).removeClass(settings.panelActiveClass);
                $targetPanel.addClass(settings.panelActiveClass);

                if( $visiblePanel.length ) {
                    $visiblePanel
                        [transitions.hide](transitions.speed, settings.transitionOutEasing, showPanel);
                } else {
                    $targetPanel
                        [transitions.uncollapse](transitions.speed, settings.transitionUncollapseEasing, showPanel);
                }
            }
        };

        // Get heights of panels to enable animation between panels of
        // differing heights, called by activateTab
        var getHeightForHidden = function($targetPanel){

            if ( $targetPanel.data('easytabs') && $targetPanel.data('easytabs').lastHeight ) {
                return $targetPanel.data('easytabs').lastHeight;
            }

            // this is the only property easytabs changes, so we need to grab its value on each tab change
            var display = $targetPanel.css('display'),

            // Workaround, because firefox returns wrong height if element itself has absolute positioning
                height = $targetPanel
                    .wrap($('<div>', {position: 'absolute', 'visibility': 'hidden', 'overflow': 'hidden'}))
                    .css({'position':'relative','visibility':'hidden','display':'block'})
                    .outerHeight();

            $targetPanel.unwrap();

            // Return element to previous state
            $targetPanel.css({
                position: $targetPanel.data('easytabs').position,
                visibility: $targetPanel.data('easytabs').visibility,
                display: display
            });

            // Cache height
            $targetPanel.data('easytabs').lastHeight = height;

            return height;
        };

        // Since the height of the visible panel may have been manipulated due to interaction,
        // we want to re-cache the visible height on each tab change, called
        // by activateTab
        var setAndReturnHeight = function($visiblePanel) {
            var height = $visiblePanel.outerHeight();

            if( $visiblePanel.data('easytabs') ) {
                $visiblePanel.data('easytabs').lastHeight = height;
            } else {
                $visiblePanel.data('easytabs', {lastHeight: height});
            }
            return height;
        };

        // Setup hash-change callback for forward- and back-button
        // functionality, called by init
        var initHashChange = function(){

            // enabling back-button with jquery.hashchange plugin
            // http://benalman.com/projects/jquery-hashchange-plugin/
            if(typeof $(window).hashchange === 'function'){
                $(window).hashchange( function(){
                    plugin.selectTabFromHashChange();
                });
            } else if ($.address && typeof $.address.change === 'function') { // back-button with jquery.address plugin http://www.asual.com/jquery/address/docs/
                $.address.change( function(){
                    plugin.selectTabFromHashChange();
                });
            }
        };

        // Begin cycling if set in options, called by init
        var initCycle = function(){
            var tabNumber;
            if (settings.cycle) {
                tabNumber = plugin.tabs.index($defaultTab);
                setTimeout( function(){ plugin.cycleTabs(tabNumber + 1); }, settings.cycle);
            }
        };


        plugin.init();

    };

    $.fn.easytabs = function(options) {
        var args = arguments;

        return this.each(function() {
            var $this = $(this),
                plugin = $this.data('easytabs');

            // Initialization was called with $(el).easytabs( { options } );
            if (undefined === plugin) {
                plugin = new $.easytabs(this, options);
                $this.data('easytabs', plugin);
            }

            // User called public method
            if ( plugin.publicMethods[options] ){
                return plugin.publicMethods[options](Array.prototype.slice.call( args, 1 ));
            }
        });
    };

})(jQuery);

/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license.
 * Copyright 2007, 2013 Brian Cherne
 */
(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery)

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 *
 * Open source under the BSD License.
 *
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 *
 * Neither the name of the author nor the names of contributors may be used to endorse
 * or promote products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
    {
        def: 'easeOutQuad',
        swing: function (x, t, b, c, d) {
            //alert(jQuery.easing.default);
            return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
        },
        easeInQuad: function (x, t, b, c, d) {
            return c*(t/=d)*t + b;
        },
        easeOutQuad: function (x, t, b, c, d) {
            return -c *(t/=d)*(t-2) + b;
        },
        easeInOutQuad: function (x, t, b, c, d) {
            if ((t/=d/2) < 1) return c/2*t*t + b;
            return -c/2 * ((--t)*(t-2) - 1) + b;
        },
        easeInCubic: function (x, t, b, c, d) {
            return c*(t/=d)*t*t + b;
        },
        easeOutCubic: function (x, t, b, c, d) {
            return c*((t=t/d-1)*t*t + 1) + b;
        },
        easeInOutCubic: function (x, t, b, c, d) {
            if ((t/=d/2) < 1) return c/2*t*t*t + b;
            return c/2*((t-=2)*t*t + 2) + b;
        },
        easeInQuart: function (x, t, b, c, d) {
            return c*(t/=d)*t*t*t + b;
        },
        easeOutQuart: function (x, t, b, c, d) {
            return -c * ((t=t/d-1)*t*t*t - 1) + b;
        },
        easeInOutQuart: function (x, t, b, c, d) {
            if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
            return -c/2 * ((t-=2)*t*t*t - 2) + b;
        },
        easeInQuint: function (x, t, b, c, d) {
            return c*(t/=d)*t*t*t*t + b;
        },
        easeOutQuint: function (x, t, b, c, d) {
            return c*((t=t/d-1)*t*t*t*t + 1) + b;
        },
        easeInOutQuint: function (x, t, b, c, d) {
            if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
            return c/2*((t-=2)*t*t*t*t + 2) + b;
        },
        easeInSine: function (x, t, b, c, d) {
            return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
        },
        easeOutSine: function (x, t, b, c, d) {
            return c * Math.sin(t/d * (Math.PI/2)) + b;
        },
        easeInOutSine: function (x, t, b, c, d) {
            return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
        },
        easeInExpo: function (x, t, b, c, d) {
            return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
        },
        easeOutExpo: function (x, t, b, c, d) {
            return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
        },
        easeInOutExpo: function (x, t, b, c, d) {
            if (t==0) return b;
            if (t==d) return b+c;
            if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
            return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
        },
        easeInCirc: function (x, t, b, c, d) {
            return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
        },
        easeOutCirc: function (x, t, b, c, d) {
            return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
        },
        easeInOutCirc: function (x, t, b, c, d) {
            if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
            return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
        },
        easeInElastic: function (x, t, b, c, d) {
            var s=1.70158;var p=0;var a=c;
            if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
            if (a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
        },
        easeOutElastic: function (x, t, b, c, d) {
            var s=1.70158;var p=0;var a=c;
            if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
            if (a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
        },
        easeInOutElastic: function (x, t, b, c, d) {
            var s=1.70158;var p=0;var a=c;
            if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
            if (a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
            return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
        },
        easeInBack: function (x, t, b, c, d, s) {
            if (s == undefined) s = 1.70158;
            return c*(t/=d)*t*((s+1)*t - s) + b;
        },
        easeOutBack: function (x, t, b, c, d, s) {
            if (s == undefined) s = 1.70158;
            return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
        },
        easeInOutBack: function (x, t, b, c, d, s) {
            if (s == undefined) s = 1.70158;
            if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
            return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
        },
        easeInBounce: function (x, t, b, c, d) {
            return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
        },
        easeOutBounce: function (x, t, b, c, d) {
            if ((t/=d) < (1/2.75)) {
                return c*(7.5625*t*t) + b;
            } else if (t < (2/2.75)) {
                return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
            } else if (t < (2.5/2.75)) {
                return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
            } else {
                return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
            }
        },
        easeInOutBounce: function (x, t, b, c, d) {
            if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
            return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
        }
    });

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 *
 * Open source under the BSD License.
 *
 * Copyright © 2001 Robert Penner
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 *
 * Neither the name of the author nor the names of contributors may be used to endorse
 * or promote products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/*! Copyright (c) 2011 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 * Thanks to: Seamus Leahy for adding deltaX and deltaY
 *
 * Version: 3.0.6
 *
 * Requires: 1.2.2+
 */

(function($) {

    var types = ['DOMMouseScroll', 'mousewheel'];

    if ($.event.fixHooks) {
        for ( var i=types.length; i; ) {
            $.event.fixHooks[ types[--i] ] = $.event.mouseHooks;
        }
    }

    $.event.special.mousewheel = {
        setup: function() {
            if ( this.addEventListener ) {
                for ( var i=types.length; i; ) {
                    this.addEventListener( types[--i], handler, false );
                }
            } else {
                this.onmousewheel = handler;
            }
        },

        teardown: function() {
            if ( this.removeEventListener ) {
                for ( var i=types.length; i; ) {
                    this.removeEventListener( types[--i], handler, false );
                }
            } else {
                this.onmousewheel = null;
            }
        }
    };

    $.fn.extend({
        mousewheel: function(fn) {
            return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
        },

        unmousewheel: function(fn) {
            return this.unbind("mousewheel", fn);
        }
    });


    function handler(event) {
        var orgEvent = event || window.event, args = [].slice.call( arguments, 1 ), delta = 0, returnValue = true, deltaX = 0, deltaY = 0;
        event = $.event.fix(orgEvent);
        event.type = "mousewheel";

        // Old school scrollwheel delta
        if ( orgEvent.wheelDelta ) { delta = orgEvent.wheelDelta/120; }
        if ( orgEvent.detail     ) { delta = -orgEvent.detail/3; }

        // New school multidimensional scroll (touchpads) deltas
        deltaY = delta;

        // Gecko
        if ( orgEvent.axis !== undefined && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
            deltaY = 0;
            deltaX = -1*delta;
        }

        // Webkit
        if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY/120; }
        if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = -1*orgEvent.wheelDeltaX/120; }

        // Add event and delta to the front of the arguments
        args.unshift(event, delta, deltaX, deltaY);

        return ($.event.dispatch || $.event.handle).apply(this, args);
    }

})(jQuery);

(function($) {
    var	aux		= {
            // navigates left / right
            navigate	: function( dir, $el, $wrapper, opts, cache ) {

                var scroll		= opts.scroll,
                    factor		= 1,
                    idxClicked	= 0;

                if( cache.expanded ) {
                    scroll		= 1; // scroll is always 1 in full mode
                    factor		= 3; // the width of the expanded item will be 3 times bigger than 1 collapsed item
                    idxClicked	= cache.idxClicked; // the index of the clicked item
                }

                // clone the elements on the right / left and append / prepend them according to dir and scroll
                if( dir === 1 ) {
                    $wrapper.find('div.ca-item:lt(' + scroll + ')').each(function(i) {
                        $(this).clone(true).css( 'left', ( cache.totalItems - idxClicked + i ) * cache.itemW * factor + 'px' ).appendTo( $wrapper );
                    });
                }
                else {
                    var $first	= $wrapper.children().eq(0);

                    $wrapper.find('div.ca-item:gt(' + ( cache.totalItems  - 1 - scroll ) + ')').each(function(i) {
                        // insert before $first so they stay in the right order
                        $(this).clone(true).css( 'left', - ( scroll - i + idxClicked ) * cache.itemW * factor + 'px' ).insertBefore( $first );
                    });
                }

                // animate the left of each item
                // the calculations are dependent on dir and on the cache.expanded value
                $wrapper.find('div.ca-item').each(function(i) {
                    var $item	= $(this);
                    $item.stop().animate({
                        left	:  ( dir === 1 ) ? '-=' + ( cache.itemW * factor * scroll ) + 'px' : '+=' + ( cache.itemW * factor * scroll ) + 'px'
                    }, opts.sliderSpeed, opts.sliderEasing, function() {
                        if( ( dir === 1 && $item.position().left < - idxClicked * cache.itemW * factor ) || ( dir === -1 && $item.position().left > ( ( cache.totalItems - 1 - idxClicked ) * cache.itemW * factor ) ) ) {
                            // remove the item that was cloned
                            $item.remove();
                        }
                        cache.isAnimating	= false;
                    });
                });

            },
            // opens an item (animation) -> opens all the others
            openItem	: function( $wrapper, $item, opts, cache ) {
                cache.idxClicked	= $item.index();
                // the item's position (1, 2, or 3) on the viewport (the visible items)
                cache.winpos		= aux.getWinPos( $item.position().left, cache );
                $wrapper.find('div.ca-item').not( $item ).hide();
                $item.find('div.ca-content-wrapper').css( 'left', cache.itemW + 'px' ).stop().animate({
                    width	: cache.itemW * 2 + 'px',
                    left	: cache.itemW + 'px'
                }, opts.itemSpeed, opts.itemEasing)
                    .end()
                    .stop()
                    .animate({
                        left	: '0px'
                    }, opts.itemSpeed, opts.itemEasing, function() {
                        cache.isAnimating	= false;
                        cache.expanded		= true;

                        aux.openItems( $wrapper, $item, opts, cache );
                    });

            },
            // opens all the items
            openItems	: function( $wrapper, $openedItem, opts, cache ) {
                var openedIdx	= $openedItem.index();

                $wrapper.find('div.ca-item').each(function(i) {
                    var $item	= $(this),
                        idx		= $item.index();

                    if( idx !== openedIdx ) {
                        $item.css( 'left', - ( openedIdx - idx ) * ( cache.itemW * 3 ) + 'px' ).show().find('div.ca-content-wrapper').css({
                            left	: cache.itemW + 'px',
                            width	: cache.itemW * 2 + 'px'
                        });

                        // hide more link
                        aux.toggleMore( $item, false );
                    }
                });
            },
            // show / hide the item's more button
            toggleMore	: function( $item, show ) {
                ( show ) ? $item.find('a.ca-more').show() : $item.find('a.ca-more').hide();
            },
            // close all the items
            // the current one is animated
            closeItems	: function( $wrapper, $openedItem, opts, cache ) {
                var openedIdx	= $openedItem.index();

                $openedItem.find('div.ca-content-wrapper').stop().animate({
                    width	: '0px'
                }, opts.itemSpeed, opts.itemEasing)
                    .end()
                    .stop()
                    .animate({
                        left	: cache.itemW * ( cache.winpos - 1 ) + 'px'
                    }, opts.itemSpeed, opts.itemEasing, function() {
                        cache.isAnimating	= false;
                        cache.expanded		= false;
                    });

                // show more link
                aux.toggleMore( $openedItem, true );

                $wrapper.find('div.ca-item').each(function(i) {
                    var $item	= $(this),
                        idx		= $item.index();

                    if( idx !== openedIdx ) {
                        $item.find('div.ca-content-wrapper').css({
                            width	: '0px'
                        })
                            .end()
                            .css( 'left', ( ( cache.winpos - 1 ) - ( openedIdx - idx ) ) * cache.itemW + 'px' )
                            .show();

                        // show more link
                        aux.toggleMore( $item, true );
                    }
                });
            },
            // gets the item's position (1, 2, or 3) on the viewport (the visible items)
            // val is the left of the item
            getWinPos	: function( val, cache ) {
                switch( val ) {
                    case 0 					: return 1; break;
                    case cache.itemW 		: return 2; break;
                    case cache.itemW * 2 	: return 3; break;
                }
            }
        },
        methods = {
            init 		: function( options ) {

                if( this.length ) {

                    var settings = {
                        sliderSpeed		: 500,			// speed for the sliding animation
                        sliderEasing	: 'easeOutExpo',// easing for the sliding animation
                        itemSpeed		: 500,			// speed for the item animation (open / close)
                        itemEasing		: 'easeOutExpo',// easing for the item animation (open / close)
                        scroll			: 1				// number of items to scroll at a time
                    };

                    return this.each(function() {

                        // if options exist, lets merge them with our default settings
                        if ( options ) {
                            $.extend( settings, options );
                        }

                        var $el 			= $(this),
                            $wrapper		= $el.find('div.ca-wrapper'),
                            $items			= $wrapper.children('div.ca-item'),
                            cache			= {};

                        // save the with of one item
                        cache.itemW			= $items.width();
                        // save the number of total items
                        cache.totalItems	= $items.length;

                        // add navigation buttons
                        if( cache.totalItems > 3 )
                            $el.prepend('<div class="ca-nav"><span class="ca-nav-prev">Previous</span><span class="ca-nav-next">Next</span></div>')

                        // control the scroll value
                        if( settings.scroll < 1 )
                            settings.scroll = 1;
                        else if( settings.scroll > 3 )
                            settings.scroll = 3;

                        var $navPrev		= $el.find('span.ca-nav-prev'),
                            $navNext		= $el.find('span.ca-nav-next');

                        // hide the items except the first 3
                        $wrapper.css( 'overflow', 'hidden' );

                        // the items will have position absolute
                        // calculate the left of each item
                        $items.each(function(i) {
                            $(this).css({
                                position	: 'absolute',
                                left		: i * cache.itemW + 'px'
                            });
                        });

                        // click to open the item(s)
                        $el.find('a.ca-more').on('click.contentcarousel', function( event ) {
                            if( cache.isAnimating ) return false;
                            cache.isAnimating	= true;
                            $(this).hide();
                            var $item	= $(this).closest('div.ca-item');
                            aux.openItem( $wrapper, $item, settings, cache );
                            return false;
                        });

                        // click to close the item(s)
                        $el.find('a.ca-close').on('click.contentcarousel', function( event ) {
                            if( cache.isAnimating ) return false;
                            cache.isAnimating	= true;
                            var $item	= $(this).closest('div.ca-item');
                            aux.closeItems( $wrapper, $item, settings, cache );
                            return false;
                        });

                        // navigate left
                        $navPrev.bind('click.contentcarousel', function( event ) {
                            if( cache.isAnimating ) return false;
                            cache.isAnimating	= true;
                            aux.navigate( -1, $el, $wrapper, settings, cache );
                        });

                        // navigate right
                        $navNext.bind('click.contentcarousel', function( event ) {
                            if( cache.isAnimating ) return false;
                            cache.isAnimating	= true;
                            aux.navigate( 1, $el, $wrapper, settings, cache );
                        });

                        /* adds events to the mouse
                         $el.bind('mousewheel.contentcarousel', function(e, delta) {
                         if(delta > 0) {
                         if( cache.isAnimating ) return false;
                         cache.isAnimating	= true;
                         aux.navigate( -1, $el, $wrapper, settings, cache );
                         }
                         else {
                         if( cache.isAnimating ) return false;
                         cache.isAnimating	= true;
                         aux.navigate( 1, $el, $wrapper, settings, cache );
                         }
                         return false;
                         });
                         */

                    });
                }
            }
        };

    $.fn.contentcarousel = function(method) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.contentcarousel' );
        }
    };

})(jQuery);

/*
 * CSSMap plugin
 * version: 4.4.23
 * web: http://cssmapsplugin.com
 * email: support@cssmapsplugin.com
 * author: Łukasz Popardowski { Winston_Wolf }
 * license: http://cssmapsplugin.com/license
 */
(function(a){a.fn.cssMap=function(h){var g={size:"850",tooltips:true,tooltipArrowHeight:5,cities:false,visibleList:false,visibleListContainerId:"",loadingText:"Loading ...",multipleClick:false,searchUrl:"search.php",searchLink:"Search",searchLinkVar:"region",searchLinkSeparator:"|",clicksLimit:0,clicksLimitAlert:"You can select only %d region! || regions!",agentsListId:"",agentsListSpeed:0,agentsListOnHover:false,pins:{enable:false,pinsId:"",markerClass:"cssmap-marker",pinTooltipClass:"cssmap-tooltip-content",markerPosition:"middle",tooltipPosition:"top",tooltipOnClick:false,tooltipFadeSpeed:0,clickableRegions:true},onClick:function(d){},onSecondClick:function(d){},onHover:function(d){},unHover:function(d){},onLoad:function(d){}};if(h){var c=a.extend(true,g,h||{}),f=a(window).width(),b=a(window).height();a(window).resize(function(){f=a(window).width();b=a(window).height()});return this.each(function(o){if(!a(this).attr("id")){a(this).attr("id","css-map"+(o+1))}if(c.pins.pinsId!=""&&c.pins.pinsId!="#"){var m=c.pins.pinsId}else{var m=".cssmap-pins"}var s="#"+a(this).attr("id"),k=a(s),i=k.find("ul").eq(0),j=a(i).attr("class").split(" ")[0],t=a(i).find("li"),d=a(m).find("li"),n=0,r=false,l="",v="",q=c.tooltips.toString(),u=c.pins.clickableRegions.toString(),p={init:function(){p.clearMap();k.addClass("css-map-container m"+c.size);var w=i.css("background-image").replace(/^url\("?([^\"\))]+)"?\)$/i,"$1");this.loader(w)},loader:function(z){var y=new Image(),w=a("<span />",{"class":"map-loader",text:c.loadingText}).appendTo(k),x={left:k.outerWidth()/2,marginLeft:w.outerWidth()/-2,marginTop:w.outerHeight()/-2,top:k.outerHeight()/2};w.css(x);a(i).addClass("css-map");a(c.agentsListId).find("li").hide();a(y).load(function(){if(navigator.appVersion.indexOf("MSIE 7.")!=-1){var A=true}if(c.cities&&!A){k.append('<span class="cities '+j+'-cities" />')}if(A){k.addClass("ie")}if(u!="false"){p.regions.init()}if(a(c.agentsListId).length){p.agentslist.init()}if(c.multipleClick){p.searchButton()}if(c.pins.enable){p.pins.init()}w.fadeOut("slow");c.onLoad(k)}).error(function(){w.fadeOut();a(i).removeClass()}).attr("src",z)},regions:{init:function(){var w=p.regions;w.hideTooltips();t.each(function(){var y=a(this),z=y.attr("class").split(" ")[0],A=y.children("a").eq(0),x=a(A).attr("href");if(typeof x=="undefined"||x.length<2){a(y).remove()}w.copyList(a(y),z,A,x);w.createSpans(a(y),z);p.selectRegion.init(a(y),z,A)});if(c.visibleList){w.createList(l);p.selectRegion.initVisibleList()}w.autoSelectRegion()},createSpans:function(x,z){var w='<span class="m">',A=[],E="",B=x.children("a").eq(0);if(q!="visible"&&q.split("-")[0]!="floating"){var C=a('<span class="tooltip-arrow" />').appendTo(B)}switch(j){case"argentina":E="ar";A=[3,18,18,17,12,17,15,14,21,13,12,17,18,8,19,22,22,17,11,20,20,12,10,9,2];break;case"australia":E="au";A=[3,21,5,15,8,6,15,13];break;case"austria":case"osterreich":E="at";A=[15,18,30,25,24,28,22,8,4];break;case"belgium":E="be";A=[13,6,19,28,25,29,22,29,24,16,23];break;case"brazil":case"brasil":E="br";A=[12,8,11,34,28,13,3,5,22,19,23,18,30,34,9,11,19,17,9,10,15,13,14,12,21,6,23];break;case"canada":E="ca";A=[8,11,10,3,19,20,6,31,17,2,21,3,12];break;case"chile":E="cl";A=[11,4,10,13,9,8,12,7,9,7,20,7,11,7,9];break;case"colombia":E="co";A=[22,30,8,5,6,21,21,11,30,18,23,13,23,12,17,18,16,18,11,14,23,15,12,15,5,6,2,16,11,13,14,21,14];break;case"continents":case"world-continents":E="c";A=[20,35,19,23,35,15,3];break;case"croatia":E="hr";A=[24,27,36,10,15,24,20,11,26,8,21,18,21,30,28,29,13,18,21,33,35];break;case"cuba":E="cu";A=[8,20,18,7,12,10,4,16,9,12,11,5,14,15,11,15];break;case"czech-republic":case"cesko":E="cs";A=[5,15,21,10,18,16,12,16,25,19,14,28,14,15];break;case"denmark":case"danmark":E="dk";A=[15,40,37,24,30,2];break;case"danmarks-kommuner":E="dkk";A=[9,5,14,14,10,9,7,7,6,14,16,9,8,7,9,8,8,7,7,8,6,12,11,23,11,13,7,16,6,16,16,18,25,18,17,21,11,23,5,15,24,10,19,13,18,12,24,23,24,14,26,16,18,8,16,11,18,19,17,13,5,17,14,21,6,11,18,14,12,8,11,14,5,10,9,19,11,17,12,13,22,6,9,17,22,15,18,13,10,14,13,12,11,16,16,27,20,25];break;case"europe":E="eu";A=[5,2,9,10,5,6,7,10,4,9,9,5,15,22,7,14,12,8,7,7,2,24,2,7,2,7,2,4,3,7,2,4,8,30,12,4,11,42,6,5,5,11,26,6,10,20,17,10,2,6,9,3];break;case"europe-russia":E="euru";A=[4,2,8,14,8,7,8,13,3,10,8,6,21,20,9,14,10,10,4,6,21,5,8,2,7,2,4,2,9,2,5,5,27,14,7,12,82,2,9,8,4,18,21,8,14,25,14,6,10,45,16,32,14,18,28];break;case"finland":E="fi";A=[8,22,28,22,26,14,15,29,15,43,21,23,28,48,24,18,15,19,18];break;case"france":E="fr";A=[13,25,25,14,27,14,25,21,8,19,12,13,28,15,18,27,11,26,17,25,24,34,2,2,2,2,2];break;case"france-departments":case"departements-francais":E="frd";A=[10,8,9,11,9,8,11,8,9,8,11,9,7,7,7,9,15,10,9,7,7,8,7,7,10,11,8,9,10,5,13,16,11,15,10,8,9,10,12,9,10,12,10,9,11,10,10,8,7,9,8,9,10,9,11,7,7,8,9,10,5,10,8,9,6,10,5,8,6,7,8,12,9,12,7,9,9,7,5,8,7,7,8,8,7,10,10,9,10,12,3,4,9,10,10,4,2,2,2,2,2];break;case"germany":case"deutschland":E="de";A=[31,41,7,38,6,8,38,25,64,37,24,9,25,31,20,33];break;case"baden-wurttemberg":E="dea";A=[26,8,25,16,17,29,17,14,18,13,7,15,12,6,11,25,5,18,21,6,14,11,18,13,5,16,19,15,6,21,19,14,19,20,15,16,18,22,9,14,16,7,13,15];break;case"bayern":E="deb";A=[8,8,16,3,17,5,10,3,9,6,10,11,17,3,17,4,9,11,12,3,9,11,7,13,14,8,14,7,2,14,8,10,9,7,6,3,8,8,13,13,4,5,2,4,12,10,6,9,10,15,4,7,4,12,4,10,7,12,13,6,6,8,14,11,15,6,12,11,19,14,3,10,11,15,3,8,16,2,14,12,3,13,14,4,6,4,14,9,14,14,4,14,11,6,14,4];break;case"berlin":E="dec";A=[18,15,21,15,17,18,19,17,22,16,17,25];break;case"brandenburg":E="ded";A=[16,11,8,31,16,3,16,18,20,18,25,22,4,28,15,20,23,18];break;case"bremen":E="dee";A=[14,11,12,8,8,17,7,12,18,14,7,31,11,11,11,8,6,12,9,10,9,8,12,8];break;case"hamburg":E="def";A=[14,21,17,24,23,36,23];break;case"hessen":E="deg";A=[13,6,14,13,14,16,12,19,13,19,4,17,12,19,10,18,8,4,9,11,21,22,15,14,21,6];break;case"mecklenburg-vorpommern":E="deh";A=[28,26,15,29,8,5,19,16];break;case"niedersachsen":E="dei";A=[10,11,4,13,14,13,3,17,4,18,11,12,11,7,9,10,9,17,10,10,13,12,11,14,13,13,12,2,15,3,9,7,9,21,17,6,8,15,11,10,9,8,3,10,12,4];break;case"nordrhein-westfalen":E="dej";A=[12,6,5,4,15,5,16,7,6,13,6,10,7,11,4,15,7,6,10,9,4,15,12,15,9,4,5,14,12,14,8,7,4,9,12,3,12,15,16,3,13,12,18,13,11,12,6,14,11,14,14,19,7];break;case"rheinland-pfalz":E="dek";A=[16,17,20,16,19,21,16,16,16,16,4,11,19,8,5,13,7,6,7,21,27,5,14,4,19,16,15,4,23,20,9,26,17,19,6,4];break;case"saarland":E="del";A=[21,22,26,28,29,19];break;case"sachsen":E="dem";A=[24,8,9,23,19,17,8,17,27,14,18,15,17];break;case"sachsen-anhalt":E="den";A=[20,25,26,14,11,6,17,19,7,21,23,23,28,12];break;case"schleswig-holstein":E="deo";A=[14,4,20,8,9,5,15,18,12,14,24,26,22,12,15];break;case"thuringen":E="dep";A=[8,10,5,10,6,20,21,18,15,5,19,8,16,14,21,17,10,17,8,17,21,5,17];break;case"greece":E="gr";A=[13,24,17,13,15,16,14,5,8,16,27,21,18,13];break;case"haiti":E="ht";A=[31,22,14,14,23,13,15,37,16,22];break;case"hungary":E="hu";A=[26,12,18,19,5,11,15,15,16,18,21,9,11,27,15,19,16,13,15,12];break;case"ireland":E="ie";A=[25,17,18,32,33,44,21,36,26,17,27,45,37,19,26,21,25,27,16,17,36,31,24,35,30,23,37,35,20,24,20,25];break;case"ireland-counties":E="iec";A=[19,16,18,32,25,45,4,35,21,6,6,23,12,42,4,34,21,25,20,26,26,3,21,17,15,31,33,23,25,31,30,24,8,24,33,19,2,20,21,23];break;case"italy":case"italia":E="it";A=[16,12,13,18,29,10,24,16,27,15,12,22,23,9,27,28,15,14,6,24];break;case"lesotho":E="ls";A=[44,28,59,55,61,75,49,37,49,77];break;case"lithuania":E="lt";A=[33,53,29,26,41,40,31,31,46,61];break;case"mexico":E="mx";A=[3,9,10,10,12,16,13,5,3,13,7,10,7,16,7,7,4,8,12,11,8,5,7,11,13,11,11,12,3,15,8,14];break;case"netherlands":case"nederland":E="nl";A=[23,18,23,34,20,16,23,22,25,23,15,24];break;case"norway":case"norge":E="no";A=[10,10,14,14,13,10,13,12,19,17,3,7,10,13,16,16,9,18,7,4];break;case"norway-divided":case"norge-delt":E="nod";A=[15,19,21,14,23,16,17,17,21,25,3,9,15,18,26,13,15,19,12,4];break;case"peru":E="pe";A=[23,27,16,37,32,26,7,42,17,32,20,25,26,21,27,77,31,20,14,20,12,30,30,18,10,48];break;case"poland":case"polska":E="pl";A=[31,31,28,25,36,22,47,22,28,30,30,27,24,29,46,26];break;case"portugal":E="pt";A=[17,28,16,15,23,26,28,15,27,23,13,24,14,32,23,8,17,22,5,3];break;case"romania":E="ro";A=[20,22,17,16,23,13,16,16,13,6,21,23,17,21,22,16,18,19,13,16,16,23,17,15,27,14,21,25,20,23,26,12,19,18,14,18,12,31,14,20,11,14];break;case"russia":E="ru";A=[17,36,9,39,44,16,36,23];break;case"russia-central":E="rua";A=[16,17,17,24,15,16,22,16,15,7,27,12,16,20,15,26,14,17];break;case"russia-far-eastern":E="rub";A=[18,5,24,16,8,33,19,27,20];break;case"russia-north-caucasian":E="ruc";A=[32,9,13,17,12,33,18];break;case"russia-northwestern":E="rud";A=[48,19,6,18,34,11,16,25,9,13,3];break;case"russia-siberian":E="rue";A=[10,10,20,16,30,10,44,12,8,12,11,7];break;case"russia-southern":E="ruf";A=[18,27,41,46,45,43];break;case"russia-ural":E="rug";A=[12,22,20,40,15,33];break;case"russia-volga":E="ruh";A=[30,31,13,14,20,28,13,26,18,24,21,15,16,8];break;case"slovakia":case"slovensko":E="sk";A=[33,16,29,32,27,29,32,25];break;case"slovenia":E="si";A=[32,43,43,18,23,23,42,32,24,41,24,11];break;case"south-africa":E="za";A=[20,19,11,14,14,21,34,24,24,13];break;case"eastern-cape":E="zaec";A=[30,60,17,60,50,45,9,34];break;case"free-state":E="zafs";A=[54,61,34,70,61];break;case"gauteng":E="zagt";A=[45,30,41,44,29,48,32,19,62,19];break;case"kwazulu-natal":E="zanl";A=[29,35,57,38,59,45,27,42,55,42,46];break;case"limpopo":E="zalp";A=[57,43,31,36,64];break;case"mpumalanga":E="zamp";A=[49,86,70];break;case"northern-cape":E="zanc";A=[24,32,77,62,73];break;case"north-west":E="zanw";A=[32,42,65,56];break;case"western-cape":E="zawc";A=[37,36,43,40,50,20];break;case"south-america":E="sam";A=[80,30,100,52,36,21,18,6,18,44,10,13,36,6];break;case"spain":case"espana":E="es";A=[18,11,12,16,14,16,23,9,12,24,12,16,2,21,19,21,15,17,11,16,17,7,12,18,14,10,13,8,19,14,14,20,2,13,12,17,11,15,8,15,7,13,18,15,11,21,25,15,14,8,12,28];break;case"spain-autonomies":case"espana-autonomias":E="esa";A=[24,30,12,7,12,11,48,57,17,2,24,27,14,11,16,2,18,16,12];break;case"sweden":case"sverige":E="se";A=[7,30,20,6,13,39,14,17,13,30,11,15,7,9,11,10,19,34,28,10,18];break;case"switzerland":E="ch";A=[27,12,7,22,4,61,34,11,14,35,17,24,17,12,12,10,15,31,28,22,19,16,31,47,6,20];break;case"turkey":case"turkiye":E="tr";A=[16,8,12,12,7,11,19,17,7,7,9,12,5,10,6,6,8,10,8,10,10,8,9,13,13,13,6,7,10,10,18,8,11,9,10,6,6,4,11,9,13,10,8,14,8,10,13,4,6,8,9,7,23,10,12,11,9,12,13,10,7,10,8,6,8,6,10,12,8,7,16,7,8,10,6,8,6,8,3,10,5];break;case"ukraine":E="ua";A=[20,23,20,13,26,24,17,26,25,16,5,29,26,21,17,19,32,22,21,6,18,14,20,19,13,25,18];break;case"united-kingdom":E="uk";A=[31,23,10,18,24,28,30,31,24,9,8,9,10,12,12,14,17,8,16,23,11,6,14,17,7,28,19,14,19,20,4];break;case"uruguay":E="uy";A=[17,13,25,12,28,15,21,23,17,5,22,21,22,23,20,17,21,30,20];break;case"usa":E="usa";A=[5,6,8,6,18,2,4,5,10,9,5,11,11,4,5,5,12,6,7,9,6,9,14,7,10,10,5,14,6,7,3,10,10,3,7,6,4,5,4,8,3,6,15,3,5,10,5,3,11,8,2,2];break;case"venezuela":E="ve";A=[20,17,19,8,19,29,2,4,9,18,11,5,18,15,11,6,12,3,11,8,7,6,4,8,23];break;case"zimbabwe":E="zw";A=[8,8,47,38,47,49,49,62,54,54];break}for(var y=0;y<A.length;y++){var D=y+1;if(z==E+D){for(var F=1;F<A[y];F++){w+='<span class="s'+F+'" />'}break}}w+="</span>";x.prepend(w).append('<span class="bg" />')},showTooltip:function(y){var B=i.find(y).children("a")[0];if(q=="true"||q=="sticky"||q=="visible"){var x=i.outerWidth(),C=parseInt(a(B).outerHeight()*-1)-c.tooltipArrowHeight,z=parseInt(a(B).outerHeight()/-2),F=parseInt(a(B).outerWidth()/-2),E=a(B).position().left,A=a(B).position().top;if((F*-1)>E){a(B).addClass("tooltip-left").css("left",0);F=0}if((F*-1)+E>x){a(B).addClass("tooltip-right");F=0}if((C*-1)>A){a(B).addClass("tooltip-top");C=c.tooltipArrowHeight}if(a(B).hasClass("tooltip-middle")){C=z}B.style.marginLeft=F+"px";if(q=="visible"){B.style.marginTop=z+"px"}else{B.style.marginTop=C+"px"}}else{if(q.split("-")[0]=="floating"){var w=a(B).html(),D=a("<div />",{id:"map-tooltip",html:w}).appendTo("body")}}},hideTooltips:function(){var z=i.find("a");a("#map-tooltip").remove();for(var x=0;x<z.length;x++){var w=z[x],y=parseInt(a(w).outerWidth()/-2),A=parseInt(a(w).outerHeight()/-2);if(q=="visible"){w.style.marginTop=A+"px";w.style.marginLeft=y+"px"}else{w.style.marginTop="-9999px"}}},copyList:function(x,y,z,w){var A=z.html();if(typeof w!="undefined"&&w.length>=2){l+='<li class="'+y+'"><a href="'+w+'">'+A+"</a></li>"}},createList:function(w){var x='<ul class="map-visible-list">'+w+"</ul>";if(c.visibleListContainerId&&c.visibleListContainerId!="#"){a(c.visibleListContainerId).html(x)}else{a(i).after(x)}},autoSelectRegion:function(){var w=k.find(".active-region"),x=s+" ."+w.parent("li").attr("class");if(w.length){p.selectRegion.activated(a(x))}}},selectRegion:{init:function(w,x,B){var z=p.selectRegion,x=s+" ."+x,A=a(x).children("span").eq(0),y=null;z.autoSelect(B);A.hover(function(){z.onHover(a(x))},function(){z.unHover(a(x))}).mousemove(function(C){if(q.split("-")[0]=="floating"){z.onMouseMove(a(x),C)}}).click(function(C){z.clicked(a(x));C.preventDefault()});a(B).focus(function(){z.onHover(a(x))}).blur(function(){z.unHover(a(x))}).keypress(function(C){y=(C.keyCode?C.keyCode:C.which);if(y===13){z.clicked(a(x))}}).click(function(C){z.clicked(a(x));C.preventDefault()})},initVisibleList:function(){var x=p.selectRegion;if(c.visibleListContainerId&&c.visibleListContainerId!="#"){var w=a(c.visibleListContainerId+" .map-visible-list").find("li")}else{var w=a(s+" .map-visible-list").find("li")}w.each(function(){var z=a(this).children("a"),y=s+" ."+a(this).attr("class");z.hover(function(){x.onHover(a(y))},function(){x.unHover(a(y))}).focus(function(){x.onHover(a(y))}).blur(function(){x.unHover(a(y))}).click(function(){x.clicked(a(y));return false}).keypress(function(){code=(e.keyCode?e.keyCode:e.which);if(code===13){x.clicked(a(y));return false}})})},onHover:function(x){var w=x.children("a").eq(0).attr("href");p.regions.hideTooltips();p.regions.showTooltip(x);x.addClass("focus");c.onHover(x);if(c.agentsListOnHover){p.agentslist.showAgent(w)}},onMouseMove:function(B,C){var F=a("#map-tooltip").eq(0),z=c.tooltipArrowHeight,w=10,E=15+z,A=a(F).outerHeight(),G=a(F).outerWidth(),x=a(window).scrollTop(),y=C.pageY-A-z,D=C.pageX-(G/2);if(z<3){z=3}switch(q){case"floating-left":case"floating-left-top":case"floating-top-left":if(C.clientX-G<=w){D=C.pageX+w}else{D=C.pageX-G-w}break;case"floating-right":case"floating-right-top":case"floating-top-right":if(f<=C.clientX+G+w){D=C.pageX-G-w}else{D=C.pageX+w}break;case"floating-middle":case"floating-middle-right":case"floating-right-middle":if(f<=C.clientX+G+w){D=C.pageX-G-w}else{D=C.pageX+w}if(x>=C.pageY-(A/2)-z){y=C.pageY+E-z}else{if(C.clientY+(A/2)>=b){y=C.pageY-A-z}else{y=C.pageY-(A/2)}}break;case"floating-middle-left":case"floating-left-middle":if(C.clientX-G<=w){D=C.pageX+w}else{D=C.pageX-G-w}if(x>=C.pageY-(A/2)-z){y=C.pageY+E-z}else{if(C.clientY+(A/2)>=b){y=C.pageY-A-z}else{y=C.pageY-(A/2)}}break;case"floating-bottom-left":case"floating-left-bottom":if(C.clientX-G<w){D=C.pageX+w}else{D=C.pageX-G-w}y=C.pageY+E;break;case"floating-bottom":case"floating-bottom-center":case"floating-center-bottom":if(C.clientX-(G/2)+w<=w){D=C.pageX+w}else{if(f<=C.clientX+(G/2)){D=C.pageX-G-w}else{D=C.pageX-(G/2)}}y=C.pageY+E;break;case"floating-bottom-right":case"floating-right-bottom":if(f<=C.clientX+G+w){D=C.pageX-G-w}else{D=C.pageX+w}y=C.pageY+E;break;default:if(C.clientX-(G/2)+w<=w){D=C.pageX+w}else{if(f<=C.clientX+(G/2)){D=C.pageX-G-w}else{D=C.pageX-(G/2)}}}if(x>=C.pageY-A-z){y=C.pageY+E}if(C.clientY+A+E>=b){y=C.pageY-A-z}F.css({left:D+"px",top:y+"px"})},unHover:function(x){var w=x.children("a").eq(0).attr("href");p.regions.hideTooltips();x.removeClass("focus");if(c.agentsListOnHover){p.agentslist.hideAgents(w);a(i).find(".active-region").each(function(){var y=a(this).children("a").eq(0).attr("href");p.agentslist.showAgent(y)})}c.unHover(x)},activated:function(B){var A=c.clicksLimitAlert.split(" %d ")[0],y=c.clicksLimitAlert.split(" %d ")[1],z=B.children("a").eq(0),w=z.attr("href"),x="";if(c.clicksLimit==0||!c.multipleClick){c.clicksLimit=Infinity}if(c.clicksLimit==1){x=y.split(" || ")[0]}else{x=y.split(" || ")[1]}if(B.hasClass("active-region")){p.agentslist.hideAgents(w);B.removeClass("active-region");n--;r=false}else{if(!c.multipleClick){k.find(".active-region").removeClass("active-region")}if(n<c.clicksLimit){if(a(c.agentsListId).length&&w.charAt(0)=="#"){p.agentslist.showAgent(w)}B.addClass("active-region");n++}else{alert(A+" "+c.clicksLimit+" "+x);r=true}}},clicked:function(A){var y=A.children("a").eq(0),x=y.attr("href"),z=y.attr("target"),w=y.attr("rel");p.selectRegion.activated(A);if(r==false){if(A.hasClass("active-region")){c.onClick(A)}else{c.onSecondClick(A)}if(typeof z!=="undefined"&&z!==false){window.open(x,z)}else{if(x!==undefined&&x.charAt(0)==="#"){if(a(c.agentsListId).length||c.multipleClick){return false}else{if(w!="nofollow"){window.location.hash=x}}}else{if(w!="nofollow"){window.location.href=x}else{return false}}}}},multiple:function(){var w=[],x=k.find(".map-search-link");t.each(function(){var A=a(this).children("a"),z=A.attr("href"),y;if(z!==undefined&&z.charAt(0)=="#"){y=z.slice(1)}else{if(/&/i.test(z)){y=z.slice(z.indexOf("?")+(c.searchLinkVar.length)+2,z.indexOf("&"))}else{y=z.slice(z.indexOf("?")+(c.searchLinkVar.length)+2)}}if(a(this).hasClass("active-region")){w.push(y)}});if(w.length){x.attr("href",c.searchUrl+"?"+c.searchLinkVar+"="+w.join(c.searchLinkSeparator))}else{x.attr("href",c.searchUrl)}},autoSelect:function(y){var x=y.attr("href"),w=window.location.hash;if(x!==undefined&&x.charAt(0)=="#"&&x==w){y.addClass("active-region");return false}}},searchButton:function(){var w=p.selectRegion,x=a("<a />",{href:c.searchUrl,"class":"map-search-link",text:c.searchLink});a(i).after(x);x.hover(function(){w.multiple()}).focus(function(){w.multiple()}).click(function(){w.multiple()}).keypress(function(){code=(e.keyCode?e.keyCode:e.which);if(code==13){w.multiple()}})},agentslist:{init:function(){a(i).find(".active-region").each(function(){var w=a(this).children("a").eq(0).attr("href");p.agentslist.showAgent(w)})},showAgent:function(w){if(!c.multipleClick){a(c.agentsListId).find("li").hide()}if(!c.agentsListOnHover){a(w+","+w+" li").fadeIn(c.agentsListSpeed)}else{a(w+","+w+" li").show()}},hideAgents:function(w){if(!c.agentsListOnHover){a(w+","+w+" li").fadeOut(c.agentsListSpeed)}else{a(w+","+w+" li").hide()}}},pins:{init:function(){var y=k.position().top,w=a(i).position().left,z=a(i).outerWidth(),x=parseInt(z/-2),A=a(i).outerHeight(),B={height:A,left:"50%",marginLeft:x,position:"absolute",top:y,width:z};a(m).css(B);d.each(function(){var R=a(this);p.pins.pinContent(R);var E=R.find("."+c.pins.markerClass).eq(0),C=R.find("."+c.pins.pinTooltipClass).eq(0),S=E.attr("href"),N=R.attr("data-cssmap-coords").split(","),O=parseInt(N[0]),L=parseInt(N[1]),G=E.outerWidth(),M=parseInt(G/-2),Q=parseInt(E.outerHeight()),P=C.outerHeight(),D=C.outerWidth(),K=parseInt(D/-2),H=function(){switch(c.pins.markerPosition){case"middle":var T=L-(Q/2);break;case"bottom":var T=L;break;default:var T=L-Q;break}return T},J=function(){switch(c.pins.tooltipPosition){case"hidden":var T="-9999em";break;case"bottom":var T=H()+Q;break;default:var T=H()-P;break}return T},F={left:O,marginLeft:M,position:"absolute",textAlign:"center",top:H(),zIndex:200},I={display:"block",left:O,marginLeft:K,marginTop:"-9999em",opacity:0,position:"absolute",top:J(),zIndex:201};E.css(F);C.css(I);if(c.pins.tooltipOnClick){E.click(function(){if(R.hasClass("hide-tooltip")){p.pins.pinClose(R,E,C)}else{p.pins.pinOpen(R,E,C)}})}else{E.hover(function(){p.pins.pinOpen(R,E,C)},function(){p.pins.pinClose(R,E,C)})}E.click(function(){if(S!==undefined&&S.charAt(0)=="#"){return false}})})},pinContent:function(z){var w=z.find("."+c.pins.pinTooltipClass),y=z.find("."+c.pins.markerClass);if(!w.length){z.wrapInner(a("<div />").addClass(c.pins.pinTooltipClass).hide())}else{w.hide()}if(!y.length){var x=a("<a />",{"class":c.pins.markerClass,href:"#",text:""}).appendTo(z)}},pinOpen:function(y,w,x){a(m).find(".hide-tooltip").each(function(){var B=a(this),z=B.find("."+c.pins.markerClass),A=B.find("."+c.pins.pinTooltipClass),C=z.outerWidth();p.pins.pinClose(B,z,A)});y.addClass("hide-tooltip");x.css("margin-top",0).animate({opacity:1},c.pins.tooltipFadeSpeed)},pinClose:function(y,w,x){y.removeClass("hide-tooltip");x.animate({opacity:0},c.pins.tooltipFadeSpeed,function(){a(this).css("margin-top","-9999em")})}},clearMap:function(){for(var w=100;w<2050;w+=5){v+=" m"+w}k.removeClass(v).removeClass("css-map-container");a(i).removeClass("css-map");k.find(".map-loader, .cities, .m, .bg, .map-visible-list, .map-search-link").remove();k.find("li").removeClass("focus").removeClass("active-region")}};p.init()})}else{return this.html("<b>Error:</b> map size must be set!")}}})(jQuery);

/*! http://mths.be/placeholder v2.0.7 by @mathias */
;(function(window, document, $) {

    var isInputSupported = 'placeholder' in document.createElement('input');
    var isTextareaSupported = 'placeholder' in document.createElement('textarea');
    var prototype = $.fn;
    var valHooks = $.valHooks;
    var propHooks = $.propHooks;
    var hooks;
    var placeholder;

    if (isInputSupported && isTextareaSupported) {

        placeholder = prototype.placeholder = function() {
            return this;
        };

        placeholder.input = placeholder.textarea = true;

    } else {

        placeholder = prototype.placeholder = function() {
            var $this = this;
            $this
                .filter((isInputSupported ? 'textarea' : ':input') + '[placeholder]')
                .not('.placeholder')
                .bind({
                    'focus.placeholder': clearPlaceholder,
                    'blur.placeholder': setPlaceholder
                })
                .data('placeholder-enabled', true)
                .trigger('blur.placeholder');
            return $this;
        };

        placeholder.input = isInputSupported;
        placeholder.textarea = isTextareaSupported;

        hooks = {
            'get': function(element) {
                var $element = $(element);

                var $passwordInput = $element.data('placeholder-password');
                if ($passwordInput) {
                    return $passwordInput[0].value;
                }

                return $element.data('placeholder-enabled') && $element.hasClass('placeholder') ? '' : element.value;
            },
            'set': function(element, value) {
                var $element = $(element);

                var $passwordInput = $element.data('placeholder-password');
                if ($passwordInput) {
                    return $passwordInput[0].value = value;
                }

                if (!$element.data('placeholder-enabled')) {
                    return element.value = value;
                }
                if (value == '') {
                    element.value = value;
                    // Issue #56: Setting the placeholder causes problems if the element continues to have focus.
                    if (element != document.activeElement) {
                        // We can't use `triggerHandler` here because of dummy text/password inputs :(
                        setPlaceholder.call(element);
                    }
                } else if ($element.hasClass('placeholder')) {
                    clearPlaceholder.call(element, true, value) || (element.value = value);
                } else {
                    element.value = value;
                }
                // `set` can not return `undefined`; see http://jsapi.info/jquery/1.7.1/val#L2363
                return $element;
            }
        };

        if (!isInputSupported) {
            valHooks.input = hooks;
            propHooks.value = hooks;
        }
        if (!isTextareaSupported) {
            valHooks.textarea = hooks;
            propHooks.value = hooks;
        }

        $(function() {
            // Look for forms
            $(document).delegate('form', 'submit.placeholder', function() {
                // Clear the placeholder values so they don't get submitted
                var $inputs = $('.placeholder', this).each(clearPlaceholder);
                setTimeout(function() {
                    $inputs.each(setPlaceholder);
                }, 10);
            });
        });

        // Clear placeholder values upon page reload
        $(window).bind('beforeunload.placeholder', function() {
            $('.placeholder').each(function() {
                this.value = '';
            });
        });

    }

    function args(elem) {
        // Return an object of element attributes
        var newAttrs = {};
        var rinlinejQuery = /^jQuery\d+$/;
        $.each(elem.attributes, function(i, attr) {
            if (attr.specified && !rinlinejQuery.test(attr.name)) {
                newAttrs[attr.name] = attr.value;
            }
        });
        return newAttrs;
    }

    function clearPlaceholder(event, value) {
        var input = this;
        var $input = $(input);
        if (input.value == $input.attr('placeholder') && $input.hasClass('placeholder')) {
            if ($input.data('placeholder-password')) {
                $input = $input.hide().next().show().attr('id', $input.removeAttr('id').data('placeholder-id'));
                // If `clearPlaceholder` was called from `$.valHooks.input.set`
                if (event === true) {
                    return $input[0].value = value;
                }
                $input.focus();
            } else {
                input.value = '';
                $input.removeClass('placeholder');
                input == document.activeElement && input.select();
            }
        }
    }

    function setPlaceholder() {
        var $replacement;
        var input = this;
        var $input = $(input);
        var id = this.id;
        if (input.value == '') {
            if (input.type == 'password') {
                if (!$input.data('placeholder-textinput')) {
                    try {
                        $replacement = $input.clone().attr({ 'type': 'text' });
                    } catch(e) {
                        $replacement = $('<input>').attr($.extend(args(this), { 'type': 'text' }));
                    }
                    $replacement
                        .removeAttr('name')
                        .data({
                            'placeholder-password': $input,
                            'placeholder-id': id
                        })
                        .bind('focus.placeholder', clearPlaceholder);
                    $input
                        .data({
                            'placeholder-textinput': $replacement,
                            'placeholder-id': id
                        })
                        .before($replacement);
                }
                $input = $input.removeAttr('id').hide().prev().attr('id', id).show();
                // Note: `$input[0] != input` now!
            }
            $input.addClass('placeholder');
            $input[0].value = $input.attr('placeholder');
        } else {
            $input.removeClass('placeholder');
        }
    }

}(this, document, jQuery));
$(document).ready(function(){
    $('input, textarea').placeholder();
});
