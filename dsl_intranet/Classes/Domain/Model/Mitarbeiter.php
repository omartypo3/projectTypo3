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
 * Mitarbeiter
 */
class Mitarbeiter extends \DslFactory\DslIntranet\Domain\Model\Benutzer
{

    /**
     * mobilephone
     *
     * @var string
     */
    protected $mobilephone;

    /**
     * spitzname
     *
     * @var string
     */
    protected $spitzname;

    /**
     * initialien
     *
     * @var string
     */
    protected $initialien;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * arbeitsbegin
     *
     * @var int
     */
    protected $arbeitsbegin;

    /**
     * arbeitsende
     *
     * @var int
     */
    protected $arbeitsende;

    /**
     * autostop
     *
     * @var int
     */
    protected $autostop;

    /**
     * farbe
     *
     * @var string
     */
    protected $farbe;

    /**
     * rechte
     *
     * @var string
     */
    protected $rechte;

    /**
     * urlaubstageProJahr
     *
     * @var int
     */
    protected $urlaubstageProJahr;

    /**
     * urlaubstageVerbraucht
     *
     * @var int
     */
    protected $urlaubstageVerbraucht;

    /**
     * Returns true if is mitarbeiter
     *
     * @return boolean
     */
    public function isMitarbeiter()
    {
        return true;
    }

    /**
     * Returns true if is kunde
     *
     * @return boolean
     */
    public function isKunde()
    {
        return false;
    }

    /**
     * Returns the mobilephone
     *
     * @return string
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
     * Returns the spitzname
     *
     * @return string
     */
    public function getSpitzname()
    {
        return $this->spitzname;
    }

    /**
     * Sets the spitzname
     *
     * @param string $spitzname
     * @return void
     */
    public function setSpitzname(string $spitzname)
    {
        $this->spitzname = $spitzname;
    }

    /**
     * Returns the initialien
     *
     * @return string
     */
    public function getInitialien()
    {
        return $this->initialien;
    }

    /**
     * Sets the initialien
     *
     * @param string $initialien
     * @return void
     */
    public function setInitialien(string $initialien)
    {
        $this->initialien = $initialien;
    }

    /**
     * Returns the notiz
     *
     * @return string
     */
    public function getNotiz()
    {
        return $this->notiz;
    }

    /**
     * Sets the notiz
     *
     * @param string $notiz
     * @return void
     */
    public function setNotiz(string $notiz)
    {
        $this->notiz = $notiz;
    }

    /**
     * Returns the arbeitsbegin
     *
     * @return int
     */
    public function getArbeitsbegin()
    {
        if ($this->arbeitsbegin) {
            return $this->arbeitsbegin;
        }
        $configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];
        return $settings['defaultMitarbeiterArbeitsbegin'];
    }

    /**
     * Sets the arbeitsbegin
     *
     * @param int $arbeitsbegin
     * @return void
     */
    public function setArbeitsbegin(int $arbeitsbegin)
    {
        $this->arbeitsbegin = $arbeitsbegin;
    }

    /**
     * Returns the arbeitsende
     *
     * @return int
     */
    public function getArbeitsende()
    {
        if ($this->arbeitsende) {
            return $this->arbeitsende;
        }
        $configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];
        return $settings['defaultMitarbeiterArbeitsende'];
    }

    /**
     * Sets the arbeitsende
     *
     * @param int $arbeitsende
     * @return void
     */
    public function setArbeitsende(int $arbeitsende)
    {
        $this->arbeitsende = $arbeitsende;
    }

    /**
     * Returns the autostop
     *
     * @return int
     */
    public function getAutostop()
    {
        if ($this->autostop) {
            return $this->autostop;
        }
        $configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];
        return $settings['defaultMitarbeiterAutostop'];
    }

    /**
     * Sets the autostop
     *
     * @param int $autostop
     * @return void
     */
    public function setAutostop(int $autostop)
    {
        $this->autostop = $autostop;
    }

    /**
     * Returns the farbe
     *
     * @return string
     */
    public function getFarbe()
    {
        return $this->farbe;
    }

    /**
     * Sets the farbe
     *
     * @param string $farbe
     * @return void
     */
    public function setFarbe(string $farbe)
    {
        $this->farbe = $farbe;
    }

    /**
     * Returns the rechte
     *
     * @return string
     */
    public function getRechte()
    {
        return $this->rechte;
    }

    /**
     * @return boolean
     */
    public function getRechteUrlaubsManager()
    {
        if (in_array(10, explode(',', $this->rechte))) {
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function getRechteMitarbeiterManager()
    {
        if (in_array(20, explode(',', $this->rechte))) {
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function getRechteRechnungslegung()
    {
        if (in_array(30, explode(',', $this->rechte))) {
            return true;
        }
        return false;
    }

    /**
     * Sets the rechte
     *
     * @param string $rechte
     * @return void
     */
    public function setRechte(string $rechte)
    {
        $this->rechte = $rechte;
    }

    /**
     * Returns the urlaubstageProJahr
     *
     * @return int
     */
    public function getUrlaubstageProJahr()
    {
        return $this->urlaubstageProJahr;
    }

    /**
     * Sets the urlaubstageProJahr
     *
     * @param int $urlaubstageProJahr
     * @return void
     */
    public function setUrlaubstageProJahr(int $urlaubstageProJahr)
    {
        $this->urlaubstageProJahr = $urlaubstageProJahr;
    }

    /**
     * Returns the urlaubstageVerbraucht
     *
     * @return int
     */
    public function getUrlaubstageVerbraucht()
    {
        return $this->urlaubstageVerbraucht;
    }

    /**
     * Sets the urlaubstageVerbraucht
     *
     * @param int $urlaubstageVerbraucht
     * @return void
     */
    public function setUrlaubstageVerbraucht(int $urlaubstageVerbraucht)
    {
        $this->urlaubstageVerbraucht = $urlaubstageVerbraucht;
    }

    /**
     * @param $auftraege
     */
    public function checkValidFegroupChange($auftraege = false)
    {
        if (!$auftraege) {
            $auftraege = $this->getOffeneAuftraege();
        }
        $mGroupsArr = array();
        $mFegroups = $this->getUsergroup();
        foreach ($mFegroups as $mFegroup) {
            $mGroupsArr[] = $mFegroup->getUid();
        }
        $verbleibendArr = array();
        foreach ($auftraege as $auftrag) {
            if ($auftrag->getUid()) {
                foreach ($auftrag->getFegroups() as $aFegroup) {
                    if (in_array($aFegroup->getUid(), $mGroupsArr)) {
                        $verbleibendArr[] = $auftrag;
                    }
                }
            }
        }
        if (count($verbleibendArr) != count($auftraege)) {
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $mitarbeiterRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
            $this->setOffeneAuftraege($objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            foreach ($verbleibendArr as $auftrag) {
                $this->addOffeneAuftraege($auftrag);
            }
            $mitarbeiterRepository->update($this);
            $changeInOffeneAuftraege = true;
            $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function getRechteAdminAuftraege()
    {
        if (in_array(40, explode(',', $this->rechte))) {
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function getRechteExternerMitarbeiter()
    {
        if (in_array(60, explode(',', $this->rechte))) {
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function getRechteAdminDownloadcenter()
    {
        if (in_array(50, explode(',', $this->rechte))) {
            return true;
        }
        return false;
    }

    /**
     * kanban
     *
     * @var \DslFactory\DslKanban\Domain\Model\Kanban
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $kanban = null;


    /**
     * Returns the Kanban
     *
     * @return \DslFactory\DslKanban\Domain\Model\Kanban kanban
     */
    public function getKanban()
    {
        return $this->kanban;
    }


    /**
     * Sets the kanban
     *
     * @param \DslFactory\DslKanban\Domain\Model\Kanban $kanban
     * @return void
     */
    public function setKanban(\DslFactory\DslKanban\Domain\Model\Kanban $kanban)
    {
        $this->kanban = $kanban;
    }
}
