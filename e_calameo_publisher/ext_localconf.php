<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Emagineurs\ECalameoPublisher\Controller\CalameoPluginController;

defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'e_calameo_publisher';

ExtensionUtility::configurePlugin(
    $_EXTKEY,
    'CalameoPlugin',
    [
        CalameoPluginController::class => 'index,list',
    ],
    [
        CalameoPluginController::class => 'index,list',
    ]
);

// Register FormEngine renderTypes for flexform fields
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1704124800] = [
    'nodeName' => 'selectAllDocuments',
    'priority' => 40,
    'class' => \Emagineurs\ECalameoPublisher\Form\Element\SelectAllDocumentsElement::class,
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1704124801] = [
    'nodeName' => 'selectDocuments',
    'priority' => 40,
    'class' => \Emagineurs\ECalameoPublisher\Form\Element\SelectDocumentsElement::class,
];