<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\SchedulerTask;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 BEAURIN Tristan <tbeaurin@e-magineurs.com>, E-magineurs
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Emagineurs\EAnnuaires\Utility\AbstractLib;
use TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Messaging\FlashMessage;

class ImportTableAdditionalFieldProvider implements AdditionalFieldProviderInterface
{
    /**
     * Type de champs ajoutes
     *
     * @var array<string, string>
     */
    protected array $params = [
        'table' => 'string',
        'pidFeuser' => 'int',
        'configuration' => 'string',
        'pid' => 'int',
        'type' => 'int',
        'pidCat' => 'int',
        'parentCat' => 'int',
    ];
	
    /**
     * Add an integer input field for difference between scheduler run time
     * and file modification time in days to select from
     *
     * @param array $taskInfo Reference to the array containing the info used in the add/edit form
     * @param AbstractTask|null $task When editing, reference to the current task object. Null when adding.
     * @param SchedulerModuleController $parentObject Reference to the calling object (Scheduler's BE module)
     * @return array<string, array<string, string>> Array containing all the information pertaining to the additional fields
     */
    public function getAdditionalFields(array &$taskInfo, $task, SchedulerModuleController $parentObject): array
    {
        $additionalFields = [];
        
        foreach ($this->params as $param => $type) {
            $name = 'scheduler_eannuaire_' . $param;
            if (!isset($taskInfo[$name])) {
                if ($task !== null && property_exists($task, $param)) {
                    $taskInfo[$name] = $task->$param;
                } else {
                    $taskInfo[$name] = '';
                }
            }
            $fieldName = 'tx_scheduler[' . $name . ']';
            $fieldId = $name;
            $fieldValue = (string)$taskInfo[$name];
            
            if ($param === 'configuration') {
                $fieldHtml = '<textarea cols="40" name="' . $fieldName . '" id="' . $fieldId . '">' . htmlspecialchars($fieldValue) . '</textarea>';
            } else {
                $fieldHtml = '<input type="text" name="' . $fieldName . '" id="' . $fieldId . '" value="' . htmlspecialchars($fieldValue) . '" />';
            }
            $additionalFields[$fieldId] = [
                'code' => $fieldHtml,
                'label' => AbstractLib::getLL('ImportTableTask.' . $param),
                'cshKey' => '',
                'cshLabel' => '',
            ];
        }
        return $additionalFields;
    }

    /**
     * Checks if the given value is an integer
     *
     * @param array $submittedData Reference to the array containing the data submitted by the user
     * @param SchedulerModuleController $parentObject Reference to the calling object (Scheduler's BE module)
     * @return bool true if validation was ok (or selected class is not relevant), false otherwise
     */
    public function validateAdditionalFields(array &$submittedData, SchedulerModuleController $parentObject): bool
    {
        $result = true;
        
        foreach ($this->params as $param => $type) {
            $name = 'scheduler_eannuaire_' . $param;
            if ($param !== 'parentCat') {
                if ($type === 'int') {
                    if (!isset($submittedData[$name]) || !is_numeric($submittedData[$name]) || (int)$submittedData[$name] < 1) {
                        $result = false;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Saves given integer value in task object
     *
     * @param array $submittedData Contains data submitted by the user
     * @param AbstractTask $task Reference to the current task object
     * @return void
     */
    public function saveAdditionalFields(array $submittedData, AbstractTask $task): void
    {
        foreach ($this->params as $param => $type) {
            $key = 'scheduler_eannuaire_' . $param;
            if (!isset($submittedData[$key])) {
                continue;
            }
            $val = $submittedData[$key];
            if ($type === 'int') {
                $val = (int)$val;
            } else {
                $val = trim((string)$val);
            }
            $task->$param = $val;
        }
    }
}