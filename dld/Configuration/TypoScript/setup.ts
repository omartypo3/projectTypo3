plugin.tx_dld_dldfront {
    view {
        templateRootPaths.0 = EXT:dld/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_dld_dldfront.view.templateRootPath}
        partialRootPaths.0 = EXT:dld/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_dld_dldfront.view.partialRootPath}
        layoutRootPaths.0 = EXT:dld/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_dld_dldfront.view.layoutRootPath}
    }

    persistence {
        storagePid = {$plugin.tx_dld_dldfront.persistence.storagePid}
        #recursive = 1
    }

    features {
        skipDefaultArguments = 1
    }

    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }

    settings {
        youTubeApiKey = AIzaSyBFgc-jxg9kosA5ECj52Hn23j0v2tMo9s4
        youTubeChannelID = UC_lste7714m4UFBef4JTlKw
        youTubeMaxResult = 21
        flickrApiKey = a0bb241c73b709ea1210b4fd958496b1
        flickrUserId = 141594106@N02
        targetPageID = 88
        ParentPageID = 4
        feUserStoragePid = {$plugin.tx_dld_dldfront.settings.feUserStoragePid}
        partnersPid = {$plugin.tx_dld_dldfront.settings.feUserStoragePid}
        EventItemsPerPage = 2
        peopleItemsPerPage = 21
        typeNum = 235
        url = https://softodo1.highrisehq.com
        urlSince = https://softodo1.highrisehq.com/people.xml?since=
        urlXml = https://softodo1.highrisehq.com/people.xml
        higriseKey = aa78772c4120aca7887f625f79c1e7ee
        urlDelete = https://softodo1.highrisehq.com/deletions.xml?since=
        xingApiKey = 9wlW1a1y8KNQIT1d8zYyz7xeUJjRFNZHYFXA0GNabd9YXXfXxB
        urlEvent = typo3conf/ext/theme/Resources/Public/logos/DefaultEventHeader.jpg
        urlPeople = typo3conf/ext/theme/Resources/Public/logos/DefaultPeopleImage.jpg
        urlPatner = typo3conf/ext/theme/Resources/Public/logos/DefaultPartnerImage.png
        profilevisibilitymessage =  Your Profile is not visible to anyone other than the DLD Team
    }
}

config {
    tx_realurl_enable = 1
    spamProtectEmailAddresses = 1
    spamProtectEmailAddresses_atSubst = @
    uniqueLinkVars = 1
    simulateStaticDocuments = 0
    linkVars = L
    absRelPath = /
    absRefPrefix = /
    prefixLocalAnchors = all
}

plugin.tx_dld._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-dld table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-dld table th {
        font-weight:bold;
    }

    .tx-dld table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
plugin.tx_dld_dldevent {
    settings {
        eventPageID = 13
        sessionPageID = 12
        peoplePageID = 11
        partnerPageID = 13
        signupPage = 10
        createdPage = 23
        conferencePage = 476
        invitedpage = 10
        urlEvent = typo3conf/ext/theme/Resources/Public/logos/DefaultEventHeader.jpg
        urlPeople = typo3conf/ext/theme/Resources/Public/logos/DefaultPeopleImage.jpg
        urlPatner = typo3conf/ext/theme/Resources/Public/logos/DefaultPartnerImage.png
    }
}

# Module configuration
module.tx_dld_web_dlddldback {
    persistence {
        storagePid = {$module.tx_dld_dldback.persistence.storagePid}
    }

    view {
        templateRootPaths.0 = EXT:dld/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_dld_dldback.view.templateRootPath}
        partialRootPaths.0 = EXT:dld/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_dld_dldback.view.partialRootPath}
        layoutRootPaths.0 = EXT:dld/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_dld_dldback.view.layoutRootPath}
    }
}

plugin.tx_femanager {
    settings {
        invitation {
            forceValues {
                tx_extbase_type = TEXT

                beforeAnyConfirmation {
                    usergroup = TEXT
                    usergroup.value = 1
                }

                onUserConfirmation {
                    usergroup = TEXT
                    usergroup.value = 1
                }

                onAdminConfirmation {
                    usergroup = TEXT
                    usergroup.value = 1
                }
            }
        }
    }
}

plugin_speakerfilter_ajax = PAGE
plugin_speakerfilter_ajax {
    typeNum = 555
    10 < tt_content.list.20.dld_dldfront
    config {
        disableAllHeaderCode = 1
        xhtml_cleaning = 1
        admPanel = 0
        additionalHeaders = Content-type: text/plain
        no_cache = 1
    }
}


plugin.tx_dld_dldyoutube {
    view {
        templateRootPaths = EXT:dld/Resources/Private/Templates/
        partialRootPaths = EXT:dld/Resources/Private/Partials/
        layoutRootPaths = EXT:dld/Resources/Private/Layouts/
    }

    persistence {
        storagePid = {$plugin.tx_dld_dldyoutube.persistence.storagePid}
    }

    settings {
        typeNum = {$plugin.tx_dld_dldyoutube.settings.typeNum}
    }
}


// PAGE object for Ajax call:
youtube_page = PAGE
youtube_page {
    typeNum = 135
    10 < tt_content.list.20.dld_dldyoutube
    config {
        disableAllHeaderCode = 1
        xhtml_cleaning = 1
        admPanel = 0
        additionalHeaders = Content-type: text/plain
        no_cache = 1
    }


}
