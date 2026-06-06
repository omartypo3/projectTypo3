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
 * Auftraege
 */
class Auftraege extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * titel
     *
     * @var string
     */
    protected $titel;
	
	/**
     * counterKontingent
     *
     * @var string
     */
    protected $counterKontingent;
	
	/**
     * mitarbeiterTracker
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Zeiteintraege
     */
    protected $mitarbeiterTracker;

    /**
     * counterZeitnahme
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $counterZeitnahme = 0;
	
	/**
     * counterClass
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $counterClass;

    /**
     * protokolle
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Protokolle>
     */
    protected $protokolle;

    /**
     * statusmeldungen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Protokolle>
     */
    protected $statusmeldungen;

    /**
     * kommentare
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Protokolle>
     */
    protected $kommentare;
	
	/**
     * datumproduktion
     *
     * @var \DateTime
     */
    protected $datumproduktion;

    /**
     * mitarbeiterKontingent
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $mitarbeiterKontingent;

    /**
     * lieferungAnKunde
     *
     * @var bool
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $lieferungAnKunde;
	
	/**
     * stundensatzAgenturvertrag
     *
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $stundensatzAgenturvertrag;

    /**
     * verechnungAgenturvertragFremdkostenInklusive
     *
     * @var int
     */
    protected $verechnungAgenturvertragFremdkostenInklusive;

    /**
     * verechnungAgenturvertragNutzungsfaktorInklusive
     *
     * @var int
     */
    protected $verechnungAgenturvertragNutzungsfaktorInklusive;

	
	/**
     * projekt
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Projekte
     */
    protected $projekt;

    /**
     * status
     *
     * @var int
     */
    protected $status;

    /**
     * datum
     *
     * @var \DateTime
     */
    protected $datum;

    /**
     * prioritaet
     *
     * @var int
     */
    protected $prioritaet;

    /**
     * datumfertigstellung
     *
     * @var \DateTime
     */
    protected $datumfertigstellung;

    /**
     * phasenKontingent
     *
     * @var string
     */
    protected $phasenKontingent;

    /**
     * sichtbarkeit
     *
     * @var bool
     */
    protected $sichtbarkeit;

    /**
     * kontingent
     *
     * @var int
     */
    protected $kontingent;
	
	/**
     * kontingentUsedCached
     *
     * @var int
     */
    protected $kontingentUsedCached;

    /**
     * beschreibung
     *
     * @var string
     */
    protected $beschreibung;

    /**
     * per
     *
     * @var int
     */
    protected $per;

    /**
     * durch
     *
     * @var string
     */
    protected $durch;

    /**
     * oldid
     *
     * @var int
     */
    protected $oldid;

    /**
     * festpreis
     *
     * @var float
     */
    protected $festpreis;

    /**
     * fremdkostenSumme
     *
     * @var float
     */
    protected $fremdkostenSumme;

    /**
     * datumAbschluss
     *
     * @var \DateTime
     */
    protected $datumAbschluss;

    /**
     * nutzungsFaktorNurEntwurfKreativleistung
     *
     * @var bool
     */
    protected $nutzungsFaktorNurEntwurfKreativleistung;

    /**
     * nutzungsFaktoren
     *
     * @var string
     */
    protected $nutzungsFaktoren;

    /**
     * stundensatz
     *
     * @var float
     */
    protected $stundensatz;

    /**
     * phasenStundensatz
     *
     * @var string
     */
    protected $phasenStundensatz;

    /**
     * notizenIntern
     *
     * @var string
     */
    protected $notizenIntern;

    /**
     * kunde
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden
     */
    protected $kunde;

    /**
     * mitarbeiter
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Mitarbeiter>
     */
    protected $mitarbeiter;

    /**
     * zeiten
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Zeiteintraege>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $zeiten;

    /**
     * auftragsart
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Auftragsarten
     */
    protected $auftragsart;

    /**
     * phasen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Phasen>
     */
    protected $phasen;

    /**
     * dateien
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $dateien;

    /**
     * ansprechpartner
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Mitarbeiter
     */
    protected $ansprechpartner;

    /**
     * texte
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $texte;

    /**
     * fegroups
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Fegroups>
     */
    protected $fegroups;

    /**
     * fremdkosten
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Fremdkosten>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $fremdkosten;

    /**
     * lieferanten
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Lieferanten>
     */
    protected $lieferanten;

    /**
     * Erstellt durch
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;
	
	/**
     * datei
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $datei = null;

	/**
     * Returns the titel
     *
     * @return string $titel
     */
    public function getTitelForAufgabe()
    {
        if ($this->kunde) {
            return $this->kunde->getName() . ' : ' . $this->titel;
        } else {
            return $this->titel;
        }
    }
    /**
     * Returns the titel
     *
     * @return string
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
    public function setTitel(string $titel)
    {
        $this->titel = $titel;
    }


    /**
     * Returns the status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param int $status
     * @return void
     */
    public function setStatus(int $status)
    {
        if ($this->status != 70 && $status == 70) {
            if ($this->datum == $this->datumAbschluss) {
                $this->datumAbschluss = new \DateTime();
            }
        }
        //entfernen der favoritenmarkierung falls es gesetzt war vom eingeloggten mitarbeiter
        if ($status == 70) {
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
            $mitarbeiterRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
            $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
            //$mitarbeiters = $mitarbeiterRepository->findAll();
            //foreach($mitarbeiters as $mitarbeiter){
            foreach ($mitarbeiter->getAblage() as $ablage) {
                if ($ablage->getAuftrag()) {
                    if ($ablage->getAuftrag()->getUid() == $this->getUid()) {
                        $mitarbeiter->removeAblage($ablage);
                    }
                }
            }
            $mitarbeiterRepository->update($mitarbeiter);
        }
        //beim setzen des status auf abgeschlossen
        $this->status = $status;
    }

    /**
     * Returns the datum
     *
     * @return \DateTime
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Sets the datum
     *
     * @param \DateTime $datum
     * @return void
     */
    public function setDatum(\DateTime $datum)
    {
        if ($this->datum == $this->datumAbschluss || !$this->datumAbschluss) {
            $this->datumAbschluss = $datum;
        }
        //$this->datumAbschluss = $datum;
        $this->datum = $datum;
    }

    /**
     * Returns the prioritaet
     *
     * @return int
     */
    public function getPrioritaet()
    {
        return $this->prioritaet;
    }

    /**
     * Sets the prioritaet
     *
     * @param int $prioritaet
     * @return void
     */
    public function setPrioritaet(int $prioritaet)
    {
        $this->prioritaet = $prioritaet;
    }

    /**
     * Returns the datumfertigstellung
     *
     * @return \DateTime
     */
    public function getDatumfertigstellung()
    {
        if ($this->datumfertigstellung) {
            if ($this->datumfertigstellung->format('d.m.Y')) {
                return $this->datumfertigstellung;
            }
        }
        return NULL;
    }

    /**
     * Sets the datumfertigstellung
     *
     * @param \DateTime $datumfertigstellung
     * @return void
     */
    public function setDatumfertigstellung(\DateTime $datumfertigstellung)
    {
        $this->datumfertigstellung = $datumfertigstellung;
    }
	
	public function deleteDatumfertigstellung()
    {
        $this->datumfertigstellung = NULL;
    }
	
	
	/**
     * Returns the datumproduktion
     *
     * @return \DateTime $datumproduktion
     */
    public function getDatumproduktion()
    {
        if ($this->datumproduktion) {
            if ($this->datumproduktion->format('d.m.Y')) {
                return $this->datumproduktion;
            }
        }
        return NULL;
    }

    public function deleteDatumproduktion()
    {
        $this->datumproduktion = NULL;
    }

    /**
     * Sets the datumproduktion
     *
     * @param \DateTime $datumproduktion
     * @return void
     */
    public function setDatumproduktion(\DateTime $datumproduktion)
    {
        $this->datumproduktion = $datumproduktion;
    }

    /**
     * Returns the phasenKontingent
     *
     * @return string
     */
    public function getPhasenKontingent()
    {
        return $this->phasenKontingent;
    }
	
	/**
     * Returns the phasenKontingent
     *
     * @return array $phasenKontingent
     */
    public function getPhasenKontingentArray()
    {
        if($this->phasenKontingent) {
            return unserialize($this->phasenKontingent);
        }
    }

    /**
     * Sets the phasenKontingent
     *
     * @param string $phasenKontingent
     * @return void
     */
    public function setPhasenKontingent(string $phasenKontingent)
    {
        $this->phasenKontingent = $phasenKontingent;
    }
	
	/**
     * Returns the mitarbeiterKontingent
     *
     * @return string $mitarbeiterKontingent
     */
    public function getMitarbeiterKontingent()
    {
        return $this->mitarbeiterKontingent;
    }

    /**
     * Returns the mitarbeiterKontingent
     *
     * @return array $mitarbeiterKontingent
     */
    public function getMitarbeiterKontingentArray()
    {
		if($this->mitarbeiterKontingent){
			return unserialize($this->mitarbeiterKontingent);
		}else{
			return [];
		}
    }

    /**
     * Returns the mitarbeiterKontingent summe
     *
     * @return int $mitarbeiterKontingent
     */
    public function getMitarbeiterKontingentSumme()
    {
        return array_sum($this->getMitarbeiterKontingentArray());
    }

    /**
     * Sets the mitarbeiterKontingent
     *
     * @param string $mitarbeiterKontingent
     * @return void
     */
    public function setMitarbeiterKontingent($mitarbeiterKontingent)
    {
        $this->mitarbeiterKontingent = $mitarbeiterKontingent;
    }

    public function toggleSichtbarkeit()
    {
        if ($this->sichtbarkeit) {
            $this->sichtbarkeit = 0;
        } else {
            $this->sichtbarkeit = 1;
        }
    }


    /**
     * Returns the sichtbarkeit
     *
     * @return bool
     */
    public function getSichtbarkeit()
    {
        return $this->sichtbarkeit;
    }

    /**
     * Sets the sichtbarkeit
     *
     * @param bool $sichtbarkeit
     * @return void
     */
    public function setSichtbarkeit(bool $sichtbarkeit)
    {
        $this->sichtbarkeit = $sichtbarkeit;
    }

    /**
     * Returns the boolean state of sichtbarkeit
     *
     * @return bool
     */
    public function isSichtbarkeit()
    {
        return $this->sichtbarkeit;
    }

    /**
     * Returns the kontingent
     *
     * @return int
     */
    public function getKontingent()
    {
        return $this->kontingent;
    }
	
	 /**
     * Returns the kontingent
     *
     * @return array $kontingentSet
     */
    public function getKontingentSet()
    {
        return \DslFactory\DslIntranet\Utility\DateUtility::init()->convertTimeToArray($this->kontingent);
    }

    public function getKontingentUsedSet()
    {
        return \DslFactory\DslIntranet\Utility\DateUtility::init()->convertTimeToArray($this->getKontingentUsed());
    }

	
	public function getKontingentMehraufwandUsedSet()
    {
        return \DslFactory\DslIntranet\Utility\DateUtility::init()->convertTimeToArray($this->getKontingentMehraufwandUsed());
    }
	
    public function getKontingentUsedMoreSet()
    {
        return \DslFactory\DslIntranet\Utility\DateUtility::init()->convertTimeToArray($this->getKontingentUsedMore());
    }

    public function getKontingentFreeSet()
    {
        return \DslFactory\DslIntranet\Utility\DateUtility::init()->convertTimeToArray($this->getKontingentFree());
    }

    public function getPhasenKontingentArraySet()
    {
        $phasenKontingentArraySet = $this->getPhasenKontingentArray();
        foreach ($phasenKontingentArraySet as $k => $v) {
            $phasenKontingentArraySet[$k] = \DslFactory\DslIntranet\Utility\DateUtility::init()->convertTimeToArray($v);
        }
        return $phasenKontingentArraySet;
    }

    /**
     * Sets the kontingent
     *
     * @param int $kontingent
     * @return void
     */
    public function setKontingent(int $kontingent)
    {
        $this->kontingent = $kontingent;
    }

    /**
     * Returns the beschreibung
     *
     * @return string
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
    public function setBeschreibung(string $beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * Returns the per
     *
     * @return int
     */
    public function getPer()
    {
        return $this->per;
    }

    /**
     * Sets the per
     *
     * @param int $per
     * @return void
     */
    public function setPer(int $per)
    {
        $this->per = $per;
    }
	
	/**
     * Returns the counterKontingent
     *
     * @return int $counterKontingent
     */
    public function getCounterKontingent()
    {
        return $this->counterKontingent;
    }

    /**
     * Sets the counterKontingent
     *
     * @param int $counterKontingent
     * @return void
     */
    public function setCounterKontingent($counterKontingent)
    {
        $this->counterKontingent = $counterKontingent;
    }
	
	/**
     * Returns the counterZeitnahme
     *
     * @return int $counterZeitnahme
     */
    public function getCounterZeitnahme()
    {
        return $this->counterZeitnahme;
    }

    /**
     * Sets the counterZeitnahme
     *
     * @param int $counterZeitnahme
     * @return void
     */
    public function setCounterZeitnahme($counterZeitnahme)
    {
        $this->counterZeitnahme = $counterZeitnahme;
        $this->counterClass = '';
        if ($this->counterKontingent) {
            $this->counterClass = 'timerZeitnahmePause';
        }
        if ($this->counterZeitnahme) {
            $this->counterClass = 'timerZeitnahmeAktiv';
        }
    }

    /**
     * Sets the mitarbeiterTracker
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     * @return void
     */
    public function setMitarbeiterTracker($mitarbeiterTracker)
    {
        $this->mitarbeiterTracker = $mitarbeiterTracker;
    }

    /**
     * Returns the mitarbeiterTracker
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Zeiteintraege mitarbeiterTracker
     */
    public function getMitarbeiterTracker()
    {
        return $this->mitarbeiterTracker;
    }

    /**
     * Returns the counterClass
     *
     * @return string $counterClass
     */
    public function getCounterClass()
    {
        return $this->counterClass;
    }
	
	
    /**
     * Returns the zeiten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Protokolle> $protokolle
     */
    public function getProtokolle()
    {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $protokolleRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');

        $this->protokolle = $protokolleRepository->findByAuftraege($this);
        return $this->protokolle;
    }

    /**
     * Returns the zeiten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Protokolle> $protokolle
     */
    public function getKommentare()
    {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $protokolleRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');

        $this->kommentare = $protokolleRepository->findKommentareByAuftraege($this);
        return $this->kommentare;
    }
	
	
	/**
     * Returns the zeiten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Protokolle> $protokolle
     */
    public function getStatusmeldungen()
    {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $protokolleRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');

        $this->statusmeldungen = $protokolleRepository->findStatusmeldungenByAuftraege($this);
        return $this->statusmeldungen;
    }

    /**
     * Returns the durch
     *
     * @return string
     */
    public function getDurch()
    {
        return $this->durch;
    }

    /**
     * Sets the durch
     *
     * @param string $durch
     * @return void
     */
    public function setDurch(string $durch)
    {
        $this->durch = $durch;
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
        return str_pad((string)$this->uid, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Returns the oldid
     *
     * @return int
     */
    public function getOldid()
    {
        return $this->oldid;
    }

    /**
     * Sets the oldid
     *
     * @param int $oldid
     * @return void
     */
    public function setOldid(int $oldid)
    {
        $this->oldid = $oldid;
    }
	
	/*dsl userrights*/
	public function getRights()
    {
        $rights = array(
            'edit' => false,
            'view' => false,
            'delete' => false
            
        );
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($this->getAnsprechpartner() == $mitarbeiter) {
            $rights['delete'] = true;
            $rights['view'] = true;
            $rights['edit'] = true;
        }
        foreach ($this->getMitarbeiter() as $ma) {
            if ($ma == $mitarbeiter) {
                $rights['delete'] = true;
                $rights['view'] = true;
                $rights['edit'] = true;
            }
        }
        if ($mitarbeiter->getRechteAdminAuftraege()) {
            $rights['delete'] = true;
            $rights['view'] = true;
            $rights['edit'] = true;
        }

        if($mitarbeiter->getRechteExternerMitarbeiter()){
            $rights['delete'] = false;
            $rights['edit'] = false;
        }
        //if($mitarbeiter->getUid()==2) $rights['delete'] = true;
        return $rights;
    }

    /**
     * Returns the festpreis
     *
     * @return float
     */
    public function getFestpreis()
    {
        return $this->festpreis;
    }

	/**
     * Returns the festpreis
     *
     * @return float $festpreis
     */
    public function getFestpreisGrundlageAgenturvertrag()
    {
        //return $endpreisPhasen["endpreisArray"]["gesamt"]["nettoFestpreisGesamt"];
        //auftraege.endpreisPhasen.endpreisArray.gesamt.nettoIstGesamt // 900 mit NF
        //auftraege.endpreisPhasen.endpreisArray.gesamt.nettoIst // 600 ohne NF
        //auftraege.endpreisPhasen.endpreisArray.gesamt.nettoIstNutzungsrechte // 300 NR
        //auftraege.endpreisPhasen.endpreisArray.gesamt.nettoFremdkosten // 30
        //$this->festpreis
        if ($this->festpreis) {
            return $this->festpreis;
        }
        $endpreisPhasen = $this->getEndpreisPhasen();
        //return 888;

        
      
        $fespreisVonNutzungsfaktorOderFremdkosten = 0;
        if ($this->verechnungAgenturvertragFremdkostenInklusive == 10) {
            $fespreisVonNutzungsfaktorOderFremdkosten += $endpreisPhasen['endpreisArray']['gesamt']['nettoFremdkosten'];
        }
        if ($this->verechnungAgenturvertragNutzungsfaktorInklusive == 10) {
            $fespreisVonNutzungsfaktorOderFremdkosten += $endpreisPhasen['endpreisArray']['gesamt']['nettoIstNutzungsrechte'];
        }
        if ($fespreisVonNutzungsfaktorOderFremdkosten) {
            return $fespreisVonNutzungsfaktorOderFremdkosten + $endpreisPhasen['endpreisArray']['gesamt']['nettoIst'];
        }

        //prüfen stundensatz



        //wegen agenturvertragsverechnung mit anderen stundensätzen
        //$usedCustom = false;
        foreach($endpreisPhasen["phasenStundensatzArray"] as $phaseUid => $stundensatz){
            if($stundensatz){
                if(isset($endpreisPhasen["kontingentPhasenUsed"][$phaseUid])){
                    if($endpreisPhasen["kontingentPhasenUsed"][$phaseUid]["used"]){
                        //$usedCustom = true;
                        return $endpreisPhasen['endpreisArray']['gesamt']['nettoIst'];
                    }
                }
            }
        }

        return $endpreisPhasen['endpreisArray']['gesamt']['nettoIst'];
//return 888;
     //   return $this->festpreis;
    }
    /**
     * Sets the festpreis
     *
     * @param float $festpreis
     * @return void
     */
    public function setFestpreis(float $festpreis)
    {
        $this->festpreis = $festpreis;
    }

    /**
     * Returns the fremdkostenSumme
     *
     * @return float
     */
    public function getFremdkostenSumme()
    {
        return $this->fremdkostenSumme;
    }

    /**
     * Sets the fremdkostenSumme
     *
     * @param float $fremdkostenSumme
     * @return void
     */
    public function setFremdkostenSumme(float $fremdkostenSumme)
    {
        $this->fremdkostenSumme = $fremdkostenSumme;
    }

    /**
     * Returns the datumAbschluss
     *
     * @return \DateTime
     */
    public function getDatumAbschluss()
    {
        return $this->datumAbschluss;
    }

    /**
     * Sets the datumAbschluss
     *
     * @param \DateTime $datumAbschluss
     * @return void
     */
    public function setDatumAbschluss(\DateTime $datumAbschluss)
    {
        $this->datumAbschluss = $datumAbschluss;
    }
	
	/**
     * Returns the statusAblage
     *
     * @return bool sichtbarkeit
     */
    public function isInAblage()
    {
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        foreach ($mitarbeiter->getAblage() as $ablage) {
            if ($ablage->getAuftrag()) {
                if ($ablage->getAuftrag()->getUid() == $this->getUid()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns the nutzungsFaktorNurEntwurfKreativleistung
     *
     * @return bool
     */
    public function getNutzungsFaktorNurEntwurfKreativleistung()
    {
        return $this->nutzungsFaktorNurEntwurfKreativleistung;
    }

    /**
     * Sets the nutzungsFaktorNurEntwurfKreativleistung
     *
     * @param bool $nutzungsFaktorNurEntwurfKreativleistung
     * @return void
     */
    public function setNutzungsFaktorNurEntwurfKreativleistung(bool $nutzungsFaktorNurEntwurfKreativleistung)
    {
        $this->nutzungsFaktorNurEntwurfKreativleistung = $nutzungsFaktorNurEntwurfKreativleistung;
    }

    /**
     * Returns the boolean state of nutzungsFaktorNurEntwurfKreativleistung
     *
     * @return bool
     */
    public function isNutzungsFaktorNurEntwurfKreativleistung()
    {
        return $this->nutzungsFaktorNurEntwurfKreativleistung;
    }

    /**
     * Returns the nutzungsFaktoren
     *
     * @return string
     */
    public function getNutzungsFaktoren()
    {
        $filterArr = array();
        if ($this->nutzungsFaktoren) {
            $filterArr = unserialize($this->nutzungsFaktoren);
        }
        //if($filterArr["switch"]) unset($filterArr["switch"]);
        return $filterArr;
    }
	
	 /**
     * Returns the nutzungsFaktor
     *
     * @return float $nutzungsFaktor
     */
    public function getNutzungsFaktor()
    {
        if ($this->isNutzungsFaktorNurEntwurfKreativleistung) {
            return NULL;
        }
        $faktoren = $this->getNutzungsfaktoren();
        $faktor = 0;
        foreach ($faktoren as $value) {
            $faktor += $value;
        }
        return $faktor;
    }

    /**
     * Sets the nutzungsFaktoren
     *
     * @param string $nutzungsFaktoren
     * @return void
     */
    public function setNutzungsFaktoren(string $nutzungsFaktoren)
    {
        if ($nutzungsFaktoren) {
            $this->nutzungsFaktoren = serialize($nutzungsFaktoren);
        } else {
            $this->nutzungsFaktoren = '';
        }
    }

    /**
     * Returns the stundensatz
     *
     * @return float
     */
    public function getStundensatz()
    {
         if ($this->stundensatz) {
            return $this->stundensatz;
        }
        return floatval(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('defaultStundensatz'));

    }

    /**
     * Sets the stundensatz
     *
     * @param float $stundensatz
     * @return void
     */
    public function setStundensatz(float $stundensatz)
    {
        $this->stundensatz = $stundensatz;
    }

    /**
     * Returns the phasenStundensatz
     *
     * @return string
     */
    public function getPhasenStundensatz()
    {
        return $this->phasenStundensatz;
    }
	
	/**
     * Returns the phasenStundensatz
     *
     * @return array $phasenStundensatz
     */
    public function getPhasenStundensatzArray()
    {
        if($this->phasenStundensatz) {
            return unserialize($this->phasenStundensatz);
        }
    }


    /**
     * Sets the phasenStundensatz
     *
     * @param string $phasenStundensatz
     * @return void
     */
    public function setPhasenStundensatz(string $phasenStundensatz)
    {
        $this->phasenStundensatz = $phasenStundensatz;
    }

    /**
     * Returns the notizenIntern
     *
     * @return string
     */
    public function getNotizenIntern()
    {
        return $this->notizenIntern;
    }

    /**
     * Sets the notizenIntern
     *
     * @param string $notizenIntern
     * @return void
     */
    public function setNotizenIntern(string $notizenIntern)
    {
        $this->notizenIntern = $notizenIntern;
    }

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->mitarbeiter = $this->mitarbeiter ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->zeiten = $this->zeiten ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->phasen = $this->phasen ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->dateien = $this->dateien ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->texte = $this->texte ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->fegroups = $this->fegroups ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->fremdkosten = $this->fremdkosten ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->lieferanten = $this->lieferanten ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the kunde
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Kunden
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
     * Adds a Mitarbeiter
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @return void
     */
    public function addMitarbeiter(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter)
    {
        $this->mitarbeiter->attach($mitarbeiter);
    }

    /**
     * Removes a Mitarbeiter
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiterToRemove The Mitarbeiter to be removed
     * @return void
     */
    public function removeMitarbeiter(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiterToRemove)
    {
        $this->mitarbeiter->detach($mitarbeiterToRemove);
    }

    /**
     * Returns the mitarbeiter
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Mitarbeiter>
     */
    public function getMitarbeiter()
    {
        return $this->mitarbeiter;
    }

    /**
     * Sets the mitarbeiter
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Mitarbeiter> $mitarbeiter
     * @return void
     */
    public function setMitarbeiter(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $mitarbeiter)
    {
        $this->mitarbeiter = $mitarbeiter;
    }

    /**
     * Adds a Zeiteintraege
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiten
     * @return void
     */
    public function addZeiten(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiten)
    {
        $this->zeiten->attach($zeiten);
    }

    /**
     * Removes a Zeiteintraege
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeitenToRemove The Zeiteintraege to be removed
     * @return void
     */
    public function removeZeiten(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeitenToRemove)
    {
        $this->zeiten->detach($zeitenToRemove);
    }

    /**
     * Returns the zeiten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Zeiteintraege>
     */
    public function getZeiten()
    {
        return $this->zeiten;
    }

    /**
     * Sets the zeiten
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Zeiteintraege> $zeiten
     * @return void
     */
    public function setZeiten(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $zeiten)
    {
        $this->zeiten = $zeiten;
    }
	
	/**
     * Returns the Sum of zeiten Kontingent
     *
     * @return integer $kontingentUsed
     */
    public function getKontingentUsed()
    {


        if($this->getKontingentUsedCached()) return $this->getKontingentUsedCached();

        //rückgabe in minuten
        $kontingentUsed = 0;
        $now = new \DateTime();
        foreach ($this->zeiten as $zeiteintraege) {
            if (!$zeiteintraege->getEnd()) {
                //tracker zeiten ergänzen
               // echo " tracker ";
                $kontingentUsed += $zeiteintraege->getTrackerSeconds();
                continue;
            }
            $kontingentUsed += $zeiteintraege->getKontingent() * 60;
        }
        if ($kontingentUsed) {
            $minuten = ceil($kontingentUsed / 60);
            $this->setKontingentUsedCached($minuten);
            return $minuten;
        }



        return 0;
    }

    /**
     * Returns the kontingentUsedCached
     *
     * @return integer $kontingentUsedCached
     */
    public function getKontingentUsedCached()
    {
        return $this->kontingentUsedCached;
    }

    /**
     * Sets the kontingentUsedCached
     *
     * @param integer $kontingentUsedCached
     * @return void
     */
    public function setKontingentUsedCached($kontingentUsedCached)
    {
        $this->kontingentUsedCached = $kontingentUsedCached;
    }

    /**
     * Returns the Sum of zeiten Kontingent
     *
     * @return integer $kontingentMehraufwandUsed
     */
    public function getKontingentMehraufwandUsed()
    {
        //rückgabe in minuten
        $kontingentUsed = 0;
        $now = new \DateTime();
        foreach ($this->zeiten as $zeiteintraege) {
            if (!$zeiteintraege->getEnd()) {
                //tracker zeiten ergänzen
                //$kontingentUsed += $zeiteintraege->getTrackerSeconds();
                continue;
            }
            $kontingentUsed += $zeiteintraege->getKontingentMehraufwand() * 60;
        }
        if ($kontingentUsed) {
            return ceil($kontingentUsed / 60);
        }
        return 0;
    }
    /**
     * Returns the Kontingent by mitarbeiter
     *
     * @return mixed
     */
    public function getKontingentUsedByMitarbeiter()
    {
        $mitarbeiterArray = array();
        //rückgabe in minuten
        //$kontingentUsed = 0;
        $now = new \DateTime();
        foreach ($this->zeiten as $zeiteintraege) {
            //	$mitarbeiterArray[1000] = 100;
            //$mitarbeiterArray[1000+count($mitarbeiterArray)] = ;
			if($zeiteintraege->getCruser()){
				$cruser = $zeiteintraege->getCruser()->getUid();
				if (!isset($mitarbeiterArray[$cruser])) {
					$mitarbeiterArray[$cruser] = 0;
				}
				if (!$zeiteintraege->getEnd()) {
					//tracker zeiten ergänzen
					$mitarbeiterArray[$cruser] += $zeiteintraege->getTrackerSeconds();
					continue;
				}
				$mitarbeiterArray[$cruser] += $zeiteintraege->getKontingent() * 60;
			}
        }
        foreach (array_keys($mitarbeiterArray) as $cruser) {
            $mitarbeiterArray[$cruser] = ceil($mitarbeiterArray[$cruser] / 60);
        }
        return $mitarbeiterArray;
    }

    /**
     * Returns the Kontingent by mitarbeiter summe
     *
     * @return integer $getKontingentUsedByMitarbeiter
     */
    public function getKontingentUsedByMitarbeiterSumme()
    {
        return array_sum($this->getKontingentUsedByMitarbeiter());
    }

    /**
     * Returns the Sum of zeiten Kontingent
     *
     * @return integer $getKontingentPhasenUsed
     */
    public function getKontingentPhasenUsed()
    {
        if ($result = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getVarFor('getKontingentPhasenUsedResult' . $this->getUid())) {
            return $result;
        }

        if($this->getPhasenKontingent()){
            $kontingentPhasen = unserialize($this->getPhasenKontingent());
        }
        $kontingentPhasenUsedArray = array();
        $now = new \DateTime();
        foreach ($this->zeiten as $zeiteintraege) {
            if (!$zeiteintraege->getEnd()) {
                //zeit ist temporär noch in einem Tracker!!!
                if (!isset($kontingentPhasenUsedArray[0])) {
                    $kontingentPhasenUsedArray[0] = 0;
                }
                $kontingentPhasenUsedArray[0] += $zeiteintraege->getTrackerSeconds();
            } else {
                //zeit wurde gespeichert oder war eh ein manueller zeiteintrag
                //	echo $zeiteintraege->getUid()."(".count($zeiteintraege->getSegmente())."):";
                if (!count($zeiteintraege->getSegmente())) {
                    if (!isset($kontingentPhasenUsedArray[0])) {
                        $kontingentPhasenUsedArray[0] = 0;
                    }
                    $kontingentPhasenUsedArray[0] += $zeiteintraege->getKontingent() * 60;
                }
                foreach ($zeiteintraege->getSegmente() as $segment) {
                    $phase = $segment->getPhase();
                    if ($phase) {
                        $uid = $phase->getUid();
                    } else {
                        $uid = 0;
                    }
                    if (!isset($kontingentPhasenUsedArray[$uid])) {
                        $kontingentPhasenUsedArray[$uid] = 0;
                    }
                    $kontingentPhasenUsedArray[$uid] += $segment->getMinuten() * 60;
                }
            }
        }
        $usedSum = 0;
        foreach ($kontingentPhasenUsedArray as $uid => $sekunden) {
            // Initialize with default values
            $currentEntry = [
                'used' => 0,
                'max' => 0,
                'percent' => 0,
                'free' => 0
            ];

            // Safely calculate used minutes
            $currentEntry['used'] = isset($kontingentPhasenUsedArray[$uid])
                ? (int)ceil($kontingentPhasenUsedArray[$uid] / 60)
                : 0;

            $usedSum += $sekunden;

            // Set max value if available
            if (isset($kontingentPhasen[$uid])) {
                $currentEntry['max'] = (int)$kontingentPhasen[$uid];
            }

            // Calculate percentage if both values exist
            if ($currentEntry['used'] > 0 && $currentEntry['max'] > 0) {
                $currentEntry['percent'] = round(100 / $currentEntry['max'] * $currentEntry['used'], 1);
            }

            // Calculate free time
            if ($currentEntry['max'] > 0) {
                $currentEntry['free'] = max(0, $currentEntry['max'] - $currentEntry['used']);
            }

            $kontingentPhasenUsedArray[$uid] = $currentEntry;
        }
        //$kontingentPhasenUsedArray["_"] = unserialize($this->getPhasenKontingent());
        $kontingentPhasenUsedArray['all'] = array(
            'used' => ceil($usedSum / 60),
            'max' => $this->getKontingent()
        );
        if ($kontingentPhasenUsedArray['all']['max'] > $kontingentPhasenUsedArray['all']['used']) {
            $kontingentPhasenUsedArray['all']['free'] = $kontingentPhasenUsedArray['all']['max'] - $kontingentPhasenUsedArray['all']['used'];
        } else {
            $kontingentPhasenUsedArray['all']['free'] = 0;
        }
        //achtung läuft mehrmals durch!!!
        //		print_r($kontingentPhasenUsedArray);
        \DslFactory\DslIntranet\Utility\SettingsUtility::init()->setVarFor('getKontingentPhasenUsedResult' . $this->getUid(), $kontingentPhasenUsedArray);
        return $kontingentPhasenUsedArray;
    }

    /**
     * Returns the Sum of zeiten Kontingent
     *
     * @return integer $kontingentUsedMore
     */
    public function getKontingentUsedMore()
    {
        if (!$this->kontingent) {
            return false;
        }
        $kontingentUsedMore = $this->getKontingentUsed() - $this->kontingent;
        if ($kontingentUsedMore < 0) {
            $kontingentUsedMore = 0;
        }
        return $kontingentUsedMore;
    }

    /**
     * Returns the Sum of zeiten Kontingent
     *
     * @return integer $kontingentFree
     */
    public function getKontingentFree()
    {
        $free = $this->kontingent - $this->getKontingentUsed();
        if ($free < 0) {
            $free = 0;
        }
        return $free;
    }

    /**
     * Returns the status
     *
     * @return integer $status
     */
    public function getKontingentUsedPercent()
    {
        if (!$this->getKontingent()) {
            return 0;
        }
        return ceil(100 / $this->getKontingent() * $this->getKontingentUsed());
    }

    /**
     * Returns the auftragsart
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Auftragsarten
     */
    public function getAuftragsart()
    {
        return $this->auftragsart;
    }

    /**
     * Sets the auftragsart
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsart
     * @return void
     */
    public function setAuftragsart(\DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsart)
    {
        $this->auftragsart = $auftragsart;
    }
	
	 /**
     * Returns the projekt
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Projekte projekt
     */
    public function getProjekt()
    {
        return $this->projekt;
    }

    /**
     * Sets the projekt
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Projekte $projekt
     * @return void
     */
    public function setProjekt(\DslFactory\DslIntranet\Domain\Model\Projekte $projekt)
    {
        $this->projekt = $projekt;
    }
	
	/**
     * Returns the status
     *
     * @return int $status
     */
    public function getStatusPercent()
    {
        $statusKeys = array_keys($this->getStatuss());
        $position = array_search($this->getStatus(), $statusKeys) + 1;
        return ceil(100 / count($statusKeys) * $position);
    }
	
	/**
     * Returns the status
     *
     * @return int $status
     */
    public function getStatuss()
    {
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] as $status) {
            //vorbereitet durch kunde angelegt status rauslassen
            if ($status[1] != 5) {
                $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.statusnr.' . $status[1], 'dsl_intranet',[],'de') . '. ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.status.' . $status[1], 'dsl_intranet',[],'de');
            }
        }
        return $statuss;
    }
	
	
	 /**
     * Returns the status
     *
     * @return int $status
     */
    public function getStatussKunde()
    {
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] as $status) {
            //vorbereitet durch kunde angelegt status rauslassen
            if ($status[1] != 5) {
                $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.kundenstatusnr.' . $status[1], 'dsl_intranet',[],'de') . '. ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.kundenstatus.' . $status[1], 'dsl_intranet',[],'de');
            }
        }
        return $statuss;
    }
	
	/**
     * Returns the status
     *
     * @return int $status
     */
    public function getStatusNr()
    {
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] as $status) {
            //vorbereitet durch kunde angelegt status rauslassen
            if ($status[1] != 5) {
                $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.statusnr.' . $status[1], 'dsl_intranet',[],'de');
            }
        }
        return $statuss;
    }
	
	 /**
     * Returns the statustext
     *
     * @return string $statusText
     */
    public function getStatusText()
    {
        $arr = $this->getStatuss();
        return $arr[$this->status];
    }


    /**
     * Adds a Phasen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phasen
     * @return void
     */
    public function addPhasen(\DslFactory\DslIntranet\Domain\Model\Phasen $phasen)
    {
        $this->phasen->attach($phasen);
    }

    /**
     * Removes a Phasen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phasenToRemove The Phasen to be removed
     * @return void
     */
    public function removePhasen(\DslFactory\DslIntranet\Domain\Model\Phasen $phasenToRemove)
    {
        $this->phasen->detach($phasenToRemove);
    }

    /**
     * Returns the phasen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Phasen>
     */
    public function getPhasen()
    {
        return $this->phasen;
    }
	
	/**
     * Returns the usedPhasen
     *
     * @return mixed
     */
    public function getPhasenUsed()
    {
        $phasenResultArr = array();
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $phasenRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\PhasenRepository');

        $phasenAll = $phasenRepository->findAll();
        $phasen = $this->getPhasen();
        $kontingentPhasen = $this->getKontingentPhasenUsed();
        foreach ($phasenAll as $phase) {
            $found = false;
            if (!$found) {
                foreach ($kontingentPhasen as $phaseKey => $phaseTmp) {
                    if ($phaseKey == $phase->getUid()) {
                        $found = true;
                        continue;
                    }
                }
            }
            if (!$found) {
                foreach ($phasen as $phaseTmp) {
                    if ($phaseTmp->getUid() == $phase->getUid()) {
                        $found = true;
                        continue;
                    }
                }
            }
            if ($found) {
                $phasenResultArr[] = $phase;
            }
        }
        //print_r($phasenResultArr);
        //die;
        return $phasenResultArr;
    }

    /**
     * Returns the usedPhasen
     *
     * @return mixed
     */
    public function getPhasenSonstigesUsed()
    {
        $kontingentPhasen = $this->getKontingentPhasenUsed();
        if ($kontingentPhasen[0]) {
            return $kontingentPhasen[0];
        }
        return false;
    }

    /**
     * Sets the phasen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Phasen> $phasen
     * @return void
     */
    public function setPhasen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $phasen)
    {
        $this->phasen = $phasen;
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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien>
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
     * Returns the dateien Downloads
     *
     * @return mixed
     */
    public function getDownloads()
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $result = array();
        foreach ($this->dateien as $download) {
            if ($download->getType() == 50) {
                if ($user->isKunde() && !$download->isSichtbarkeit()) {
                    continue;
                }
                $result[] = $download;
            }
        }
        if (count($result)) {
            return $result;
        }
        return false;
    }
	
	/**
     * Returns the dateien Rechnungen
     *
     * @return mixed
     */
    public function getRechnungen()
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $result = array();
        foreach ($this->dateien as $download) {
            if ($download->getType() == 30) {
                if ($user->isKunde() && !$download->isSichtbarkeit()) {
                    continue;
                }
                $result[] = $download;
            }
        }
        if (count($result)) {
            return $result;
        }
        return false;
    }
	
	/**
     * Returns the dateien Angebote
     *
     * @return mixed
     */
    public function getAngebote()
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $result = array();
        foreach ($this->dateien as $download) {
            if ($download->getType() == 20) {
                if ($user->isKunde() && !$download->isSichtbarkeit()) {
                    continue;
                }
                $result[] = $download;
            }
        }
        if (count($result)) {
            return $result;
        }
        return false;
    }
	
	 /**
     * Returns the dateien Finanzen
     *
     * @return mixed
     */
    public function getFinanzen()
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $result = array();
        foreach ($this->dateien as $download) {
            if ($download->getType() != 50) {
                if ($user->isKunde() && !$download->isSichtbarkeit()) {
                    continue;
                }
                $result[] = $download;
            }
        }
        if (count($result)) {
            return $result;
        }
        return false;
    }

    /**
     * Returns the ansprechpartner
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Mitarbeiter
     */
    public function getAnsprechpartner()
    {
        return $this->ansprechpartner;
    }

    /**
     * Sets the ansprechpartner
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $ansprechpartner
     * @return void
     */
    public function setAnsprechpartner(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $ansprechpartner)
    {
        $this->ansprechpartner = $ansprechpartner;
    }

    /**
     * Adds a AuftraegeTexte
     *
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $texte
     * @return void
     */
    public function addTexte(\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $texte)
    {
        $this->texte->attach($texte);
    }

    /**
     * Removes a AuftraegeTexte
     *
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $texteToRemove The AuftraegeTexte to be removed
     * @return void
     */
    public function removeTexte(\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $texteToRemove)
    {
        $this->texte->detach($texteToRemove);
    }

    /**
     * Returns the texte
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte>
     */
    public function getTexte()
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($user->isKunde()) {
            $result = array();
            foreach ($this->texte as $text) {
                if (!$text->isSichtbarkeit()) {
                    continue;
                }
                $result[] = $text;
            }
            if (count($result)) {
                return $result;
            }
            return false;
        }
        return $this->texte;
    }

    /**
     * Sets the texte
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte> $texte
     * @return void
     */
    public function setTexte(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $texte)
    {
        $this->texte = $texte;
    }

    /**
     * Adds a Fegroups
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $fegroup
     * @return void
     */
    public function addFegroup(\DslFactory\DslIntranet\Domain\Model\Fegroups $fegroup)
    {
        $this->fegroups->attach($fegroup);
    }

    /**
     * Removes a Fegroups
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $fegroupToRemove The Fegroups to be removed
     * @return void
     */
    public function removeFegroup(\DslFactory\DslIntranet\Domain\Model\Fegroups $fegroupToRemove)
    {
        $this->fegroups->detach($fegroupToRemove);
    }

    /**
     * Returns the fegroups
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Fegroups>
     */
    public function getFegroups()
    {
        return $this->fegroups;
    }

    /**
     * Sets the fegroups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Fegroups> $fegroups
     * @return void
     */
    public function setFegroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $fegroups)
    {
        $this->fegroups = $fegroups;
    }

    /**
     * Adds a Fremdkosten
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fremdkosten $fremdkosten
     * @return void
     */
    public function addFremdkosten(\DslFactory\DslIntranet\Domain\Model\Fremdkosten $fremdkosten)
    {
        $this->fremdkosten->attach($fremdkosten);
    }

    /**
     * Removes a Fremdkosten
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fremdkosten $fremdkostenToRemove The Fremdkosten to be removed
     * @return void
     */
    public function removeFremdkosten(\DslFactory\DslIntranet\Domain\Model\Fremdkosten $fremdkostenToRemove)
    {
        $this->fremdkosten->detach($fremdkostenToRemove);
    }

    /**
     * Returns the fremdkosten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Fremdkosten>
     */
    public function getFremdkosten()
    {
        return $this->fremdkosten;
    }
	
	/**
     * Returns the stundensatzValid
     *
     * @return float $stundensatzValid
     */
    public function getStundensatzValid()
    {
        $stundensatz = $this->getStundensatz();
        if ($this->getAuftragsart()->getUid() == 6) {
            $stundensatz = $this->getStundensatzAgenturvertrag();
            if (!$stundensatz) {
                $stundensatz = $this->getDefaultStundensatzAgenturvertrag();
            }
        }
       
        return floatval($stundensatz);
    }

    /**
     * @return array
     */
    public function getEndpreisPhasen(): array
    {
        $stundensatz = $this->getStundensatzValid();
        $phasenStundensatzArray = $this->getPhasenStundensatzArray() ?? [];
        $kontingentPhasenUsed = $this->getKontingentPhasenUsed() ?? [];
        $phasenKontingentArray = $this->getPhasenKontingentArray() ?? [];

        // Initialize complete structure with default values
        $endpreisArray = [
            'phasen' => [],
            'phasenSoll' => [],
            'gesamt' => [
                'minutenIst' => 0,
                'nettoIst' => 0,
                'nettoIstGesamt' => 0,
                'nettoIstNutzungsrechte' => 0,
                'nettoFremdkosten' => $this->getFremdkostenSumme() ?? 0,
                'zwischensumme' => false,
                'nettoFestpreis' => $this->festpreis ?? 0,
                'minutenSoll' => 0,
                'nettoSoll' => 0,
                'nettoSollGesamt' => 0,
                'nettoSollNutzungsrechte' => 0,
                'nettoFestpreisGesamt' => 0,
                'nettoIstGesamtMitFremdkosten' => 0,
                'nutzungsFaktor' => 0
            ]
        ];

        // Process phases
        foreach ($this->getPhasenUsed() ?? [] as $phase) {
            try {
                if ($phase->getUid() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                    $phase->getUid()->_loadRealInstance();
                }

                $phaseUid = $phase->getUid();
                $phaseArr = [
                    'phase' => $phase,
                    'aufwand' => [
                        'used' => $kontingentPhasenUsed[$phaseUid]['used'] ?? 0,
                        'max' => 0,
                        'free' => $kontingentPhasenUsed[$phaseUid]['free'] ?? 0,
                        'percent' => $kontingentPhasenUsed[$phaseUid]['percent'] ?? 0,
                        'stundensatz' => (float)($phasenStundensatzArray[$phaseUid] ?? $stundensatz)
                    ]
                ];

                // Set max value from kontingent array if available
                if (isset($phasenKontingentArray[$phaseUid])) {
                    $phaseArr['aufwand']['max'] = (float)$phasenKontingentArray[$phaseUid];
                }

                // Add to phasen if used > 0
                if (($phaseArr['aufwand']['used'] ?? 0) > 0) {
                    $endpreisArray['phasen'][] = $phaseArr;
                }

                // Always add to phasenSoll
                $endpreisArray['phasenSoll'][] = $phaseArr;
            } catch (\Exception $e) {
                continue; // Skip problematic phases
            }
        }

        // Handle sonstige phase
        if ($sonstigeUsed = $this->getPhasenSonstigesUsed()) {
            $endpreisArray['phasen']['sonstige'] = [
                'aufwand' => array_merge(
                    ['used' => 0, 'max' => 0, 'free' => 0, 'percent' => 0],
                    is_array($sonstigeUsed) ? $sonstigeUsed : [],
                    ['stundensatz' => $stundensatz]
                )
            ];
        }

        // Calculate net prices
        foreach ($endpreisArray['phasen'] as $k => $v) {
            $used = (float)($v['aufwand']['used'] ?? 0);
            $rate = (float)($v['aufwand']['stundensatz'] ?? 0);
            $endpreisArray['phasen'][$k]['aufwand']['nettoIst'] = round($used / 60 * $rate);
        }

        foreach ($endpreisArray['phasenSoll'] as $k => $v) {
            $max = (float)($v['aufwand']['max'] ?? 0);
            $rate = (float)($v['aufwand']['stundensatz'] ?? 0);
            $endpreisArray['phasenSoll'][$k]['aufwand']['nettoSoll'] = round($max / 60 * $rate, 2);
        }

        // Sum up values
        foreach ($endpreisArray['phasen'] as $v) {
            $endpreisArray['gesamt']['nettoIst'] += (float)($v['aufwand']['nettoIst'] ?? 0);
            $endpreisArray['gesamt']['minutenIst'] += (float)($v['aufwand']['used'] ?? 0);
        }

        foreach ($endpreisArray['phasenSoll'] as $v) {
            $endpreisArray['gesamt']['nettoSoll'] += (float)($v['aufwand']['nettoSoll'] ?? 0);
            $endpreisArray['gesamt']['minutenSoll'] += (float)($v['aufwand']['max'] ?? 0);
        }

        // Fallback for nettoSoll
        if (empty($endpreisArray['gesamt']['nettoSoll'])) {
            $endpreisArray['gesamt']['nettoSoll'] = isset($kontingentPhasenUsed['all']['max'])
                ? (float)($kontingentPhasenUsed['all']['max'] / 60 * $stundensatz)
                : 0;
        }

        // Calculate usage rights
        if (!$this->isNutzungsFaktorNurEntwurfKreativleistung()) {
            $factor = $this->getNutzungsFaktor() ?? 1;
            $endpreisArray['gesamt']['nutzungsFaktor'] = $factor;
            $endpreisArray['gesamt']['nettoFestpreisNutzungsrechte'] = $factor * ($endpreisArray['gesamt']['nettoFestpreis'] ?? 0);
            $endpreisArray['gesamt']['nettoIstNutzungsrechte'] = $factor * ($endpreisArray['gesamt']['nettoIst'] ?? 0);
            $endpreisArray['gesamt']['nettoSollNutzungsrechte'] = $factor * ($endpreisArray['gesamt']['nettoSoll'] ?? 0);
        }

        // Calculate totals
        $endpreisArray['gesamt']['nettoIstGesamt'] = ($endpreisArray['gesamt']['nettoIst'] ?? 0) + ($endpreisArray['gesamt']['nettoIstNutzungsrechte'] ?? 0);
        $endpreisArray['gesamt']['nettoSollGesamt'] = ($endpreisArray['gesamt']['nettoSoll'] ?? 0) + ($endpreisArray['gesamt']['nettoSollNutzungsrechte'] ?? 0);
        $endpreisArray['gesamt']['nettoFestpreisGesamt'] = ($endpreisArray['gesamt']['nettoFestpreis'] ?? 0) + ($endpreisArray['gesamt']['nettoFestpreisNutzungsrechte'] ?? 0);
        $endpreisArray['gesamt']['nettoIstGesamtMitFremdkosten'] = ($endpreisArray['gesamt']['nettoIstGesamt'] ?? 0) + ($endpreisArray['gesamt']['nettoFremdkosten'] ?? 0);

        // Set intermediate sum flag
        $endpreisArray['gesamt']['zwischensumme'] =
            ($endpreisArray['gesamt']['nettoIstGesamt'] ?? 0) != ($endpreisArray['gesamt']['nettoIst'] ?? 0);

        return [
            'phasenSonstigesUsed' => $this->getPhasenSonstigesUsed() ?? [],
            'phasenUsed' => $this->getPhasenUsed() ?? [],
            'kontingentPhasenUsed' => $kontingentPhasenUsed,
            'phasenKontingentArray' => $phasenKontingentArray,
            'phasenStundensatzArray' => $phasenStundensatzArray,
            'endpreisArray' => $endpreisArray
        ];
    }

    /**
     * Sets the fremdkosten
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Fremdkosten> $fremdkosten
     * @return void
     */
    public function setFremdkosten(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $fremdkosten)
    {
        $this->fremdkosten = $fremdkosten;
    }
	
	/**
     * Returns the titel
     *
     * @return string $titel
     */
    public function getAbrechnungArt()
    {
        if ($this->festpreis) {
            return 'Projektpreis';
        } else {
            return 'Zeitliste';
        }
    }

    /**
     * Adds a Lieferanten
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten
     * @return void
     */
    public function addLieferanten(\DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten)
    {
        $this->lieferanten->attach($lieferanten);
    }

    /**
     * Removes a Lieferanten
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferantenToRemove The Lieferanten to be removed
     * @return void
     */
    public function removeLieferanten(\DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferantenToRemove)
    {
        $this->lieferanten->detach($lieferantenToRemove);
    }

    /**
     * Returns the lieferanten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Lieferanten>
     */
    public function getLieferanten()
    {
        return $this->lieferanten;
    }

    /**
     * Sets the lieferanten
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Lieferanten> $lieferanten
     * @return void
     */
    public function setLieferanten(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $lieferanten)
    {
        $this->lieferanten = $lieferanten;
    }
	
	    /**
     * Returns the lieferungAnKunde
     *
     * @return bool $lieferungAnKunde
     */
    public function getLieferungAnKunde()
    {
        return $this->lieferungAnKunde;
    }

    /**
     * Sets the lieferungAnKunde
     *
     * @param bool $lieferungAnKunde
     * @return void
     */
    public function setLieferungAnKunde($lieferungAnKunde)
    {
        $this->lieferungAnKunde = $lieferungAnKunde;
    }

    /**
     * Returns the boolean state of lieferungAnKunde
     *
     * @return bool
     */
    public function isLieferungAnKunde()
    {
        return $this->lieferungAnKunde;
    }
	
	/**
     * Returns the stundensatzAgenturvertrag
     *
     * @return float $stundensatzAgenturvertrag
     */
    public function getDefaultStundensatzAgenturvertrag()
    {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $agenturvertraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AgenturvertraegeRepository');

        /*	
        		
        		if ($this->request->hasArgument('kunde')) if ($this->request->getArgument('kunde')){
        			$kunde = $this->kundenRepository->findByUid($this->request->getArgument('kunde'));
        
        			$datum = new \DateTime($this->request->getArgument('datumAbschluss'));
        
        			$stundensatz = $agenturvertraegeRepository->findAgenturvertragByKundeDatum($kunde,$datum->format("Y-m-d"));
        
        			//$kunde = $this->kunden
        		}
        		if(!$stundensatz) $stundensatz = floatval(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('defaultStundensatz'));
        */

        if ($this->getUid()) {
            //$datum = new \DateTime($this->request->getArgument('datumAbschluss'));
            if ($stundensatz = $agenturvertraegeRepository->findAgenturvertragByKundeDatum($this->getKunde(), $this->getDatumAbschluss()->format('Y-m-d'))) {
                return floatval($stundensatz);
            }
        }
        return floatval(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('defaultStundensatz'));
    }
	
	/**
     * Returns the stundensatzAgenturvertrag
     *
     * @return float $stundensatzAgenturvertrag
     */
    public function getStundensatzAgenturvertrag()
    {
        return $this->stundensatzAgenturvertrag;
    }
	 /**
     * Sets the stundensatzAgenturvertrag
     *
     * @param float $stundensatzAgenturvertrag
     * @return void
     */
    public function setStundensatzAgenturvertrag($stundensatzAgenturvertrag)
    {
        $this->stundensatzAgenturvertrag = $stundensatzAgenturvertrag;
    }
	
	/**
     * Returns the verechnungAgenturvertragFremdkostenInklusive
     *
     * @return int $verechnungAgenturvertragFremdkostenInklusive
     */
    public function getVerechnungAgenturvertragFremdkostenInklusive()
    {
        return $this->verechnungAgenturvertragFremdkostenInklusive;
    }

    /**
     * Sets the verechnungAgenturvertragFremdkostenInklusive
     *
     * @param int $verechnungAgenturvertragFremdkostenInklusive
     * @return void
     */
    public function setVerechnungAgenturvertragFremdkostenInklusive($verechnungAgenturvertragFremdkostenInklusive)
    {
        $this->verechnungAgenturvertragFremdkostenInklusive = $verechnungAgenturvertragFremdkostenInklusive;
    }
	
	/**
     * Returns the verechnungAgenturvertragNutzungsfaktorInklusive
     *
     * @return int $verechnungAgenturvertragNutzungsfaktorInklusive
     */
    public function getVerechnungAgenturvertragNutzungsfaktorInklusive()
    {
        return $this->verechnungAgenturvertragNutzungsfaktorInklusive;
    }

    /**
     * Sets the verechnungAgenturvertragNutzungsfaktorInklusive
     *
     * @param int $verechnungAgenturvertragNutzungsfaktorInklusive
     * @return void
     */
    public function setVerechnungAgenturvertragNutzungsfaktorInklusive($verechnungAgenturvertragNutzungsfaktorInklusive)
    {
        $this->verechnungAgenturvertragNutzungsfaktorInklusive = $verechnungAgenturvertragNutzungsfaktorInklusive;
    }
	
	 /**
     * Returns the agenturvertragExistiert
     *
     * @return bool agenturvertragExistiert
     */
    public function getAgenturvertragExistiert()
    {
        $stundensatz = $this->getStundensatz();
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $agenturvertraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AgenturvertraegeRepository');

		if ($this->getAuftragsart()->getUid() == 6) {
            if ($this->getKunde()) {
                if ($agenturvertraegeRepository->findAgenturvertragByKundeDatum($this->getKunde(), $this->getDatumAbschluss()->format('Y-m-d'))) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns the cruser
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser cruser
     */
    public function getCruser()
    {
        return $this->cruser;
    }

    /**
     * Sets the cruser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser cruser
     */
    public function setCruser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser)
    {
        $this->cruser = $cruser;
    }
	
	 /**
     * Returns the datei
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getDatei()
    {
        return $this->datei;
    }

    /**
     * Sets the datei
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $datei
     * @return void
     */
    public function setDatei(\TYPO3\CMS\Extbase\Domain\Model\FileReference $datei)
    {
        $this->datei = $datei;
    }
}
