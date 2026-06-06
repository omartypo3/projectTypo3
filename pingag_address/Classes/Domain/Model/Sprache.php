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
class Sprache extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * sprache
     *
     * @var string
     */
    protected $sprache = '';



    /**
     * Returns the sprache
     *
     * @return string
     */
    public function getSprache()
    {
        return $this->sprache;
    }

    /**
     * Sets the sprache
     *
     * @param string $sprache
     * @return void
     */
    public function setSprache(string $sprache)
    {
        $this->sprache = $sprache;
    }
}
