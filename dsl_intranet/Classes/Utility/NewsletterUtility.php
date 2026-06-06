<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Users
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class NewsletterUtility 
{


	public $api;
	
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
	
	
	public function initApi(){//\TYPO3\CMS\Core\Utility\
		if(!$this->api) {
			
			$nl2goSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('nl2go');
			if($nl2goSettings["active"]){
			
				$authKey = $nl2goSettings["authKey"];
				$userEmail = $nl2goSettings["userEmail"];
				$userPassword = $nl2goSettings["userPassword"];
				
				$this->api = new \DslFactory\DslIntranet\Utility\Newsletter2Go_REST_Api_Dsl($authKey, $userEmail, $userPassword);
				$this->api->setSSLVerification(false);
				
			}
			/*https://docs.newsletter2go.com/?_ga=2.253269899.34505663.1519993030-1802414241.1519993030&_gac=1.117387636.1519992989.Cj0KCQiAieTUBRCaARIsAHeLDCTTtGwxz56jscJPDcWNydg5tOkHvKH3kYHgYJH38t4dDw5NVK9xIJwaAtalEALw_wcB#!/Recipient/getRecipients*/

			
			
			
			
		
		}
	}


	public function getApi()
    {
		$this->initApi();
		return $this->api;
	
		//echo $this->api;
		//echo $this->api="def";
		//return "testfunctui";
	/*
		//$groupStorage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		
		
        $user = $GLOBALS['TSFE']->fe_user->user;
		 switch ($user['tx_extbase_type']) {
            case 'Tx_DslIntranet_Mitarbeiter':    
				$mitarbeiterRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
				return $mitarbeiterRepository->findByUid($user['uid']);

                break;
            case 'Tx_DslIntranet_Kunden':    
				$kundenRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
				return $kundenRepository->findByUid($user['uid']);
			
            break;
        }
		return $user;*/
    }
	
	

 
	
	


}