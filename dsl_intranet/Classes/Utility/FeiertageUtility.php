<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Feiertage
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class FeiertageUtility 
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
	
	

	private $feiertage = array();

    

    public function getFeiertageFuerJahr($jahr)
    {
		//return self::getFeiertage($jahr);
		if(!isset($this->feiertage[$jahr])){
			$this->feiertage[$jahr]=self::getFeiertage($jahr);
		}
		
		return $this->feiertage[$jahr];
		
    }
    
    /**
     * 
     * @param \DateTime $date
     * @return boolean
     */
	public function isFeiertag(\DateTime $date)
	{
		//return false;
		$feiertageArr = self::getFeiertageFuerJahr($date->format('Y'));
		
		if(isset($feiertageArr[$date->format('Y-m-d')])) return true;
		return false;
		//$date->format('Y-m-d')
		return true;	
	}
	
	
	// Feiertage für ein jahr abfragen
    /**
     * @param $iYear
     */
    private function getFeiertage($iYear)
    {
	
        $aHoliday = array();
        // Feste Feiertage  short / long  description
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, 1, 1, $iYear))] = 'Neujahr';
        //$aHoliday[date("Y.m.d",mktime(0, 0, 0, 1, 6, $iYear))]  = 'Heilige 3 Könige';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, 5, 1, $iYear))] = '1. Mai';
        //$aHoliday[date("Y.m.d",mktime(0, 0, 0, 8, 15, $iYear))]  = 'Maria Himmelfahrt';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, 10, 3, $iYear))] = 'Tag der deutschen Einheit';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, 10, 31, $iYear))] = 'Reformationstag';
        //$aHoliday[date("Y.m.d",mktime(0, 0, 0, 11, 1, $iYear))]  = 'Allerheiligen';
        // $aHoliday[date("Y-m-d",mktime(0, 0, 0, 12, 24, $iYear))]  = 'Heiligabend';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, 12, 25, $iYear))] = '1. Weihnachtsfeiertag';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, 12, 26, $iYear))] = '2. Weihnachtsfeiertag';
        // $aHoliday[date("Y-m-d",mktime(0, 0, 0, 12, 31, $iYear))]  = 'Sylvester';
        // Bewegliche Feiertage, von Ostern abhängig
        $iEaster = self::getEasterjetzt($iYear);

		
//echo "Ostersonntag: ".date('d.m.Y', $iEaster)."<br>";
        $iEasterDay = date('d', $iEaster);
        $iEasterMonth = date('m', $iEaster);
        $iEasterYear = date('Y', $iEaster);
        // $aHoliday[date("Y.m.d",mktime(0,0,0,$iEasterMonth,$iEasterDay-48,$iEasterYear))]= 'Rosenmontag';
        // $aHoliday[date("Y.m.d",mktime(0,0,0,$iEasterMonth,$iEasterDay-46,$iEasterYear))]= 'Aschermittwoch';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, $iEasterMonth, $iEasterDay - 2, $iEasterYear))] = 'Karfreitag';
        // $aHoliday[date("Y-m-d",mktime(0,0,0,$iEasterMonth,$iEasterDay,$iEasterYear))]   = 'Ostersonntag';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, $iEasterMonth, $iEasterDay + 1, $iEasterYear))] = 'Ostermontag';
//echo "Himmelfahrt: ".date('Y-m-d', mktime(0, 0, 0, $iEasterMonth, $iEasterDay + 39, $iEasterYear))."<br>";		
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, $iEasterMonth, $iEasterDay + 39, $iEasterYear))] = 'Himmelfahrt';
        // $aHoliday[date("Y-m-d",mktime(0,0,0,$iEasterMonth,$iEasterDay+49,$iEasterYear))]= 'Pfingstsonntag';
        $aHoliday[date('Y-m-d', mktime(0, 0, 0, $iEasterMonth, $iEasterDay + 50, $iEasterYear))] = 'Pfingstmontag';
        // $aHoliday[date("Y.m.d",mktime(0,0,0,$iEasterMonth,$iEasterDay+60,$iEasterYear))]= 'Fronleichnam';
        // Bewegliche Feiertage, vom ersten Advent abhängig
        $iFirstAdvent = self::getFirstAdvent($iYear);
        $iAdventDay = date('d', $iFirstAdvent);
        $iAdventMonth = date('m', $iFirstAdvent);
        $iAdventYear = date('Y', $iFirstAdvent);
        // $aHoliday[date("Y-m-d",mktime(0,0,0,$iAdventMonth,$iAdventDay,$iAdventYear))]= '1. Advent';
        // $aHoliday[date("Y-m-d",mktime(0,0,0,$iAdventMonth,$iAdventDay+7,$iAdventYear))]= '2. Advent';
        // $aHoliday[date("Y-m-d",mktime(0,0,0,$iAdventMonth,$iAdventDay+14,$iAdventYear))]= '3. Advent';
        // $aHoliday[date("Y-m-d",mktime(0,0,0,$iAdventMonth,$iAdventDay+21,$iAdventYear))]= '4. Advent';
        $aHoliday[self::getBussBettag($iYear)] = 'Buß- und Bettag';
        // $aHoliday[date("Y.m.d",mktime(0,0,0,$iAdventMonth,$iAdventDay-28,$iAdventYear))]= 'Totensonntag';
        // $aHoliday[date("Y.m.d",mktime(0,0,0,$iAdventMonth,$iAdventDay-35,$iAdventYear))]= 'Volkstrauertag';
		
		
        return $aHoliday;
    }
    
    /*Feiertagsberechnungen*/
    // Berechnung des ersten Advent
    /**
     * @param $iYear
     */
    private function getFirstAdvent($iYear)
    {
        $wei = mktime(0, 0, 0, 12, 25, $iYear);
        for ($i = 7; $i > 0; $i--) {
            $wei -= 86400;
            $advent4 = $wei;
            $advent41 = date('Y.m.D', $advent4);
            $advent42 = date('Y.m.d', $advent4);
            if ($advent41 == $iYear . '.12.Sun') {
                $iLastAdvent = $advent4;
            }
        }
        return $iLastAdvent - 3 * 7 * 24 * 60 * 60;
    }
    
    // Berechnung des Buss und Bettages
    /**
     * @param $iYear
     */
    private function getBussBettag($iYear)
    {
        $iFirstAdvent = self::getFirstAdvent($iYear);
        $anzahl = 0;
        for ($i = 14; $i > 0; $i--) {
            $iFirstAdvent = $iFirstAdvent - 86400;
            $buss = date('Y-m-D', $iFirstAdvent);
            $buss2 = date('Y-m-d', $iFirstAdvent);
            if ($buss == $iYear . '-11-Wed') {
                $anzahl++;
                $anzahl;
            }
            if ($anzahl == '2' && $buss == $iYear . '-11-Wed') {
                $iBettag = $buss2;
            }
        }
        return $iBettag;
    }
    
    /**
     * @param $iYear
     */
    private function getEasterjetzt($iYear = -1)
    {
	
        // the Golden number
        $iGolden = $iYear % 19 + 1;
        // the "Domincal number"
        $iDom = ($iYear + (int) ($iYear / 4) - (int) ($iYear / 100) + (int) ($iYear / 400)) % 7;
        if ($iDom < 0) {
            $iDom += 7;
        }
        // the solar and lunar corrections
        $iSolar = ($iYear - 1600) / 100 - ($iYear - 1600) / 400;
        $iLunar = ($iYear - 1400) / 100 * 8 / 25;
        // uncorrected date of the Paschal full moon
        $iPFM = (3 - 11 * $iGolden + $iSolar - $iLunar) % 30;
        if ($iPFM < 0) {
            $iPFM += 30;
        }
        // corrected date of the Paschal full moon
        // days after 21st March
        if ($iPFM == 29 || $iPFM == 28 && $iGolden > 11) {
            $iPFM--;
        }
        $iTMP = (4 - $iPFM - $iDom) % 7;
        if ($iTMP < 0) {
            $iTMP += 7;
        }
        // Easter as the number of days after 21st March */
        $iEaster = $iPFM + $iTMP + 1;
        if ($iEaster < 11) {
            $iMonth = 3;
            $iDay = $iEaster + 21;
        } else {
            $iMonth = 4;
            $iDay = $iEaster - 10;
        }
		
        $iEaster = mktime(0, 0, 0, $iMonth, $iDay, $iYear);//, -1); letzter parameter entfernt da er nicht mehr unterstütz wird
        return $iEaster;
    }
    
    /**
     * @param $iYear
     */
    private function getImportantDays($iYear)
    {
        // summertime
        for ($i = 31; $i <= 40; $i--) {
            if (date('w', mktime(0, 0, 0, 3, $i, $iYear)) == '0') {
                $iSummertime = mktime(0, 0, 0, 3, $i, $iYear);
                break;
            }
        }
        // wintertime
        for ($i = 30; $i <= 40; $i--) {
            if (date('w', mktime(0, 0, 0, 10, $i, date('Y'))) == '0') {
                $iWintertime = mktime(0, 0, 0, 10, $i, date('Y'));
                break;
            }
        }
        // mothersday
        $l = 0;
        for ($i = 0; $i <= 31; $i++) {
            if (date('w', mktime(0, 0, 0, 5, $i, date('Y'))) == '0') {
                $l++;
            }
            if ($l == 2) {
                $iMothersday = mktime(0, 0, 0, 5, $i, date('Y'));
                break;
            }
        }
        $aImportantDays[mktime(0, 0, 0, 1, 1 + 44, $iYear)] = 'Valentienstag';
        $aImportantDays[mktime(0, 0, 0, 1, 1 + 79 + date('L'), $iYear)] = 'Frühlingsanfang';
        $aImportantDays[mktime(0, 0, 0, 1, 1 + 171 + date('L'), $iYear)] = 'Sommeranfang';
        $aImportantDays[mktime(0, 0, 0, 1, 1 + 275 + date('L'), $iYear)] = 'Herbstanfang';
        $aImportantDays[mktime(0, 0, 0, 1, 1 + 355 + date('L'), $iYear)] = 'Winteranfang';
        $aImportantDays[$iSummertime] = 'Sommerzeitumstellung';
        $aImportantDays[$iWintertime] = 'Winterzeitumstellung';
        $aImportantDays[$iMothersday] = 'Muttertag';
        return $aImportantDays;
    }
	
	
    
    

}