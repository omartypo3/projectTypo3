<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * Agenturvertraege
 */
class Agenturvertraege extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * auftraege
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $auftraege;

    /**
     * auftraegeJahr
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $auftraegeJahr;

    /**
     * stundenMonatlich
     *
     * @var float
     */
    protected $stundenMonatlich;

    /**
     * preisMonatlich
     *
     * @var float
     */
    protected $preisMonatlich;

    /**
     * beschreibung
     *
     * @var string
     */
    protected $beschreibung;

    /**
     * vertragsbegin
     *
     * @var \DateTime
     */
    protected $vertragsbegin;

    /**
     * vertragsende
     *
     * @var \DateTime
     */
    protected $vertragsende;

    /**
     * vertrag
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $vertrag;

    /**
     * preisMehraufwandStunde
     *
     * @var float
     */
    protected $preisMehraufwandStunde;

    /**
     * kunde
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden
     */
    protected $kunde;

    /**
     * dateien
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $dateien;

    /**
     * Returns the stundenMonatlich
     * 
     * @return float $stundenMonatlich
     */
    public function getStundenMonatlich()
    {
        return $this->stundenMonatlich;
    }

    /**
     * Returns the stundenJaehrlich
     * 
     * @return float $stundenJaehrlich
     */
    public function getStundenJaehrlich()
    {
        return $this->stundenMonatlich*12;
    }
	
    /**
     * Sets the stundenMonatlich
     * 
     * @param float $stundenMonatlich
     * @return void
     */
    public function setStundenMonatlich($stundenMonatlich)
    {
        $this->stundenMonatlich = $stundenMonatlich;
    }

    /**
     * Returns the preisMonatlich
     * 
     * @return float $preisMonatlich
     */
    public function getPreisMonatlich()
    {
        return $this->preisMonatlich;
    }

    /**
     * Sets the preisMonatlich
     * 
     * @param float $preisMonatlich
     * @return void
     */
    public function setPreisMonatlich($preisMonatlich)
    {
        $this->preisMonatlich = $preisMonatlich;
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
     * Returns the vertragsbegin
     * 
     * @return \DateTime $vertragsbegin
     */
    public function getVertragsbegin()
    {
        return $this->vertragsbegin;
    }

    /**
     * Sets the vertragsbegin
     * 
     * @param \DateTime $vertragsbegin
     * @return void
     */
    public function setVertragsbegin(\DateTime $vertragsbegin)
    {
        //$this->vertragsbegin = $vertragsbegin;
        $vertragsbegin = new \DateTime('01.' . $vertragsbegin->format('m.Y'));
        $vertragsbegin->modify('+3 hours');
        $this->vertragsbegin = $vertragsbegin;
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
        return 'AV' . str_pad((string)$this->uid, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Returns the stundensatz
     * 
     * @return float $stundensatz
     */
    public function getStundensatz()
    {
        if (!$this->stundenMonatlich) {
            return 0;
        }
        return $this->preisMonatlich / $this->stundenMonatlich;
    }

    /**
     * Returns the kontingentJeMonat
     * 
     * @param $monat
     * @param $jahr
     * @return float $kontingentJeMonat
     */
    public function getKontingentJeMonat($monat = NULL, $jahr = NULL)
    {
        if ($monat !== NULL && $jahr !== NULL) {
            if (!$this->checkValidMonat($monat, $jahr)) {
                return 0;
            }
        }
        return $this->stundenMonatlich * 60;
    }

    /**
     * Returns the kontingent
     * 
     * @return float $kontingent
     */
    public function getKontingent()
    {
        //für gewählten zeitraum
        return $this->getKontingentJeMonat() * $this->getMonate();
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
        $kontingentUsed = $this->getKontingentHandling();
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
        $kontingentUsed = 0;
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
        $kontingentUsed = $this->getKontingentHandling();
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
        $kontingentUsed = $this->getKontingentHandlingJahr();
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
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        $diagrammArr = array('monat' => array(), 'diagrammMax' => 0, 'max' => 0, 'avg' => 0, 'jahr' => $settings['statJahr']);
        for ($monat = 1; $monat <= 12; $monat++) {
            $diagrammArr['monat'][$monat] = array(
                'kontingentJeMonat' => $this->getKontingentJeMonat($monat, $settings['statJahr']),
                'kontingentHandlingJeMonat' => $this->getKontingentHandlingJeMonat($monat, $settings['statJahr']),//achtung nur vergangene monate
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

        if(count($kontingentArr) > 0){
            $diagrammArr['avg'] = array_sum($kontingentArr) / count($kontingentArr);
        }else{
            $diagrammArr['avg'] = array_sum($kontingentArr);
        }
        //print_r($kontingentArr);
        foreach ($diagrammArr['monat'] as $monat => $v) {
            if ($v['kontingentJeMonat']) {
                $diagrammArr['monat'][$monat]['avg'] = $diagrammArr['avg'];
            }
        }
        //$diagrammArr["max"]+=ceil($diagrammArr["max"]*0.1);//10% luft für skale ergänzen
        //$diagrammArr["diagrammMax"]=(floor($diagrammArr["max"]/60)*60);//10% luft für skale ergänzen
        $diagrammArr['diagrammStepSize'] = ceil($diagrammArr['max'] / 10 / 60) * 60;
        if($diagrammArr['diagrammStepSize'] > 0) {
            $diagrammArr['diagrammMax'] = ceil($diagrammArr['max'] / $diagrammArr['diagrammStepSize']) * $diagrammArr['diagrammStepSize'] + $diagrammArr['diagrammStepSize'];
        }else{
            $diagrammArr['diagrammMax'] = ceil($diagrammArr['max']) * $diagrammArr['diagrammStepSize'] + $diagrammArr['diagrammStepSize'];
        }
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
        $kontingentUsed = $this->getKontingentHandlingJahr();
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
     * Returns the Kontingent HandlingJeMonat
     * 
     * @param $monat
     * @param $jahr
     * @return integer $kontingentHandlingJeMonat
     */
    public function getKontingentHandlingJeMonat($monat = NULL, $jahr = NULL)
    {
        //	echo 'getKontingentHandlingJeMonat';
        //	echo $monat;
        //	echo $jahr;
		//if($jahr==2019) return 0;
        if ($monat !== NULL && $jahr !== NULL) {
            if (!$this->checkValidMonat($monat, $jahr)) {
                return 0;
            }
        }
		//if($monat>6)  return 0;
        return ceil($this->getStundenMonatlich() * 60 * 0.15);
    }

    /**
     * @param $monat
     * @param $jahr
     */
    private function checkValidMonat($monat, $jahr)
    {
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
     * Returns the Kontingent Handling
     * 
     * @return integer $kontingentHandling
     */
    public function getKontingentHandling()
    {
        return $this->getMonate() * $this->getKontingentHandlingJeMonat();
    }

    /**
     * Returns the Kontingent Handling Statistuk Jahr
     * 
     * @return integer $kontingentHandling
     */
    public function getKontingentHandlingJahr()
    {
        return ceil($this->getMonateJahr() * ($this->getStundenMonatlich() * 60 * 0.15));
    }

    /**
     * Get Calc end Date
     * 
     * @param \DateTime $end
     * @return \DateTime $end
     */
    private function getEndDateForCalc(\DateTime $end)
    {
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
        //korrektur enddatum für ausgabe der monatsanzahl
        $now = new \DateTime();
        if ($this->getVertragsbegin() > $start) {
            $start = $this->getVertragsbegin();
        }
        return $start;
    }

    /**
     * Returns the Anzahl von Differenz Monaten
     * 
     * @return string $monate
     */
    public function getMonate()
    {
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
     * Returns the Anzahl von Differenz Monaten für die Jahresstatistik
     * 
     * @return string $monate
     */
    public function getMonateJahr()
    {
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        //print_r($settings);
        $start = $this->getStartDateForCalc(new \DateTime('01.01.' . $settings['statJahr']));
        //$start = new \DateTime('01.01.' . $settings['statJahr']);
        $end = $this->getEndDateForCalc(new \DateTime('31.12.' . $settings['statJahr']));
        //echo $start->format('d.m.Y');
        //echo "-";
        //echo $end->format('d.m.Y');
        //die;
        if ($this->getVertragsende()) {
            if ($end > $this->getVertragsende()) {
                $end = $this->getVertragsende();
            }
        }
        if ($end < $start) {
            return 0;
        }
        $diff = $start->diff($end);
        //echo $diff;
        //die;
        //if(!$diff) return 1;
        $monate = $diff->y * 12 + $diff->m;
        if ($diff->d) {
            $monate++;
        }
        //if(!$monate) return 1;
        return $monate;
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
            $this->auftraege = $auftraegeRepository->findAuftraegeByAgenturvertrag($this);
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
     * Returns the vertragsende
     * 
     * @return \DateTime $vertragsende
     */
    public function getVertragsende()
    {
        return $this->vertragsende;
    }

    /**
     * Sets the vertragsende
     * 
     * @param \DateTime $vertragsende
     * @return void
     */
    public function setVertragsende(\DateTime $vertragsende)
    {
        if ($vertragsende) {
            $vertragsende = new \DateTime('01.' . $vertragsende->format('m.Y'));
            $vertragsende = date_add($vertragsende, date_interval_create_from_date_string('1 month'));
            $vertragsende = date_sub($vertragsende, date_interval_create_from_date_string('1 day'));
        }
        if (!$vertragsende) {
            $this->vertragsende = NULL;
        } else {
            // $this->vertragsende =   new \DateTime("02.10.2017");
            $vertragsende->modify('+3 hours');
            $this->vertragsende = $vertragsende;
        }
    }

    /**
     * Clear the vertragsende
     * 
     * @return void
     */
    public function clearVertragsende()
    {
        $this->vertragsende = NULL;
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
    public function setVertrag(\TYPO3\CMS\Extbase\Domain\Model\FileReference $vertrag)
    {
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
}
