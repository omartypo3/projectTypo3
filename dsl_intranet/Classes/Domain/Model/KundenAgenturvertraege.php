<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * KundenAgenturvertraege
 */
class KundenAgenturvertraege extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	 /**
     * kunde
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden
     */
    protected $kunde;

    /**
     * auftraege
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $auftraege;

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
     * month
     * 
     * @var \DateTime
     */
    protected $month;

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
     * vertrag
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $vertrag;

    /**
     * preisMehraufwandStunde
     * 
     * @var float
     */
    protected $preisMehraufwandStunde;

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
     * Returns the beschreibung
     * 
     * @return string $beschreibung
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
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
     * Returns the vertragsende
     * 
     * @return \DateTime $vertragsende
     */
    public function getVertragsende()
    {
        return $this->vertragsende;
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
     * Returns the stundenMonatlich
     * 
     * @return float $stundenMonatlich
     */
    public function getStundenMonatlich()
    {
        return $this->stundenMonatlich;
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
     * Returns the month
     * 
     * @return \DateTime $month
     */
    public function getMonth()
    {
        //	$logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        if (!$this->month) {
            //		$logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, print_r(array("getMonth nicht gesetzt:" ), 1));
            $month = new \DateTime();
            $this->month = new \DateTime('01.' . $month->format('m.Y'));
        }
        // $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, print_r(array("getMonth:",$this->month->format('d.m.Y') ), 1));
        return $this->month;
    }

    /**
     * Sets the month
     * 
     * @param \DateTime $month
     * @return void
     */
    public function setMonth(\DateTime $month)
    {
        //$logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        //      $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, print_r(array("setMonth:",$month->format('d.m.Y') ), 1));
        /* if ($month) {
           $month = new \DateTime('01.' . $month->format('m.Y'));
           $vertragsende = date_add($vertragsende, date_interval_create_from_date_string('1 month'));
           $vertragsende = date_sub($vertragsende, date_interval_create_from_date_string('1 day'));
           }*/

        // $this->vertragsende =   new \DateTime("02.10.2017");
        //  $vertragsende->modify('+3 hours');
        $this->month = $month;
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
     * Returns the auftraege
     * 
     * @param $reload
     */
    public function getAuftraege($reload = false)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        if ($this->auftraege === NULL || $reload) {
            //$this->auftraege = $auftraegeRepository->findAuftraegeByKundenAgenturvertrag($this); //monatsauswertung
            $this->auftraege = $auftraegeRepository->findAuftraegeByKundenAgenturvertragJahr($this);
        }
        return $this->auftraege;
    }

    /**
     * Returns the Kontingent Handling
     * 
     * @return integer $kontingentHandling
     */
    public function getKontingentHandling()
    {
        return ceil($this->getMonate() * ($this->getStundenMonatlich() * 60 * 0.15));
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
     * Returns the auftraege
     * 
     * @param $reload
     */
    public function getAuftraegeJahr($reload = false)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        if ($this->auftraegeJahr === NULL || $reload) {
            $this->auftraegeJahr = $auftraegeRepository->findAuftraegeByKundenAgenturvertragJahr($this);
        }
        return $this->auftraegeJahr;
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
                if ($auftrag->getFestpreis()) {
                    if ($this->getStundensatz()) {
                        $kontingentUsed += ceil($auftrag->getFestpreis() / $this->getStundensatz() * 60);
                    }
                } else {
                    $kontingentUsed += $auftrag->getKontingentUsed();
                }
            }
        }
        return $kontingentUsed;
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
     * Returns the Jahr fuer die Statistik
     * 
     * @return string $jahr
     */
    public function getStatistikJahr()
    {
        return $this->getMonth()->format('Y');
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
                    if ($auftrag->getFestpreis()) {
                        if ($this->getStundensatz()) {
                            //					echo ceil($auftrag->getFestpreis() / $this->getStundensatz() * 60);
                            $kontingentUsed += ceil($auftrag->getFestpreis() / $this->getStundensatz() * 60);
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
        //return true;
		
        return true;
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
                    if ($auftrag->getFestpreis()) {
                        if ($this->getStundensatz()) {
                            $kontingentUsed += ceil($auftrag->getFestpreis() / $this->getStundensatz() * 60);
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
        if ($monat !== NULL && $jahr !== NULL) {
            if (!$this->checkValidMonat($monat, $jahr)) {
                return 0;
            }
        }
        return ceil($this->getStundenMonatlich() * 60 * 0.15);
    }

    /**
     * Returns the Sum of zeiten Kontingent für Statistik Jahr
     * 
     * @return integer $kontingentUsed
     */
    public function getKontingentJahrDiagramm()
    {
        $diagrammArr = array('monat' => array(), 'diagrammMax' => 0, 'max' => 0, 'avg' => 0, 'jahr' => $this->getStatistikJahr());
        for ($monat = 1; $monat <= 12; $monat++) {
            $diagrammArr['monat'][$monat] = array(
                'kontingentJeMonat' => $this->getKontingentJeMonat($monat, $this->getStatistikJahr()),
                'kontingentHandlingJeMonat' => $this->getKontingentHandlingJeMonat($monat, $this->getStatistikJahr()),
                'kontingentAbgeschlossen' => 0,
                'kontingentSchwebend' => 0,
                'kontingentAbgeschlossenUeberMax' => 0,
                'kontingentSchwebendUeberMax' => 0,
                'kontingentUeberGesamt' => 0,
                'avg' => 0
            );
        }
        $auftraege = $this->getAuftraegeJahr();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                $monat = $auftrag->getDatumAbschluss()->format('n');
                if ($auftrag->getFestpreis()) {
                    if ($this->getStundensatz()) {
                        $kontingentUsed = ceil($auftrag->getFestpreis() / $this->getStundensatz() * 60);
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
        $kontingentUsed = $this->getKontingentHandlingJahr();
        //return $kontingentUsed;
        //$kontingentUsed=0;
        $auftraege = $this->getAuftraegeJahr();
        if ($auftraege) {
            foreach ($auftraege as $auftrag) {
                if ($auftrag->getFestpreis()) {
                    if ($this->getStundensatz()) {
                        $kontingentUsed += ceil($auftrag->getFestpreis() / $this->getStundensatz() * 60);
                    }
                } else {
                    $kontingentUsed += $auftrag->getKontingentUsed();
                }
            }
        }
        return $kontingentUsed;
    }

    /**
     * Returns the kontingent
     * 
     * @return float $kontingent
     */
    public function getKontingent()
    {
        return $this->stundenMonatlich * 60 * $this->getMonate();
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
        /*
                                                        if (!$this->month) {
                                                            return 0;
                                                        }
                                                        //	return 0;
                                                        //$now = new \DateTime();
                                                        if ($this->vertragsende) {
                                                            if ($this->vertragsende < $this->month) {
                                                            return 0;
                                                            }
                                                        }
                                                        // if($this->vertragsbegin > $this->month) return 0;
                                                        if ($this->vertragsbegin->format('Ym') > $this->month->format('Ym')) {
                                                            return 0;
                                                        }
                                                        return 1;*/

        if (!$this->month) {
            return 0;
        }
        // $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        //$settings = $mitarbeiter->getSettingsAgenturauftrag();
        $start = $this->getStartDateForCalc(new \DateTime('01.01.' . $this->getMonth()->format('Y')));
        $end = $this->getEndDateForCalc(new \DateTime('31.12.' . $this->getMonth()->format('Y')));
        //echo $start->format("d.m.Y");
        //echo $end->format("d.m.Y");
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
        //print_r($settings);
        $start = $this->getStartDateForCalc(new \DateTime('01.01.' . $this->getMonth()->format('Y')));
        //$start = new \DateTime('01.01.' . $settings['statJahr']);
        $end = $this->getEndDateForCalc(new \DateTime('31.12.' . $this->getMonth()->format('Y')));
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
     * Returns the preisMehraufwandStunde
     * 
     * @return float $preisMehraufwandStunde
     */
    public function getPreisMehraufwandStunde()
    {
        return $this->preisMehraufwandStunde;
    }
	
	
	/**
     * dateien
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\KundenDateien>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $dateien = null;

	
	/**
     * Returns the dateien
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\KundenDateien> $dateien
     */
    public function getDateien()
    {
		$retArr = array();
		foreach($this->dateien as $datei) if($datei->getSichtbarkeit()) $restArr[] = $datei;
		return $restArr;
        //return $this->dateien;
    }
}
