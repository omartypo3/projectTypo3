config {
    concatenateJs = 0
    concatenateCss = 0
    compressJs = 0
    compressCss = 0
    contentObjectExceptionHandler = 0
    absRefPrefix = /
# default language settings
    linkVars = L
    sys_language_uid = 0
    language = en
    locale_all = en_GB
    htmlTag_langKey = en
    tx_realurl_enable = 1
    index_enable = 1
    sys_language_mode = content_fallback
    sys_language_overlay = 1
    prefixLocalAnchors = all
}
[globalVar = GP:L = 1]
config {
    sys_language_uid = 1
    language = fr
    locale_all = fr_FR
    htmlTag_langKey = fr
}
[global]
[globalVar = GP:L = 2]
config {
    sys_language_uid = 2
    language = jp
    locale_all = jp_JP
    htmlTag_langKey = jp
}
[global]
[globalVar = GP:L = 3]
config {
    sys_language_uid = 3
    language = cn
    locale_all = cn_CN
    htmlTag_langKey = cn
}
[global]
[globalVar = GP:L = 4]
config {
    sys_language_uid = 4
    language = ar
    locale_all = ar_AR
    htmlTag_langKey = ar
}
[global]
[globalVar = GP:L = 5]
config {
    sys_language_uid = 5
    language = de
    locale_all = de_DE
    htmlTag_langKey = de
}
[global]
lib.language = COA
lib.language {
    20 = HMENU
    20 {
        special = language
        special.value = {$plugin.tx_site_frontend.settings.language}
        #special.value = 0
        special.normalWhenNoLanguage = 0
        wrap =  <ul class="nav header-lang"> | </ul>
        1 = TMENU
        1 {
            noBlur = 1
            NO = 1
            NO {
                doNotLinkIt = 1
                linkWrap = <li class="header-lang__item ">  <span class="header-lang__title">en</span> | </li> || <li class="header-lang__item ">  <span class="header-lang__title">fr</span> | </li> || <li class="header-lang__item ">  <span class="header-lang__title">jp</span> | </li> || <li class="header-lang__item ">  <span class="header-lang__title">cn</span> | </li> || <li class="header-lang__item ">  <span class="header-lang__title">ar</span> | </li> || <li class="header-lang__item ">  <span class="header-lang__title">de</span> | </li>
                #linkWrap = <li class="header-lang__item ">  <span class="header-lang__title">en</span> | </li>
                stdWrap.override =<img class="header-lang__icon" src="typo3conf/ext/site/Resources/Public/img/svg/countries/uk.svg" alt="uk language icon" />  || <img class="header-lang__icon" src="typo3conf/ext/site/Resources/Public/img/svg/countries/france.svg" alt="france language icon" />  || <img class="header-lang__icon" src="typo3conf/ext/site/Resources/Public/img/svg/countries/japan.svg" alt="japan language icon" /> || <img class="header-lang__icon" src="typo3conf/ext/site/Resources/Public/img/svg/countries/china.svg" alt="china language icon" /> ||  <img class="header-lang__icon" src="typo3conf/ext/site/Resources/Public/img/svg/countries/uae.svg" alt="uae language icon" /> || <img class="header-lang__icon" src="typo3conf/ext/site/Resources/Public/img/svg/countries/germany.svg" alt="germany language icon" />
                #stdWrap.override =<img class="header-lang__icon" src="typo3conf/ext/site/Resources/Public/img/svg/countries/uk.svg" alt="uk language icon" />
                    stdWrap {
                    typolink {
                        parameter.data = page:uid
                        #additionalParams = &L=0
                        additionalParams = &L=0 || &L=1 || &L=2 || &L=3 || &L=4 || &L=5
                        addQueryString = 1
                        ATagParams = class="nav-link"
                        addQueryString.exclude = id,no_cache,L
                        addQueryString.method = GET
                        no_cache = 0
                    }
                }
            }
            ACT < .NO
            ACT.linkWrap = <li id="chosen-lang" class="header__chosen-lang">  <span class="header-lang__title">en</span> | </li> || <li id="chosen-lang" class="header__chosen-lang">  <span class="header-lang__title">fr</span> | </li> || <li id="chosen-lang" class="header__chosen-lang">  <span class="header-lang__title">jp</span> | </li> || <li id="chosen-lang" class="header__chosen-lang">  <span class="header-lang__title">cn</span> | </li> || <li id="chosen-lang" class="header__chosen-lang">  <span class="header-lang__title">ar</span> | </li> || <li id="chosen-lang" class="header__chosen-lang">  <span class="header-lang__title">de</span> | </li>
            #ACT.linkWrap = <li id="chosen-lang" class="header__chosen-lang">  <span class="header-lang__title">en</span> | </li>

        }
    }
}
lib.navifooter = HMENU
lib.navifooter{
    entryLevel = 0
    special = directory
    special.value = {$plugin.tx_site_frontend.settings.footerNaviPageUid}
    wrap=<ul class="footer-menu__items">|</ul>
    1 = TMENU
    1{
        expAll = 1
        noBlur = 1

        NO = 1
        NO {
            wrapItemAndSub = <li class="footer-menu__item">|</li>
            stdWrap.insertData = 1
        }
        ACT = 1
        ACT {
            wrapItemAndSub = <li class="footer-menu__item">|</li>
            stdWrap.insertData = 1
        }
    }
}
lib.parseFunc_RTE.nonTypoTagStdWrap.encapsLines.nonWrappedTag >
