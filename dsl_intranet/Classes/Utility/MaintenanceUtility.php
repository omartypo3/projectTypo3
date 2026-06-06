<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Maintenance
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class MaintenanceUtility 
{
	
	protected $objectManager = NULL;

	protected $wartungsvertraegeRepository = NULL;
    protected $wartungsvertraegeZeitraeumeRepository = NULL;
    protected $wartungsvertraegeRechnungenRepository = NULL;

    protected $protokolleRepository = NULL;
	protected $dateienRepository = NULL;
    

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

	public function initVars(){
		if(!$this->objectManager) $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		
		if(!$this->wartungsvertraegeRepository) $this->wartungsvertraegeRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
		if(!$this->wartungsvertraegeZeitraeumeRepository) $this->wartungsvertraegeZeitraeumeRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeZeitraeumeRepository');
		if(!$this->wartungsvertraegeRechnungenRepository) $this->wartungsvertraegeRechnungenRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRechnungenRepository');
		if(!$this->protokolleRepository) $this->protokolleRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
		if(!$this->dateienRepository) $this->dateienRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\DateienRepository');
	}

    public function maintenanceCheckForWartungsvertraegeNewZeitraeume()
	{
		
		
		$this->initVars();
		
		if ($wartungsvertraege = $this->wartungsvertraegeRepository->findAll()) {
			
			
			$nextMonthsFirstDay = new \DateTime();//2017-03-10//'2018-03-01'
			date_add($nextMonthsFirstDay, date_interval_create_from_date_string('1 months'));
			$now = new \DateTime($nextMonthsFirstDay->format('Y-m-') . '01');
			
			/*echo "<br>nextMonthsFirstDay:".$nextMonthsFirstDay->format('d.m.Y');
			echo "nextMonthsFirstDay:".$nextMonthsFirstDay->format('Y-m-') . '01';
			echo "<br>now:".$now->format('d.m.Y');*/
			
            //was ist mit gekündigten?? // evtl abfangen im setzen des enddatums im model?
            foreach ($wartungsvertraege as $wartungsvertrag) {
				
				
				
				if($wartungsvertrag->isGekuendigt()) continue;
                //foreach wartungsverträge
                //echo "<br>wvuid:".$wartungsvertrag->getUid();
				
				
				/*echo "<hr>";
				echo "<br>Titel:".$wartungsvertrag->getTitel();
                echo "<br>getVertragsBegin:".$wartungsvertrag->getVertragsBegin()->format('d.m.Y');*/
				
				
        		
				//if($wartungsvertrag->getVertragsBegin()>$now) continue;
			
				//now ist der 1. tag des nächsten monats
                if (!$this->wartungsvertraegeZeitraeumeRepository->findByWartungsvertragForDate($wartungsvertrag, $now)) {
					
					//echo "<br>nichts gefunden Zeitraum muß erstellt werden";
				//	die;
					//if($wartungsvertrag->getVertragsBegin()<$now);
					
                    //              echo '<br>zeitraum fehlt => erstellen';
                    //                echo '<br>einbauen das geprüft wird wann der letzte wartungsvertragexistierte';
                    //                  echo '<br>wartungsvertrag begin:' . $wartungsvertrag->getVertragsBegin()->format('d.m.Y');
                    //aber egal weil ja mindestens einmal im monat bzw. bei jedem intranet aufruf diese funktion aufgerufen wird
                    //                    echo '<br>wvuid:' . $wartungsvertrag->getUid() . ' - ' . $wartungsvertrag->getTitel();
                    //die;
                    //analog import im wvcontroller
                    $vertragsBegin = clone $wartungsvertrag->getVertragsBegin();
                    foreach ($wartungsvertrag->getZeitraeume() as $zeitraum) {
                        if ($vertragsBegin < $zeitraum->getBis()) {
                            $vertragsBegin = clone $zeitraum->getBis();
                        }
                    }
					//echo "<br>vertragsBegin:".$vertragsBegin->format('d.m.Y');
					$laufzeit = $wartungsvertrag->getLaufzeit();
                    
                    //echo '<br>laufzeit:' . $laufzeit;
					
                   
                    $vertragsBeginZeitraum = new \DateTime($vertragsBegin->format('Y-m').'-01 05:00:00');//clone $vertragsBegin;
                    $vertragsBeginNaechsterZeitraum = clone $vertragsBeginZeitraum;
                    $loopCounter = 0;
                    do {    date_add($vertragsBeginNaechsterZeitraum, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($laufzeit)));
						
						
						
                      // 	echo "<br>vertragsBeginNaechsterZeitraum:".$vertragsBeginNaechsterZeitraum->format('d.m.Y');
						//echo "<br>++Zeitraum";
                       	//die;
						
                        $wartungsvertraegeZeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();
                        $wartungsvertraegeZeitraeume->setVon(clone $vertragsBeginZeitraum);
                        $wartungsvertraegeZeitraeume->setBis(clone $vertragsBeginNaechsterZeitraum);
                        $wartungsvertraegeZeitraeume->setPid(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('wartungsvertraegeZeiteintraegePid'));
						
						/*echo "<br>wartungsvertraegeZeitraeumeVon:".$wartungsvertraegeZeitraeume->getVon()->format('d.m.Y');
						echo "<br>wartungsvertraegeZeitraeumeBis:".$wartungsvertraegeZeitraeume->getBis()->format('d.m.Y');*/
						//die;
						
                        $this->wartungsvertraegeZeitraeumeRepository->add($wartungsvertraegeZeitraeume);
                        $wartungsvertrag->addZeitraeume($wartungsvertraegeZeitraeume);
                        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                        $protokolle->setPid(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('protokollePid'));
                        $protokolle->setAktion(50);
                        $protokolle->setNotizSystem('system wartungsvertrag neuen zeitraum erstellt ' . $wartungsvertraegeZeitraeume->getUid().$wartungsvertraegeZeitraeume->getVon()->format('d.m.Y').' - '.$wartungsvertraegeZeitraeume->getBis()->format('d.m.Y'));
                        $protokolle->setZeitpunkt(new \DateTime());
						if(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser())
                        	$protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                        $this->protokolleRepository->add($protokolle);
						//01.04.2017 >= 
						/*echo "<br>if";
						echo "<br>now:".$now->format('Ymd');
						echo "<br>vertragsBeginZeitraum:".$vertragsBeginZeitraum->format('d.m.Y');
						echo "<br>vertragsBeginNaechsterZeitraum:".$vertragsBeginNaechsterZeitraum->format('Ymd');
						echo '<br><strong>if (now < vertragsBeginNaechsterZeitraum) </strong>';*/
                        if ($now->format("Ymd") < $vertragsBeginNaechsterZeitraum->format("Ymd")) {//$now >= $vertragsBeginZeitraum && 
                            //	echo "<br>&gt;= erfüllt";
							//echo "break!!";
							//die;
                            break;
                        }
					//	echo "<hr>";
                        date_add($vertragsBeginZeitraum, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($laufzeit)));
                        $loopCounter++;
                    } while ($loopCounter < 100);
					//die;
                }
                $this->wartungsvertraegeRepository->update($wartungsvertrag);
            }
			
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }
		//die;
		
	}
    public function maintenanceCheckForWartungsvertraegeNewRechnungen()
	{
		$this->initVars();
		
	//	echo "<hr><br>maintenanceCheckForWartungsvertraegeNewRechnungen";
		//die;
		
		//neue Rechnungen für Zeiträume erstellen
        if ($zeitraeume = $this->wartungsvertraegeZeitraeumeRepository->findForNewInterval()) {
            //			echo $zeitraeume;
      //                  echo '<br>anzahl zeitraeume:' . count($zeitraeume);
            foreach ($zeitraeume as $zeitraum) {
       
                if (!count($zeitraum->getRechnungen())) {
                    //intervalle erstellen!!
                    $von = clone $zeitraum->getVon();
                    $bis = clone $von;
                    $zeitraumBis = clone $zeitraum->getBis();
                    
                    $wv = $zeitraum->getWartungsvertrag();

                    if($wv){
                        $intervall = $wv->getReIntervall();

                    }else{
                        $intervall = 0;

                    }

                    $debug = '';
                    $loopCounter = 0;
                    do {    //echo '<hr>';
                        //                        echo '<br>do{  addintervall:' . \DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($intervall);
                        date_add($bis, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($intervall)));
                        //                        echo '<br>von:' . $von->format('Ymd') . ' bis:' . $bis->format('Ymd');
                        //                        echo '<br>' . $bis->format('Ymd') . ' > ' . $zeitraum->getBis()->format('Ymd');
                        if ($bis->format('Ymd') > $zeitraum->getBis()->format('Ymd')) {
                            break;
                        }
                        $wartungsvertraegeRechnungen= '';
                        if ($wartungsvertraegeRechnungen) {
                            unset($wartungsvertraegeRechnungen);
                        }
                        $wartungsvertraegeRechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();
                        $wartungsvertraegeRechnungen->setVon(clone $von);
                        $wartungsvertraegeRechnungen->setBis(clone $bis);
                 
                        $wartungsvertraegeRechnungen->setPid(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('wartungsvertraegeZeiteintraegePid'));
                        $wartungsvertraegeRechnungen->setStatus(10);
                        //$wartungsvertraegeRechnungen->setPreis($zeitraum->getWartungsvertrag()->getPreisMonatlich());
                        if ($bis->format('Ymd') == $zeitraumBis->format('Ymd')) {
                            $wartungsvertraegeRechnungen->setType(20);
                        } else {
                            $wartungsvertraegeRechnungen->setType(10);
                        }
                        $zeitraum->addRechnungen($wartungsvertraegeRechnungen);
                        $this->wartungsvertraegeRechnungenRepository->add($wartungsvertraegeRechnungen);
                        $this->wartungsvertraegeZeitraeumeRepository->update($zeitraum);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        //						echo "<br>Neue Rechnung UID: ".$wartungsvertraegeRechnungen->getUid();
                        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                        $protokolle->setPid(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('protokollePid'));
                        $protokolle->setAktion(40);
                        $protokolle->setNotizSystem('system wartungsvertrag neue rechnung für zeitraum erstellt ' . $wartungsvertraegeRechnungen->getUid());
                        $protokolle->setZeitpunkt(new \DateTime());
						if(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser())
                        	$protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                        $this->protokolleRepository->add($protokolle);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        date_add($von, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($intervall)));
                        $loopCounter++;
                    } while ($loopCounter < 100);
                }
            }
        }
		
		
	}

	public function maintenanceCheckForWartungsvertraegeRechnungenStatus()
	{
		//echo "finish";
		//die;
		$this->initVars();
		
		//neue Rechnungen für Zeiträume erstellen
        if ($rechnungen = $this->wartungsvertraegeRechnungenRepository->findForNewStatusFaellig()) {
            //			echo $zeitraeume;
      //      	echo "<br>anzahl rechnungen:".count($rechnungen);
			
            foreach ($rechnungen as $rechnung) {
				
//                	echo "<hr>";
  //              echo "<br>uid: ".$rechnung->getUid();
    //            echo "<br>von: ".$rechnung->getVon()->format('d.m.Y');
                $rechnung->setStatus(20);
                //erstimport::
                //$rechnung->setStatus(30);
                if($rechnung->getPreisBerechnet()) {
                    $rechnung->setPreis($rechnung->getPreisBerechnet());
                    $this->wartungsvertraegeRechnungenRepository->update($rechnung);
                }
                $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                $protokolle->setPid(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('protokollePid'));
                $protokolle->setAktion(30);
				
                $protokolle->setNotizSystem('system wartungsvertrag rechnung auf fällig gesetzt' . $rechnung->getUid());
				
                $protokolle->setZeitpunkt(new \DateTime());
				
				if(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser())
					$protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
				
                $this->protokolleRepository->add($protokolle);
            }
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }
		
		//die;
		
	}
	

    public function maintenanceCheckForWartungsvertraegeRechnungenMehraufwandZeitraeumeStatus()
    {
		$this->initVars();
        //neue Rechnungen für Zeiträume erstellen
        if ($rechnungen = $this->wartungsvertraegeRechnungenRepository->findForMehraufwandNewStatusFaellig()) {
            //			echo $zeitraeume;
            //echo "<hr><br>anzahl rechnungen:".count($rechnungen);
            foreach ($rechnungen as $rechnung) {
                //                	echo "<hr>";
                //        echo "<br>uid: ".$rechnung->getUid();
                //			echo "<br>mehraufwandMinuten: ".$rechnung->getZeitraum()->getMehraufwandMinuten();
                $zeitraum = $rechnung->getZeitraum();
                if ($rechnung->getZeitraum()->getMehraufwandMinuten()) {
                    $zeitraum->setStatus(20);
                } else {
                    $zeitraum->setStatus(30);
                }
               
                $this->wartungsvertraegeZeitraeumeRepository->update($zeitraum);
                $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                $protokolle->setPid(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('protokollePid'));
                $protokolle->setAktion(80);
                $protokolle->setNotizSystem('system wartungsvertrag zeitraum status von setzen je nach mehraufwand auf ' . $zeitraum->getStatus() . ' uid:' . $zeitraum->getUid());
                $protokolle->setZeitpunkt(new \DateTime());
				if(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser())
                	$protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                $this->protokolleRepository->add($protokolle);
            }
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }
        
    }
    
 	public function maintenanceDateienTempFields()
    {
		$this->initVars();
		
        //neue Rechnungen für Zeiträume erstellen
        $dateiens = $this->dateienRepository->findForRefresh();
		
		
        foreach ($dateiens as $datei) {
			/*echo ":";
			echo $datei;
			echo $datei->getUid();
			echo ";";
			die;*/
            //$datei->setTempTimestamp(time());
			if($datei->getTitel()){
				$datei->setTitel($datei->getTitel());//aufruf um interne aktualisierung zu starten
            }
			$this->dateienRepository->update($datei);
        }
        if (count($dateiens)) $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
		
        
    }


}