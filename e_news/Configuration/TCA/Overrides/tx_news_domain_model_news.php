<?php


/**
 * Add extra fields to tx_news_domain_model_news record
 */

$tmp_e_news_columns = array(
	'placename' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.placename',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'is_event' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.is_event',
		'config' => array(
			'type' => 'check',
			'default' => 0
		)
	),
	'feuser' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.feuserid',
		'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'fe_users',
            'foreign_table' => 'fe_users',
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
		)
	),
    'uservalidation' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.uservalidation',
        'config' => array(
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => array(
                array('LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.validation.waiting', 0),
                array('LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.validation.accepted', 1),
                array('LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.validation.rejected', 2),
            )
        )
    ),
    'uservalidationtoken' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.uservalidationtoken',
        'config' => array(
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ),
    ),
    'adminvalidation' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.adminvalidation',
        'config' => array(
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => array(
                array('LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.validation.waiting', 0),
                array('LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.validation.accepted', 1),
                array('LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.validation.rejected', 2),
            )
        )
    ),
    'adminvalidationtoken' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.adminvalidationtoken',
        'config' => array(
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ),
    ),
	'begindate' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.begindate',
		'config' => array(
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime',
            'default' => time(),
		),
	),
	'finishdate' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.finishdate',
		'config' => array(
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime',
            'default' => time(),
		),
	),
	'schedules' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.schedules',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),
	'placeadress' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.placeadress',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),
	'eventphone' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.eventphone',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'eventmail' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.eventmail',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'mainpicture' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.mainpicture',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'rightpicture'=> array(
	        'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.rightpicture',
	        'exclude' => 1,
	        'config' => array(
                'type' => 'check',
                'default' => '0'
	        )
	),
	'linklist' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.linklist',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		)
	),
	'numberpage' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.numberpage',
		'config' => array(
			'type' => 'input',
			'size' => 4,
			'eval' => 'int'
		)
	),
	'price' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.prix',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'double2'
		)
	),
	'iframetitle' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.iframetitle',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'iframe' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.iframe',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		)
	),
	'date_edition' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.date_edition',
		'config' => array(
			'type' => 'input',
			'size' => 10,
			'eval' => 'datetime',
			'checkbox' => 1,
			'default' => time()
		),
	),
	'authorpublication' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.authorpublication',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'email_publication' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.email_publication',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'type_document' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.type_document',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'countview' => array(
		'exclude' => 1,
		'label' => 'Nombre de vu',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'calameo_plugin' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.calameo_plugin',
		'config' => array(
			'type' => 'inline',    
            'foreign_table' => 'tt_content',
            'foreign_record_defaults' => array(
                'list_type' => 'ecalameopublisherextbase_ecalameo',
                'CType' => 'list'
          	),
			'minitems' => 0,
			'maxitems' => 1,
			'appearance' => array(
				'collapseAll' => 0,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
	'calameo_html' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.calameo_html',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		)
	),
    'commandable' => array(
        'exclude' => 0,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.commandable',
        'config' => array(
            'type' => 'check',
        ),
    ),
	'related_annuaire' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.related_annuaire',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_eannuaires_domain_model_fiche',
            'foreign_table' => 'tx_eannuaires_domain_model_fiche',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        )
	),
	'related_project_news' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.related_project_news',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_news_domain_model_news',
            'foreign_table' => 'tx_news_domain_model_news',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        )
	),
	'related_project' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.related_project',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_news_domain_model_news',
            'foreign_table' => 'tx_news_domain_model_news',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        )
	),
	'related_tools' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.related_tools',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_news_domain_model_news',
            'foreign_table' => 'tx_news_domain_model_news',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        )
	),
	'related_pages' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.related_pages',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'pages',
            'foreign_table' => 'pages',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        )
	),
	'town' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.town',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_enews_domain_model_commune',
            'foreign_table' => 'tx_enews_domain_model_commune',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        )
	),
	'related_subject' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.related_subject',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_news_domain_model_news',
            'foreign_table' => 'tx_news_domain_model_news',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        )
	),    
    'dates' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.dates',
        'config' => array(
            'type' => 'inline',
            'foreign_table' => 'tx_enews_domain_model_dates',
                'minitems' => 0,
                'maxitems' => 150,
                'appearance' => array(
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
        )
    ),
	'topteaser' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.topteaser',
		'config' => array(
			'type' => 'text',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'youngaudience' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.youngaudience',
		'config' => array(
			'type' => 'check',
			'default' => 0
		)
	),
	'freeentrance' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.freeentrance',
		'config' => array(
			'type' => 'check',
			'default' => 0
		)
	),
	'toptitle' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.toptitle',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),

	'zipcode' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.zipcode',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),

	'contenttitle1' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttitle1',
		'config' => array(
			'type' => 'input',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'contenttext1' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttext1',
		'config' => array(
			'type' => 'text',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),

	'contenttitle2' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttitle2',
		'config' => array(
			'type' => 'input',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'contenttext2' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttext2',
		'config' => array(
			'type' => 'text',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),

	'contenttitle3' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttitle3',
		'config' => array(
			'type' => 'input',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'contenttext3' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttext3',
		'config' => array(
			'type' => 'text',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),

	'contenttitle4' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttitle4',
		'config' => array(
			'type' => 'input',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'contenttext4' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttext4',
		'config' => array(
			'type' => 'text',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),

	'contenttitle5' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttitle5',
		'config' => array(
			'type' => 'input',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'contenttext5' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.contenttext5',
		'config' => array(
			'type' => 'text',
			'cols' => 50,
			'rows' => 5,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),
);

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['config']['items'][] = ['LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.related_type', 'related_new'];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['config']['items'][] = ['LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.faq', 'faq'];

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_e_news_columns);

$confExtTpl = [];
try {
    $confExtTpl = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    )->get('e_news');
} catch (\Exception $e) {
}

// On crÃ©e un nouvel onglet pour les dates et on y met les champs correspondants
if($confExtTpl['useDateOcurrences'] ?? false){
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_news_domain_model_news',
        ',--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.date,is_event,dates,toptitle,',
        '',
        'after:rte_disabled'
    );
} else {
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_news_domain_model_news',
        ',--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.date,is_event,begindate,finishdate,schedules,',
        '',
        'after:rte_disabled'
    );
}

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.location,placename,placeadress,zipcode,',
    '',
    'after:rte_disabled'
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.contentsup,contenttitle1,contenttext1,contenttitle2,contenttext2,contenttitle3,contenttext3,contenttitle4,contenttext4,contenttitle5,contenttext5,',
    '',
    'after:rte_disabled'
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.infosdivers,eventphone,eventmail,rightpicture,linklist,feuser,uservalidation,uservalidationtoken,adminvalidation,adminvalidationtoken',
    '',
    'after:rte_disabled'
);


// On ajoute dans l'onglet relation les champs permettant d'ajouter des Ã©lÃ©ments
// Ensure fal_media, fal_related_files, related_subject, and iframe are in Relations tab
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',fal_media,fal_related_files,related_subject,iframe,',
    '',
    'after:related'
);

if($confExtTpl['publication']){
    // Si la conf est cochÃ©e dans l'extension manager, on crÃ©e un nouvel onglet pour les publications et on y met les champs correspondants
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_news_domain_model_news',
        ',--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.publication,type_document,numberpage,price,date_edition,'
    );
}

if($confExtTpl['geolocalisation']){
//     On rajoute Ã  la fin un onglet de gÃ©olocalisation et on y met les champs correspondants
     TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
         'tx_news_domain_model_news', 
         ',--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.geoloc,latitude,longitude'
     );	
}

$confShowItem = $GLOBALS['TCA']['tx_news_domain_model_news']['types']['0']['showitem'] ?? '';
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_ENews_Enews']['showitem'] = $confShowItem;

$confArrayShowItem = explode('--div--',$confShowItem);

$isV7orHigher = true;
if ($isV7orHigher) {
	$wantedOrder = array(
	    1 => ';LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories',
	    2 => ';LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.content_elements',
	    3 => ';LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tabs.relations',
	    4 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.date',
	    5 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.publication',
	    6 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.geoloc',
	    7 => ';LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.extended',
	    8 => ';LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access',
	    9 => ';LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata',
	    10 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.location',
	    11 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.infosdivers',
	    12 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.contentsup',
	    //11 => ';LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags',
    );
}
else {
	$wantedOrder = array(
	    1 => ';LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories',
	    2 => ';LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.content_elements',
	    3 => ';LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tabs.relations',
	    4 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.date',
	    5 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.publication',
	    6 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.geoloc',
	    7 => ';LLL:EXT:cms/locallang_tca.xlf:pages.tabs.extended',
	    8 => ';LLL:EXT:cms/locallang_tca.xlf:pages.tabs.metadata',
	    9 => ';LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access',
	    10 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.location',
	    11 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.infosdivers',
	    12 => ';LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.contentsup',
	);
}

$GLOBALS['TCA']['tx_news_domain_model_news']['types']['related_new'] = $GLOBALS['TCA']['tx_news_domain_model_news']['types'][0];
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['related_new']['showitem'] = 'related_project_news';

//Rajout d'un type de news spécifique au FAQ
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['paletteCoreFaq']['canNotCollapse'] = 1;
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['paletteCoreFaq']['showitem'] = 'type,sys_language_uid,hidden,';
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['faq'] = $GLOBALS['TCA']['tx_news_domain_model_news']['types'][0];
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['faq']['showitem'] = 'l10n_parent,l10n_diffsource,title;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.title_faq, --palette--;;paletteCoreFaq;datetime,toptitle,bodytext;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_enews.bodytext_faq,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,categories,--div--;LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tabs.relations,fal_media,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.extended,--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.date,parent_pid,--div--;LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tca.tab.geoloc,zipcode,--div--;LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;paletteAccess';

$newOrderFieldsArray = array();
foreach($confArrayShowItem as $key => $tab){
    foreach($wantedOrder as $newKey => $value){
        if(strpos($tab,$value) !== FALSE){
            $newOrderFieldsArray[$newKey] = $tab;
        }        
    }        
}
if (!empty($newOrderFieldsArray)) {
    $newOrderFieldsArray[0] = $confArrayShowItem[0];
    ksort($newOrderFieldsArray);
    $newOrderFields = implode('--div--',$newOrderFieldsArray);
    
    $tabs = explode('--div--', $newOrderFields);
    foreach($tabs as $index => $tab) {
        if (strpos($tab, 'tabs.relations') !== false) {
            // Remove tags if present (multiple patterns to catch all cases)
            $tab = preg_replace('/,tags,/', ',', $tab);
            $tab = preg_replace('/,tags([^-])/', '$1', $tab);
            $tab = preg_replace('/^tags,/', '', $tab);
            $tab = preg_replace('/,tags$/', '', $tab);
			$tab = preg_replace('/,related,/', ',', $tab);
            $tab = preg_replace('/,related([^-])/', '$1', $tab);
            $tab = preg_replace('/^related,/', '', $tab);
            $tab = preg_replace('/,related$/', '', $tab);
			$tab = preg_replace('/,related_from,/', ',', $tab);
            $tab = preg_replace('/,related_from([^-])/', '$1', $tab);
            $tab = preg_replace('/^related_from,/', '', $tab);
            $tab = preg_replace('/,related_from$/', '', $tab);
            
            if (strpos($tab, 'fal_media') === false) {
                $tab = preg_replace('/(tabs\.relations[^,]*),/', '$1,fal_media,', $tab);
            }
            
            if (strpos($tab, 'fal_related_files') === false) {
                if (strpos($tab, 'fal_media') !== false) {
                    $tab = str_replace('fal_media,', 'fal_media,fal_related_files,', $tab);
                } 
                else {
                    $tab = preg_replace('/(tabs\.relations[^,]*),/', '$1,fal_related_files,', $tab);
                }
            }
            
            $tabs[$index] = $tab;
        }
    }
    $newOrderFields = implode('--div--', $tabs);
    
    $GLOBALS['TCA']['tx_news_domain_model_news']['types']['0']['showitem'] = $newOrderFields;
}

$ssll = 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:';
/**
 * Add new fields
 */
$sectionField = [
    'section' => [
      'label' => $ssll . 'tx_news_domain_model_news.section',        
      'config' => [
        'type' => 'radio',
        'items' => [
            [$ssll . 'tx_news_domain_model_news.section.0', 0], 
            [$ssll . 'tx_news_domain_model_news.section.1', 1],
            [$ssll . 'tx_news_domain_model_news.section.2', 2],
        ],
      ],
    ],
];

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $sectionField);
