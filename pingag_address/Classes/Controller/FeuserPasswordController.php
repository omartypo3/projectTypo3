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

use Evoweb\SfRegister\Controller\Event\PasswordFormEvent;
use Evoweb\SfRegister\Controller\Event\PasswordSaveEvent;
use Evoweb\SfRegister\Domain\Model\FrontendUser;
use Pingag\PingagAddress\Domain\Model\Infouser;
use Evoweb\SfRegister\Domain\Model\Password;
use Evoweb\SfRegister\Domain\Repository\FrontendUserGroupRepository;
use Evoweb\SfRegister\Domain\Repository\FrontendUserRepository;
use Evoweb\SfRegister\Services\File;
use Evoweb\SfRegister\Services\Session;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

/**
 * An frontend user password controller
 */
class FeuserPasswordController extends \Evoweb\SfRegister\Controller\FeuserPasswordController
{

    public function formAction(Password $password = null): ResponseInterface
    {
        $userId = $this->getTypoScriptFrontendController()->fe_user->user['uid'];
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $configuration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $setting = $configuration['plugin.']['tx_pingagaddress_mapshow.']['settings.'];
        $angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
        $lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
        $kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $addressRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AddressRepository');
        $frontendUserRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FrontendUserRepository');
        if($userId) {
            $addressid = $frontendUserRepository->findByUid($userId)->getAddressid();
            $address = $addressRepository->findByUid((int)$addressid);

            if($GLOBALS['TSFE']->id != $setting['PidFolderPassword']) {

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

                foreach ($address->getAngebote() as $angebote) {
                    array_push($optionsselected, $angebote->getUid());
                }
                foreach ($address->getLebensalter() as $lebensalter) {
                    array_push($lebensalterselected, $lebensalter->getUid());
                }
                foreach ($address->getKantone() as $kantone) {
                    array_push($kantoneselected, $kantone->getUid());
                }
                $this->view->assign('angebotesselected', $optionsselected);
                $this->view->assign('lebensaltersselected', $lebensalterselected);
                $this->view->assign('kantonesselected', $kantoneselected);

                $this->view->assign('address', $address);
            }

            if ($password === null) {
                $password = new Password();
            }
            $this->eventDispatcher->dispatch(new PasswordFormEvent($password, $this->settings));

            $this->view->assign('password', $password);
            $this->view->assign('user', $this->getTypoScriptFrontendController()->fe_user->user);
        }
        return new HtmlResponse($this->view->render());
    }

    /**
     * Save action
     *
     * @param Password $password
     *
     * @return ResponseInterface
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("Evoweb\SfRegister\Validation\Validator\UserValidator", param="password")
     */
    public function saveAction(Password $password): ResponseInterface
    {
        if ($this->userIsLoggedIn()) {

            $userId = $this->getTypoScriptFrontendController()->fe_user->user['uid'];
            /** @var FrontendUser $user */
            $user = $this->userRepository->findByUid($userId);

            $latitude = $_POST['tx_sfregister_password']['latitude'];
            $longitude = $_POST['tx_sfregister_password']['longitude'];
            $angeboteid = $_POST['tx_sfregister_password']['angebote'];
            $lebensalterid = $_POST['tx_sfregister_password']['lebensalter'];
            $dienstleistungenid = $_POST['tx_sfregister_password']['dienstleistungen'];
            $kantonesid = $_POST['tx_sfregister_password']['kantones'];
            $descriptionAdress = $_POST['tx_sfregister_password']['descriptionAdress'];
            $url = $_POST['tx_sfregister_password']['url'];
            $adress = $_POST['tx_sfregister_password']['adress'];
            $angebotTitel = $_POST['tx_sfregister_password']['angebotTitel'];
            $city = $_POST['tx_sfregister_password']['stadt'];
            $zip = $_POST['tx_sfregister_password']['zip'];
            $phone = $_POST['tx_sfregister_password']['phone'];

            $objectangeboteid = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $objectlebensalterid = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $objectdienstleistungenid = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $objectkantonesid  = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

            $angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
            $lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
            $kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
            $dienstleistungenRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\DienstleistungenRepository');
            $addressRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AddressRepository');



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

            $userId = $this->context->getAspect('frontend.user')->get('id');
            $frontendUserRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FrontendUserRepository');

            $addressid = $frontendUserRepository->findByUid($userId)->getAddressid();

            $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
            $configuration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            $setting = $configuration['plugin.']['tx_pingagaddress_mapshow.']['settings.'];


            if($GLOBALS['TSFE']->id != $setting['PidFolderPassword']) {

                $newAddress = $addressRepository->findByUid((int)$addressid);
                $newAddress->setZip($zip);
                $newAddress->setFirstName($user->getFirstName());
                $newAddress->setLastName($user->getLastName());
                if ($angebotTitel) {
                    $newAddress->setName($angebotTitel);
                } else {
                    $newAddress->setName("");
                }
                $newAddress->setLatitude((float)$latitude);
                $newAddress->setLongitude((float)$longitude);
                $newAddress->setPhone($phone);
                if ($angeboteid) {
                    $newAddress->setAngebote($objectangeboteid);
                }
                if ($lebensalterid) {
                    $newAddress->setLebensalter($objectlebensalterid);
                }
                //$newAddress->setDienstleistungen($objectdienstleistungenid);
                if ($kantonesid) {
                    $newAddress->setKantone($objectkantonesid);
                }
                $newAddress->setDescription($descriptionAdress);
                $newAddress->setEmail($user->getEmail());
                $newAddress->setWww($url);
                $newAddress->setCity($city);
                $newAddress->setAddress($adress);
                $newAddress->setHidden(0);
                //$newAddress->set
                $newAddress->setPid((int)$setting['PidFolderNewUser']);

                $addressRepository->update($newAddress);
                GeneralUtility::makeInstance(PersistenceManager::class)->persistAll();

            }

            $this->eventDispatcher->dispatch(new PasswordSaveEvent($user, $this->settings));

            $user->setPassword($this->encryptPassword($password->getPassword()));

            $this->userRepository->update($user);

        }

        return new HtmlResponse($this->view->render());
    }
}
