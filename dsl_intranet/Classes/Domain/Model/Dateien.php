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
 * Dateien
 */
class Dateien extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	 /**
     * @var int
     */
    protected $crdate;

    /**
     * @var int
     */
    protected $tstamp;

    /**
     * kunden
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden
     */
    protected $kunden;

    /**
     * auftraege
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    protected $auftraege;

    /**
     * agenturvertraege
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Agenturvertraege
     */
    protected $agenturvertraege;


    /**
     * type
     *
     * @var int
     */
    protected $type;
	
	/**
     * iduser
     *
     * @var int
     */
    protected $iduser;

    /**
     * datei
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $datei;

    /**
     * titel
     *
     * @var string
     */
    protected $titel;

    /**
     * sichtbarkeit
     *
     * @var bool
     */
    protected $sichtbarkeit;

    /**
     * tempDateiName
     *
     * @var string
     */
    protected $tempDateiName;

    /**
     * tempDateiGroesse
     *
     * @var int
     */
    protected $tempDateiGroesse;

    /**
     * tempKundenName
     *
     * @var string
     */
    protected $tempKundenName;

    /**
     * tempType
     *
     * @var string
     */
    protected $tempType;

    /**
     * tempKundenNummer
     *
     * @var string
     */
    protected $tempKundenNummer;

    /**
     * tempTimestamp
     *
     * @var string
     */
    protected $tempTimestamp;

    /**
     * tempRechnungsnummer
     *
     * @var string
     */
    protected $tempRechnungsnummer;
	
	/**
     * Erstellt durch
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;
	
	
	/**
     * Returns the kunden
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     */
    public function getKunden()
    {
        if ($this->auftraege) {
            return $this->auftraege->getKunde();
        }
        if ($this->agenturvertraege) {
            return $this->agenturvertraege->getKunde();
        }
        return $this->kunden;
    }

    /**
     * Sets the kunden
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     * @return void
     */
    public function setKunden(\DslFactory\DslIntranet\Domain\Model\Kunden $kunden)
    {
        //um fehler beim sofortigen neu auslesen / zugriff zu beheben /// ein reines setzen funktioniert nicht // nur temporät
        $this->kunden = $kunden;
    }
	
	 /**
     * Returns the cruser
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser
     */
    public function getCruser()
    {
        return $this->cruser;
    }

	
	 /**
     * Sets the cruser
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser
     * @return void
     */
    public function setCruser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser)
    {
        $this->cruser = $cruser;
    }

    /**
     * Returns the type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param int $type
     * @return void
     */
    public function setType(int $type)
    {
        $this->type = $type;
        if (!$this->titel) {
            //if($type==30){ //rechnung
			if($this->getDateiName()){
				$pathInfo = pathinfo($this->getDateiName());
			}
        }
        $this->refreshTempVars();
    }
	
	/**
     * Returns the iduser
     *
     * @return int
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Sets the iduser
     *
     * @param int $iduser
     * @return void
     */
    public function setIduser(int $iduser)
    {
        $this->iduser = $iduser;
       
    }
	
	
	public function setDefaultType()
    {
        $this->setType(100);
        if ($this->datei) {
            $fileProperties = $this->datei->getOriginalResource()->getProperties();
            if ($fileProperties['mime_type'] == 'image/jpeg') {
                $this->setType(70);
            }
        }
    }
	
	/**
     * Returns the dateiName
     * 
     * @return string
     */
    public function getDateiName()
    {
        if ($this->datei) {
            if ($this->datei->getOriginalResource()) {
                return $this->datei->getOriginalResource()->getName();
            }
        } else {
            return $this->tempDateiName;
        }
        return '';
    }

	
	 /**
     * Returns the dateiNameOhneErweiterung
     * 
     * @return string
     */
    public function getDateiNameOhneErweiterung()
    {
		if($this->getDateiName()){
			$pathInfo = pathinfo($this->getDateiName());
			return $pathInfo['filename'];
		}
    }

    /**
     * Returns the dateiGroesse
     * 
     * @return string
     */
    public function getDateiGroesse()
    {
        if ($this->datei) {
            if ($this->datei->getOriginalResource()) {
                return $this->datei->getOriginalResource()->getSize();
            }
        }
        return 0;
    }

    /**
     * Returns the initialien of cruser
     * 
     * @return string
     */
    public function getInitialien()
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($user->isKunde()) {
            if ($user->getUid() == $this->cruser->getUid()) {
                return 'mir';
            }
        } else {
            if ($this->auftraege) {
                if ($this->auftraege->getKunde() == $this->cruser) {
                    return 'Kunde';
                }
            }
        }
        if ($this->cruser) {
            return $this->cruser->getInitialien();
        }
        return '';
    }

    /**
     * Returns the owner of upload
     * 
     * @return booleon
     */
    public function uploadDurchKunde()
    {
        if ($this->auftraege) {
            if ($this->auftraege->getKunde() == $this->cruser) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the owner of upload
     * 
     * @return booleon
     */
    public function getUploadDurchKunde()
    {
        return $this->uploadDurchKunde();
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
		$this->refreshTempVars();
    }

	 /**
     * Returns the auftraege
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function getAuftraege()
    {
        return $this->auftraege;
    }

    /**
     * Returns the kunden email
     * 
     * @return string $email
     */
    public function getKundenEmail()
    {
        if ($this->getKunden()) {
            if ($this->getKunden()->getEmail()) {
                return $this->getKunden()->getEmail();
            } else {
                if ($this->getKunden()->getQbEmail()) {
                    return $this->getKunden()->getQbEmail();
                }
            }
        }
        return false;
    }

    /**
     * Returns the kunden versandEmail
     * 
     * @return string $email
     */
    public function getKundenVersandEmail()
    {
        if ($this->getKunden()) {
            switch ($this->getType()) {
                case 20:    //Angebot
                    if ($this->getKunden()->getEmailAngebote()) {
                        return $this->getKunden()->getEmailAngebote();
                    } else {
                        if ($this->getKunden()->getQbEmail()) {
                            return $this->getKunden()->getQbEmail();
                        }
                    }
                    break;
                case 30:    //Rechnung
                    if ($this->getKunden()->getEmailRechnungen()) {
                        return $this->getKunden()->getEmailRechnungen();
                    } else {
                        if ($this->getKunden()->getQbEmail()) {
                            return $this->getKunden()->getQbEmail();
                        }
                    }
                    break;
            }
            if ($this->getKunden()->getEmail()) {
                return $this->getKunden()->getEmail();
            }
        }
        return false;
    }

    /**
     * Sets the auftraege
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     * @return void
     */
    public function setAuftraege(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege)
    {
        /*Um im Kundenbereich einen kurioser weise nicht möglichen zugriff nach dem upload zu gewähren*/
        $this->auftraege = $auftraege;
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
		$this->refreshTempVars();
    }
	
	public function refreshTempVars()
    {
        if (!$this->getKunden()) {

        } else {
            $this->tempKundenName = $this->getKunden()->getName();
            $this->tempKundenNummer = $this->getKunden()->getNummer();
        }
        $this->tempDateiName = $this->getDateiName();
		
        //$this->tempKundenName.=" R".$this->kunden;
        $this->tempDateiGroesse = $this->getDateiGroesse();
        if (!$this->type) {
            $this->tempType = '';
        } else {
            $this->tempType = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_dateien.kundentype.' . $this->type, 'dsl_intranet',[],'de');
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
	
	 /*dsl userrights*/
    public function getRights()
    {
        $rights = array(
            'edit' => false,
            'delete' => false,
            'mail' => false,
            'editTitle' => true
        );
        if ($this->auftraege) {
            $rights['delete'] = false;
            $rights['edit'] = false;
            $rights['mail'] = false;
            if ($this->auftraege->getSichtbarkeit()) {
                foreach ($this->getAuftraege()->getMitarbeiter() as $ma) {
                    if ($ma == $benutzer) {
                        $rights['mail'] = true;
                        $rights['delete'] = true;
                        $rights['edit'] = true;
                    }
                }
                if ($this->getAuftraege()->getAnsprechpartner() == $benutzer) {
                    $rights['mail'] = true;
                    $rights['delete'] = true;
                    $rights['edit'] = true;
                }
            }
        } else {

        }
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if (method_exists($benutzer, 'getRechteAdminDownloadcenter')) {
            if ($benutzer->getRechteAdminDownloadcenter()) {
                $rights['delete'] = true;
                $rights['edit'] = true;
                $rights['mail'] = true;
            }
        }
        if (method_exists($benutzer, 'getRechteAdminAuftraege')) {
            if ($benutzer->getRechteAdminAuftraege()) {
                $rights['delete'] = true;
                $rights['edit'] = true;
                $rights['mail'] = true;
            }
        }
        if ($benutzer->isKunde()) {
            //wenn der eingeloggte Benutzer ein Kunde ist
            if ($this->cruser->getUid() == $benutzer->getUid()) {
                $rights['delete'] = true;
                $rights['edit'] = true;
            } else {
                $rights['editTitle'] = false;
            }
        } else {
            if (!$rights['edit']) {
                $rights['editTitle'] = false;
            }
            if ($this->auftraege) {
                if ($this->auftraege->getKunde() == $this->cruser) {
                    $rights['editTitle'] = false;
                }
            }
        }
        if ($this->cruser) {
            if ($this->cruser->isKunde() && $this->cruser->getUid() != $benutzer->getUid()) {
                $rights['editTitle'] = false;
            }
        }
        //if($this->cruser->isKunde() || !$rights['edit']) $rights['editTitle'] = false;
        /*
        
        if(!$mitarbeiter->isKunde()) {
        	if($this->auftraege->getKunde()==$this->cruser) return 'Kunde';
        }
        */

        if ($this->type == 40) {
            //bei lr angeboten
            $rights['mail'] = false;
        }
        return $rights;
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
	
	public function toggleSichtbarkeit()
    {
        if ($this->sichtbarkeit) {
            $this->sichtbarkeit = 0;
        } else {
            $this->sichtbarkeit = 1;
        }
    }
	
	public function getShowBtnToggleSichtbarkeit()
    {
        if ($this->type == 40) {
            return false;
        }
        //bei LR angeboten
        $rights = $this->getRights();
        if (!$rights['edit']) {
            //angelegt oder statuswechsel oder kundenkommentar
            return false;
        }
        //if($this->kundeninfoSichtbarkeit())
        //return false;
        return true;
    }
	
	/**
     * Returns the kundeninfoTime
     * 
     * @return \DateTime $kundeninfoTime
     */
    public function getKundeninfoTime()
    {
        $kundeninfoTime = new \DateTime();
        return $kundeninfoTime;
    }
	
	 /**
     * Returns the typeName
     * 
     * @return string
     */
    public function getTypeName()
    {
        $types = $this->getTypes();
        return $types[$this->type];
    }
	
	/**
     * Returns the types
     * 
     * @return mixed
     */
    public function getTypes()
    {
        $types = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['type']['config']['items'] as $type) {
            //vorbereitet durch kunde angelegt status rauslassen
            $types[$type[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_dateien.type.' . $type[1], 'dsl_intranet',[],'de');
        }
        return $types;
    }
	
	 /**
     * Returns the last Protokoll
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Protokolle
     */
    public function getProtokoll()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $protokolleRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
        $protokolle = $protokolleRepository->findByDateien($this)->getFirst();
        return $protokolle;
    }

    /**
     * Returns the last log
     * 
     * @return \BravoBuero\BbDownloadlog\Domain\Model\Entry
     */
    public function getLastDownloadLog()
    {
        $groupUidForKundenLogin = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('groupUidForKundenLogin');
        //$groupUidForKundenLogin = 2;
        if ($logs = $this->getDownloadLogs()) {
            foreach ($logs as $log) {
                if ($this->uploadDurchKunde()) {
                    if (!in_array($groupUidForKundenLogin, explode(',', $log->getFeusergroups()))) {
                        return $log;
                    }
                } else {
                    if (in_array($groupUidForKundenLogin, explode(',', $log->getFeusergroups()))) {
                        return $log;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Returns the downloads
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbDownloadlog\Domain\Model\Entry> $downloadLogs
     */
    public function getDownloadLogs()
    {
        if (!$this->datei) {
            return false;
        }
		
		
		
        $properties = $this->datei->getOriginalResource()->getOriginalFile()->getProperties();
        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($properties['uid']);
		//die();
		if (!intval($properties['uid'])) {
            return false;
        }
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $downloadlogRepository = $objectManager->get('BravoBuero\\BbDownloadlog\\Domain\\Repository\\EntryRepository');

        return $logs = $downloadlogRepository->findByFileUid($properties['uid']);
    }

    /**
     * Returns the tempDateiName
     *
     * @return string
     */
    public function getTempDateiName()
    {
        return $this->tempDateiName;
    }

    /**
     * Sets the tempDateiName
     *
     * @param string $tempDateiName
     * @return void
     */
    public function setTempDateiName(string $tempDateiName)
    {
        $this->tempDateiName = $tempDateiName;
    }

    /**
     * Returns the tempDateiGroesse
     *
     * @return int
     */
    public function getTempDateiGroesse()
    {
        return $this->tempDateiGroesse;
    }

    /**
     * Sets the tempDateiGroesse
     *
     * @param int $tempDateiGroesse
     * @return void
     */
    public function setTempDateiGroesse(int $tempDateiGroesse)
    {
        $this->tempDateiGroesse = $tempDateiGroesse;
    }

    /**
     * Returns the tempKundenName
     *
     * @return string
     */
    public function getTempKundenName()
    {
        return $this->tempKundenName;
    }

    /**
     * Sets the tempKundenName
     *
     * @param string $tempKundenName
     * @return void
     */
    public function setTempKundenName(string $tempKundenName)
    {
        $this->tempKundenName = $tempKundenName;
    }

    /**
     * Returns the tempType
     *
     * @return string
     */
    public function getTempType()
    {
        return $this->tempType;
    }

    /**
     * Sets the tempType
     *
     * @param string $tempType
     * @return void
     */
    public function setTempType(string $tempType)
    {
        $this->tempType = $tempType;
    }

    /**
     * Returns the tempKundenNummer
     *
     * @return string
     */
    public function getTempKundenNummer()
    {
        return $this->tempKundenNummer;
    }

    /**
     * Sets the tempKundenNummer
     *
     * @param string $tempKundenNummer
     * @return void
     */
    public function setTempKundenNummer(string $tempKundenNummer)
    {
        $this->tempKundenNummer = $tempKundenNummer;
    }

    /**
     * Returns the tempTimestamp
     *
     * @return string
     */
    public function getTempTimestamp()
    {
        return $this->tempTimestamp;
    }

    /**
     * Sets the tempTimestamp
     *
     * @param string $tempTimestamp
     * @return void
     */
    public function setTempTimestamp(string $tempTimestamp)
    {
        $this->tempTimestamp = $tempTimestamp;
    }

    /**
     * Returns the tempRechnungsnummer
     *
     * @return string
     */
    public function getTempRechnungsnummer()
    {
        return $this->tempRechnungsnummer;
    }

    /**
     * Sets the tempRechnungsnummer
     *
     * @param string $tempRechnungsnummer
     * @return void
     */
    public function setTempRechnungsnummer(string $tempRechnungsnummer)
    {
        $this->tempRechnungsnummer = $tempRechnungsnummer;
    }
	
	 /**
     * Returns the crdate
     * 
     * @return int
     */
    public function getCrdate()
    {
        if (!$this->crdate) {
            $now = new \DateTime();
            return $now->getTimestamp();
        }
        return $this->crdate;
    }

    /**
     * Returns the tstamp
     * 
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Returns the agenturvertraege
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertraege
     */
    public function getAgenturvertraege()
    {
        return $this->agenturvertraege;
    }
}
