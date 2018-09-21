<?php
namespace Wng\WngCvciNews\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
 *
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * EventController
 */
class NewsController extends \GeorgRinger\News\Controller\NewsController {

	/**
	 * eventRepository
	 *
	 * @var \Wng\WngCvciNews\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository;

    /**
     * eventEmailRepository
     *
     * @var \Wng\WngCvciNews\Domain\Repository\EventEmailRepository
     * @inject
     */
    protected $eventEmailRepository;

    /**
     * frontendUserRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * @const string Retour de ligne dans les fichiers ICS
     * @access public
     */
    const LB = "\r\n";

    /**
   	 * Initializes the settings
     *
     * @param array $settings
   	 * @return array $settings
   	 */
   	protected function initializeSettings($settings) {
        if (isset($settings['event']['dateField'])) {
            $settings['dateField'] = $settings['event']['dateField'];
        } else {
            $settings['dateField'] = 'eventStartDate';
        }

        //Filter
        if (isset($settings['filter']['theme'])) {
            $settings['theme'] = $settings['filter']['theme'];
        }
        if (isset($settings['filter']['statut'])) {
            $settings['statut'] = $settings['filter']['statut'];
        }

        return $settings;
   	}

    /**
     * Overrides setViewConfiguration: Use event view configuration instead of news view configuration if an event
     * controller action is used
     *
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     * @return void
     */
    protected function setViewConfiguration(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view) {
        $extbaseFrameworkConfiguration =
            $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK);

        // Fetch the current controller action which is set in the news plugin
        $controllerConfigurationAction = implode(';', $extbaseFrameworkConfiguration['controllerConfiguration']['News']['actions']);

        parent::setViewConfiguration($view);

        // Check if the current controller configuration action matches with one of the event controller actions
        foreach($GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems'] as $switchableControllerActions => $value) {
            $action = str_replace('News->', '', $switchableControllerActions);

            if(strpos($action, $controllerConfigurationAction) !== FALSE) {
                // the current controller configuration action matches with one of the event controller actions: set event view configuration
                if(strpos($action, 'event')===0){
                    $this->setEventViewConfiguration($view);
                } else {
                    //Filter
                    //$this->setFilterViewConfiguration($view);
                }
            }
            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(get_class_methods($view),"viewMethods");
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($view->getTemplatePaths(),"getTemplatePaths");
        }
    }

    /**
     * Override templateRootPath, layoutRootPath and/or partialRootPath of the news view with event specific settings
     *
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     * @param array $extbaseFrameworkConfiguration
     * @return void
     */
    protected function setEventViewConfiguration(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view) {
        // Template Path Override
        $extbaseFrameworkConfiguration =
            $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK);

        if (isset($extbaseFrameworkConfiguration['view']['event']['templateRootPath'])
            && strlen($extbaseFrameworkConfiguration['view']['event']['templateRootPath']) > 0
            && method_exists($view, 'setTemplateRootPaths')) {
            $view->setTemplateRootPaths(array(0=>GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['event']['templateRootPath'])));
        }
        if (isset($extbaseFrameworkConfiguration['view']['event']['layoutRootPath'])
            && strlen($extbaseFrameworkConfiguration['view']['event']['layoutRootPath']) > 0
            && method_exists($view, 'setLayoutRootPaths')) {
            $view->setLayoutRootPaths(array(0=>GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['event']['layoutRootPath'])));
        }
        if (isset($extbaseFrameworkConfiguration['view']['event']['partialRootPath'])
            && strlen($extbaseFrameworkConfiguration['view']['event']['partialRootPath']) > 0
            && method_exists($view, 'setPartialRootPaths')) {
            $view->setPartialRootPaths(array(0=>GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['event']['partialRootPath'])));
        }
    }

    /**
     * Create the demand object which define which records will get shown
     *
     * @param array $settings
     * @return \GeorgRinger\News\Domain\Model\Dto\NewsDemand
     */
    protected function eventCreateDemandObjectFromSettings($settings) {
        $demand = $this->createDemandObjectFromSettings($settings);
        $orderByAllowed = $demand->getOrderByAllowed();

        if(sizeof($orderByAllowed) > 0) {
            $orderByAllowed .= ',';
        }

        // set ordering
        if($settings['event']['orderByAllowed']) {
            $demand->setOrderByAllowed($orderByAllowed . str_replace(' ', '', $settings['event']['orderByAllowed']));
        } else {
            // default orderByAllowed list
            $demand->setOrderByAllowed($orderByAllowed . 'tx_wngcvcinews_start_date,tx_wngcvcinews_start_time');
        }

        if($demand->getArchiveRestriction() == 'archived') {
            if ($settings['event']['archived']['orderBy']) {
                $demand->setOrder($settings['event']['archived']['orderBy']);
            } else {
                // default ordering for archived events
                $demand->setOrder('tx_wngcvcinews_start_date DESC, tx_wngcvcinews_start_time DESC');
            }
        } else {
            if ($settings['event']['orderBy']) {
                $demand->setOrder($settings['event']['orderBy']);
            } else {
                // default ordering for active events
                $demand->setOrder('tx_wngcvcinews_start_date ASC, tx_wngcvcinews_start_time ASC');
            }
        }

        if($settings['event']['startingpoint']) {
            $demand->setStoragePage(\GeorgRinger\News\Utility\Page::extendPidListByChildren($settings['event']['startingpoint'], $settings['recursive']));
        }

        return $demand;
    }

    /**
     * Render a menu by dates, e.g. years, months or dates
     *
     * @param array $overwriteDemand
     * @return void
     */
    public function eventDateMenuAction(array $overwriteDemand = NULL) {
        $this->settings = $this->initializeSettings($this->settings);
        $demand = $this->eventCreateDemandObjectFromSettings($this->settings);

        $eventRecords = $this->eventRepository->findDemanded($demand);

        if (!$dateField = $this->settings['dateField']) {
            $dateField = 'eventStartDate';
        }

        $this->view->assignMultiple(array(
            'listPid' => ($this->settings['listPid'] ? $this->settings['listPid'] : $GLOBALS['TSFE']->id),
            'dateField' => $dateField,
            'events' => $eventRecords,
            'overwriteDemand' => $overwriteDemand,
        ));
    }

    /**
     * Output a list view of news events
     *
     * @param array $overwriteDemand
     * @return string the Rendered view
     */
    public function eventListAction(array $overwriteDemand = NULL) {
        $this->settings = $this->initializeSettings($this->settings);
            $demand = $this->eventCreateDemandObjectFromSettings($this->settings);

        if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
            $demand = $this->overwriteDemandObject($demand, $overwriteDemand);
        }

        $newsRecords = $this->eventRepository->findDemanded($demand);
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($newsRecords,"news");
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->view,"view");
        $this->view->assignMultiple(array(
            'news' => $newsRecords,
            'overwriteDemand' => $overwriteDemand,
        ));
    }

    /**
     * Output a list view of news events
     *
     * @param array $overwriteDemand
     * @return string the Rendered view
     */
    public function eventSearchListAction(array $overwriteDemand = NULL) {
        $this->settings = $this->initializeSettings($this->settings);
        $demand = $this->eventCreateDemandObjectFromSettings($this->settings);

        if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
            $demand = $this->overwriteDemandObject($demand, $overwriteDemand);
        }

        $newsRecords = $this->eventRepository->findDemanded($demand);

        $this->view->assignMultiple(array(
            'news' => $newsRecords,
            'overwriteDemand' => $overwriteDemand,
        ));

        //Filter
        $idList = explode(',', $this->settings['categoriesFilter']);

        $startingPoint = null;
        if (!empty($this->settings['startingpoint'])) {
            $startingPoint = $this->settings['startingpoint'];
        }

        $this->view->assignMultiple(array(
            'categories' => $this->categoryRepository->findTree($idList, $startingPoint),
            //'overwriteDemand' => $overwriteDemand,
            //'demand' => $demand,
        ));
    }

    /**
     * Single view of a news event record
     *
     * @param \Wng\WngCvciNews\Domain\Model\Event $event
     * @param integer $currentPage current page for optional pagination
     * @return void
     */
    public function eventDetailAction(\Wng\WngCvciNews\Domain\Model\Event $event = NULL, $currentPage = 1, \Wng\WngCvciNews\Domain\Model\EventEmail $eventEmail = NULL) {
        $this->settings = $this->initializeSettings($this->settings);

        if (is_null($event)) {
            if ((int)$this->settings['singleNews'] > 0) {
                $previewNewsId = $this->settings['singleNews'];
            } elseif ($this->request->hasArgument('news_preview')) {
                $previewNewsId = $this->request->getArgument('news_preview');
            } else {
                $previewNewsId = $this->request->getArgument('news');
            }

            if ($this->settings['previewHiddenRecords']) {
                $event = $this->eventRepository->findByUid($previewNewsId, FALSE);
            } else {
                $event = $this->eventRepository->findByUid($previewNewsId);
            }
        }

        if (is_null($event) && isset($this->settings['detail']['errorHandling'])) {
            $this->handleNoNewsFoundError($this->settings['detail']['errorHandling']);
        }

        $this->view->assignMultiple(array(
            'newsItem' => $event,
            'currentPage' => (int)$currentPage,
        ));

        \GeorgRinger\News\Utility\Page::setRegisterProperties($this->settings['detail']['registerProperties'], $event);

        //Configuration
        $extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['wng_cvci_news']);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($extensionConfiguration,"extensionConfiguration");
        $this->view->assignMultiple(array(
            'extConf' => $extensionConfiguration,
        ));
        //Save Event Email
        $input = GeneralUtility::_POST();
        //Verification de formulaire
        $errorMessage = "";
        $errorForm = FALSE;
        if(!isset($input["tx_news_pi1"]["newEventEmail"]["firstname"]) || empty($input["tx_news_pi1"]["newEventEmail"]["firstname"])){
            $errorMessage .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.error.empty", "wng_cvci_news", array(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.firstname", "wng_cvci_news")))."<br/>";
            $errorForm = TRUE;
        }
        if(!isset($input["tx_news_pi1"]["newEventEmail"]["lastname"]) || empty($input["tx_news_pi1"]["newEventEmail"]["lastname"])){
            $errorMessage .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.error.empty", "wng_cvci_news", array(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.lastname", "wng_cvci_news")))."<br/>";
            $errorForm = TRUE;
        }
        if(!isset($input["tx_news_pi1"]["newEventEmail"]["email"]) || empty($input["tx_news_pi1"]["newEventEmail"]["email"])){
            $errorMessage .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.error.empty", "wng_cvci_news", array(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.email", "wng_cvci_news")))."<br/>";
            $errorForm = TRUE;
        } elseif(!filter_var($input["tx_news_pi1"]["newEventEmail"]["email"], FILTER_VALIDATE_EMAIL)){
            $errorMessage .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.error.email", "wng_cvci_news")."<br/>";
            $errorForm = TRUE;
        }
        if(!$GLOBALS['TSFE']->fe_user->user['uid']) {
            if(!isset($input["g-recaptcha-response"]) || empty($input["g-recaptcha-response"])){
                $errorMessage .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.error.empty", "wng_cvci_news", array(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.captcha", "wng_cvci_news")))."<br/>";
                $errorForm = TRUE;
            } elseif(!$this->isValidCaptcha()){
                $errorMessage .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.error.captcha", "wng_cvci_news")."<br/>";
                $errorForm = TRUE;
            }
        }
        //Pré-remplir le formulaire si l'utilisateur FE est connecté
        if($GLOBALS['TSFE']->fe_user->user['uid']) {
            $feUser = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);

            $newEventEmail = GeneralUtility::makeInstance('Wng\\WngCvciNews\\Domain\\Model\\EventEmail');
            $newEventEmail->setFirstname($feUser->getFirstName());
            $newEventEmail->setLastname($feUser->getLastName());
            $newEventEmail->setCompany($feUser->getCompany());
            $newEventEmail->setJobfield($feUser->getTitle());
            $newEventEmail->setAddress($feUser->getAddress());
            $newEventEmail->setZip($feUser->getZip());
            $newEventEmail->setCity($feUser->getCity());
            $newEventEmail->setPhone($feUser->getTelephone());
            $newEventEmail->setEmail($feUser->getEmail());

            $this->view->assignMultiple(array(
                'newEventEmail' => $newEventEmail,
            ));
        }

        if(isset($input["tx_news_pi1"]["newEventEmail"]) && !empty($input["tx_news_pi1"]["newEventEmail"])) {

            $newEventEmail = GeneralUtility::makeInstance('Wng\\WngCvciNews\\Domain\\Model\\EventEmail');
            $newEventEmail->setFirstname($input["tx_news_pi1"]["newEventEmail"]["firstname"]);
            $newEventEmail->setLastname($input["tx_news_pi1"]["newEventEmail"]["lastname"]);
            $newEventEmail->setCompany($input["tx_news_pi1"]["newEventEmail"]["company"]);
            $newEventEmail->setJobfield($input["tx_news_pi1"]["newEventEmail"]["jobfield"]);
            $newEventEmail->setAddress($input["tx_news_pi1"]["newEventEmail"]["address"]);
            $newEventEmail->setZip($input["tx_news_pi1"]["newEventEmail"]["zip"]);
            $newEventEmail->setCity($input["tx_news_pi1"]["newEventEmail"]["city"]);
            $newEventEmail->setPhone($input["tx_news_pi1"]["newEventEmail"]["phone"]);
            $newEventEmail->setMobile($input["tx_news_pi1"]["newEventEmail"]["mobile"]);
            $newEventEmail->setEmail($input["tx_news_pi1"]["newEventEmail"]["email"]);
            $newEventEmail->setAperitif($input["tx_news_pi1"]["newEventEmail"]["aperitif"]);
            $newEventEmail->setApparaitre($input["tx_news_pi1"]["newEventEmail"]["apparaitre"]);
            $newEventEmail->setComments($input["tx_news_pi1"]["newEventEmail"]["comments"]);

            if(!$errorForm){
                $newEventEmail->setEvent($event);
                if($GLOBALS['TSFE']->fe_user->user['uid']) {
                    $feUser = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
                    $newEventEmail->setUser($feUser);
                }
                $newEventEmail->setPid($this->settings['startingpoint']);
                $this->eventEmailRepository->add($newEventEmail);

                $this->view->assignMultiple(array(
                    'newEventEmail' => $newEventEmail,
                ));
                //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($newEventEmail,"newEventEmail");

                /*
                 * Send Email
                 */

                // Génération du ICS
                $ics = $this->createICSstring($event);

                // Email
                $mailEvent = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
                $mailEvent->setFrom(array($extensionConfiguration['emailFrom'] => $extensionConfiguration['emailFromName']));
                //$mailEvent->setFrom(array("bel@wng.ch" => "Chambre vaudoise du commerce et de l'industrie"));
                $mailEvent->setTo(array($input["tx_news_pi1"]["newEventEmail"]["email"] => $input["tx_news_pi1"]["newEventEmail"]["firstname"].' '.$input["tx_news_pi1"]["newEventEmail"]["lastname"]));
                //$mailEvent->setTo(array("bel@wng.ch" => "Bilel ELLOUZE"));
                $mailEvent->setSubject(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.title", "wng_cvci_news", array($event->getTitle())));
                $mailEvent->setBody($this->buildEventInvitationBody($event), 'text/plain');

                // Ajoute l'invitation en pièce jointe
                $attachment = \Swift_Attachment::newInstance()->setFilename('cvci-event-invitation.ics')->setContentType('text/calendar')->setBody($ics);
                $mailEvent->attach($attachment);

                // Envoi -.-'
               // $mailEvent->send();

                $mailEventNotification = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
                $mailEventNotification->setFrom(array($input["tx_news_pi1"]["newEventEmail"]["email"] => $input["tx_news_pi1"]["newEventEmail"]["firstname"].' '.$input["tx_news_pi1"]["newEventEmail"]["lastname"]));
                $mailEventNotification->setTo(array($event->getAuthorEmail()));
                //$mailEventNotification->setBcc('bel@wng.ch');//$mailEventNotification->setBcc('webmaster@cvci.ch');
                $mailEventNotification->setSubject(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.title", "wng_cvci_news", array($event->getTitle())));
                $mailEventNotification->setBody($this->buildEventNotificationBody($event, $input), 'text/html');
                // Envoi
                //$mailEventNotification->send();

                $this->view->assign("validMessage", \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("tx_wngcvcinews_domain_model_eventemail.valid.message", "wng_cvci_news"));
                //$this->redirect('eventList');

            } else {
                $this->view->assignMultiple(array(
                    'newEventEmail' => $newEventEmail,
                    "errorMessage" => $errorMessage,
                ));
            }
        }

        /*
         * List Participants
         */

        //Récupérer les paramètres de configuration de l'extension
        //Vérifier si l'événement à la catégorie Evénement CVCI[25] ou Evénement Partenaires[26]
        $theme = 0;
        $res = $GLOBALS['TYPO3_DB']->exec_SELECT_queryArray(array(
            'SELECT' => 'uid_local',
            'FROM' => 'sys_category_record_mm',
            'WHERE' => "uid_foreign = ".$event->getUid()." AND tablenames = 'tx_news_domain_model_news' AND fieldname = 'categories'"
        ));
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            if (in_array($row['uid_local'], array(2))){//25
                $theme = 1;
                break;
            }
        }
        $this->view->assign('theme', $theme);

        $confArray = unserialize($GLOBALS["TYPO3_CONF_VARS"]["EXT"]["extConf"]["wng_cvci_news"]);

        $showListParticipant = $event->getEventParticipant();
        if(!$showListParticipant) {
            //Vérifier si (la date de fin de l'événement - nombre de jour choisir dans la configuaration) est supérieur ou égal à la date d'aujourd'hui.
            $newDate = strtotime('-'.$confArray['nbJour'].' day', $event->getEventStartDate()->getTimestamp());
            $now = strtotime("now");
            $show = ($newDate >= $now) ? 0 : 1;
            $this->view->assign('show', $show);
            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($show,"show");
            //Vérifier si l'événement à la catégorie Evénement CVCI[25] ou Evénement Partenaires[26]
            $theme = 0;
            $res = $GLOBALS['TYPO3_DB']->exec_SELECT_queryArray(array(
                'SELECT' => 'uid_local',
                'FROM' => 'sys_category_record_mm',
                'WHERE' => "uid_foreign = ".$event->getUid()." AND tablenames = 'tx_news_domain_model_news' AND fieldname = 'categories'"
            ));
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                if (in_array($row['uid_local'], array(2))){//25
                    $theme = 1;
                    break;
                }
            }
            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($theme,"theme");
            //Envoyer la liste des particiapants qu'ils acceptent d'afficher leurs noms.
            if($show and $theme) {
                $eventsEmails = $this->eventEmailRepository->findByEventShow($event->getUid());
                $this->view->assign('eventsEmails', $eventsEmails);
                //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($eventsEmails,"eventsEmails");
            }
        }
    }

    /**
     * Génère le contenu du fichier .ics
     *
     * @param \Wng\WngCvciNews\Domain\Model\Event $event
     * @return string Le contenu du fichier
     */
    protected function createICSstring($event) {
        // Dates
        $start = date_format($event->getEventStartDate(), 'Ymd').'T'.date_format($event->getEventStartTime(), 'His');
        $end = date_format($event->getEventEndDate(), 'Ymd').'T'.date_format($event->getEventEndTime(), 'His');
        //SUMMARY
        $summary = $event->getTitle();
        // Catégories
        $categories = $event->getAllCategoryText();
        // Location
        $location = $event->getEventLocation();
        //Description
        $description = substr($event->getBodytext(), 0, 100).'...';
        //TRANSP
        $transp = 'OPAQUE';

        $ics = 'BEGIN:VCALENDAR'.self::LB;
        $ics .= 'VERSION:2.0'.self::LB;
        $ics .= 'PRODID:-//hacksw/handcal//NONSGML v1.0//EN'.self::LB;
        $ics .= 'BEGIN:VEVENT'.self::LB;
        $ics .= 'DTSTART:'.$start.self::LB;
        $ics .= 'DTEND:'.$end.self::LB;
        $ics .= 'SUMMARY:'.$summary.self::LB;
        $ics .= 'LOCATION:'.$location.self::LB;
        $ics .= 'CATEGORIES:Chambre Vaudoise du Commerce et de l\'Industrie'.self::LB;
        //	$ics .= 'CATEGORIES:'.$categories.self::LB;
        $ics .= 'STATUS:CONFIRMED'.self::LB;
        $ics .= 'DESCRIPTION:'.$description.self::LB;
        $ics .= 'TRANSP:'.$transp.self::LB;
        $ics .= 'END:VEVENT'.self::LB;
        $ics .= 'END:VCALENDAR'.self::LB;

        return $ics;
    }


    /**
     * Crée le contenu de l'email l10n
     *
     * @param \Wng\WngCvciNews\Domain\Model\Event $event
     * @return string Le contenu
     */
    protected function buildEventInvitationBody(\Wng\WngCvciNews\Domain\Model\Event $event) {
        $body = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.header", "wng_cvci_news")."\n\n";
        $body .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.message", "wng_cvci_news", array($event->getTitle(), strftime('%d %B %Y', $event->getEventStartDate()->getTimestamp()), strftime('%H:%M', $event->getEventStartTime()->getTimestamp())))."\n";
        $body .= "\n";
        $body .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.waiting", "wng_cvci_news")."\n";
        $body .= "\n";
        $body .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.sign", "wng_cvci_news")."\n\n";

        return $body;
    }

    /**
     * Crée le contenu de l'email de notification
     *
     * @param \Wng\WngCvciNews\Domain\Model\Event $event
     * @param array $input
     * @return string
     */
    protected function buildEventNotificationBody(\Wng\WngCvciNews\Domain\Model\Event $event = NULL, $input = array()) {
        $body = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.message2", "wng_cvci_news", array($event->getTitle()))."<br>";
        $body .= "<br>";

        // Inscrits à l'événement
        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.event", "wng_cvci_news").":</b> ";
        $body .= $event->getTitle()."<br>";

        // Date de début
        $body .= "<b>Commence :</b> ";
        $body .= date_format($event->getEventStartDate(), 'd.m.Y').' '.date_format($event->getEventStartTime(), 'H:i')."<br />";

        // Date de fin
        $body .= "<b>Se termine :</b> ";
        $body .= date_format($event->getEventEndDate(), 'd.m.Y').' '.date_format($event->getEventEndTime(), 'H:i')."<br />";

        // Journée entière
        if ($event->getEventAllDay()) {
            $body .= "<b>Toute la journée</b><br />";
        }

        // Nom de la personne inscrite
        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.name", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["firstname"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.lastname", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["lastname"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.company", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["company"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.jobfield", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["jobfield"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.address", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["address"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.zip", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["zip"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.city", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["city"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.phone", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["phone"]."<br> ";

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.mobile", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["mobile"]."<br> ";

        if($input["tx_news_pi1"]["newEventEmail"]["aperitif"] == 1) {
            $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.aperitif", "wng_cvci_news").":</b> ";
            $body .= $input["tx_news_pi1"]["newEventEmail"]["aperitif"]."<br> ";
        }

        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.comments", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["comments"]."<br> ";

        // Email de la personne inscrite
        $body .= "<b>".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("email.notifications", "wng_cvci_news").":</b> ";
        $body .= $input["tx_news_pi1"]["newEventEmail"]["email"]."<br><br>";

        return $body;
    }


    /**
     * Vérifier la réponse de captcha
     *
     * @return boolean
     */
    protected function isValidCaptcha()
    {
        try {

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = ['secret'   => '6LftJhMUAAAAAPLqid3Lwb4-lTJmj50sJSsd9fgq',
                'response' => GeneralUtility::_POST('g-recaptcha-response'),
                'remoteip' => $_SERVER['REMOTE_ADDR']];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            return json_decode($result)->success;
        }
        catch (Exception $e) {
            return null;
        }
    }
}

?>
