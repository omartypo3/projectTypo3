#page = PAGE
#page {
#    headerData.10 = TEXT
#    headerData.10.value = <script type="text/javascript" src="/typo3conf/ext/j77products/Resources/Public/Frontends/fed/javascript/jquery-3.1.1.min.js"></script>
#    headerData.20 = TEXT
#    headerData.20.value = <link href="/typo3conf/ext/j77products/Resources/Public/Frontends/fed/css/style.min.css" rel="stylesheet" type="text/css" />
#
#    footerData.30 = TEXT
#    footerData.30.value (
#        <script type="text/javascript" src="/typo3conf/ext/j77products/Resources/Public/Frontends/fed/javascript/slick.min.js"></script>
#        <script type="text/javascript" src="/typo3conf/ext/j77products/Resources/Public/Frontends/fed/javascript/collabsible.min.js"></script>
#        <script type="text/javascript" src="/typo3conf/ext/j77products/Resources/Public/Frontends/fed/javascript/mapping.js"></script>
#        <script type="text/javascript" src="/typo3conf/ext/j77products/Resources/Public/Frontends/fed/javascript/custom.js"></script>
#    )
#}

## Products Settings
plugin.tx_j77products {
	settings {
		template.maschinendetail = {$plugin.tx_j77products.settings.template.maschinendetail}
		template.anlagendetail = {$plugin.tx_j77products.settings.template.anlagendetail}
		contact = {$plugin.tx_j77products.settings.contact}
		standAloneAssets = {$plugin.tx_j77products.settings.debugMode}
	}
}

plugin.tx_j77products_maschine {
    view {
        templateRootPaths.0 = EXT:j77products/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_j77products_maschine.view.templateRootPath}
        partialRootPaths.0 = EXT:j77products/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_j77products_maschine.view.partialRootPath}
        layoutRootPaths.0 = EXT:j77products/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_j77products_maschine.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_j77products_maschine.persistence.storagePid}
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
}

plugin.tx_j77products_prozessanlage {
    view {
        templateRootPaths.0 = EXT:j77products/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_j77products_prozessanlage.view.templateRootPath}
        partialRootPaths.0 = EXT:j77products/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_j77products_prozessanlage.view.partialRootPath}
        layoutRootPaths.0 = EXT:j77products/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_j77products_prozessanlage.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_j77products_prozessanlage.persistence.storagePid}
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
}

plugin.tx_j77products_slider {
    view {
        templateRootPaths.0 = EXT:j77products/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_j77products_slider.view.templateRootPath}
        partialRootPaths.0 = EXT:j77products/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_j77products_slider.view.partialRootPath}
        layoutRootPaths.0 = EXT:j77products/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_j77products_slider.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_j77products_slider.persistence.storagePid}
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
}

# these classes are only used in auto-generated templates
plugin.tx_j77products._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-j77products table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-j77products table th {
        font-weight:bold;
    }

    .tx-j77products table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
