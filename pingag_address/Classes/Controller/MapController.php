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
 * MapController
 */
class MapController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    const PINGAG_IP = '196.179.244.127';

    public function initializeAction(): void
    {


        $this->addressRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AddressRepository');
        $this->dienstleistungenRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\DienstleistungenRepository');
        $this->kantoneRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $this->angeboteRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AngeboteRepository');
        $this->lebensalterRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\LebensalterRepository');
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
        $storage = ($configuration['persistence']['storagePid']) ? $configuration['persistence']['storagePid'] : "20";

        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);

        if ($this->request->hasArgument('useajax')) {
            if ($this->request->hasArgument('inputValue') || $this->request->hasArgument('zipValue') || $this->request->hasArgument('umkreisValue') ) {
                //\TYPO3\CMS\Core\Utility\DebugUtility::debug($this->request->getArguments());

                $maps = $this->addressRepository->getByLangAndLat($this->request->getArguments(),explode(",", $storage));

                if($storage == 1048) {
                    if($this->request->hasArgument('zipValue')){
                        if ($this->request->getArgument('zipValue') && $this->request->getArgument('umkreisValue')) {
                            $this->view->assign('weiteresAjaxzip', 0);
                            $zip = $this->geocode((int)$this->request->getArgument('zipValue'));
                            $lowerLatitude = $this->subDistanceFromCoordinates((float)$zip[0], (float)$zip[1], (int)$this->request->getArgument('umkreisValue'), true);
                            $upperLatitude = $this->addDistanceToCoordinates((float)$zip[0], (float)$zip[1], (int)$this->request->getArgument('umkreisValue'), true);
                            $lowerLongitude = $this->subDistanceFromCoordinates((float)$zip[0], (float)$zip[1], (int)$this->request->getArgument('umkreisValue'), false);
                            $upperLongitude = $this->addDistanceToCoordinates((float)$zip[0], (float)$zip[1], (int)$this->request->getArgument('umkreisValue'), false);
                            $this->view->assign('lowerLatitude', $lowerLatitude);
                            $this->view->assign('upperLatitude', $upperLatitude);
                            $this->view->assign('lowerLongitude', $lowerLongitude);
                            $this->view->assign('upperLongitude', $upperLongitude);


                        } else if ($this->request->getArgument('zipValue')) {
                            $this->view->assign('weiteresAjaxzip', 1);
                            $this->view->assign('weiterestandortezip', $this->request->getArgument('zipValue'));
                        }
                    }else {
                        $this->view->assign('weiteresAjaxzip', 0);
                    }
                    /**/
                }


            } else {
               $maps = $this->addressRepository->findAdressPid(explode(",", $storage));
            }




            //  \TYPO3\CMS\Core\Utility\DebugUtility::debug($storage);

            if($storage == 1048){
                $this->view->assign('mapAngebote', 1);
                $this->view->assign('weiteresAjax', 1);
            }

        } else {

            if ($mapCenter = $data['mapCenter']) {
                $cords = explode(',', $mapCenter);
                $objFormat = '{"lat": %s, "lng": %s}';
                $mapCenter = sprintf($objFormat, $cords[0], $cords[1]);
                $this->view->assign('mapCenter', $mapCenter);
                $this->view->assign('defaultLat', $cords[0]);
                $this->view->assign('defaultLng', $cords[1]);
            }

            // Get Map Style from Flexform/Plugin Config
            if ($mapStyle = $data['mapStyle']) {
                $this->view->assign('mapStyle', $mapStyle);
            }
            //$maps = $this->addressRepository->findAll();

            $maps = $this->addressRepository->findAdressPid(explode(",", $storage));

            $this->view->assign('mapAngebote', $data['mapAngebote']);

        }
        $dienstleistungens = $this->dienstleistungenRepository->findAll();
        $kantones = $this->kantoneRepository->findAll();
        $angebote = $this->angeboteRepository->findAll();
        $lebensalter = $this->lebensalterRepository->findAll();

        $type = [];
        $typeKantone = [];
        $typeAngebote = [];
        $typeLebensalter = [];
        $weiterestandorte = [];
        foreach ($maps as $loc) {

            $DienstleistungenId = "";
            $KantoneId = "";
            $AngebotesId = "";
            $LebensaltersId = "";

            if ($loc->getDienstleistungen()) {
                //\TYPO3\CMS\Core\Utility\DebugUtility::debug( $loc->getServices()->getService()->getUid());
                foreach ($loc->getDienstleistungen() as $key => $Dienstleistungens) {
                    $DienstleistungenId .= $Dienstleistungens->getUid() . ",";
                }

                $string = rtrim($DienstleistungenId, ",");
                $type[$loc->getUid()] = $string;
            }
            if ($loc->getKantone()) {
                //\TYPO3\CMS\Core\Utility\DebugUtility::debug( $loc->getServices()->getService()->getUid());
                foreach ($loc->getKantone() as $key => $Kantones) {

                    $KantoneId .= $Kantones->getUid() . ",";
                }

                $string = rtrim($KantoneId, ",");
                $typeKantone[$loc->getUid()] = $string;
            }

            if ($loc->getAngebote()) {
                //\TYPO3\CMS\Core\Utility\DebugUtility::debug( $loc->getServices()->getService()->getUid());
                foreach ($loc->getAngebote() as $key => $Angebotes) {

                    $AngebotesId .= $Angebotes->getUid() . ",";
                }

                $string = rtrim($AngebotesId, ",");
                $typeAngebote[$loc->getUid()] = $string;
            }
            if ($loc->getLebensalter()) {
                //\TYPO3\CMS\Core\Utility\DebugUtility::debug( $loc->getServices()->getService()->getUid());
                foreach ($loc->getLebensalter() as $key => $Lebensalters) {

                    $LebensaltersId .= $Lebensalters->getUid() . ",";
                }

                $string = rtrim($LebensaltersId, ",");
                $typeLebensalter[$loc->getUid()] = $string;
            }



        }

        /*if($debug){
            \TYPO3\CMS\Core\Utility\DebugUtility::debug($maps);
        }*/


        $this->view->assign('maps', $maps);
        $this->view->assign('dienstleistungens', $dienstleistungens);
        $this->view->assign('kantones', $kantones);
        $this->view->assign('angebotes', $angebote);
        $this->view->assign('lebensalters', $lebensalter);
        $this->view->assign('count', count($maps));
        $this->view->assign('addressWithIdDienstleistungens', $type);
        $this->view->assign('addressWithIdKantones', $typeKantone);
        $this->view->assign('addressWithIdAngebote', $typeAngebote);
        $this->view->assign('addressWithIdLebensalter', $typeLebensalter);


        return $this->htmlResponse();
    }

    public function confirmAction()
    {
        //add action in typo3conf
        //get registraion from url after click
        //get event from url after click

        $uidOfRegistration = $_GET['tx_pingagaddress_mapshow']['registration'];

        $registration = $this->infoTable((int)$uidOfRegistration);

        $api = GeneralUtility::makeInstance(Api::class);
        $configurationService = GeneralUtility::makeInstance(ConfigurationService::class);
        $formId = $_GET['tx_pingagaddress_mapshow']['formId'];
        $groupId = $_GET['tx_pingagaddress_mapshow']['groupId'];
        $cleverreach = $_GET['tx_pingagaddress_mapshow']['cleverreach'];
        $vorname = $registration['firstname'];
        $Name = $registration['lastname'];
        $email = $registration['email'];
        $acompany = $registration['acompany'];
        $dateOfBirth = $registration['date_of_birth'];
        $markers = $registration['gender'];
        switch ($markers) {
            case "s":
                $marker = 'Herr';
                break;
            case "f":
                $marker = 'Frau';
                break;
            case "n":
                $marker = 'Neutral';
                break;
            default:
                $marker = 'Herr';
        }
        $formValues = array();

        if ($cleverreach === Api::MODE_OPTIN) {

            $formValues['vorname'] = $vorname;
            $formValues['nachname'] = $Name;
            $formValues['mailadresse'] = $email;
            $formValues['herr___frau'] = $marker;
            if ($dateOfBirth) {
                $newDate = date("Y-m-d", strtotime($dateOfBirth));
                $formValues['geburtstdatum'] = $newDate;

            }
            $formValues['firma'] = $acompany;

            $receiver = new Receiver($email, $formValues);
            $receiver->setActivated(1);
            $api->addReceiversToGroup($receiver, $groupId);
            $api->sendSubscribeMail($email, $formId, $groupId);

        } else if ($cleverreach === Api::MODE_OPTOUT) {

            if ($configurationService->getUnsubscribeMethod() === 'doubleoptout') {

                $api->sendUnsubscribeMail($email);

            } else if ($configurationService->getUnsubscribeMethod() === 'delete') {

                $api->removeReceiversFromGroup($email);

            } else {

                $api->disableReceiversInGroup($email, $groupId);

            }

        }

        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();

// specify the page ID for the link
        $uriBuilder->setTargetPageUid((int)228);

// specify extra parameters for the link
// At this stage, the variable $keywords will contain a single
// entry, to which the browser will be redirected

        $uri = $uriBuilder->build(); // ready, steady…
        $this->redirectToUri($uri); // …go!



    }

    public function updateToTable($table, $options, $uid)
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable($table);
        $sql = $queryBuilder
            ->update($table)
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            );
        foreach ($options as $key => $option) {
            $sql->set($key, $option);
        };
        return $sql->execute();
    }

    /**
     * action show
     *
     * @param \Pingag\PingagAddress\Domain\Model\Map $map
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\Pingag\PingagAddress\Domain\Model\Map $map): \Psr\Http\Message\ResponseInterface
    {

        $this->view->assign('map', $map);
        return $this->htmlResponse();
    }

    public function infoTable($uid)
    {


        $fields = '*';
        $table = 'tx_sfeventmgt_domain_model_registration';
        $where = $uid . '= tx_sfeventmgt_domain_model_registration.uid';
        $groupBy = '';
        $orderBy = '';
        $limit = '1';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        return $record;
    }

    /**
     * @param $address
     * @return array
     */
    function geocode($address)
    {
        // get matching Ort name from PLZ
        $ort = "";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://openplzapi.org/ch/Localities?postalCode=" . $address);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Accept: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            // do nothing
        } else {
            $result = json_decode($result);
            foreach ($result as $result1) {
                $ort = $result1->name;
                $ort = str_replace(' ', '', $ort);
            }
        }
        curl_close ($ch);

        if (empty($result)) {
            return $this->geocode(intval($address) + 1);
        }

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($ort);

        // --- Step 2: Build structured Nominatim query ---
        $nominatimUrl = "https://nominatim.openstreetmap.org/search?";
        $query = [
            'country'     => 'Switzerland',
            'postalcode'  => $address,
            'format'      => 'json',
            'limit'       => 1
        ];
        if (!empty($ort)) {
            $query['city'] = $ort;
        }

        $requestURL = $nominatimUrl . http_build_query($query);

        // --- Step 3: Query Nominatim via cURL ---
        $ch = curl_init($requestURL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["User-Agent: MyAppGeocoder/1.0"],
            CURLOPT_TIMEOUT => 10
        ]);

        $json = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log("Nominatim request failed: " . curl_error($ch));
            curl_close($ch);
            return null;
        }
        curl_close($ch);

        // --- Step 4: Parse response ---
        $data = json_decode($json, true);
        if (empty($data) || !isset($data[0]['lat'], $data[0]['lon'])) {
            return null;
        }

        $lat = (float)$data[0]['lat'];
        $lon = (float)$data[0]['lon'];

        return [$lat, $lon];
    }

    // Function to add distance in kilometers to latitude or longitude
    function addDistanceToCoordinates($lat, $lon, $kmToAdd, $isLatitude) {
        $degreesToAdd = $kmToAdd / ($isLatitude ? 111 : (111 * cos(deg2rad($lat))));
        return $isLatitude ? $lat + $degreesToAdd : $lon + $degreesToAdd;
    }

    // Function to subtract distance in kilometers to latitude or longitude
    function subDistanceFromCoordinates($lat, $lon, $kmToSub, $isLatitude) {
        $degreesToSub = $kmToSub / ($isLatitude ? 111 : (111 * cos(deg2rad($lat))));
        return $isLatitude ? $lat - $degreesToSub : $lon - $degreesToSub;
    }




}
