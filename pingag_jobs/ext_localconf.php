<?php
defined('TYPO3_MODE') or die();


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'list',
    ['Vacancy' => 'list'],
    ['Vacancy' => 'list']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'show',
    ['Vacancy' => 'show'],
    ['Vacancy' => 'show']
);

// Realurl Configuration Hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['pingag_jobs'] = 'Pingag\\PingagJobs\\Hooks\\Realurl->addConfig';

// Job Publication Task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Pingag\PingagJobs\Task\UpdateTask::class] = array(
    'extension' => $_EXTKEY,
    'title' => 'Updates Jobs from the PeopleXS System',
    'description' => 'Updates Jobs from the PeopleXS System.',
);