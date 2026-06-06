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
 * KundenDateien
 */
class KundenDateien extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * @var int
     */
    protected $crdate;

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
     * type
     * 
     * @var int
     */
    protected $type;

    /**
     * datei
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
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
     * Erstellt durch
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

    /**
     * tempRechnungsnummer
     * 
     * @var string
     */
    protected $tempRechnungsnummer;

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
        return $this->kunden;
    }

    /**
     * Returns the type
     * 
     * @return integer $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     * 
     * @param integer $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->refreshTempVars();
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
     * Returns the datei
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $datei
     */
    public function getDatei()
    {
        return $this->datei;
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
        if ($this->datei) {
            if ($this->datei->getOriginalResource()) {
                $pathInfo = pathinfo($this->datei->getOriginalResource()->getName());
                return $pathInfo['filename'];
            }
        }
        return '';
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
            return $this->getKunden()->getEmail();
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
        $this->refreshTempVars();
    }

    /**
     * Returns the sichtbarkeit
     * 
     * @return bool $sichtbarkeit
     */
    public function getSichtbarkeit()
    {
        return $this->sichtbarkeit;
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

    /*dsl userrights*/
    public function getRights()
    {
        $rights = array(
            'edit' => false,
            'delete' => false,
            'mail' => false,
            'editTitle' => true
        );
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($this->auftraege) {
            $rights['delete'] = false;
            $rights['edit'] = false;
            $rights['mail'] = false;
        } else {

        }
        if ($benutzer->isKunde()) {
            if ($this->cruser == $benutzer) {
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
        if ($this->type == 40) {
            //bei lr angeboten
            $rights['mail'] = false;
        }
        return $rights;
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
        if (!intval($properties['uid'])) {
            return false;
        }
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $downloadlogRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\DownloadlogRepository');
  
        return $logs = $downloadlogRepository->findByFileUid($properties['uid']);
    }

    /**
     * Returns the tempDateiName
     * 
     * @return string $tempDateiName
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
    public function setTempDateiName($tempDateiName)
    {
        $this->tempDateiName = $tempDateiName;
    }

    /**
     * Returns the tempDateiGroesse
     * 
     * @return int $tempDateiGroesse
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
    public function setTempDateiGroesse($tempDateiGroesse)
    {
        $this->tempDateiGroesse = $tempDateiGroesse;
    }

    /**
     * Returns the tempKundenName
     * 
     * @return string $tempKundenName
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
    public function setTempKundenName($tempKundenName)
    {
        $this->tempKundenName = $tempKundenName;
    }

    /**
     * Returns the tempType
     * 
     * @return string $tempType
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
    public function setTempType($tempType)
    {
        $this->tempType = $tempType;
    }

    /**
     * Returns the tempKundenNummer
     * 
     * @return string $tempKundenNummer
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
    public function setTempKundenNummer($tempKundenNummer)
    {
        $this->tempKundenNummer = $tempKundenNummer;
    }

    /**
     * Returns the tempTimestamp
     * 
     * @return string $tempTimestamp
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
    public function setTempTimestamp($tempTimestamp)
    {
        $this->tempTimestamp = $tempTimestamp;
    }

    /**
     * Returns the tempRechnungsnummer
     * 
     * @return string $tempRechnungsnummer
     */
    public function getTempRechnungsnummer()
    {
        return $this->tempRechnungsnummer;
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
     * agenturvertraege
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege
     */
    protected $agenturvertraege;

	
	/**
     * Returns the agenturvertraege
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $agenturvertraege
     */
    public function getAgenturvertraege()
    {
        return $this->agenturvertraege;
    }
}
