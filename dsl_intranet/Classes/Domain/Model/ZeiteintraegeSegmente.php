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
 * ZeiteintraegeSegmente
 */
class ZeiteintraegeSegmente extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * minuten
     *
     * @var int
     */
    protected $minuten;

    /**
     * phase
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Phasen
     */
    protected $phase;

    /**
     * Returns the minuten
     *
     * @return int
     */
    public function getMinuten()
    {
        return $this->minuten;
    }

    /**
     * Sets the minuten
     *
     * @param int $minuten
     * @return void
     */
    public function setMinuten(int $minuten)
    {
        $this->minuten = $minuten;
    }

    /**
     * Returns the phase
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Phasen
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Sets the phase
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phase
     * @return void
     */
    public function setPhase(\DslFactory\DslIntranet\Domain\Model\Phasen $phase)
    {
        $this->phase = $phase;
    }
}
