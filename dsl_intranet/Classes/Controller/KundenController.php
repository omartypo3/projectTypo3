<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;

use DslFactory\DslIntranet\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect;
use DslFactory\DslIntranet\Utility\FileUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Database\Connection;
/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * KundenController
 */
class KundenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * kundenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\KundenRepository
     */
    protected $kundenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\KundenRepository $kundenRepository
     */
    public function injectKundenRepository(\DslFactory\DslIntranet\Domain\Repository\KundenRepository $kundenRepository)
    {
        $this->kundenRepository = $kundenRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->kundenAgenturvertraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenAgenturvertraegeRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->dateienRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\DateienRepository');
    }

   
    /**
     * action import
     *
     * @return void
     */
    public function importAction()
    {
		
		$newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();

		//die();
		if ($this->request->hasArgument('newDateien')) {
			$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
			$FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
			$fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

			$uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('kundenImport');

							//$uploadedImage = $this->createUserProfileImage($image);
							// Index the image, it will move the file and return the FAL file object
			$indexedFiles = $fileUtility->indexImages($this->request->getArgument('newDateien')['datei'], $uploadSettings['falStorageSubDir'], true);

			if (!empty($indexedFiles)) {
				$falFile = $indexedFiles[0];
				// Now, you can create a FileReference from this FAL file and save it to your model
				$fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');

				// Assuming you have an Event model that accepts a FileReference
				$newDateien->setDatei($fileReference);


			}
			$newDateien->setType(10);
			$this->dateienRepository->add($newDateien);
			$storageCfg = $newDateien->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->getConfiguration();
			
			$resultarray[] = rtrim($storageCfg['basePath'], '/') . $newDateien->getDatei()->getOriginalResource()->getOriginalFile()->getIdentifier();
            $fileContent = utf8_encode($newDateien->getDatei()->getOriginalResource()->getContents());
			$lines = preg_split("/\r\n|\n|\r/", $fileContent); // handles different newline types
			$fileArr = array();
			$rows = [];
			$currentRow = '';

			foreach ($lines as $line) {
				$line = trim($line);
				if (empty($line)) {
					continue;
				}

				if (preg_match('/^(!?CUST|!FOOTER|FOOTER|EndOfLine)/', $line)) {
					if ($currentRow !== '') {
						$rows[] = $currentRow;
						$currentRow = '';
					}
				}

				$currentRow .= ($currentRow !== '' ? ' ' : '') . $line;
			}
			if ($currentRow !== '') {
				$rows[] = $currentRow;
			}

			
            //parse the rows
            foreach ($rows as $row) {
                $fileArr[] = str_getcsv($row, "\t");
            }
			
            $qbArray = $this->getKundenFromArray($fileArr);
			
            $this->syncKundenFromQuickBooks($qbArray);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            $resultarray[] = array('fileArr' => $fileArr);
            $resultarray[] = array('qbArray' => $qbArray);
            //			die;
            $resultarray[] = 'imported!!';
            $resultarray[] = 'getDatei:' . $newDateien->getDatei();
		}
		
		
		
		//die();
        $this->view->assign('resultarray', $resultarray);
        $this->view->assign('newDateien', $newDateien);
		
		

    }

   
    /**
     * @param $csv
     */
    public function getKundenFromArray($csv)
    {
        /*		$handle = fopen($file, "r");
            if ($handle) {
            while (!feof($handle)) $text.= fgets($handle, 4096);
            fclose($handle);
            }
            $lines = explode("\r",$text);*/
			
		
        $kundenArr = array();
        foreach ($csv as $key => $tmp) {
			
            if (trim($tmp[0]) == '!CUST') {
                $haeder = array_flip($tmp);
            }
            if (trim($tmp[0]) == 'CUST') {
				

                //&& $tmp[34] && $tmp[4]
                $rechtsformArr = array('Einzelunternehmen', 'GmbH &amp; Co. KG', 'gGmbH', 'GmbH', 'mbH', 'e.K.', 'GbR', 'OHG', 'KG', 'e. V.', 'AG', 'eG');
                $ignoreArr = array(' ', '&', 'amp;');
                $adrArr = array();
                unset($rechtsform);
                if ($tmp[$haeder['BADDR1']]) {
                    $adrArr[] = $tmp[$haeder['BADDR1']];
                }
                if ($tmp[$haeder['BADDR2']]) {
                    $adrArr[] = $tmp[$haeder['BADDR2']];
                }
                if ($tmp[$haeder['BADDR3']]) {
                    $adrArr[] = $tmp[$haeder['BADDR3']];
                }
                if ($tmp[$haeder['BADDR4']]) {
                    $adrArr[] = $tmp[$haeder['BADDR4']];
                }
                if ($tmp[$haeder['BADDR5']]) {
                    $adrArr[] = $tmp[$haeder['BADDR5']];
                }
                foreach ($adrArr as $key => $value) {
                    if ($rechtsform) {
                        break;
                    }
                    foreach ($rechtsformArr as $rechtsformValue) {
                        if (stristr(str_replace($ignoreArr, '', $value), str_replace($ignoreArr, '', $rechtsformValue)) === FALSE) {

                        } else {
                            $rechtsform = $rechtsformValue;
                            break;
                        }
                    }
                }
                $adrArr = array();
                if ($tmp[$haeder['BADDR5']]) {
                    $adrArr[] = $tmp[$haeder['BADDR5']];
                }
                if ($tmp[$haeder['BADDR4']]) {
                    $adrArr[] = $tmp[$haeder['BADDR4']];
                }
                if ($tmp[$haeder['BADDR3']]) {
                    $adrArr[] = $tmp[$haeder['BADDR3']];
                }
                if ($tmp[$haeder['BADDR2']]) {
                    $adrArr[] = $tmp[$haeder['BADDR2']];
                }
                unset($plz);
                unset($ort);
                unset($strasse);
                foreach ($adrArr as $key => $value) {
                    if ($plz && $ort) {
                        $strasse = $value;
                        break;
                    }
                    if (str_replace(' ', '', $value[2] . $value[3] . $value[4]) > 1 && str_replace(' ', '', $value[2] . $value[3] . $value[4]) < 1000) {
                        //plz gefunden
                        $plzArr = explode(' ', $value);
                        $plz = $plzArr[0];
                        unset($plzArr[0]);
                        $ort = implode(' ', $plzArr);
                        unset($adrArr[$key]);
                    }
                }
                //				$emailTemp = $tmp[$haeder['EINVEMAIL']];
                //				if(!$emailTemp) $emailTemp = $tmp[$haeder['EMAIL']];
                if($strasse==NULL) $strasse = "";
                if($plz==NULL) $plz = "";
                if($ort==NULL) $ort = "";
                $kundenArr[] = array(
                    'knr' => $tmp[$haeder['NAMENUMBER']],
                    'company' => $tmp[$haeder['BADDR1']],
                    'refnum' => $tmp[$haeder['REFNUM']],
                    'qb_firstname' => $tmp[$haeder['FIRSTNAME']],
                    'qb_lastname' => $tmp[$haeder['LASTNAME']],
                    'qb_inhaber' => $tmp[$haeder['FIRSTNAME']] . ' ' . $tmp[$haeder['LASTNAME']],
                    'qb_street' => $strasse,
                    'qb_postal' => $plz,
                    'qb_city' => $ort,
                    'qb_anrede' => $tmp[$haeder['SALUTATION']],
                    'qb_phone' => $tmp[$haeder['PHONE1']],
                    'qb_mobile' => $tmp[$haeder['PHONE2']],
                    'qb_fax' => $tmp[$haeder['FAXNUM']],
                    'qb_email' => trim($tmp[$haeder['EMAIL']]),
                    'qb_kto_nr' => $tmp[$haeder['ACCNO']],
                    'qb_bank' => $tmp[$haeder['BANK']],
                    'qb_blz' => $tmp[$haeder['BLZ']],
                    'qb_kto_inh' => $tmp[$haeder['ACCHOLDER']],
                    'qb_iban' => $tmp[$haeder['IBAN']],
                    'qb_bic' => $tmp[$haeder['BIC']],
                    'qb_rechtform' => $rechtsform,
                    'qb_hidden' => $tmp[$haeder['HIDDEN']],
                    'qb_company' => $tmp[$haeder['COMPANYNAME']],
                    'qb_baddr' => implode('
',
                        array($tmp[$haeder['BADDR1']], $tmp[$haeder['BADDR2']], $tmp[$haeder['BADDR3']], $tmp[$haeder['BADDR4']], $tmp[$haeder['BADDR5']])
                    ),
                    'qb_cont' => $tmp[$haeder['CONT1']],
                    'qb_cont2' => $tmp[$haeder['CONT2']],
                    'qb_phone2' => $tmp[$haeder['PHONE2']],
                    'qb_einvemail' => trim($tmp[$haeder['EINVEMAIL']])
                );
            }
        }

        /*?><pre><?php print_r($kundenArr);?></pre><?php */
        return $kundenArr;
    }

    /**
     * @param $qbArray
     */
    public function syncKundenFromQuickBooks($qbArray)
    {
        foreach ($qbArray as $kundeQb) {
            //if ($kundeQb['knr']) {
            /*	if($kunden = $this->kundenRepository->findByNummer($kundeQb["knr"])){
               //		echo $kunden->getEmail();
               echo "gibts schopn";
               }
               echo ":".$kundeQb["knr"];*/

            //inaktiver kunde prüfen ob er im typo deaktiviert werden muß
            //if($kundeQb["qb_hidden"]=='Y'){
            //}
            //				if ($kunden = $this->kundenRepository->findByNummer($kundeQb['knr'])) {
            if ($kunden = $this->kundenRepository->findByQbrefnum($kundeQb['refnum'])) {
                $kunden = $this->updateKundenProperties($kunden, $kundeQb);
                $this->kundenRepository->update($kunden);
                continue;
            }
            /*if ($kundeQb['qb_hidden'] == 'Y') {
              continue;
              }*/

            //nur einfügen wenn der kunde überhaupt noch im qb aktiv ist
            //prüfen ob evtl schon ein kunde mit der kundennummer im intranet angelegt wurde
            if ($kundeQb['knr']) {
                if ($kunden = $this->kundenRepository->findByNummer($kundeQb['knr'])) {
                    $kunden = $this->updateKundenProperties($kunden, $kundeQb);
                    $this->kundenRepository->update($kunden);
                    continue;
                }
            }
            if ($kundeQb['qb_hidden'] != 'Y') {
                $kunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();
                $kunden->setPid((int)$this->settings['kundenPid']);
                $kunden = $this->updateKundenProperties($kunden, $kundeQb);
                //if($kundeQb['qb_hidden'] == 'Y') $kunden->setDisable(1);
                $this->kundenRepository->add($kunden);
            }
        }
    }

    /**
     * @param $kunden
     * @param $kundeQb
     */
    public function updateKundenProperties($kunden, $kundeQb)
    {
        if ($kunden->getQbrefnum()) {

        } else {
            //neuer kunde
            $kunden->setQbrefnum($kundeQb['refnum']);
            $kunden->setNummer($kundeQb['knr']);
            //$kunden->setEmail($kundeQb['qb_email']);

        }


        if ($kundeQb['company']) {
            $kunden->setCompany($kundeQb['company']);
            $kunden->setName($kundeQb['company']);
        } else {
            $kunden->setName($kunden->getFirstName() . ' ' . $kunden->getLastName());
        }

        $kunden->setFirstName($kundeQb['qb_firstname']);
        $kunden->setLastName($kundeQb['qb_lastname']);
        $kunden->setAddress($kundeQb['qb_street']);
        $kunden->setCity($kundeQb['qb_city']);
        $kunden->setZip($kundeQb['qb_postal']);

        $kunden->setTelephone($kundeQb['qb_phone']);

        $kunden->setFax($kundeQb['qb_fax']);

        if (!$kunden->getEmail() && $kundeQb['qb_email']) {
            $kunden->setEmail($kundeQb['qb_email']);
        }
        if (!$kunden->getEmail() && $kundeQb['qb_einvemail']) {
            $kunden->setEmail($kundeQb['qb_einvemail']);
        }
        $kunden->setQbCompany($kundeQb['qb_company']);
        $kunden->setQbBank($kundeQb['qb_bank']);
        $kunden->setQbIban($kundeQb['qb_iban']);
        $kunden->setQbBic($kundeQb['qb_bic']);
        $kunden->setQbEmail($kundeQb['qb_email']);
        $kunden->setQbFirstname($kundeQb['qb_firstname']);
        $kunden->setQbLastname($kundeQb['qb_lastname']);
        $kunden->setQbPhone($kundeQb['qb_phone']);
        $kunden->setQbStreet($kundeQb['qb_street']);
        $kunden->setQbPostal($kundeQb['qb_postal']);
        $kunden->setQbCity($kundeQb['qb_city']);
        $kunden->setQbbaddr($kundeQb['qb_baddr']);
        $kunden->setMobilephone($kundeQb['qb_mobile']);
        //alt



        if ($kundeQb['qb_hidden'] == 'Y') {
            $kunden->setDisable(1);
        } else {
            //$kunden->setDisable(0);
            $kunden->setDisable(0);
        }
        $kunden->setQbAnrede($kundeQb['qb_anrede']);
        $kunden->setQbCont($kundeQb['qb_cont']);
        $kunden->setQbCont2($kundeQb['qb_cont2']);
        $kunden->setQbPhone2($kundeQb['qb_phone2']);
        $kunden->setQbKtoInh($kundeQb['qb_kto_inh']);
        $kunden->setQbEinvemail($kundeQb['qb_einvemail']);

        if (!$kunden->getCompany()) {
            if ($kunden->getQbCompany()) {
                $kunden->setCompany($kunden->getQbCompany());
            }
        }
        return $kunden;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     */
    private function updateKundenFromRequest($kunden)
    {
        if ($this->request->hasArgument('picDropZugangscode')) {
            $kunden->setPicDropZugangscode($this->request->getArgument('picDropZugangscode'));
        }
        if ($this->request->hasArgument('telephone')) {
            $kunden->setTelephone($this->request->getArgument('telephone'));
        }
        if ($this->request->hasArgument('username')) {
            $kunden->setUsername($this->request->getArgument('username'));
        }
        if ($this->request->hasArgument('name')) {
            $kunden->setName($this->request->getArgument('name'));
        }
        if ($this->request->hasArgument('company')) {
            $kunden->setCompany($this->request->getArgument('company'));
        }
        if ($this->request->hasArgument('title')) {
            $kunden->setTitle($this->request->getArgument('title'));
        }
        if ($this->request->hasArgument('firstName')) {
            $kunden->setFirstName($this->request->getArgument('firstName'));
        }
        if ($this->request->hasArgument('lastName')) {
            $kunden->setLastName($this->request->getArgument('lastName'));
        }
        if ($this->request->hasArgument('address')) {
            $kunden->setAddress($this->request->getArgument('address'));
        }
        if ($this->request->hasArgument('zip')) {
            $kunden->setZip($this->request->getArgument('zip'));
        }
        if ($this->request->hasArgument('city')) {
            $kunden->setCity($this->request->getArgument('city'));
        }
        if ($this->request->hasArgument('fax')) {
            $kunden->setFax($this->request->getArgument('fax'));
        }
        if ($this->request->hasArgument('qbPhone2')) {
            $kunden->setQbPhone2($this->request->getArgument('qbPhone2'));
        }
        if ($this->request->hasArgument('qbCont2')) {
            $kunden->setQbCont2($this->request->getArgument('qbCont2'));
        }
        if ($this->request->hasArgument('qbKtoInh')) {
            $kunden->setQbKtoInh($this->request->getArgument('qbKtoInh'));
        }
        if ($this->request->hasArgument('qbBank')) {
            $kunden->setQbBank($this->request->getArgument('qbBank'));
        }
        if ($this->request->hasArgument('qbIban')) {
            $kunden->setQbIban($this->request->getArgument('qbIban'));
        }
        if ($this->request->hasArgument('qbBic')) {
            $kunden->setQbBic($this->request->getArgument('qbBic'));
        }
        if ($this->request->hasArgument('nummer')) {
            $kunden->setNummer($this->request->getArgument('nummer'));
        }
        if ($this->request->hasArgument('email')) {
            $kunden->setEmail($this->request->getArgument('email'));
        }
        if ($this->request->hasArgument('emailRechnungen')) {
            $kunden->setEmailRechnungen($this->request->getArgument('emailRechnungen'));
        }
        if ($this->request->hasArgument('emailAngebote')) {
            $kunden->setEmailAngebote($this->request->getArgument('emailAngebote'));
        }
        if ($this->request->hasArgument('disable')) {
            if ($this->request->getArgument('disable')) {
                $kunden->setDisable(0);
            } else {
                $kunden->setDisable(1);
            }
        }
		//$kunden->setSettings("");
		//$kunden->setQbbaddr("");
		//$kunden->setFarbe("");

        /*dsl korrektur*/
        if ($this->request->hasArgument('login')) {
            $kunden->setLogin($this->request->getArgument('login'));
        }
        return $kunden;
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
        if ($this->request->hasArgument('switch')) {
            $this->view->assign('switch', $this->request->getArgument('switch'));
            switch ($this->request->getArgument('switch')) {
                case 'filterSet':    $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    if ($this->request->hasArgument('settings')) {
                        $stringRepresentation= json_encode($this->request->getArgument('settings'));
                        $benutzer->setSettingsKunden($stringRepresentation);
                    } else {
                        $benutzer->setSettingsKunden('');
                    }
                    //echo "test";echo $benutzer->getUid();
                    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
                    $frontendUserRepository = $objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
                    $frontendUserRepository->update($benutzer);
                    //echo "bla";
                    $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $settings = $benutzer->getSettingsKunden();
                    $kundenGefiltert = $this->kundenRepository->findByFilter($settings, false, false, array(), false, true);
                    //$kundenGefiltert = $this->kundenRepository->findAll();
                    $found = count($kundenGefiltert);
                    $this->view->assign('kundens', $kundenGefiltert);
                    $this->view->assign('returnString', json_encode(array('found' => $found)));
                    //echo json_encode(array('found' => $found, 'contentShow' => "test"));//$this->getKundenAuftraegeList($auftraegeGefiltert)
                    //from wird nicht mehr benötigt ?! //  'from' => count($this->auftraegeRepository->findByFilter(array(), false, false, array(), false, true)),
                    //,'contentShow'=>$this->getKundenAuftraegeList($auftraegeGefiltert)
                    //die;
                    break;
                case 'autologin':    //$returnArr = array('uid' => $this->request->getArgument('uid'), 'contentShow' => 'autologinurl!!');
                    //echo json_encode($returnArr);
                    //sethash
                    $kunden = $this->kundenRepository->findByUid($this->request->getArgument('uid'));
                    $kunden->setAutologin((string)time());
                    $this->kundenRepository->update($kunden);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $uriBuilder = $this->controllerContext->getUriBuilder();
                    $uriBuilder->reset();
                    $uriBuilder->setTargetPageType(89656999);
                    $uriBuilder->setTargetPageUid(84);
                    $uriBuilder->setArguments(array(
                        'tx_dslintranet_autologin' => array(
                            'controller' => 'Kunden',
                            'action' => 'autologin',
                            'uid' => $this->request->getArgument('uid')
                        )
                    ));
                    $hostKundenlogin = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('hostKundenlogin');
                   // $url = $hostKundenlogin . '/' . $uriBuilder->build();
                    $url = $uriBuilder->build();

                    header('Location: ' . $url);
                    //				echo '<div><a href="'.$url.'">'.$url.'</a></div>';
                    die;
                    break;
                case 'show':   
					if (!$this->request->hasArgument('kunden')) {
						break;
					}
				
                    $kunden = $this->kundenRepository->findByUid((int)$this->request->getArgument('kunden'));
					if(!$kunden){
						$kunden = $this->kundenRepository->getUidIgnoreDeleted($this->request->getArgument('kunden'));

					}
                    if ($kunden) {
                        $this->showAction($kunden);					
                    }else{
						echo 'errpr kunden:' . $kunden . ':' . $this->request->getArgument('kunden');
						die;
						break;
					}
                    break;
                case 'toggleDisable':    if (!$this->request->hasArgument('uid')) {
                    break;
                }
                    if ($kunde = $this->kundenRepository->findByUid($this->request->getArgument('uid'))) {
                        //print_r($this->request->getArguments());
                        //	echo "!!!".$kunde->getUid();
                        //echo "!!!vorher:".$kunde->getDisable();
                        $kunde->setDisable($this->request->getArgument('disable'));
                        //	echo "!!!nachher:".$kunde->getDisable();
                        $this->kundenRepository->update($kunde);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        $returnArr = array('uid' => $this->request->getArgument('uid'), 'contentShow' => $this->getPartialsListRow($kunde));
                        echo json_encode($returnArr);
                    }
                    //echo "!!!";
                    //	print_r($this->request->getArguments('uid'));
                    die;
                    break;
                case 'zugangsdaten':    $status = 'missing_field';
                    $contentShow = '';
                    if ($this->request->hasArgument('kunden') && $this->request->hasArgument('password') && $this->request->hasArgument('empfaenger') && $this->request->hasArgument('betreff') && $this->request->hasArgument('nachricht')) {
                        if ($this->request->getArgument('kunden') && $this->request->getArgument('password') && $this->request->getArgument('empfaenger') && $this->request->getArgument('betreff') && $this->request->getArgument('nachricht')) {
                            if ($kunde = $this->kundenRepository->findByUid($this->request->getArgument('kunden'))) {
                                //$dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Mail/PartialSignatur.html', $this->request->getControllerExtensionName());
                                $kunde->setPassword($this->encryptPassword($this->request->getArgument('password')));
                                $kunde->setPasswortKopie($this->request->getArgument('password'));
                                $this->kundenRepository->update($kunde);
                                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                                //neu mailversand
                                $template = 'Mail/KundenZugangsdaten.html';
                                $notification = (object) array(
                                    'betreff' => $this->request->getArgument('betreff'),
                                    'body' => $this->request->getArgument('nachricht'),
                                    'bodyHtml' => nl2br($this->request->getArgument('nachricht')),
                                    'benutzername' => $kunde->getUsername(),
                                    'passwort' => $this->request->getArgument('password')
                                );
                                $view = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, 'DslIntranet');
                                $view->assign('notification', $notification);
                                $view->assign('layout', 'MailBetreff');
                                $subject = $view->render();
                                $view->assign('layout', 'MailHtml');
                                $bodyHtml = $view->render();
                                $view->assign('layout', 'MailText');
                                $body = $view->render();
                                $status = \DslFactory\DslIntranet\Utility\MailUtility::init()->sendMail($subject, $body, $this->request->getArgument('empfaenger'), $kunde->getName(), $bodyHtml);
                                $kunde->addHistory('accessMail', array(
                                    'betreff' => $this->request->getArgument('betreff'),
                                    'content' => $body,
                                    'toMail' => $this->request->getArgument('empfaenger'),
                                    'toName' => $kunde->getName(),
                                    'status' => $status
                                ));
                                //print_r($kunde->getHistory());die;
                                $this->kundenRepository->update($kunde);
                                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                                $contentShow = $this->getPartialsListRow($kunde);
                            }
                        }
                    }
                    $returnArr = array('uid' => $this->request->getArgument('kunden'), 'status' => $status);
                    if ($contentShow) {
                        $returnArr['contentShow'] = $contentShow;
                    }
                    echo json_encode($returnArr);
                    //					print_r( $this->request->getArguments() );
                    //					echo "bli";
                    die;
                    break;
                case 'edit':    //tx_rnbase::load('tx_t3users_util_LoginAsFEUser');
                    $kunden = $this->kundenRepository->findByUid($this->request->getArgument('kunden'));
					if(!$kunden){
						$kunden = $this->kundenRepository->getUidIgnoreDeleted($this->request->getArgument('kunden'));

					}
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Kunden/Edit.html', $this->request->getControllerExtensionName());
					$kunden->setUsername($kunden->getNummer());
                    $dbView->assign('kunden', $kunden);
                    $dbView->assign('editForm', true);
                    return $dbView->render();
                    break;

                case 'update':    $kunden = $this->kundenRepository->findByUid($this->request->getArgument('kunden'));
                    if(!$kunden){
						$kunden = $this->kundenRepository->getUidIgnoreDeleted($this->request->getArgument('kunden'));

					}
					//$kunde = $this->kundenRepository->findByUid($this->request->getArgument('kunden'));
                    //echo "knr".$kunde->getUid();
                    $kunden = $this->updateKundenFromRequest($kunden);
                    $this->kundenRepository->update($kunden);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('uid' => $kunden->getUid(), 'contentShow' => $this->getPartialsListRow($kunden)));
                    die;
					break;
                case 'editNotizen':    //tx_rnbase::load('tx_t3users_util_LoginAsFEUser');
                    $kunden = $this->kundenRepository->findByUid($this->request->getArgument('kunden'));
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Kunden/EditNotizen.html', $this->request->getControllerExtensionName());
                    //$kunden->setUsername($kunden->getNummer());
                    $dbView->assign('kunden', $kunden);
                    $dbView->assign('editForm', true);
                    return $dbView->render();
                    break;
                case 'updateNotizen':    $kunden = $this->kundenRepository->findByUid($this->request->getArgument('kunden'));
                    //$kunde = $this->kundenRepository->findByUid($this->request->getArgument('kunden'));
                    //echo "knr".$kunde->getUid();

                    if($this->request->hasArgument('textNotizen')) $kunden->setNotizen($this->request->getArgument('textNotizen'));
                    //$kunden = $this->updateKundenFromRequest($kunden);
                    $this->kundenRepository->update($kunden);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    return json_encode(array('uid' => $kunden->getUid()));// , 'contentShow' => $this->getPartialsListRow($kunden)
                    break;
                case 'create':    $kunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();
                    //$kunden->setFeCruserId(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                   // \TYPO3\CMS\Core\Utility\DebugUtility::debug($this->settings['kundenPid']);
					$kunden->setPid((int)$this->settings['kundenPid']);
					
                    $kunden = $this->updateKundenFromRequest($kunden);
					//die();
                    $this->kundenRepository->add($kunden);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('newUid' => $kunden->getUid(), 'contentShow' => $this->getPartialsListRow($kunden)));
                    //$this->redirect('ajax');
                    die;
                    //$newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege $this->request->getArgument('titel');
                    break;
                case 'delete':    if ($this->request->hasArgument('uid')) {
                    if ($kunde = $this->kundenRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($kunde);
                        return true;
                    }
                }
                    break;
                case 'checkForm':    //$kunde = $this->kundenRepository->findByUidIgnoreDeleted($this->request->getArgument('uid'));
                    //sleep(5);
                    $kunden = $this->kundenRepository->findOtherByField($this->request->getArgument('field'), $this->request->getArgument('value'), $this->request->getArgument('uid'));
                    echo count($kunden);
                    die;
                    break;
                default:    header('HTTP/1.1 400 Bad Request');
                    return json_encode(array('error' => 'Bad request!'));
                    break;
            }
        }
       // return $this->htmlResponse();
    }
    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     */
    public function getPartialsListRow(\DslFactory\DslIntranet\Domain\Model\Kunden $kunden)
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Kunden/ListItemAjax.html', $this->request->getControllerExtensionName());
        $dbView->assignMultiple(array('kunden' => $kunden));
        return $dbView->render();
    }

    //Abgeschaut aus: sf_register_6.2.8 // FeuserController.php
    /**
     * Encrypt the password
     *
     * @param string $password
     * @return string
     */
    public static function encryptPassword($password)
    {
		/** @var PasswordHashFactory $passwordHashFactory */
        $passwordHashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        $passwordHash = $passwordHashFactory->getDefaultHashInstance('FE');
        $password =  $passwordHash->getHashedPassword($password);
       
        return $password;
    }

    /**
     * action access
     *
     * @return void
     */
    public function accessAction()
    {
		$kunden = $this->kundenRepository->findByUid($this->request->getArgument('kunden'));
		
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Kunden/Access.html', $this->request->getControllerExtensionName());
        //		$view = $this->getView('Auftraege/Show.html');       
	   $dbView->assign('kunden', $kunden);
        echo $dbView->render();
        die;
    }

    /**
     * action environment
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function environmentAction(): \Psr\Http\Message\ResponseInterface
    {
        $kundenAgenturvertraeges = $this->kundenAgenturvertraegeRepository->findAllForKunde();
        //return array(1=>"bla",2=>"bli","aha"=>"mhhh");
        $this->view->assign('agenturvertraege', count($kundenAgenturvertraeges));
        return $this->htmlResponse();
    }

    /**
     * action autologin
     *
     * @return void
     */
    public function autologinAction()
    {
        $kunden = $this->kundenRepository->findByUid($this->request->getArgument('uid'));
        $time = time() - (int)$kunden->getAutologin();
        $kunden->setAutologin('');
        $this->kundenRepository->update($kunden);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

        //$time = time()-"";
        if ($time > 5) {
            header('HTTP/1.0 403 Forbidden');
            die;
        }
        //echo $time;die;
        //print_r($loginData);
        $GLOBALS['TSFE']->fe_user->checkPid = 0;
        $info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($info['db_user']['table']);
		
        $user = $queryBuilder
            ->select('*')
            ->from($info['db_user']['table'])
            ->where(
                $queryBuilder->expr()->eq('username', $queryBuilder->createNamedParameter($kunden->getUsername()))
            )
            ->executeQuery()
            ->fetchAssociative();

        if ($user) {
			
				$feUser = $GLOBALS['TSFE']->fe_user;
				$feUser->start(); // Start the session if it's not started already

				$feUser->createUserSession($user);
				$feUser->loginSessionStarted = true;
				$feUser->user = $feUser->fetchUserSession();
				$GLOBALS['TSFE']->loginUser = true; // Corrected this line to use boolean true
				$GLOBALS['TSFE']->initUserGroups(); 
				
				 $cookieValue = $feUser->id; // This is an example; adjust according to your user session data
				 $cookieName = 'fe_typo_user';

				// Set the cookie with the appropriate parameters
				setcookie($cookieName, $cookieValue, time() + 3600, '/');
				$hostKundenlogin = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('hostKundenlogin');
				\TYPO3\CMS\Core\Utility\HttpUtility::redirect($hostKundenlogin);
				die();

        }
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $this->view->assign('anzahlAuftraegeByKunde', $auftraegeRepository->anzahlByKunde());
        $this->view->assign('anzahlAuftraegeAVByKunde', $auftraegeRepository->anzahlAVByKunde());
        $wartungsvertraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
        $this->view->assign('anzahlWartungsvertraegeByKunde', $wartungsvertraegeRepository->anzahlByKunde());
        $hostingRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingRepository');
        $this->view->assign('anzahlHostingByKunde', $hostingRepository->anzahlByKunde());
        $kundens = $this->kundenRepository->findAll();
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $benutzer->getSettingsKunden();
        $this->view->assign('settings', $settings);
        $kundens = $this->kundenRepository->findByFilter($settings, false, false, array(), false, true);
        $this->view->assign('kundens', $kundens);
        $this->view->assign('filterAktiv', array('aktiv' => 'Kunde Aktiv', 'inaktiv' => 'Kunde Inaktiv'));
        $this->view->assign('filterLogin', array('aktiv' => 'Login Aktiv', 'inaktiv' => 'Login Inaktiv'));
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     * @return void
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Kunden $kunden)
    {
       //		echo $kunden
        //		echo "bla";
        //		die;
		
		$dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Kunden/Show.html', $this->request->getControllerExtensionName());
		
        /*$dbView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        //echo "WW";
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        //exit;
        $dbView->getRequest()->setControllerExtensionName($this->request->getControllerExtensionName());
        $dbView->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]) . 'Kunden/Show.html');
        $dbView->setLayoutRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPaths'][0]));
        $dbView->setPartialRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPaths'][0]));
        //		$view = $this->getView('Auftraege/Show.html');
		*/
        $dbView->assign('kunden', $kunden);
        echo $dbView->render();
        die;
    }

    /**
     * action new
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $newKunden
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(\DslFactory\DslIntranet\Domain\Model\Kunden $newKunden = NULL): \Psr\Http\Message\ResponseInterface
    {
        $newKunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();
        //$newKunden = new
        $newKunden->setDisable(1);
        $this->view->assign('kunden', $newKunden);
        $this->view->assign('editForm', false);
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $newKunden
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Kunden $newKunden)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenRepository->add($newKunden);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("kunden")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Kunden $kunden): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kunden', $kunden);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Kunden $kunden)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenRepository->update($kunden);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Kunden $kunden)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenRepository->remove($kunden);
        $this->redirect('list');
    }
}
