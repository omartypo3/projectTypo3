<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Settings
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class SettingsUtility 
{

	public static $vars;
	
	public static $settings;

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
     * @param string $section
     * @return mixed
     */
	public function getSettingFor($section)
	{
		
		if(self::$settings===null){
			$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
			$extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

			self::$settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];
			
		}

		if(isset(self::$settings[$section])) {
			return self::$settings[$section];
		} elseif(isset(self::$settings[$section."."])){
			return self::$settings[$section."."];
		}
		return false;
		
		
	}
	

	
    /**
     * 
     * @param string $section
     * @return mixed
     */
	public function getVarFor($key)
	{
		
		if(self::$vars===null) self::$vars = array();
		if(isset(self::$vars[$key])) return self::$vars[$key];
		
		return false;
		
		
	}
	
	    /**
     * 
     * @param string $key
	 * @param mixed $value
     * @return mixed
     */
	public function setVarFor($key,$value)
	{
		
		if(self::$vars===null) self::$vars = array();
		self::$vars[$key] = $value;
		
		return true;
		
		
	}

}