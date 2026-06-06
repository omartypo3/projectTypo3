<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Settings
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class LanguageUtility 
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
     * @param string $ext
     * @param string $model
     * @param string $field
     * @return mixed
     */
	public function getArrayFor($ext, $model,$field)
	{
	
	
		$statuss = array();
        foreach ($GLOBALS['TCA'][$model]['columns'][$field]['config']['items'] as $status) {
            $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($model.'.'.$field.'.' . $status[1], $ext,[],'de');
        }
        return $statuss;
		
		
		
		
	}
	


}