<?php


$desc = [
    'teaser' => [
        'exclude' => true,
        'label' => $ll . 'tx_news_domain_model_news.teaser',
        'config' => [
            'type' => 'text',
            'cols' => 60,
            'rows' => 5,
            'enableRichtext' => true,
        ]
    ],
    'title2' => [
        'exclude' => false,
        'l10n_mode' => 'prefixLangTitle',
        'label' => 'Überschrift 2',
        'config' => [
            'type' => 'input',
            'size' => 60,
            'max' => 255,
            'eval' => 'required',
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $desc);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes("tx_news_domain_model_news", 'title2', '', 'after:title');
