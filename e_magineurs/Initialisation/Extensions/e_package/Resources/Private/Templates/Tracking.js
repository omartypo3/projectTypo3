var tagAnalyticsCNIL = {}

tagAnalyticsCNIL.CookieConsent = function() {
    var gaProperty = '{UA}'
    var disableStr = 'ga-disable-' + gaProperty;
    var firstCall = false;
    var showBannerTxt = "{showBanner}";
    var askDNTConfirmationTxt = "{askDNTConfirmation}";
    var createInformAndAskDivTxt = "{createInformAndAskDiv}";
    var oppositionTxt = "{opposition}";

    function getCookieExpireDate() { 
        var cookieTimeout = {cookieTimeout};
        var date = new Date();
        date.setTime(date.getTime()+cookieTimeout);
        var expires = "; expires="+date.toGMTString();
        return expires;
    }
    function checkFirstVisit() {
       var consentCookie =  getCookie('hasConsent'); 
       if ( !consentCookie ) return true;
    }
    function showBanner(){
        var bodytag = document.getElementById('cookieCnil');
        var div = document.createElement('div');
        div.setAttribute('id','cookie-banner');
        div.innerHTML =  '<div id="cookie-banner-message">'+showBannerTxt+'<br/><f:link.page pageUid="{lienInfo}">En savoir plus</f:link.page> - <a href="javascript:tagAnalyticsCNIL.CookieConsent.showInform()">Accepter ou s\'opposer</a></div>';
        bodytag.parentNode.insertBefore(div, bodytag.nextSibling);
        bodytag.appendChild(div);
        document.getElementById('cookieCnil').className+=' cookiebanner';    
        createInformAndAskDiv();
    }     
    function getCookie(NameOfCookie)  {
        if (document.cookie.length > 0) {        
            begin = document.cookie.indexOf(NameOfCookie+"=");
            if (begin != -1)  {
                begin += NameOfCookie.length+1;
                end = document.cookie.indexOf(";", begin);
                if (end == -1) end = document.cookie.length;
                return unescape(document.cookie.substring(begin, end)); 
            }
         }
        return null;
    }
    function getInternetExplorerVersion() {
      var rv = -1;
      if (navigator.appName == 'Microsoft Internet Explorer')  {
        var ua = navigator.userAgent;
        var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
          rv = parseFloat( RegExp.$1 );
      }  else if (navigator.appName == 'Netscape')  {
        var ua = navigator.userAgent;
        var re  = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
          rv = parseFloat( RegExp.$1 );
      }
      return rv;
    }
    function askDNTConfirmation() {
        var r = confirm(askDNTConfirmationTxt);
        return r;
    }
    function notToTrack() {
        if ( (navigator.doNotTrack && (navigator.doNotTrack=='yes' || navigator.doNotTrack=='1'))
            || ( navigator.msDoNotTrack && navigator.msDoNotTrack == '1') ) {
            var isIE = (getInternetExplorerVersion()!=-1)
            if (!isIE){    
                 return true;
            }
            return false;
        }
    }
    function isToTrack() {
        if ( navigator.doNotTrack && (navigator.doNotTrack=='no' || navigator.doNotTrack==0 )) {
            return true;
        }
    }   
    function delCookie(name )   {
        var path = ";path=" + "/";
        var hostname = document.location.hostname;
        if (hostname.indexOf("www.") === 0)
            hostname = hostname.substring(4);
        var domain = ";domain=" + "."+hostname;
        var expiration = "Thu, 01-Jan-1970 00:00:01 GMT";       
        document.cookie = name + "=" + path + domain + ";expires=" + expiration;
    }      
    function deleteAnalyticsCookies() {
        var cookieNames = ["__utma","__utmb","__utmc","__utmt","__utmv","__utmz","_ga","_gat"]
        for (var i=0; i<cookieNames.length; i++)
            delCookie(cookieNames[i])
    }
    function createInformAndAskDiv() {
        var bodytag = document.getElementById('cookieCnil');
        var div = document.createElement('div');
        div.setAttribute('id','inform-and-ask');
        //div.style.width= window.innerWidth+"px" ;
        //div.style.height= window.innerHeight+"px";
        div.style.display= "none";
        //div.style.position= "fixed";
        div.innerHTML = '<div id="inform-and-consent">'+createInformAndAskDivTxt+'<br/><button name="S\'opposer" onclick="tagAnalyticsCNIL.CookieConsent.gaOptout();" id="optout-button" >S\'opposer</button><button name="Accepter" id="acceptCookie" onclick="tagAnalyticsCNIL.CookieConsent.hideInform()">Accepter</button></div>';
        //bodytag.insertBefore(div,bodytag.firstChild); 
        bodytag.parentNode.insertBefore(div, bodytag.nextSibling);
        bodytag.appendChild(div);
    }
    function isClickOnOptOut(evt) { 
        return(evt.target.parentNode.id == 'cookie-banner' || evt.target.parentNode.parentNode.id =='cookie-banner' 
        || evt.target.id == 'optout-button')
    }
    function consent(evt) {
        jQuery("#acceptCookie").click(function(evt) {
            evt.preventDefault();
            document.cookie = 'hasConsent=true; '+ getCookieExpireDate() +' ; path=/'; 
            callGoogleAnalytics();
            clickprocessed = true;
            //window.setTimeout(function() {evt.target.click();}, 1000)
        });
    }
    function callGoogleAnalytics() {
        if (firstCall) return;
        else firstCall = true; 
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', gaProperty, 'auto');
      ga('send', 'pageview');

    }
    return {
         gaOptout: function() {
            document.cookie = disableStr + '=true;'+ getCookieExpireDate() +' ; path=/';       
            document.cookie = 'hasConsent=false;'+ getCookieExpireDate() +' ; path=/';
            var div = document.getElementById("inform-and-ask");
            div.style.display = "none";
            var div = document.getElementById('cookie-banner');
            div.style.display = "";
            if ( div!= null ) div.innerHTML = '<div id="cookie-message">'+oppositionTxt+'</div>'
            window[disableStr] = true;
            clickprocessed = true;
            deleteAnalyticsCookies();
        },
         showInform: function() {
            var div = document.getElementById("inform-and-ask");
            div.style.display = "";
            var div = document.getElementById("cookie-banner");
            div.style.display = "none";
        },
         hideInform: function() {
            var div = document.getElementById("inform-and-ask");
            div.style.display = "none";
            var div = document.getElementById("cookie-banner");
            div.style.display = "none";
        },
        start: function() {
            var consentCookie =  getCookie('hasConsent');
            clickprocessed = false; 
            if (!consentCookie) {
                if (notToTrack() ){ 
                    tagAnalyticsCNIL.CookieConsent.gaOptout()
                    alert("Vous avez activé Do Not Track, nous respectons votre choix")
                } else {
                    if (isToTrack() ) { 
                        consent();
                    } else {
                        if (window.addEventListener) { 
                            window.addEventListener("load", showBanner, false);
                            //inform-and-consent button
                            document.addEventListener("click", consent, false);
                        } else {
                            window.attachEvent("onload", showBanner);
                            //document.attachEvent("onclick", consent);
                        }
                    }
                }
            } else {
                if (document.cookie.indexOf('hasConsent=false') > -1) 
                    window[disableStr] = true;
                else 
                    callGoogleAnalytics();
            }
        }
    }
}();
tagAnalyticsCNIL.CookieConsent.start();