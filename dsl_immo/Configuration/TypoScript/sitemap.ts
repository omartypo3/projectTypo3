plugin.dd_googlesitemap.skipRootlineCheck=1
plugin.dd_googlesitemap_dmf {
#gittest
immobilien {

    # uid is NECESSARY in the sqlSelect field
    sqlMainTable = tx_dslimmo_domain_model_immobilie

    # if catList depends of column of sqlMainTable (Column name like city or country)
    #sqlCatColumn =
    
    # if catList depends on sqlMMTable (Only works if uid_foreign and uid_local is in use)
    #sqlMMTable = tx_news_domain_model_news_category_mm
    
    # order of the XML output
    sqlOrder = tstamp DESC
    
    # last modified timestamp column (inside of sqlMainTable)
    sqlLastUpdated = tstamp
    
    # sql column of the title
    sqlTitle = objekt_nrextern

    # sql column of keywords
    sqlKeywords = geo_ort

    # frequency
    frequency =

    # typolink additionalParam (must belong to the uid of the sqlMainTable)
    linkParams = {$plugin.tx_dslimmo_immositemap.immobilien.linkParams}

    # csv Pid's of the stored elements. Rootline is not checked with this setting
    pidList = {$plugin.tx_dslimmo_immositemap.immobilien.pidList}
     
    # detail page id where the link should point at
    singlePid = {$plugin.tx_dslimmo_immoout.settings.canonicalPid}
    
    # filter by category which is inside of the main table -> sqlCatColumn
    catList =
    
    # csv filter by mm related table -> sqlMMTable
    catMMList =
    
    # disable the language check through GLOBALS['TSFE']->sys_language_uid
    disableLanguageCheck = 1
  }
	
}
