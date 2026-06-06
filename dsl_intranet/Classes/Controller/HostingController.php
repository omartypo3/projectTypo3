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
 * HostingController
 */
class HostingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * hostingRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\HostingRepository
     */
    protected $hostingRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\HostingRepository $hostingRepository
     */
    public function injectHostingRepository(\DslFactory\DslIntranet\Domain\Repository\HostingRepository $hostingRepository)
    {
        $this->hostingRepository = $hostingRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->hostingRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingRepository');
        $this->hostingDomainsRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingDomainsRepository');
        $this->hostingZusatzleistungenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingZusatzleistungenRepository');
        $this->hostingTarifRechnungenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingTarifRechnungenRepository');
        $this->tarifeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\TarifeRepository');
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
                case 'delete':    if ($this->request->hasArgument('uid')) {
                    if ($hosting = $this->hostingRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($hosting);
                        return true;
                    }
                }
                    break;
                case 'deleteDomain':    if ($hostingDomain = $this->hostingDomainsRepository->findByUid($this->request->getArgument('uid'))) {
                    //						if ($hosting = $this->hostingRepository->findByHauptTarif($hostingDomain)) {
                    //$hosting->clearHauptTarif();
                    //								$hosting->gHauptTarif();
                    //	echo $hosting->getUid();
                    //							}
                    //echo "end";
                    //die;
                    if ($hosting = $this->hostingRepository->findByHauptTarif($hostingDomain)) {
                        $hosting->clearHauptTarif();
                        $this->hostingRepository->update($hosting);
                    } elseif ($hosting = $this->hostingRepository->findByZusatzTarif($hostingDomain)) {
                        $hosting->removeZusatzTarif($hostingDomain);
                        $this->hostingRepository->update($hosting);
                    }
                    $this->hostingDomainsRepository->remove($hostingDomain);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //$this->redirect('list');
                    die;
                }
                    break;
                case 'showKennwort':    //echo "bla";
                    $hosting = $this->hostingRepository->findByUid($this->request->getArgument('uid'));
                    echo $hosting->getKennwort();
                    die;
                    break;
                case 'hostingList':    //echo $kunde->getUid();
                    $retarray = $this->listJSONDataTable();
                    echo json_encode($retarray);
                    die;
                    break;
                case 'prevRechnung':    switch ($this->request->getArgument('produkt')) {
                    case 'domains':    //	$hostingDomainsRepository = NULL;
                        $vertrag = $this->hostingDomainsRepository->findByUid($this->request->getArgument('uid'));
                        // $tarif = $vertrag->getTarif();
                        break;
                    case 'zusatzleistungen':    $vertrag = $this->hostingZusatzleistungenRepository->findByUid($this->request->getArgument('uid'));
                        $anzahl = $vertrag->getAnzahl();
                        // $tarif = $vertrag->getZusatzleistung();
                        break;
                }
                    $neuBezahltbis = $vertrag->getBezahltbis();
                    date_sub($neuBezahltbis, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($vertrag->getLaufzeit())));
                    $vertrag->setBezahltbis($neuBezahltbis);
                    switch ($this->request->getArgument('produkt')) {
                        case 'domains':    //	$hostingDomainsRepository = NULL;
                            $this->hostingDomainsRepository->update($vertrag);
                            break;
                        case 'zusatzleistungen':    $this->hostingZusatzleistungenRepository->update($vertrag);
                            break;
                    }
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    die;
                    break;
                case 'nextRechnung':    $anzahl = 1;
                    $newRechnung = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();
                    $newRechnung->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $newRechnung->setPid((int)$this->settings['hostingPid']);
                    switch ($this->request->getArgument('produkt')) {
                        case 'domains':    $vertrag = $this->hostingDomainsRepository->findByUid($this->request->getArgument('uid'));
                            $newRechnung->setDomainname($vertrag->getDomainname());
                            $tarif = $vertrag->getTarif();
                            break;
                        case 'zusatzleistungen':    $vertrag = $this->hostingZusatzleistungenRepository->findByUid($this->request->getArgument('uid'));
                            $anzahl = $vertrag->getAnzahl();
                            $tarif = $vertrag->getZusatzleistung();
                            break;
                    }
                    //echo "alt: ".$vertrag->getBezahltbis()->format("d.m.Y");
                    $newRechnung->setVon($vertrag->getBezahltbis());
                    $neuBezahltbis = $vertrag->getBezahltbis();
                    date_add($neuBezahltbis, date_interval_create_from_date_string(\DslFactory\DslIntranet\Utility\HostingUtility::init()->getIntervalDateString($vertrag->getLaufzeit())));
                    //echo "neu: ".$neuBezahltbis->format("d.m.Y");
                    //die;
                    $newRechnung->setBis($neuBezahltbis);
                    $newRechnung->setPreis($anzahl * (\DslFactory\DslIntranet\Utility\HostingUtility::init()->getLaufzeitMonate($vertrag->getLaufzeit()) * $vertrag->getPreisMonatlich()));
                    $newRechnung->setTarif($anzahl . ' x ' . $tarif->getTitel());
                    $newRechnung->setNotiz('');
                    $vertrag->addRechnungen($newRechnung);
                    $vertrag->setBezahltbis($neuBezahltbis);
                    switch ($this->request->getArgument('produkt')) {
                        case 'domains':    $this->hostingDomainsRepository->update($vertrag);
                            break;
                        case 'zusatzleistungen':    $this->hostingZusatzleistungenRepository->update($vertrag);
                            break;
                    }
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //neues Rechnungsintervall!!
                    print_r($this->request->getArguments());
                    die;
                    break;
                case 'update':    $hosting = $this->hostingRepository->findByUid($this->request->getArgument('hosting'));
                    $hosting = $this->updateHostingFromRequest($hosting);
                    $this->hostingRepository->update($hosting);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('uid' => $hosting->getUid()));
                    //, 'contentList' => $this->getPartialsListRow($auftraege)
                    die;
                    break;
                case 'create':    $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();
                    //$hosting->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $hosting = $this->updateHostingFromRequest($hosting);
                    $this->hostingRepository->add($hosting);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('newUid' => $hosting->getUid()));

                    die;
                    //$newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege $this->request->getArgument('titel');
                    break;
                case 'updateDomain':    $hostingDomain = $this->hostingDomainsRepository->findByUid($this->request->getArgument('hostingDomain'));
                    $hostingDomain = $this->updateHostingDomainFromRequest($hostingDomain);
                    $this->hostingDomainsRepository->update($hostingDomain);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('uid' => $hostingDomain->getUid()));
                    die;
                    break;
                case 'newZusatzTarif':    $zusatzTarif = true;
                case 'newHauptTarif':    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Hosting/NewDomain.html', $this->request->getControllerExtensionName());
                    $newHostingDomain = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();
                    // echo "drei";
                    $tarifes = $this->tarifeRepository->findAll();
					$tarife=[];
					foreach ($tarifes as $tarif) {
						$tarifgetLaufzeit = '';
						switch ($tarif->getLaufzeit()) {
							case 10:
								$tarifgetLaufzeit = "1 Monat";
								break;
							case 30:
								$tarifgetLaufzeit = "3 Monate";
								break;
							case 60:
								$tarifgetLaufzeit = "6 Monate";
								break;
							case 120:
								$tarifgetLaufzeit = "12 Monate";
								break;	
							case 240:
								$tarifgetLaufzeit = "2 Jahre";
								break;
							case 360:
								$tarifgetLaufzeit = "3 Jahre";
								break;
						}
					
						array_push($tarife,array('uid' =>$tarif->getUid(),'titelPreisLaufzeit' => $tarif->getTitel() ." (mtl. ". $tarif->getPreisMonatlich() ." € Netto / " .$tarifgetLaufzeit." Laufzeit )" ));	
					}

                   // array_unshift($tarife ,array('uid' =>'','titelPreisLaufzeit' =>''));
					
                    $dbView->assign('tarife', $tarife);
                    $dbView->assign('sonderlaufzeiten', $this->getSonderlaufzeiten());
                    $dbView->assign('hostingDomain', $newHostingDomain);
                    $dbView->assign('hostingUid', $this->request->getArgument('hostingUid'));
                    if ($zusatzTarif) {
                        $dbView->assign('zusatzTarif', true);
                    }
                    echo $dbView->render();
                    die;
                    break;
                case 'createZusatzTarif':    $zusatzTarif = true;
                case 'createHauptTarif':
                    $hostingDomain = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();
                    $hostingDomain->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $hostingDomain = $this->updateHostingDomainFromRequest($hostingDomain);

                    $hosting = $this->hostingRepository->findByUid((int)$this->request->getArgument('hostingUid'));
                  
                    if ($zusatzTarif) {
                        $hosting->addZusatzTarif($hostingDomain);
                    } else {
                        $hosting->setHauptTarif($hostingDomain);
                    }
                    //	echo "bla";
                    $this->hostingRepository->update($hosting);
                    $this->hostingDomainsRepository->add($hostingDomain);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('newUid' => $hostingDomain->getUid()));
                    die;
                    //$newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege $this->request->getArgument('titel');
                    break;
                case 'filterSet':    $user = $GLOBALS['TSFE']->fe_user->user;
                    $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
                    if ($this->request->hasArgument('settings')) {
                        $stringRepresentation= json_encode($this->request->getArgument('settings'));

                        $mitarbeiter->setSettingsHosting($stringRepresentation);
                    } else {
                        $mitarbeiter->setSettingsHosting('');
                    }
                    $this->mitarbeiterRepository->update($mitarbeiter);
                    //print_r($mitarbeiter->getSettingsHosting());
                    //die;
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //$this->redirect('list', NULL, NULL, array('ajaxGet' => true));
                    /*	print_r($this->request->getArguments());
                       echo "YYYS";
                       print_r($mitarbeiter->getSettingsHosting());
                       exit;*/

                    // $this->redirect('list', NULL, NULL, array('ajaxGet' => true));
                    die;
                    break;
            }
        }
        //header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));

       // return $this->htmlResponse();
    }

    protected function listJSONDataTable()
    {
        $data = array();


        /** @var $logger \TYPO3\CMS\Core\Log\Logger */
        //$logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        //$logger->info('Everything went fine.');
        //$logger->warning('Something went awry, check your configuration!');
        //$logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'listJSONDataTable!');
        //echo "!";
        //echo $kunde = $this->kundenRepository->findByName("pro haar");
        //		die;
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Hosting/ListJSONDataTable.html', $this->request->getControllerExtensionName());
        $dbViewZusatzDomain = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Hosting/ListJSONDataTableZusatzDomain.html', $this->request->getControllerExtensionName());
        $dbViewZusatzLeistung = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Hosting/ListJSONDataTableZusatzLeistung.html', $this->request->getControllerExtensionName());
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
        $user = $GLOBALS['TSFE']->fe_user->user;
        $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);


        $settings = $mitarbeiter->getSettingsHosting();

      
        //print_r($settings);die;
        //$this->view->assign('settings', $settings);
        $hostingsAnzahlFiltered = count($this->hostingRepository->findByFilter($settings));
        //echo $hostingsAnzahlFiltered ;
        //die;
        $hostings = $this->hostingRepository->findByFilter($settings, $start, $length, $order, $search);

	

        $hostingsAnzahl = $this->hostingRepository->findByFilter($settings, false, false, $order, $search);
        $dtRecordsTotal = $hostingsAnzahlFiltered;
        $dtRecordsFiltered = count($hostingsAnzahl);
        //$dbView->assign('hosting', $hostings);
        //  $data[] = explode('<--break-->', $dbView->render());
        if ($hostings) {
            foreach ($hostings as $hosting) {
                //echo "<hr>hostingid:".$hosting->getUid();
                $dbView->assign('hosting', $hosting);
                $data[] = explode('<--break-->', $dbView->render());
                $hostingDomains = $this->hostingDomainsRepository->findByFilter($hosting, $hosting->getHauptTarif(), $settings, false, false, $order, $search);
                $zusatz = false;
                if ($hostingDomains) {
                    foreach ($hostingDomains as $zusatzDomain) {
                        //echo "<hr>hostingzusatzdomainid:".$zusatzDomain->getUid();
                        $zusatz = true;
                        $dbViewZusatzDomain->assign('zusatzDomain', $zusatzDomain);
                        $dbViewZusatzDomain->assign('hosting', $hosting);
                        $data[] = explode('<--break-->', $dbViewZusatzDomain->render());
                    }
                }
                $zusatzLeistungen = $this->hostingZusatzleistungenRepository->findByFilter($hosting, $settings, false, false, $order, $search);
                if ($zusatzLeistungen) {
                    foreach ($zusatzLeistungen as $zusatzLeistung) {
                        $zusatz = true;
                        $dbViewZusatzLeistung->assign('hosting', $hosting);
                        $dbViewZusatzLeistung->assign('zusatzLeistung', $zusatzLeistung);
                        $data[] = explode('<--break-->', $dbViewZusatzLeistung->render());
                    }
                }
                $valid = true;
                if (isset($settings['statuss'])) {
                    //if (in_array(20, $settings['statuss'])) {
                    if (20 == $settings['statuss']) {
                        //nur wenn fällig oder fällige zusatztarife gefunden wurden
                        if (!$hosting->getHauptTarif()) {
                            $valid = false;
                        } else {
                            if (!$hosting->getHauptTarif()->isFaellig() && !$zusatz) {
                                $valid = false;
                            }
                        }
                    }
                    //if (in_array(30, $settings['statuss'])) {
                    if (30 == $settings['statuss']) {
                        //nur wenn überfällig oder überfällige zusatztarife gefunden wurden
                        if (!$hosting->getHauptTarif()) {
                            $valid = false;
                        } else {
                            if (!$hosting->getHauptTarif()->isUeberFaellig() && !$zusatz) {
                                $valid = false;
                            }
                        }
                    }
                }
                if (!$valid) {
                    $dtRecordsTotal--;
                    $dtRecordsFiltered--;
                    array_pop($data);
                }
            }
        }
        $retarray = array(
            'draw' => $_GET['draw'],
            'recordsTotal' => $dtRecordsTotal,
            'recordsFiltered' => $dtRecordsFiltered,
            'data' => $data
        );

        return $retarray;
    }

    /**
     * action import
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function importAction(): \Psr\Http\Message\ResponseInterface
    {
        $file = 'H:/Shares/dsl_data/projekte/web/dsl_intranet/export_hosting.json';
        $file = '/var/www/kd/dsl-factory.de/intern/export_hosting.json';
        $resultarray = array();
        $resultarray['datei'] = $file;
        $resultarray['dateidatum'] = date('d.m.Y H:i:s', filemtime($file)) . ' Uhr';
        $resultarray['dateigröße'] = filesize($file) . ' Bytes';
        $importArr = json_decode(file_get_contents($file));
        $importUsers = $importArr->fe_users;
        $importHostings = $importArr->dsl_hosting;
        $importDomains = $importArr->dsl_codomains;
        $resultarray = array($importUsers, $importHosting, $importDomains);
        $counter = 0;
        foreach ($importHostings->items as $importHosting) {
            if (!$importHosting[$importHostings->index->dsl_domains_domain]) {
                continue;
            }
            $counter++;
            $resultarray[] = $importHosting[$importHostings->index->dsl_hosting_login];
            if ($hosting = $this->hostingRepository->findByOldid($importHosting[$importHostings->index->dsl_hosting_id])) {
                $hosting = $this->updateHostingImport($hosting, $importHosting, $importHostings->index, $importUsers);
                $this->hostingRepository->update($hosting);
            } else {
                $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();
                $hosting = $this->updateHostingImport($hosting, $importHosting, $importHostings->index, $importUsers);
                $this->hostingRepository->add($hosting);
                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            }
            $resultarray[] = 'codomain: ' . $importHosting[$importHostings->index->dsl_domains_domain] . ' old_id:' . $importHosting[$importHostings->index->dsl_domains_id];
            if ($hostingDomain = $this->hostingDomainsRepository->findByOldid($importHosting[$importHostings->index->dsl_domains_id])) {
                $resultarray[] = 'ja gefunden!->update';
                $hostingDomain = $this->updateHostingDomainsImport($hostingDomain, $importHosting, $importHostings->index);
            } else {
                $resultarray[] = 'nicht gefunden!->neu';
                $hostingDomain = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();
                $hostingDomain = $this->updateHostingDomainsImport($hostingDomain, $importHosting, $importHostings->index);
            }
            if ($importHosting[$importHostings->index->dsl_domains_text]) {
                $hosting->setNotiz($importHosting[$importHostings->index->dsl_domains_domain] . ':
' . $importHosting[$importHostings->index->dsl_domains_text]);
            }
            $hosting->setHauptTarif($hostingDomain);
            //	echo "bla";
            $this->hostingRepository->update($hosting);
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //CoDomains eintragen
        $counter = 0;
        foreach ($importDomains->items as $importDomain) {
            $resultarray[] = 'coDomain:' . $importDomain[$importDomains->index->dsl_domains_domain];
            $hosting = $this->hostingRepository->findByOldid($importDomain[$importDomains->index->dsl_domains_dsl_hosting_id]);
            if ($hostingDomain = $this->hostingDomainsRepository->findByOldid($importDomain[$importDomains->index->dsl_domains_id])) {
                $resultarray[] = 'ja gefunden!->update';
                $hostingDomain = $this->updateHostingDomainsImport($hostingDomain, $importDomain, $importDomains->index);
                $this->hostingRepository->update($hosting);
            } else {
                $resultarray[] = 'nicht gefunden!->neu';
                $hostingDomain = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();
                $hostingDomain = $this->updateHostingDomainsImport($hostingDomain, $importDomain, $importDomains->index);
                //addZusatzTarif
                $hosting->addZusatzTarif($hostingDomain);
                $this->hostingRepository->update($hosting);
            }
            if ($importDomain[$importDomains->index->dsl_domains_text]) {
                $hosting->setNotiz($hosting->getNotiz() . '
' . $importDomain[$importDomains->index->dsl_domains_domain] . ':
' . $importDomain[$importDomains->index->dsl_domains_text]);
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $this->view->assign('resultarray', $resultarray);
        // echo "drei";
        echo $this->view->render();
        return $this->htmlResponse();
    }

    /**
     * @param $hosting
     * @param $importHosting
     * @param $index
     * @param $importUsers
     */
    public function updateHostingImport($hosting, $importHosting, $index, $importUsers)
    {
        $hosting->setBenutzername($importHosting[$index->dsl_hosting_login]);
        $hosting->setKennwort($importHosting[$index->dsl_hosting_password]);
        $hosting->setOldid($importHosting[$index->dsl_hosting_id]);
        $hosting->setStatistik($importHosting[$index->dsl_hosting_statistiklink]);
        $hosting->setNotiz('');
        $user = $importUsers->items->{$importHosting[$index->dsl_hosting_kunden_uid]};
        if ($user[$importUsers->index->title]) {
            if ($kunde = $this->kundenRepository->findByNummer($user[$importUsers->index->title])) {
                $hosting->setKunde($kunde);
            } else {
                echo '<div>FEHLER! Kunde nicht gefunden</div>';
            }
        } else {
            echo '<div>FEHLER! Kunde (' . $user[$importUsers->index->name] . ' / ' . $user[$importUsers->index->company] . ') hat keine kundennummer uid im alten typo3:' . $user[$importUsers->index->uid] . '</div>';
        }
        return $hosting;
    }

    /**
     * @param $hosting $hostingDomain
     * @param $importHosting
     * @param $index
     */
    public function updateHostingDomainsImport($hostingDomain, $importHosting, $index)
    {
        //$hostingDomain->setBenutzername($importHosting[$index->dsl_hosting_login]);
        //$hostingDomain->setKennwort($importHosting[$index->dsl_hosting_password]);
        /*if($importHosting[$index->dsl_domains_text]){
          $hostingDomain->setNotiz($hostingDomain->getNotiz()."\n".$importHosting[$index->dsl_domains_domain].":\n".$importHosting[$index->dsl_domains_text]);
          }*/

        $hostingDomain->setOldid($importHosting[$index->dsl_domains_id]);
        $hostingDomain->setDomainname($importHosting[$index->dsl_domains_domain]);
        $hostingDomain->setBezahltbis(new \DateTime($importHosting[$index->dsl_domains_bezahltbis]));
        $hostingDomain->setVertragsbegin(new \DateTime($importHosting[$index->dsl_domains_start]));
        if ($importHosting[$index->dsl_domains_gek]) {
            $hostingDomain->setGekuendigt(true);
        } else {
            $hostingDomain->setGekuendigt(false);
        }
        if ($importHosting[$index->dsl_domains_sonderpreis]) {
            $hostingDomain->setSonderpreisMonatlich($importHosting[$index->dsl_domains_sonderpreis]);
        }
        // alt => neu
        $tarifMapping = array(
            5 => 11,
            9 => 2,
            10 => 3,
            20 => 4,
            25 => 4,
            30 => 5,
            32 => 5,
            34 => 6,
            50 => 6,
            55 => 6,
            60 => 7,
            75 => 8,
            99 => 1,
            999 => 11
        );
        $hostingDomain->setTarif($this->tarifeRepository->findByUid($tarifMapping[$importHosting[$index->dsl_domains_paket]]));
        if ($importHosting[$index->dsl_domains_intervall]) {
            //3 => 6 Monate // 4 => 12 Monate
            //60 => 6 Monate // 120 => 12 Monate
            //3=>60 / 4=>120
            if ($importHosting[$index->dsl_domains_intervall] == 3 && $hostingDomain->getLaufzeit() != 60) {
                $hostingDomain->setSonderlaufzeit(60);
            }
            if ($importHosting[$index->dsl_domains_intervall] == 4 && $hostingDomain->getLaufzeit() != 120) {
                $hostingDomain->setSonderlaufzeit(120);
            }
        }
        //achtung auf benutzerdefinierten interval prüfen
        //!!!dsl_domains_text
        //!!!dsl_domains_intervall	benutzerdefinierte übernehmen?!
        return $hostingDomain;
    }

    /**
     * action editDomain
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomain
     * @return void
     */
    public function editDomainAction(\DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomain)
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Hosting/EditDomain.html', $this->request->getControllerExtensionName());
        $kundens = $this->kundenRepository->getActive();
        //        $dbView->assign('kundens', $kundens);
        $dbView->assign('hostingDomain', $hostingDomain);
        $tarifes = $this->tarifeRepository->findAll();
		$tarife=[];
		foreach ($tarifes as $tarif) {
				$tarifgetLaufzeit = '';
				switch ($tarif->getLaufzeit()) {
					case 10:
						$tarifgetLaufzeit = "1 Monat";
						break;
					case 30:
						$tarifgetLaufzeit = "3 Monate";
						break;
					case 60:
						$tarifgetLaufzeit = "6 Monate";
						break;
					case 120:
						$tarifgetLaufzeit = "12 Monate";
						break;	
					case 240:
						$tarifgetLaufzeit = "2 Jahre";
						break;
					case 360:
						$tarifgetLaufzeit = "3 Jahre";
						break;								
			}
					
			array_push($tarife,array('uid' =>$tarif->getUid(),'titelPreisLaufzeit' => $tarif->getTitel() ." (mtl. ". $tarif->getPreisMonatlich() ." € Netto / " .$tarifgetLaufzeit." Laufzeit )" ));	
		}

         //array_unshift($tarife ,array('uid' =>'','titelPreisLaufzeit' =>''));
        $dbView->assign('tarife', $tarife);
        $dbView->assign('sonderlaufzeiten', $this->getSonderlaufzeiten());
         echo $dbView->render();
        die;
    }


    private function getSonderlaufzeiten()
    {
        $prioritaets = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_hostingdomains']['columns']['sonderlaufzeit']['config']['items'] as $prioritaet) {
            $prioritaets[$prioritaet[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_tarife.laufzeit.' . $prioritaet[1], 'dsl_intranet',[],'de');
        }
        return $prioritaets;
    }

    private function getStatuss()
    {
        $statuss = array();
        foreach (array(10, 20) as $status) {
            //30
            $statuss[$status] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_hosting.statusfilter.' . $status, 'dsl_intranet',[],'de');
        }
        return $statuss;
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
        $hostings = $this->hostingRepository->findAll();
        $this->view->assign('hostings', $hostings);
        $kundenArr = array();
        foreach ($hostings as $hosting) {
            if ($hosting->getKunde()) {
                if (!in_array($hosting->getKunde(), $kundenArr)) {
                    $kundenArr[] = $hosting->getKunde();
                }
            }
        }
        $kundens = $this->kundenRepository->sortByName($kundenArr);
        $this->view->assign('kundens', $kundens);
        $this->view->assign('statuss', $this->getStatuss());
        //laden der aktiven Filterzustände
        $user = $GLOBALS['TSFE']->fe_user->user;
        $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
        $settings = $mitarbeiter->getSettingsHosting();
        $settingsArray = json_decode($settings, true);
        $settingsArray['statuss'] = [$settingsArray['statuss']];
        $settingsArray['kundens'] = [$settingsArray['kundens']];
        $this->view->assign('settings', $settings);
        $this->view->assign('kundensselect', $settingsArray['kundens']);
        $this->view->assign('statussselect', $settingsArray['statuss']);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Hosting $hosting
     * @return void
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Hosting $hosting)
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Hosting/Show.html', $this->request->getControllerExtensionName());
        $dbView->assign('hosting', $hosting);
        echo $dbView->render();
        die;
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $newHosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();
        //$newAuftraege->setTitel('neu / vorbelegung');
        // $newHosting->setDatum(new \DateTime());
        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        $this->view->assign('hosting', $newHosting);
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Hosting $newHosting
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Hosting $newHosting)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingRepository->add($newHosting);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Hosting $hosting
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("hosting")
     * @return void
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Hosting $hosting)
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Hosting/Edit.html', $this->request->getControllerExtensionName());
        $kundens = $this->kundenRepository->getActive();
        $dbView->assign('kundens', $kundens);
        $dbView->assign('hosting', $hosting);
        echo $dbView->render();
        die;
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Hosting $hosting
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Hosting $hosting)
    {
        /*$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingRepository->update($hosting);
        $this->redirect('list');*/
        die();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Hosting $hosting
     */
    private function updateHostingFromRequest($hosting)
    {
        if ($this->request->hasArgument('kunde')) {
            if (is_array($this->request->getArgument('kunde'))) {
                foreach ($this->request->getArgument('kunde') as $kunde) {
                    $hosting->setKunde($this->kundenRepository->findByUid($kunde));
                }
            } else {
                $hosting->setKunde($this->kundenRepository->findByUid($this->request->getArgument('kunde')));
            }
        }
        /* if ($this->request->hasArgument('kunde')) {
           if (is_array($this->request->getArgument('kunde'))) {
           foreach ($this->request->getArgument('kunde') as $kunde) {
           $hosting->setKunde($this->kundenRepository->findByUid($kunde));
           }
           }
           }*/

        if ($this->request->hasArgument('benutzername')) {
            $hosting->setBenutzername($this->request->getArgument('benutzername'));
        }
        if ($this->request->hasArgument('kennwort')) {
            $hosting->setKennwort($this->request->getArgument('kennwort'));
        }
        if ($this->request->hasArgument('statistik')) {
            $hosting->setStatistik($this->request->getArgument('statistik'));
        }
        if ($this->request->hasArgument('notiz')) {
            $hosting->setNotiz($this->request->getArgument('notiz'));
        }
        return $hosting;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomain
     */
    private function updateHostingDomainFromRequest($hostingDomain)
    {
        if ($this->request->hasArgument('domainname')) {
            $hostingDomain->setDomainname($this->request->getArgument('domainname'));
        }

        if ($this->request->hasArgument('tarif')) {
            if (is_array($this->request->getArgument('tarif'))) {
                foreach ($this->request->getArgument('tarif') as $tarif) {
                    $hostingDomain->setTarif($this->tarifeRepository->findByUid($tarif));
                }
            } else {
                $hostingDomain->setTarif($this->tarifeRepository->findByUid($this->request->getArgument('tarif')));
            }
        }
        if ($this->request->hasArgument('vertragsbegin')) {
            $hostingDomain->setVertragsbegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('vertragsbegin'))));
        }
        /*
        //abgelöst durch fällig import
        if ($this->request->hasArgument('bezahltbis')) {
            $hostingDomain->setBezahltbis(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('bezahltbis'))));
        }*/
        if ($this->request->hasArgument('notiz')) {
            $hostingDomain->setNotiz($this->request->getArgument('notiz'));
        }
        if ($this->request->hasArgument('faelligmonat')) {
            //echo $this->request->getArgument('bezahltbismonat');
            $faelligArr = explode('/',$this->request->getArgument('faelligmonat'));
            $faellig = new \DateTime("".$faelligArr[1]."-".$faelligArr[0]."-01");
            //$faellig->modify('+1 month');
            //echo ":".$bezahltbismonat->format('d.m.Y');
            //print_r($bezahltbismonatArr);

            $hostingDomain->setBezahltbis(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($faellig->format('d.m.Y'))));

            //$hostingDomain->setBezahltbis(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('bezahltbis'))));
        }


        if ($this->request->hasArgument('gekuendigtZum')) if ($this->request->getArgument('gekuendigtZum')) {
            //echo $this->request->getArgument('bezahltbismonat');
            $faelligArr = explode('/',$this->request->getArgument('gekuendigtZum'));
            $faellig = new \DateTime("".$faelligArr[1]."-".$faelligArr[0]."-01");
            //$faellig->modify('+1 month');
            //echo ":".$bezahltbismonat->format('d.m.Y');
            //print_r($bezahltbismonatArr);

            $hostingDomain->setGekuendigtZum(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($faellig->format('d.m.Y'))));

            //$hostingDomain->setBezahltbis(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('bezahltbis'))));
        }

        if ($this->request->hasArgument('gekuendigt')) {

            if($this->request->getArgument('gekuendigt') == '' || $this->request->getArgument('gekuendigt')=='0'){
                $hostingDomain->setGekuendigt(FALSE);

            }else{
                $hostingDomain->setGekuendigt(TRUE);

            }
            //echo "hasArgument:".$this->request->getArgument('gekuendigt');
        }

        /*else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        			echo "noargument";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        		}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             		die;*/

        if ($this->request->hasArgument('sonderlaufzeit')) {
            if (is_array($this->request->getArgument('sonderlaufzeit'))) {
                foreach ($this->request->getArgument('sonderlaufzeit') as $sonderlaufzeit) {
                    $hostingDomain->setSonderlaufzeit((int)$sonderlaufzeit);
                }
            } else {
                $hostingDomain->setSonderlaufzeit((int)$this->request->getArgument('sonderlaufzeit'));
            }
        }
        /*
        	    if ($this->request->hasArgument('kunde')) {
                    if (is_array($this->request->getArgument('kunde'))) {
                        foreach ($this->request->getArgument('kunde') as $kunde) {
                            $hosting->setKunde($this->kundenRepository->findByUid($kunde));
                        }
                    }
                }
                if ($this->request->hasArgument('benutzername')) {
                    $hosting->setBenutzername($this->request->getArgument('benutzername'));
                }
                if ($this->request->hasArgument('kennwort')) {
                    $hosting->setKennwort($this->request->getArgument('kennwort'));
                }
                if ($this->request->hasArgument('statistik')) {
                    $hosting->setStatistik($this->request->getArgument('statistik'));
                }
                if ($this->request->hasArgument('notiz')) {
                    $hosting->setNotiz($this->request->getArgument('notiz'));
                }
        */


        if ($this->request->hasArgument('sonderpreisMonatlich')) {
            $hostingDomain->setSonderpreisMonatlich((float)str_replace(',', '.', $this->request->getArgument('sonderpreisMonatlich')));
        }
        return $hostingDomain;
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Hosting $hosting
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Hosting $hosting)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingRepository->remove($hosting);
		$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

        //$this->redirect('list');
        die;
    }
}
