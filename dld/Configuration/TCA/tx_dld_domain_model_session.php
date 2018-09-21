<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session',
        'label' => 'name',
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
		'searchFields' => 'name,start,end,is_visible,event_id,venue_id',
        'iconfile' => 'EXT:dld/Resources/Public/Icons/tx_dld_domain_model_session.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, start, end, is_visible, event_id, venue_id, description',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, start, end, is_visible, event_id, venue_id, description, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_dld_domain_model_session',
                'foreign_table_where' => 'AND tx_dld_domain_model_session.pid=###CURRENT_PID### AND tx_dld_domain_model_session.sys_language_uid IN (-1,0)',
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
        'name' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session.name',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'start' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session.start',
	        'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
			]
	    ],
	    'end' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session.end',
	        'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
			]
	    ],
	    'is_visible' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session.is_visible',
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
	    'event_id' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session.event_id',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_dld_domain_model_event',
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
	    'venue_id' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session.venue_id',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_dld_domain_model_venue',
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
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_event.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],

        'slugname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_session.slugname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],



        'sessionpeople' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
