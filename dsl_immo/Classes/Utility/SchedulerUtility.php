<?php
namespace  DslFactory\DslImmo\Utility;


use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Utility class for Scheduler
 *
 * @package TYPO3
 * @subpackage tx_dslimmo
 */
class SchedulerUtility 
{

	public static $instance;
    public function __construct() {
        self::$instance = $this;
    }

	public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 
     * @param string schedulerUids
     */
	public function executeTasks($schedulerUids)
	{
		$schedulerUidArr = array();
 		$uidArr = explode(",",trim(str_replace(";",",",$schedulerUids),','));
		if(count($uidArr)) {
			foreach($uidArr as $schedulerUid){
				$uid = intval($schedulerUid);
				if($uid){
					if((string)$uid == (string)$schedulerUid){
						$schedulerUidArr[] = $uid;
						
					}
					
				}
			}
		}
		
		if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('scheduler')) {
			foreach($schedulerUidArr as $schedulerUid){
				
				
				
				
				
				$scheduler = GeneralUtility::makeInstance(\TYPO3\CMS\Scheduler\Scheduler::class);
		
// Try fetching the task
		
				$task = $scheduler->fetchTask($schedulerUid);
				if(!$task) continue;
//                    $class = get_class($task);
//					if(!$class) continue;

				//$name = $registeredClasses[$class]['title'] . ' (' . $registeredClasses[$class]['extension'] . ')';
				if (GeneralUtility::_POST('go_cron') !== null) {
					$task->setRunOnNextCronJob(true);
					$task->save();
				} else {
					// Now try to execute it and report on outcome
					try {
						$result = $scheduler->executeTask($task);
						if ($result) {

						   // $this->addMessage(sprintf($this->getLanguageService()->getLL('msg.executed'), $name));
						} else {
						 //   $this->addMessage(sprintf($this->getLanguageService()->getLL('msg.notExecuted'), $name), FlashMessage::ERROR);
						}
					} catch (\Exception $e) {
						// An exception was thrown, display its message as an error
						//$this->addMessage(sprintf($this->getLanguageService()->getLL('msg.executionFailed'), $name, $e->getMessage()), FlashMessage::ERROR);

					}
				}
				
				
				
			}
		}
		
		

		return;
	}


}