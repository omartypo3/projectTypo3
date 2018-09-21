<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'title,date,aktionszeit,location,street,streetnumber,zip,city,moderator,informations,fon,fax,mail,lon,lat',
        'iconfile' => 'EXT:pk_eventmaps/Resources/Public/Icons/tx_pkeventmaps_domain_model_event.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, date, aktionszeit, location, street, streetnumber, zip, city, moderator, informations, fon, fax, mail, lon, lat',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, date, aktionszeit, location, street, streetnumber, zip, city, moderator, informations, fon, fax, mail, lon, lat, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_pkeventmaps_domain_model_event',
                'foreign_table_where' => 'AND tx_pkeventmaps_domain_model_event.pid=###CURRENT_PID### AND tx_pkeventmaps_domain_model_event.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
		'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
		'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
        'title' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.title',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'date' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.date',
	        'config' => [
			    'dbType' => 'date',
			    'type' => 'input',
			    'size' => 7,
			    'eval' => 'date',
			    'default' => '0000-00-00'
			],
	    ],
	    'aktionszeit' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.aktionszeit',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'location' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.location',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'street' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.street',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'streetnumber' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.streetnumber',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'zip' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.zip',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'city' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.city',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'moderator' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.moderator',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'informations' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.informations',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim',
			],
	        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
	    ],
	    'fon' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.fon',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'fax' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.fax',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'mail' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.mail',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'lon' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.lon',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'lat' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pkeventmaps_domain_model_event.lat',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
    ],
];
