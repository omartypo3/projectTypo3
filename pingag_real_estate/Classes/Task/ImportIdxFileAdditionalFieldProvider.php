<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 27.07.2018
 * Time: 10:35
 */

namespace Pingag\PingagRealEstate\Task;

use Pingag\PingagRealEstate\Service\RealEstateImporter;
use TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface;

class ImportIdxFileAdditionalFieldProvider implements AdditionalFieldProviderInterface
{

    /**
     * Gets additional fields to render in the form to add/edit a task
     *
     * @param array $taskInfo Values of the fields from the add/edit task form
     * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task The task object being edited. Null when adding a task!
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     * @return array A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' => '', 'cshKey' => '', 'cshLabel' => ''))
     */
    public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule)
    {

        if (empty($taskInfo['timeOut'])) {
            if ($schedulerModule->CMD == 'edit') {
                $taskInfo['importSource'] = $task->importSource;
            } else {
                $taskInfo['importSource'] = $task->importSource;
            }
        }
        
        $fieldCode = '<div class="form-control-wrap">';
        $fieldCode .= '<input type="text" name="tx_scheduler[importSource]"id="importSource" class="form-control" value="'. htmlspecialchars($taskInfo['importSource']) .'" required="required" />';
        $fieldCode .= '</div>';
        
        return [
            'importSource' => [
                'code' => $fieldCode,
                'label' => 'Import File Pfad',
            ],
        ];
    }

    /**
     * Validates the additional fields' values
     *
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     * @return bool TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule)
    {
        if(!isset($submittedData['importSource'])){
            return false;
        }

        $sources = $submittedData['importSource'];
        foreach (explode(',', $sources) as $source) {
            $importSource = PATH_site . RealEstateImporter::REAL_ESTATE_IMPORT_DIR . '/' . $this->cleanImportSource($source);
            if(!file_exists($importSource)){
                return false;
            }
        }
        
        return true;
    }

    /**
     * Takes care of saving the additional fields' values in the task's object
     *
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the scheduler backend module
     * @return void
     */
    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task)
    {
        $task->importSource = $this->cleanImportSource($submittedData['importSource']);
    }
    
    protected function cleanImportSource($path)
    {
        return trim($path, '/');
    }
}