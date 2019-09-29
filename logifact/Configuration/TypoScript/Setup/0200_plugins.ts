plugin.tx_logifact_frontend {
    view {
        templateRootPaths.0 = {$plugin.tx_logifact_frontend.view.templateRootPaths.0}
        partialRootPaths.0 = {$plugin.tx_logifact_frontend.view.partialRootPaths.0}
        layoutRootPaths.0 = {$plugin.tx_logifact_frontend.view.layoutRootPaths.0}
    }

    settings {
        logoImagePath = {$plugin.tx_logifact_frontend.settings.logoImagePath}
        shopImagePath = {$plugin.tx_logifact_frontend.settings.shopImagePath}
        shopImageText = {$plugin.tx_logifact_frontend.settings.shopImageText}
        shopImagelink = {$plugin.tx_logifact_frontend.settings.shopImagelink}
        footerPageUid = {$plugin.tx_logifact_frontend.settings.footerPageUid}
        footerNavigationPageUid = {$plugin.tx_logifact_frontend.settings.footerNavigationPageUid}
        rightMenuPageUid = {$plugin.tx_logifact_frontend.settings.rightMenuPageUid}
        contactNumber = {$plugin.tx_logifact_frontend.settings.contactNumber}
        ContactMail = {$plugin.tx_logifact_frontend.settings.ContactMail}
        mapsLocationLink = {$plugin.tx_logifact_frontend.settings.mapsLocationLink}
    }
}
plugin.tx_news {
    view {
        templateRootPaths {
            0 = EXT:news/Resources/Private/Templates/
            1 = EXT:logifact/Resources/Ext/News/Private/Templates/
        }

        partialRootPaths {
            0 = EXT:news/Resources/Private/Partials/
            1 = EXT:logifact/Resources/Ext/News/Private/Partials/
        }

        layoutRootPaths {
            0 = EXT:news/Resources/Private/Layouts/
            1 = EXT:logifact/Resources/Ext/News/Private/Layouts/
        }

    }
#    script {
#        name = script
#        path = EXT:bpi_waeschereien/Resources/Public/Js/newsListPagination.js
#    }
}
