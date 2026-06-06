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
 * Ablage
 */
class Ablage extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * auftrag
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    protected $auftrag;

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
     * Returns the auftrag
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    public function getAuftrag()
    {
        return $this->auftrag;
    }

    /**
     * Sets the auftrag
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftrag
     * @return void
     */
    public function setAuftrag(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftrag)
    {
        $this->auftrag = $auftrag;
    }
}
