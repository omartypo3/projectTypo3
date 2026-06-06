<?php 
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

/*http://stackoverflow.com/questions/41503947/typo3-fal-securedownload-slot*/

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */

$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');


$signalSlotDispatcher->connect(
        'BeechIt\\FalSecuredownload\\Hooks\\FileDumpHook',
        'BeforeFileDump',
        'BravoBuero\\BbDownloadlog\\Slot\\LogFileDump',
        'logFileDump'
);
?>