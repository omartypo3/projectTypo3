<?php
namespace FRONTAL\FagInstitutionManagement\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

// This hook fills the username into the email field
class UserHook {

	/**
	 * This function will be executed after creation or update a record in TYPO3-Backend
	 *
     * @param    array                                    $fieldArray : The array of fields and values that have been saved to the datamap
     * @param    string                                   $table      : The name of the table the data should be saved to
     * @param    int                                      $id         : The uid of the page we are currently working on
	 *
	 * @return void
	 */
	public function processDatamap_preProcessFieldArray(&$fieldArray, $table, $id, &$reference) {

        if($table == 'fe_users' && $fieldArray['username'] != '') {
            $fieldArray['email'] = $fieldArray['username'];
        }
	}
}

?>
