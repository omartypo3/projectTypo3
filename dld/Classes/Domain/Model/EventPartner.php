<?php
namespace DLD\Dld\Domain\Model;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * EventPartner
 */
class EventPartner extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * 1=bronze, 2=silver, 3=gold
     * 
     * @var int
     */
    protected $partnerStatus = 0;

    /**
     * sortOrder
     * 
     * @var int
     */
    protected $sortOrder = 0;

    /**
     * eventId
     * 
     * @var \DLD\Dld\Domain\Model\Event
     */
    protected $eventId = null;

    /**
     * partnerId
     * 
     * @var \DLD\Dld\Domain\Model\Partner
     */
    protected $partnerId = null;

    /**
     * sessionId
     * 
     * @var \DLD\Dld\Domain\Model\Session
     */
    protected $sessionId = null;

    /**
     * Returns the partnerStatus
     * 
     * @return int $partnerStatus
     */
    public function getPartnerStatus()
    {
        return $this->partnerStatus;
    }

    /**
     * Sets the partnerStatus
     * 
     * @param int $partnerStatus
     * @return void
     */
    public function setPartnerStatus($partnerStatus)
    {
        $this->partnerStatus = $partnerStatus;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {

    }

    /**
     * Returns the sessionId
     * 
     * @return \DLD\Dld\Domain\Model\Session $sessionId
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Sets the sessionId
     * 
     * @param \DLD\Dld\Domain\Model\Session $sessionId
     * @return void
     */
    public function setSessionId(\DLD\Dld\Domain\Model\Session $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Returns the partnerId
     * 
     * @return \DLD\Dld\Domain\Model\Partner $partnerId
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * Sets the partnerId
     * 
     * @param \DLD\Dld\Domain\Model\Partner $partnerId
     * @return void
     */
    public function setPartnerId(\DLD\Dld\Domain\Model\Partner $partnerId)
    {
        $this->partnerId = $partnerId;
    }

    /**
     * Returns the eventId
     * 
     * @return \DLD\Dld\Domain\Model\Event $eventId
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Sets the eventId
     * 
     * @param \DLD\Dld\Domain\Model\Event $eventId
     * @return void
     */
    public function setEventId(\DLD\Dld\Domain\Model\Event $eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * Returns the sortOrder
     * 
     * @return int sortOrder
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Sets the sortOrder
     * 
     * @param int $sortOrder
     * @return void
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }
}
