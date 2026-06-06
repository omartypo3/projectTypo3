<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_event_mgt" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Pingag\PingagAddress\Controller;

use Pingag\PingagAddress\Domain\Model\Registration;
use DERHANSEN\SfEventMgt\Domain\Model\Dto\CategoryDemand;
use DERHANSEN\SfEventMgt\Domain\Model\Dto\EventDemand;
use DERHANSEN\SfEventMgt\Domain\Model\Dto\ForeignRecordDemand;
use DERHANSEN\SfEventMgt\Domain\Model\Dto\SearchDemand;
use Pingag\PingagAddress\Domain\Model\Event;
use DERHANSEN\SfEventMgt\Event\AfterRegistrationCancelledEvent;
use DERHANSEN\SfEventMgt\Event\AfterRegistrationConfirmedEvent;
use DERHANSEN\SfEventMgt\Event\AfterRegistrationSavedEvent;
use DERHANSEN\SfEventMgt\Event\EventPidCheckFailedEvent;
use DERHANSEN\SfEventMgt\Event\ModifyCalendarViewVariablesEvent;
use DERHANSEN\SfEventMgt\Event\ModifyCancelRegistrationViewVariablesEvent;
use DERHANSEN\SfEventMgt\Event\ModifyConfirmRegistrationViewVariablesEvent;
use DERHANSEN\SfEventMgt\Event\ModifyCreateDependingRegistrationsEvent;
use DERHANSEN\SfEventMgt\Event\ModifyDetailViewVariablesEvent;
use DERHANSEN\SfEventMgt\Event\ModifyListViewVariablesEvent;
use DERHANSEN\SfEventMgt\Event\ModifyRegistrationViewVariablesEvent;
use DERHANSEN\SfEventMgt\Event\ModifySearchViewVariablesEvent;
use DERHANSEN\SfEventMgt\Event\WaitlistMoveUpEvent;
use DERHANSEN\SfEventMgt\Service\EventCacheService;
use DERHANSEN\SfEventMgt\Utility\MessageType;
use DERHANSEN\SfEventMgt\Utility\PageUtility;
use DERHANSEN\SfEventMgt\Utility\RegistrationResult;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use TYPO3\CMS\Core\Database\ConnectionPool;
use WapplerSystems\Cleverreach\CleverReach\Api;
use WapplerSystems\Cleverreach\Domain\Model\Receiver;
use WapplerSystems\Cleverreach\Service\ConfigurationService;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\Mailer;


/**
 * EventController
 */
class EventController extends \DERHANSEN\SfEventMgt\Controller\EventController
{
    const PINGAG_IP = '196.179.244.127';
    /**
     * Initializes the current action
     */
    public function initializeAction()
    {
        $typoScriptFrontendController = $this->getTypoScriptFrontendController();
        if ($typoScriptFrontendController !== null) {
            static $cacheTagsSet = false;

            if (!$cacheTagsSet) {
                $typoScriptFrontendController->addCacheTags(['tx_sfeventmgt']);
                $cacheTagsSet = true;
            }
        }
        $this->eventRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\EventRepository');
        $this->veranstaltungRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\VeranstaltungRepository');
        $this->kursthemenRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KursthemenRepository');
        $this->zielgruppeRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\ZielgruppeRepository');
        $this->spracheRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\SpracheRepository');

    }

    /**
   

    /**
     * Set date format for field dateOfBirth
     */
    public function initializeSaveRegistrationAction()
    {

        $this->registrationRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\RegistrationRepository');
        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($this);
        // die();
        $this->arguments->getArgument('registration')
            ->getPropertyMappingConfiguration()->forProperty('dateOfBirth')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                $this->settings['registration']['formatDateOfBirth'] ?? 'd.m.Y'
            );
        $this->removePossibleSpamCheckFieldsFromArguments();
        $this->setRegistrationFieldValuesToArguments();
    }

    /**
     * Saves the registration
     *
     * @param Registration $registration Registration
     * @param Event $event Event
     * @Extbase\Validate("DERHANSEN\SfEventMgt\Validation\Validator\RegistrationFieldValidator", param="registration")
     * @Extbase\Validate("DERHANSEN\SfEventMgt\Validation\Validator\RegistrationValidator", param="registration")
     *
     * @return mixed|void
     */
    public function saveRegistrationAction(Registration $registration, Event $event)
    {

        if (is_a($event, Event::class) && ($this->settings['registration']['checkPidOfEventRecord'] ?? false)) {
            $event = $this->checkPidOfEventRecord($event);
        }
        if (is_null($event) && isset($this->settings['event']['errorHandling'])) {
            return $this->handleEventNotFoundError($this->settings);
        }
        $autoConfirmation = (bool)($this->settings['registration']['autoConfirmation'] ?? false) ||
            $event->getEnableAutoconfirm();
        $result = RegistrationResult::REGISTRATION_SUCCESSFUL;
        list($success, $result) = $this->registrationService->checkRegistrationSuccess($event, $registration, $result);

        // Save registration if no errors
        if ($success) {
            $isWaitlistRegistration = $this->registrationService->isWaitlistRegistration(
                $event,
                $registration->getAmountOfRegistrations()
            );
            $linkValidity = (int)($this->settings['confirmation']['linkValidity'] ?? 3600);
            if ($linkValidity === 0) {
                // Use 3600 seconds as default value if not set or zero
                $linkValidity = 3600;
            }
            $confirmationUntil = new \DateTime();
            $confirmationUntil->add(new \DateInterval('PT' . $linkValidity . 'S'));

            $registration->setEvent($event);
            $registration->setPid($event->getPid());
            $registration->setRegistrationDate(new \DateTime());
            $registration->setConfirmationUntil($confirmationUntil);
            if($this->request->hasArgument('personaldata')){
                $bool = ($this->request->getArgument('personaldata') == 1) ? TRUE:FALSE;
                $registration->setPersonaldata($bool);
            }else{
                $registration->setPersonaldata(FALSE);
            }
            $registration->setLanguage($this->getCurrentLanguageTwoLetterIsoCode());
            $registration->setFeUser($this->registrationService->getCurrentFeUserObject());
            $registration->setWaitlist($isWaitlistRegistration);

           /* \TYPO3\CMS\Core\Utility\DebugUtility::debug($this->request->getArguments());
            \TYPO3\CMS\Core\Utility\DebugUtility::debug($registration);
            die();*/

            // $this->registrationRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\RegistrationRepository');



            $this->registrationRepository->add($registration);

            // Persist registration, so we have an UID
            $this->persistAll();

            if ($isWaitlistRegistration) {
                $messageType = MessageType::REGISTRATION_WAITLIST_NEW;
            } else {
                $messageType = MessageType::REGISTRATION_NEW;
            }

            $this->eventDispatcher->dispatch(new AfterRegistrationSavedEvent($registration, $this));

            // Send notifications to user and admin if confirmation link should be sent
            if (!$autoConfirmation) {
                $this->notificationService->sendUserMessage(
                    $event,
                    $registration,
                    $this->settings ?? [],
                    $messageType
                );
                $this->notificationService->sendAdminMessage(
                    $event,
                    $registration,
                    $this->settings ?? [],
                    $messageType
                );
            }

            // Create given amount of registrations if necessary
            $modifyCreateDependingRegistrationsEvent = new ModifyCreateDependingRegistrationsEvent(
                $registration,
                ($registration->getAmountOfRegistrations() > 1),
                $this
            );
            $this->eventDispatcher->dispatch($modifyCreateDependingRegistrationsEvent);
            $createDependingRegistrations = $modifyCreateDependingRegistrationsEvent->getCreateDependingRegistrations();
            if ($createDependingRegistrations) {
                $this->registrationService->createDependingRegistrations($registration);
            }

            // Flush page cache for event, since new registration has been added
            $this->eventCacheService->flushEventCache($event->getUid(), $event->getPid());
        }

        if($registration->getNewsletter()){
            $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
            $sys_language_uid = $languageAspect->getId();
            if($sys_language_uid == 0){
                $subject = "Bestätigung Anmeldung für SZBLIND-Kurs + Newsletter Anmeldung";
            }else{
                $subject = "Confirmation d'inscription au cours SZBLIND + inscription à la newsletter";
            }

            $mailsendkommissionen = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mailsendkommissionen
                ->from(new \Symfony\Component\Mime\Address($this->settings['notification']['senderEmail'], $this->settings['notification']['senderName']))
                ->to(
                // new \Symfony\Component\Mime\Address('omar.jmal91@gmail.com')
                    new \Symfony\Component\Mime\Address($registration->getEmail())
                )
                ->subject($subject)
                ->html($this->sendEmailwithdoubleopt($event,$registration,0))
                ->send();

            $resiced = preg_split('/[\s,;]+/', $this->settings['notification']['adminEmail']);
            if (count($resiced) > 1) {
                foreach ($resiced as $key => $resice) {

                    $mailToAdmin = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $mailToAdmin
                        ->from(new \Symfony\Component\Mime\Address($this->settings['notification']['senderEmail'], $this->settings['notification']['senderName']))
                        ->to(
                            new \Symfony\Component\Mime\Address($resice)
                        )
                        ->subject($this->settings['notification']['registrationConfirmed']['adminSubject'])
                        ->html($this->sendEmailwithdoubleopt($event,$registration,1))
                        ->send();
                }
            } else {
                if ($this->settings['notification']['adminEmail']) {
                    $mailToAdminOne = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $mailToAdminOne
                        ->from(new \Symfony\Component\Mime\Address($this->settings['notification']['senderEmail'], $this->settings['notification']['senderName']))
                        ->to(
                            new \Symfony\Component\Mime\Address($this->settings['notification']['adminEmail'])
                        )
                        ->subject($this->settings['notification']['registrationConfirmed']['adminSubject'])
                        ->html($this->sendEmailwithdoubleopt($event,$registration,1))
                        ->send();
                }
            }
            $uriBuilder = $this->controllerContext->getUriBuilder();
            $uriBuilder->reset();

// specify the page ID for the link
            $uriBuilder->setTargetPageUid((int)954);

// specify extra parameters for the link
// At this stage, the variable $keywords will contain a single
// entry, to which the browser will be redirected

            $uri = $uriBuilder->build(); // ready, steady…
            $this->redirectToUri($uri);

        }

        if ($autoConfirmation && $success) {
            $this->redirect(
                'confirmRegistration',
                null,
                null,
                [
                    'reguid' => $registration->getUid(),
                    'hmac' => $this->hashService->generateHmac('reg-' . $registration->getUid()),
                ]
            );
        } else {
            $this->redirect(
                'saveRegistrationResult',
                null,
                null,
                [
                    'result' => $result,
                    'eventuid' => $event->getUid(),
                    'hmac' => $this->hashService->generateHmac('event-' . $event->getUid()),
                ]
            );
        }


    }

    /**
     * Confirms the registration if possible and sends emails to admin and user
     *
     * @param int $reguid UID of registration
     * @param string $hmac HMAC for parameters
     * @return mixed
     */
    public function confirmRegistrationAction(int $reguid, string $hmac)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $setting = $extbaseFrameworkConfiguration['plugin.']['tx_pingagaddress_mapshow.']['settings.']['pageconfirmUid'];

        $event = null;

        /* @var $registration Registration */
        list($failed, $registration, $messageKey, $titleKey) = $this->registrationService->checkConfirmRegistration(
            $reguid,
            $hmac
        );

        if ($failed === false) {
            $registration->setConfirmed(true);
            $event = $registration->getEvent();
            $this->registrationRepository->update($registration);

            $this->eventDispatcher->dispatch(new AfterRegistrationConfirmedEvent($registration, $this));

            $messageType = MessageType::REGISTRATION_CONFIRMED;
            if ($registration->getWaitlist()) {
                $messageType = MessageType::REGISTRATION_WAITLIST_CONFIRMED;
            }

            // Send notifications to user and admin
            $this->notificationService->sendUserMessage(
                $registration->getEvent(),
                $registration,
                $this->settings ?? [],
                $messageType
            );
            $this->notificationService->sendAdminMessage(
                $registration->getEvent(),
                $registration,
                $this->settings ?? [],
                $messageType
            );

            // Confirm registrations depending on main registration if necessary
            if ($registration->getAmountOfRegistrations() > 1) {
                $this->registrationService->confirmDependingRegistrations($registration);
            }
        }

        // Redirect to payment provider if payment/redirect is enabled
        $paymentPid = (int)($this->settings['paymentPid'] ?? 0);
        if (!$failed && $paymentPid > 0 && $this->registrationService->redirectPaymentEnabled($registration)) {
            $this->uriBuilder->reset()
                ->setTargetPageUid($paymentPid);
            $uri = $this->uriBuilder->uriFor(
                'redirect',
                [
                    'registration' => $registration,
                    'hmac' => $this->hashService->generateHmac('redirectAction-' . $registration->getUid()),
                ],
                'Payment',
                'sfeventmgt',
                'Pipayment'
            );
            $this->redirectToUri($uri);
        }

        $modifyConfirmRegistrationViewVariablesEvent = new ModifyConfirmRegistrationViewVariablesEvent(
            [
                'failed' => $failed,
                'messageKey' => $messageKey,
                'titleKey' => $titleKey,
                'event' => $event,
                'registration' => $registration,
            ],
            $this
        );
        $this->eventDispatcher->dispatch($modifyConfirmRegistrationViewVariablesEvent);
        $variables = $modifyConfirmRegistrationViewVariablesEvent->getVariables();
        $this->view->assignMultiple($variables);


        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();

// specify the page ID for the link
        $uriBuilder->setTargetPageUid((int)$setting);

// specify extra parameters for the link
// At this stage, the variable $keywords will contain a single
// entry, to which the browser will be redirected

        $uri = $uriBuilder->build(); // ready, steady…
        $this->redirectToUri($uri); // …go!

        return $this->htmlResponse();
    }

    /**
     * List view
     *
     * @param array $overwriteDemand OverwriteDemand
     */
    public function listAction(array $overwriteDemand = []): ResponseInterface
    {
        //header("Access-Control-Allow-Origin: *");

        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);

        $eventDemand = EventDemand::createFromSettings($this->settings);

        $foreignRecordDemand = ForeignRecordDemand::createFromSettings($this->settings);
        $categoryDemand = CategoryDemand::createFromSettings($this->settings);
        if ($this->isOverwriteDemand($overwriteDemand)) {
            $eventDemand = $this->overwriteEventDemandObject($eventDemand, $overwriteDemand);
        }

      /* if($debug){
            \TYPO3\CMS\Core\Utility\DebugUtility::debug( $this->eventRepository);
       }*/

       // \TYPO3\CMS\Core\Utility\DebugUtility::debug($this->settings);
        if($this->request->hasArgument('type')) {
            $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
            $sys_language_uid = $languageAspect->getId();
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
            $statement = $queryBuilder
                ->select('*')
                ->from('tt_content')
                ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($this->request->getArgument('uidPage'), \PDO::PARAM_INT)))
                ->andWhere($queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter($sys_language_uid, \PDO::PARAM_INT)))

                ->execute();
            $all = [];
            while ($row = $statement->fetch()) {
                // Do something useful with that single $row
                if($row['list_type'] == 'sfeventmgt_pieventlist'){
                    $flexFormData = $flexFormData = GeneralUtility::xml2array($row['pi_flexform']);
                    $detailPid   = $flexFormData['data']['additional']['lDEF']['settings.detailPid']['vDEF'];
                    $settings['detailPid'] = $detailPid;
                    $this->view->assign('settings', $settings);

                }
            }

            $events = $this->eventRepository->findEventAjax($this->request->getArgument('type'));


        }else{
            $events = $this->eventRepository->findDemanded($eventDemand);
        }

        /*$allEvents = [];
        if($debug){
            foreach ($events as $event){
                if($event->getStartdate() > new \DateTime()){
                    array_push($allEvents,$event);
                }
            }

            \TYPO3\CMS\Core\Utility\DebugUtility::debug($events);

        }*/
        $pagenate = $this->getPagination($events, $this->settings['pagination'] ?? []);
        //$pagenate = $this->getPagination($allEvents, $this->settings['pagination'] ?? []);
        $categories = $this->categoryRepository->findDemanded($categoryDemand);
        $locations = $this->locationRepository->findDemanded($foreignRecordDemand);
        $organisators = $this->organisatorRepository->findDemanded($foreignRecordDemand);
        $speakers = $this->speakerRepository->findDemanded($foreignRecordDemand);


        $modifyListViewVariablesEvent = new ModifyListViewVariablesEvent(
            [
                'events' => $events,
                'pagination' => $pagenate,
                'categories' => $categories,
                'locations' => $locations,
                'organisators' => $organisators,
                'speakers' => $speakers,
                'overwriteDemand' => $overwriteDemand,
                'eventDemand' => $eventDemand,
                'veranstaltungs' => $this->veranstaltungRepository->findAll(),
                'zielgruppes' => $this->zielgruppeRepository->findAll(),
                'kursthemens' => $this->kursthemenRepository->findAll(),
                'spraches' => $this->spracheRepository->findAll(),
            ],
            $this
        );
        $this->eventDispatcher->dispatch($modifyListViewVariablesEvent);
        $variables = $modifyListViewVariablesEvent->getVariables();
        $this->view->assignMultiple($variables);



        $this->eventCacheService->addPageCacheTagsByEventDemandObject($eventDemand);

        return $this->htmlResponse();
    }

    public function getUidEvent($table,$val)
    {
        $all = [];
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($table)->createQueryBuilder();
        $result = $queryBuilder
            ->select('uid_local')
            ->from($table)
            ->join(
                $table,
                'tx_sfeventmgt_domain_model_event',
                'e',
                $queryBuilder->expr()->eq('e.uid', $queryBuilder->quoteIdentifier($table.'.uid_local'))
            )
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $val)
            )
           ->andwhere(
                $queryBuilder->expr()->eq('e.sys_language_uid', $queryBuilder->createNamedParameter($languageAspect->getId(), \PDO::PARAM_INT))
            )
            ->executeQuery();
        while ($row = $result->fetchAssociative()) {
            // Do something with that single row
            array_push($all,$row['uid_local']);
        }
        return $all;
    }

    /**
     * Detail view for an event
     *
     * @param Event|null $event Event
     * @return mixed
     */
    public function detailAction(?Event $event = null)
    {
        $event = $this->evaluateSingleEventSetting($event);
        $event = $this->evaluateIsShortcutSetting($event);
        if (is_a($event, Event::class) && ($this->settings['detail']['checkPidOfEventRecord'] ?? false)) {
            $event = $this->checkPidOfEventRecord($event);
        }

        if (is_null($event) && isset($this->settings['event']['errorHandling'])) {
            return $this->handleEventNotFoundError($this->settings);
        }

        $modifyDetailViewVariablesEvent = new ModifyDetailViewVariablesEvent(['event' => $event], $this);
        $this->eventDispatcher->dispatch($modifyDetailViewVariablesEvent);
        $variables = $modifyDetailViewVariablesEvent->getVariables();

        $this->view->assignMultiple($variables);
        if ($event !== null) {
            $this->eventCacheService->addCacheTagsByEventRecords([$event]);
        }

        return $this->htmlResponse();
    }


    public function sendEmailwithdoubleopt($event,$regestration,$nbr){

        $resultat = "<ul>";
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        if($sys_language_uid == 0){
            $numero = 'Kurs Nr.:';
            $Titre = 'Kurstitel:';
            $date = 'Datum:';
            $genderf = 'Anrede: Frau';
            $genderm = 'Anrede: Herr';
            $gendern = 'Anrede: Neutral';
            $last = 'Name:';
            $first = 'Vorname:';
            $Adresse = 'Adresse:';
            $NPA = 'PLZ:';
            $Ort = 'Ort:';
            $Telefon = 'Telefon:';
            $mail = ' E-Mail:';
            $Firma = ' Firma:';
            $Tatigkeit = ' Tätigkeit:';
            $billac = ' Rechnung an die Adresse des Arbeitgebers';
            $billnotac = ' Rechnung an meine Privatadresse';
            $Documentsac = ' Schicken Sie mir alle Unterlagen an: Arbeitsadresse inkl. E-Mail';
            $Documentsnotac = ' Schicken Sie mir alle Unterlagen an: Privatadresse inkl. E-Mail';
            $situations = 'Ich bin sehend';
            $situationb = 'Ich bin sehbehindert / blind';
            $situationnotbc = 'Ich bin hörbehindert';
            $Mitteilung = 'Mitteilung:';
            $NewsletterJa = 'Newsletter: Ja';
            $NewsletterNein = ' Newsletter: Nein';
            $inscription = ' Sollten Sie die Kursanmeldung versehentlich ausgelöst haben, melden Sie dies bitte an <a href="mailto:bildung@szblind.ch">bildung@szblind.ch</a> und wir machen diese rückgängig. ';
            $url = "https://www.szblind.ch/";
        }else{
            $numero = 'Numéro de cours';
            $Titre = 'Titre de cours :';
            $date = 'Date:';
            $genderf = 'Titre: Madame';
            $genderm = 'Titre: Mr.';
            $gendern = 'Titre: Neutral';
            $last = 'Nom:';
            $first = 'Prénom:';
            $Adresse = 'Adresse:';
            $NPA = 'NPA:';
            $Ort = 'Lieu:';
            $Telefon = 'Téléphone:';
            $mail = ' E-Mail:';
            $Firma = ' Firme:';
            $Tatigkeit = ' Activité présente:';
            $billac = ' Facture à l\'adresse professionnelle';
            $billnotac = ' Facture à l\'adresse privée';
            $Documentsac = ' S’il-vous-plaît envoyer tous documents du cours à: l\'adresse professionnelle inclus e-mail';
            $Documentsnotac = ' S’il-vous-plaît envoyer tous documents du cours à: l\'adresse privée inclus e-mail';
            $situations = 'Je suis voyant(e)';
            $situationb = 'Je suis malvoyant(e) / aveugle';
            $situationnotbc = 'Je suis malvoyant(e)-malentendant(e)';
            $Mitteilung = 'Remarque:';
            $NewsletterJa = 'Newsletter: oui';
            $NewsletterNein = 'Newsletter: non';
            $inscription = "Si vous avez effectué une inscription au cours par erreur, veuillez le signaler à <a href='mailto:fomation@ucba.ch'>fomation@ucba.ch</a> et nous l\'annulerons.";
            $url = "https://www.ucba.ch/";
        }

        $uid = $this->countTable();

        $formId = $this->settings['cleverReachFormID'];
        $groupId = $this->settings['cleverReachGroupID'];
        $cleverreach = $this->settings['orderBy'];

        $link = $url.$this->getSlugPage()."?tx_pingagaddress_mapshow%5Baction%5D=confirm&tx_pingagaddress_mapshow%5Bcontroller%5D=Map&tx_pingagaddress_mapshow%5Bregistration%5D=".$uid."&tx_pingagaddress_mapshow%5BformId%5D=".$formId."&tx_pingagaddress_mapshow%5BgroupId%5D=".$groupId."&tx_pingagaddress_mapshow%5Bcleverreach%5D=".$cleverreach;
        if ($sys_language_uid == 0) {
            $textlink = "Bitte klicken Sie hier, um die Newsletter Anmeldung zu bestätigen";
        }else if ($sys_language_uid == 1) {
            $textlink = "Please click here to confirm the newsletter subscription.";
        }else if ($sys_language_uid == 2) {
            $textlink = "Veuillez cliquer ici pour confirmer l'inscription à la newsletter.";
        }else if ($sys_language_uid == 3) {
            $textlink = "Clicca qui per confermare l'iscrizione alla newsletter.";
        }


        $resultat .= "<li>".$numero." ".$event->getTitle()."</li>";
        $resultat .= "<li>".$Titre." ".$event->getTeaser()."</li>";
        if($this->changeDate($event->getEnddate()) == $this->changeDate($event->getStartdate())){
            if($event->getOtherdates()){
                $resultat .= "<li>".$date." ".$event->getOtherdates()."</li>";
            }else{
                $resultat .= "<li>".$date." ".$this->changeDate($event->getStartdate())." - ".$this->changeDate($event->getEnddate()). "</li>";
            }
        }else{
            if($event->getOtherdates()){
                $resultat .= "<li>".$date." ".$event->getOtherdates()."</li>";
            }else{
                $resultat .= "<li>".$date." ".$this->changeDate($event->getStartdate())." - ".$this->changeDate($event->getEnddate()). "</li>";
            }
        }
        if($regestration->getGender() == 'f') {
            $resultat .= "<li>" . $genderf . "</li>";
        }
        if($regestration->getGender() == 'm') {
            $resultat .= "<li>" . $genderm . "</li>";
        }
        if($regestration->getGender() == 'n') {
            $resultat .= "<li>" . $gendern . "</li>";
        }
        $resultat .= "<li>".$last." ".$regestration->getLastname()."</li>";
        $resultat .= "<li>".$first." ".$regestration->getFirstname()."</li>";
        $resultat .= "<li>".$Adresse." ".$regestration->getAddress()."</li>";
        $resultat .= "<li>".$NPA." ".$regestration->getZip()."</li>";
        $resultat .= "<li>".$Ort." ".$regestration->getCity()."</li>";
        $resultat .= "<li>".$Telefon." ".$regestration->getPhone()."</li>";
        $resultat .= "<li>".$mail." ".$regestration->getEmail()."</li>";
        $resultat .= "<li>".$Firma." ".$regestration->getCompany()."</li>";
        $resultat .= "<li>".$Adresse." ".$regestration->getAaddress()."</li>";
        $resultat .= "<li>".$NPA." ".$regestration->getAzip()."</li>";
        $resultat .= "<li>".$Ort." ".$regestration->getAcity()."</li>";
        $resultat .= "<li>".$Telefon." ".$regestration->getAphone()."</li>";
        if($regestration->getAemail()){
            $resultat .= "<li>".$mail." ".$regestration->getAemail()."</li>";
        }else{
            $resultat .= "<li>".$mail." ".$regestration->getEmail()."</li>";
        }
        $resultat .= "<li>".$Tatigkeit." ".$regestration->getAjob()."</li>";
        if($regestration->getBill() == 'c' || $regestration->getBill() == 'a'){
            $resultat .= "<li>".$billac."</li>";
        }else{
            $resultat .= "<li>".$billnotac."</li>";
        }
        if($regestration->getDocuments() == 'c' || $regestration->getDocuments() == 'a'){
            $resultat .= "<li>".$Documentsac."</li>";
        }else{
            $resultat .= "<li>".$Documentsnotac."</li>";
        }

        if($regestration->getSituation() == 's') {
            $resultat .= "<li>" . $situations . "</li>";
        }
        else if($regestration->getSituation() == 'b') {
            $resultat .= "<li>" . $situationb . "</li>";
        }
       else{
            $resultat .= "<li>" . $situationnotbc . "</li>";
        }
        $resultat .= "<li>".$Mitteilung." ".$regestration->getNotes()."</li>";
        if($regestration->getNewsletter() == 1){
            $resultat .= "<li>".$NewsletterJa."</li>";
        }else{
            $resultat .= "<li>".$NewsletterNein."</li>";
        }
        $resultat .= "</ul>";
        if($nbr == 0) {
            $resultat .= "<br> <a href='" . $link . "'>" . $textlink . "</a> <br> <br>";
        }
        $resultat .= $inscription;




        return $resultat;


    }


    public function changeDate($date){
        $newDate = date_format($date,"m-d-Y");
        return $newDate;
    }

    public function countTable(){

        $fields = '*';
        $table = 'tx_sfeventmgt_domain_model_registration';
        $where = '';
        $groupBy = '';
        $orderBy = 'uid DESC';
        $limit = '1';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        return $record['uid'];
    }

    public function getSlugPage(){
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        if($sys_language_uid == 0) {
            $fields = 'slug';
            $table = 'pages';
            $where = 'pages.uid = 953';
            $groupBy = '';
            $orderBy = '';
            $limit = '1';
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
            $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        }else{
            $uidTranslate = $this->translePageTable($sys_language_uid);
            $fields = 'slug';
            $table = 'pages';
            $where = 'pages.uid ='.$uidTranslate;
            $groupBy = '';
            $orderBy = '';
            $limit = '1';
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
            $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        }
        return $record['slug'];
    }

    public function translePageTable($sys_language_uid){

        $fields = 'uid';
        $table = 'pages';
        $where = 'pages.l10n_parent = 953 AND pages.sys_language_uid ='.$sys_language_uid;
        $groupBy = '';
        $orderBy = '';
        $limit = '1';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        return $record['uid'];
    }


}
