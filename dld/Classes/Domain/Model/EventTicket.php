<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 19/06/2018
 * Time: 10:04
 */

namespace DLD\Dld\Domain\Model;



/**
 * EventTicket
 */
class EventTicket  extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * conferenceId
     *
     * @var int
     *
     */
    protected $conferenceId = null;
    /**
     * ticketId
     *
     * @var string
     */
    protected $ticketId;
    /**
     * highriseTagSuffix
     *
     * @var string
     */
    protected $highriseTagSuffix;
    /**
     * isLocked
     *
     * @var bool
     */
    protected $isLocked;
    /**
     * name
     * @var string
     */
    protected $name;

    /**
     * Returns the conferenceId
     *
     * @return integer $conferenceId
     */
    public function getConferenceId()
    {
        return $this->conferenceId;
    }

    /**
     * Sets the conferenceId
     *
     * @param integer $conferenceId
     * @return void
     */
    public function setConferenceId($conferenceId)
    {
        $this->conferenceId = $conferenceId;
    }

    /**
     * Returns the ticketId
     *
     * @return string $ticketId
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * Sets the ticketId
     *
     * @param string $ticketId
     * @return void
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;
    }

    /**
     * Returns the highriseTagSuffix
     *
     * @return string $highriseTagSuffix
     */
    public function getHighriseTagSuffix()
    {
        return $this->highriseTagSuffix;
    }

    /**
     * Sets the highriseTagSuffix
     *
     * @param string $highriseTagSuffix
     * @return void
     */
    public function setHighriseTagSuffix($highriseTagSuffix)
    {
        $this->highriseTagSuffix = $highriseTagSuffix;
    }


    /**
     * Returns the isLocked
     *
     * @return string $isLocked
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }

    /**
     * Sets the isLocked
     *
     * @param string $isLocked
     * @return void
     */
    public function setIsLocked($isLocked)
    {
        $this->islocked = $isLocked;
    }


    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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




}