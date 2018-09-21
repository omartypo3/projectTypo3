<?php
namespace J77\J77products\Domain\Model;

/***
 *
 * This file is part of the "Produkte" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * WeitereAnforderungen
 */
class WeitereAnforderungen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * element
     *
     * @var int
     */
    protected $sorting = 0;

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * wert
     *
     * @var string
     */
    protected $wert = '';

    /**
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @param int $sorting
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }

    /**
     * Returns the name
     *
     * @return string $name
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the wert
     *
     * @return string $wert
     */
    public function getWert()
    {
        return $this->wert;
    }

    /**
     * Sets the wert
     *
     * @param string $wert
     * @return void
     */
    public function setWert($wert)
    {
        $this->wert = $wert;
    }
}
