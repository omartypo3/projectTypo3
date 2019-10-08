<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
call_user_func(function () {
    // Add your code here
});
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi1/class.tx_mtmeteo_pi1.php', '_pi1', 'list_type', 1);

?>