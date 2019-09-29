<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 30.04.2018
 * Time: 17:43
 */

namespace Pingag\PingagJobs\Task;

use Pingag\PingagJobs\Service\PeopleXsConnectorService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

class UpdateTask extends AbstractTask
{
    
    /**
     * @return bool Returns TRUE on successful execution, FALSE on error
     */
    public function execute()
    {
        $connectorService = GeneralUtility::makeInstance(PeopleXsConnectorService::class);
        return $connectorService->update();
    }
}