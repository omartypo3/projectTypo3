<?php
defined('TYPO3_MODE') || die();

if (!isset($GLOBALS['TCA']['fe_users']['ctrl']['type'])) {
    if (file_exists($GLOBALS['TCA']['fe_users']['ctrl']['dynamicConfigFile'])) {
        require_once($GLOBALS['TCA']['fe_users']['ctrl']['dynamicConfigFile']);
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['fe_users']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_dld_fe_users = [];
    $tempColumnstx_dld_fe_users[$GLOBALS['TCA']['fe_users']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['People','Tx_Dld_People']
            ],
            'default' => 'Tx_Dld_People',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumnstx_dld_fe_users);
}
$GLOBALS['TCA']['fe_users']['ctrl']['label'] = 'first_name';
$GLOBALS['TCA']['fe_users']['ctrl']['label_alt'] = 'last_name';
$GLOBALS['TCA']['fe_users']['ctrl']['label_alt_force'] = TRUE;
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    $GLOBALS['TCA']['fe_users']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['fe_users']['ctrl']['label']
);

$tmp_dld_columns = [

    'email_private' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.email_private',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'pid' => Array(
        'exclude' => 1,
        'label' => 'PID',
        'config' => array(
            'type' => 'none',
        )
    ),
    'email_default_cc' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.email_default_cc',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'social_linkedin_url' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.social_linkedin_url',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'social_twitter_username' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.social_twitter_username',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'is_amazing_speaker' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.is_amazing_speaker',
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
    'is_dld_team' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.is_dld_team',
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
    'amazing_speaker_sort_order' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.amazing_speaker_sort_order',
        'config' => [
            'type' => 'input',
            'size' => 4,
            'eval' => 'int'
        ]
    ],
    'biography' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.biography',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim'
        ]
    ],
    'highrise_person_id' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.highrisePersonId',
        'config' => [
            'type' => 'input',
            'size' => 30
        ]
    ],


    'tags' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.tags',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim'
        ]
    ],

    'youtubevideos' => [
        'exclude' => true,
        'label' => 'LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people.youtubevideos',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim'
        ]
    ]

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_dld_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_Dld_People']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_Dld_People']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_Dld_People']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_Dld_People']['showitem'] .= ',--div--;LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_people,';
$GLOBALS['TCA']['fe_users']['types']['Tx_Dld_People']['showitem'] .= 'email_private, email_default_cc, social_linkedin_url, social_twitter_username, is_amazing_speaker, amazing_speaker_sort_order, is_dld_team, biography';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_Dld_People','Tx_Dld_People'];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    '',
    'EXT:/Resources/Private/Language/locallang_csh_.xlf'
);