
plugin.tx_dslautologout_felogincheck {
  view {
    templateRootPaths.0 = EXT:dsl_autologout/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_dslautologout_felogincheck.view.templateRootPath}
    partialRootPaths.0 = EXT:dsl_autologout/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_dslautologout_felogincheck.view.partialRootPath}
    layoutRootPaths.0 = EXT:dsl_autologout/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_dslautologout_felogincheck.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_dslautologout_felogincheck.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_dslautologout._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-dsl-autologout table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-dsl-autologout table th {
        font-weight:bold;
    }

    .tx-dsl-autologout table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

plugin.tx_dslautologout_felogincheck.settings.redirectPid = {$plugin.tx_dslautologout_felogincheck.settings.redirectPid}


#lib.dslautologout_felogincheck  < tt_content.list.20.dslautologout_felogincheck






[globalVar = TSFE:id = 79]
	dslautologoutfelogincheck = PAGE
	dslautologoutfelogincheck {
	  typeNum = 89657999
	  config {
		disableAllHeaderCode = 1
		#xhtml_cleaning = 0
		admPanel = 0
		#additionalHeaders = Content-type: text/plain
		no_cache = 1
		debug = 0
	  }
	  10 < tt_content.list.20.dslautologout_felogincheck
	}
[global]
[PIDupinRootline = 79]
	page.footerData.9999 < tt_content.list.20.dslautologout_felogincheck
[global]
#page.headerData.339 = TEXT
#page.headerData.339.value (
#    <person vorname="Mike" Nachname="Zimmer" />
#)
