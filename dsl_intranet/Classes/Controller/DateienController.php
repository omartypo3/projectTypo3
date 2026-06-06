<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;
use DslFactory\DslIntranet\Utility\SettingsUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect;
use DslFactory\DslIntranet\Utility\FileUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024
 */

/**
 * DateienController
 */
class DateienController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * dateienRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\DateienRepository
     */
    protected $dateienRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\DateienRepository $dateienRepository
     */
    public function injectDateienRepository(\DslFactory\DslIntranet\Domain\Repository\DateienRepository $dateienRepository)
    {
        $this->dateienRepository = $dateienRepository;
    }

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
        $this->protokollePendingRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokollePendingRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->frontendUserRepository  = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
        $this->protokolleRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $this->agenturvertraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AgenturvertraegeRepository');
    }



	/**
     * initProtokollPending
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     * @return \DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending
     */
    private function initProtokollPending($protokolle)
    {
        $newProtokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($protokolle->getPending()) {
            foreach ($protokolle->getPending() as $protokollePending) {

				if ($protokollePending->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
					$protokollePending->getMitarbeiter()->_loadRealInstance();
				}

                if ($protokollePending->getPending() && $protokollePending->getMitarbeiter() == $mitarbeiter) {
                    $protokollePending->setTimestamp(new \DateTime());
                    $this->protokollePendingRepository->update($protokollePending);
                    unset($newProtokollePending);
                    break;
                }
            }
        }
        if ($newProtokollePending) {
            $newProtokollePending->setMitarbeiter($mitarbeiter);
            $newProtokollePending->setPending(true);
            $newProtokollePending->setTimestamp(new \DateTime());
            $this->protokollePendingRepository->add($newProtokollePending);
            $protokolle->addPending($newProtokollePending);
            if ($protokolle->getUid()) {
                $this->protokolleRepository->update($protokolle);
            }
            $protokollePending = $newProtokollePending;
        }
        return $protokollePending;
    }


    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {

        if ($this->request->hasArgument('switch')) {
            switch ($this->request->getArgument('switch')) {

                case 'toggleSichtbarkeitDateien':    if ($this->request->hasArgument('uid')) {
                        if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                            $datei->toggleSichtbarkeit();
                            $this->dateienRepository->update($datei);
                            //echo $datei->getSichtbarkeit();
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            echo json_encode(array('uid' => $datei->getUid(), 'data' => $this->listJSONDataTableRow($datei)));
                            die;
                            break;
                        }
                    }
                    break;
                case 'dateienList':    //$kunde = $this->kundenRepository->findByName("pro haar");
                    //echo $kunde->getUid();
                    $retarray = $this->listJSONDataTable();
                    echo json_encode($retarray);
                    die;
                    break;
                case 'delete':    if ($this->request->hasArgument('uid')) {
                        if ($auftraege = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                            $this->deleteAction($auftraege);
                            return true;
                        }
                    }
                    break;
                case 'filterSet':    $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    if ($this->request->hasArgument('settings')) {
                        $stringRepresentation= json_encode($this->request->getArgument('settings'));
                        $benutzer->setSettingsDateien($stringRepresentation);
                    } else {
                        $benutzer->setSettingsDateien('');
                    }
                    $this->frontendUserRepository->update($benutzer);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('found' => count($this->dateienRepository->findByFilter($benutzer->getSettingsDateien())), 'from' => count($this->dateienRepository->findByFilter(array()))));
                    die;
                    break;
                case 'update':    $dateien = $this->dateienRepository->findByUid($this->request->getArgument('dateien'));
                    $dateien = $this->updateDateiFromRequest($dateien);
                    $this->dateienRepository->update($dateien);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //$persistenceManager->persistAll();
                    echo json_encode(array('uid' => $dateien->getUid(), 'data' => $this->listJSONDataTableRow($dateien)));
                    die;
                    break;
                case 'updateDateiTitel':
					if ($this->request->hasArgument('uid')) {
                            $datei = $this->dateienRepository->findByUid((int)$this->request->getArgument('uid'));
                            $datei->setTitel($this->request->getArgument('titel'));
                            $this->dateienRepository->update($datei);
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            echo json_encode(array('uid' => $datei->getUid()));

                    }
                    die;
                    break;
                case 'create':
				    $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
                    $dateien->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $dateien = $this->updateDateiFromRequest($dateien);

					if ($dateien->getType() == 20 || $dateien->getType() == 30) {
                        //achtung existiert noch im AuftraegeController
                        $tmpArr = explode('_', $dateien->getDateiname());
                        if (count($tmpArr) > 1) {
                            //rechnung oder angebot
                            if (strlen((string) intval($tmpArr[0])) == 8) {
                                //rechnung
                                //$newDateien->setType(30);
                                $dateien->setTempRechnungsNummer($tmpArr[0]);
                                //strlen prüfung wegen dateikopien welche dann dem auftrag 1 oder 2 oder x ... zugeordnet werden
                                if ($auftragsNummer = intval($tmpArr[2])) {
                                    if ($auftragsNummer > 100) {
                                        if ($auftrag = $this->auftraegeRepository->findByUid($auftragsNummer)) {
                                            $auftrag->addDateien($dateien);
                                            $this->auftraegeRepository->update($auftrag);
                                        }
                                    }
                                }
                            } elseif (strlen((string) intval($tmpArr[0])) == 4) {
                                //angebot
                                $dateien->setTempRechnungsNummer($tmpArr[0]);
                            }
                        }
                    }
                    $this->dateienRepository->add($dateien);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //echo json_encode(array('newUid' => $dateien->getUid(),'data' => $this->listJSONDataTableRow($dateien)));
                    echo 1;
                    die;
                    //$newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege $this->request->getArgument('titel');
                    break;
                case 'edit':    $dateien = $this->dateienRepository->findByUid($this->request->getArgument('dateien'));
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Dateien/Edit.html', $this->request->getControllerExtensionName());
                    //$kunden->setUsername($kunden->getNummer());
                    $dbView->assign('dateien', $dateien);
                    $dbView->assign('editForm', true);
                    $kundens = $this->kundenRepository->getActive();
                    $dbView->assign('kundens', $kundens);
                    $dbView->assign('types', $this->getTypes());
                    //$dbView->assignMultiple(array('auftraege' => $auftraege));
                    echo $dbView->render();
                    die;
                    break;
                case 'sendKundeninfoMailDatei':    if ($this->request->hasArgument('uid')) {
                        if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                            //neu
                            $datei->setSichtbarkeit(TRUE);
                            $this->dateienRepository->update($datei);
                            //echo "puid:";
                            if (!$datei->getProtokoll()) {
                                //echo "kein protokoll da!!";
                                $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                                $protokolle->setPid((int)$this->settings['protokollePid']);
                                if ($datei->getAuftraege()) {
                                    if ($datei->getAuftraege() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                                        $datei->getAuftraege()->_loadRealInstance();
                                    }
                                    $protokolle->setAuftrag($datei->getAuftraege());
                                }
                                $protokolle->setDatei($datei);
                                $protokolle->setAktion(90);
                                $protokolle->setZeitpunkt(new \DateTime());
                                $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                                $this->protokolleRepository->add($protokolle);
                                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            }
                            //echo $datei->getProtokoll()->getUid();
                            //echo "danach";
                            $newProtokollePending = $this->initProtokollPending($datei->getProtokoll());
                            //$this->protokolleRepository->update($datei->getProtokoll());
                            //echo "b";
                            //updateprotokolle?!
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            echo json_encode(array('protokollePendingUid' => $newProtokollePending ? $newProtokollePending->getUid() : false, 'data' => $this->listJSONDataTableRow($datei)));
                            die;
                        }
                    }
                    die;
                    break;
                /*Zeiteintragshandling*/
                case 'deleteDatei':    if ($this->request->hasArgument('uid')) {
                        //	die;
                        if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                            if ($datei->getAuftraege()) {
                                $auftrag = $datei->getAuftraege();
                                $auftrag->removeDateien($datei);
                                $this->auftraegeRepository->update($auftrag);
                            }
                            //$datei->getDatei()->detach();
                            $this->dateienRepository->remove($datei);
                            $datei->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->deleteFile($datei->getDatei()->getOriginalResource()->getOriginalFile());
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            die;
                        }
                        die;
                    }
                    break;
                case 'setOpenAuftrag':    if ($auftrag = $this->auftraegeRepository->findByUid($this->request->getArgument('auftrag'))) {
                        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                        $mitarbeiter->addOffeneAuftraege($auftrag);
                        $mitarbeiter->setGeoeffneterAuftrag($auftrag->getUid());
                        $this->mitarbeiterRepository->update($mitarbeiter);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }
                    die;
                    break;
            }
        }
        //header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
       // return $this->htmlResponse();
    }

	 /**
     * @param $datei
     */
    private function updateDateiFromRequest($datei)
    {
		$id = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
		$datei->setIduser($id->getUid());
		
        if ($this->request->hasArgument('newDateien')) {
            $fileUtility = GeneralUtility::makeInstance(FileUtility::class,
                GeneralUtility::makeInstance(ResourceFactory::class),
                GeneralUtility::makeInstance(FileDeletionAspect::class)
            );

            $uploadSettings = SettingsUtility::init()->getSettingFor('auftraegeAngeboteRechnungen');
            $indexedFiles = $fileUtility->indexImages(
                $this->request->getArgument('newDateien')['datei'],
                $uploadSettings['falStorageSubDir'],
                true
            );

            if (!empty($indexedFiles)) {
                $falFile = $indexedFiles[0];

                // Get or create parent UID
                $foreignUid = $datei->getUid();
								
                if (empty($foreignUid)) {
                    $this->dateienRepository->add($datei);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $foreignUid = $datei->getUid();
                }

                $fileReference = $fileUtility->createFileReferenceFromFalFileObject(
                    $falFile,
                    $datei->getPid() ?: 1, // Storage PID
                    $foreignUid,
                    'tx_dslintranet_domain_model_dateien', // Your table
                    'datei'                  // Your field
                );
				
								

                $datei->setDatei($fileReference);
				//\TYPO3\CMS\Core\Utility\DebugUtility::debug($datei);
                $this->dateienRepository->update($datei);
				$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

            }
        }
        if ($this->request->hasArgument('kunde')) {
            if (is_array($this->request->getArgument('kunde'))) {
                foreach ($this->request->getArgument('kunde') as $kunde) {
                    $kunden = $this->kundenRepository->findByUid($kunde);
                    $kunden->addDateien($datei);
                    $this->kundenRepository->update($kunden);
                    $datei->setKunden($kunden);
                    //nur temporär
                    $datei->setTempKundenName($auftrag->getKunde()->getName());
                    $datei->setTempKundenNummer($auftrag->getKunde()->getNummer());
                }
            } else {
                $kunden = $this->kundenRepository->findByUid($this->request->getArgument('kunde'));
                $kunden->addDateien($datei);
                $this->kundenRepository->update($kunden);
                $datei->setKunden($kunden);
                //nur temporär
                $datei->setTempKundenName($kunden->getName());
                $datei->setTempKundenNummer($kunden->getNummer());
            }
        }

        if ($this->request->hasArgument('titel')) {
            $datei->setTitel($this->request->getArgument('titel'));
        }


        if ($this->request->hasArgument('sichtbarkeit')) {
			if($this->request->getArgument('sichtbarkeit') == '1'){
				$datei->setSichtbarkeit(TRUE);
			}else{
				$datei->setSichtbarkeit(FALSE);
			}

        }

        if ($this->request->hasArgument('type')) {
            if (is_array($this->request->getArgument('type'))) {
                foreach ($this->request->getArgument('type') as $type) {
                    $datei->setType((int)$type);
                }
            } else {
					$datei->setType((int)$this->request->getArgument('type'));
				
            }

        }else{
			$datei->setType(100);
		}
		
		





        return $datei;
    }

    /**
     * action checkFile
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function checkFileAction(): \Psr\Http\Message\ResponseInterface
    {
		$uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('auftraegeAngeboteRechnungen');
        $filename = $this->request->getArgument('fileName');
        $identifier = $uploadSettings['falStorage'] . ':/' . trim($uploadSettings['falStorageSubDir'], '/') . '/' . $this->request->getArgument('fileName');
        $folderIdentifier = $uploadSettings['falStorage'] . ':/' . trim($uploadSettings['falStorageSubDir'], '/') . '/';
        $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
        $storage = $resourceFactory->getStorageObject($uploadSettings['falStorage']);
        $folder = $storage->getFolder(trim($uploadSettings['falStorageSubDir'], '/') . '/');
        $debug = '';
        $beginUpload = true;
        if ($folder->hasFile($filename)) {
            $file = $resourceFactory->getFileObjectFromCombinedIdentifier($identifier);
            //$fileObjects = $this->getDatabaseConnection()->exec_SELECTgetRows('uid, tablenames, fieldname, uid_foreign', 'sys_file_reference', ' uid_local=' . (int) $file->getUid(), '', 'sorting_foreign', '', 'uid');

			$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
			$queryBuilder = $connectionPool->getQueryBuilderForTable('sys_file_reference');

			$fileObjects = $queryBuilder
				->select('uid', 'tablenames', 'fieldname', 'uid_foreign')
				->from('sys_file_reference')
				->where(
					$queryBuilder->expr()->eq('uid_local', $queryBuilder->createNamedParameter((int)$file->getUid(), \PDO::PARAM_INT))
				)
				->orderBy('sorting_foreign')
				->executeQuery()
				->fetchAllAssociative();
			//print_r($fileObjects);die;
            foreach ($fileObjects as $value) {
                if ($value['tablenames'] == 'tx_dslintranet_domain_model_dateien' && $value['fieldname'] == 'datei') {
                    //$value["uid_foreign"];
                    $datei = $this->dateienRepository->findByUid($value['uid_foreign']);
                    //$this->dateienRepository->remove($datei);
                    $this->view->assign('dateien', $datei);
                    break;
                }
            }
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            $debug = $file->getUid();
            $beginUpload = false;
        } else {
            $beginUpload = true;
        }


		$invalid = false;
		if($this->request->hasArgument('agenturvertrag')){
			if($agenturvertrag = $this->agenturvertraegeRepository->findByUid($this->request->getArgument('agenturvertrag'))){
				$fileArr = explode(".",$filename);
				//prüfung dateiname gültigkeit
				$tmpArr = explode('_', $fileArr[0]);
				if (count($tmpArr) > 1) {
					if (strlen($tmpArr[0]) == 8 && strlen($tmpArr[1]) == 4) {
						if ($tmpArr[1] == $agenturvertrag->getKunde()->getNummer()) {

						} else {
							$invalid = 'Kundennummer im Dateiname ('.$filename.') passt nicht.';
						}
					} else {
						$invalid = 'Der Dateiname ('.$filename.') muß mit der Rechnungsnummer gefolgt von der Kundennummer beginnen. (xxxxxxxx_xxxx.pdf)';
					}
				} else {
					$invalid = 'Der Dateiname ('.$filename.') muß mit der Rechnungsnummer gefolgt von der Kundennummer beginnen. (xxxxxxxx_xxxx.pdf)';
				}

				if(!is_numeric(str_replace('_','',str_replace(array(',','.','-'),'A',$fileArr[0])))) $invalid = 'Es sind nur Zahlen im Dateiname erlaubt. (xxxxxxxx_xxxx.pdf)';
				/**/
				//prüfung ende
				//$invalid.= ":".$agenturvertrag->getKunde()->getUid().":".$agenturvertrag->getKunde()->getNummer().":filename:".$filename.":blaaa::".$bla;
			}
		}

        $this->view->assign('returnString', json_encode(array('fileMD5' => $this->request->getArgument('fileMD5'), 'fileName' => $filename, 'beginUpload' => $beginUpload, 'debug' => $debug, 'identifier' => $identifier, 'invalid'=>$invalid)));

        return $this->htmlResponse();
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
		$newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $this->view->assign('newDateien', $newDateien);
        \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceDateienTempFields();
        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        $this->view->assign('typens', $this->getTypes());
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsDateien();
        $this->view->assign('settings', $settings);
        //print_r($settings);
        //die;
        $dateiens = $this->dateienRepository->findByFilter($settings);
        $this->view->assign('dateiens', $dateiens);
        $dateiensAnzahl = count($this->dateienRepository->findByFilter(array()));
        //echo "z";
        $this->view->assign('dateiensAnzahl', $dateiensAnzahl);
        return $this->htmlResponse();
    }



	private function getTypes()
    {
        $types = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['type']['config']['items'] as $type) {
            //vorbereitet durch kunde angelegt status rauslassen
            if ($type[1] == 20 || $type[1] == 30 || $type[1] == 35 || $type[1] == 60 || $type[1] == 70 || $type[1] == 80 || $type[1] == 90 || $type[1] == 100) {
                // || $type[1] == 50 auftragsdomumente rausklammern
                $types[$type[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_dateien.kundentype.' . $type[1], 'dsl_intranet',[],'de');
            }
        }
        return $types;
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Dateien $dateien): \Psr\Http\Message\ResponseInterface
    {

        $this->view->assign('dateien', $dateien);
        return $this->htmlResponse();
    }

	 /**
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     * @param $kunde
     */
    protected function listJSONDataTableRow($datei, $kunde = false)
    {
        //$dateien = $this->dateienRepository->findByUid($datei->getUid());
        if ($kunde) {
            $template = 'KundenDateien/ListJSONDataTableRow.html';
        } else {
            $template = 'Dateien/ListJSONDataTableRow.html';
        }
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, $this->request->getControllerExtensionName());
        $dbView->assign('dateien', $datei);
        //$dbView->assign('dateien', $dateiKopie);
        return explode('<--break-->', $dbView->render());
    }

    /**
     * @param $kunde
     */
    protected function listJSONDataTable($kunde = false)
    {
        //\DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceDateienTempFields();
        $data = array();
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        //$user = $GLOBALS['TSFE']->fe_user->user;
        if ($kunde) {
            $template = 'KundenDateien/ListJSONDataTable.html';
        } else {
            $template = 'Dateien/ListJSONDataTable.html';
        }



        $settings = $benutzer->getSettingsDateien();
		
		
		

        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, $this->request->getControllerExtensionName());
        if (isset($_GET['start'])) {
            $start = intval($_GET['start']);
        } else {
            $start = 0;
        }
        if (isset($_GET['length'])) {
            $length = intval($_GET['length']);
        } else {
            $length = 10;
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = array();
        }
        if (isset($_GET['search'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = false;
        }
        // echo $search;
        //	die;
        $dateienAnzahlFiltered = count($this->dateienRepository->findByFilter($settings, false, false, array(), false, $kunde));
        $dateienAnzahl = $this->dateienRepository->findByFilter($settings, false, false, array(), $search, $kunde);

		/*\TYPO3\CMS\Core\Utility\DebugUtility::debug($dateienAnzahlFiltered);
		die();*/
		if ($dateienAnzahlFiltered) {
            //wenn überhaupt aufträge vorhanden sind
            $sortInRepository = true;
            if ($order[0]['column'] == 3) {

            }
            if ($sortInRepository) {
                $dateiens = $this->dateienRepository->findByFilter($settings, $start, $length, $order, $search, $kunde);
		//die();
               // \TYPO3\CMS\Core\Utility\DebugUtility::debug($dateiens);
				foreach ($dateiens as $dateien) {
                    $dbView->assign('dateien', $dateien);
                    $data[] = explode('<--break-->', $dbView->render());
                }

            }
        }
        $retarray = array(
            'draw' => $_GET['draw'],
            'recordsTotal' => $dateienAnzahlFiltered,
            'recordsFiltered' => count($dateienAnzahl),
            'data' => $data
        );


        return $retarray;
    }


    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
		$newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        //$newKunden = new
        $newDateien->setSichtbarkeit(false);
        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        $this->view->assign('dateien', $newDateien);
        $this->view->assign('editForm', false);
        $this->view->assign('types', $this->getTypes());
        return $this->htmlResponse();
    }




    /**
     * action create
     *
	 * @return void
     */
    public function createAction()
    {
		$newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
		//
		$id = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
		$newDateien->setIduser($id->getUid());

        $newDateien = $this->updateDateiFromRequest($newDateien);
		
		$newDateien->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
			
        /*$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->dateienRepository->add($newDateien);
        $this->redirect('list');*/

		//echo "bla1";die;
       // $newDateien->setDefaultType();
        //achtung existiert noch im AuftraegeController
        if ($this->request->hasArgument('agenturvertrag')) {
            $agenturvertrag = $this->agenturvertraegeRepository->findByUid($this->request->getArgument('agenturvertrag'));
            $agenturvertrag->addDateien($newDateien);
            $newDateien->setType(35);
            $newDateien->setSichtbarkeit(true);
            $this->agenturvertraegeRepository->update($agenturvertrag);
            if ($kunden = $this->kundenRepository->findByUid($agenturvertrag->getKunde()->getUid())) {
                //echo "juihu"	;
                $kunden->addDateien($newDateien);
                $this->kundenRepository->update($kunden);
            }


			$tmpArr = explode('_', $newDateien->getDateiNameOhneErweiterung());

			/*prüfung*/
			/*
            if ($tmpArr[0]) {
                $invalid = false;
            }
            if (count($tmpArr) > 1) {
                if (strlen($tmpArr[0]) == 8 && strlen($tmpArr[1]) == 4) {
                    if ($tmpArr[1] == $auftrag->getKunde()->getNummer()) {

                    } else {
                        $invalid = 'Kundennummer im Dateiname passt nicht.';
                    }
                } else {
                    $invalid = 'Der Dateiname muß mit der Rechnungsnummer gefolgt von der Kundennummer beginnen. (xxxxxxxx_xxxx.pdf)';
                }
            } else {
                $invalid = 'Der Dateiname muß mit der Rechnungsnummer gefolgt von der Kundennummer beginnen. (xxxxxxxx_xxxx.pdf)';
            }
            if ($invalid) {
                echo $invalid;
                $newDateien->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->deleteFile($newDateien->getDatei()->getOriginalResource()->getOriginalFile());
                die;
            }
			*/


            $tmpArr = explode('_', $newDateien->getDateiNameOhneErweiterung());
            //getTitel
            if (count($tmpArr) > 1) {
                //rechnung oder angebot
                if ((string) intval(strlen($tmpArr[1])) == 4) {
                    if ((string) intval(strlen($tmpArr[0])) == 4) {
                        //evtl angebot
                        $newDateien->setTempRechnungsNummer($tmpArr[0]);
                    } elseif (strlen((string) intval($tmpArr[0])) == 8) {
                        //rechnung
                        $newDateien->setTempRechnungsNummer($tmpArr[0]);
                    }
                }
            }
        } else {
            $tmpArr = explode('_', $newDateien->getDateiNameOhneErweiterung());
            //getTitel
            if (count($tmpArr) > 1) {
                //rechnung oder angebot
                if ((string) intval(strlen($tmpArr[1])) == 4) {
                    if ($kunden = $this->kundenRepository->findByNummer($tmpArr[1])) {
                        $kunden->addDateien($newDateien);
                        $this->kundenRepository->update($kunden);
                    }
                    if ((string) intval(strlen($tmpArr[0])) == 4) {
                        //evtl angebot
                        $newDateien->setType(20);
                        $newDateien->setSichtbarkeit(true);
                        $newDateien->setTempRechnungsNummer($tmpArr[0]);
                    } elseif (strlen((string) intval($tmpArr[0])) == 8) {
                        //rechnung
                        $newDateien->setType(30);
                        $newDateien->setSichtbarkeit(true);
                        $newDateien->setTempRechnungsNummer($tmpArr[0]);
                        //strlen prüfung wegen dateikopien welche dann dem auftrag 1 oder 2 oder x ... zugeordnet werden
                        if ($auftragsNummer == intval($tmpArr[2])) {
                            if ($auftragsNummer > 100) {
                                if ($auftrag = $this->auftraegeRepository->findByUid($auftragsNummer)) {
                                    $auftrag->addDateien($newDateien);
                                    $this->auftraegeRepository->update($auftrag);
                                }
                            }
                        }
                    }
                }
            }
        }
		
		/*\TYPO3\CMS\Core\Utility\DebugUtility::debug(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
		die();*/
		
        if ($kunden) {
            $newDateien->setTempKundenName($kunden->getName());
            $newDateien->setTempKundenNummer($kunden->getNummer());
        }
        if ($kunden) {
            $newDateien->setKunden($kunden);
        }
       // $this->dateienRepository->add($newDateien);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
        $protokolle->setPid((int)$this->settings['protokollePid']);
        if ($auftrag) {
            $protokolle->setAuftrag($auftrag);
        }
		if ($agenturvertrag) {
            $protokolle->setAgenturvertrag($agenturvertrag);
        }
        $protokolle->setDatei($newDateien);
        $protokolle->setAktion(90);
        $protokolle->setZeitpunkt(new \DateTime());
        $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        $this->protokolleRepository->add($protokolle);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        if ($kunden || $auftrag) {
            $mailSettings = $protokolle->getMailSettings();
            //echo $mailSettings["template"];die;
            if (!$mailSettings['mailInfoDenied'] && $mailSettings['template'] && $newDateien->getSichtbarkeit()) {
                $newProtokollePending = $this->initProtokollPending($protokolle);
                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            }
        }
        echo json_encode(array('newDateienUid' => $newDateien->getUid(), 'protokollePendingUid' => $newProtokollePending ? $newProtokollePending->getUid() : false));

    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("dateien")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Dateien $dateien): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('dateien', $dateien);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Dateien $dateien)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->dateienRepository->update($dateien);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Dateien $dateien)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->dateienRepository->remove($dateien);
        $this->redirect('list');
    }
}
