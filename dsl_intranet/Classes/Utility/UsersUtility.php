<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Users
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class UsersUtility 
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
	
	



	public function getFeUser()
    {
		
		
	
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
		return $user;
    }
	
	

 
	
	


}