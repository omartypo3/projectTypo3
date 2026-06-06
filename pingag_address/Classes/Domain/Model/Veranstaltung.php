<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Model;


/**
 * This file is part of the "pingagaddress" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */

/**
 * Map
 */
class Veranstaltung extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * veranstaltung
     *
     * @var string
     */
    protected $veranstaltung = '';



    /**
     * Returns the veranstaltung
     *
     * @return string
     */
    public function getVeranstaltung()
    {
        return $this->veranstaltung;
    }

    /**
     * Sets the veranstaltung
     *
     * @param string $veranstaltung
     * @return void
     */
    public function setVeranstaltung(string $veranstaltung)
    {
        $this->veranstaltung = $veranstaltung;
    }
}
