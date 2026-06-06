<?php

declare(strict_types=1);

namespace Emagineurs\EImportExport\SchedulerTask;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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

use Emagineurs\EImportExport\Domain\Repository\ConfRepository;
use Emagineurs\EImportExport\Utility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * ImportExportAdditionalFieldProvider
 */
class ImportExportAdditionalFieldProvider implements AdditionalFieldProviderInterface
{
    protected string $prefix = 'scheduler_eimportexport_';
    protected string $prefixLL = 'ImportExportTask.';

    /**
     * Id of the import that will be processed
     *
     * @var int
     */
    protected int $uidRec = 30;

    /**
     * The types of the fields that will be added
     *
     * @var array<string, string>
     */
    protected array $params = [
        'uidRec' => 'int',
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
    public function getAdditionalFields(
        array &$taskInfo,
        $task,
        SchedulerModuleController $parentObject
    ): array {
        $additionalFields = [];
        foreach ($this->params as $param => $type) {
            $name = $this->prefix . $param;
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
            
            // Build the select box html
            $fieldHtml = '<select name="' . $fieldName . '" id="' . $fieldId . '" >';
            try {
                $confRepo = GeneralUtility::makeInstance(ConfRepository::class);
                foreach ($confRepo->findAll() as $conf) {
                        if ($fieldValue === (string)$conf->getUid()) {
                            $fieldHtml .= '<option value="' . $conf->getUid() . '" selected>' . htmlspecialchars($conf->getTitle()) . '</option>';
                        } else {
                            $fieldHtml .= '<option value="' . $conf->getUid() . '" >' . htmlspecialchars($conf->getTitle()) . '</option>';
                        }
                }
            } catch (\Exception $e) {
                // Fallback if repository unavailable
                $fieldHtml .= '<option value="">No configurations available</option>';
            }
            $fieldHtml .= '</select>';
            
            $additionalFields[$fieldId] = [
                'code' => $fieldHtml,
                'label' => Utility::getLL($this->prefixLL . $param),
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
    public function validateAdditionalFields(
        array &$submittedData,
        SchedulerModuleController $parentObject
    ): bool {
        $result = true;
        
        foreach ($this->params as $param => $type) {
            $name = $this->prefix . $param;
            
            if ($type === 'int') {
                if (!isset($submittedData[$name]) || !is_numeric($submittedData[$name]) || (int)$submittedData[$name] < 1) {
                    $result = false;
                } elseif ($param === 'uidRec') {
                    $uidRec = (int)$submittedData[$name];
                    // Validate the record exists
                    try {
                        $confRepo = GeneralUtility::makeInstance(ConfRepository::class);
                        $conf = $confRepo->findByUid($uidRec);
                        if ($conf === null) {
                            $result = false;
                        }
                    } catch (\Exception $e) {
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
            $key = $this->prefix . $param;
            if (!isset($submittedData[$key])) {
                continue;
            }
            $val = $submittedData[$key];
            if ($type === 'int') {
                $val = (int)$val;
            } else {
                $val = trim((string)$val);
            }
        }
    }
}
