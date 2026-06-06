<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Hosting
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class HostingUtility 
{

	protected $tempIsFaelligArr = [];
	protected $tempIsUeberFaelligArr = [];

	public static $instance;
    public function __construct() {
        self::$instance = $this;
    }


	public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
	//	if(!self::$tempIsFaelligArr) self::$tempIsFaelligArr = [];
	//	if(!self::$tempIsUeberFaelligArr) self::$tempIsUeberFaelligArr = [];
        return self::$instance;
    }
	
	


    /**
     * 
     * @param \DateTime $date
     * @return boolean
     */
	public function isFaellig(\DateTime $date)
	{
		if(isset($this->tempIsFaelligArr[$date->format("Ym01")])) {
			return $this->tempIsFaelligArr[$date->format("Ym01")];
		}

		//return false;
		$dateFaellig = new \DateTime(date('Y-m-d H:i:s', mktime(0, 0, 0, (int)date('m'), 1, (int)date('Y'))));//orange
		date_add($dateFaellig, date_interval_create_from_date_string('1 months'));		
		
		if($date->format("Ym01") <= $dateFaellig->format("Ymd")) {
			return $this->tempIsFaelligArr[$date->format("Ym01")] = true;
		} else {
			return $this->tempIsFaelligArr[$date->format("Ym01")] = false;
		}

		
	}
	
	/**
     * 
     * @param \DateTime $date
     * @return boolean
     */
	public function isUeberFaellig(\DateTime $date)
	{
		if(isset($this->tempIsUeberFaelligArr[$date->format("Ym01")])) {
			return $this->tempIsUeberFaelligArr[$date->format("Ym01")];
		}

	//	return false;
		$dateUeberFaellig = new \DateTime(date('Y-m-d H:i:s', mktime(0, 0, 0, (int)date('m'), 1, (int)date('Y'))));
		
		if($date->format("Ym01") <= $dateUeberFaellig->format("Ymd")) {
			return $this->tempIsUeberFaelligArr[$date->format("Ym01")] = true;
		} else {
			return $this->tempIsUeberFaelligArr[$date->format("Ym01")] = false;
		}
			

		
	}
	
	/**
     * 
     * @param integer $interval
     * @return string
     */
	public function getIntervalDateString($interval)
	{
		switch($interval){
			case 10:
				return "1 months";
			break;	
			case 30:
				return "3 months";			
			break;	
			case 60:
				return "6 months";			
			break;	
			case 120:
				return "1 year";			
			break;
			case 240:
				return "2 years";			
			break;
			case 360:
				return "3 years";			
			break;
		}
		return "";
	
	}	
	/**
     * 
     * @param integer $interval
     * @return integer
     */
	public function getLaufzeitMonate($interval)
	{
		switch($interval){
			case 10:
				return 1;
			break;	
			case 30:
				return 3;			
			break;	
			case 60:
				return 6;			
			break;	
			case 120:
				return 12;			
			break;	
			case 240:
				return 24;			
			break;
			case 360:
				return 36;			
			break;
		}
		return 0;
	
	}	
 

}