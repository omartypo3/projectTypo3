<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_eventticket',
        'label' => 'event_ticket',
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
        'searchFields' => 'conference_id,ticket_id,highrise_tag_suffix,is_locked,name',
        'iconfile' => 'EXT:dld/Resources/Public/Icons/tx_dld_domain_model_eventticket.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,conference_id,ticket_id,highrise_tag_suffix,is_locked,name',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,conference_id,ticket_id,highrise_tag_suffix,is_locked,name, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_dld_domain_model_eventpartner',
                'foreign_table_where' => 'AND tx_dld_domain_model_eventpartner.pid=###CURRENT_PID### AND tx_dld_domain_model_eventpartner.sys_language_uid IN (-1,0)',
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
        'conference_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_eventticket.conference_id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'ticket_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_eventticket.ticket_id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'highrise_tag_suffix' => [
            'exclude' => true,
            'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_eventticket.highrise_tag_suffix',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'is_locked' => array(
            'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_eventticket.is_locked',
            'exclude' => 1,
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_eventticket.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],

    ],
];
