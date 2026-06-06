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
 * HostingTarifRechnungen
 */
class HostingTarifRechnungen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * von
     *
     * @var \DateTime
     */
    protected $von;

    /**
     * bis
     *
     * @var \DateTime
     */
    protected $bis;

    /**
     * preis
     *
     * @var float
     */
    protected $preis;

    /**
     * tarif
     *
     * @var string
     */
    protected $tarif;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * domainname
     *
     * @var string
     */
    protected $domainname;
	
	/**
     * cruser
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

    /**
     * Returns the von
     *
     * @return \DateTime
     */
    public function getVon()
    {
        return $this->von;
    }

    /**
     * Sets the von
     *
     * @param \DateTime $von
     * @return void
     */
    public function setVon(\DateTime $von)
    {
        $this->von = $von;
    }

    /**
     * Returns the bis
     *
     * @return \DateTime
     */
    public function getBis()
    {
        return $this->bis;
    }

    /**
     * Sets the bis
     *
     * @param \DateTime $bis
     * @return void
     */
    public function setBis(\DateTime $bis)
    {
        $this->bis = $bis;
    }

    /**
     * Returns the preis
     *
     * @return float
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
    public function setPreis(float $preis)
    {
        $this->preis = $preis;
    }

    /**
     * Returns the tarif
     *
     * @return string
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Sets the tarif
     *
     * @param string $tarif
     * @return void
     */
    public function setTarif(string $tarif)
    {
        $this->tarif = $tarif;
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

}
