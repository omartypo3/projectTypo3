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

use Evoweb\SfRegister\Controller\Event\CreateAcceptEvent;
use Evoweb\SfRegister\Controller\Event\CreateConfirmEvent;
use Evoweb\SfRegister\Controller\Event\CreateDeclineEvent;
use Evoweb\SfRegister\Controller\Event\CreateFormEvent;
use Evoweb\SfRegister\Controller\Event\CreatePreviewEvent;
use Evoweb\SfRegister\Controller\Event\CreateRefuseEvent;
use Evoweb\SfRegister\Controller\Event\CreateSaveEvent;
use Evoweb\SfRegister\Domain\Model\FrontendUser;
use Evoweb\SfRegister\Services\Session;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;


use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
/**
 * A frontend user create controller
 */
class FeuserCreateController extends \Pingag\PingagAddress\Controller\FeuserController
{


    protected string $controller = 'Create';

    protected array $ignoredActions = ['confirmAction', 'refuseAction', 'acceptAction', 'declineAction'];

    public function formAction(FrontendUser $user = null): ResponseInterface
    {
        $setupResponse = $this->setupCheck();

        $angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
        $lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
        $kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $dienstleistungenRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\DienstleistungenRepository');
        $options = [];
        $optionslebensalter = [];
        $optionskantones = [];
        $optionsdienstleistungen = [];
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
        $dienstleistungens = $dienstleistungenRepository->findAll();
        foreach ($dienstleistungens as $dienstleistungen) {
            array_push($optionsdienstleistungen, array('label' => $dienstleistungen->getTitle(), 'value' => $dienstleistungen->getUid()));
        }

        $this->view->assign('angebotes', $options);
        $this->view->assign('lebensalters', $optionslebensalter);
        $this->view->assign('kantones', $optionskantones);
        $this->view->assign('dienstleistungens', $optionsdienstleistungen);

        if ($user) {
            $this->eventDispatcher->dispatch(new CreateFormEvent($user, $this->settings));
            $this->view->assign('user', $user);
        }

        return $setupResponse ?? new HtmlResponse($this->view->render());
    }

    /**
     * Preview action
     *
     * @param FrontendUser $user
     *
     * @return ResponseInterface
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("Evoweb\SfRegister\Validation\Validator\UserValidator", param="user")
     */
    public function previewAction(FrontendUser $user): ResponseInterface
    {
        $angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
        $lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
        $kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $dienstleistungenRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\DienstleistungenRepository');

        if ($this->request->hasArgument('temporaryImage')) {
            $this->view->assign('temporaryImage', $this->request->getArgument('temporaryImage'));
        }

        $this->eventDispatcher->dispatch(new CreatePreviewEvent($user, $this->settings));



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
             $this->view->assign('allNameangebote', implode(",", $allNameangebote));


         }
         if($this->request->hasArgument('lebensalter')){
             $allNamelebensalter = [];

             $this->view->assign('lebensalterid', implode(",",$this->request->getArgument('lebensalter')));
             foreach ($this->request->getArgument('lebensalter') as $angebotes){
                 array_push($allNamelebensalter,$lebensalterRepository->findByUid($angebotes)->getName());
             }
             $this->view->assign('allNamelebensalter', implode(",", $allNamelebensalter));
         }

         if($this->request->hasArgument('kantones')){
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


        if($weiteradress){
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
        }


        $this->view->assign('accordiantweiter', $array);



        $this->view->assign('user', $user);


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

        $latitude = $_POST['tx_sfregister_create']['latitude'];
        $longitude = $_POST['tx_sfregister_create']['longitude'];
        $angeboteid = $_POST['tx_sfregister_create']['angebote'];
        $lebensalterid = $_POST['tx_sfregister_create']['lebensalter'];
        $dienstleistungenid = $_POST['tx_sfregister_create']['dienstleistungen'];
        $kantonesid = $_POST['tx_sfregister_create']['kantones'];

       // \TYPO3\CMS\Core\Utility\DebugUtility::debug($kantonesid);
       // die();

        $descriptionAdress = $_POST['tx_sfregister_create']['descriptionAdress'];
        $url = $_POST['tx_sfregister_create']['url'];
        $adress = $_POST['tx_sfregister_create']['adress'];
        $angebotTitel = $_POST['tx_sfregister_create']['angebotTitel'];
        $city = $_POST['tx_sfregister_create']['stadt'];
        $zip = $_POST['tx_sfregister_create']['zip'];
        $phone = $_POST['tx_sfregister_create']['phone'];



        $weiteradress = $_POST['tx_sfregister_create']['weiteradress'];
        $weiterzip = $_POST['tx_sfregister_create']['weiterzip'];
        $weiterstadt = $_POST['tx_sfregister_create']['weiterstadt'];
        $weiterphone = $_POST['tx_sfregister_create']['weiterphone'];
        $weiteremail = $_POST['tx_sfregister_create']['weiteremail'];
        $weiterurl = $_POST['tx_sfregister_create']['weiterurl'];
        $weiterlatitude = $_POST['tx_sfregister_create']['weiterlatitude'];
        $weiterlongitude = $_POST['tx_sfregister_create']['weiterlongitude'];
        $weiterkantone = $_POST['tx_sfregister_create']['weiterkantone'];
        $weiterbeschreibung = $_POST['tx_sfregister_create']['weiterbeschreibung'];

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
                $weiterestandorte->setStrasse($sdtWeiterestandorte);
                $weiterestandorte->set_languageUid(-1);
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

        /*****************add New address*******************/
        $newAddress = new \Pingag\PingagAddress\Domain\Model\Address();
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
        $newAddress->setDienstleistungen($objectdienstleistungenid);
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
        $newAddress->set_languageUid(-1);
        $newAddress->setHidden(1);
        //$newAddress->set
        $newAddress->setPid((int)$setting['PidFolderNewUser']);

       // \TYPO3\CMS\Core\Utility\DebugUtility::debug($newAddress);
       // die();
      //  die();\TYPO3\CMS\Core\Utility\DebugUtility::debug()

        $addressRepository->add($newAddress);



        GeneralUtility::makeInstance(PersistenceManager::class)->persistAll();

        /*\TYPO3\CMS\Core\Utility\DebugUtility::debug($user);
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($newAddress->getUid());

        die();*/
        if (
            ($this->settings['confirmEmailPostCreate'] ?? false)
            || ($this->settings['acceptEmailPostCreate'] ?? false)
        ) {
            $user->setDisable(true);
            $user = $this->changeUsergroup($user, (int)($this->settings['usergroupPostSave'] ?? 0));
        } else {
            $user = $this->changeUsergroup($user, (int)($this->settings['usergroup'] ?? 0));
            $this->moveTemporaryImage($user);
        }

        if (($this->settings['useEmailAddressAsUsername'] ?? false)) {
            $user->setUsername($user->getEmail());
        }

        $this->eventDispatcher->dispatch(new CreateSaveEvent($user, $this->settings));

        // Persist user to get valid uid
        $plainPassword = $user->getPassword();
        // Avoid plain password being persisted
        $user->setPassword('');
        $user->setPid((int)$setting['PidFolderNewUser']);
        $user->setUsername($user->getUsername());
        $user->setWww($url);
        $user->setDisable(1);
        $this->userRepository->add($user);
        $this->persistAll();

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $queryBuilder
            ->update('fe_users')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($user->getUid(), Connection::PARAM_INT))
            )
            ->set('addressid', $newAddress->getUid())
            ->executeStatement();

        // Write back plain password
        $user->setPassword($plainPassword);
        $user = $this->sendEmails($user, __FUNCTION__);

        // Encrypt plain password
        if ($user->getPassword()) {
            $user->setPassword($this->encryptPassword($user->getPassword()));
        }


        $this->userRepository->update($user);
        $this->persistAll();

        /** @var Session $session */
        $session = GeneralUtility::makeInstance(Session::class);
        $session->remove('captchaWasValidPreviously');

        if (($this->settings['autologinPostRegistration'] ?? false)) {
            $this->autoLogin($user, (int)($this->settings['redirectPostRegistrationPageId'] ?? 0));
        }

        if ((int)($this->settings['redirectPostRegistrationPageId'] ?? 0) > 0) {
            $this->redirectToPage((int)($this->settings['redirectPostRegistrationPageId'] ?? 0));
        }

        $this->view->assign('user', $user);

        return new HtmlResponse($this->view->render());
    }

    /**
     * Confirm registration process by user
     * Could be followed by acceptance of admin
     *
     * @param ?FrontendUser $user
     * @param ?string $hash
     *
     * @return ResponseInterface
     */
    public function confirmAction(?FrontendUser $user, ?string $hash): ResponseInterface
    {
        $user = $this->determineFrontendUser($user, $hash);

        if (!($user instanceof FrontendUser)) {
            $this->view->assign('userNotFound', 1);
        } else {
            $this->view->assign('user', $user);

            if (
                $user->getActivatedOn() || $this->isUserInUserGroups(
                    $user,
                    $this->getConfiguredUserGroups((int)($this->settings['usergroupPostConfirm'] ?? 0))
                )
            ) {
                $this->view->assign('userAlreadyConfirmed', 1);
            } else {
                $user = $this->changeUsergroup($user, (int)($this->settings['usergroupPostConfirm'] ?? 0));
                $this->moveTemporaryImage($user);
                $user->setActivatedOn(new \DateTime('now'));

                if (!($this->settings['acceptEmailPostConfirm'] ?? false)) {
                    $user->setDisable(false);
                }

                $this->eventDispatcher->dispatch(new CreateConfirmEvent($user, $this->settings));

                $this->userRepository->update($user);

                $this->sendEmails($user, __FUNCTION__);

                if (($this->settings['autologinPostConfirmation'] ?? false)) {
                    $this->persistAll();
                    $this->autoLogin($user, (int)($this->settings['redirectPostActivationPageId'] ?? 0));
                }

                if ((int)($this->settings['redirectPostActivationPageId'] ?? 0) > 0) {
                    $this->redirectToPage((int)($this->settings['redirectPostActivationPageId'] ?? 0));
                }

                $this->view->assign('userConfirmed', 1);
            }
        }

        return new HtmlResponse($this->view->render());
    }

    /**
     * Refuse registration process by user with removing the user data
     *
     * @param ?FrontendUser $user
     * @param ?string $hash
     *
     * @return ResponseInterface
     */
    public function refuseAction(?FrontendUser $user, ?string $hash): ResponseInterface
    {
        $user = $this->determineFrontendUser($user, $hash);

        if (!($user instanceof FrontendUser)) {
            $this->view->assign('userNotFound', 1);
        } else {
            $this->view->assign('user', $user);

            $this->eventDispatcher->dispatch(new CreateRefuseEvent($user, $this->settings));

            $this->userRepository->remove($user);

            $this->sendEmails($user, __FUNCTION__);

            $this->view->assign('userRefused', 1);
        }

        return new HtmlResponse($this->view->render());
    }

    /**
     * Accept registration process by admin after user confirmation
     *
     * @param ?FrontendUser $user
     * @param ?string $hash
     *
     * @return ResponseInterface
     */
    public function acceptAction(?FrontendUser $user, ?string $hash): ResponseInterface
    {
        $user = $this->determineFrontendUser($user, $hash);

        if (!($user instanceof FrontendUser)) {
            $this->view->assign('userNotFound', 1);
        } else {
            $this->view->assign('user', $user);

            if (
                !$user->getDisable() || $this->isUserInUserGroups(
                    $user,
                    $this->getConfiguredUserGroups((int)($this->settings['usergroupPostAccept'] ?? 0))
                )
            ) {
                $this->view->assign('userAlreadyAccepted', 1);
            } else {
                $user = $this->changeUsergroup($user, (int)($this->settings['usergroupPostAccept'] ?? 0));
                $user->setDisable(false);

                if (!($this->settings['confirmEmailPostAccept'] ?? false)) {
                    $user->setActivatedOn(new \DateTime('now'));
                }

                $this->eventDispatcher->dispatch(new CreateAcceptEvent($user, $this->settings));

                $this->userRepository->update($user);

                $this->sendEmails($user, __FUNCTION__);

                $this->view->assign('userAccepted', 1);
            }
        }

        return new HtmlResponse($this->view->render());
    }

    /**
     * Decline registration process by admin with removing the user data
     *
     * @param ?FrontendUser $user
     * @param ?string $hash
     *
     * @return ResponseInterface
     */
    public function declineAction(?FrontendUser $user, ?string $hash): ResponseInterface
    {
        $user = $this->determineFrontendUser($user, $hash);

        if (!($user instanceof FrontendUser)) {
            $this->view->assign('userNotFound', 1);
        } else {
            $this->view->assign('user', $user);

            $this->eventDispatcher->dispatch(new CreateDeclineEvent($user, $this->settings));

            $this->userRepository->remove($user);

            $this->sendEmails($user, __FUNCTION__);

            $this->view->assign('userDeclined', 1);
        }

        return new HtmlResponse($this->view->render());
    }

    protected function setupCheck(): ?ResponseInterface
    {
        $result = null;

        $setupChecks = GeneralUtility::makeInstance(
            \Evoweb\SfRegister\Services\Setup\CheckFactory::class
        )->getCheckInstances();
        foreach ($setupChecks as $setupCheck) {
            if (($result = $setupCheck->check($this->settings))) {
                break;
            }
        }

        return $result;
    }
}
