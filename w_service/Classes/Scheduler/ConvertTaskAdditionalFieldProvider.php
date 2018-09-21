<?php

class tx_wservice_scheduler_converttaskadditionalfieldprovider implements tx_scheduler_AdditionalFieldProvider {

    /**
     * Used to define fields to provide the TYPO3 site to index and number of
     * items to index per run when adding or editing a task.
     *
     * @param	array					$taskInfo: reference to the array containing the info used in the add/edit form
     * @param	tx_scheduler_Task		$task: when editing, reference to the current task object. Null when adding.
     * @param	tx_scheduler_module1	$schedulerModule: reference to the calling object (Scheduler's BE module)
     * @return	array					Array containg all the information pertaining to the additional fields
     *									The array is multidimensional, keyed to the task class name and each field's id
     *									For each field it provides an associative sub-array with the following:
     */
    public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $schedulerModule) {
        $additionalFields = array();

        if ($schedulerModule->CMD == 'add') {
            $taskInfo['convertIndexLimit'] = 100;
        }

        if ($schedulerModule->CMD == 'edit') {
            $taskInfo['convertIndexLimit'] = $task->getConvertIndexLimit();
        }

        $additionalFields['convertIndexLimit'] = array(
            'code'     => '<input type="text" name="tx_scheduler[convertIndexLimit]" value="' . htmlspecialchars($taskInfo['convertIndexLimit']) . '" />',
            'label'    => 'Number of addresses to index per run',
            'cshKey'   => '',
            'cshLabel' => ''
        );

        return $additionalFields;
    }

    /**
     * Checks any additional data that is relevant to this task. If the task
     * class is not relevant, the method is expected to return TRUE
     *
     * @param	array					$submittedData: reference to the array containing the data submitted by the user
     * @param	tx_scheduler_module1	$parentObject: reference to the calling object (Scheduler's BE module)
     * @return	boolean					True if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $schedulerModule) {
//        $result = FALSE;

        // escape limit
        $submittedData['convertIndexLimit'] = intval($submittedData['convertIndexLimit']);

        return TRUE;
    }

    /**
     * Saves any additional input into the current task object if the task
     * class matches.
     *
     * @param	array				$submittedData: array containing the data submitted by the user
     * @param	tx_scheduler_Task	$task: reference to the current task object
     */
    public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {
        $task->setConvertIndexLimit($submittedData['convertIndexLimit']);
    }
}

?>