<?php

namespace FRONTAL\FagBesichtigung\Controller;

/***
 *
 * This file is part of the "besichtigung" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Service\CacheService;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * EventController
 */
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * eventRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;
    /**
     * gruppentypRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\GruppentypRepository
     * @inject
     */
    protected $gruppentypRepository = null;
    /**
     * datumRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository
     * @inject
     */
    protected $datumRepository = null;

    /**
     * anfrageRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\AnfrageRepository
     * @inject
     */
    protected $anfrageRepository = null;

    /**
     * /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $events = $this->eventRepository->findAll();
        $this->view->assign('events', $events);
    }

    /**
     * action anfrage
     *
     * @return void
     */
    public function anfrageAction()
    {
        $pids = (int)$this->settings['anfragePage'];

        $this->cacheService->clearPageCache($pids);
        $gruppentyp = $this->gruppentypRepository->findAll();
        $eventid = $this->request->getArgument('event');
        $datum = $this->datumRepository->findByevent((int)$eventid);
        $event = $this->eventRepository->findByUid((int)$eventid);
        $datumFree = array();
        $datumNotfree = array();

        $max = 0;
        $maxs = array();
        foreach ($datum as $d) {
            /********************* free********************/
            if ($d->getGruppentyp()->getUid() == 1) {
                array_push($datumFree, $d);
            };

            if (count($d->getAnfrage()) == 0) {
                $max = $d->getTeilnehmerMax();
            } else {
                $somme = 0;
                foreach ($d->getAnfrage() as $max0) {
                    $somme = intval($somme) + intval($max0->getTeilnehmeraktuell());
                    // DebugUtility::debug($somme);
                }

                $max = $d->getTeilnehmerMax() - $somme;


            }

            array_push($maxs, array('uid' => $d->getUid(), 'max' => $max));


            if ($d->getGruppentyp()->getUid() == 1) {
                $date_aujourdhui = new \DateTime();
                $date = date_format($date_aujourdhui, "Y-m-d");
                $eventdate = date_format($d->getDate(), "Y-m-d");

                if($date == $eventdate) {
                    $time = date_format($date_aujourdhui, "H:i");
                    $eventtime = new \DateTime();
                    $eventtime->setTimestamp($d->getStartTime());
                    $eventtime->format("H:i");
                    $timehi = date_format($eventtime, "H:i");
                    if($time >= $timehi){
                        $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $d->getUid(), array(
                            'status' => 'Ausgebucht'
                        ));
                    }
                 }else if($date > $eventdate){
                    $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $d->getUid(), array(
                        'status' => 'Ausgebucht'
                    ));

                }
            }
            if ($max == 0) {

                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $d->getUid(), array(
                    'status' => 'Ausgebucht'
                ));
            }
            /********************* notfree********************/
            if ($d->getGruppentyp()->getUid() == 2 || $d->getGruppentyp()->getUid() == 3) {
                array_push($datumNotfree, $d);
            };

            // On compare les deux dates
            if ($d->getGruppentyp()->getUid() != 1) {

                if ($d->getDate() > $date_aujourdhui) {
                    $date = date_format($d->getDate(), "Y-m-d");
                    $datesub = date_create($date);
                    $sub = date_sub($datesub, date_interval_create_from_date_string("14 days"));
                    if ($sub < $date_aujourdhui) {
                        $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $d->getUid(), array(
                            'status' => 'Ausgebucht'
                        ));
                    }
                } else {
                    //$GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_fagcalendar_domain_model_event', 'uid=' . $eventuid);
                    $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $d->getUid(), array(
                        'status' => 'Ausgebucht'
                    ));
                }
            }


        }

        /*convert to json*/
        $jsonMax = json_encode($maxs);
        /*session is started if you don't write this line can't use $_Session  global variable*/

        if ($this->request->hasArgument('uid')) {
            $newAnfrage = $this->anfrageRepository->findHiddenByUid(
                intval($this->request->getArgument('uid'))
            );

            $this->view->assignMultiple(['newAnfrage' => $newAnfrage, 'unsuccessful' => true]);
        }

        $this->view->assignMultiple(['gruppentyp' => $gruppentyp, 'event' => $event, 'eventid' => $eventid, 'datumfree' => $datumFree, 'datumNotfree' => $datumNotfree, 'datum' => $datum, 'max' => $maxs, 'json' => $jsonMax]);
    }

    /**
     * action show
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Event $event
     * @return void
     */
    public function showAction(\FRONTAL\FagBesichtigung\Domain\Model\Event $event)
    {
        $this->view->assign('event', $event);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Event $newEvent
     * @return void
     */
    public function createAction(\FRONTAL\FagBesichtigung\Domain\Model\Event $newEvent)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->eventRepository->add($newEvent);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Event $event
     * @ignorevalidation $event
     * @return void
     */
    public function editAction(\FRONTAL\FagBesichtigung\Domain\Model\Event $event)
    {
        $this->view->assign('event', $event);
    }

    /**
     * action update
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Event $event
     * @return void
     */
    public function updateAction(\FRONTAL\FagBesichtigung\Domain\Model\Event $event)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->eventRepository->update($event);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Event $event
     * @return void
     */
    public function deleteAction(\FRONTAL\FagBesichtigung\Domain\Model\Event $event)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->eventRepository->remove($event);
        $this->redirect('list');
    }

    public function buttonAction()
    {

    }

    /**
     * action export
     *
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return void
     */
    public function exportAction()
    {

        if (!file_exists('files/export')) {
            mkdir('files/export', 511, true);
        }

        $exports = $this->datumRepository->findAll();
        $phpExcelService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('phpexcel');
        $objPHPExcel = $phpExcelService->getPHPExcel();
        foreach ($exports as $key => $event) {
            if ($key > 0) {
                $objPHPExcel->createSheet();
            }
            $objPHPExcel->setActiveSheetIndex($key);
            $objPHPExcel->getActiveSheet()->setTitle('Alle Tabellen exportieren');
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A1', 'Event Titel')
                ->setCellValue('B1', 'Datum')
                ->setCellValue('C1', 'Start Time')
                ->setCellValue('D1', 'End Time')
                ->setCellValue('E1', 'Status')
                ->setCellValue('F1', 'Teilnehmer Max')
                ->setCellValue('G1', 'Teilnehmer Aktuell')
                ->setCellValue('H1', 'Führerin')
                ->setCellValue('I1', 'Gruppentyp')
                ->setCellValue('J1', 'Preishinweis');
            $dataArray = [];
            foreach ($exports as $event) {
                if ($event->getGruppenFuhrer()) {
                    $Fuhrerin = $event->getGruppenFuhrer()->getVorname() . ', ' . $event->getGruppenFuhrer()->getNachname();
                }

                if (count($event->getAnfrage()) == 0) {
                    $max = 0;
                } else {
                    $somme = 0;
                    foreach ($event->getAnfrage() as $max0) {
                        $somme = intval($somme) + intval($max0->getTeilnehmeraktuell());
                    }

                    $max = $somme;

                }

                $rowarray = [];
                $date = date_format($event->getDate(), "Y-m-d");
                $start = date("H:i", $event->getStartTime());
                $end = date("H:i", $event->getEndTime());
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fagbesichtigung_domain_model_datum');
                $rows = $queryBuilder
                    ->select('event')
                    ->from('tx_fagbesichtigung_domain_model_datum')
                    ->Where(
                        "tx_fagbesichtigung_domain_model_datum.uid = " . $event->getUid()
                    )
                    ->andWhere(
                        "tx_fagbesichtigung_domain_model_datum.event != 0"
                    )
                    ->andWhere(
                        "tx_fagbesichtigung_domain_model_datum.deleted = 0"
                    )
                    ->andWhere(
                        "tx_fagbesichtigung_domain_model_datum.hidden = 0"
                    )
                    ->execute();
                /*DebugUtility::debug($rows->fetch());
                die();*/
                while ($r = $rows->fetch()) {
                    $e = $this->eventRepository->findByUid((int)$r['event']);
                    if (count($e) > 0) {
                        $i = $event->getGruppentyp()->getUid();
                        switch ($i) {
                            case 1:
                                $group = 'Öffentlich';
                                $preis = '';
                                break;
                            case 2:
                                $group = 'Privat';
                                $preis = $e->getPreishinweis();
                                break;

                        }
                        $rowarray['Event Titel'] = $e->getTitel();
                        $rowarray['Datum'] = $date;
                        $rowarray['StartTime'] = $start;
                        $rowarray['EndTime'] = $end;
                        $rowarray['Status'] = $event->getStatus();
                        $rowarray['Teilnehmer Max'] = $event->getTeilnehmerMax();
                        $rowarray['Teilnehmer Aktuell'] = $max;
                        $rowarray['Führerin'] = $Fuhrerin;
                        $rowarray['Gruppentyp'] = $group;
                        $rowarray['Preishinweis'] = $preis;
                        array_push($dataArray, $rowarray);
                    }
                }


            }


            $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A2');
        }
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-Disposition: attachment;filename=export.csv');
        header('Content-Transfer-Encoding: binary ');
        $excelWriter = $phpExcelService->getInstanceOf('PHPExcel_Writer_Excel2007', $objPHPExcel);
        $file = 'files/export/export_' . date('d-m-Y_H.i.s') . '.csv';
        $excelWriter->save($file);
        $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $dataHandler->start([], []);
        $dataHandler->clear_cacheCmd('all');


    }
}
