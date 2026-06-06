<?php
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']=array (
	'_DEFAULT' => array (
    	'init' => array (
      		'enableCHashCache' => true,
			'appendMissingSlash' => 'ifNotFile,redirect',
			'adminJumpToBackend' => true,
			'enableUrlDecodeCache' => true,
			'enableUrlEncodeCache' => true,
			'emptyUrlReturnValue' => '/',
    	),
    	'preVars' => array(
			array(
				'GETvar' => 'no_cache',
				'valueMap' => array(
					'no-cache' => 1,
				),
				'noMatch' => 'bypass',
			),
			array(
				'GETvar' => 'L',
				'valueMap' => array(
					'fr' => '0',
					'en' => '1'
				),
				'noMatch' => 'bypass',
			),
		),
    	'pagePath' => array (
			'type' => 'user',
			'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
			'spaceCharacter' => '-',
			'languageGetVar' => 'L',
		),
    	'postVarSets' => array(
			'_DEFAULT' => array (
			// EXT:solr start
				'motcle' => array (
						array(
							'GETvar' => 'q',
						),			
				),
			// EXT:solr start
			// EXT:e_annuaires start
				'fiche' => array(
						array(
								'GETvar' => 'tx_eannuaires_pi1[action]',
								'noMatch' => 'bypass'
						),
						array(
								'GETvar' => 'tx_eannuaires_pi1[controller]',
								'noMatch' => 'bypass'
						),
						array(
								'GETvar' => 'tx_eannuaires_pi1[fiche]',
								'lookUpTable' => array(
										'table' => 'tx_eannuaires_domain_model_fiche',
										'id_field' => 'uid',
										'alias_field' => 'title',
										'addWhereClause' => ' AND NOT deleted',
										'useUniqueCache' => 1,
										'useUniqueCache_conf' => array(
												'strtolower' => 1,
												'spaceCharacter' => '-',
										),
										'languageGetVar' => 'L',
										'languageExceptionUids' => '',
										'languageField' => 'sys_language_uid',
										'transOrigPointerField' => 'l10n_parent',
										'autoUpdate' => 1,
										'expireDays' => 180,
								),
						),
				),
			// EXT:e_annuaires start
			// EXT:news start
				'controller' => array(
						array(
								'GETvar' => 'tx_news_pi1[action]',
								'noMatch' => 'bypass'
						),
						array(
								'GETvar' => 'tx_news_pi1[controller]',
								'noMatch' => 'bypass'
						)
				),
				'filtreDate' => array(
						array(
								'GETvar' => 'tx_news_pi1[overwriteDemand][year]',
						),
						array(
								'GETvar' => 'tx_news_pi1[overwriteDemand][month]',
						),
				),
				'page' => array(
                        array(
                                'GETvar' => 'tx_news_pi1[@widget_0][currentPage]',
                        ),
                        array(
                                'GETvar' => 'tx_eannuaires_pi1[@widget_0][currentPage]',
                        ),
                        array(
                                'GETvar' => 'tx_fsmediagallery_mediagallery[@widget_0][currentPage]',
                        ),
				),
				'actualites' => array(
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
								'lookUpTable' => array(
										'table' => 'tx_news_domain_model_news',
										'id_field' => 'uid',
										'alias_field' => 'title',
										'addWhereClause' => ' AND NOT deleted',
										'useUniqueCache' => 1,
										'useUniqueCache_conf' => array(
												'strtolower' => 1,
												'spaceCharacter' => '-',
										),
										'languageGetVar' => 'L',
										'languageExceptionUids' => '',
										'languageField' => 'sys_language_uid',
										'transOrigPointerField' => 'l10n_parent',
										'autoUpdate' => 1,
										'expireDays' => 180,
								),
						),
				),
				// EXT:news end
				// EXT:fs_media_gallery begin
				'galerie' => array (
						array(
							'GETvar' => 'tx_fsmediagallery_mediagallery[mediaAlbum]',
							'lookUpTable' => array(
									'table' => 'sys_file_collection',
									'id_field' => 'uid',
									'alias_field' => 'title',
									'addWhereClause' => ' AND NOT deleted',
									'useUniqueCache' => 1,
									'useUniqueCache_conf' => array(
											'strtolower' => 1,
											'spaceCharacter' => '-',
									),
									'languageGetVar' => 'L',
									'languageExceptionUids' => '',
									'languageField' => 'sys_language_uid',
									'transOrigPointerField' => 'l10n_parent',
									'autoUpdate' => 1,
									'expireDays' => 180,
							),
						),			
				),
				// EXT:fs_media_gallery end
				//EXT:glossary begin
				'lexique' => array(
					array(
						'GETvar' => 'tx_dpnglossary_glossarylist[controller]',
						'noMatch' => 'bypass'
					),
					array(
						'GETvar' => 'tx_dpnglossary_glossarylist[action]',
						'noMatch' => 'bypass'
					),
					array(
						'GETvar' => 'tx_dpnglossary_glossarylist[@widget_0][character]',
					),
				),

				'lettre' => array(
					array(
						'GETvar' => 'tx_dpnglossary_glossarydetail[controller]',
						'noMatch' => 'bypass',
					),
					array(
						'GETvar' => 'tx_dpnglossary_glossarydetail[action]',
						'noMatch' => 'bypass',
					),
					array(
						'GETvar' => 'tx_dpnglossary_glossarydetail[term]',
						'lookUpTable' => array(
						'table' => 'tx_dpnglossary_domain_model_term',
						'id_field' => 'uid',
						'alias_field' => 'name',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
						'strtolower' => 1,
						'spaceCharacter' => '-',
						),
						'languageGetVar' => 'L',
						'languageExceptionUids' => '',
						'languageField' => 'sys_language_uid',
						'transOrigPointerField' => 'l10n_parent',
						'autoUpdate' => 1,
						'expireDays' => 180,
						),
					),
					array(
						'GETvar' => 'tx_dpnglossary_glossarydetail[pageUid]',
						'optional' => true,
					),
				),
				//EXT:glossary end
				'categorie' => array (
						array(
							'GETvar' => 'tx_news_pi1[overwriteDemand][categories]',
							'lookUpTable' => array(
									'table' => 'sys_category',
									'id_field' => 'uid',
									'alias_field' => 'title',
									'addWhereClause' => ' AND NOT deleted',
									'useUniqueCache' => 1,
									'useUniqueCache_conf' => array(
											'strtolower' => 1,
											'spaceCharacter' => '-',
									),
									'languageGetVar' => 'L',
									'languageExceptionUids' => '',
									'languageField' => 'sys_language_uid',
									'transOrigPointerField' => 'l10n_parent',
									'autoUpdate' => 1,
									'expireDays' => 180,
							),
						),			
				),

                //EXT:powermail begin
                'powermail' => array(
                  array(
                   'GETvar' => 'tx_powermail_pi1[action]',
                  ),
                  array(
                   'GETvar' => 'tx_powermail_pi1[controller]',
                  ),
                  array(
                   'GETvar' => 'tx_powermail_pi1[hash]',
                  ),
                  array(
                   'GETvar' => 'tx_powermail_pi1[mail]',
                  ),
                ), 
                //EXT:powermail end
			),
    	),
		
		'fileName' => array (
			'index' => array(
				'index.html' => array(
					'keyValues' => array(
						'type' => 0,
					)
				),
				'sitemap.xml' => array(
           			'keyValues' => array(
           				'type' => 470955600,
           			)
				),
                'flux.xml' => array(
                    'keyValues' => array(
                        'type' => 9818,
                    )
                )
			),
			'defaultToHTMLsuffixOnPrev' => 0,
			'acceptHTMLsuffix' => 1,
		),
	),
);
?>