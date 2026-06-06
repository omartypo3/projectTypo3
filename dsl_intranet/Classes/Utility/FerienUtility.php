<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Ferien
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class FerienUtility 
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
	
	

	private $ferien = array();

    

    public function getFerienFuerJahr($jahr)
    {
		
		if(!isset($this->ferien[$jahr])){
			$this->ferien[$jahr]=self::getFerien($jahr);
		}
		
		return $this->ferien[$jahr];
		
    }
    
    /**
     * 
     * @param \DateTime $date
     * @return boolean
     */
	public function isFerien(\DateTime $date)
	{
		//return false;
		$ferienArr = self::getFerienFuerJahr($date->format('Y'));
		
		if(isset($ferienArr[$date->format('Y-m-d')])) return true;
		return false;
		//$date->format('Y-m-d')
		return true;	
	}
	
	
	// Ferien für ein jahr abfragen
    /**
     * @param $iYear
     */
    private function getFerien($iYear)
    {
        $ferien = array();

        for( $jahr=$iYear-1 ; $jahr<=$iYear ; $jahr++ ){

            $json = json_decode(file_get_contents('https://ferien-api.de/api/v1/holidays/SN/'.$jahr));


            foreach($json as $ferie){
                $begin = new \DateTime($ferie->start);
                $end = new \DateTime($ferie->end);

                $interval = new \DateInterval('P1D');
                $daterange = new \DatePeriod($begin, $interval ,$end);
                foreach($daterange as $date){

                    if($date->format("Y")==$iYear){
                        $ferien[date('Y-m-d', mktime(0, 0, 0, $date->format("m") , $date->format("d") , $date->format("Y") ))] = ucfirst($ferie->name);
                    }
                    //echo $date->format("Ymd") . "<br>";
                }
    /*
                echo $begin->format("d.m.Y")."<br>";
                echo $ferie->start;
                echo ":";
                echo $ferie->end;
                echo ":";
                echo $ferie->name;
                echo "<br>";*/
            }
        }
        

        ksort($ferien);
/*        ?><pre><?php print_r($ferien);?></pre><?php 
        die;*/

        //$ferien[date('Y-m-d', mktime(0, 0, 0, 1, 2, $iYear))] = 'Ferientagnachneujahr';
        return $ferien;

    }
    
 
    

}