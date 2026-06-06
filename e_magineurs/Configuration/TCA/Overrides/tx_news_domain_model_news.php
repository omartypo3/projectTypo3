<?php

$ll = 'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:';

$teaserRteConfiguration = 'richtext:rte_transform[mode=ts_css]';

$GLOBALS['TCA']['tx_news_domain_model_news']['types']['0']['columnsOverrides'] = [
    'bodytext' => [
        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
    ],
    'teaser' => [
        'defaultExtras' => $teaserRteConfiguration
    ],
];

if (isset($GLOBALS['TCA']['tx_news_domain_model_news']['columns']['related_from'])) {
    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['related_from']['config']['readOnly'] = true;
}

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;paletteAccess,
        starttime,endtime,fe_group,editlock',
    '',
    'after:rte_disabled'
); 

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    'toptitle',
    '',
    'after:title'
);