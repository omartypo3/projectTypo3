<?php
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
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * ImportExportTask
 */
class ImportExportTask extends AbstractTask {
	/**
	 * The task title
	 *
	 * @var integer
	 */
	protected $name;

    /**
     * Function execute from the Scheduler
     *
     * @access public
     * @return bool TRUE on successful execution, FALSE on error
     * @throws \Exception
     */
	public function execute() {
		$this->initSettings();
		
		$conf = array();
		$conf['vendor'] = 'Emagineurs';
		$conf['extensionName'] = 'EImportExport';
		$conf['controller'] = 'ImportExport';
		$conf['action'] = 'index';
		$conf['arguments'] = array('confuid' => $this->getTaskUid());

		$export = Utility::callExtbaseAction($conf);
		$export = unserialize($export);

		if($export['status'] == 'ok'){
			$recap = sprintf(Utility::getLL('ImportExportTask.recap'), $export['create'], $export['update']);
			$this->addMessage($recap);					
		}
		else{
			throw new \Exception($export['error']);
		}
		
		return true;
	}
	
	/**
	 * Display a message as flash message
	 *
	 * @param string $message the message
	 * @access public
	 * @return void
	 */
	public function addMessage($message){
		if(!$this->moduleTemplate)
			$this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
		
		$severity = FlashMessage::INFO;
		$title = Utility::getLL('ImportExportTask.name').' - '.$this->name;
		
		$this->moduleTemplate->addFlashMessage($message, $title, $severity);
	}
	
	/**
	 * Returns some additional information about indexing progress, shown in
	 * the scheduler's task overview list.
	 *
	 * @access public
	 * @return string Information to display
	 */
	public function getAdditionalInformation() {
		$this->initSettings();
		return $this->name;
	}

	/**
	 * Init settings before the task execution
	 *
	 * @access public
	 * @return void
	 */
	function initSettings(){
		if($this->isCron()){
			$GLOBALS['BE_USER']->user['admin'] = 1;
		}
		$confRepository = GeneralUtility::makeInstance(className: ConfRepository::class);
		$exportConf = $confRepository->findByUid($this->getTaskUid());
		$this->name = '[' . $this->getTaskUid() . '] ' . ($exportConf !== null ? $exportConf->getTitle() : '');
	}
	
	/**
	 * Check if the task is a cron task
	 *
	 * @access public
	 * @return boolean TRUE if the task is a cron task, FALSE otherwise
	 */
	function isCron(){
		if($GLOBALS['BE_USER']->user['username'] != '_cli_scheduler')
			return false;
		return true;
	}
}
