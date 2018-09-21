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
 * Application
 */
class Application extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * userId
     * 
     * @var int
     */
    protected $userId = 0;

    /**
     * 	eventId
     *
     * @var int
     */
    protected $eventId = 0;

    /**
     * 	message
     * 
     * @var string
     */
    protected $message = '';

    /**
     * Returns the userId
     * 
     * @return int $userId
     */
    public function getUserId()
    {
        return $this->userid;
    }

    /**
     * Sets the userId
     * 
     * @param int $userId
     * @return void
     */
    public function setUserId($userId)
    {
        $this->userid = $userId;
    }

    /**
     * Returns the eventId
     *
     * @return int $eventId
     */
    public function getEventId()
    {
        return $this->eventid;
    }

    /**
     * Sets the eventId
     *
     * @param int $eventId
     * @return void
     */
    public function setEventId($eventId)
    {
        $this->eventid = $eventId;
    }

    /**
     * Returns the message
     * 
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the message
     * 
     * @param string $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
