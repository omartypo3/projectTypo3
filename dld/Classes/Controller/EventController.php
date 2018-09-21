<?php

namespace DLD\Dld\Controller;

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
 * EventController
 */
use DLD\Dld\Domain\Model\UserTag;
use DLD\Dld\Flickr\Flickr;
use DLD\Dld\Property\TypeConverter\UploadedFileReferenceConverter;
use DLD\Dld\YouTube\YouTubeApi;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;

class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;
    /**
     * venueRepository
     *
     * @var \DLD\Dld\Domain\Repository\VenueRepository
     * @inject
     */
    protected $venueRepository = null;
    /**
     * partnerRepository
     *
     * @var \DLD\Dld\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = null;
    /**
     * sessionRepository
     *
     * @var \DLD\Dld\Domain\Repository\SessionRepository
     * @inject
     */
    protected $sessionRepository = null;
    /**
     * eventpartnerRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventPartnerRepository
     * @inject
     */
    protected $eventpartnerRepository = null;

    /**
     * applicationRepository
     *
     * @var \DLD\Dld\Domain\Repository\ApplicationRepository
     * @inject
     */
    protected $applicationRepository = null;
    /**
     * peopleRepository
     *
     * @var \DLD\Dld\Domain\Repository\PeopleRepository
     * @inject
     */
    protected $peopleRepository = null;
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * userTagRepository
     *
     * @var \DLD\Dld\Domain\Repository\UserTagRepository
     * @inject
     */
    protected $userTagRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $events = $this->eventRepository->findAll();
        $this->view->assign('events', $events);
    }

    /**
     * action events
     * @param int $offset
     * @param string $city
     * @return void
     */
    public function eventsAction($offset = 0, $city = "")
    {
        $pageid = $this->settings['pageid'];
        $limit = (int)$this->settings['EventItemsPerPage'];

        $events = $this->eventRepository->findUpcomingEvents('');
        $pastevents = $this->eventRepository->findPastEvents($offset, $limit, '');
        $countpast = $this->eventRepository->countPastEvents('');
        if ($countpast == $pastevents->count()) {
            $countpast = 1;
        }
        $this->view->assignMultiple(array('events' => $events, 'pastevents' => $pastevents, 'maxpage' => ceil($countpast / $limit), 'pageid' => $pageid));
    }

    /**
     * @param string $city
     */
    public function pastEventsAction($city = "")
    {
        $limit = (int)$this->settings['EventItemsPerPage'];
        $offset = (int)$this->request->getArgument('offset');
        $pageid = $this->settings['pageid'];
        $pastevents = $this->eventRepository->findPastEvents(($offset * $limit + 1), $limit, '');
        $this->view->assignMultiple(array('pastevents' => $pastevents, 'pageid' => $pageid));
    }

    /**
     * action show
     *
     * @param \DLD\Dld\Domain\Model\Event $event
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\Event $event)
    {

        $limit = (int)$this->settings['EventItemsPerPage'];
        $pastevents = $this->eventRepository->findPastEvents(0, 10);
        $pageid = $this->settings;
        $eventpartners = $this->eventpartnerRepository->findByEventId($event->getUid());
        $this->view->assignMultiple(array('event' => $event, 'partners' => $eventpartners, 'pageid' => $pageid, 'pastevents' => $pastevents));
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $venues = $this->venueRepository->findAll();
        $partners = $this->partnerRepository->findAll();
        $this->view->assignMultiple(array('venues' => $venues, 'partners' => $partners));
    }

    /**
     * action create
     *
     * @param \DLD\Dld\Domain\Model\Event $newEvent
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\Event $newEvent)
    {


        //$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);


        // add event page
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $target = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['targetPageID'];
        $parent = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['ParentPageID'];
        $cmd['pages'][$target]['copy'] = $parent;
        $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
        $tce->stripslashes_values = 0;
        $tce->start(array(), $cmd);
        $tce->process_cmdmap();
        $newPageId = $tce->copyMappingArray_merged['pages'][$target];
        $this->eventRepository->setPagetitle($newPageId, $newEvent->getTitle());
        $newContentId = $tce->copyMappingArray_merged['tt_content'];

        $flexArray2Xml_options = [
            'parentTagMap' => [
                'data' => 'sheet',
                'sheet' => 'language',
                'language' => 'field',
                'el' => 'field',
                'field' => 'value',
                'field:el' => 'el',
                'el:_IS_NUM' => 'section',
                'section' => 'itemType'
            ],
            'disableTypeAttrib' => 2
        ];
        $newEvent->setShowPage($newPageId);
        $this->eventRepository->add($newEvent);
        $this->persistenceManager->persistAll();
        foreach ($newContentId as $key => $value) {
            $flex = $this->eventRepository->getContent((int)$newContentId[$key])['pi_flexform'];
            $flexform = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($flex);
            $flexform['data']['sDEF']['lDEF']['settings.eventid']['vDEF'] = (string)$newEvent->getUid();
            $newflexform = \TYPO3\CMS\Core\Utility\GeneralUtility::array2xml($flexform, '', 0, 'T3FlexForms', 4, $flexArray2Xml_options);
            $newflex = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . $newflexform;
            $this->eventRepository->setContent((int)$newContentId[$key], $newflex);
        }
        // end add event page

        $this->addEventPartners($newEvent);

        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DLD\Dld\Domain\Model\Event $event
     * @ignorevalidation $event
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\Event $event)
    {
        $eventpartners = array();
        $venues = $this->venueRepository->findAll();
        $epartners = $this->eventpartnerRepository->findByEventId($event->getUid());
        foreach ($epartners as $value) {
            array_push($eventpartners, $value->getPartnerId()->getUid());
        }
        $partners = $this->partnerRepository->findAll();
        $this->view->assignMultiple(array('event' => $event, 'venues' => $venues, 'eventpartners' => $eventpartners, 'partners' => $partners));
    }

    /**
     * action update
     *
     * @param \DLD\Dld\Domain\Model\Event $event
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\Event $event)
    {

//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($event);
//        die();

//        $event->addVenueId($venue);
        //$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->eventRepository->removeFileRefrence($event->getUid());
        $this->eventRepository->update($event);
        $this->deleteEventPartners($event);
        $this->addEventPartners($event);

        //update evenet page
        $pagename = $this->eventRepository->getPageTitle($event->getShowPage()->getUid());
        if ($pagename != $event->getTitle()) {
            $this->eventRepository->setPagetitle($event->getShowPage()->getUid(), $event->getTitle());
        }
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DLD\Dld\Domain\Model\Event $event
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\Event $event)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->deleteEventPartners($event);
        //delete event page
        $cmd['pages'][$event->getShowPage()->getUid()]['delete'] = 1;
        $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
        $tce->stripslashes_values = 0;
        $tce->start(array(), $cmd);
        $tce->process_cmdmap();

        $sessions = $this->sessionRepository->findAllSessions($event->getUid());
        if (sizeof($sessions) > 0) {
            foreach ($sessions as $session) {
                $this->sessionRepository->remove($session);
            }
        }
        $this->eventRepository->remove($event);
        $this->redirect('list');
    }

    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => 'fileadmin/dld/conferences',
        ];

        /** @var PropertyMappingConfiguration $newExampleConfiguration */
        $newImageConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();


        $newImageConfiguration->forProperty('headerImage')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('headerImage');
        $newImageConfiguration->allowModificationForSubProperty('headerImage');
        $newImageConfiguration->forProperty('headerImage')
            ->setTypeConverterOptions(
                'DLD\\Dld\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );


        $newImageConfiguration->forProperty('slideImage')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('slideImage');
        $newImageConfiguration->allowModificationForSubProperty('slideImage');
        $newImageConfiguration->forProperty('slideImage')
            ->setTypeConverterOptions(
                'DLD\\Dld\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );


        $newImageConfiguration->forProperty('conferenceImage')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('conferenceImage');
        $newImageConfiguration->allowModificationForSubProperty('conferenceImage');
        $newImageConfiguration->forProperty('conferenceImage')
            ->setTypeConverterOptions(
                'DLD\\Dld\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeCreateAction()
    {


        $this->arguments['newEvent']->getPropertyMappingConfiguration()->forProperty('applyToInviteUntil')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd.m.Y H:i'
        );
        $this->setTypeConverterConfigurationForImageUpload('newEvent');
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeUpdateAction()
    {
        $this->arguments['event']->getPropertyMappingConfiguration()->forProperty('applyToInviteUntil')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd.m.Y H:i'
        );
        $this->setTypeConverterConfigurationForImageUpload('event');
    }


    public function mainSliderAction()
    {
        $settings = $this->settings;
        $eventToBeDisplayed = $this->eventRepository->mainSlider((int)$settings['eventold'], (int)$settings['eventnew']);
        // DebugUtility::debug($eventToBeDisplayed);die;
        $this->view->assignMultiple(array('eventToBeDisplayed' => $eventToBeDisplayed, 'settings' => $settings));
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($eventToBeDisplayed);
    }

    /**
     * @param $event
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    private function addEventPartners($event)
    {
        foreach ($this->request->getArgument('partners') as $p) {
            $eventPartner = new \DLD\Dld\Domain\Model\EventPartner();
            $eventPartner->setEventId($event);
            $partner = $this->partnerRepository->findByUid($p);
            $eventPartner->setPartnerId($partner);
            $this->eventpartnerRepository->add($eventPartner);
        }
    }

    /**
     * @param $event
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    private function deleteEventPartners($event)
    {
        $eventpartners = $this->eventpartnerRepository->findByEventId($event->getUid());
        if (sizeof($eventpartners) > 0) {
            foreach ($eventpartners as $p) {
                $this->eventpartnerRepository->remove($p);
            }
        }
    }

    /**
     * action header
     * @return void
     */
    public function headerAction()
    {
        $pageid = $this->settings;
        $buttontext = $this->settings['buttontext'];
        $application = $this->settings['application'];
        $eventid = $this->settings['eventid'];
        $event = $this->eventRepository->findByUid($eventid);
//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($event);die();
        $XingEventId = $event->getXingEventId();
        if ($XingEventId != 0) {
            $homepage = file_get_contents("https://www.xing-events.com/api/event/" . $XingEventId . "?apikey=9wlW1a1y8KNQIT1d8zYyz7xeUJjRFNZHYFXA0GNabd9YXXfXxB&version=1&format=json");

            $obj = \GuzzleHttp\json_decode($homepage);
            $XingIdentifier = $obj->event->identifier;
//        print_r($XingIdentifier);die();
            $this->view->assignMultiple(array('pageid' => $pageid, 'event' => $event, 'buttontext' => $buttontext, 'application' => $application, 'XingIdentifier' => $XingIdentifier));
        } else {

//        print_r($XingIdentifier);die();
            $this->view->assignMultiple(array('pageid' => $pageid, 'event' => $event, 'buttontext' => $buttontext, 'application' => $application, 'XingIdentifier' => ''));
        }

    }

    /**
     * action description
     * @return void
     */
    public function descriptionAction()
    {
        $pageid = $this->settings;
        $eventid = $this->settings['eventid'];
        $event = $this->eventRepository->findByUid($eventid);
        $this->view->assignMultiple(array('pageid' => $pageid, 'event' => $event));
    }

    /**
     * action twitter
     * @return void
     */
    public function twitterAction()
    {

        $eventid = $this->settings['eventid'];
        $event = $this->eventRepository->findByUid($eventid);
        $pageid = $this->settings;
        $this->view->assignMultiple(array('pageid' => $pageid, 'event' => $event));
    }

    /**
     * action map
     * @return void
     */
    public function mapAction()
    {

        $eventid = $this->settings['eventid'];
        $event = $this->eventRepository->findByUid($eventid);
        $pageid = $this->settings;
        $this->view->assignMultiple(array('pageid' => $pageid, 'event' => $event));
    }

    /**
     * action gallery
     * @return void
     */
    public function galleryAction()
    {

        $settings = $this->settings;
        $event = $this->eventRepository->findByUid($settings['eventid']);
        $this->view->assignMultiple(array('settings' => $settings, 'event' => $event));
    }

    /**
     * action speakers
     * @return void
     */
    public function speakersAction()
    {

        $eventid = $this->settings['eventid'];
        $event = $this->eventRepository->findByUid($eventid);
        $pageid = $this->settings;
        $this->view->assignMultiple(array('pageid' => $pageid, 'event' => $event));
    }

    /**
     * action program
     * @return void
     */
    public function programAction()
    {

        $eventid = $this->settings['eventid'];
        $event = $this->eventRepository->findByUid($eventid);
        $dates = $this->sessionRepository->findEventSessionsDate($eventid);
        $pageid = $this->settings;
        $this->view->assignMultiple(array('pageid' => $pageid, 'event' => $event, 'dates' => $dates));
    }

    /**
     * action conference
     *
     * @param \DLD\Dld\Domain\Model\Event $event
     * @return void
     */
    public function conferenceAction(\DLD\Dld\Domain\Model\Event $event = NULL)
    {
        $uid = $GLOBALS['TSFE']->fe_user->user['uid'];

        $EventTagPrefix = $this->eventRepository->getTagPrefix();

        $tagPrefixArray = array();
        foreach ($EventTagPrefix as $etp) {
            $tagPrefixArray[] = $etp->getTagPrefix();
        }

        $userTagsArray = $this->userTagRepository->findByuserid($uid);

        $c = array();
        $h = array();
        $events = array();
        foreach ($tagPrefixArray as $tagPrefix) {
            foreach ($userTagsArray as $userTags) {
                $prefix = stristr($userTags->getHighrisetag(), $tagPrefix);
                if ($prefix != FALSE) {
                    $h[] = $userTags;
                    $c[$tagPrefix] = $h;
                    array_push($events, $tagPrefix);
                }

            }
            $h = array();
        }
//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($c);die();
        if ($uid) {
            $application = $this->applicationRepository->findByUser($uid);
            foreach ($application as $applicationuser) {
                $event1 = $this->applicationRepository->findByUid($applicationuser->_getProperty('uid'));
            }
            $this->view->assignMultiple(array('event1' => $event1, 'userevents' => $events, 'event' => $event, 'userTags' => $c, 'userUid' => $uid));
        } else {
            if ($event)
                $this->view->assign('event', $event);
            else
                $this->view->render();

        }

    }

    /**
     * action invited
     * @return void
     */
    public function invitedAction()
    {
        $uid = $GLOBALS['TSFE']->fe_user->user['uid'];
        if ($this->request->hasArgument('id')) {
            $conference_id = (int)$this->request->getArgument('id');
        }
        if ($this->request->hasArgument('body')) {
            $body = $this->request->getArgument('body');
        }

        if ($this->request->hasArgument('tagPrefix')) {
            $tagPrefix = $this->request->getArgument('tagPrefix');
        }

        $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $event = $this->eventRepository->findByUid($conference_id);
        $tag = new UserTag();
        $tag->setHighrisetag($tagPrefix . '_applied');
        $tag->setUserid($uid);
        $tag->setHighriseTagcreatedat(new \DateTime('NOW'));
        $this->userTagRepository->add($tag);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($tagorgine);

        if ($conference_id != '' && $body != '') {
            $applicationshow = $this->applicationRepository->findByUserAndEvent($uid, $conference_id);
            if (count($applicationshow) > 0) {
                foreach ($applicationshow as $leistunganhang) {
                    $uid1 = $leistunganhang->_getProperty('uid');
                    $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_dld_domain_model_application', 'uid=' . intval($uid1), array('message' => $body));

                }
            } else {

                $application = $objectManager->get(\DLD\Dld\Domain\Model\Application::class);
                $application->setUserId($uid);
                $application->setEventId($conference_id);
                $application->setMessage($body);
                $this->applicationRepository->add($application);


            }

            /*foreach ($tagorgine_applied as $search_applied) {
                if (!(strpos($search_applied, '_applied') !== false)) {
                    $user->setTags($tag);
                   $this->peopleRepository->update($user);
                    $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                    $persistenceManager->persistAll();
                }
            }*/
            $this->view->assignMultiple(array('event' => $event, 'text' => $body));
        } else {
            $application = $this->applicationRepository->findByUser($uid);

            foreach ($application as $applicationuser) {
                $event = $this->applicationRepository->findByUid($applicationuser->_getProperty('uid'));
            }
            $this->view->assignMultiple(array('event1' => $event));
        }
        $application = $this->applicationRepository->findByUser($uid);

    }

    /**
     * action partners
     * @return void
     */
    public
    function partnersAction()
    {

        $eventid = $this->settings['eventid'];
        $headline = $this->settings['partnerhedline'];
        $event = $this->eventRepository->findByUid((int)$eventid);
        $eventpartners = $this->eventpartnerRepository->findByEventId($event->getUid());
        $pageid = $this->settings;
        $this->view->assignMultiple(array('pageid' => $pageid, 'headline' => $headline, 'event' => $event, 'partners' => $eventpartners));
    }

    /**
     * action eventsMightLike
     * @return void
     */

    public
    function eventsMightLikeAction()
    {
        $eventPageId = $this->settings['eventPageID'];
        $pastEventsTitle = $this->settings['pastEventsTitle'];
        $pastEventsLabelTitle = $this->settings['pastEventsButtonTitle'];
        $limit = $this->settings['pastEventsNumbers'];
        $pastEvents = $this->eventRepository->findPastEvents(0, (int)$limit, '');
        $this->view->assign('pastEvents', $pastEvents);
        $this->view->assign('title', $pastEventsTitle);
        $this->view->assign('pastEventsButtonTitle', $pastEventsLabelTitle);
        $this->view->assign('eventPageId', $eventPageId);

    }

    /**
     * action nextUpcomingEvent
     * @return void
     */

    public
    function nextUpcomingEventAction()
    {
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();
        $event = $this->eventRepository->findNextUpcoming();

        $uriBuilder->setTargetPageUid($event->getShowPage()->getUid());
        $uri = $uriBuilder->build();
        $this->redirectToUri($uri);
    }

    /**
     * action flickrAllAlbums
     * @return void
     */

    public
    function flickrAllAlbumsAction()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $flickrApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['flickrApiKey'];
        $userid = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['flickrUserId'];
        $f = new Flickr($flickrApiKey);

        $recent = $f->photosets_getList($userid);
        $albums = $recent['photoset'];
        $flickralbums = array();
        foreach ($albums as $k => $v) {
            $album = array();
            array_push($album, $v['photos']);
            array_push($album, $v['title']['_content']);
            array_push($album, $f->photos_getSizes($v['primary'])[4]['source']);
            array_push($album, 'https://www.flickr.com/photos/' . $userid . '/albums/' . $v['id']);
            array_push($flickralbums, $album);
        }
        $this->view->assign('albums', $flickralbums);
    }

    /**
     * action youtubeAllVideos
     * @return void
     */

    public function youtubeAllVideosAction()
    {
        $keyword = null;

        if (isset($this->request->getArguments()['keyword'])) {
            $keyword = $this->request->getArgument('keyword');

        }
        $conference = null;
        if (isset($this->request->getArguments()['conference'])) {
            $conference = (int)$this->request->getArgument('conference');

        }
        $speaker = null;
        if (isset($this->request->getArguments()['speaker'])) {
            $speaker = (int)$this->request->getArgument('speaker');

        }
        $speakercompany = null;
        if (isset($this->request->getArguments()['speakercompany'])) {
            $speakercompany = $this->request->getArgument('speakercompany');

        }
        $topic = null;
        if (isset($this->request->getArguments()['topic'])) {
            $topic = $this->request->getArgument('topic');

        }
        $duration = null;
        if (isset($this->request->getArguments()['duration'])) {
            $duration = $this->request->getArgument('duration');

        }
        $order = null;
        if (isset($this->request->getArguments()['order'])) {
            $order = $this->request->getArgument('order');

        }
        $pagecount = 0;
        if (isset($this->request->getArguments()['pagecount'])) {
            $pagecount = (int)$this->request->getArgument('pagecount');

        }


        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $ApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['youTubeApiKey'];
        $channelID = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['youTubeChannelID'];
        $maxresults = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['youTubeMaxResult'];

        if ($pagecount > 0)
            $pagecount *= $maxresults;
        $yt = new YouTubeApi($ApiKey);
        $yt->setChannelId($channelID);
        if ($speaker || $speakercompany || $conference) {

            $speakervids = array();
            if ($speaker) {
                $speakervids = $this->peopleRepository->findByUid((int)$speaker)->getYoutubeVideos();
                $speakervids = explode(',', $speakervids);
            }

            $companyvids = array();
            if ($speakercompany) {
                $companypeople = $this->peopleRepository->findByCompany($speakercompany);
                $companyvids = '';
                foreach ($companypeople as $peop) {
                    if ($peop->getYoutubeVideos() != '') {
                        $companyvids .= $peop->getYoutubeVideos() . ',';
                    }
                }
                $companyvids = rtrim($companyvids, ',');
                $companyvids = explode(',', $companyvids);
            }


            $eventvids = array();
            if ($conference) {

                $vids = $yt->getPlaylistVideos($this->eventRepository->findByUid($conference)->getYoutubePlaylist());
                if ($vids) {
                    foreach ($vids as $vid) {
                        $eventvids [] = $vid['modelData']['snippet']['resourceId']['videoId'];
                    }
                }
            }

            if ($speaker && $speakercompany && $conference) {
                $vidIDs = array_intersect($speakervids, $companyvids, $eventvids);
            } elseif ($speaker && $speakercompany) {
                $vidIDs = array_intersect($speakervids, $companyvids);
            } elseif ($speakercompany && $conference) {
                $vidIDs = array_intersect($companyvids, $eventvids);
            } elseif ($speaker && $conference) {
                $vidIDs = array_intersect($speakervids, $eventvids);
            } elseif ($speaker) {
                $vidIDs = $speakervids;
            } elseif ($speakercompany) {
                $vidIDs = $companyvids;
            } elseif ($conference) {
                $vidIDs = $eventvids;
            }


        } else {
            $vidIDs = '';
            $speakers = $this->peopleRepository->getAllspeakers();
            foreach ($speakers as $peop) {
                if ($peop->getYoutubeVideos() != '') {
                    $vidIDs .= $peop->getYoutubeVideos() . ',';
                }
            }
            $vidIDs = rtrim($vidIDs, ',');
            $vidIDs = explode(',', str_replace(' ', '', $vidIDs));
            $vidIDs = array_filter($vidIDs);

        }


        $keyvids = array();

        if ($keyword) {
            $vids = $yt->getVideosBykeyword($keyword);
            foreach ($vids as $vid) {
                $keyvids[] = $vid['modelData']['id']['videoId'];
            }
            $vidIDs = array_intersect($keyvids, $vidIDs);
        }


        $topicvids = array();
        $durvids = array();
        $ytvids = $yt->getVideosById(rtrim(implode(",", array_filter($vidIDs)), ','));

        foreach ($ytvids as $vid) {
            if ($topic) {
                $topic = str_replace('+', ' ', $topic);
                foreach ($vid['modelData']['snippet']['tags'] as $v) {
                    if ($v == $topic) {
                        $topicvids[] = $vid['id'];

                    }
                }

            }
            if ($duration) {
                $cond = explode('_than_', $duration);
                if ($cond[0] == 'less') {
                    if ($this->covtime($vid['modelData']['contentDetails']['duration']) < intval($cond[1])) {
                        $durvids[] = $vid['id'];
                    }
                } elseif ($cond[0] == 'more') {
                    if ($this->covtime($vid['modelData']['contentDetails']['duration']) > intval($cond[1])) {
                        $durvids[] = $vid['id'];
                    }
                }
            }
        }
        if ($topic) {

            $vidIDs = array_intersect($vidIDs, $topicvids);

        }
        if ($duration) {

            $vidIDs = array_intersect($vidIDs, $durvids);
        }

       $vidIDs = array_slice($vidIDs,$pagecount,$maxresults);
        $ytvids = $yt->getVideosById(implode(",", $vidIDs));
        $videos = array();

        foreach ($ytvids as $vid) {
            $ytvid = array();
            $speakers = explode('(', $vid['modelData']['snippet']['title'])[1];
            $ytvid['id'] = $vid['id'];
            $ytvid['title'] = $vid['modelData']['snippet']['title'];
            $ytvid['session'] = explode('(', $vid['modelData']['snippet']['title'])[0];
            $ytvid['conference'] = explode('|', $vid['modelData']['snippet']['title'])[1];
            $ytvid['speakers'] = (explode(')', $speakers)[0]);
            $ytvid['thumbnail'] = $vid['modelData']['snippet']['thumbnails']['medium']['url'];
            $ytvid['publishedAt'] = date('Y-m-d', strtotime($vid['modelData']['snippet']['publishedAt']));
            $ytvid['viewCount'] = $vid['modelData']['statistics']['viewCount'];
            $ytvid['duration'] = $this->covtimeread($vid['modelData']['contentDetails']['duration']);
            $videos[] = $ytvid;
        }

        if (strtoupper($order) == 'RECENT') {
            usort($videos, function ($a, $b) {
                $v1 = strtotime($a['publishedAt']);
                $v2 = strtotime($b['publishedAt']);
                return $v2 - $v1;
            });
        } else {
            usort($videos, function ($a, $b) {
                return (int)$b['viewCount'] - (int)$a['viewCount'];
            });
        }
        $showmore = 1;
        if (count($videos) < $maxresults)
            $showmore = 0;

        $events = $this->eventRepository->findAll();
        $speakerslist = $this->peopleRepository->getAllspeakers();
        $this->view->assignMultiple(array('videos' => $videos, 'events' => $events, 'speakers' => $speakerslist, 'showmore' => $showmore));
    }

    /**
     * action buyTicket
     * @param integer $eventUid
     * @param integer $peopleID
     * @return void
     */
    public
    function buyTicketAction($eventUid, $peopleID)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $xingApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['xingApiKey'];
        $event = $this->eventRepository->findOneByUid($eventUid);
        $user = $this->peopleRepository->findOneByUid($peopleID);

        $eventTagPrefix = $event->getTagPrefix();
        $newUserTag = $eventTagPrefix . "_ticketissued_started";//event.tag_prefix + "_ticketissued_started
        $userTags = $user->getTags();
        $userTagsArray = explode(",", $userTags);
        array_push($userTagsArray, $newUserTag);
        $userUpdatedTags = implode(",", $userTagsArray);
        $user->setTags($userUpdatedTags);
        $this->peopleRepository->update($user);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($userTagsArray);die();
        $XingEventId = $event->getXingEventId();
        $homepage = file_get_contents("https://www.xing-events.com/api/event/" . $XingEventId . "?apikey=" . $xingApiKey . "&version=1&format=json");
        $obj = \GuzzleHttp\json_decode($homepage);
        $this->redirectToURI($obj->event->eventURL, $delay = 0, $statusCode = 303);
//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($obj->event->eventURL);die();

    }


    function covtime($youtube_time)
    {
        preg_match_all('/(\d+)/', $youtube_time, $parts);

        // Put in zeros if we have less than 3 numbers.
        if (count($parts[0]) == 1) {
            array_unshift($parts[0], "0", "0");
        } elseif (count($parts[0]) == 2) {
            array_unshift($parts[0], "0");
        }

        $sec_init = $parts[0][2];
        $seconds = $sec_init % 60;
        $seconds_overflow = floor($sec_init / 60);

        $min_init = $parts[0][1] + $seconds_overflow;
        $minutes = ($min_init) % 60;
        $minutes_overflow = floor(($min_init) / 60);

        $hours = ($parts[0][0] + $minutes_overflow) * 60;
        $minutes += $hours;

        return intval($minutes);
    }

    function covtimeread($youtube_time)
    {
        preg_match_all('/(\d+)/', $youtube_time, $parts);

        // Put in zeros if we have less than 3 numbers.
        if (count($parts[0]) == 1) {
            array_unshift($parts[0], "0", "0");
        } elseif (count($parts[0]) == 2) {
            array_unshift($parts[0], "0");
        }

        $sec_init = $parts[0][2];
        $seconds = $sec_init % 60;
        $seconds_overflow = floor($sec_init / 60);

        $min_init = $parts[0][1] + $seconds_overflow;
        $minutes = ($min_init) % 60;
        $minutes_overflow = floor(($min_init) / 60);

        $hours = ($parts[0][0] + $minutes_overflow) * 60;
        if ($seconds < 10)
            $seconds = '0' . $seconds;
        if ($hours)
            return $hours . ':' . $minutes . ':' . $seconds;

        else return $minutes . ':' . $seconds;

    }
}

