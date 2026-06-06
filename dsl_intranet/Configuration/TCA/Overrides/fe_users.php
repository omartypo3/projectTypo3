<?php
defined('TYPO3_MODE') || die();

if (!isset($GLOBALS['TCA']['fe_users']['ctrl']['type'])) {
    if (file_exists($GLOBALS['TCA']['fe_users']['ctrl']['dynamicConfigFile'])) {
        require_once($GLOBALS['TCA']['fe_users']['ctrl']['dynamicConfigFile']);
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['fe_users']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_dslintranet_fe_users = [];
    $tempColumnstx_dslintranet_fe_users[$GLOBALS['TCA']['fe_users']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['Lieferanten','Tx_DslIntranet_Lieferanten']
            ],
            'default' => 'Tx_DslIntranet_Lieferanten',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumnstx_dslintranet_fe_users);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    $GLOBALS['TCA']['fe_users']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['fe_users']['ctrl']['label']
);

$tmp_dsl_intranet_columns = [

    'nummer' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_lieferanten.nummer',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_dsl_intranet_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Lieferanten']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Lieferanten']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Lieferanten']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Lieferanten']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_lieferanten,';
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Lieferanten']['showitem'] .= 'nummer';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_DslIntranet_Lieferanten','Tx_DslIntranet_Lieferanten'];

$tmp_dsl_intranet_columns = [

    'settings_kunde' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kundenstammdaten.settings_kunde',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'newsletter' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kundenstammdaten.newsletter',
        'config' => [
		    'type' => 'check',
		    'items' => [
		        '1' => [
		            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
		        ]
		    ],
		    'default' => 0
		]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_dsl_intranet_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_KundenStammdaten']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_KundenStammdaten']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_KundenStammdaten']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_KundenStammdaten']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kundenstammdaten,';
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_KundenStammdaten']['showitem'] .= 'settings_kunde, newsletter';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_DslIntranet_KundenStammdaten','Tx_DslIntranet_KundenStammdaten'];

$tmp_dsl_intranet_columns = [

    'settings' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'settings_hosting' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_hosting',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'geoeffneter_auftrag' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.geoeffneter_auftrag',
        'config' => [
		    'type' => 'input',
		    'size' => 4,
		    'eval' => 'int'
		]
    ],
    'settings_aufgaben' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_aufgaben',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'settings_dateien' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_dateien',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'avatar' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.avatar',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
		    'avatar',
		    [
		        'appearance' => [
		            'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
		        ],
		        'foreign_types' => [
		            '0' => [
		                'showitem' => '
		                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
		                --palette--;;filePalette'
		            ],
		            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
		                'showitem' => '
		                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
		                --palette--;;filePalette'
		            ],
		            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
		                'showitem' => '
		                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
		                --palette--;;filePalette'
		            ],
		            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
		                'showitem' => '
		                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
		                --palette--;;filePalette'
		            ],
		            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
		                'showitem' => '
		                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
		                --palette--;;filePalette'
		            ],
		            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
		                'showitem' => '
		                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
		                --palette--;;filePalette'
		            ]
		        ],
		        'maxitems' => 1
		    ],
		    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
		),
    ],
    'settings_agenturauftrag' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_agenturauftrag',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'settings_ablage' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_ablage',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
	],
    'settings_kanban' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_kanban',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'settings_allgemein' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_allgemein',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'settings_kunden' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.settings_kunden',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'offene_auftraege' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.offene_auftraege',
        'config' => [
		    'type' => 'select',
		    'renderType' => 'selectMultipleSideBySide',
		    'foreign_table' => 'tx_dslintranet_domain_model_auftraege',
		    'MM' => 'tx_dslintranet_benutzer_auftraege_mm',
		    'size' => 10,
		    'autoSizeMax' => 30,
		    'maxitems' => 9999,
		    'multiple' => 0,
		    'wizards' => [
		        '_PADDING' => 1,
		        '_VERTICAL' => 1,
		        'edit' => [
		            'module' => [
		                'name' => 'wizard_edit',
		            ],
		            'type' => 'popup',
		            'title' => 'Edit', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.edit
		            'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
		            'popup_onlyOpenIfSelected' => 1,
		            'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
		        ],
		        'add' => [
		            'module' => [
		                'name' => 'wizard_add',
		            ],
		            'type' => 'script',
		            'title' => 'Create new', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.add
		            'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
		            'params' => [
		                'table' => 'tx_dslintranet_domain_model_auftraege',
		                'pid' => '###CURRENT_PID###',
		                'setValue' => 'prepend'
		            ],
		        ],
		    ],
		],
    ],
    'ablage' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer.ablage',
        'config' => [
		    'type' => 'inline',
		    'foreign_table' => 'tx_dslintranet_domain_model_ablage',
		    'foreign_field' => 'benutzer',
		    'foreign_sortby' => 'sorting',
		    'maxitems' => 9999,
		    'appearance' => [
		        'collapseAll' => 0,
		        'levelLinksPosition' => 'top',
		        'showSynchronizationLink' => 1,
		        'showPossibleLocalizationRecords' => 1,
		        'useSortable' => 1,
		        'showAllLocalizationLink' => 1
		    ],
		],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_dsl_intranet_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_benutzer,';
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'] .= 'settings, settings_hosting, geoeffneter_auftrag, settings_aufgaben, settings_dateien, avatar, settings_agenturauftrag, settings_ablage, settings_allgemein, settings_kunden, offene_auftraege, ablage';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_DslIntranet_Benutzer','Tx_DslIntranet_Benutzer'];

$tmp_dsl_intranet_columns = [

    'nummer' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.nummer',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qbrefnum' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qbrefnum',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qbbaddr' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qbbaddr',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
	'notizen' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.notizen',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'spitzname' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.spitzname',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'initialien' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.initialien',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'notiz' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.notiz',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'freigaben' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.freigaben',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'history' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.history',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'qb_email' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_email',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_einv_email' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_einv_email',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_cont' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_cont',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_anrede' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_anrede',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_firstname' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_firstname',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_lastname' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_lastname',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_street' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_street',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_postal' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_postal',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_city' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_city',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_phone' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_phone',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'qb_fax' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_fax',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_cont2' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_cont2',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_phone2' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_phone2',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'autologin' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.autologin',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'email_rechnungen' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.email_rechnungen',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'email_angebote' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.email_angebote',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'newsletter' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.newsletter',
        'config' => [
		    'type' => 'check',
		    'items' => [
		        '1' => [
		            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
		        ]
		    ],
		    'default' => 0
		]
    ],
    'email_newsletter' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.email_newsletter',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_kto_inh' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_kto_inh',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_bic' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_bic',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_iban' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_iban',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_bank' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_bank',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'pic_drop_zugangscode' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.pic_drop_zugangscode',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'passwort_kopie' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.passwort_kopie',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'qb_company' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.qb_company',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'dateien' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden.dateien',
        'config' => [
		    'type' => 'inline',
		    'foreign_table' => 'tx_dslintranet_domain_model_dateien',
		    'foreign_field' => 'kunden',
		    'maxitems' => 9999,
		    'appearance' => [
		        'collapseAll' => 0,
		        'levelLinksPosition' => 'top',
		        'showSynchronizationLink' => 1,
		        'showPossibleLocalizationRecords' => 1,
		        'showAllLocalizationLink' => 1
		    ],
		],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_dsl_intranet_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Kunden']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Kunden']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Kunden']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Kunden']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kunden,';
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Kunden']['showitem'] .= 'nummer, qbrefnum, qbbaddr, notizen, spitzname, initialien, notiz, freigaben, history, qb_email, qb_einv_email, qb_cont, qb_anrede, qb_firstname, qb_lastname, qb_street, qb_postal, qb_city, qb_phone, qb_fax, qb_cont2, qb_phone2, autologin, email_rechnungen, email_angebote, newsletter, email_newsletter, qb_kto_inh, qb_bic, qb_iban, qb_bank, pic_drop_zugangscode, passwort_kopie, qb_company, dateien';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_DslIntranet_Kunden','Tx_DslIntranet_Kunden'];

$tmp_dsl_intranet_columns = [

    'mobilephone' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.mobilephone',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'spitzname' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.spitzname',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'initialien' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.initialien',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'notiz' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.notiz',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'arbeitsbegin' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.arbeitsbegin',
        'config' => [
		    'type' => 'input',
		    'size' => 4,
		    'eval' => 'time',
		    'default' => time()
		]
    ],
    'arbeitsende' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.arbeitsende',
        'config' => [
		    'type' => 'input',
		    'size' => 4,
		    'eval' => 'time',
		    'default' => time()
		]
    ],
    'autostop' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.autostop',
        'config' => [
		    'type' => 'input',
		    'size' => 4,
		    'eval' => 'time',
		    'default' => time()
		]
    ],
    'farbe' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.farbe',
        'config' => [
		    'type' => 'text',
		    'cols' => 40,
		    'rows' => 15,
		    'eval' => 'trim'
		]
    ],
    'rechte' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.rechte',
        'config' => [
		    'type' => 'input',
		    'size' => 30,
		    'eval' => 'trim'
		],
    ],
    'urlaubstage_pro_jahr' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.urlaubstage_pro_jahr',
        'config' => [
		    'type' => 'input',
		    'size' => 4,
		    'eval' => 'int'
		]
    ],
    'urlaubstage_verbraucht' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter.urlaubstage_verbraucht',
        'config' => [
		    'type' => 'input',
		    'size' => 4,
		    'eval' => 'int'
		]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_dsl_intranet_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Mitarbeiter']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Benutzer']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Mitarbeiter']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Mitarbeiter']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Mitarbeiter']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_mitarbeiter,';
$GLOBALS['TCA']['fe_users']['types']['Tx_DslIntranet_Mitarbeiter']['showitem'] .= 'mobilephone, spitzname, initialien, notiz, arbeitsbegin, arbeitsende, autostop, farbe, rechte, urlaubstage_pro_jahr, urlaubstage_verbraucht';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_DslIntranet_Mitarbeiter','Tx_DslIntranet_Mitarbeiter'];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('fe_users', 'EXT:frontend/Resources/Private/Language/locallang_csh_fe_users.xlf');

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$GLOBALS['TCA']['fe_users']['columns']['farbe']['config'] = array (
   'type' => 'input',
   'size' => 10,
   'wizards' => array(
       '_PADDING' => 2,
       'color' => array(
           'title' => 'Color:',
           'type' => 'colorbox',
           'dim' => '16×12',
          /* 'tableStyle' => 'border:solid 1px black;',*/
		   'module' => array(
				'name' => 'wizard_colorpicker'
			),
           //'script' => 'wizard_colorpicker.php',
           'JSopenParams' => 'height=500,width=500,status=0,menubar=0,scrollbars=1',
      ),
   ),
);

//für mitarbeiter
$GLOBALS['TCA']['fe_users']['columns']['rechte']['config'] = array(
			'type' => 'select',
			'renderType' => 'selectSingleBox',
			'items' => array(
				array('Urlaubsmanager', 10),
				array('Mitarbeitermanager', 20),
				array('Rechnungslegung', 30),
				array('SuperAdmin für Aufträge', 40),
				array('Downloadcenter', 50),
				array('externe Auftragsbearbeiter (eingeschränkte Ansichten)', 60),
		
			),
			'size' => 5,
			'multiple' => 1,
			'minitems' => 0,
			'maxitems' => 99,
			'eval' => ''
		);

//für kunden
$GLOBALS['TCA']['fe_users']['columns']['freigaben']['config'] = array(
			'type' => 'select',
			'renderType' => 'selectSingleBox',
			'items' => array(
				array('Aufträge', 10),
				array('Hosting', 20)
			),
			'size' => 5,
			'multiple' => 1,
			'minitems' => 0,
			'maxitems' => 99,
			'eval' => ''
		);
$GLOBALS['TCA']['fe_users']['columns']['deleted'] = array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.deleted',
			'config' => array(
				'type' => 'check',
			)
		);
	
$GLOBALS['TCA']['fe_users']['ctrl']['label'] = 'name';
$GLOBALS['TCA']['fe_users']['ctrl']['label_alt'] = 'uid';
$GLOBALS['TCA']['fe_users']['ctrl']['label_alt_force'] = 1;