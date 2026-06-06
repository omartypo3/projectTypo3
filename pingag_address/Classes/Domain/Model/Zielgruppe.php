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
class Zielgruppe extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * zielgruppe
     *
     * @var string
     */
    protected $zielgruppe = '';



    /**
     * Returns the zielgruppe
     *
     * @return string
     */
    public function getZielgruppe()
    {
        return $this->zielgruppe;
    }

    /**
     * Sets the zielgruppe
     *
     * @param string $zielgruppe
     * @return void
     */
    public function setZielgruppe(string $zielgruppe)
    {
        $this->zielgruppe = $zielgruppe;
    }
}
