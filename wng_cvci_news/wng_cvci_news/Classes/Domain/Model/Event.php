<?php
namespace Wng\WngCvciNews\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Event
 */
class Event extends \GeorgRinger\News\Domain\Model\News {

    /**
   	 * Is event
   	 *
   	 * @var boolean
   	 */
   	protected $eventIsEvent = FALSE;

	/**
	 * Event start date
	 *
	 * @var DateTime
	 * @validate NotEmpty
	 */
	protected $eventStartDate;

	/**
	 * Event start time
	 *
	 * @var DateTime
	 */
	protected $eventStartTime;

	/**
	 * Event end date
	 *
	 * @var DateTime
	 */
	protected $eventEndDate;

	/**
	 * Event end time
	 *
	 * @var DateTime
	 */
	protected $eventEndTime;

	/**
	 * Event All Day
	 *
	 * @var boolean
	 */
	protected $eventAllDay = FALSE;

	/**
	 * eventPrice
	 *
	 * @var string
	 */
	protected $eventPrice;

	/**
	 * eventUrl
	 *
	 * @var string
	 */
	protected $eventUrl;

	/**
	 * eventUrlTitle
	 *
	 * @var string
	 */
	protected $eventUrlTitle;

	/**
	 * eventTheme
	 *
	 * @var string
	 */
	protected $eventTheme;

	/**
	 * eventType
	 *
	 * @var string
	 */
	protected $eventType;

	/**
	 * eventPhone
	 *
	 * @var string
	 */
	protected $eventPhone;

	/**
	 * eventApero
	 *
	 * @var boolean
	 */
	protected $eventApero = FALSE;

	/**
	 * eventOrganisor
	 *
	 * @var string
	 */
	protected $eventOrganisor;

	/**
	 * eventForm
	 *
	 * @var boolean
	 */
	protected $eventForm = FALSE;

	/**
	 * eventParticipant
	 *
	 * @var boolean
	 */
	protected $eventParticipant = FALSE;

	/**
	 * eventOrganizer
	 *
	 * @var string
	 */
	protected $eventOrganizer;

	/**
	 * eventOrganizerId
	 *
	 * @var \Wng\WngCvciNews\Domain\Model\Organizer
	 */
	protected $eventOrganizerId = NULL;

	/**
	 * eventOrganizerPid
	 *
	 * @var string
	 */
	protected $eventOrganizerPid;

	/**
	 * eventOrganizerLink
	 *
	 * @var string
	 */
	protected $eventOrganizerLink;

	/**
	 * eventLocation
	 *
	 * @var string
	 */
	protected $eventLocation;

	/**
	 * eventLocationId
	 *
	 * @var \Wng\WngCvciNews\Domain\Model\Location
	 */
	protected $eventLocationId = NULL;

	/**
	 * eventLocationPid
	 *
	 * @var string
	 */
	protected $eventLocationPid;

	/**
	 * eventLocationLink
	 *
	 * @var string
	 */
	protected $eventLocationLink;

	/**
	 * eventEmails
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wng\WngCvciNews\Domain\Model\EventEmail>
	 * @lazy
	 */
	protected $eventEmails = NULL;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wng\WngCvciNews\Domain\Model\Event>
	 * @lazy
	 */
	protected $related;

	/*** Function ***/

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
		$this->eventEmails = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

   	/**
   	 * Returns the eventIsEvent
   	 *
   	 * @return boolean $eventIsEvent
   	 */
   	public function getEventIsEvent() {
   		return $this->eventIsEvent;
   	}

   	/**
   	 * Sets the eventIsEvent
   	 *
   	 * @param boolean $eventIsEvent
   	 * @return void
   	 */
   	public function setEventIsEvent($eventIsEvent) {
   		$this->eventIsEvent = $eventIsEvent;
   	}

   	/**
   	 * Returns the boolean state of isEvent
   	 *
   	 * @return boolean
   	 */
   	public function isEvent() {
   		return $this->getEventIsEvent();
   	}

	/**
	 * Returns the eventStartDate
	 *
	 * @return DateTime $eventStartDate
	 */
	public function getEventStartDate() {
		return $this->eventStartDate;
	}

	/**
	 * Sets the eventStartDate
	 *
	 * @param DateTime $eventStartDate
	 * @return void
	 */
	public function setEventStartDate($eventStartDate) {
		$this->eventStartDate = $eventStartDate;
	}

	/**
	 * Returns the eventStartTime
	 *
	 * @return DateTime $eventStartTime
	 */
	public function getEventStartTime() {
		return $this->eventStartTime;
	}

	/**
	 * Sets the eventStartTime
	 *
	 * @param DateTime $eventStartTime
	 * @return void
	 */
	public function setEventStartTime($eventStartTime) {
		$this->eventStartTime = $eventStartTime;
	}

	/**
	 * Returns the eventEndDate
	 *
	 * @return DateTime $eventEndDate
	 */
	public function getEventEndDate() {
		return $this->eventEndDate;
	}

	/**
	 * Sets the eventEndDate
	 *
	 * @param DateTime $eventEndDate
	 * @return void
	 */
	public function setEventEndDate($eventEndDate) {
		$this->eventEndDate = $eventEndDate;
	}

	/**
	 * Returns the eventEndTime
	 *
	 * @return DateTime $eventEndTime
	 */
	public function getEventEndTime() {
		return $this->eventEndTime;
	}

	/**
	 * Sets the eventEndTime
	 *
	 * @param DateTime $eventEndTime
	 * @return void
	 */
	public function setEventEndTime($eventEndTime) {
		$this->eventEndTime = $eventEndTime;
	}

    /**
     * Get year of eventStartDate
     *
     * @return integer
     */
    public function getYearOfEventStartDate() {
        return $this->getEventStartDate()->format('Y');
    }

    /**
     * Get month of eventStartDate
     *
     * @return integer
     */
    public function getMonthOfEventStartDate() {
        return $this->getEventStartDate()->format('m');
    }

    /**
     * Get day of eventStartDate
     *
     * @return integer
     */
    public function getDayOfEventStartDate() {
        return $this->getEventStartDate()->format('d');
    }

	/**
	 * Returns the eventAllDay
	 *
	 * @return boolean $eventAllDay
	 */
	public function getEventAllDay() {
		return $this->eventAllDay;
	}

	/**
	 * Sets the eventAllDay
	 *
	 * @param boolean $eventAllDay
	 * @return void
	 */
	public function setEventAllDay($eventAllDay) {
		$this->eventAllDay = $eventAllDay;
	}

	/**
	 * Get eventPrice
	 *
	 * @return string
	 */
	public function getEventPrice()
	{
		return $this->eventPrice;
	}

	/**
	 * Set eventPrice
	 *
	 * @param string $eventPrice eventPrice
	 * @return void
	 */
	public function setEventPrice($eventPrice)
	{
		$this->eventPrice = $eventPrice;
	}

	/**
	 * Get eventUrl
	 *
	 * @return string
	 */
	public function getEventUrl()
	{
		return $this->eventUrl;
	}

	/**
	 * Set eventUrl
	 *
	 * @param string $eventUrl eventUrl
	 * @return void
	 */
	public function setEventUrl($eventUrl)
	{
		$this->eventUrl = $eventUrl;
	}

	/**
	 * Get eventUrlTitle
	 *
	 * @return string
	 */
	public function getEventUrlTitle()
	{
		return $this->eventUrlTitle;
	}

	/**
	 * Set eventUrlTitle
	 *
	 * @param string $eventUrlTitle eventUrlTitle
	 * @return void
	 */
	public function setEventUrlTitle($eventUrlTitle)
	{
		$this->eventUrlTitle = $eventUrlTitle;
	}

	/**
	 * Get eventTheme
	 *
	 * @return string
	 */
	public function getEventTheme()
	{
		return $this->eventTheme;
	}

	/**
	 * Set eventTheme
	 *
	 * @param string $eventTheme eventTheme
	 * @return void
	 */
	public function setEventTheme($eventTheme)
	{
		$this->eventTheme = $eventTheme;
	}

	/**
	 * Get eventType
	 *
	 * @return string
	 */
	public function getEventType()
	{
		return $this->eventType;
	}

	/**
	 * Set eventType
	 *
	 * @param string $eventType eventType
	 * @return void
	 */
	public function setEventType($eventType)
	{
		$this->eventType = $eventType;
	}

	/**
	 * Get eventPhone
	 *
	 * @return string
	 */
	public function getEventPhone()
	{
		return $this->eventPhone;
	}

	/**
	 * Set eventPhone
	 *
	 * @param string $eventPhone eventPhone
	 * @return void
	 */
	public function setEventPhone($eventPhone)
	{
		$this->eventPhone = $eventPhone;
	}

	/**
	 * Returns the eventApero
	 *
	 * @return boolean $eventApero
	 */
	public function getEventApero() {
		return $this->eventApero;
	}

	/**
	 * Sets the eventApero
	 *
	 * @param boolean $eventApero
	 * @return void
	 */
	public function setEventApero($eventApero) {
		$this->eventApero = $eventApero;
	}

	/**
	 * Get eventOrganisor
	 *
	 * @return string
	 */
	public function getEventOrganisor()
	{
		return $this->eventOrganisor;
	}

	/**
	 * Set eventOrganisor
	 *
	 * @param string $eventOrganisor eventOrganisor
	 * @return void
	 */
	public function setEventOrganisor($eventOrganisor)
	{
		$this->eventOrganisor = $eventOrganisor;
	}

	/**
	 * Returns the eventForm
	 *
	 * @return boolean $eventForm
	 */
	public function getEventForm() {
		return $this->eventForm;
	}

	/**
	 * Sets the eventForm
	 *
	 * @param boolean $eventForm
	 * @return void
	 */
	public function setEventForm($eventForm) {
		$this->eventForm = $eventForm;
	}

	/**
	 * Returns the eventParticipant
	 *
	 * @return boolean $eventParticipant
	 */
	public function getEventParticipant() {
		return $this->eventParticipant;
	}

	/**
	 * Sets the eventParticipant
	 *
	 * @param boolean $eventParticipant
	 * @return void
	 */
	public function setEventParticipant($eventParticipant) {
		$this->eventParticipant = $eventParticipant;
	}

	/**
	 * Get eventOrganizer
	 *
	 * @return string
	 */
	public function getEventOrganizer()
	{
		return $this->eventOrganizer;
	}

	/**
	 * Set eventOrganizer
	 *
	 * @param string $eventOrganizer eventOrganizer
	 * @return void
	 */
	public function setEventOrganizer($eventOrganizer)
	{
		$this->eventOrganizer = $eventOrganizer;
	}

	/**
	 * Returns the eventOrganizerId
	 *
	 * @return \Wng\WngCvciNews\Domain\Model\Organizer $eventOrganizerId
	 */
	public function getEventOrganizerId() {
		return $this->eventOrganizerId;
	}

	/**
	 * Sets the eventOrganizerId
	 *
	 * @param \Wng\WngCvciNews\Domain\Model\Organizer $eventOrganizerId
	 * @return void
	 */
	public function setEventOrganizerId(\Wng\WngCvciNews\Domain\Model\Organizer $eventOrganizerId) {
		$this->eventOrganizerId = $eventOrganizerId;
	}

	/**
	 * Get eventOrganizerPid
	 *
	 * @return string
	 */
	public function getEventOrganizerPid()
	{
		return $this->eventOrganizerPid;
	}

	/**
	 * Set eventOrganizerPid
	 *
	 * @param string $eventOrganizerPid eventOrganizerPid
	 * @return void
	 */
	public function setEventOrganizerPid($eventOrganizerPid)
	{
		$this->eventOrganizerPid = $eventOrganizerPid;
	}

	/**
	 * Get eventOrganizerLink
	 *
	 * @return string
	 */
	public function getEventOrganizerLink()
	{
		return $this->eventOrganizerLink;
	}

	/**
	 * Set eventOrganizerLink
	 *
	 * @param string $eventOrganizerLink eventOrganizerLink
	 * @return void
	 */
	public function setEventOrganizerLink($eventOrganizerLink)
	{
		$this->eventOrganizerLink = $eventOrganizerLink;
	}

	/**
	 * Get eventLocation
	 *
	 * @return string
	 */
	public function getEventLocation()
	{
		return $this->eventLocation;
	}

	/**
	 * Set eventLocation
	 *
	 * @param string $eventLocation eventLocation
	 * @return void
	 */
	public function setEventLocation($eventLocation)
	{
		$this->eventLocation = $eventLocation;
	}

	/**
	 * Returns the eventLocationId
	 *
	 * @return \Wng\WngCvciNews\Domain\Model\Location $eventLocationId
	 */
	public function getEventLocationId() {
		return $this->eventLocationId;
	}

	/**
	 * Sets the eventLocationId
	 *
	 * @param \Wng\WngCvciNews\Domain\Model\Location $eventLocationId
	 * @return void
	 */
	public function setEventLocationId(\Wng\WngCvciNews\Domain\Model\Location $eventLocationId) {
		$this->eventLocationId = $eventLocationId;
	}

	/**
	 * Get eventLocationPid
	 *
	 * @return string
	 */
	public function getEventLocationPid()
	{
		return $this->eventLocationPid;
	}

	/**
	 * Set eventLocationPid
	 *
	 * @param string $eventLocationPid eventLocationPid
	 * @return void
	 */
	public function setEventLocationPid($eventLocationPid)
	{
		$this->eventLocationPid = $eventLocationPid;
	}

	/**
	 * Get eventLocationLink
	 *
	 * @return string
	 */
	public function getEventLocationLink()
	{
		return $this->eventLocationLink;
	}

	/**
	 * Set eventLocationLink
	 *
	 * @param string $eventLocationLink eventLocationLink
	 * @return void
	 */
	public function setEventLocationLink($eventLocationLink)
	{
		$this->eventLocationLink = $eventLocationLink;
	}

	/**
	 * Adds a EventEmail
	 *
	 * @param \Wng\WngAnnuaire\Domain\Model\EventEmail $eventEmail
	 * @return void
	 */
	public function addEventEmail(\Wng\WngAnnuaire\Domain\Model\EventEmail $eventEmail)
	{
		$this->eventEmails->attach($eventEmail);
	}

	/**
	 * Removes a EventEmail
	 *
	 * @param \Wng\WngAnnuaire\Domain\Model\EventEmail $eventEmailToRemove The EventEmail to be removed
	 * @return void
	 */
	public function removeEventEmail(\Wng\WngAnnuaire\Domain\Model\EventEmail $eventEmailToRemove)
	{
		$this->eventEmails->detach($eventEmailToRemove);
	}

	/**
	 * Returns the eventEmails
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wng\WngAnnuaire\Domain\Model\EventEmail> eventEmails
	 */
	public function getEventEmails()
	{
		return $this->eventEmails;
	}

	/**
	 * Sets the eventEmails
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wng\WngAnnuaire\Domain\Model\EventEmail> $eventEmails
	 * @return void
	 */
	public function setEventEmails(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eventEmails)
	{
		$this->eventEmails = $eventEmails;
	}

	/**
	 * Get All category Text
	 *
	 * @return string
	 */
	public function getAllCategoryText()
	{
		$categories = $this->getCategories();
		if (!is_null($categories)) {
			$categoryText = "";
			foreach($categories as $category) {
				$categoryText .= $category->getTitle().", ";
			}
			$categoryText = rtrim($categoryText, ", ");
			return $categoryText;
		} else {
			return "";
		}
	}

	/**
	 * Get eventAddress
	 *
	 * @return string
	 */
	public function getEventAddress()
	{
		if($this->getEventLocation()) {
			return $this->getEventLocation();
		} elseif($this->getEventLocationId()) {
			return $this->getEventLocationId()->getAddress();
		}
		return "";
	}

	/**
	 * Get eventOrganizerName
	 *
	 * @return string
	 */
	public function getEventOrganizerName()
	{
		if($this->getEventOrganizer()) {
			return $this->getEventOrganizer();
		} elseif($this->getEventOrganizerId()) {
			return $this->getEventOrganizerId()->getName();
		}
		return "";
	}

	/**
	 * Get related news
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wng\WngCvciNews\Domain\Model\Event>
	 */
	public function getRelated()
	{
		return $this->related;
	}


}
?>