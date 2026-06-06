<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Views
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class DateUtility 
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
	
	


    // korrektur chrome filter von "(Mitteleuropäische Zeit)" am ende des zeitstrings
    /**
     * @param $datestring
     */
    public function parseDateString($datestring)
    {
        $tmpArr = explode('(', $datestring);
        if (count($tmpArr) > 1) {
            return trim($tmpArr[0]);
        } else {
            return $datestring;
        }
    }
	
	
	/** @var $logger \TYPO3\CMS\Core\Log\Logger */
/*        $logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        $logger->info('Everything went fine.');
        $logger->warning('Something went awry, check your configuration!');
        $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'This is an utter failure!');*/
	
    /**
     * @param $time
     */
    public function convertTimeToArray($time)
    {
        $stunden = floor($time / 60);
        $minuten = $time - $stunden * 60;
        return array('stunden' => $stunden, 'minuten' => $minuten);
    }

}