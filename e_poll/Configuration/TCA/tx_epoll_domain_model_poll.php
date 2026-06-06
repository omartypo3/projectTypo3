<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
        'searchFields' => 'title,question',
        'iconfile' => 'EXT:e_poll/Resources/Public/Icons/tx_epoll_domain_model_poll.gif',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title, fegroup, image, question, explanation, multiplechoice, options, categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;;access,
            '
        ],
    ],
    'palettes' => [
        'language' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
        'hidden' => [
            'showitem' => 'hidden',
        ],
        'access' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
            'showitem' => 'starttime, endtime',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_epoll_domain_model_poll',
                'foreign_table_where' => 'AND {#tx_epoll_domain_model_poll}.{#pid}=###CURRENT_PID### AND {#tx_epoll_domain_model_poll}.{#sys_language_uid} IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required',
            ]
        ],
        'fegroup' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.fegroup',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                    ['label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hide_at_login', 'value' => -1],
                    ['label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.any_login', 'value' => -2],
                    ['label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.usergroups', 'value' => '--div--']
                ],
                'foreign_table' => 'fe_groups'
            ]
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.image',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'maxitems' => 1,
            ]
        ],
        'question' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.question',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 5,
            ]
        ],
        'explanation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.explanation',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 3,
            ]
        ],
        'multiplechoice' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.multiplechoice',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'options' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.options',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_epoll_domain_model_option',
                'foreign_field' => 'poll',
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'levelLinksPosition' => 'top',
                    'useSortable' => true,
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                ],
            ],
        ],
        'categories' => [
            'exclude' => true,
            'label' => 'LLL:EXT:e_poll/Resources/Private/Language/locallang_db.xlf:tx_epoll_domain_model_poll.categories',
            'config' => [
                'type' => 'category',
                'relationship' => 'manyToMany',
                'size' => 10,
                'maxitems' => 9999,
            ],
        ],
    ],
];
