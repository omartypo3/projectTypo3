<?php

namespace Pingag\PingagAddress\Controller;

/*
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Evoweb\SfRegister\Controller\Event\EditAcceptEvent;
use Evoweb\SfRegister\Controller\Event\EditConfirmEvent;
use Evoweb\SfRegister\Controller\Event\EditFormEvent;
use Evoweb\SfRegister\Controller\Event\EditPreviewEvent;
use Evoweb\SfRegister\Controller\Event\EditSaveEvent;
use Evoweb\SfRegister\Domain\Model\FrontendUser;
use Evoweb\SfRegister\Services\Session as SessionService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Persistence\Generic\Session;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

/**
 * An frontend user edit controller
 */
class FeuserEditController extends \Pingag\PingagAddress\Controller\FeuserController
{
    protected string $controller = 'Edit';

    protected array $ignoredActions = ['confirmAction', 'acceptAction'];

    public function formAction(FrontendUser $user = null): ResponseInterface
    {
        $userId = $this->context->getAspect('frontend.user')->get('id');

        $angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
        $lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
        $kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $addressRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AddressRepository');
        $frontendUserRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FrontendUserRepository');
        $weiterestandorteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\WeiterestandorteRepository');

        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();

        if($userId) {
            $addressid = $frontendUserRepository->findByUid($userId)->getAddressid();
            $address = $addressRepository->findByUid((int)$addressid);

            $originalRequest = $this->request->getOriginalRequest();
            if (
                (
                    $this->request->hasArgument('user')
                    || ($originalRequest !== null && $originalRequest->hasArgument('user'))
                )
                && $this->userIsLoggedIn()
            ) {
                /** @var FrontendUser $userData */
                $userData = $this->request->hasArgument('user') ?
                    $this->request->getArgument('user') :
                    $originalRequest->getArgument('user');
                if ($userData instanceof FrontendUser && $userData->getUid() != $userId) {
                    $user = null;
                }
            }

            if ($user == null) {
                /** @var FrontendUser $user */
                $user = $this->userRepository->findByUid($userId);
            }

            if ($originalRequest !== null && $originalRequest->hasArgument('temporaryImage')) {
                $this->view->assign('temporaryImage', $originalRequest->getArgument('temporaryImage'));
            }

            // user is logged in
            if ($user instanceof FrontendUser) {
                $this->eventDispatcher->dispatch(new EditFormEvent($user, $this->settings));
            }

            $options = [];
            $optionslebensalter = [];
            $optionskantones = [];
            $optionsselected = [];
            $lebensalterselected = [];
            $kantoneselected = [];
            $angebotes = $angeboteRepository->findAll();
            foreach ($angebotes as $angebote) {
                array_push($options, array('label' => $angebote->getName(), 'value' => $angebote->getUid()));
            }
            $lebensalters = $lebensalterRepository->findAll();
            foreach ($lebensalters as $lebensalter) {
                array_push($optionslebensalter, array('label' => $lebensalter->getName(), 'value' => $lebensalter->getUid()));
            }
            $kantones = $kantoneRepository->findAll();
            foreach ($kantones as $kantone) {
                array_push($optionskantones, array('label' => $kantone->getTitle(), 'value' => $kantone->getUid()));
            }


            $this->view->assign('angebotes', $options);
            $this->view->assign('lebensalters', $optionslebensalter);
            $this->view->assign('kantones', $optionskantones);
            $this->view->assign('Weiterestandorte', $address->getWeiterestandorte());

            if($address) {
                foreach ($address->getAngebote() as $angebote) {
                    if($sys_language_uid == 0){
                        array_push($optionsselected, $angebote->getUid());
                    }else{
                        array_push($optionsselected, $this->getTranslate('tx_pingagaddress_domain_model_angebote',$angebote->getUid(),$sys_language_uid));
                    }
                }
                foreach ($address->getLebensalter() as $lebensalter) {
                    if($sys_language_uid == 0) {
                        array_push($lebensalterselected, $lebensalter->getUid());
                    }else{
                        array_push($lebensalterselected, $this->getTranslate('tx_pingagaddress_domain_model_lebensalter',$lebensalter->getUid(),$sys_language_uid));
                    }
                }
                foreach ($address->getKantone() as $kantone) {
                    if($sys_language_uid == 0) {
                        array_push($kantoneselected, $kantone->getUid());
                    }else{
                        array_push($kantoneselected, $this->getTranslate('tx_pingagaddress_domain_model_kantone',$kantone->getUid(),$sys_language_uid));
                    }
                }
            }




            $this->view->assign('angebotesselected', $optionsselected);
            $this->view->assign('lebensaltersselected', $lebensalterselected);
            $this->view->assign('kantonesselected', $kantoneselected);
            //$this->view->assign('kantonesselected', array('18', '19'));

            $this->view->assign('user', $user);
            $this->view->assign('address', $address);
        }

        return new HtmlResponse($this->view->render());
    }

    /**
     * Preview action
     *
     * @param \Evoweb\SfRegister\Domain\Model\FrontendUser $user
     *
     * @return ResponseInterface
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("Evoweb\SfRegister\Validation\Validator\UserValidator", param="user")
     */
    public function previewAction(FrontendUser $user): ResponseInterface
    {
        if ($this->request->hasArgument('temporaryImage')) {
            $this->view->assign('temporaryImage', $this->request->getArgument('temporaryImage'));
        }

        $this->eventDispatcher->dispatch(new EditPreviewEvent($user, $this->settings));

        $angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
        $lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
        $kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $dienstleistungenRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\DienstleistungenRepository');


        $this->view->assign('user', $user);

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($this->request->getArguments());
        if($this->request->hasArgument('stadt')){
            $this->view->assign('stadt', $this->request->getArgument('stadt'));
        }
        if($this->request->hasArgument('phone')){
            $this->view->assign('phone', $this->request->getArgument('phone'));
        }
        if($this->request->hasArgument('zip')){
            $this->view->assign('zip', $this->request->getArgument('zip'));
        }
        if($this->request->hasArgument('adress')){
            $this->view->assign('adress', $this->request->getArgument('adress'));
        }
        if($this->request->hasArgument('angebotTitel')){
            $this->view->assign('angebotTitel', $this->request->getArgument('angebotTitel'));
        }

        if($this->request->hasArgument('url')){
            $this->view->assign('url', $this->request->getArgument('url'));
        }
        if($this->request->hasArgument('latitude')){
            $this->view->assign('latitude', $this->request->getArgument('latitude'));
        }

        if($this->request->hasArgument('descriptionAdress')){
            $this->view->assign('descriptionAdress', $this->request->getArgument('descriptionAdress'));
        }

        if($this->request->hasArgument('longitude')){
            $this->view->assign('longitude', $this->request->getArgument('longitude'));
        }
        if($this->request->hasArgument('angebote')){
            $allNameangebote = [];
            $this->view->assign('angeboteid', implode(",",$this->request->getArgument('angebote')));
            foreach ($this->request->getArgument('angebote') as $angebotes){
                array_push($allNameangebote,$angeboteRepository->findByUid($angebotes)->getName());
            }
            $this->view->assign('allNameangebote', implode(",",$allNameangebote));


        }
        if($this->request->hasArgument('lebensalter')){
            $allNamelebensalter = [];

            $this->view->assign('lebensalterid', implode(",",$this->request->getArgument('lebensalter')));
            foreach ($this->request->getArgument('lebensalter') as $angebotes){
                array_push($allNamelebensalter,$lebensalterRepository->findByUid($angebotes)->getName());
            }
            $this->view->assign('allNamelebensalter', implode(",",$allNamelebensalter));
        }
        if($this->request->hasArgument('dienstleistungen')){
            $allNamedienstleistungen = [];

            $this->view->assign('dienstleistungenid', implode(",",$this->request->getArgument('dienstleistungen')));
            foreach ($this->request->getArgument('dienstleistungen') as $angebotes){
                array_push($allNamedienstleistungen,$dienstleistungenRepository->findByUid($angebotes)->getTitle());
            }
            $this->view->assign('allNamedienstleistungen', implode(",",$allNamedienstleistungen));
        }

        if($this->request->hasArgument('kantones')){
            /* $allNamekantones = [];
             $this->view->assign('kantonesid', implode(",",$this->request->getArgument('kantones')));
             foreach ($this->request->getArgument('kantones') as $angebotes){
                 array_push($allNamekantones,$kantoneRepository->findByUid($angebotes)->getTitle());

             }*/
            $this->view->assign('kantonesid', implode(",",$this->request->getArgument('kantones')));
            $this->view->assign('allNamekantones', $kantoneRepository->findByUid($this->request->getArgument('kantones')[0])->getTitle());
        }

        if($this->request->hasArgument('weiteradress')){

            $this->view->assign('weiteradress', implode(",",array_filter($this->request->getArgument('weiteradress'))));
            $weiteradress = implode(",",array_filter($this->request->getArgument('weiteradress')));
        }
        if($this->request->hasArgument('weiterzip')){
            $this->view->assign('weiterzip', implode(",",array_filter($this->request->getArgument('weiterzip'))));
            $weiterzip = implode(",",array_filter($this->request->getArgument('weiterzip')));
        }
        if($this->request->hasArgument('weiterstadt')){
            $this->view->assign('weiterstadt', implode(",",array_filter($this->request->getArgument('weiterstadt'))));
            $weiterstadt = implode(",",array_filter($this->request->getArgument('weiterstadt')));
        }
        if($this->request->hasArgument('weiteremail')){
            $this->view->assign('weiteremail', implode(",",array_filter($this->request->getArgument('weiteremail'))));
            $weiteremail = implode(",",array_filter($this->request->getArgument('weiteremail')));
        }
        if($this->request->hasArgument('weiterphone')){
            $this->view->assign('weiterphone', implode(",",array_filter($this->request->getArgument('weiterphone'))));
            $weiterphone = implode(",",array_filter($this->request->getArgument('weiterphone')));
        }
        if($this->request->hasArgument('weiterurl')){
            $this->view->assign('weiterurl', implode(",",array_filter($this->request->getArgument('weiterurl'))));
            $weiterurl = implode(",",array_filter($this->request->getArgument('weiterurl')));
        }
        if($this->request->hasArgument('weiterlatitude')){
            $this->view->assign('weiterlatitude', implode(",",array_filter($this->request->getArgument('weiterlatitude'))));
            $weiterlatitude = implode(",",array_filter($this->request->getArgument('weiterlatitude')));
        }
        if($this->request->hasArgument('weiterlongitude')){
            $this->view->assign('weiterlongitude', implode(",",array_filter($this->request->getArgument('weiterlongitude'))));
            $weiterlongitude = implode(",",array_filter($this->request->getArgument('weiterlongitude')));
        }
        if($this->request->hasArgument('weiterkantone')){

            $this->view->assign('weiterkantone', implode(",",array_filter($this->request->getArgument('weiterkantone'))));
            $weiterkantone = implode(",",array_filter($this->request->getArgument('weiterkantone')));
        }
        if($this->request->hasArgument('weiterbeschreibung')){
            $this->view->assign('weiterbeschreibung', implode(",",array_filter($this->request->getArgument('weiterbeschreibung'))));
            $weiterbeschreibung = implode(",",array_filter($this->request->getArgument('weiterbeschreibung')));
        }
        $array = [];

        foreach (explode(",", $weiteradress) as $key=> $weiteradress) {

            $zipWeiterestandorte = explode(",", $weiterzip)[$key];
            $stadtWeiterestandorte = explode(",", $weiterstadt)[$key];
            $emailWeiterestandorte = explode(",", $weiteremail)[$key];
            $urlWeiterestandorte = explode(",", $weiterurl)[$key];
            $phoneWeiterestandorte = explode(",", $weiterphone)[$key];
            $latitudeWeiterestandorte = explode(",", $weiterlatitude)[$key];
            $longitudeWeiterestandorte = explode(",", $weiterlongitude)[$key];
            $kantoneWeiterestandorte = explode(",", $weiterkantone)[$key];
            $beschreibungWeiterestandorte = explode(",", $weiterbeschreibung)[$key];

            $allNamekantones = $kantoneRepository->findByUid(explode(",", $weiterkantone)[$key])->getTitle();

            if($weiteradress){
                array_push($array,array('strasse'=>$weiteradress,'plz'=>$zipWeiterestandorte,'ort'=>$stadtWeiterestandorte,'email'=>$emailWeiterestandorte,'url'=>$urlWeiterestandorte,'telefon'=>$phoneWeiterestandorte,'breitengrad'=>$latitudeWeiterestandorte,'laungengrad'=>$longitudeWeiterestandorte,'kantone'=>$kantoneWeiterestandorte,'allNamekantones'=>$allNamekantones,'allbeschreibung'=>$beschreibungWeiterestandorte));

            }
        }

        $this->view->assign('accordiantweiter', $array);
        return new HtmlResponse($this->view->render());
    }

    /**
     * Save action
     *
     * @param FrontendUser $user
     *
     * @return ResponseInterface
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("Evoweb\SfRegister\Validation\Validator\UserValidator", param="user")
     */
    public function saveAction(FrontendUser $user): ResponseInterface
    {
        if (($this->settings['confirmEmailPostEdit'] ?? false) || ($this->settings['acceptEmailPostEdit'] ?? false)) {
            // Remove user object from session to fetch it really from database
            /** @var Session $session */
            $session = GeneralUtility::makeInstance(Session::class);
            $session->unregisterObject($user);

            /** @var FrontendUser $userBeforeEdit */
            $userBeforeEdit = $this->userRepository->findByUid($user->getUid());

            // Now remove the fresh fetched and add the updated one to make it known again
            $session->unregisterObject($userBeforeEdit);
            $session->registerObject($user, 'sf-register-' . $user->getUid());

            $user->setEmailNew($user->getEmail());
            $user->setEmail($userBeforeEdit->getEmail() ?: $user->getEmail());
        } elseif (($this->settings['useEmailAddressAsUsername'] ?? false)) {
            $user->setUsername($user->getEmail());
        }

        $this->eventDispatcher->dispatch(new EditSaveEvent($user, $this->settings));

        $user = $this->sendEmails($user, __FUNCTION__);

        $latitude = $_POST['tx_sfregister_edit']['latitude'];
        $longitude = $_POST['tx_sfregister_edit']['longitude'];
        $angeboteid = $_POST['tx_sfregister_edit']['angebote'];
        $lebensalterid = $_POST['tx_sfregister_edit']['lebensalter'];
        $dienstleistungenid = $_POST['tx_sfregister_edit']['dienstleistungen'];
        $kantonesid = $_POST['tx_sfregister_edit']['kantones'];
        $descriptionAdress = $_POST['tx_sfregister_edit']['descriptionAdress'];
        $url = $_POST['tx_sfregister_edit']['url'];
        $adress = $_POST['tx_sfregister_edit']['adress'];
        $angebotTitel = $_POST['tx_sfregister_edit']['angebotTitel'];
        $city = $_POST['tx_sfregister_edit']['stadt'];
        $zip = $_POST['tx_sfregister_edit']['zip'];
        $phone = $_POST['tx_sfregister_edit']['phone'];
        $weiteradress = $_POST['tx_sfregister_edit']['weiteradress'];
        $weiterzip = $_POST['tx_sfregister_edit']['weiterzip'];
        $weiterstadt = $_POST['tx_sfregister_edit']['weiterstadt'];
        $weiterphone = $_POST['tx_sfregister_edit']['weiterphone'];
        $weiteremail = $_POST['tx_sfregister_edit']['weiteremail'];
        $weiterurl = $_POST['tx_sfregister_edit']['weiterurl'];
        $weiterlatitude = $_POST['tx_sfregister_edit']['weiterlatitude'];
        $weiterlongitude = $_POST['tx_sfregister_edit']['weiterlongitude'];
        $weiterkantone = $_POST['tx_sfregister_edit']['weiterkantone'];
        $weiterbeschreibung = $_POST['tx_sfregister_edit']['weiterbeschreibung'];


        $objectangeboteid = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectlebensalterid = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectdienstleistungenid = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectkantonesid  = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectWeiterestandorte  = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
        $lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
        $kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $dienstleistungenRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\DienstleistungenRepository');
        $addressRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AddressRepository');
        $weiterestandorteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\WeiterestandorteRepository');



        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $configuration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $setting = $configuration['plugin.']['tx_pingagaddress_mapshow.']['settings.'];



        if($angeboteid) {
            foreach (explode(",", $angeboteid) as $angebote) {
                $objectangeboteid->attach($angeboteRepository->findByUid((int)$angebote));
            }
        }

        if($lebensalterid) {
            foreach (explode(",", $lebensalterid) as $lebensalter) {
                $objectlebensalterid->attach($lebensalterRepository->findByUid((int)$lebensalter));
            }
        }

        if($dienstleistungenid) {
            foreach (explode(",", $dienstleistungenid) as $dienstleistungen) {
                $objectdienstleistungenid->attach($dienstleistungenRepository->findByUid((int)$dienstleistungen));
            }
        }

        if($kantonesid) {
            foreach (explode(",", $kantonesid) as $kantones) {
                $objectkantonesid->attach($kantoneRepository->findByUid((int)$kantones));
            }
        }

        if($weiteradress) {
            foreach ($weiteradress as $key=> $weiteradress) {
                $weiterestandorte = new \Pingag\PingagAddress\Domain\Model\Weiterestandorte();
                $sdtWeiterestandorte = $weiteradress;
                $zipWeiterestandorte = $weiterzip[$key];
                $stadtWeiterestandorte = $weiterstadt[$key];
                $emailWeiterestandorte = $weiteremail[$key];
                $urlWeiterestandorte = $weiterurl[$key];
                $phoneWeiterestandorte = $weiterphone[$key];
                $latitudeWeiterestandorte = $weiterlatitude[$key];
                $longitudeWeiterestandorte = $weiterlongitude[$key];
                $kantoneWeiterestandorte = $weiterkantone[$key];
                $beschreibungWeiterestandorte = $weiterbeschreibung[$key];
                $weiterestandorte->set_languageUid(-1);
                $weiterestandorte->setStrasse($sdtWeiterestandorte);
                $weiterestandorte->setPlz($zipWeiterestandorte);
                $weiterestandorte->setTelefon($phoneWeiterestandorte);
                $weiterestandorte->setOrt($stadtWeiterestandorte);
                $weiterestandorte->setEmail($emailWeiterestandorte);
                $weiterestandorte->setKantone($kantoneWeiterestandorte);
                if($beschreibungWeiterestandorte) {
                    $weiterestandorte->setBeschreibung($beschreibungWeiterestandorte);
                }
                if($urlWeiterestandorte) {
                    $weiterestandorte->setUrl($urlWeiterestandorte);
                }
                if($latitudeWeiterestandorte) {
                    $weiterestandorte->setBreitengrad($latitudeWeiterestandorte);
                }
                if($longitudeWeiterestandorte) {
                    $weiterestandorte->setLaungengrad($longitudeWeiterestandorte);
                }
                $objectWeiterestandorte->attach($weiterestandorte);

            }


        }


        $userId = $this->context->getAspect('frontend.user')->get('id');
        $frontendUserRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FrontendUserRepository');

        $addressid = $frontendUserRepository->findByUid($userId)->getAddressid();

        $newAddress = $addressRepository->findByUid((int)$addressid);
        $newAddress->setZip($zip);
        $newAddress->setFirstName($user->getFirstName());
        $newAddress->setLastName($user->getLastName());
        if($angebotTitel){
            $newAddress->setName($angebotTitel);
        }else{
            $newAddress->setName("");
        }
        $newAddress->setLatitude((float)$latitude);
        $newAddress->setLongitude((float)$longitude);
        $newAddress->setPhone($phone);
        if($angeboteid) {
            $newAddress->setAngebote($objectangeboteid);
        }
        if($lebensalterid) {
            $newAddress->setLebensalter($objectlebensalterid);
        }
        //$newAddress->setDienstleistungen($objectdienstleistungenid);
        if($kantonesid) {
            $newAddress->setKantone($objectkantonesid);
            $newAddress->setRegion($objectkantonesid[0]->getTitle());
        }
        $newAddress->setDescription($descriptionAdress);
        if($objectWeiterestandorte) {
            $newAddress->setWeiterestandorte($objectWeiterestandorte);
        }
        $newAddress->setEmail($user->getEmail());
        $newAddress->setWww($url);
        $newAddress->setCity($city);
        $newAddress->setAddress($adress);
        $newAddress->setHidden(0);

        //$newAddress->set
        $newAddress->setPid((int)$setting['PidFolderNewUser']);



        $addressRepository->update($newAddress);
        GeneralUtility::makeInstance(PersistenceManager::class)->persistAll();

        $this->userRepository->update($user);
        $this->persistAll();

        /** @var SessionService $session */
        $session = GeneralUtility::makeInstance(SessionService::class);
        $session->remove('captchaWasValidPreviously');

        if (($this->settings['forwardToEditAfterSave'] ?? false)) {
            $response = new ForwardResponse('form');
        } else {
            $this->view->assign('user', $user);
            $response = new HtmlResponse($this->view->render());
        }

        return $response;
    }

    public function confirmAction(FrontendUser $user = null, string $hash = null): ResponseInterface
    {
        $user = $this->determineFrontendUser($user, $hash);

        if (!($user instanceof FrontendUser)) {
            $this->view->assign('userNotFound', 1);
        } else {
            $this->view->assign('user', $user);

            $userEmailNew = $user->getEmailNew();
            if ($user->getDisable()) {
                $this->view->assign('userNotConfirmed', 1);
            } elseif (empty($userEmailNew)) {
                $this->view->assign('userAlreadyConfirmed', 1);
            } else {
                if (!($this->settings['acceptEmailPostEdit'] ?? false)) {
                    $user->setEmail($user->getEmailNew());
                    $user->setEmailNew('');

                    if (($this->settings['useEmailAddressAsUsername'] ?? false)) {
                        $user->setUsername($user->getEmail());
                    }
                }

                $this->eventDispatcher->dispatch(new EditConfirmEvent($user, $this->settings));

                $this->userRepository->update($user);

                $this->sendEmails($user, __FUNCTION__);

                $this->view->assign('userConfirmed', 1);
            }

            if (($this->settings['autologinPostConfirmation'] ?? false)) {
                $this->persistAll();
                $this->autoLogin($user, (int)($this->settings['redirectPostActivationPageId'] ?? 0));
            }

            if ((int)($this->settings['redirectPostActivationPageId'] > 0)) {
                $this->redirectToPage((int)($this->settings['redirectPostActivationPageId'] ?? 0));
            }
        }

        return new HtmlResponse($this->view->render());
    }

    public function acceptAction(FrontendUser $user = null, string $hash = null): ResponseInterface
    {
        $user = $this->determineFrontendUser($user, $hash);

        if (!($user instanceof FrontendUser)) {
            $this->view->assign('userNotFound', 1);
        } else {
            $this->view->assign('user', $user);

            if (!$user->getDisable()) {
                $this->view->assign('userAlreadyConfirmed', 1);
            } else {
                if (!empty($user->getEmailNew())) {
                    $user->setEmail($user->getEmailNew());
                    $user->setEmailNew('');
                }

                if (($this->settings['useEmailAddressAsUsername'] ?? false)) {
                    $user->setUsername($user->getEmail());
                }

                $this->eventDispatcher->dispatch(new EditAcceptEvent($user, $this->settings));

                $this->userRepository->update($user);

                $this->sendEmails($user, __FUNCTION__);

                if ((int)($this->settings['redirectPostActivationPageId'] ?? 0) > 0) {
                    $this->redirectToPage((int)($this->settings['redirectPostActivationPageId'] ?? 0));
                }

                $this->view->assign('adminAccept', 1);
            }
        }

        return new HtmlResponse($this->view->render());
    }

    function getTranslate($table ,$uid, $lang){
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
        $result = $queryBuilder
            ->select('uid')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter($lang, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('l10n_parent', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->executeQuery();

        $row = $result->fetchAssociative();
            // Do something with that single row
        if($row['uid']) {
            return $row['uid'];
        }else{
            return $uid;
        }

    }
   
}
