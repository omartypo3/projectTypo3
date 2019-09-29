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
    language = de
    locale_all = de_DE
    htmlTag_langKey = de
}
[globalVar = GP:L = 1]
    config {
        sys_language_uid = 1
        language = en
        locale_all = en_GB
        htmlTag_langKey = en
    }
[global]
plugin.tx_form {
    settings {
        yamlConfigurations {
            1505042806 = EXT:logifact/Configuration/Yaml/FormSetup.yaml
        }
    }
}
lib.language = COA
lib.language {
    20 = HMENU
    20 {
        special = language
        special.value = 0,1
        special.normalWhenNoLanguage = 0
        wrap =
        1 = TMENU
        1 {
            noBlur = 1
            NO = 1
            NO {
                doNotLinkIt = 1
                linkWrap = <li>|</li>
                stdWrap.override = DE || EN
                stdWrap {
                    typolink {
                        parameter.data = page:uid
                        additionalParams = &L=0 || &L=1
                        ATagParams = hreflang="de-DE" || hreflang="en-GB"
                        addQueryString = 1
                        addQueryString.exclude = id,no_cache,L
                        addQueryString.method = GET
                        no_cache = 0
                    }
                }
            }

            ACT < .NO
            ACT.linkWrap = <li class="d-none">|</li>
            USERDEF1 < .NO
            USERDEF1 {
                linkWrap = <li class="text-muted">|</li>
                stdWrap.typolink >
            }

            USERDEF2 < .ACT
            USERDEF2 {
                linkWrap = <li class="text-muted">|</li>
                stdWrap.typolink >
            }
        }
    }
}
lib.parseFunc_RTE.nonTypoTagStdWrap.encapsLines.nonWrappedTag >
