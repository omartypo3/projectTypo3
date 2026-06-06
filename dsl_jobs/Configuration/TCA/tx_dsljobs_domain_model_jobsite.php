<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite',
        'label' => 'jobsite_uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'enablecolumns' => [
        ],
		'searchFields' => 'jobsite_uid,company,shortname,country,state,zip,city,street,streetnumber',
        'iconfile' => 'EXT:dsl_jobs/Resources/Public/Icons/tx_dsljobs_domain_model_jobsite.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, jobsite_uid, company, shortname, country, state, zip, city, street, streetnumber',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, jobsite_uid, company, shortname, country, state, zip, city, street, streetnumber'],
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
                'foreign_table' => 'tx_dsljobs_domain_model_jobsite',
                'foreign_table_where' => 'AND tx_dsljobs_domain_model_jobsite.pid=###CURRENT_PID### AND tx_dsljobs_domain_model_jobsite.sys_language_uid IN (-1,0)',
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
        'jobsite_uid' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.jobsite_uid',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'company' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.company',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'shortname' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.shortname',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'country' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.country',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'state' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.state',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'zip' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.zip',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'city' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.city',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'street' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.street',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'streetnumber' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobsite.streetnumber',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
    ],
];
