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
 * Session
 */
class Session extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     * @validate NotEmpty
     * @var string
     */
    protected $name = '';

    /**
     * start
     * @validate NotEmpty
     * @var \DateTime
     */
    protected $start;

    /**
     * end
     * @validate NotEmpty
     * @var \DateTime
     */
    protected $end;

    /**
     * isVisible
     *
     * @var bool
     */
    protected $isVisible = false;

    /**
     * eventId
     *
     * @var \DLD\Dld\Domain\Model\Event
     *
     */
    protected $eventId = null;

    /**
     * venueId
     *
     * @var \DLD\Dld\Domain\Model\Venue
     * @cascade remove
     */
    protected $venueId = null;


    /**
     * speakers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DLD\Dld\Domain\Model\People>
     * @cascade remove
     */
    protected $speakers = null;

    /**
     * moderator
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DLD\Dld\Domain\Model\People>
     * @cascade remove
     */
    protected $moderator = null;
    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     *  slugname
     *
     * @var string
     */
    protected $slugname = '';
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
     * Returns the start
     *
     * @return \DateTime $start
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Sets the start
     *
     * @param \DateTime $start
     * @return void
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;
    }

    /**
     * Returns the end
     *
     * @return \DateTime $end
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Sets the end
     *
     * @param \DateTime $end
     * @return void
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;
    }

    /**
     * Returns the isVisible
     *
     * @return bool $isVisible
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Sets the isVisible
     *
     * @param bool $isVisible
     * @return void
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    /**
     * Returns the boolean state of isVisible
     *
     * @return bool
     */
    public function isIsVisible()
    {
        return $this->isVisible;
    }



    /**
     * Returns the applyToInviteUntil
     *
     * @return int $applyToInviteUntil
     */
    public function getApplyToInviteUntil()
    {
        return $this->applyToInviteUntil;
    }

    /**
     * Sets the applyToInviteUntil
     *
     * @param int $applyToInviteUntil
     * @return void
     */
    public function setApplyToInviteUntil($applyToInviteUntil)
    {
        $this->applyToInviteUntil = $applyToInviteUntil;
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
        $this->speakers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->moderator = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    /**
     * Adds a Speakers
     *
     * @param \DLD\Dld\Domain\Model\People $speakers
     * @return void
     */
    public function addSpeakers(\DLD\Dld\Domain\Model\People $speakers)
    {
        $this->speakers->attach($speakers);
    }

    /**
     * Removes a Speakers
     *
     * @param \DLD\Dld\Domain\Model\Event $speakersToRemove The Event to be removed
     * @return void
     */
    public function removeSpeakers(\DLD\Dld\Domain\Model\People $speakersToRemove)
    {
        $this->speakers->detach($speakersToRemove);
    }

    /**
     * Returns the speakers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DLD\Dld\Domain\Model\People> $speakers
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }

    /**
     * Sets the speakers
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DLD\Dld\Domain\Model\People> $speakers
     * @return void
     */
    public function setSpeakers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $speakers)
    {
        $this->speakers = $speakers;
    }





    /**
     * Adds a Moderator
     *
     * @param \DLD\Dld\Domain\Model\People $moderator
     * @return void
     */
    public function addModerator(\DLD\Dld\Domain\Model\People $moderator)
    {
        $this->moderator->attach($moderator);
    }

    /**
     * Removes a moderator
     *
     * @param \DLD\Dld\Domain\Model\Event $moderatorToRemove The Event to be removed
     * @return void
     */
    public function removeModerator(\DLD\Dld\Domain\Model\People $moderatorToRemove)
    {
        $this->moderator->detach($moderatorToRemove);
    }

    /**
     * Returns the moderator
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DLD\Dld\Domain\Model\People> $moderator
     */
    public function getmoderator()
    {
        return $this->moderator;
    }

    /**
     * Sets the moderator
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DLD\Dld\Domain\Model\People> $moderator
     * @return void
     */
    public function setModerator(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $moderator)
    {
        $this->moderator = $moderator;
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
     * Returns the venueId
     *
     * @return \DLD\Dld\Domain\Model\Venue $venueId
     */
    public function getVenueId()
    {
        return $this->venueId;
    }

    /**
     * Sets the venueId
     *
     * @param \\DLD\Dld\Domain\Model\Venue $venueId
     * @return void
     */
    public function setVenueId(\DLD\Dld\Domain\Model\Venue $venueId)
    {
        $this->venueId = $venueId;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the slugname
     *
     * @return string $slugname
     */
    public function getSlugname() {
        return $this->slugname;
    }

    /**
     * Sets the slugname
     *
     * @param string $slugname
     * @return void
     */
    public function setSlugname($slugname) {
        $this->slugname = $slugname;
    }


}
