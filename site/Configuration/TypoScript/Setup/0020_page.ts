lib.lib.footer_footer_navi = CONTENT
lib.lib.footer_footer_navi {
    table = tt_content
    select.pidInList = {$plugin.tx_site_frontend.settings.footerPageUid}
    select.where = colPos = 8
}
lib.pageResources = FILES
lib.pageResources {
    references {
        table = pages
        uid.data = page:uid
        fieldName = image
    }
    renderObj = IMAGE
    renderObj {
        file {
            import.data = file:current:uid
            treatIdAsReference = 1
            width = 150c
            height = 150c
        }
        altText.data = file:current:alternative
        titleText.data = file:current:title
        params = class="intro-bg-img"
    }
}

lib.pageResourcesVideo = CONTENT
lib.pageResourcesVideo {
    table = sys_file_reference
    select {
        selectFields = 	sys_file.identifier
        where = sys_file_reference.tablenames = 'pages' AND sys_file_reference.fieldname = 'video'
        andWhere = sys_file_reference.uid_foreign = page:uid
        join = sys_file ON (sys_file.uid = sys_file_reference.uid_local)
        andWhere.insertData = 1
        languageField = sys_language_uid
    }
    renderObj = TEXT
    renderObj{
        field = identifier
        wrap = fileadmin|
    }
}
page = PAGE
page {
    headerData {
        10 = TEXT
        10.value (
            <meta charset="utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1"/>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    )
        #5 = TEXT
        #5 {
            #data = page:title
            #noTrimWrap = |<title>|</title>|
        #}
    }

    shortcutIcon = {$plugin.tx_site_frontend.settings.favicon}
    includeCSS {
        style = typo3conf/ext/site/Resources/Public/css/style.min.css
        styleAdd = typo3conf/ext/site/Resources/Public/css/style-add.css
        swiper = typo3conf/ext/site/Resources/Public/css/swiper.css
    }

    includeJSFooter {
        scroll = typo3conf/ext/site/Resources/Public/js/scroll.js
        radialIndicator = typo3conf/ext/site/Resources/Public/js/radialIndicator.js
        swiper = typo3conf/ext/site/Resources/Public/js/swiper.js
        scripts = typo3conf/ext/site/Resources/Public/js/scripts.min.js

    }

    10 = FLUIDTEMPLATE
    10 {
    # for <f:translate>
        extbase.controllerExtensionName = site

        partialRootPath = EXT:site/Resources/Private/FluidPageTemplates/Partials
        layoutRootPath = EXT:site/Resources/Private/FluidPageTemplates/Layouts

        file.stdWrap.cObject = CASE
        file.stdWrap.cObject {
            key.data = pagelayout
        default = TEXT
        default.value = EXT:site/Resources/Private/FluidPageTemplates/Templates/Home.html
            pagets__1 < .default
            pagets__2 = TEXT
            pagets__2.value = EXT:site/Resources/Private/FluidPageTemplates/Partials/Footer.html
            pagets__3 = TEXT
            pagets__3.value = EXT:site/Resources/Private/FluidPageTemplates/Templates/Default.html
        }

        variables {
            Intro < styles.content.get
            Intro.select.where = colPos = 1
            Whyinter < styles.content.get
            Whyinter.select.where = colPos = 2
            Threepillars < styles.content.get
            Threepillars.select.where = colPos = 3
            Quotes < styles.content.get
            Quotes.select.where = colPos = 4
            Sgeagles < styles.content.get
            Sgeagles.select.where = colPos = 5
            PartnerSgeagles < styles.content.get
            PartnerSgeagles.select.where = colPos = 6
            Newsroom < styles.content.get
            Newsroom.select.where = colPos = 7
            Content < styles.content.get
            Content.select.where = colPos = 9


        }
        dataProcessing {
        # example for menu processor ! so no VHS extension needed...

            10 = TYPO3\CMS\Frontend\DataProcessing\MenuProcessor
            10 {
                levels = 1
                entryLevel = 0
                includeSpacer = 0
                as = navMain
            }
        }

    }

    settings < plugin.tx_site.settings
}
