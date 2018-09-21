<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Avonis.' . $_EXTKEY,
    'Main',
    array(
        'Main' => 'pixel, pixelCached, submit',
    ),
    // non-cacheable actions
    array(
        'Main' => 'cookie, submit',
    )
);