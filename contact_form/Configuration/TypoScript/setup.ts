plugin.tx_contactform_fecontactform {
    view {
        templateRootPaths.0 = EXT:contact_form/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_contactform_fecontactform.view.templateRootPath}
        partialRootPaths.0 = EXT:contact_form/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_contactform_fecontactform.view.partialRootPath}
        layoutRootPaths.0 = EXT:contact_form/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_contactform_fecontactform.view.layoutRootPath}
    }

    persistence {
        storagePid = {$plugin.tx_contactform_fecontactform.persistence.storagePid}
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

    settings {
        backendSectionPageUid = 5
        EventsListPageUid = 6
        ParticipantListPageUid = 14
        UsersListPageUid = 12
        EventsStoragePageUid = 2
        ParticipantsStoragePageUid = 3
        UsersStoragePageUid = 4
    }
}

plugin.tx_contactform_feevents {
    view {
        templateRootPaths.0 = EXT:contact_form/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_contactform_feevents.view.templateRootPath}
        partialRootPaths.0 = EXT:contact_form/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_contactform_feevents.view.partialRootPath}
        layoutRootPaths.0 = EXT:contact_form/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_contactform_feevents.view.layoutRootPath}
    }

    persistence {
        storagePid = {$plugin.tx_contactform_feevents.persistence.storagePid}
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

ajaxselectlist_page = PAGE
ajaxselectlist_page {
    typeNum = 555
    10 < tt_content.list.20.contactform_feevents
    config {
        disableAllHeaderCode = 1
        xhtml_cleaning = 1
        admPanel = 0
        additionalHeaders = Content-type: text/plain
        no_cache = 1
    }
}

page = PAGE
page {
    headerData {
        10 = TEXT
        10.value (
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name =" robots " content =" noindex, nofollow ">
        )
    }

    includeJSFooter {
        jquery = https://code.jquery.com/jquery-2.2.0.min.js
        popper = https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js
        bootstrapjs = https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js
        participants = typo3conf/ext/contact_form/Resources/Public/JS/searchParticpants.js
        search = typo3conf/ext/contact_form/Resources/Public/JS/searchEvents.js
    }
}

download = PAGE
download {
    typeNum = 1249058993
    10 < tt_content.list.20.contactform_feevents

    config {
        disableAllHeaderCode = 1
        xhtml_cleaning = 0
        admPanel = 0
        additionalHeaders = Content-type:application/octet-stream
    }
}

search = PAGE
search {
    typeNum = 555
    10 < tt_content.list.20.contactform_fecontactform

    config {
        disableAllHeaderCode = 1
        xhtml_cleaning = 0
        admPanel = 0
        additionalHeaders = Content-type:application/octet-stream
    }
}

[userFunc = TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('felogin')]
    plugin.tx_felogin_pi1 {
        exposeNonexistentUserInForgotPasswordDialog = 1
        welcomeHeader_stdWrap.wrap = <div class="panel-heading"> | </div>
        logoutHeader_stdWrap.wrap = <div class="panel-heading"> | </div>
        forgotHeader_stdWrap.wrap = <div class="panel-heading"> | </div>
    }

    plugin.tx_felogin_pi1._LOCAL_LANG.default {
        ll_welcome_header = Login
        ll_logout_header = Login
        username = E-Mail Address
        password = Password
        permalogin = Remember Me
        login = Sign in
        reset_password = Send
        forgot_password = Forgot your password?
    }
[global]

lib.logOut = COA_INT
lib.logOut {
    10 = COA
    10 {
        20 = TEXT
        20.typolink.parameter = 3
        20.typolink.returnLast = url
        20.wrap = <form id="logoutform" action="|" method="post">

        25 = COA
        25 {
            5 = TEXT
            5.data = TSFE:fe_user|user|first_name
            5.wrap = <span class='welcome'>Welcome&nbsp;|</span>
        }

        30 = COA
        30 {
            5 = TEXT
            5.wrap = <a href="javascript:{}" onclick="document.getElementById('logoutform').submit(); return false;" classe='user'>Logout</a>
            10 = TEXT
            10.value = <input type="hidden" name="logintype" value="logout" />
            20 = TEXT
            20.value = <input type="hidden" name="redirect_url" value="" />
            30 = TEXT
            30.value = </span></form>
        }
    }

    20 = HMENU
    20.special = list
    20.special.value = 38
    20.includeNotInMenu = 1
    20.1 = TMENU
    20.1 {
        noBlur = 1
        expAll = 1
        IFSUB = 1
        NO {
            ATagTitle.field = 1
        }

        ACT = 1
        ACT {
            ATagTitle.field = 1
            stdWrap.htmlSpecialChars = 1
            ATagParams = class="active"
        }
    }
}
