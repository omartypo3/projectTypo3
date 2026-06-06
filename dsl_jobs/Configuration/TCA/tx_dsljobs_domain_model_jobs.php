<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs',
        'label' => 'jobid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
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
		'searchFields' => 'jobid,jobtitle,description_intro_heading,description_intro_body,description_tasks_heading,description_tasks_body,description_qualifications_heading,description_qualifications_body,description_benefits_heading,description_benefits_body,description_outro_body,applylink_label,applylink_url,job_site,job_level',
        'iconfile' => 'EXT:dsl_jobs/Resources/Public/Icons/tx_dsljobs_domain_model_jobs.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, jobid, jobtitle, description_intro_heading, description_intro_body, description_tasks_heading, description_tasks_body, description_qualifications_heading, description_qualifications_body, description_benefits_heading, description_benefits_body, description_outro_body, applylink_label, applylink_url, job_site, job_level',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, jobid, jobtitle, description_intro_heading, description_intro_body, description_tasks_heading, description_tasks_body, description_qualifications_heading, description_qualifications_body, description_benefits_heading, description_benefits_body, description_outro_body, applylink_label, applylink_url, job_site, job_level, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_dsljobs_domain_model_jobs',
                'foreign_table_where' => 'AND tx_dsljobs_domain_model_jobs.pid=###CURRENT_PID### AND tx_dsljobs_domain_model_jobs.sys_language_uid IN (-1,0)',
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
        'jobid' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.jobid',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'jobtitle' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.jobtitle',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'description_intro_heading' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_intro_heading',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'description_intro_body' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_intro_body',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim',
			],
	        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
	    ],
	    'description_tasks_heading' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_tasks_heading',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'description_tasks_body' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_tasks_body',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim',
			],
	        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
	    ],
	    'description_qualifications_heading' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_qualifications_heading',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'description_qualifications_body' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_qualifications_body',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim',
			],
	        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
	    ],
	    'description_benefits_heading' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_benefits_heading',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'description_benefits_body' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_benefits_body',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim',
			],
	        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
	    ],
	    'description_outro_body' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.description_outro_body',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim',
			],
	        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
	    ],
	    'applylink_label' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.applylink_label',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'applylink_url' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.applylink_url',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'job_site' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.job_site',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'foreign_table' => 'tx_dsljobs_domain_model_jobsite',
			    'minitems' => 0,
			    'maxitems' => 1,
			],
	    ],
	    'job_level' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsljobs_domain_model_jobs.job_level',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'foreign_table' => 'tx_dsljobs_domain_model_joblevel',
			    'minitems' => 0,
			    'maxitems' => 1,
			],
	    ],
    ],
];
