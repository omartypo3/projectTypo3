<?php
$TYPO3_CONF_VARS['FE']['addRootLineFields'] .= ',tx_realurl_pathsegment,alias,nav_title,title';
$TYPO3_CONF_VARS["FE"]["pageNotFound_handling_statheader"] = 'HTTP/1.1 404 Not Found';

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array(


	'preVars' => array(
		array(
			'GETvar'       => 'L',
			'valueMap'     => array(
				'en'    => '0',
				'fr'    => '1',
				'jp'    => '2',
				'cn'    => '3',
				'ar'    => '4',
				'de'    => '5',
			),
			'valueDefault' => 'de',
			'noMatch'      => 'bypass',
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

	),

	'postVarSets' => array(

	),

	'fileName' => array(
		'defaultToHTMLsuffixOnPrev' => 0,
		'index'                     => array(
			'sitemap.xml' => array(
				'keyValues' => array(
					'type' => 841132,
				),
			),
			'robots.txt' => array(
				'keyValues' => array(
					'type' => 841133,
				),
			),
		) ,
		'_DEFAULT'                  => array(
			'keyValues' => array()
		),
	),
);

?>