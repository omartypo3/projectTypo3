<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Controller;

use WapplerSystems\Cleverreach\CleverReach\Api;
use WapplerSystems\Cleverreach\Domain\Model\Receiver;
use WapplerSystems\Cleverreach\Service\ConfigurationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;


/**
 * This file is part of the "pingagaddress" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022
 */

/**
 * CommunicationController
 */
class AddressPersonController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    const PINGAG_IP = '196.179.244.127';

    public function initializeAction(): void
    {


        $this->addressRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AddressPersonRepository');
        $this->techniquesRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\TechniquesRepository');
        $this->placeofuseRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\PlaceofuseRepository');
        $this->languageRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LanguageRepository');
        $this->gehoerlosRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\GehoerlosRepository');
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);

        $configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $storage = ($configuration['persistence']['storagePid']) ? $configuration['persistence']['storagePid'] : "1017";

        $techniques = $this->techniquesRepository->findAll();
        $placefuce = $this->placeofuseRepository->findAll();
        $gehoerlos = $this->gehoerlosRepository->findAll();
        //$language = $this->languageRepository->findAll();
        $language = $this->languageRepository->getOrder();

        $uids = [16, 1, 2, 5, 4, 6];
        $languageMother = [];
        foreach ($uids as $uidMother) {
            array_push($languageMother, $this->languageRepository->findByUid($uidMother));
        }
        $languageMotherAndere = $this->languageRepository->getOrderName($uids);


        if ($this->request->hasArgument('useajax')) {

            $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
            $sys_language_uid = $languageAspect->getId();

            if ($sys_language_uid != 0) {
                $Muttersprache = $this->getOrginalUids($this->request->getArgument('Muttersprache'), $sys_language_uid, 'tx_pingagaddress_domain_model_language');
                if (!$Muttersprache) {
                    $Muttersprache = $this->request->getArgument('Muttersprache');
                }
                $SprachenArray = $this->request->getArgument('Sprachen');
                $Sprachen = [];
                foreach ($SprachenArray as $sprache) {
                    $sprachetoArray = $this->getOrginalUids($sprache, $sys_language_uid, 'tx_pingagaddress_domain_model_language');
                    if (!$sprachetoArray) {
                        $sprachetoArray = $sprache;
                    }
                    array_push($Sprachen, $sprachetoArray);
                }
                $TechnikenArray = $this->request->getArgument('Techniken');

                $Techniken = [];
                foreach ($TechnikenArray as $Technik) {
                    $TechniktoArray = $this->getOrginalUids($Technik, $sys_language_uid, 'tx_pingagaddress_domain_model_techniques');

                    if (!$TechniktoArray) {
                        $TechniktoArray = $Technik;
                    }
                    array_push($Techniken, $TechniktoArray);
                }

                $Ort = $this->getOrginalUids($this->request->getArgument('Ort'), $sys_language_uid, 'tx_pingagaddress_domain_model_placeofuse');
                if (!$Ort) {
                    $Ort = $this->request->getArgument('Ort');
                }

                $Gehoerlos = $this->getOrginalUids($this->request->getArgument('Gehoerlos'), $sys_language_uid, 'tx_pingagaddress_domain_model_gehoerlos');
                if (!$Gehoerlos) {
                    $Gehoerlos = $this->request->getArgument('Gehoerlos');
                }

            } else {
                $Techniken = $this->request->getArgument('Techniken');
                $Muttersprache = $this->request->getArgument('Muttersprache');
                $Sprachen = $this->request->getArgument('Sprachen');
                $Ort = $this->request->getArgument('Ort');
                $Gehoerlos = $this->request->getArgument('Gehoerlos');



            }

            $notwenidg = $this->request->getArgument('notwenidg');
            $Geschlecht = $this->request->getArgument('Geschlecht');
            $storageId = explode(",", $storage);


            if ($Geschlecht || $Muttersprache || $Techniken || $Sprachen || $Ort || $Gehoerlos || $notwenidg) {
                $addressCommunication = $this->addressRepository->findAdress($storageId, $Geschlecht, $Techniken, $Muttersprache, $Sprachen, $Ort, $Gehoerlos, $notwenidg);
                if ($Muttersprache) {
                    $addressCommunicationMuttersprache = [];
                    foreach ($addressCommunication as $address) {
                        foreach ($address->getMutterSprache() as $place) {
                            if($Muttersprache == '999999') {
                                if (!in_array($place->getUid(), $uids)){
                                    array_push($addressCommunicationMuttersprache, $address);
                                }
                            }else{
                                if ($place->getUid() == (int)$Muttersprache) {
                                    array_push($addressCommunicationMuttersprache, $address);
                                }
                            }

                        }
                    }
                    $this->view->assignMultiple([
                        'addressCommunication' => $addressCommunicationMuttersprache,
                        'techniques' => $techniques,
                        'ort' => $placefuce,
                        'gehoerlos' => $gehoerlos,
                        'language' => $language,
                        'languageMother' => $languageMother,
                        'languageMotherAndere' => $languageMotherAndere
                    ]);

                } else if ($Ort) {
                    $uids = ['1','4','7'];
                    if(in_array($Ort, $uids)){

                        $this->view->assignMultiple([
                            'addressCommunication' => $addressCommunication,
                            'techniques' => $techniques,
                            'ort' => $placefuce,
                            'gehoerlos' => $gehoerlos,
                            'language' => $language,
                            'languageMother' => $languageMother,
                            'languageMotherAndere' => $languageMotherAndere
                        ]);
                    }else{
                        $addressCommunicationort = [];

                        foreach ($addressCommunication as $address) {
                            foreach ($address->getPlaceofuse() as $place) {
                                if ($place->getUid() == (int)$Ort) {
                                    array_push($addressCommunicationort, $address);
                                }
                            }
                        }
                        $this->view->assignMultiple([
                            'addressCommunication' => $addressCommunicationort,
                            'techniques' => $techniques,
                            'ort' => $placefuce,
                            'gehoerlos' => $gehoerlos,
                            'language' => $language,
                            'languageMother' => $languageMother,
                            'languageMotherAndere' => $languageMotherAndere
                        ]);
                    }


                } else {

                    $this->view->assignMultiple([
                        'addressCommunication' => $addressCommunication,
                        'techniques' => $techniques,
                        'ort' => $placefuce,
                        'gehoerlos' => $gehoerlos,
                        'language' => $language,
                        'languageMother' => $languageMother,
                        'languageMotherAndere' => $languageMotherAndere
                    ]);
                }
            } else {
                $addressCommunication = $this->addressRepository->findAdressPid(explode(",", $storage));

                $this->view->assignMultiple([
                    'addressCommunication' => $addressCommunication,
                    'techniques' => $techniques,
                    'ort' => $placefuce,
                    'gehoerlos' => $gehoerlos,
                    'language' => $language,
                    'languageMother' => $languageMother,
                    'languageMotherAndere' => $languageMotherAndere
                ]);
            }
        } else {
            $addressCommunication = $this->addressRepository->findAdressPid(explode(",", $storage));

            $this->view->assignMultiple([
                'addressCommunication' => $addressCommunication,
                'techniques' => $techniques,
                'ort' => $placefuce,
                'gehoerlos' => $gehoerlos,
                'language' => $language,
                'languageMother' => $languageMother,
                'languageMotherAndere' => $languageMotherAndere
            ]);
        }


        return $this->htmlResponse();
    }


    /**
     * action show
     *
     * @param \Pingag\PingagAddress\Domain\Model\AddressPerson $addressPerson
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\Pingag\PingagAddress\Domain\Model\AddressPerson $addressPerson): \Psr\Http\Message\ResponseInterface
    {

        $this->view->assign('addressPerson', $addressPerson);
        return $this->htmlResponse();
    }


    public function getOrginalUids($uid, $sys_language_uid, $table)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $result = $queryBuilder
            ->select('*')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('deleted', 0)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('sys_language_uid', $sys_language_uid)
            )
            ->executeQuery();

        $row = $result->fetchAssociative();
        return $row['l10n_parent'];

    }


}
