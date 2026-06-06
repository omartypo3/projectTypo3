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
 * AuftraegeTexte
 */
class AuftraegeTexte extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * auftraege
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    protected $auftraege;

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
     * sichtbarkeit
     *
     * @var bool
     */
    protected $sichtbarkeit;

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
     * Returns the auftraege
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function getAuftraege()
    {
        return $this->auftraege;
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
	
	public function toggleSichtbarkeit()
    {
        if ($this->sichtbarkeit) {
            $this->sichtbarkeit = 0;
        } else {
            $this->sichtbarkeit = 1;
        }
    }
}
