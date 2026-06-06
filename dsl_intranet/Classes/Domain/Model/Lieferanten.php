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
 * Lieferanten
 */
class Lieferanten extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * nummer
     *
     * @var string
     */
    protected $nummer;

    /**
     * Returns the nummer
     *
     * @return string
     */
    public function getNummer()
    {
        return $this->nummer;
    }

    /**
     * Sets the nummer
     *
     * @param string $nummer
     * @return void
     */
    public function setNummer(string $nummer)
    {
        $this->nummer = $nummer;
    }
}
