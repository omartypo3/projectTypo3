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
 * ProtokollePending
 */
class ProtokollePending extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * pending
     *
     * @var bool
     */
    protected $pending;

    /**
     * timestamp
     *
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * mitarbeiter
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Mitarbeiter
     */
    protected $mitarbeiter;
	
	/**
     * protokoll
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Protokolle
     */
    protected $protokoll;

    /**
     * Returns the pending
     *
     * @return bool
     */
    public function getPending()
    {
        return $this->pending;
    }

    /**
     * Sets the pending
     *
     * @param bool $pending
     * @return void
     */
    public function setPending(bool $pending)
    {
        $this->pending = $pending;
    }

    /**
     * Returns the boolean state of pending
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->pending;
    }

    /**
     * Returns the timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Sets the timestamp
     *
     * @param \DateTime $timestamp
     * @return void
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Returns the mitarbeiter
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Mitarbeiter
     */
    public function getMitarbeiter()
    {
        return $this->mitarbeiter;
    }

    /**
     * Sets the mitarbeiter
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @return void
     */
    public function setMitarbeiter(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter)
    {
        $this->mitarbeiter = $mitarbeiter;
    }

    /**
     * Returns the protokoll
     *
     * @param $reload
     */
    public function getProtokoll($reload = false)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $protokolleRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
        if ($this->protokoll === NULL || $reload) {
            $this->protokoll = $protokolleRepository->findProtokollByProtokollePending($this);
        }
        return $this->protokoll;
    }
}
