lib.footer_service_telefon_text = CONTENT
lib.footer_service_telefon_text {
    table = tt_content
    select.pidInList = {$plugin.tx_logifact_frontend.settings.footerPageUid}
    select.where = colPos = 5
}

lib.rightMenu = COA
lib.rightMenu {
    10 = CONTENT
    10 {
        table = tt_content
        select.pidInList.field = pageuid
    }
}

lib.footer_anfahrt_kontaktformular_button_text = CONTENT
lib.footer_anfahrt_kontaktformular_button_text {
    table = tt_content
    select.pidInList = {$plugin.tx_logifact_frontend.settings.footerPageUid}
    select.where = colPos = 6
}

lib.lib.footer_footer_navi = CONTENT
lib.lib.footer_footer_navi {
    table = tt_content
    select.pidInList = {$plugin.tx_logifact_frontend.settings.footerPageUid}
    select.where = colPos = 7
}

lib.footer_Fernwartung_OnlineShop = CONTENT
lib.footer_Fernwartung_OnlineShop {
    table = tt_content
    select.pidInList = {$plugin.tx_logifact_frontend.settings.footerPageUid}
    select.where = colPos = 8
}

lib.footer_newsletter_anmeldung_archiv = CONTENT
lib.footer_newsletter_anmeldung_archiv {
    table = tt_content
    select.pidInList = {$plugin.tx_logifact_frontend.settings.footerPageUid}
    select.where = colPos = 9
}
page = PAGE
page {
    headerData {
        10 = TEXT
        10.value (
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    )
        5 = TEXT
        5 {
            data = page:title
            noTrimWrap = |<title>|</title>|
        }
    }

    shortcutIcon = EXT:logifact/Resources/Public/Img/favicon.ico
    includeCSS {
        style = typo3conf/ext/logifact/Resources/Public/Css/style.css
        flex = typo3conf/ext/logifact/Resources/Public/Css/flexslider.css
        boilerplate = typo3conf/ext/logifact/Resources/Public/Css/boilerplate.css
        buttons = typo3conf/ext/logifact/Resources/Public/Css/buttons.css
        slideform = typo3conf/ext/logifact/Resources/Public/Css/slideform.css
        carousel = typo3conf/ext/logifact/Resources/Public/Css/carousel.css
        anythingSlider = typo3conf/ext/logifact/Resources/Public/Css/style-anythingSlider.css
        jquery-ui = typo3conf/ext/logifact/Resources/Public/Css/jquery-ui.css
        news-ui = typo3conf/ext/logifact/Resources/Public/Css/news.css
        newsbase = typo3conf/ext/logifact/Resources/Public/Css/news-basic.css
        fontNoto = https://fonts.googleapis.com/css?family=Noto+Serif
        fontOpen = https://fonts.googleapis.com/css?family=Open+Sans
        cookie = https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/dark-top.css
        #leafletcss= typo3conf/ext/logifact/Resources/Public/Css/leaflet.css
    }

    includeJSFooter {
        jquery = //code.jquery.com/jquery-2.1.1.min.js
            jquery.external = 1
        flexslider = typo3conf/ext/logifact/Resources/Public/Js/jquery.flexslider-min.js
        camaliga = fileadmin/templates/camaliga/javascript/jquery.camaliga.js
        lightbox = fileadmin/templates/colorbox/jquery.colorbox-min.js
        menu1 = fileadmin/templates/menu/js/classie.js
        anythingslider = typo3conf/ext/logifact/Resources/Public/Js/anythingslider.js
        zzz = fileadmin/templates/js/custom.js
        menu2 = fileadmin/templates/menu/js/nav.js
        jqueryUi = typo3conf/ext/logifact/Resources/Public/Js/jquery-ui-1.9.2.custom.min.js
        slideform = typo3conf/ext/logifact/Resources/Public/Js/slideform.js
        #leaflet = typo3conf/ext/logifact/Resources/Public/Js/leaflet.js
        map = https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6Cv1ODns3SIQd-ocv0OcUpXKagGSqqg&callback=initMap
        main = typo3conf/ext/logifact/Resources/Public/Js/main.js

    }

    10 = FLUIDTEMPLATE
    10 {
    # for <f:translate>
        extbase.controllerExtensionName = logifact

        partialRootPath = EXT:logifact/Resources/Private/FluidPageTemplates/Partials
        layoutRootPath = EXT:logifact/Resources/Private/FluidPageTemplates/Layouts

        file.stdWrap.cObject = CASE
        file.stdWrap.cObject {
            key.data = pagelayout
        default = TEXT
        default.value = EXT:logifact/Resources/Private/FluidPageTemplates/Templates/Default.html
            pagets__1 < .default
            pagets__2 = TEXT
            pagets__2.value = EXT:logifact/Resources/Private/FluidPageTemplates/Templates/Profile.html
            pagets__3 = TEXT
            pagets__3.value = EXT:logifact/Resources/Private/FluidPageTemplates/Templates/NoCols.html
            pagets__4 = TEXT
            pagets__4.value = EXT:logifact/Resources/Private/FluidPageTemplates/Partials/Footer.html
        }

        variables {
            mainContent < styles.content.get
            mainContent.select.where = colPos = 0
            headerContent < styles.content.get
            headerContent.select.where = colPos = 1

            profileHeaderContent < styles.content.get
            profileHeaderContent.select.where = colPos = 2
            profileMainContent < styles.content.get
            profileMainContent.select.where = colPos = 3

            nocolsMainContent < styles.content.get
            nocolsMainContent.select.where = colPos = 4

            service_telefon_text < lib.footer_service_telefon_text
            anfahrt_kontaktformular_button_text < lib.footer_anfahrt_kontaktformular_button_text
            footer_navi < lib.footer_footer_navi
            Fernwartung_OnlineShop < lib.footer_Fernwartung_OnlineShop
            newsletter_anmeldung_archiv < lib.footer_newsletter_anmeldung_archiv
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

            20 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
            20 {
                table = tt_content
                pidInList.field = uid
                where = CType = "gridelements_pi1" and sectionIndex = 1
                orderBy = sorting
                as = subNav
            }

            30 = TYPO3\CMS\Frontend\DataProcessing\MenuProcessor
            30 {
                special = directory
                special.value = {$plugin.tx_logifact_frontend.settings.footerNavigationPageUid}
                levels = 3
                includeSpacer = 1
                as = footerNavigation
            }

            40 = TYPO3\CMS\Frontend\DataProcessing\MenuProcessor
            40 {
                special = directory
                special.value = {$plugin.tx_logifact_frontend.settings.rightMenuPageUid}
                levels = 3
                includeSpacer = 1
                as = rightmenu
            }
        }
    }

    settings < plugin.tx_logifact.settings
}

page.headerData.91 = CASE
page.headerData.91 {
    stdWrap.wrap = <link rel="stylesheet" type="text/css" href="typo3conf/ext/logifact/Resources/Public/Css/|" media="all" />
    key.data = pagelayout
    key.override.field = backend_layout
default = TEXT
default.value = style_Handy_Tablet_Ipad.css
    pagets__1 = TEXT
    pagets__1.value = style_Handy_Tablet_Ipad.css
    pagets__2 = TEXT
    pagets__2.value = style_Handy_Tablet_Ipad_Profil.css
    pagets__3 = TEXT
    pagets__3.value = style_Handy_Tablet_Ipad_Standard.css
}

page.headerData.92 = CASE
page.headerData.92 {
    stdWrap.wrap = <link rel="stylesheet" type="text/css" href="typo3conf/ext/logifact/Resources/Public/Css/|" media="all" />
    key.data = pagelayout
    key.override.field = backend_layout
default = TEXT
default.value = style_Desktop.css
    pagets__1 = TEXT
    pagets__1.value = style_Desktop.css
    pagets__2 = TEXT
    pagets__2.value = style_Desktop_Profil.css
    pagets__3 = TEXT
    pagets__3.value = style_Desktop_Standard.css
}


