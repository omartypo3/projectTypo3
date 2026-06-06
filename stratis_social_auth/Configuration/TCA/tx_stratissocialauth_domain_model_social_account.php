<?php
defined('TYPO3') or die;

$LLL = 'LLL:EXT:stratis_social_auth/Resources/Private/Language/locallang_db.xlf:tx_stratissocialauth_domain_model_social_account';

return [
    'ctrl' => [
        'title' => $LLL,
        'label' => 'uid',
        'label_userFunc' => \Stratis\StratisSocialAuth\UserFunc\TCA::class . '->getProviderTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY uid',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'hideTable' => true,
        'typeicon_column' => 'provider',
        'typeicon_classes' => [
            'userFunc' => \Stratis\StratisSocialAuth\UserFunc\TCA::class . '->getProviderIcon',
        ],
    ],
    'columns' => [
        'hidden' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'user' => [
            'exclude' => true,
            'label' => $LLL . '.user',
            'config' => [
                'type' => 'select',
                'readOnly' => true,
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
                'minitems' => 0,
            ],
        ],
        'provider' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'identifier' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '--palette--;;paletteCore',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'provider, hidden,',
            'canNotCollapse' => true
        ],
    ],
];
