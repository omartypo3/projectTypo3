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
 * Event
 */

class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     * @validate NotEmpty
     * @var string
     */
    protected $title = '';

    /**
     * headerImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $headerImage;

    /**
     * isVisible
     *
     * @var bool
     */
    protected $isVisible = false;

    /**
     * slideImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $slideImage;

    /**
     * conferenceImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $conferenceImage;

    /**
     * programPdf
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $programPdf ;

    /**
     * maxInvitee
     *
     * @var int
     */
    protected $maxInvitee = 0;

    /**
     * twitterHashtag
     *
     * @var string
     */
    protected $twitterHashtag = '';


    /**
     * isVisible
     *
     * @var bool
     */
    protected $isInvitationalEvent = false;

    /**
     * applyToInviteUntil
     * @validate NotEmpty
     * @var \DateTime
     */
    protected $applyToInviteUntil = 0;


    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * venueId
     *
     * @var \DLD\Dld\Domain\Model\Venue

     */
    protected $venueId = null;

    /**
     * session
     *
     * @var int
     */
    protected $session = 0;


    /**
     * start
     *
     * @var \DateTime
     */
    protected $start;

    /**
     * showPageID
     *
     * @var \DLD\Dld\Domain\Model\Page
     */
    protected $showPage = null;

    /**
     * livestream
     *
     * @var string
     */
    protected $livestream = '';
    /**
     * albumID
     *
     * @var string
     */
    protected $albumId = '';

    /**
     * xingEventId
     *
     * @var int
     */
    protected $xingEventId;

    /**
     * type
     *
     * @var string
     */
    protected $type;
    /**
     * tagPrefix
     *
     * @var string
     */
    protected $tagPrefix = '';

    /**
     * youtubePlaylist
     *
     * @var string
     */
    protected $youtubePlaylist = '';

    /**
     *  invitednumber
     *
     * @var int
     */
    protected $invitednumber = 0;

    /**
     * Variable appliednumber
     *
     * @var int
     */
    protected $appliednumber = 0;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the headerImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $headerImage
     */
    public function getHeaderImage()
    {
        return $this->headerImage;
    }

    /**
     * Sets the headerImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $headerImage
     * @return void
     */
    public function setHeaderImage( $headerImage)
    {
        $this->headerImage = $headerImage;
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
     * Returns the slideImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $slideImage
     */
    public function getSlideImage()
    {
        return $this->slideImage;
    }

    /**
     * Sets the slideImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $slideImage
     * @return void
     */
    public function setSlideImage( $slideImage)
    {
        $this->slideImage = $slideImage;
    }

    /**
     * Returns the conferenceImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $conferenceImage
     */
    public function getConferenceImage()
    {
//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($this);
//        die();*/
        return $this->conferenceImage;
    }

    /**
     * Sets the conferenceImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $conferenceImage
     * @return void
     */
    public function setConferenceImage( $conferenceImage)
    {
        $this->conferenceImage = $conferenceImage;
    }

    /**
     * Returns the programPdf
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $programPdf
     */
    public function getProgramPdf()
    {
        return $this->programPdf;
    }

    /**
     * Sets the programPdf
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $programPdf
     * @return void
     */
    public function setProgramPdf($programPdf)
    {
        $this->programPdf = $programPdf;
    }

    /**
     * Returns the livestream
     *
     * @return string $livestream
     */
    public function getLiveStream()
    {
        return $this->livestream;
    }

    /**
     * Sets the livestream
     *
     * @param string $livestream
     * @return void
     */
    public function setLiveStream($livestream)
    {
        $this->livestream = $livestream;
    }

    /**
     * Returns the maxInvitee
     *
     * @return int $maxInvitee
     */
    public function getMaxInvitee()
    {
        return $this->maxInvitee;
    }

    /**
     * Sets the maxInvitee
     *
     * @param int $maxInvitee
     * @return void
     */
    public function setMaxInvitee($maxInvitee)
    {
        $this->maxInvitee = $maxInvitee;
    }

    /**
     * Returns the twitterHashtag
     *
     * @return string $twitterHashtag
     */
    public function getTwitterHashtag()
    {
        return $this->twitterHashtag;
    }

    /**
     * Sets the twitterHashtag
     *
     * @param string $twitterHashtag
     * @return void
     */
    public function setTwitterHashtag($twitterHashtag)
    {
        $this->twitterHashtag = $twitterHashtag;
    }




    /**
     * Returns the isInvitationalEvent
     *
     * @return bool $isInvitationalEvent
     */
    public function getIsInvitationalEvent()
    {
        return $this->isInvitationalEvent;
    }

    /**
     * Sets the isInvitationalEvent
     *
     * @param bool $isInvitationalEvent
     * @return void
     */
    public function setIsInvitationalEvent($isInvitationalEvent)
    {
        $this->isInvitationalEvent = $isInvitationalEvent;
    }

    /**
     * Returns the boolean state of isInvitationalEvent
     *
     * @return bool
     */
    public function isIsInvitationalEvent()
    {
        return $this->isInvitationalEvent;
    }



    /**
     * Returns the applyToInviteUntil
     *
     * @return \DateTime $applyToInviteUntil
     */
    public function getApplyToInviteUntil()
    {
        return $this->applyToInviteUntil;
    }

    /**
     * Sets the applyToInviteUntil
     *
     * @param \DateTime $applyToInviteUntil
     * @return void
     */
    public function setApplyToInviteUntil($applyToInviteUntil)
    {
        $this->applyToInviteUntil = $applyToInviteUntil;
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
     * @param \DLD\Dld\Domain\Model\Venue $venueId
     * @return void
     */
    public function setVenueId(\DLD\Dld\Domain\Model\Venue $venueId)
    {
        $this->venueId = $venueId;
    }



    /**
     * Returns the session
     *
     * @return int $session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Sets the session
     *
     * @param int $session
     * @return void
     */
    public function setSession($session)
    {
        $this->session = $session;
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
     * Returns the showPage
     *
     * @return \DLD\Dld\Domain\Model\Page $showPage
     */
    public function getShowPage()
    {
        return $this->showPage;
    }

    /**
     * Sets the showPage
     *
     * @param \DLD\Dld\Domain\Model\Page  $showPage
     * @return void
     */
    public function setShowPage($showPage)
    {
        $this->showPage = $showPage;
    }
    /**
     * Returns the albumId
     *
     * @return string $albumId
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * Sets the showPage
     *
     * @param string $albumId
     * @return void
     */
    public function setAlbumId($albumId)
    {
        $this->albumId = $albumId;
    }

    /**
     * Returns the xingEventId
     *
     * @return int $xingEventId
     */

    public function getXingEventId()
    {
        return $this->xingEventId;
    }

    /**
     * Sets the xingEventId
     *
     * @param int $xingEventId
     * @return void
     */
    public function setXingEventId($xingEventId)
    {
        $this->xingEventId = $xingEventId;
    }

    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the tagPrefix
     *
     * @return string $tagPrefix
     */
    public function getTagPrefix()
    {
        return $this->tagPrefix;
    }

    /**
     * Sets the tagPrefix
     *
     * @param string $tagPrefix
     * @return void
     */
    public function setTagPrefix($tagPrefix)
    {
        $this->tagPrefix = $tagPrefix;
    }

    /**
     * Returns the youtubePlaylist
     *
     * @return string $youtubePlaylist
     */
    public function getYoutubePlaylist()
    {
        return $this->youtubePlaylist;
    }

    /**
     * Sets the youtubePlaylist
     *
     * @param string $youtube_playlist
     * @return void
     */
    public function setYoutubePlaylist($youtube_playlist)
    {
        $this->youtubePlaylist = $youtube_playlist;
    }



    /**
     * Returns the invitednumber
     *
     * @return int $invitednumber
     */
    public function getInvitednumber() {
        return $this->invitednumber;
    }

    /**
     * Sets the invitednumber
     *
     * @param int $invitednumber
     * @return void
     */
    public function setInvitednumber($invitednumber) {
        $this->invitednumber = $invitednumber;
    }

    /**
     * Returns the appliednumber
     *
     * @return int $appliednumber
     */
    public function getAppliednumber() {
        return $this->appliednumber;
    }

    /**
     * Sets the appliednumber
     *
     * @param int $appliednumber
     * @return void
     */
    public function setAppliednumber($appliednumber) {
        $this->appliednumber = $appliednumber;
    }

}
