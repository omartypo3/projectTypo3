<?php
return [
    'ctrl' => [
        'title'	=> 'UserTag',
        'label' => 'field',
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
        'searchFields' => 'user_id,highrisetag, highrisetagcreatedat, emailsentat, emailsent, mailchimpplaceholders',
        'iconfile' => 'EXT:dld/Resources/Public/Icons/tx_dld_domain_model_setting.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, userid,highrisetag, highrisetagcreatedat, emailsentat, emailsent, mailchimpplaceholders',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, userid,highrisetag, highrisetagcreatedat, emailsentat, emailsent, mailchimpplaceholders, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_dld_domain_model_setting',
                'foreign_table_where' => 'AND tx_dld_domain_model_setting.pid=###CURRENT_PID### AND tx_dld_domain_model_setting.sys_language_uid IN (-1,0)',
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
        'userid' => [
            'exclude' => true,
            'label' => 'userId',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'highrisetag' => [
            'exclude' => true,
            'label' => 'highrisetag',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ],
        ],
        'highrisetagcreatedat' => [
            'exclude' => true,
            'label' => 'highriseTagcreatedat',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'emailsentat' => [
            'exclude' => true,
            'label' => 'emailsentat',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'emailsent' => [
            'exclude' => true,
            'label' => 'emailsent',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => 'foo',
                        1 => '',
                        'labelChecked' => 'Email has been sent',
                        'labelUnchecked' => 'Email has not been sent',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'mailchimpplaceholders' => [
            'exclude' => true,
            'label' => 'mailchimpPlaceholders',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ],
        ],
    ],
];
