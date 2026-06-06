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
 * Fremdkosten
 */
class Fremdkosten extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * anzahl
     *
     * @var int
     */
    protected $anzahl;

    /**
     * name
     *
     * @var string
     */
    protected $name;

    /**
     * preis
     *
     * @var float
     */
    protected $preis;

    /**
     * Returns the anzahl
     *
     * @return int
     */
    public function getAnzahl()
    {
        return $this->anzahl;
    }

    /**
     * Sets the anzahl
     *
     * @param int $anzahl
     * @return void
     */
    public function setAnzahl(int $anzahl)
    {
        $this->anzahl = $anzahl;
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
}
