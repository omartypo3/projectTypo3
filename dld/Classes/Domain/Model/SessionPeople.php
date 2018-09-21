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
 *
 */
class SessionPeople extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * isSpeaker
     * 
     * @var bool
     */
    protected $isSpeaker = false;

    /**
     * isModerator
     * 
     * @var bool
     */
    protected $isModerator = false;

    /**
     * sortOrder
     * 
     * @var int
     */
    protected $sortOrder = 0;

    /**
     * sessionId
     * 
     * @var \DLD\Dld\Domain\Model\Session
     */
    protected $sessionId = null;

    /**
     * peopleId
     * 
     * @var \DLD\Dld\Domain\Model\People
     */
    protected $peopleId = null;

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
//        $this->sessionId = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the isSpeaker
     * 
     * @return bool $isSpeaker
     */
    public function getIsSpeaker()
    {
        return $this->isSpeaker;
    }

    /**
     * Sets the isSpeaker
     * 
     * @param bool $isSpeaker
     * @return void
     */
    public function setIsSpeaker($isSpeaker)
    {
        $this->isSpeaker = $isSpeaker;
    }

    /**
     * Returns the boolean state of isSpeaker
     * 
     * @return bool
     */
    public function isIsSpeaker()
    {
        return $this->isSpeaker;
    }

    /**
     * Returns the boolean state of isModeraor
     * 
     * @return bool
     */
    public function isIsModeraor()
    {
        return $this->isModeraor;
    }

    /**
     * Returns the isModerator
     * 
     * @return bool isModerator
     */
    public function getIsModerator()
    {
        return $this->isModerator;
    }

    /**
     * Sets the isModerator
     * 
     * @param bool $isModerator
     * @return void
     */
    public function setIsModerator($isModerator)
    {
        $this->isModerator = $isModerator;
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
    public function setSessionId( \DLD\Dld\Domain\Model\Session $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Returns the peopleId
     * 
     * @return \DLD\Dld\Domain\Model\People $peopleId
     */
    public function getPeopleId()
    {
        return $this->peopleId;
    }

    /**
     * Sets the peopleId
     * 
     * @param \DLD\Dld\Domain\Model\People $peopleId
     * @return void
     */
    public function setPeopleId(\DLD\Dld\Domain\Model\People $peopleId)
    {
        $this->peopleId = $peopleId;
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
