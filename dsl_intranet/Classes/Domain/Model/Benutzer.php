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
 * Benutzer
 */
class Benutzer extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{
	/**
     * disable
     * 
     * @var boolean
     */
    protected $disable;

    /**
     * mobilephone
     * 
     * @var string
     */
    protected $mobilephone;

    /**
     * settings
     *
     * @var string
     */
    protected $settings;

    /**
     * settingsHosting
     *
     * @var string
     */
    protected $settingsHosting;

    /**
     * geoeffneterAuftrag
     *
     * @var int
     */
    protected $geoeffneterAuftrag;

    /**
     * settingsAufgaben
     *
     * @var string
     */
    protected $settingsAufgaben;

    /**
     * settingsDateien
     *
     * @var string
     */
    protected $settingsDateien;

    /**
     * avatar
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $avatar;

    /**
     * settingsAgenturauftrag
     *
     * @var string
     */
    protected $settingsAgenturauftrag;

    /**
     * settingsAblage
     *
     * @var string
     */
    protected $settingsAblage;
	
	/**
     * settingsKanban
     * 
     * @var string
     */
    protected $settingsKanban;

    /**
     * settingsAllgemein
     *
     * @var string
     */
    protected $settingsAllgemein;

    /**
     * settingsKunden
     *
     * @var string
     */
    protected $settingsKunden;

    /**
     * offeneAuftraege
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege>
     */
    protected $offeneAuftraege;

    /**
     * ablage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Ablage>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $ablage;
	
	/**
     * Returns the mobilephone
     * 
     * @return string $mobilephone
     */
    public function getMobilephone()
    {
        return $this->mobilephone;
    }

    /**
     * Sets the mobilephone
     * 
     * @param string $mobilephone
     * @return void
     */
    public function setMobilephone(string $mobilephone)
    {
        $this->mobilephone = $mobilephone;
    }

    /**
     * Sets the disable status
     * 
     * @param bool $disable
     * @return void
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
    }

    /**
     * Returns the disable
     * 
     * @return bool $disable
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Returns the settings
     *
     * @return string
     */
    public function getSettings()
    {
         $filterArr = array();
        if ($this->settings) {
            $filterArr = unserialize($this->settings);
        }
        //if($filterArr["switch"]) unset($filterArr["switch"]);
        return $filterArr;
    }

    /**
     * Sets the settings
     *
     * @param string $settings
     * @return void
     */
    public function setSettings(string $settings)
    {
       if ($settings) {
            $this->settings = serialize($settings);
        } else {
            $this->settings = '';
        }
    }

    /**
     * Returns the settingsHosting
     *
     * @return string
     */
    public function getSettingsHosting()
    {
        $filterArr = array();
        if ($this->settingsHosting) {
            $filterArr = unserialize($this->settingsHosting);
        }
        //if($filterArr["switch"]) unset($filterArr["switch"]);
        return $filterArr;
    }

    /**
     * Sets the settingsHosting
     *
     * @param string $settingsHosting
     * @return void
     */
    public function setSettingsHosting(string $settingsHosting)
    {
        if ($settingsHosting) {
            $this->settingsHosting = serialize($settingsHosting);
        } else {
            $this->settingsHosting = '';
        }
    }

    /**
     * Returns the geoeffneterAuftrag
     *
     * @return int
     */
    public function getGeoeffneterAuftrag()
    {
        return $this->geoeffneterAuftrag;
    }

    /**
     * Sets the geoeffneterAuftrag
     *
     * @param int $geoeffneterAuftrag
     * @return void
     */
    public function setGeoeffneterAuftrag(int $geoeffneterAuftrag)
    {
        $this->geoeffneterAuftrag = $geoeffneterAuftrag;
    }

    /**
     * Returns the settingsAufgaben
     *
     * @return string
     */
    public function getSettingsAufgaben()
    {
         $filterArr = array();
        if ($this->settingsAufgaben) {
            $filterArr = unserialize($this->settingsAufgaben);
        }
        return $filterArr;
    }

    /**
     * Sets the settingsAufgaben
     *
     * @param string $settingsAufgaben
     * @return void
     */
    public function setSettingsAufgaben(string $settingsAufgaben)
    {
        if ($settingsAufgaben) {
            $this->settingsAufgaben = serialize($settingsAufgaben);
        } else {
            $this->settingsAufgaben = '';
        }
    }

    /**
     * Returns the settingsDateien
     *
     * @return string
     */
    public function getSettingsDateien()
    {
       $filterArr = array();
        if ($this->settingsDateien) {
            $filterArr = unserialize($this->settingsDateien);
        }
        return $filterArr;
    }

    /**
     * Sets the settingsDateien
     *
     * @param string $settingsDateien
     * @return void
     */
    public function setSettingsDateien(string $settingsDateien)
    {
        if ($settingsDateien) {
            $this->settingsDateien = serialize($settingsDateien);
        } else {
            $this->settingsDateien = '';
        }
    }

    /**
     * Returns the avatar
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Sets the avatar
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $avatar
     * @return void
     */
    public function setAvatar(\TYPO3\CMS\Extbase\Domain\Model\FileReference $avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Returns the settingsAgenturauftrag
     *
     * @return string
     */
    public function getSettingsAgenturauftrag()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');

        $filterArr = array();
        if ($this->settingsAgenturauftrag) {
            $jsonString = unserialize($this->settingsAgenturauftrag);
			if (is_array($jsonString)){
				$filterArr = $jsonString;
			}else{
				$filterArr = json_decode($jsonString, true);
			}
        }
        $filterArr = $filterArr ?? [];

        if (!isset($filterArr['start']) || !isset($filterArr['end'])) {
            $agenturvertraegeRange = $auftraegeRepository->getAgenturvertraegeRange();
			

            if (!isset($filterArr['start'])) {
                $filterArr['start'] = $agenturvertraegeRange['minDate']->format('d.m.Y');
            }
            if (!isset($filterArr['end'])) {
                $filterArr['end'] = $agenturvertraegeRange['maxDate']->format('d.m.Y');
            }
        }
        $tmp = new \DateTime($filterArr['end']);
        //$filterArr['statJahr'] = $tmp->format('Y');
        $now = new \DateTime();
        if ($tmp->format('Y') > $now->format('Y')) {
            $filterArr['statJahr'] = $now->format('Y');
        } else {
            $filterArr['statJahr'] = $tmp->format('Y');
        }
        //echo $filterArr['statJahr'];
        //die;
        return $filterArr;
    }

    /**
     * Sets the settingsAgenturauftrag
     *
     * @param string $settingsAgenturauftrag
     * @return void
     */
    public function setSettingsAgenturauftrag(string $settingsAgenturauftrag)
    {
         if ($settingsAgenturauftrag) {
            $this->settingsAgenturauftrag = serialize($settingsAgenturauftrag);
        } else {
            $this->settingsAgenturauftrag = '';
        }
    }

    /**
     * Returns the settingsAblage
     *
     * @return string
     */
    public function getSettingsAblage()
    {
       $filterArr = array();
        if ($this->settingsAblage) {
            $filterArr = unserialize($this->settingsAblage);
        }
        return $filterArr;
    }

    /**
     * Sets the settingsAblage
     *
     * @param string $settingsAblage
     * @return void
     */
    public function setSettingsAblage(string $settingsAblage)
    {
        if ($settingsAblage) {
            $this->settingsAblage = serialize($settingsAblage);
        } else {
            $this->settingsAblage = '';
        }
    }
	
	/**
     * Returns the settingsKanban
     *
     * @return string
     */
    public function getSettingsKanban()
    {
       $filterArr = array();
        if ($this->settingsKanban) {
            $filterArr = unserialize($this->settingsKanban);
        }
        return $filterArr;
    }

    /**
     * Sets the settingsKanban
     *
     * @param string $settingsKanban
     * @return void
     */
    public function setSettingsKanban(string $settingsAblage)
    {
        if ($settingsAblage) {
            $this->settingsKanban = serialize($settingsKanban);
        } else {
            $this->settingsKanban = '';
        }
    }

    /**
     * Returns the settingsAllgemein
     *
     * @return string
     */
    public function getSettingsAllgemein()
    {
        //return $this->settingsAllgemein;
		 $filterArr = array();
        if ($this->settingsAllgemein) {
            $filterArr = unserialize($this->settingsAllgemein);
        }
        return $filterArr;
    }

    /**
     * Sets the settingsAllgemein
     *
     * @param string $settingsAllgemein
     * @return void
     */
    public function setSettingsAllgemein(string $settingsAllgemein)
    {
        if ($settingsAllgemein) {
            $this->settingsAllgemein = serialize($settingsAllgemein);
        } else {
            $this->settingsAllgemein = '';
        }
    }

    /**
     * Returns the settingsKunden
     *
     * @return string
     */
    public function getSettingsKunden()
    {
        $filterArr = array();
        if ($this->settingsKunden) {
            $filterArr = unserialize($this->settingsKunden);
        }
        return $filterArr;
    }

    /**
     * Sets the settingsKunden
     *
     * @param string $settingsKunden
     * @return void
     */
    public function setSettingsKunden(string $settingsKunden)
    {
        if ($settingsKunden) {
            $this->settingsKunden = serialize($settingsKunden);
        } else {
            $this->settingsKunden = '';
        }
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
        $this->offeneAuftraege = $this->offeneAuftraege ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->ablage = $this->ablage ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Auftraege
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $offeneAuftraege
     * @return void
     */
    public function addOffeneAuftraege(\DslFactory\DslIntranet\Domain\Model\Auftraege $offeneAuftraege)
    {
        $this->offeneAuftraege->attach($offeneAuftraege);
    }

    /**
     * Removes a Auftraege
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $offeneAuftraegeToRemove The Auftraege to be removed
     * @return void
     */
    public function removeOffeneAuftraege(\DslFactory\DslIntranet\Domain\Model\Auftraege $offeneAuftraegeToRemove)
    {
        $this->offeneAuftraege->detach($offeneAuftraegeToRemove);
    }

    /**
     * Returns the offeneAuftraege
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege>
     */
    public function getOffeneAuftraege()
    {
        return $this->offeneAuftraege;
    }

    /**
     * Sets the offeneAuftraege
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege> $offeneAuftraege
     * @return void
     */
    public function setOffeneAuftraege(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $offeneAuftraege)
    {
        $this->offeneAuftraege = $offeneAuftraege;
    }

    /**
     * Adds a Ablage
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablage
     * @return void
     */
    public function addAblage(\DslFactory\DslIntranet\Domain\Model\Ablage $ablage)
    {
        $this->ablage->attach($ablage);
    }

    /**
     * Removes a Ablage
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablageToRemove The Ablage to be removed
     * @return void
     */
    public function removeAblage(\DslFactory\DslIntranet\Domain\Model\Ablage $ablageToRemove)
    {
        $this->ablage->detach($ablageToRemove);
    }

    /**
     * Returns the ablage
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Ablage>
     */
    public function getAblage()
    {
        return $this->ablage;
    }

    /**
     * Sets the ablage
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Ablage> $ablage
     * @return void
     */
    public function setAblage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ablage)
    {
        $this->ablage = $ablage;
    }
	
	/**
     * Insert a Ablage
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $newAblage
     * @return void
     */
    public function insertAblage(\DslFactory\DslIntranet\Domain\Model\Ablage $newAblage)
    {
        //return true;
        $oldArr = array();
        foreach ($this->ablage as $ablage) {
			if($ablage->getAuftrag()){
				if ($ablage->getAuftrag()->getUid()) {
					$oldArr[] = $ablage;
				}
			}
        }
        $this->setAblage(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
        $this->addAblage($newAblage);
        foreach ($oldArr as $ablage) {
            $this->addAblage($ablage);
        }
    }

    /**
     * Move a Ablage to Top
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablageToMove
     * @return void
     */
    public function moveAblageToTop(\DslFactory\DslIntranet\Domain\Model\Ablage $ablageToMove)
    {
        //return true;
        $oldArr = array();
        //echo $ablageToMove->getUid();
        foreach ($this->ablage as $ablage) {
            if ($ablageToMove->getUid() != $ablage->getUid()) {
                $oldArr[] = $ablage;
            }
        }
        $this->setAblage(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
        $this->addAblage($ablageToMove);
        foreach ($oldArr as $ablage) {
            $this->addAblage($ablage);
        }
    }

    /**
     * Move a Ablage after another
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablageToMove
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablageBefore
     * @return void
     */
    public function moveAblageAfter(\DslFactory\DslIntranet\Domain\Model\Ablage $ablageToMove, \DslFactory\DslIntranet\Domain\Model\Ablage $ablageBefore)
    {
        //return true;
        $oldArr = array();
        //echo $ablageToMove->getUid();
        foreach ($this->ablage as $ablage) {
            if ($ablageToMove->getUid() != $ablage->getUid()) {
                $oldArr[] = $ablage;
            }
        }
        $this->setAblage(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
        foreach ($oldArr as $ablage) {
            $this->addAblage($ablage);
            if ($ablage->getUid() == $ablageBefore->getUid()) {
                $this->addAblage($ablageToMove);
            }
        }
    }
}
