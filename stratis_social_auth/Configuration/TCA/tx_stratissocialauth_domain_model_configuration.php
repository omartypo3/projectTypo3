<?php
defined('TYPO3') or die;

$LLL = 'LLL:EXT:stratis_social_auth/Resources/Private/Language/locallang_db.xlf:tx_stratissocialauth_domain_model_configuration';

return [
    'ctrl' => [
        'title' => $LLL,
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:stratis_social_auth/Resources/Public/Icons/Config.svg',
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => $LLL . '.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => $LLL . '.hidden',
            'config' => [
                'type' => 'check',
                'default' => false,
            ],
        ],
        'storage_pid' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $LLL . '.storagePid',
            'config' => [
                'type' => 'group',
                'allowed' => 'pages',
                'foreign_table' => 'pages',
                'foreign_table_where' => 'ORDER BY tx_stratissocialauth_domain_model_provider.title',
                'minitems' => 1,
                'maxitems' => 1,
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                        'default' => [
                            'searchWholePhrase' => true,
                        ]
                    ],
                ],
            ],
        ],
        'providers' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $LLL . '.providers',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_stratissocialauth_domain_model_provider',
                'foreign_table_where' => 'ORDER BY tx_stratissocialauth_domain_model_provider.title',
                'minitems' => 1,
                'maxitems' => 100,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                ],
            ],
        ],
        'default_groups' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $LLL . '.defaultGroups',
            'config' => [
                'type' => 'group',
                'allowed' => 'fe_groups',
                'foreign_table' => 'fe_groups',
                'foreign_table_where' => 'ORDER BY fe_groups.title',
                'minitems' => 1,
                'maxitems' => 100,
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                        'default' => [
                            'searchWholePhrase' => true,
                        ]
                    ],
                ],
            ],
        ],
        'mail_body' => [
            'exclude' => 0,
            'l10n_mode' => 'noCopy',
            'label' => $LLL . '.mailBody',
            'defaultExtras' => 'richtext:rte_transform[mode=ts_css]',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
                'required' => true,
                'cols' => 30,
                'rows' => 5,
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
                'wizards' => [
                    '_PADDING' => 2,
                    'RTE' => [
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'Full screen Rich Text Editing',
                        'icon' => 'actions-wizard-rte',
                        'module' => [
                            'name' => 'wizard_rte',
                        ],
                    ],
                ],
            ]
        ],
        'mail_sender_name' => [
            'exclude' => true,
            'label' => $LLL . '.mailSenderName',
            'config' => [
                'type' => 'input',
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'mail_sender_email' => [
            'exclude' => true,
            'label' => $LLL . '.mailSenderEmail',
            'config' => [
                'type' => 'input',
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'mail_subject' => [
            'exclude' => true,
            'label' => $LLL . '.mailSubject',
            'config' => [
                'type' => 'input',
                'required' => true,
                'eval' => 'trim',
            ],
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '--palette--;;paletteCore, --palette--;;paletteConfig, --div--;' . $LLL . '.tab.mail, --palette--;;paletteMail,',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'title, hidden, --linebreak--, type',
            'canNotCollapse' => true
        ],
        'paletteConfig' => [
            'showitem' => 'storage_pid, --linebreak--, default_groups, --linebreak--, providers, --linebreak--',
            'canNotCollapse' => true
        ],
        'paletteMail' => [
            'showitem' => 'mail_sender_name, --linebreak--, mail_sender_email, --linebreak--, mail_subject, --linebreak--, mail_body',
            'canNotCollapse' => true
        ],
    ],
];
