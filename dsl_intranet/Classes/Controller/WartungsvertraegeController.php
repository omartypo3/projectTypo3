<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * WartungsvertraegeController
 */
class WartungsvertraegeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * wartungsvertraegeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRepository
     */
    protected $wartungsvertraegeRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRepository $wartungsvertraegeRepository
     */
    public function injectWartungsvertraegeRepository(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRepository $wartungsvertraegeRepository)
    {
        $this->wartungsvertraegeRepository = $wartungsvertraegeRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->protokolleRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
        $this->zeiteintraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ZeiteintraegeRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->wartungsvertraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
        $this->wartungsvertraegeZeitraeumeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeZeitraeumeRepository');
        $this->wartungsvertraegeRechnungenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRechnungenRepository');
        $this->wartungsvertraegeOptionenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeOptionenRepository');
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
                case 'toggleSichtbarkeit':    if ($this->request->hasArgument('uid')) {
                    if ($wartungsvertraege = $this->wartungsvertraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        $wartungsvertraege->toggleSichtbarkeit();
                        $this->wartungsvertraegeRepository->update($wartungsvertraege);
                        echo $wartungsvertraege->getSichtbarkeit();
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        die;
                        break;
                    }
                }
                    break;
                case 'delete':    if ($this->request->hasArgument('uid')) {
                    if ($wartungsvertraege = $this->wartungsvertraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($wartungsvertraege);
                        /*$dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Wartungsvertraege/List.html', $this->request->getControllerExtensionName());
                          $dbView->assign('wartungsvertraeges', $this->wartungsvertraegeRepository->findAll());
                          echo $dbView->render();*/

                        die;
                        return true;
                    }
                }
                    break;
                case 'update':    $wartungsvertraege = $this->wartungsvertraegeRepository->findByUid($this->request->getArgument('wartungsvertraege'));
                    $wartungsvertraege = $this->updateWartungsvertragFromRequest($wartungsvertraege);
                    $this->wartungsvertraegeRepository->update($wartungsvertraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('uid' => $wartungsvertraege->getUid()));
                    //, 'contentShow' => $this->showAction($auftraege)
                    //, 'contentList' => $this->getPartialsListRow($auftraege)
                    die;
                    break;
                case 'create':    $wartungsvertraege = new \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege();
                    $wartungsvertraege->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $wartungsvertraege = $this->updateWartungsvertragFromRequest($wartungsvertraege);
                    $this->wartungsvertraegeRepository->add($wartungsvertraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeNewZeitraeume();
                    \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeNewRechnungen();
                    \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeRechnungenStatus();
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Wartungsvertraege/ListItemAjax.html', $this->request->getControllerExtensionName());
                    $dbView->assign('wartungsvertraege', $wartungsvertraege);
                    //$dbView->assign('wartungsvertraeges', $this->wartungsvertraegeRepository->findAll());
                    echo json_encode(array('newUid' => $wartungsvertraege->getUid(), 'content' => $dbView->render()));
                    //$this->getPartialsListRow($auftraege)
                    die;
                    //$newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege $this->request->getArgument('titel');
                    break;
                case 'show':    if (!$this->request->hasArgument('uid')) {
                    break;
                }
                    //					echo asd":".22""
                    $uid = $this->request->getArgument('uid');
                    $tmpArr = explode('-', $uid);
                    if (count($tmpArr) > 1) {
                        $uid = $tmpArr[count($tmpArr) - 1];
                    }
                    $wartungsvertraege = $this->wartungsvertraegeRepository->findByUid($uid);
                    //echo "bla3:".$auftraege->getUid();
                    //			echo 99188;die;
                    //					$content = $this->showAction($auftraege);
                    echo $this->showAction($wartungsvertraege);
                    die;
                    break;
                case 'deleteZeiteintraege':    if ($this->request->hasArgument('uid')) {
                    if ($zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        //        $this->deleteAction($zeiteintraege);
                        $this->zeiteintraegeRepository->remove($zeiteintraege);
                        //$this->redirect('list');
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        return true;
                    }
                }
                    break;
                case 'updateZeiteintraege':    $zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('zeiteintraege'));
                    $zeiteintraege = $this->updateZeiteintragFromRequest($zeiteintraege);
                    $zeiteintraege->setZeitnahme(0);
                    $this->zeiteintraegeRepository->update($zeiteintraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $zeitraum = $this->wartungsvertraegeZeitraeumeRepository->findByZeiteintraege($zeiteintraege);
                    echo json_encode(array('wartungsvertraegeUid' => $zeitraum->getWartungsvertrag()->getUid(), 'uid' => $zeiteintraege->getUid()));
                    die;
                    break;
                case 'createZeiteintraege':    if ($this->request->hasArgument('wartungsvertraege')) {
                    $newZeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
                    $newZeiteintraege->setPid((int)$this->settings['wartungsvertraegeZeiteintraegePid']);
                    $wartungsvertraege = $this->wartungsvertraegeRepository->findByUid((int)$this->request->getArgument('wartungsvertraege'));
                   //\TYPO3\CMS\Core\Utility\DebugUtility::debug($this->request->getArguments());
				   //$wartungsvertraege->addZeiten($newZeiteintraege);
                    //Ersteller für den Zeiteintrag ermitteln
                    $newZeiteintraege->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $newZeiteintraege = $this->updateZeiteintragFromRequest($newZeiteintraege);
					
                    $this->zeiteintraegeRepository->add($newZeiteintraege);
					$wartungsvertraegezeiteintraege = $wartungsvertraege->getZeitraeume()[0];
					
					$wartungsvertraegezeiteintraege->addZeiten($newZeiteintraege);
					
                    $this->wartungsvertraegeZeitraeumeRepository->update($wartungsvertraegezeiteintraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('wartungsvertraegeUid' => $wartungsvertraege->getUid(), 'test' => 'bla' . $newZeiteintraege->getUid()));
                    //, 'content' => $this->getPartialsList($auftraege)
                    die;
                }
                    echo json_encode(array('content___' => print_r($this->request->getArguments(), 1)));
                    die;
                    break;
                case 'checkRechnung':    if ($this->request->hasArgument('uid')) {
                    if ($rechnung = $this->wartungsvertraegeRechnungenRepository->findByUid($this->request->getArgument('uid'))) {
                        //        $this->deleteAction($zeiteintraege);
                        $rechnung->setStatus(30);
                        $rechnung->setPreis($rechnung->getPreisBerechnet());
                        $this->wartungsvertraegeRechnungenRepository->update($rechnung);
                        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                        $protokolle->setPid((int)$this->settings['protokollePid']);
                        $protokolle->setAktion(60);
                        $protokolle->setNotizSystem('wartungsvertrag rechnung auf berechnet gesetzt' . $rechnung->getUid());
                        $protokolle->setZeitpunkt(new \DateTime());
                        $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                        $this->protokolleRepository->add($protokolle);
                        //$this->redirect('list');
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeRechnungenMehraufwandZeitraeumeStatus();
                        echo json_encode(array('wartungsvertraegeUid' => $rechnung->getZeitraum()->getWartungsvertrag()->getUid(), 'uid' => $rechnung->getUid()));
                        die;
                    }
                }
                    break;
                case 'checkZeitraum':    if ($this->request->hasArgument('uid')) {
                    if ($rechnung = $this->wartungsvertraegeRechnungenRepository->findByUid($this->request->getArgument('uid'))) {
                        //        $this->deleteAction($zeiteintraege);
                        $zeitraum = $rechnung->getZeitraum();
                        $rechnung->setPreisMehraufwand($zeitraum->getMehraufwandPreis());
                        $this->wartungsvertraegeRechnungenRepository->update($rechnung);
                        //$zeitraum = $rechnung->getZeitraum();
                        $zeitraum->setStatus(30);
                        $this->wartungsvertraegeZeitraeumeRepository->update($zeitraum);
                        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                        $protokolle->setPid((int)$this->settings['protokollePid']);
                        $protokolle->setAktion(70);
                        $protokolle->setNotizSystem('wartungsvertrag rechnung zeitraum nachberechnung Mehraufwand auf berechnet gesetzt' . $zeitraum->getUid());
                        $protokolle->setZeitpunkt(new \DateTime());
                        $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                        $this->protokolleRepository->add($protokolle);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        echo json_encode(array('wartungsvertraegeUid' => $zeitraum->getWartungsvertrag()->getUid(), 'uid' => $zeitraum->getUid()));
                        die;
                    }
                }
                    break;
            }
        }
        //header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
        //return $this->htmlResponse();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    private function updateWartungsvertragFromRequest($wartungsvertrag)
    {
        if ($this->request->hasArgument('kunde')) {
            if (is_array($this->request->getArgument('kunde'))) {
                foreach ($this->request->getArgument('kunde') as $kunde) {
                    $wartungsvertrag->setKunde($this->kundenRepository->findByUid($kunde));
                }
            } else {
                $wartungsvertrag->setKunde($this->kundenRepository->findByUid($this->request->getArgument('kunde')));
            }
        }
        if ($this->request->hasArgument('titel')) {
            $wartungsvertrag->setTitel($this->request->getArgument('titel'));
        }
        if ($this->request->hasArgument('beschreibung')) {
            $wartungsvertrag->setBeschreibung($this->request->getArgument('beschreibung'));
        }
        if ($this->request->hasArgument('sichtbarkeit')) {
			$sichtbarkeit = ($this->request->getArgument('sichtbarkeit') == '1') ? TRUE : FALSE; 
            $wartungsvertrag->setSichtbarkeit($sichtbarkeit);
        }
        if ($this->request->hasArgument('gekuendigt')) {
			$gekuendigt = ($this->request->getArgument('gekuendigt') == '1') ? TRUE : FALSE; 

            $wartungsvertrag->setGekuendigt($gekuendigt);
        }
        if ($this->request->hasArgument('laufzeit')) {
            if (is_array($this->request->getArgument('laufzeit'))) {
                foreach ($this->request->getArgument('laufzeit') as $status) {
                    $wartungsvertrag->setLaufzeit($status);
                }
            } else {
                $wartungsvertrag->setLaufzeit((int)$this->request->getArgument('laufzeit'));
            }
        }
        if ($this->request->hasArgument('reIntervall')) {
            if (is_array($this->request->getArgument('reIntervall'))) {
                foreach ($this->request->getArgument('reIntervall') as $status) {
                    $wartungsvertrag->setReIntervall($status);
                }
            } else {
                $wartungsvertrag->setReIntervall((int)$this->request->getArgument('reIntervall'));
            }
        }
        if ($this->request->hasArgument('kuendigungsFrist')) {
            if (is_array($this->request->getArgument('kuendigungsFrist'))) {
                foreach ($this->request->getArgument('kuendigungsFrist') as $status) {
                    $wartungsvertrag->setKuendigungsFrist($status);
                }
            } else {
                $wartungsvertrag->setKuendigungsFrist((int)$this->request->getArgument('kuendigungsFrist'));
            }
        }
        if ($this->request->hasArgument('vertragsbegin')) {
            $wartungsvertrag->setVertragsbegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('vertragsbegin'))));
        }
        if ($this->request->hasArgument('bezahltbis')) {
            $wartungsvertrag->setBezahltbis(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('bezahltbis'))));
        }
        if ($this->request->hasArgument('stundenProJahr')) {
            $wartungsvertrag->setStundenProJahr((int)$this->request->getArgument('stundenProJahr'));
        }

        if ($this->request->hasArgument('preisMonatlich')) {
            $wartungsvertrag->setPreisMonatlich((float)$this->request->getArgument('preisMonatlich'));
        }
        if ($this->request->hasArgument('preisMehraufwandStunde')) {
            $wartungsvertrag->setPreisMehraufwandStunde((float)$this->request->getArgument('preisMehraufwandStunde'));
        }
        if ($this->request->hasArgument('optionen')) {
            $wartungsvertrag->setOptionen($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            if (is_array($this->request->getArgument('optionen'))) {
                foreach ($this->request->getArgument('optionen') as $option) {
                    $wartungsvertrag->addOptionen($this->wartungsvertraegeOptionenRepository->findByUid($option));
                }
            }
        }
        return $wartungsvertrag;
    }

    /**
     * action import
     *
     * @return void
     */
    public function importAction()
    {
        $file = 'H:/Shares/dsl_data/projekte/web/dsl_intranet/export_wartung.json';
        $file = '/var/www/kd/dsl-factory.de/intern/export_wartung.json';
        $resultarray = array();
        $resultarray['datei'] = $file;
        $resultarray['dateidatum'] = date('d.m.Y H:i:s', filemtime($file)) . ' Uhr';
        $resultarray['dateigröße'] = filesize($file) . ' Bytes';
        $importArr = json_decode(file_get_contents($file));
        $importUsers = $importArr->fe_users;
        $importWartungs = $importArr->dsl_wartung;
        $importZeiten = $importArr->dsl_zeiten;
        $counter = 0;
        foreach ($importWartungs->items as $importWartung) {
            $counter++;
            $resultarray[] = $importWartung[$importWartungs->index->dsl_wartung_title];
            if ($wartung = $this->wartungsvertraegeRepository->findByOldid($importWartung[$importWartungs->index->dsl_wartung_id])) {
                $wartung = $this->updateWartungsvertraegeImport($wartung, $importWartung, $importWartungs->index, $importUsers);
                $this->wartungsvertraegeRepository->update($wartung);
            } else {
                $wartung = new \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege();
                $wartung = $this->updateWartungsvertraegeImport($wartung, $importWartung, $importWartungs->index, $importUsers);
                $this->wartungsvertraegeRepository->add($wartung);
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //zeiten eintragen
        $counter = 0;
        foreach ($importZeiten->items as $importZeiteintrag) {
            if ($importZeiteintrag[$importZeiten->index->dsl_zeiten_dsl_wartung_id]) {
                $counter++;
                $resultarray[] = $importZeiteintrag[$importZeiten->index->dsl_zeiten_text];
                if ($zeiteintraege = $this->zeiteintraegeRepository->findByOldid($importZeiteintrag[$importZeiten->index->dsl_zeiten_id])) {
                    $zeiteintraege = $this->updateZeiteintraegeImport($zeiteintraege, $importZeiteintrag, $importZeiten->index, $importUsers);
                    $this->zeiteintraegeRepository->update($zeiteintraege);
                } else {
                    $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
                    $zeiteintraege->setPid((int)$this->settings['wartungsvertraegeZeiteintraegePid']);
                    $zeiteintraege = $this->updateZeiteintraegeImport($zeiteintraege, $importZeiteintrag, $importZeiten->index, $importUsers);
                    $this->zeiteintraegeRepository->add($zeiteintraege);
                }
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $this->view->assign('resultarray', $resultarray);
        echo $this->view->render();
        die;
    }


    /**
     * @param $zeiteintraege
     * @param $importZeiteintrag
     * @param $index
     * @param $importUsers
     */
    public function updateZeiteintraegeImport($zeiteintraege, $importZeiteintrag, $index, $importUsers)
    {
        $zeiteintraege->setText($importZeiteintrag[$index->dsl_zeiten_text]);
        $zeiteintraege->setOldid($importZeiteintrag[$index->dsl_zeiten_id]);
        $zeiteintraege->setBegin(new \DateTime(date('Y-m-d H:i:s', $importZeiteintrag[$index->dsl_zeiten_start])));
        $zeiteintraege->setEnd(new \DateTime(date('Y-m-d H:i:s', $importZeiteintrag[$index->dsl_zeiten_end])));
        $user = $importUsers->items->{$importZeiteintrag[$index->dsl_zeiten_fe_user_uid]};
        if ($mitarbeiter = $this->mitarbeiterRepository->findByInitialien($user[$importUsers->index->title])) {
            $zeiteintraege->setCruser($mitarbeiter);
        } else {
            $mitarbeiter = $this->mitarbeiterRepository->findByInitialien('JL');
            $zeiteintraege->setCruser($mitarbeiter);
        }
        if ($wartungsvertraege = $this->wartungsvertraegeRepository->findByOldid($importZeiteintrag[$index->dsl_zeiten_dsl_wartung_id])) {
            //echo date('Y-m-d H:i:s', $importZeiteintrag[$index->dsl_zeiten_end]);
            if ($wartungsvertraegeZeitraeume = $this->wartungsvertraegeZeitraeumeRepository->findByWartungsvertragForDate($wartungsvertraege, $zeiteintraege->getBegin())) {
                echo '<br>GEFUNDEN!!';
            } else {
                //zeitraum anlegen / schleife each
                $vertragsBegin = $wartungsvertraege->getVertragsBegin();
                $laufzeit = $wartungsvertraege->getLaufzeit();
                echo '<br>vertragsbegin:' . date('Y-m-d H:i:s', $vertragsBegin->getTimestamp());
                echo '<br>laufzeit:' . $laufzeit;
                $datumZeiteintrag = $zeiteintraege->getBegin();
                $vertragsBeginZeitraum = clone $vertragsBegin;
                $vertragsBeginNaechsterZeitraum = clone $vertragsBeginZeitraum;
                $loopCounter = 0;
                do {    //date('Y-m-d', $datumZeiteintrag->getTimestamp()
                    date_sub($vertragsBeginZeitraum, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($laufzeit)));
                    if ($datumZeiteintrag >= $vertragsBeginZeitraum && $datumZeiteintrag < $vertragsBeginNaechsterZeitraum) {
                        break;
                    } else {
                        date_sub($vertragsBeginNaechsterZeitraum, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($laufzeit)));
                    }
                    $loopCounter++;
                } while ($loopCounter < 100);
                $vertragsBeginNaechsterZeitraum = clone $vertragsBeginZeitraum;
                $loopCounter = 0;
                do {    date_add($vertragsBeginNaechsterZeitraum, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($laufzeit)));
                    if ($datumZeiteintrag >= $vertragsBeginZeitraum && $datumZeiteintrag < $vertragsBeginNaechsterZeitraum) {
                        //echo "<br>datum liegt dazwischen // neuen zeitraum anlegen!!";
                        $wartungsvertraegeZeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();
                        $wartungsvertraegeZeitraeume->setVon(clone $vertragsBeginZeitraum);
                        $wartungsvertraegeZeitraeume->setBis(clone $vertragsBeginNaechsterZeitraum);
                        $wartungsvertraegeZeitraeume->setPid((int)$this->settings['wartungsvertraegeZeiteintraegePid']);
                        $this->wartungsvertraegeZeitraeumeRepository->add($wartungsvertraegeZeitraeume);
                        $wartungsvertraege->addZeitraeume($wartungsvertraegeZeitraeume);
                        // $newAufgaben->setAuftrag($this->auftraegeRepository->findByUid($auftraegeUid));
                        //                     $this->wartungsvertraegeRepository->update($wartungsvertraege);
                        break;
                    } else {
                        //echo "<br>datum liegt noch nicht dazwischen!! // weiter while schleife!!";
                        date_add($vertragsBeginZeitraum, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($laufzeit)));
                    }
                    $loopCounter++;
                } while ($loopCounter < 200);
            }
            $wartungsvertraegeZeitraeume->addZeiten($zeiteintraege);
            $this->wartungsvertraegeRepository->update($wartungsvertraege);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }
        $zeiteintraege->setKontingent(ceil(($importZeiteintrag[$index->dsl_zeiten_end] - $importZeiteintrag[$index->dsl_zeiten_start]) / 60));
        return $zeiteintraege;
    }

    /**
     * @param $wartung
     * @param $importWartung
     * @param $index
     * @param $importUsers
     */
    public function updateWartungsvertraegeImport($wartung, $importWartung, $index, $importUsers)
    {
        /*
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        //   b v n s ü geregelt


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        dsl_wartung_rezeitraum
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        dsl_wartung_zeitraum
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        dsl_wartung_kfrist



                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $cfg["rezeitraum"] = array(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        10=>array("value"=>"1"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        20=>array("value"=>"3"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        30=>array("value"=>"6"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        );
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $cfg["zeitraum"] = array(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        10=>array("value"=>"3"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        20=>array("value"=>"6"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        30=>array("value"=>"12"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        40=>array("value"=>"24"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        );
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $cfg["kfrist"] = array(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        10=>array("value"=>"3"),

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        );*/

        $kuendigungsFristMapping = array(10 => 30);
        $wartung->setKuendigungsFrist($kuendigungsFristMapping[$importWartung[$index->dsl_wartung_kfrist]]);
        $reIntervallMapping = array(10 => 10, 20 => 30, 30 => 60);
        $wartung->setReIntervall($reIntervallMapping[$importWartung[$index->dsl_wartung_rezeitraum]]);
        $laufzeitMapping = array(10 => 30, 20 => 60, 30 => 120, 40 => 240);
        $wartung->setLaufzeit($laufzeitMapping[$importWartung[$index->dsl_wartung_zeitraum]]);
        $wartung->setTitel($importWartung[$index->dsl_wartung_title]);
        $wartung->setOldid($importWartung[$index->dsl_wartung_id]);
        $wartung->setBeschreibung($importWartung[$index->dsl_wartung_text]);
        $wartung->setGekuendigt($importWartung[$index->dsl_wartung_gekuendigt]);
        if ($importWartung[$index->dsl_wartung_archiv]) {
            $wartung->setGekuendigt(true);
        }
        $wartung->setPreisMehraufwandStunde($importWartung[$index->dsl_wartung_preisstunde]);
        // mehraufwand
        $wartung->setPreisMonatlich($importWartung[$index->dsl_wartung_preismonat]);
        $wartung->setBezahltbis(new \DateTime($importWartung[$index->dsl_wartung_redate]));
        $wartung->setVertragsbegin(new \DateTime($importWartung[$index->dsl_wartung_start]));
        //$wartung->setVertragsbegin(new \DateTime($importWartung[$index->dsl_wartung_start]));
        $wartung->setStundenProJahr($importWartung[$index->dsl_wartung_minuten] / 60);
        $user = $importUsers->items->{$importWartung[$index->dsl_wartung_kunden_uid]};
        if ($user[$importUsers->index->title]) {
            //			echo '<div>nutzer existiert im import</div>';
            if ($kunde = $this->kundenRepository->findByNummer($user[$importUsers->index->title])) {
                //			echo '<div>'.$kunde.'</div>';
                $wartung->setKunde($kunde);
            } else {
                echo '<div>FEHLER! Kunde nicht gefunden</div>';
            }
        } else {
            echo '<div>FEHLER! Kunde (' . $user[$importUsers->index->name] . ' / ' . $user[$importUsers->index->company] . ') hat keine kundennummer uid im alten typo3:' . $user[$importUsers->index->uid] . '</div>';
        }
        //		$wartung->setBezahltbis($importWartung[$index->dsl_wartung_redate]);
        /*

        [dsl_wartung_id] => 0
                            [dsl_wartung_kunden_uid] => 1
        //                    [dsl_wartung_title] => 2
        //                    [dsl_wartung_text] => 3
        //                    [dsl_wartung_start] => 4
                            [dsl_wartung_end] => 5 // ende wird in rechnungszeiträume geschrieben
        //                    [dsl_wartung_archiv] => 6
        //                    [dsl_wartung_minuten] => 7
                            [dsl_wartung_lastchange] => 8
                            [dsl_wartung_minutengesamt] => 9
                            [dsl_wartung_archivdate] => 10
        //                    [dsl_wartung_status] => 11
        //                    [dsl_wartung_preismonat] => 12
        //                    [dsl_wartung_preisstunde] => 13
        //                    [dsl_wartung_rezeitraum] => 14
        //                    [dsl_wartung_zeitraum] => 15
        //                    [dsl_wartung_kfrist] => 16
        //                    [dsl_wartung_gekuendigt] => 17
        //                    [dsl_wartung_redate] => 18 // datum wann nächste rechnung geschrieben werden muß
        */

        return $wartung;
    }


    /**
     * action newZeiteintrag
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $newZeiteintraege
     * @return void
     */
    public function newZeiteintragAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $newZeiteintraege = NULL)
    {
		
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Wartungsvertraege/NewZeiteintraege.html', $this->request->getControllerExtensionName());
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $begin = false;
        if ($zeiteintraegeLast = $this->zeiteintraegeRepository->findLast($mitarbeiter)) {
            if (date('Y-m-d') == date('Y-m-d', $zeiteintraegeLast->getEnd()->getTimestamp())) {
                $begin = $zeiteintraegeLast->getEnd();
            }
        }
        if (!$begin) {
            $begin = new \DateTime(date('Y-m-d H:i:s', mktime(0, 0, 0, (int)date('m'), (int)date('d'), (int)date('Y')) + $mitarbeiter->getArbeitsbegin()));
        }
		$wartungsvertraege = $this->wartungsvertraegeRepository->findByUid($this->request->getArgument('wartungsvertraege'));

		//vorauswahl des aktiven Zeitraum setzen
        $now = new \DateTime();
		$zeitraeume=[];
        foreach ($wartungsvertraege->getZeitraeumeSorted() as $zeitraum) {
			//array_push($zeitraeume,array('uid' =>$zeitraum->getUid(),'titel' =>  $zeitraum->getVon()->format('m/y') .' - '. $zeitraum->getBis()->format('m/y')));
            $uid = $zeitraum->getUid();
			$zeitraeume[$uid] = [
				'uid' => $uid,
				'titel' => $zeitraum->getVon()->format('m/y') . ' - ' . $zeitraum->getBis()->format('m/y')
			];
			if ($now->format('Y-m-d') >= $zeitraum->getVon()->format('Y-m-d') && $now->format('Y-m-d') < $zeitraum->getBis()->format('Y-m-d')) {               
			   $dbView->assign('zeitraum', $zeitraum);     
                break;
            }
			
		}
		
		
        //die;
        $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $zeiteintraege->setBegin($begin);
        //hier das letzte ende oder den tagesbegin eintragen
        $zeiteintraege->setEnd(new \DateTime());
        $zeiteintraege->setKontingent((int)ceil(($zeiteintraege->getEnd()->getTimestamp() - $zeiteintraege->getBegin()->getTimestamp()) / 60));
        //$zeiteintraege->setKontingent(($zeiteintraege->getEnd()->getTimestamp() - $zeiteintraege->getBegin()->getTimestamp()) / 60);
        $dbView->assign('zeiteintraege', $zeiteintraege);
        $dbView->assign('wartungsvertraege', $wartungsvertraege);
        $dbView->assign('wartungsvertraegeAll', $wartungsvertraege);
		
		// Sort if necessary
		/*usort($zeitraeume, function ($a, $b) {
			return strcmp($a['titel'], $b['titel']);
		});*/
		
		//\TYPO3\CMS\Core\Utility\DebugUtility::debug($zeitraeume);


    // Assign the sorted array to wartungsvertraege.zeitraeumeSorted
		$dbView->assign('wartungsvertraege', ['zeitraeumeSorted' => $zeitraeume]);
        echo $dbView->render();
        die;
    }

    /**
     * action editZeiteintrag
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("zeiteintraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editZeiteintragAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege): \Psr\Http\Message\ResponseInterface
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Wartungsvertraege/EditZeiteintraege.html', $this->request->getControllerExtensionName());
        if (!$zeiteintraege->getEnd()) {
            $zeiteintraege->setEnd(new \DateTime());
            $zeiteintraege->setKontingent(ceil($zeiteintraege->getKontingent() / 60));
        }
        //$dbView->assign('auftraegeUid', 99999);
        if ($this->request->hasArgument('auftraege')) {
            $dbView->assign('auftraegeUid', $this->request->getArgument('auftraege'));
        }
        $zeitraum = $this->wartungsvertraegeZeitraeumeRepository->findByZeiteintraege($zeiteintraege);
        $dbView->assign('pluginName', strtolower($this->request->getPluginName()));
        $dbView->assign('zeitraum', $zeitraum);
        $dbView->assign('wartungsvertraege', $zeitraum->getWartungsvertrag());
        $dbView->assign('zeiteintraege', $zeiteintraege);
        echo $dbView->render();
        die;
        return $this->htmlResponse();
    }

    /**
     * @param $zeiteintraege
     */
    private function updateZeiteintragFromRequest($zeiteintraege)
    {
		
        if ($this->request->hasArgument('zeitraum')) {
            if (is_array($this->request->getArgument('zeitraum'))) {
                //bearbeiten von zeiteinträgen
                foreach ($this->request->getArgument('zeitraum') as $zeitraum) {
                    $zeitraumAlt = $this->wartungsvertraegeZeitraeumeRepository->findByZeiteintraege($zeiteintraege);
                    $zeitraumNeu = $this->wartungsvertraegeZeitraeumeRepository->findByUid($zeitraum);
                    if ($zeitraumNeu != $zeitraumAlt) {
                        //zeitraum wurde geändert
                        $zeitraumNeu->addZeiten($zeiteintraege);
                        $this->wartungsvertraegeZeitraeumeRepository->update($zeitraumNeu);
                    }
                }
            } else {
                //anlegen von zeiteinträgen
                $zeitraumNeu = $this->wartungsvertraegeZeitraeumeRepository->findByUid($this->request->getArgument('zeitraum'));
                $zeitraumNeu->addZeiten($zeiteintraege);
                $this->wartungsvertraegeZeitraeumeRepository->update($zeitraumNeu);
            }
        }
        if ($this->request->hasArgument('text')) {
            $zeiteintraege->setText($this->request->getArgument('text'));
        }
        if ($this->request->hasArgument('kontingent')) {
            $zeiteintraege->setKontingent((int)$this->request->getArgument('kontingent'));
        }
        if ($this->request->hasArgument('begin')) {
            if ($this->request->hasArgument('beginTime')) {
                if ($this->request->hasArgument('beginTime') > $this->request->hasArgument('endTime')) {
                    $timeString = ' ' . $this->request->getArgument('endTime');
                } else {
                    $timeString = ' ' . $this->request->getArgument('beginTime');
                }
            } else {
                $timeString = '';
            }
            //$newBegin = $this->request->getArgument('begin');
            $zeiteintraege->setBegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('begin') . $timeString)));
        }
        //->getArgument('begin')
        if ($this->request->hasArgument('endTime')) {
            if ($this->request->hasArgument('beginTime') > $this->request->hasArgument('endTime')) {
                $timeString = ' ' . $this->request->getArgument('beginTime');
            } else {
                $timeString = ' ' . $this->request->getArgument('endTime');
            }
            //	$newEnd = $this->request->getArgument('end');
            //$zeiteintraege->getBegin()->format('d.m.Y')
            $zeiteintraege->setEnd(new \DateTime($zeiteintraege->getBegin()->format('d.m.Y') . $timeString));
        }
        if ($zeiteintraege->getBegin()->getTimestamp() > $zeiteintraege->getEnd()->getTimestamp()) {
            $tmpBegin = $zeiteintraege->getBegin();
            $tmpEnd = $zeiteintraege->getEnd();
            $zeiteintraege->setEnd($tmpBegin);
            $zeiteintraege->setBegin($tmpEnd);
        }
        return $zeiteintraege;
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
        $wartungsvertraeges = $this->wartungsvertraegeRepository->findAll();
        $this->view->assign('wartungsvertraeges', $wartungsvertraeges);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege
     * @return void
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege)
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Wartungsvertraege/Show.html', $this->request->getControllerExtensionName());
        $dbView->assign('wartungsvertraege', $wartungsvertraege);
        $dbView->assign('feuser', \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        return $dbView->render();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $newWartungsvertrag = new \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege();
        //$newAuftraege->setTitel('neu / vorbelegung');
        $newWartungsvertrag->setVertragsbegin(new \DateTime());
        //$this->view->assign('prioritaets', $this->getPrioritaets());
        $this->view->assign('reintervalls', \DslFactory\DslIntranet\Utility\LanguageUtility::init()->getArrayFor('dsl_intranet', 'tx_dslintranet_domain_model_wartungsvertraege', 're_intervall'));
        $this->view->assign('kuendigungsfrists', \DslFactory\DslIntranet\Utility\LanguageUtility::init()->getArrayFor('dsl_intranet', 'tx_dslintranet_domain_model_wartungsvertraege', 'kuendigungs_frist'));
        $this->view->assign('laufzeits', \DslFactory\DslIntranet\Utility\LanguageUtility::init()->getArrayFor('dsl_intranet', 'tx_dslintranet_domain_model_wartungsvertraege', 'laufzeit'));
        //$this->view->assign('pers', $this->getPers());
		$kundens = $this->kundenRepository->getActive();

        $this->view->assign('kundens', $kundens);
        $optionens = $this->wartungsvertraegeOptionenRepository->findAll();
        $this->view->assign('optionens', $optionens);
        //		$newWartungsvertrag->setStundenProJahr(9);
        //default
        $newWartungsvertrag->setLaufzeit(120);
        $newWartungsvertrag->setReIntervall(30);
        $newWartungsvertrag->setStundenProJahr(12);
        $newWartungsvertrag->setPreisMonatlich(60);
        $newWartungsvertrag->setPreisMehraufwandStunde(70);
        $this->view->assign('wartungsvertraege', $newWartungsvertrag);
        return $this->htmlResponse();
    }

    private function getIntervalls()
    {
        return \DslFactory\DslIntranet\Utility\LanguageUtility::init()->getArrayFor('dsl_intranet', 'tx_dslintranet_domain_model_wartungsvertraege', 'laufzeit');
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] as $status) {
            $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.status.' . $status[1], 'dsl_intranet',[],'de');
        }
        return $statuss;
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $newWartungsvertraege
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $newWartungsvertraege)
    {
        /*$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeRepository->add($newWartungsvertraege);
        $this->redirect('list');*/
        return false;
    }

    /**
     * action edit
     *
     * @return void
     */
    public function editAction()
    {
        /*$this->view->assign('wartungsvertraege', $wartungsvertraege);
        return $this->htmlResponse();*/

        if (!$this->request->hasArgument('uid')) {
            die;
        }
        if ($wartungsvertraege = $this->wartungsvertraegeRepository->findByUid($this->request->getArgument('uid'))) {
            //		var_dump($wartungsvertraege);
            //		die;
            // $wartungsvertraege->getTitel();die;
            $this->view->assign('wartungsvertraege', $wartungsvertraege);
            $this->view->assign('reintervalls', \DslFactory\DslIntranet\Utility\LanguageUtility::init()->getArrayFor('dsl_intranet', 'tx_dslintranet_domain_model_wartungsvertraege', 're_intervall'));
            $this->view->assign('laufzeits', \DslFactory\DslIntranet\Utility\LanguageUtility::init()->getArrayFor('dsl_intranet', 'tx_dslintranet_domain_model_wartungsvertraege', 'laufzeit'));
            $this->view->assign('kuendigungsfrists', \DslFactory\DslIntranet\Utility\LanguageUtility::init()->getArrayFor('dsl_intranet', 'tx_dslintranet_domain_model_wartungsvertraege', 'kuendigungs_frist'));
            $this->view->assign('kundens', $this->kundenRepository->getActive());
            $optionens = $this->wartungsvertraegeOptionenRepository->findAll();
            $this->view->assign('optionens', $optionens);
            echo $this->view->render();
        }
        die;
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeRepository->update($wartungsvertraege);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeRepository->remove($wartungsvertraege);
        $this->redirect('list');
    }
}
