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
 * HostingDomains
 */
class HostingDomains extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * domainname
     *
     * @var string
     */
    protected $domainname;

    /**
     * sonderpreisMonatlich
     *
     * @var float
     */
    protected $sonderpreisMonatlich;

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
     * gekuendigtZum
     *
     * @var \DateTime
     */
    protected $gekuendigtZum;

    /**
     * oldid
     *
     * @var int
     */
    protected $oldid;

    /**
     * sonderlaufzeit
     *
     * @var int
     */
    protected $sonderlaufzeit;

    /**
     * tarif
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Tarife
     */
    protected $tarif;

    /**
     * rechnungen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $rechnungen;

    /**
     * cruser
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz = '';
    /**
     * Returns the domainname
     *
     * @return string
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * Sets the domainname
     *
     * @param string $domainname
     * @return void
     */
    public function setDomainname(string $domainname)
    {
        $this->domainname = $domainname;
    }

    /**
     * Returns the sonderpreisMonatlich
     *
     * @return float
     */
    public function getSonderpreisMonatlich()
    {
        return $this->sonderpreisMonatlich;
    }

    /**
     * Sets the sonderpreisMonatlich
     *
     * @param float $sonderpreisMonatlich
     * @return void
     */
    public function setSonderpreisMonatlich(float $sonderpreisMonatlich)
    {
        $this->sonderpreisMonatlich = $sonderpreisMonatlich;
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
        if ($this->vertragsbegin) {
            return $this->vertragsbegin;
        }
        return new \DateTime();
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
                //return $this->bezahltbis;
        if (!$this->bezahltbis) {
            return new \DateTime($this->getVertragsbegin()->format('Y-m-01'));
        }
        /*   if ($this->vertragsbegin > $this->bezahltbis) {
             return new \DateTime($this->vertragsbegin->format('Y-m-01'));
             }*/

        return new \DateTime($this->bezahltbis->format('Y-m-01'));
    }
	
	/**
     * Returns the bezahltbis
     * 
     * @return \DateTime bezahltbis
     */
    public function getFaelligmonat()
    {
        //return $this->bezahltbis;
        if (!$this->bezahltbis) {
			$dat = new \DateTime($this->getVertragsbegin()->format('Y-m-01'));
			//$dat->modify('-1 month');
			return $dat;
			
            //return new \DateTime($this->getVertragsbegin()->format('Y-m-01'));
        }
        /*   if ($this->vertragsbegin > $this->bezahltbis) {
             return new \DateTime($this->vertragsbegin->format('Y-m-01'));
             }*/
		$dat = new \DateTime($this->bezahltbis->format('Y-m-01'));
		//$dat->modify('-1 month');
		return $dat;
        //return new \DateTime($this->bezahltbis->format('Y-m-01'));
    }	

    /**
     * Sets the bezahltbis
     *
     * @param \DateTime $bezahltbis
     * @return void
     */
    public function setBezahltbis(\DateTime $bezahltbis)
    {
        $day = $bezahltbis->format('d');
        if ($day > 1) {
            date_sub($bezahltbis, date_interval_create_from_date_string($day - 1 . ' days'));
        }
        $bezahltbis->modify('+3 hours');
        $this->bezahltbis = $bezahltbis;
    }

    /**
     * Returns the boolean state of faellig
     *
     * @return bool
     */
    public function isFaellig()
    {
        $hostingUtility = \DslFactory\DslIntranet\Utility\HostingUtility::init();
        //$hosting = \DslFactory\DslIntranet\Utility\HostingUtility::init();
        return $hostingUtility->isFaellig($this->getBezahltbis());
    }

    /**
     * Returns the boolean state of faellig
     *
     * @return bool
     */
    public function isUeberFaellig()
    {
        $hostingUtility = \DslFactory\DslIntranet\Utility\HostingUtility::init();
        //$hosting = \DslFactory\DslIntranet\Utility\HostingUtility::init();
        return $hostingUtility->isUeberFaellig($this->getBezahltbis());
    }


    /**
     * Returns the gekuendigtZum
     *
     * @return \DateTime gekuendigtZum
     */
    public function getGekuendigtZum()
    {

        return $this->gekuendigtZum;

        if (!$this->gekuendigtZum) {
            return false;
        }
        /*   if ($this->vertragsbegin > $this->bezahltbis) {
             return new \DateTime($this->vertragsbegin->format('Y-m-01'));
             }*/

        // return new \DateTime($this->gekuendigtZum->format('Y-m-01'));
    }

    /**
     * Sets the gekuendigtZum
     *
     * @param \DateTime $gekuendigtZum
     * @return void
     */
    public function setGekuendigtZum(\DateTime $gekuendigtZum)
    {
        $day = $gekuendigtZum->format('d');
        if ($day > 1) {
            date_sub($gekuendigtZum, date_interval_create_from_date_string($day - 1 . ' days'));
        }
        $gekuendigtZum->modify('+3 hours');
        $this->gekuendigtZum = $gekuendigtZum;
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
     * Returns the sonderlaufzeit
     *
     * @return int
     */
    public function getSonderlaufzeit()
    {
        return $this->sonderlaufzeit;
    }

    /**
     * Sets the sonderlaufzeit
     *
     * @param int $sonderlaufzeit
     * @return void
     */
    public function setSonderlaufzeit(int $sonderlaufzeit)
    {
        $this->sonderlaufzeit = $sonderlaufzeit;
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
        $this->rechnungen = $this->rechnungen ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the tarif
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Tarife
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Sets the tarif
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Tarife $tarif
     * @return void
     */
    public function setTarif(\DslFactory\DslIntranet\Domain\Model\Tarife $tarif)
    {
        $this->tarif = $tarif;
    }

    /**
     * Adds a HostingTarifRechnungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungen
     * @return void
     */
    public function addRechnungen(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungen)
    {
        $this->rechnungen->attach($rechnungen);
    }

    /**
     * Removes a HostingTarifRechnungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungenToRemove The HostingTarifRechnungen to be removed
     * @return void
     */
    public function removeRechnungen(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungenToRemove)
    {
        $this->rechnungen->detach($rechnungenToRemove);
    }

    /**
     * Returns the rechnungen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen>
     */
    public function getRechnungen()
    {
        return $this->rechnungen;
    }

    /**
     * Sets the rechnungen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen> $rechnungen
     * @return void
     */
    public function setRechnungen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $rechnungen)
    {
        $this->rechnungen = $rechnungen;
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
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser cruser
     */
    public function setCruser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser)
    {
        $this->cruser = $cruser;
    }


    /**
     * Returns the notiz
     *
     * @return string $notiz
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
    public function setNotiz($notiz)
    {
        $this->notiz = $notiz;
    }
	
	/**
     * Returns the laufzeit
     * 
     * @return int $laufzeit
     */
    public function getLaufzeit()
    {
        if ($this->sonderlaufzeit) {
            return $this->sonderlaufzeit;
        } else {
            return $this->tarif->getLaufzeit();
        }
    }
	 /**
     * Returns the preisMonatlich
     * 
     * @return float $preisMonatlich
     */
    public function getPreisMonatlich()
    {
        if ($this->sonderpreisMonatlich) {
            return $this->sonderpreisMonatlich;
        }
        return $this->tarif->getPreisMonatlich();
    }
}
