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
 * Wartungsvertraege
 */
class Wartungsvertraege extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * titel
     *
     * @var string
     */
    protected $titel;

    /**
     * beschreibung
     *
     * @var string
     */
    protected $beschreibung;

    /**
     * gekuendigt
     *
     * @var bool
     */
    protected $gekuendigt;

    /**
     * vertragsbegin
     *
     * @var \DateTime
     */
    protected $vertragsbegin;

    /**
     * bezahltbis
     *
     * @var \DateTime
     */
    protected $bezahltbis;

    /**
     * laufzeit
     *
     * @var int
     */
    protected $laufzeit;

    /**
     * preisMonatlich
     *
     * @var float
     */
    protected $preisMonatlich;

    /**
     * reIntervall
     *
     * @var int
     */
    protected $reIntervall;

    /**
     * stundenProJahr
     *
     * @var int
     */
    protected $stundenProJahr;

    /**
     * sichtbarkeit
     *
     * @var bool
     */
    protected $sichtbarkeit;

    /**
     * preisMehraufwandStunde
     *
     * @var float
     */
    protected $preisMehraufwandStunde;

    /**
     * oldid
     *
     * @var int
     */
    protected $oldid;

    /**
     * kuendigungsFrist
     *
     * @var int
     */
    protected $kuendigungsFrist;

    /**
     * kunde
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden
     */
    protected $kunde;

    /**
     * optionen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen>
     */
    protected $optionen;
	
	/**
     * cruser
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

    /**
     * zeitraeume
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $zeitraeume;
	
	/**
     * wartungsvertraegeZeitraeumeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository
     */
    protected $wartungsvertraegeZeitraeumeRepository;

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
     * Returns the gekuendigt
     *
     * @return bool
     */
    public function getGekuendigt()
    {
        return $this->gekuendigt;
    }

    /**
     * Sets the gekuendigt
     *
     * @param bool $gekuendigt
     * @return void
     */
    public function setGekuendigt(bool $gekuendigt)
    {
        $this->gekuendigt = $gekuendigt;
    }

    /**
     * Returns the boolean state of gekuendigt
     *
     * @return bool
     */
    public function isGekuendigt()
    {
        return $this->gekuendigt;
    }

    /**
     * Returns the vertragsbegin
     *
     * @return \DateTime
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
        $vertragsbegin->modify('+3 hours');
        $this->vertragsbegin = $vertragsbegin;
    }

    /**
     * Returns the bezahltbis
     *
     * @return \DateTime
     */
    public function getBezahltbis()
    {
        return $this->bezahltbis;
    }

    /**
     * Sets the bezahltbis
     *
     * @param \DateTime $bezahltbis
     * @return void
     */
    public function setBezahltbis(\DateTime $bezahltbis)
    {
        $bezahltbis->modify('+3 hours');
        $this->bezahltbis = $bezahltbis;
    }

    /**
     * Returns the laufzeit
     *
     * @return int
     */
    public function getLaufzeit()
    {
        return $this->laufzeit;
    }

    /**
     * Sets the laufzeit
     *
     * @param int $laufzeit
     * @return void
     */
    public function setLaufzeit(int $laufzeit)
    {
        $this->laufzeit = $laufzeit;
    }

    /**
     * Returns the preisMonatlich
     *
     * @return float
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
    public function setPreisMonatlich(float $preisMonatlich)
    {
        $this->preisMonatlich = $preisMonatlich;
    }

    /**
     * Returns the reIntervall
     *
     * @return int
     */
    public function getReIntervall()
    {
        return $this->reIntervall;
    }

    /**
     * Sets the reIntervall
     *
     * @param int $reIntervall
     * @return void
     */
    public function setReIntervall(int $reIntervall)
    {
        $this->reIntervall = $reIntervall;
    }

    /**
     * Returns the stundenProJahr
     *
     * @return int
     */
    public function getStundenProJahr()
    {
        return $this->stundenProJahr;
    }

    /**
     * Sets the stundenProJahr
     *
     * @param int $stundenProJahr
     * @return void
     */
    public function setStundenProJahr(int $stundenProJahr)
    {
        $this->stundenProJahr = $stundenProJahr;
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
     * Returns the preisMehraufwandStunde
     *
     * @return float
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
    public function setPreisMehraufwandStunde(float $preisMehraufwandStunde)
    {
        $this->preisMehraufwandStunde = $preisMehraufwandStunde;
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

    /**
     * Returns the kuendigungsFrist
     *
     * @return int
     */
    public function getKuendigungsFrist()
    {
        return $this->kuendigungsFrist;
    }

    /**
     * Sets the kuendigungsFrist
     *
     * @param int $kuendigungsFrist
     * @return void
     */
    public function setKuendigungsFrist(int $kuendigungsFrist)
    {
        $this->kuendigungsFrist = $kuendigungsFrist;
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
        $this->optionen = $this->optionen ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->zeitraeume = $this->zeitraeume ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Adds a WartungsvertraegeOptionen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $optionen
     * @return void
     */
    public function addOptionen(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $optionen)
    {
        $this->optionen->attach($optionen);
    }

    /**
     * Removes a WartungsvertraegeOptionen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $optionenToRemove The WartungsvertraegeOptionen to be removed
     * @return void
     */
    public function removeOptionen(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $optionenToRemove)
    {
        $this->optionen->detach($optionenToRemove);
    }

    /**
     * Returns the optionen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen>
     */
    public function getOptionen()
    {
        return $this->optionen;
    }

    /**
     * Sets the optionen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen> $optionen
     * @return void
     */
    public function setOptionen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $optionen)
    {
        $this->optionen = $optionen;
    }

    /**
     * Adds a WartungsvertraegeZeitraeume
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $zeitraeume
     * @return void
     */
    public function addZeitraeume(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $zeitraeume)
    {
        $this->zeitraeume->attach($zeitraeume);
    }

    /**
     * Removes a WartungsvertraegeZeitraeume
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $zeitraeumeToRemove The WartungsvertraegeZeitraeume to be removed
     * @return void
     */
    public function removeZeitraeume(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $zeitraeumeToRemove)
    {
        $this->zeitraeume->detach($zeitraeumeToRemove);
    }

    /**
     * Returns the zeitraeume
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume>
     */
    public function getZeitraeume()
    {
        return $this->zeitraeume;
    }
	
	 /**
     * Returns the zeitraeume sortiert
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume> $zeitraeume
     */
    public function getZeitraeumeSorted()
    {
        if (!$this->wartungsvertraegeZeitraeumeRepository) {
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $this->wartungsvertraegeZeitraeumeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeZeitraeumeRepository');
        }
        return $this->wartungsvertraegeZeitraeumeRepository->findByWartungsvertrag($this);
    }

    /**
     * Sets the zeitraeume
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume> $zeitraeume
     * @return void
     */
    public function setZeitraeume(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $zeitraeume)
    {
        $this->zeitraeume = $zeitraeume;
    }

    /**
     * Returns the zeitraum aktuell
     *
     * @return \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume|bool $zeitraum
     */
    public function getZeitraumAktiv()
    {
        $zeitraeume = $this->getZeitraeumeSorted();
        if (is_array($zeitraeume) || $zeitraeume instanceof \Traversable) {
            foreach ($zeitraeume as $zeitraum) {
                return $zeitraum;
            }
        }
        return false;
    }
	
	/**
     * Returns the kontingent
     * 
     * @return int $kontingent
     */
    public function getKontingent()
    {
        $laufzeit = $this->getLaufzeit() / 10;
        $kontingent = $this->getStundenProJahr() / 12 * $laufzeit * 60;
        return $kontingent;
    }

    /**
     * Returns the kontingent
     * 
     * @return array $kontingentSet
     */
    public function getKontingentSet()
    {
        $stunden = floor($this->getKontingent() / 60);
        $minuten = $this->getKontingent() - $stunden * 60;
        return array('stunden' => $stunden, 'minuten' => $minuten);
    }

    /*dsl userrights*/
    public function getRights()
    {
        $rights = array(
            'edit' => true,
            'delete' => true
        );
        /*
        		$mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        	if($this->getAnsprechpartner()==$mitarbeiter) {
        			$rights['delete'] = true;
        			$rights['edit'] = true;
        		}
        		foreach($this->getMitarbeiter() as $ma) if($ma==$mitarbeiter) {
        			$rights['delete'] = true;
        			$rights['edit'] = true;
        		}
        		if($mitarbeiter->getRechteAdminAuftraege()){
        			$rights['delete'] = true;
        			$rights['edit'] = true;
        		}
        */

        return $rights;
    }

    public function toggleSichtbarkeit()
    {
        if ($this->sichtbarkeit) {
            $this->sichtbarkeit = 0;
        } else {
            $this->sichtbarkeit = 1;
        }
    }

    public function getOffeneRechnungen()
    {
        $counter = 0;
        if ($this->getZeitraeume()) {
            foreach ($this->getZeitraeume() as $zeitraum) {
                if ($zeitraum->getRechnungen()) {
                    foreach ($zeitraum->getRechnungen() as $rechnung) {
                        if ($rechnung->getStatus() == 20) {
                            $counter++;
                        }
                        if ($rechnung->getType() == 20 && $zeitraum->getStatus() == 20) {
                            $counter++;
                        }
                    }
                }
            }
        }
        return $counter;
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
}
