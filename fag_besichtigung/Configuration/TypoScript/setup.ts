
plugin.tx_fagbesichtigung_besichtigung {
    view {
        templateRootPaths.0 = EXT:fag_besichtigung/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_fagbesichtigung_besichtigung.view.templateRootPath}
        partialRootPaths.0 = EXT:fag_besichtigung/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_fagbesichtigung_besichtigung.view.partialRootPath}
        layoutRootPaths.0 = EXT:fag_besichtigung/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_fagbesichtigung_besichtigung.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_fagbesichtigung_besichtigung.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
    settings{
        offer-title = Besichtigungsangebot
        panel = mehr erfahren
        anfragePage = 1129
        HomePage = 1128
        stepTitle1 = Anfrage
        stepTitle1_subheader = Wählen Sie zwischen öffentlicher oder privaten Besichtigung.1
        stepTitle2 = Datum buchen
        stepTitle2_subheader = Wählen Sie das gewünschte Datum aus.
        stepTitle2_p =  Kleinwasserkraftwerk Mühlenplatz
        stepTitle3_private = Kontaktdaten private Besichtigung
        stepTitle3_free = Kontaktdaten Öffentliche Besichtigung
        stepTitle3_subheader = Bitte geben Sie Ihre Kontaktdaten ein.
        stepTitle3_p = Bitte geben Sie Ihre Kontaktdaten ein.
        Helfenstein_email = rb@frontal.ch
    }
}

page = PAGE
page.includeCSS{
    offer = EXT:fag_besichtigung/Resources/Public/css/offer.css
    stepper = EXT:fag_besichtigung/Resources/Public/css/bs-stepper.min.css
    swiper = EXT:fag_besichtigung/Resources/Public/css/swiper.css
}
page.includeJSFooter{
    steppermin = https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js
    swiper = EXT:fag_besichtigung/Resources/Public/js/swiper.js
    stepper = EXT:fag_besichtigung/Resources/Public/js/bs-stepper.js
}

# these classes are only used in auto-generated templates
plugin.tx_fagbesichtigung._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-fag-besichtigung table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-fag-besichtigung table th {
        font-weight:bold;
    }

    .tx-fag-besichtigung table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
