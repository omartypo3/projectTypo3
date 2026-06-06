<?php
namespace DslFactory\DslIntranet\Domain\Model;

/***
 *
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * Projekte
 */
class Projekte extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * auftraege
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $auftraege = NULL;

    /**
     * auftraegeJahr
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
	/*
    protected $auftraegeJahr = NULL;
*/
	

	
	    /**
     * titel
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $titel = '';

	
    /**
     * stunden
     * 
     * @var float
     */
    protected $stunden = 0.0;

    /**
     * preis
     * 
     * @var float
     */
    protected $preis = 0.0;

    /**
     * beschreibung
     * 
     * @var string
     */
    protected $beschreibung = '';

    /**
     * projektbegin
     * 
     * @var \DateTime
     */
    protected $projektbegin = null;

    /**
     * projektende
     * 
     * @var \DateTime
     */
    protected $projektende = null;

    /**
     * vertrag
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $vertrag = null;

    /**
     * preisMehraufwandStunde
     * 
     * @var float
     */
    protected $preisMehraufwandStunde = 0.0;

    /**
     * kunde
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $kunde = null;

    /**
     * dateien
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $dateien = null;

    /**
     * abgeschlossen
     *
     * @var bool
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $abgeschlossen = false;	
	
	   /**
     * Returns the titel
     * 
     * @return string $titel
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Sets the titel
     * 
     * @param string $titel
     * @return void
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }
	
    /**
     * Returns the stunden
     * 
     * @return float $stunden
     */
    public function getStunden()
    {
        return $this->stunden;
    }

   
	
    /**
     * Sets the stunden
     * 
     * @param float $stunden
     * @return void
     */
    public function setStunden($stunden)
    {
        $this->stunden = $stunden;
    }

    /**
     * Returns the preis
     * 
     * @return float $preis
     */
    public function getPreis()
    {
        return $this->preis;
    }

    /**
     * Sets the preis
     * 
     * @param float $preis
     * @return void
     */
    public function setPreis($preis)
    {
        $this->preis = $preis;
    }

    /**
     * Returns the beschreibung
     * 
     * @return string $beschreibung
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }

    /**
     * Sets the beschreibung
     * 
     * @param string $beschreibung
     * @return void
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

	/**
	 * Returns the projektbegin
	 * 
	 * @return \DateTime $projektbegin
	 */
	public function getProjektbegin()
	{
		return $this->projektbegin;
	}
	
/**
 * Returns the projektende
 * 
 * @return \DateTime $projektende
 */
public function getVertragsende()
{
	return $this->projektende;
}
	

/**
 * Returns the vertragsbegin
 * 
 * @return \DateTime $vertragsbegin
 */
public function getVertragsbegin()
{
	return $this->projektbegin;
}

	
    /**
     * Sets the projektbegin
     * 
     * @param \DateTime $projektbegin
     * @return void
     */
    public function setProjektbegin(\DateTime $projektbegin)
    {
        //$this->vertragsbegin = $vertragsbegin;
        $projektbegin = new \DateTime('01.' . $projektbegin->format('m.Y'));
        $projektbegin->modify('+3 hours');
        $this->projektbegin = $projektbegin;
    }

    /**
     * Returns the kunde
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Kunden $kunde
     */
    public function getKunde()
    {
        return $this->kunde;
    }

    /**
     * Sets the kunde
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunde
     * @return void
     */
    public function setKunde(\DslFactory\DslIntranet\Domain\Model\Kunden $kunde)
    {
        $this->kunde = $kunde;
    }

    /**
     * Returns the nr
     * 
     * @return string $nr
     */
    public function getNr()
    {
        if (!$this->uid) {
            return '';
        }
        return 'P' . str_pad((string)$this->uid, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Returns the stundensatz
     * 
     * @return float $stundensatz
     */
    public function getStundensatz()
    {
        if (!$this->stunden) {
            return 0;
        }
        return $this->preis / $this->stunden;
    }


    /**
     * Returns the kontingent
     * 
     * @return float $kontingent
     */
    public function getKontingent()
    {
        //für gewählten zeitraum
        return $this->getStunden() * 60;
    }

    /**
     * Returns the kontingent für Statistik Jahr
     * 
     * @return float $kontingent
     */
    public function getKontingentJahr()
    {
        

        return $this->getKontingentJeMonat() * $this->getMonateJahr();
    }

    /**
     * Returns the Sum of zeiten Kontingent
     * 
     * @return integer $kontingentUsed
     */
    public function getKontingentUsed()
    {
        //return 9999;
        $kontingentUsed = 0;
        //return $kontingentUsed;
        //$kontingentUsed=0;
        $auftraege = $this->getAuftraege();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                if ($auftrag->getFestpreisGrundlageAgenturvertrag()) {
                    if ($this->getStundensatz()) {
                        $kontingentUsed += ceil($auftrag->getFestpreisGrundlageAgenturvertrag() / $this->getStundensatz() * 60);
                    }
                } else {
                    $kontingentUsed += $auftrag->getKontingentUsed();
                }
            }
        }
        return $kontingentUsed;
    }

    /**
     * Returns the Sum of zeiten Kontingent
     * 
     * @return integer $kontingentUsed
     */
    public function getKontingentUsedSchwebend()
    {
        //$kontingentUsed = $this->getKontingentHandling();
        $auftraege = $this->getAuftraege();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                if ($auftrag->getStatus() != 70) {
                    //			echo "<br>".$auftrag->getUid().":";
                    if ($auftrag->getFestpreisGrundlageAgenturvertrag()) {
                        if ($this->getStundensatz()) {
                            //					echo ceil($auftrag->getFestpreis() / $this->getStundensatz() * 60);
                            $kontingentUsed += ceil($auftrag->getFestpreisGrundlageAgenturvertrag() / $this->getStundensatz() * 60);
                        }
                    } else {
                        //				echo $auftrag->getKontingentUsed();
                        $kontingentUsed += $auftrag->getKontingentUsed();
                    }
                }
            }
        }
        //echo "<br> - gesamt:".$kontingentUsed;
        //die;
        return $kontingentUsed;
    }

    /**
     * Returns the Sum of zeiten Kontingent
     * 
     * @return integer $kontingentUsed
     */
    public function getKontingentUsedAbgeschlossen()
    {
		
        //return 9999;
        $kontingentUsed = 0;
        //return $kontingentUsed;
        //$kontingentUsed=0;
        $auftraege = $this->getAuftraege();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                if ($auftrag->getStatus() == 70) {
                    if ($auftrag->getFestpreisGrundlageAgenturvertrag()) {
                        if ($this->getStundensatz()) {
                            $kontingentUsed += ceil($auftrag->getFestpreisGrundlageAgenturvertrag() / $this->getStundensatz() * 60);
                        }
                    } else {
                        $kontingentUsed += $auftrag->getKontingentUsed();
                    }
                }
            }
        }
        return $kontingentUsed;
    }

    /**
     * Returns the Sum of zeiten Kontingent für Statistik Jahr
     * 
     * @return integer $kontingentUsed
     */
    public function getKontingentUsedJahr()
    {
        //return 9999;
        $kontingentUsed = 0;//$this->getKontingentHandlingJahr();
        //return $kontingentUsed;
        //$kontingentUsed=0;
        $auftraege = $this->getAuftraegeJahr();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                if ($auftrag->getFestpreisGrundlageAgenturvertrag()) {
                    if ($this->getStundensatz()) {
                        $kontingentUsed += ceil($auftrag->getFestpreisGrundlageAgenturvertrag() / $this->getStundensatz() * 60);
                    }
                } else {
                    $kontingentUsed += $auftrag->getKontingentUsed();
                }
            }
        }
        return $kontingentUsed;
    }

    /**
     * Returns the Sum of zeiten Kontingent für Statistik Jahr
     * 
     * @return integer $kontingentUsed
     */
    public function getKontingentJahrDiagramm()
    {
		return 0;
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        $diagrammArr = array('monat' => array(), 'diagrammMax' => 0, 'max' => 0, 'avg' => 0, 'jahr' => $settings['statJahr']);
        for ($monat = 1; $monat <= 12; $monat++) {
            $diagrammArr['monat'][$monat] = array(
                'kontingentJeMonat' => $this->getKontingentJeMonat($monat, $settings['statJahr']),
               // 'kontingentHandlingJeMonat' => $this->getKontingentHandlingJeMonat($monat, $settings['statJahr']),//achtung nur vergangene monate
                'kontingentAbgeschlossen' => 0,
                'kontingentSchwebend' => 0,
                'kontingentAbgeschlossenUeberMax' => 0,
                'kontingentSchwebendUeberMax' => 0,
                'kontingentUeberGesamt' => 0,
                'avg' => 0
            );
			
			/*$handling = 0;
			if($monat<10) $handling = $this->getKontingentHandlingJeMonat($monat, $settings['statJahr']);
			$diagrammArr['monat'][$monat]['kontingentHandlingJeMonat'] = $handling;*/
			
        }
        $auftraege = $this->getAuftraegeJahr();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                $monat = $auftrag->getDatumAbschluss()->format('n');
                if ($auftrag->getFestpreisGrundlageAgenturvertrag()) {
                    if ($this->getStundensatz()) {
                        $kontingentUsed = ceil($auftrag->getFestpreisGrundlageAgenturvertrag() / $this->getStundensatz() * 60);
                    }
                } else {
                    $kontingentUsed = $auftrag->getKontingentUsed();
                }
                if ($auftrag->getStatus() == 70) {
                    //abgeschlossen
                    $diagrammArr['monat'][$monat]['kontingentAbgeschlossen'] += $kontingentUsed;
                } else {
                    //schwebend
                    $diagrammArr['monat'][$monat]['kontingentSchwebend'] += $kontingentUsed;
                }
            }
        }
        $kontingentArr = array();
        foreach ($diagrammArr['monat'] as $monat => $v) {
			//$handling = 0;
			//if($monat<10) $handling = $v['kontingentHandlingJeMonat'];
			
			//$diagrammArr['monat'][$monat]['kontingentHandlingJeMonat'] = $handling;
			
            $max = $diagrammArr['monat'][$monat]['kontingent'] = $v['kontingentHandlingJeMonat'] + $v['kontingentAbgeschlossen'] + $v['kontingentSchwebend'];
            if ($max) {
                $kontingentArr[] = $max;
            }
            //$max = $diagrammArr["monat"][$monat]["kontingent"];
            //$kontingentArr[]=$max;
            if ($v['kontingentJeMonat'] > $max) {
                $max = $v['kontingentJeMonat'];
            }
            if ($max > $diagrammArr['max']) {
                $diagrammArr['max'] = $max;
            }
        }
        $diagrammArr['avg'] = array_sum($kontingentArr) / count($kontingentArr);
        //print_r($kontingentArr);
        foreach ($diagrammArr['monat'] as $monat => $v) {
            if ($v['kontingentJeMonat']) {
                $diagrammArr['monat'][$monat]['avg'] = $diagrammArr['avg'];
            }
        }
        //$diagrammArr["max"]+=ceil($diagrammArr["max"]*0.1);//10% luft für skale ergänzen
        //$diagrammArr["diagrammMax"]=(floor($diagrammArr["max"]/60)*60);//10% luft für skale ergänzen
        $diagrammArr['diagrammStepSize'] = ceil($diagrammArr['max'] / 10 / 60) * 60;
        $diagrammArr['diagrammMax'] = ceil($diagrammArr['max'] / $diagrammArr['diagrammStepSize']) * $diagrammArr['diagrammStepSize'] + $diagrammArr['diagrammStepSize'];
        if (!$diagrammArr['diagrammStepSize'] && !$diagrammArr['diagrammMax']) {
            $diagrammArr['diagrammStepSize'] = 60;
            $diagrammArr['diagrammMax'] = 120;
        }
        //2460 / 10 => 246
        // 246/60 => 4,1 => 5
        // 5*60 => 300
        //print_r($diagrammArr);die;
        foreach ($diagrammArr['monat'] as $monat => $v) {
            $minuten = $v['kontingentAbgeschlossen'] + $v['kontingentSchwebend'] + $v['kontingentHandlingJeMonat'];
            if (intval($v['kontingent']) > intval($v['kontingentJeMonat'])) {
                $minutenUeberMax = intval($v['kontingent']) - intval($v['kontingentJeMonat']);
                //vom schwebenden abziehen
                if ($minutenSchwebend = intval($v['kontingentSchwebend'])) {
                    if ($minutenSchwebend >= $minutenUeberMax) {
                        $diagrammArr['monat'][$monat]['kontingentSchwebendUeberMax'] = $minutenUeberMax;
                        $diagrammArr['monat'][$monat]['kontingentSchwebend'] = $minutenSchwebend - $minutenUeberMax;
                    } else {
                        $diagrammArr['monat'][$monat]['kontingentSchwebendUeberMax'] = $minutenSchwebend;
                        $diagrammArr['monat'][$monat]['kontingentSchwebend'] = 0;
                        $minutenUeberMax -= $minutenSchwebend;
                    }
                }
                //vom abgeschlossenen abziehen
                if ($minutenAbgeschlossen = intval($v['kontingentAbgeschlossen'])) {
                    $diagrammArr['monat'][$monat]['kontingentAbgeschlossenUeberMax'] = $minutenUeberMax;
                    $diagrammArr['monat'][$monat]['kontingentAbgeschlossen'] = $minutenAbgeschlossen - $minutenUeberMax;
                }
            }
            $diagrammArr['monat'][$monat]['kontingentUeberGesamt'] = $diagrammArr['monat'][$monat]['kontingentSchwebendUeberMax'] + $diagrammArr['monat'][$monat]['kontingentAbgeschlossenUeberMax'];
        }
        return $diagrammArr;
        //print_r($diagrammArr);
        //die;
        //return 9999;
        $kontingentUsed = 0;
        //return $kontingentUsed;
        //$kontingentUsed=0;
        $auftraege = $this->getAuftraegeJahr();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                if ($auftrag->getFestpreisGrundlageAgenturvertrag()) {
                    if ($this->getStundensatz()) {
                        $kontingentUsed += ceil($auftrag->getFestpreisGrundlageAgenturvertrag() / $this->getStundensatz() * 60);
                    }
                } else {
                    $kontingentUsed += $auftrag->getKontingentUsed();
                }
            }
        }
        return $kontingentUsed;
    }


    /**
     * @param $monat
     * @param $jahr
     */
    private function checkValidMonat($monat, $jahr)
    {
		die;
        $pruefDatum = new \DateTime($jahr . '-' . $monat . '-01');
        //echo "<br>pruefDatum!".$pruefDatum->format("d.m.Y");
        //echo "<br>getVertragsBegin!".$this->getVertragsBegin()->format("d.m.Y");
        if ($pruefDatum->format('Ym') < $this->getVertragsBegin()->format('Ym')) {
            return false;
        }
        if ($this->getVertragsEnde()) {
            if ($pruefDatum->format('Ym') > $this->getVertragsEnde()->format('Ym')) {
                return false;
            }
        }
		//neudsl09012019
		$heute = new \DateTime();
		if($pruefDatum->format('Ym')>$heute->format('Ym')) return false;
        return true;
    }





    /**
     * Get Calc end Date
     * 
     * @param \DateTime $end
     * @return \DateTime $end
     */
    private function getEndDateForCalc(\DateTime $end)
    {
		die;
        //korrektur enddatum für ausgabe der monatsanzahl
        $now = new \DateTime();
        if ($now->format('Y') < $end->format('Y')) {
            //if ($now->format('Ym') < $end->format('Ym')) {
            //			echo "now ist kleiner als end";
            $tmpEnd = new \DateTime('01.' . $end->format('m.Y'));
            //			echo "<br>tmpEnd:".$tmpEnd->format("d.m.Y");
            while ($now->format('Ym') < $tmpEnd->format('Ym')) {
                $tmpEnd = date_sub($tmpEnd, date_interval_create_from_date_string('1 month'));
            }
            $tmpEnd = date_add($tmpEnd, date_interval_create_from_date_string('1 month'));
            $end = date_sub($tmpEnd, date_interval_create_from_date_string('1 day'));
        }
        /*		
                if (intval($end->format('m')) > intval($now->format('m'))) {
                    $newMonth = intval($now->format('m')) + 1;
                    $newYear = intval($now->format('Y'));
                    if ($newMonth > 12) {
                        $newMonth -= 12;
                        $newYear += 1;
                    }
                    $end = new \DateTime('01.' . $newMonth . '.' . $newYear);
                    $end = date_sub($end, date_interval_create_from_date_string('1 day'));
                }
        */

        if ($this->getVertragsende() && $this->getVertragsende() < $end) {
            $end = $this->getVertragsende();
        }
		
		//neudsl09012019
		$heute = new \DateTime();
		if($heute<$end) {
			$end = new \DateTime("01.".$heute->format('m').".".$heute->format('Y'));
			$end = date_add($end, date_interval_create_from_date_string('1 month'));
			$end = date_sub($end, date_interval_create_from_date_string('1 day'));
		}
		
        return $end;
    }

    /**
     * Get Calc end Date
     * 
     * @param \DateTime $start
     * @return \DateTime $start
     */
    private function getStartDateForCalc(\DateTime $start)
    {
		die;
        //korrektur enddatum für ausgabe der monatsanzahl
        $now = new \DateTime();
        if ($this->getVertragsbegin() > $start) {
            $start = $this->getVertragsbegin();
        }
        return $start;
    }

 
	

	public function getStatistikDaten()
    {
	
		
		$aktivitaetenArr = array(
		
			"diagrammMax"=>1080,
			"max"=>862,
			"avg"=>420.0833333333333,
			//"jahr"=>$filterZeitraum["datevar"]->format('Y'),
			"titel"=>"Verbrauchte Zeit nach Monaten",
			"diagrammStepSize"=>60
			
		);
		
		
		$aktivitaetenArr['data'] = (object) array(
			'range' => array(),
			'labels' => array(),//'Ma1', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'
			'datasets' => array(
				0 => (object) array(
					'type'=>'bar',
					'label'=>'verbrauchte Zeit',
					'backgroundColor'=>'rgba(20, 203, 150,0.8)',//grey
					'borderColor'=>'rgb(20, 203, 150)',//red
					'borderWidth'=>1,
					'stack'=>1,
					'data'=>[
						//10,20,130,40,50,60,70,80,90,100,110,120
					]
				),
				1 => (object) array(
					'type'=>'bar',
					'label'=>'verbrauchte Zeit (außerhalb des Projektzeitraum)',
					'backgroundColor'=>'rgba(255, 0, 0,0.8)',//grey
					'borderColor'=>'rgb(255, 0, 0)',//red
					'borderWidth'=>1,
					'stack'=>1,
					'data'=>[
						//10,20,130,40,50,60,70,80,90,100,110,120
					]
				)
			)
		);
		
		// -------------------------------------------- 
		
		
		//var_dump($monatArr);


		
		$monatArr=$this->getMonate();
			
		
		$auftraege = $monatArr["auftraege"];
		//$auftraege = $this->getAuftraege();

		// echo count($auftraege);
		// echo $auftraege{0}->getUid();
		// echo $auftraege{count($auftraege)-1}->getUid();

		
		
		
		
		
		//monate ermitteln!!
		$datum = clone $monatArr["begin"];
		while($datum <= $monatArr["projektende"]){
			
			
			if($datum<$monatArr["projektbegin"] || $datum>$monatArr['projektende']){//außerhalb!!
				$monatArr["monateAusserhalb"][$datum->format("d.m.Y")] = 0;
			}
//			if($datum>$ende){//außerhalb!!
//				$monatArr["monateAusserhalb"][$datum->format("d.m.Y")] = 0;
//			} 
			
			$monatArr["monate"][$datum->format("d.m.Y")] = 0;
			$datum->add(new \DateInterval('P1M'));
			
			
			
		}

		foreach($auftraege as $auftrag){
			/*echo $auftrag->getUid();
			echo ": ".$auftrag->getDatumabschluss()->format("Y-m-d");
			echo "-- <br>";*/

			if ($auftrag->getFestpreisGrundlageAgenturvertrag()) {
				if ($this->getStundensatz()) {
					$kontingentUsed = ceil($auftrag->getFestpreisGrundlageAgenturvertrag() / $this->getStundensatz() * 60);
				}
			} else {
				$kontingentUsed = $auftrag->getKontingentUsed();
			}
			//var_dump($kontingentUsed);
			$datumAbschluss = new \DateTime( $auftrag->getDatumabschluss()->format("Y-m")."-01" );
			$monatArr["monate"][$datumAbschluss->format("d.m.Y")]+=$kontingentUsed;
			
			if($datumAbschluss<$monatArr["projektbegin"] || $datumAbschluss>$monatArr["projektende"]){
				//mikehome
				$monatArr["monateAusserhalb"][$datumAbschluss->format("d.m.Y")]+=$kontingentUsed;
			}
			
			
			

		}
	
		
		
		foreach($monatArr["monate"] as $label => $kontingent ){
			$monat = new \DateTime($label);
			$aktivitaetenArr['data']->labels[] = strftime('%b %Y',$monat->getTimestamp());
			//$aktivitaetenArr['data']->labels[] = $label;
			
			if(isset($monatArr["monateAusserhalb"][$label])){
				$aktivitaetenArr['data']->datasets[0]->data[] = 0;
			} else {
				$aktivitaetenArr['data']->datasets[0]->data[] = $kontingent;
			}
			
			
			//$aktivitaetenArr['data']->datasets[1]->data[] = $kontingent;
		}
		
		foreach($monatArr["monate"] as $label => $kontingent ){
			
			if(isset($monatArr["monateAusserhalb"][$label])){
				$aktivitaetenArr['data']->datasets[1]->data[] = $monatArr["monateAusserhalb"][$label];	
			} else {
				$aktivitaetenArr['data']->datasets[1]->data[] = 0;
			}
		}

        if (!empty($monatArr["monate"])) {
            $aktivitaetenArr["diagrammMax"] = (ceil(max($monatArr["monate"]) / 60) + 1) * 60;
        }else {
            // Set a default value when the array is empty
            $aktivitaetenArr["diagrammMax"] = 60; // or whatever default makes sense
        }
		$aktivitaetenArr["monatArr"] = $monatArr;
		return $aktivitaetenArr;
		return $monatArr;
		
	}

    /**
     * Returns the Jahr fuer die Statistik
     * 
     * @return string $jahr
     */
    public function getStatistikJahr()
    {
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        //$settings['statJahr'];die;
        //return 2017;
        return $settings['statJahr'];
    }

    /**
     * Returns the auftraege
     * 
     * @param $reload
     */
    public function getAuftraege($reload = false)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        if ($this->auftraege === NULL || $reload) {
            $this->auftraege = $auftraegeRepository->findAuftraegeByProjekt($this);
        }
        return $this->auftraege;
    }

    /**
     * Returns the auftraege
     * 
     * @param $reload
     */
    public function getAuftraegeJahr($reload = false)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        if ($this->auftraegeJahr === NULL || $reload) {
            $this->auftraegeJahr = $auftraegeRepository->findAuftraegeByAgenturvertragJahr($this);
        }
        return $this->auftraegeJahr;
    }

    /**
     * Returns the projektende
     * 
     * @return \DateTime projektende
     */
    public function getProjektende()
    {
        return $this->projektende;
    }

    /**
     * Sets the projektende
     * 
     * @param \DateTime $projektende
     * @return void
     */
    public function setProjektende(\DateTime $projektende)
    {
        if ($projektende) {
            $projektende = new \DateTime('01.' . $projektende->format('m.Y'));
            $projektende = date_add($projektende, date_interval_create_from_date_string('1 month'));
            $projektende = date_sub($projektende, date_interval_create_from_date_string('1 day'));
        }
        if (!$projektende) {
            $this->projektende = NULL;
        } else {
            // $this->vertragsende =   new \DateTime("02.10.2017");
            $projektende->modify('+3 hours');
            $this->projektende = $projektende;
        }
    }

    /**
     * Clear the projektende
     * 
     * @return void
     */
    public function clearProjektende()
    {
        $this->projektende = NULL;
    }

    /**
     * Returns the vertrag
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $vertrag
     */
    public function getVertrag()
    {
        return $this->vertrag;
    }

    /**
     * Sets the vertrag
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $vertrag
     * @return void
     */
    public function setVertrag(\TYPO3\CMS\Extbase\Domain\Model\FileReference $vertrag)// = NULL
    {
		     /** @ignorevalidation $vertrag	 */
		//echo "hää";
		
        if ($this->vertrag) {
            if ($this->vertrag->getOriginalResource()) {
                if ($fileToDelete = $this->vertrag->getOriginalResource()->getOriginalFile()) {
                    $fileToDelete->getStorage()->deleteFile($fileToDelete);
                }
            }
        }
        $this->vertrag = $vertrag;
    }

    /**
     * Clear the vertrag
     * 
     * @return void
     */
    public function clearVertrag()
    {
        if ($this->vertrag) {
            if ($this->vertrag->getOriginalResource()) {
                if ($fileToDelete = $this->vertrag->getOriginalResource()->getOriginalFile()) {
                    $fileToDelete->getStorage()->deleteFile($fileToDelete);
                }
            }
        }
        $this->vertrag = NULL;
    }

    /**
     * Returns the preisMehraufwandStunde
     * 
     * @return float $preisMehraufwandStunde
     */
    public function getPreisMehraufwandStunde()
    {
        return $this->preisMehraufwandStunde;
    }

    /**
     * Sets the preisMehraufwandStunde
     * 
     * @param float $preisMehraufwandStunde
     * @return void
     */
    public function setPreisMehraufwandStunde($preisMehraufwandStunde)
    {
        $this->preisMehraufwandStunde = $preisMehraufwandStunde;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->dateien = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Dateien
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     * @return void
     */
    public function addDateien(\DslFactory\DslIntranet\Domain\Model\Dateien $dateien)
    {
        $this->dateien->attach($dateien);
    }

    /**
     * Removes a Dateien
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateienToRemove The Dateien to be removed
     * @return void
     */
    public function removeDateien(\DslFactory\DslIntranet\Domain\Model\Dateien $dateienToRemove)
    {
        $this->dateien->detach($dateienToRemove);
    }

    /**
     * Returns the dateien
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien> $dateien
     */
    public function getDateien()
    {
        return $this->dateien;
    }

    /**
     * Sets the dateien
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien> $dateien
     * @return void
     */
    public function setDateien(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dateien)
    {
        $this->dateien = $dateien;
    }
	
	    /**
     * Returns the Anzahl von Differenz Monaten
     * 
     * @return array $monate
     */
    public function getMonate()
    {
		/*
		$monatArr = [
			"projektbegin"=>new \DateTime("01.".$this->getProjektbegin()->format('m.Y')),
			"projektende"=>new \DateTime("01.".$this->getProjektende()->format('m.Y')),
		];
		foreach($this->getAuftraege() as $auftrag){
			
		}
		print_r($monatArr);die;
		
		*/
		
		
		$today = new \DateTime();
		$begin = new \DateTime( $this->getProjektbegin()->format("Y-m")."-01" );
		if($this->getProjektende()) $ende = new \DateTime( $this->getProjektende()->format("Y-m")."-01" ); else $ende = new \DateTime($today->format("Y-m")."-01");
		//$begin = \DateTime($projekt->getProjektbegin()->format("Y-m")."-01");

		$auftraege = $this->getAuftraege();
			
		$monatArr = array(
			"projektbegin"=>$begin,
			"projektende"=>$ende,
			"begin"=>$begin,
			"ende"=>$ende,
			"monate"=>array(),
			"monateAusserhalb"=>array(),
			"auftraege"=>$auftraege
		);
		
		
		
		
		if(count($auftraege)){
		
			//ältester auftrag
			$datumAbschluss = new \DateTime( $auftraege{0}->getDatumabschluss()->format("Y-m")."-01" );
			if($datumAbschluss<$monatArr["begin"]) $monatArr["begin"] = $datumAbschluss;

			//neuester/letzter auftrag
			$datumAbschluss = new \DateTime( $auftraege{count($auftraege)-1}->getDatumabschluss()->format("Y-m")."-01" );
			if($datumAbschluss>$monatArr["ende"]) $monatArr["ende"] = $datumAbschluss;
		}
		
		return $monatArr;
		
		return 9;
		
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        $start = $this->getStartDateForCalc(new \DateTime($settings['start']));
        $end = $this->getEndDateForCalc(new \DateTime($settings['end']));
		
       /* echo $start->format("d.m.Y");
		echo ":";
        echo $end->format("d.m.Y");
		die;*/
		
        //	die;
        if ($end < $start) {
            return false;
        }
        $diff = $start->diff($end);
        //if(!$diff) return 1;
        $monate = $diff->y * 12 + $diff->m;
        if ($diff->d) {
            $monate++;
        }
		
		//$heute = new \DateTime();
		//if($pruefDatum->format('Ym')>$heute->format('Ym')) return false;
		
        //if(!$monate) return 1;
        return $monate;
    }
	

        /**
     * Returns the abgeschlossen
     *
     * @return bool $abgeschlossen
     */
    public function getAbgeschlossen()
    {
        return $this->abgeschlossen;
    }

    /**
     * Sets the abgeschlossen
     *
     * @param bool $abgeschlossen
     * @return void
     */
    public function setAbgeschlossen($abgeschlossen)
    {
        $this->abgeschlossen = $abgeschlossen;
    }

    /**
     * Returns the boolean state of abgeschlossen
     *
     * @return bool
     */
    public function isAbgeschlossen()
    {
        return $this->abgeschlossen;
    }


}
