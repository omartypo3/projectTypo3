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

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Session;

/**
 * SessionController
 */
class SessionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;


    /**
     * sessionRepository
     *
     * @var \DLD\Dld\Domain\Repository\SessionRepository
     * @inject
     */
    protected $sessionRepository = null;
    /**
     * venueRepository
     *
     * @var \DLD\Dld\Domain\Repository\VenueRepository
     * @inject
     */
    protected $venueRepository = null;


    /**
     * sessionPeopleRepository
     *
     * @var \DLD\Dld\Domain\Repository\SessionPeopleRepository
     * @inject
     */
    protected $sessionPeopleRepository = null;

    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * peopleRepository
     *
     * @var \DLD\Dld\Domain\Repository\PeopleRepository
     * @inject
     */
    protected $peopleRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {

        $sessions = $this->sessionRepository->findAll();
        $this->view->assign('sessions', $sessions);
    }

    /**
     * action show
     *
     * @param \DLD\Dld\Domain\Model\Session $session
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\Session $session)
    {
        $next = $this->sessionRepository->findNextSession($session);
        $previous = $this->sessionRepository->findPerviousSession($session);
        $event = $session->getEventId();

        $settings = $this->settings;
        $this->view->assignMultiple(array('session' => $session, 'next' => $next, 'pervious' => $previous, 'event' => $event, 'settings' => $settings));
    }

    public function initializeShowAction()
    {

        if(! $this->sessionRepository->findByUid($this->request->getArgument('session')))
        {
            $session = $this->peopleRepository->findBySlugname($this->request->getArgument('session'))->getFirst();
            if ($session)
                $this->request->setArgument('session',$session );

            else {
                $this->request->setArgument('session', new \DLD\Dld\Domain\Model\Session());

            }
        }


    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $events = $this->eventRepository->findAll();
        $venues = $this->venueRepository->findAll();
        $speakers = $this->peopleRepository->findAll();
        $this->view->assignMultiple(array('speakers' => $speakers, 'events' => $events, 'venues' => $venues));
    }

    /**
     * action create
     *
     * @param \DLD\Dld\Domain\Model\Session $newSession
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\Session $newSession)
    {


        // or just allow certain properties
        $slug = $this->sessionRepository->findBySlugname($newSession->getName());
        if (count($slug) > 0) {
            $newSession->setSlugname($newSession->getName() . time());
        } else {
            $newSession->setSlugname($newSession->getName());
        }
        $this->sessionRepository->add($newSession);
        $this->persistenceManager->persistAll();
        $speaker = array();

        // or just allow certain properties
        foreach ($this->request->getArgument('speakers') as $sp) {
            $speaker[] = $sp;
        }
        $moderator = array();
        foreach ($this->request->getArgument('moderator') as $sp) {
            $moderator[] = $sp;
        }
        $result = array_merge($speaker, $moderator);
        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($result);

        $unique = array_unique($result);
        foreach ($unique as $p) {
            $people = $this->peopleRepository->findByUid($p);
            $sessionPeople = new \DLD\Dld\Domain\Model\SessionPeople();
            $sessionPeople->setPeopleId($people);
            foreach ($speaker as $sp) {
                if ($p == $sp) {
                    $sessionPeople->setIsSpeaker("1");
                }
            }
            foreach ($moderator as $md) {
                if ($p == $md) {
                    $sessionPeople->setIsModerator("1");
                }
            }
            $sessionPeople->setSessionId($newSession);
            $this->sessionPeopleRepository->add($sessionPeople);
        }

        $this->eventUpdateStart($this->request->getArgument('newSession')['eventId']);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DLD\Dld\Domain\Model\Session $session
     * @ignorevalidation $session
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\Session $session)
    {
        $this->view->assign('session', $session);
//
        $sessionPeoples = $this->sessionPeopleRepository->findBySessionId($session->getUid());
////        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($sessionPeoples);die();
//
        $this->view->assign('sessionPeoples', $sessionPeoples);

        $speakers = $this->peopleRepository->findAll();
        $this->view->assign('speakers', $speakers);

        $events = $this->eventRepository->findAll();
        $this->view->assign('events', $events);

        $venues = $this->venueRepository->findAll();
        $this->view->assign('venues', $venues);


        $event = $this->eventRepository->findByUid($session->getEventId()->getUid());
        $eventCpt = $event->getSession();
        if ($eventCpt > 0) {
            $cpt = $eventCpt - 1;
            $event->setSession($cpt);
        }
        $this->eventRepository->update($event);


    }

    /**
     * action update
     *
     * @param \DLD\Dld\Domain\Model\Session $session
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\Session $session)
    {
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($session);die();
        $this->sessionRepository->update($session);
        $this->persistenceManager->persistAll();

        $sessionIds = $this->sessionPeopleRepository->findBySessionId($session->getUid());


        foreach ($sessionIds as $sessionId) {

            $this->sessionPeopleRepository->remove($sessionId);
            $this->persistenceManager->persistAll();
        }

        $speaker = array();

        // or just allow certain properties
        if ($this->request->getArguments()['speakers']) {

            foreach ($this->request->getArgument('speakers') as $sp) {
                $speaker[] = $sp;
            }
        }

        $moderator = array();
        if ($this->request->getArguments()['moderator']) {

            foreach ($this->request->getArgument('moderator') as $sp) {
                $moderator[] = $sp;
            }
        }

        $result = array_merge($speaker, $moderator);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($result);die();
        $unique = array_unique($result);
        foreach ($unique as $p) {
            $people = $this->peopleRepository->findByUid($p);
            $sessionPeople = new \DLD\Dld\Domain\Model\SessionPeople();
            $sessionPeople->setPeopleId($people);
            foreach ($speaker as $sp) {
                if ($p == $sp) {
                    $sessionPeople->setIsSpeaker("1");
                }
            }
            foreach ($moderator as $md) {
                if ($p == $md) {
                    $sessionPeople->setIsModerator("1");
                }
            }
            $sessionPeople->setSessionId($session);

            $this->sessionPeopleRepository->add($sessionPeople);
            $this->persistenceManager->persistAll();
        }


        $this->persistenceManager->persistAll();


        $oldEvent = (int)$this->request->getArgument('oldEvent');

        if ($oldEvent == $session->getEventId()->getUid()) {
            $this->eventUpdateStart($session->getEventId()->getUid());

        } else {

            $eventOld = $this->eventRepository->findByUid($oldEvent);

            $eventStartOld = $this->sessionRepository->getStartFromSession($eventOld->getUid());
            if ($eventStartOld != null) {
                $eventOld->setStart($eventStartOld->getStart());
            } else {
                $this->eventRepository->resetStart($oldEvent);
            }

            $this->eventRepository->update($eventOld);

            $this->eventUpdateStart($session->getEventId()->getUid());
        }

        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DLD\Dld\Domain\Model\Session $session
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\Session $session)
    {
        $this->persistenceManager->persistAll();
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump();die();
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->sessionRepository->remove($session);
        if (sizeof($this->sessionRepository->findByEventId($session->getEventId()->getUid())) > 0) {
            $this->eventUpdateStart($session->getEventId()->getUid());
        } else {
            $this->eventRepository->resetStart($session->getEventId()->getUid());
        }
        $this->redirect('list');
    }

    public function initializeCreateAction()
    {
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArguments());die();
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArgument('newSession')['eventId']);die();
        $this->arguments['newSession']->getPropertyMappingConfiguration()->forProperty('start')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd.m.Y H:i'
        );
        $this->arguments['newSession']->getPropertyMappingConfiguration()->forProperty('end')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd.m.Y H:i'
        );
    }

    public function initializeUpdateAction()
    {
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArguments());die();
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArgument('newSession')['eventId']);die();
        $this->arguments['session']->getPropertyMappingConfiguration()->forProperty('start')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd.m.Y H:i'
        );
        $this->arguments['session']->getPropertyMappingConfiguration()->forProperty('end')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd.m.Y H:i'
        );
    }

    public function eventUpdateStart($id)
    {
        $this->persistenceManager->persistAll();

        $event = $this->eventRepository->findByUid($id);
        $eventCpt = $event->getSession();
        $cpt = $eventCpt + 1;
        $event->setSession($cpt);
        $eventStart = $this->sessionRepository->getStartFromSession($event->getUid());
        $event->setStart($eventStart->getStart());
        $this->eventRepository->update($event);


    }

    /**
     * program update
     *
     * @param \DLD\Dld\Domain\Model\Event $event
     * @return void
     */
    public function programAction(\DLD\Dld\Domain\Model\Event $event)
    {

        $eventdates = $this->sessionRepository->findEventSessionsDate($event->getUid());
        $day = $this->request->getArgument('day');
        $end = $this->sessionRepository->findEnd($event->getUid());
        $settings = $this->settings;
        $eventvenues = $this->sessionRepository->findEventSessionsVenue($event->getUid());

        $this->view->assignMultiple(array('event' => $event, 'venues' => $eventvenues, 'end' => $end, 'dates' => $eventdates, 'settings' => $settings, 'activeday' => $day));


    }

}