<?php
defined('TYPO3') or die;

call_user_func(function () {
    $LLL = 'LLL:EXT:stratis_social_auth/Resources/Private/Language/locallang_db.xlf:fe_users';

    $GLOBALS['TCA']['fe_users']['types']['0']['showitem'] .= ', --div--;' . $LLL . '.tab.social,';
    $columns = [
        'social_accounts' => [
            'exclude' => true,
            'label' => $LLL . '.social_accounts',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_stratissocialauth_domain_model_social_account',
                'foreign_field' => 'user',
                'maxitems' => 100,
                'minitems' => 0,
                'appearance' => [
                    'collapseAll' => false,
                    'enabledControls' => [
                        'info' => true,
                        'new' => false,
                        'dragdrop' => false,
                        'sort' => false,
                        'hide' => true,
                        'delete' => true,
                        'localize' => false,
                    ],
                ],
            ],
        ],
        'created_by_france_connect' => [
            'config' => [
                'type' => 'passthrough',
            ]
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $columns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'social_accounts');
});
