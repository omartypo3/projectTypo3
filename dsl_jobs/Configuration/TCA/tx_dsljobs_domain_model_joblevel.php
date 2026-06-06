<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_joblevel',
        'label' => 'job_level',
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
		'searchFields' => 'job_level,bezeichnung',
        'iconfile' => 'EXT:dsl_jobs/Resources/Public/Icons/tx_dsljobs_domain_model_joblevel.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, job_level, bezeichnung',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, job_level, bezeichnung'],
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
                'foreign_table' => 'tx_dsljobs_domain_model_joblevel',
                'foreign_table_where' => 'AND tx_dsljobs_domain_model_joblevel.pid=###CURRENT_PID### AND tx_dsljobs_domain_model_joblevel.sys_language_uid IN (-1,0)',
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
        'job_level' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_joblevel.job_level',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'bezeichnung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_joblevel.bezeichnung',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
    ],
];
