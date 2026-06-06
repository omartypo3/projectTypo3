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
class Kursthemen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * kursthemen
     *
     * @var string
     */
    protected $kursthemen = '';



    /**
     * Returns the kursthemen
     *
     * @return string
     */
    public function getKursthemen()
    {
        return $this->kursthemen;
    }

    /**
     * Sets the kursthemen
     *
     * @param string $kursthemen
     * @return void
     */
    public function setKursthemen(string $kursthemen)
    {
        $this->kursthemen = $kursthemen;
    }
}
