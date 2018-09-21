<?php
$TYPO3_CONF_VARS['FE']['addRootLineFields'] .= ',tx_realurl_pathsegment,alias,nav_title,title';
//$TYPO3_CONF_VARS['SYS']['curlUse'] = '1';
//$TYPO3_CONF_VARS["FE"]["pageNotFound_handling"] = 'USER_FUNCTION:typo3conf/ext/theme/Configuration/notFound_userProc.php:user_notFound->pageNotFound';
//$TYPO3_CONF_VARS["FE"]["pageNotFound_handling_statheader"] = 'HTTP/1.1 404 Not Found';
$TYPO3_CONF_VARS['EXTCONF']['realurl'] = array(
    'encodeSpURL_postProc' => array('user_encodeSpURL_postProc'),
    'decodeSpURL_preProc' => array('user_decodeSpURL_preProc'),
    '_DEFAULT' => array(
        'init' => array(
            'enableCHashCache' => 1,
            'appendMissingSlash' => 'ifNotFile,redirect[301]',
            'adminJumpToBackend' => 1,
            'enableUrlDecodeCache' => 1,
            'enableUrlEncodeCache' => 1,
            'respectSimulateStaticURLs' => 0,
            'postVarSet_failureMode'=> '',
            'emptyUrlReturnValue' => '/',
            'doNotRawUrlEncodeParameterNames' => 1,
            'enableAllUnicodeLetters' => 1
        ),

        'redirects' => array (
        ),
        'preVars' => array(
            array(
                'GETvar' => 'no_cache',
                'valueMap' => array(
                    'nc' => 0,
                ),
                'noMatch' => 'bypass',
            ),
        ),
        'pagePath' => array(
            'type'                  => 'user',
            'userFunc'              => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
            'spaceCharacter'        => '-',
            'languageGetVar'        => 'L',
            'expireDays'            => 5,
            'rootpage_id'           => 1,
            'segTitleFieldList'     => 'tx_realurl_pathsegment,nav_title,title,subtitle',
            'languageExceptionUids' => '10',
            'languageFallback'      => '0',
            'autoUpdatePathCache'   => true,
            'disablePathCache'      => false,
            //				'firstHitPathCache' => 1,
        ),
        'fixedPostVars' => array(
            '10'                           => 'invitation',
            'invitation'             => array(
                array(
                    'GETvar' => 'tx_dld_dldevent[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldevent[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldevent[invited]',
                    'noMatch' => 'bypass'
                ),
            ),
            '10'                           => 'login',
            'login'             => array(
                array(
                    'GETvar' => 'tx_dld_tx_dld_dldevent[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_tx_dld_dldevent[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_tx_dld_dldevent[event]',
                    'lookUpTable' => [
                        'table' => 'tx_dld_domain_model_event',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                        'expireDays' => 180,
                        'enable404forInvalidAlias' => true
                    ]
                ),
            ),
            '49'                           => 'tx_dld_dldfront',
            'tx_dld_dldfront'             => array(
                array(
                    'GETvar' => 'tx_dld_dldfront[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar'      => 'tx_dld_dldfront[partner]',
                    'lookUpTable' => array(
                        'table'                    => 'tx_dld_domain_model_partner',
                        'id_field'                 => 'uid',
                        'alias_field'              => 'name',
                        'addWhereClause'           => ' AND NOT deleted',
                        'useUniqueCache'           => 1,
                        'useUniqueCache_conf'      => array(
                            'strtolower'     => 1,
                            'spaceCharacter' => '-',
                        ),
                        'languageGetVar'           => 'L',
                        'languageExceptionUids'    => '',
                        'languageField'            => 'sys_language_uid',
                        'transOrigPointerField'    => 'l10n_parent',
                        'enable404forInvalidAlias' => 1,
                        'autoUpdate'               => 1,
                        'expireDays'               => 180,
                    ),
                )
            ),
            '50'                           => 'people',
            'people'             => array(
                array(
                    'GETvar' => 'tx_dld_dldfront[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar'      => 'tx_dld_dldfront[people]',
                    'lookUpTable' => array(
                        'table'                    => 'fe_users',
                        'id_field'                 => 'uid',
                        'alias_field'              => 'username',
                        'addWhereClause'           => ' AND NOT deleted',
                        'useUniqueCache'           => 1,
                        'useUniqueCache_conf'      => array(
                            'strtolower'     => 1,
                            'spaceCharacter' => '-',
                        ),
                    ),
                )
            ),
            '29'                           => 'dldteam',
            'dldteam'             => array(
                array(
                    'GETvar' => 'tx_dld_dldfront[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar'      => 'tx_dld_dldfront[people]',
                    'lookUpTable' => array(
                        'table'                    => 'fe_users',
                        'id_field'                 => 'uid',
                        'alias_field'              => 'concat(first_name, " ", last_name)',
                        'addWhereClause'           => ' AND NOT deleted',
                        'useUniqueCache'           => 1,
                        'useUniqueCache_conf'      => array(
                            'strtolower'     => 1,
                            'spaceCharacter' => '-',
                        ),
                    ),
                )
            ),
            '59'                           => 'tx_news_pi1',
            'tx_news_pi1'             => array(
                array(
                    'GETvar' => 'tx_news_pi1[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_news_pi1[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_news_pi1[news]',
                    'lookUpTable' => [
                        'table' => 'tx_news_domain_model_news',
                        'id_field' => 'uid',
                        'alias_field' => 'IF(path_segment!="",path_segment,title)',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                        'expireDays' => 180,
                        'enable404forInvalidAlias' => true
                    ]
                )
            ),
            '60'                           => 'program',
            'program'             => array(
                array(
                    'GETvar' => 'tx_dld_dldfront[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[event]',
                    'lookUpTable' => [
                        'table' => 'tx_dld_domain_model_event',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                        'expireDays' => 180,
                        'enable404forInvalidAlias' => true
                    ]
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[day]',
                    'valueMap' => array(
                        'program' => 1,
                    )
                ),
            ),
            '4'                           => 'event',
            'event'             => array(
                array(
                    'GETvar' => 'tx_dld_dldfront[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[offset]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[city]',
                    'noMatch' => 'bypass'
                ),
            ),
            '63'                           => 'showsossion',
            'showsossion'             => array(
                array(
                    'GETvar' => 'tx_dld_dldfront[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[controller]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldfront[session]',
                    'lookUpTable' => [
                        'table' => 'tx_dld_domain_model_session',
                        'id_field' => 'uid',
                        'alias_field' => 'slugname',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                        'expireDays' => 180,
                        'enable404forInvalidAlias' => true
                    ]
                )
            ),
            '476'                           => 'conference-application',
            'conference-application'             => array(
                array(
                    'GETvar' => 'tx_dld_dldevent[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_dld_dldevent[event]',
                    'lookUpTable' => [
                        'table' => 'tx_dld_domain_model_event',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                        'expireDays' => 180,
                        'enable404forInvalidAlias' => true
                    ]
                ),
                array(
                    'GETvar' => 'tx_dld_dldevent[controller]',
                    'noMatch' => 'bypass'
                ),
            ),
        ),
    ),
);

$TYPO3_CONF_VARS['EXTCONF']['realurl_404_multilingual'] = array(
    '_DEFAULT' => array(
        'errorPage' => '404/',
        'unauthorizedPage' => '404/',
    ),
);
function user_decodeSpURL_preProc(&$params, &$ref) {
    $params['URL'] = str_replace('people/', 'users/', $params['URL']);
}

function user_encodeSpURL_postProc(&$params, &$ref) {
    $params['URL'] =  str_replace('people/', 'users/', $params['URL']);
}
?>