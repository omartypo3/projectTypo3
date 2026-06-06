<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;


use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * UrlaubController
 */
class UrlaubController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * urlaubRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\UrlaubRepository
     */
    protected $urlaubRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\UrlaubRepository $urlaubRepository
     */
    public function injectUrlaubRepository(\DslFactory\DslIntranet\Domain\Repository\UrlaubRepository $urlaubRepository)
    {
        $this->urlaubRepository = $urlaubRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->urlaubRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\UrlaubRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->notificationRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\NotificationRepository');
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
                case 'accept':    if ($urlaub = $this->urlaubRepository->findByUid($this->request->getArgument('uid'))) {
                    $this->acceptAction($urlaub);
                }
                    break;
                case 'refuse':    if ($urlaub = $this->urlaubRepository->findByUid($this->request->getArgument('uid'))) {
                    $this->refuseAction($urlaub);
                }
                    break;
                case 'delete':    if ($urlaub = $this->urlaubRepository->findByUid($this->request->getArgument('uid'))) {
                    $this->deleteAction($urlaub);
                }
                    break;
                case 'newForm':    $newUrlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();
                    if ($this->request->hasArgument('begin')) {
                        $begin = new \DateTime($this->request->getArgument('begin'));
                        $newUrlaub->setBegin($begin);
                        $newUrlaub->setEnd($begin);
                    }
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Urlaub/New.html', $this->request->getControllerExtensionName());
                    $mitarbeiters = $this->mitarbeiterRepository->findAll();
                    $dbView->assign('mitarbeiters', $mitarbeiters);
                    $dbView->assign('feuser', \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $newUrlaub->setMitarbeiter(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $dbView->assign('urlaub', $newUrlaub);
                    return $dbView->render();
                    break;
                case 'urlaubList':    //echo $kunde->getUid();
                    $retarray = $this->listJSONDataTable();
                    echo json_encode($retarray);
                    die;
                    break;
            }
        }
		        return json_encode(array('error' => 'Bad request!'));

     
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     */
    private function updateUrlaubFromRequest($urlaub)
    {
        if ($this->request->hasArgument('titel')) {
            $urlaub->setTitel($this->request->getArgument('titel'));
        }
        if ($this->request->hasArgument('notiz')) {
            $urlaub->setNotiz($this->request->getArgument('notiz'));
        }
        if ($this->request->hasArgument('status')) {
            if (is_array($this->request->getArgument('status'))) {
                foreach ($this->request->getArgument('status') as $status) {
                    $urlaub->setStatus((int)$status);
                }
            } else {
                $urlaub->setStatus((int)$this->request->getArgument('status'));
            }
        }
        if ($this->request->hasArgument('begin')) {
            $urlaub->setBegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('begin'))));
        }
        if ($this->request->hasArgument('end')) {
            $urlaub->setEnd(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('end'))));
        }
        if ($this->request->hasArgument('sonstiges')) {
            if ($this->request->getArgument('sonstiges')) {
                $urlaub->setSonstiges(TRUE);
            } else {
                $urlaub->setSonstiges(FALSE);
            }
        }
        if ($this->request->hasArgument('mitarbeiter')) {
            // $urlaub->setMitarbeiter($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            if (is_array($this->request->getArgument('mitarbeiter'))) {
                foreach ($this->request->getArgument('mitarbeiter') as $mitarbeiter) {
                    $urlaub->setMitarbeiter($this->mitarbeiterRepository->findByUid($mitarbeiter));
                }
            } else {
                if ($mitarbeiter = $this->mitarbeiterRepository->findByUid($this->request->getArgument('mitarbeiter'))) {
                    $urlaub->setMitarbeiter($mitarbeiter);
                }
            }
        }
        /*
                if ($this->request->hasArgument('phasen')) {
                    $auftraege->setPhasen($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
                    if (is_array($this->request->getArgument('phasen'))) {
                        foreach ($this->request->getArgument('phasen') as $phase) {
                            $auftraege->addPhasen($this->phasenRepository->findByUid($phase));
                        }
                    }
                }
                if ($this->request->hasArgument('phasenKontingent')) {
                    if (is_array($this->request->getArgument('phasenKontingent'))) {
                        $auftraege->setPhasenKontingent(serialize($this->request->getArgument('phasenKontingent')));
                    } else {
                        $auftraege->setPhasenKontingent(serialize(array()));
                    }
                }
                if ($this->request->hasArgument('kontingent')) {
                    $auftraege->setKontingent($this->request->getArgument('kontingent'));
                }
        */

        return $urlaub;
    }

    /**
     * action listjson
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listjsonAction(): \Psr\Http\Message\ResponseInterface
    {
        //die;
        $termineArr = $this->getTermineArr();
        //return array(1,2);
        //		$this->request->getArguments('start');
        //		$this->request->getArguments('end');
        //		echo print_r($this->request->getArguments(),1);
        //return $termineArr;
        echo json_encode($termineArr);
        die;
        return $this->htmlResponse();
    }
/**
 * @return array
 */
    protected function listJSONDataTable()
    {
        $data = array();
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Urlaub/ListJSONDataTable.html', $this->request->getControllerExtensionName());
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

        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $dbView->assign('feuser', $mitarbeiter);
        $settings = $mitarbeiter->getSettings();
        if (!is_array($settings)){
            $array = json_decode($settings, true);
        }
//print_r($_GET['jahr']);
        if (isset($_GET['jahr'])) {
			$array['jahr'] = intval($_GET['jahr']);
        } else {
            $jahr = new \DateTime();
			$array['jahr'] = $jahr->format('Y');
        }

		$settings = json_encode($array);

        $urlaubsAnzahlFiltered = count($this->urlaubRepository->findByFilter($settings));
        $urlaubs = $this->urlaubRepository->findByJahr($array['jahr']);
        $urlaubsAnzahl = $this->urlaubRepository->findByFilter($settings, false, false, $order, $search);

        $urlaubsTageArr = array();
        foreach ($urlaubs as $urlaub) {

            $urlaub->setArbeitstageFuerJahr($array['jahr']);
        }


        //print_r($urlaubsAnzahlFiltered);
        foreach ($urlaubs as $urlaub) {
            $dbView->assign('urlaub', $urlaub);
            $data[] = explode('<--break-->', $dbView->render());
        }
        $retarray = array(
            'draw' => $_GET['draw'],
            'recordsTotal' => $urlaubsAnzahlFiltered,
            'recordsFiltered' => count($urlaubsAnzahl),
            'data' => $data
        );

        return $retarray;
    }

    private function getTermineArr()
    {
        $now = new \DateTime();
        $jahr = date('Y', $now->getTimestamp());
        if ($this->request) {
            if ($this->request->hasArgument('jahr')) {
                $jahr = intval($this->request->getArgument('jahr'));
            }
        }
        //$jahr=2017;
        $urlaubs = $this->urlaubRepository->findByJahr($jahr);
        //		print_r($this->aufgabenRepository->getStoragePageIds());
        //return array();
        $termineArr = array();
        foreach ($urlaubs as $urlaub) {
            if ($urlaubArr = $this->getFullcalendarEvent($urlaub)) {
                $termineArr[] = $urlaubArr;
            }
        }
        /*
        Manueller Testeintrag
        $termineArr[]=array(
        	"id"=>457,
        	"title"=>"Zwangsurlaub2",
        	"mitarbeiterId"=>6,
        	"mitarbeiterInitialien"=>"JL",
        	"mitarbeiterName"=>"Jana Lang",
        	"status"=>20,


        	'start' => '2016-12-24T00:00:00',
        	'end' => '2017-01-07T00:00:00',
        	'allDay' => true
        );
        */

        //$feiertageArr = $this->getFeiertage($jahr);
        $feiertage = \DslFactory\DslIntranet\Utility\FeiertageUtility::init();
        $feiertageArr = $feiertage->getFeiertageFuerJahr($jahr);
        foreach ($feiertageArr as $datum => $title) {
            $termineArr[] = array('title' => $title, 'start' => $datum . 'T00:00:00', 'allDay' => true);
        }
        return $termineArr;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     */
    private function getFullcalendarEvent(\DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub)
    {
        if ($urlaub->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $urlaub->getMitarbeiter()->_loadRealInstance();
        }

        $begin = $urlaub->getBegin()->format('Y-m-d');
        if ($urlaub->getBegin()->format('H:i:s') != '00:00:00') {
            $begin .= 'T' . $urlaub->getBegin()->format('H:i:s');
        }
        $eventArr = array(
            'id' => $urlaub->getUid(),
            'title' => $urlaub->getTitel(),
            'mitarbeiterId' => $urlaub->getMitarbeiter()->getUid(),
            'mitarbeiterInitialien' => $urlaub->getMitarbeiter()->getInitialien(),
            'mitarbeiterName' => $urlaub->getMitarbeiter()->getName(),
            'status' => $urlaub->getStatus(),
            'start' => $begin,
            'end' => $urlaub->getEnd()->format('Y-m-d') . 'T23:00:00'
        );
        return $eventArr;
    }

    /**
     * action refuse
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function refuseAction(\DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub): \Psr\Http\Message\ResponseInterface
    {
        $urlaub->setStatus(30);
        $this->urlaubRepository->update($urlaub);
        if ($urlaub->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $urlaub->getMitarbeiter()->_loadRealInstance();
        }
        if ($urlaub->getBegin() != $urlaub->getEnd()) {
            $zeitraum = $urlaub->getBegin()->format('d.m.Y') . ' - ' . $urlaub->getEnd()->format('d.m.Y');
        } else {
            $zeitraum = $urlaub->getBegin()->format('d.m.Y');
        }
        $notificationMitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Notification();
        $notificationMitarbeiter->setUrlaub($urlaub);
        $notificationMitarbeiter->setArt(110, $urlaub->getTitel(), $urlaub->getNotiz(), $zeitraum, $urlaub->getStatus());
        //$notificationMitarbeiter->setMitarbeiter($urlaub->getMitarbeiter());
        if ($notificationMitarbeiter->forOtherUser()) {
            $this->notificationRepository->add($notificationMitarbeiter);
        }
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        foreach ($mitarbeiters as $mitarbeiter) {
            if ($mitarbeiter->getRechteUrlaubsManager()) {
                $notificationUrlaubsManager = clone $notificationMitarbeiter;
                $notificationUrlaubsManager->resetUid();
                //$notificationUrlaubsManager->setMitarbeiter($mitarbeiter);
                if ($notificationUrlaubsManager->forOtherUser()) {
                    $this->notificationRepository->add($notificationUrlaubsManager);
                }
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        die;
        return $this->htmlResponse();
    }

    /**
     * action accept
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     * @return void
     */
    public function acceptAction(\DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub)
    {
        if ($urlaub->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $urlaub->getMitarbeiter()->_loadRealInstance();
        }
        $urlaub->setStatus(20);
        $this->urlaubRepository->update($urlaub);
        if ($urlaub->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $urlaub->getMitarbeiter()->_loadRealInstance();
        }
        if ($urlaub->getBegin() != $urlaub->getEnd()) {
            $zeitraum = $urlaub->getBegin()->format('d.m.Y') . ' - ' . $urlaub->getEnd()->format('d.m.Y');
        } else {
            $zeitraum = $urlaub->getBegin()->format('d.m.Y');
        }
        $notificationMitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Notification();
        $notificationMitarbeiter->setUrlaub($urlaub);
        $notificationMitarbeiter->setArt(110, $urlaub->getTitel(), $urlaub->getNotiz(), $zeitraum, $urlaub->getStatus());
        //$notificationMitarbeiter->setMitarbeiter($urlaub->getMitarbeiter());
        if ($notificationMitarbeiter->forOtherUser()) {
            $this->notificationRepository->add($notificationMitarbeiter);
        }
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        foreach ($mitarbeiters as $mitarbeiter) {
            if ($mitarbeiter->getRechteUrlaubsManager()) {
                $notificationUrlaubsManager = clone $notificationMitarbeiter;
                $notificationUrlaubsManager->resetUid();
                $notificationUrlaubsManager->setMitarbeiter($mitarbeiter);
                if ($notificationUrlaubsManager->forOtherUser()) {
                    $this->notificationRepository->add($notificationUrlaubsManager);
                }
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        die;
    }

    /**
     * action import
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function importAction(): \Psr\Http\Message\ResponseInterface
    {
        $file = 'W:/xampp/htdocs/server/dsl_intranet/export_urlaub.json';
        $file = '/var/www/kd/dsl-factory.de/intern/export_urlaub.json';
        $resultarray = array();
        $resultarray['datei'] = $file;
        $resultarray['dateidatum'] = date('d.m.Y H:i:s', filemtime($file)) . ' Uhr';
        $resultarray['dateigröße'] = filesize($file) . ' Bytes';
        $importArr = json_decode(file_get_contents($file));
        $importUsers = $importArr->fe_users;
        $importUrlaubs = $importArr->dsl_urlaub;
        $counter = 0;
        foreach ($importUrlaubs->items as $importUrlaub) {
            //  echo '!!!!!!!!!!!!!<hr>';
            $counter++;
            //echo $counter;
            $resultarray[] = $importUrlaub[$importUrlaubs->index->dsl_urlaub_bemerkung];
            if ($urlaubs = $this->urlaubRepository->findByOldid($importUrlaub[$importUrlaubs->index->dsl_urlaub_id])) {
                $urlaubs = $this->updateUrlaubsImport($urlaubs, $importUrlaub, $importUrlaubs->index, $importUsers);
                $this->urlaubRepository->update($urlaubs);
            } else {
                $urlaubs = new \DslFactory\DslIntranet\Domain\Model\Urlaub();
                $urlaubs = $this->updateUrlaubsImport($urlaubs, $importUrlaub, $importUrlaubs->index, $importUsers);
                $this->urlaubRepository->add($urlaubs);
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        /*
        Leeren!!
        SELECT * FROM tx_dslintranet_domain_model_auftraege WHERE oldid

        DELETE FROM tx_dslintranet_domain_model_auftraege WHERE oldid
        */

        $this->view->assign('resultarray', $resultarray);
        // echo "drei";
        echo $this->view->render();
        die;
        return $this->htmlResponse();
    }

    /**
     * @param $urlaubs
     * @param $importAuftrag $importUrlaub
     * @param $index
     * @param $importUsers
     */
    public function updateUrlaubsImport($urlaubs, $importUrlaub, $index, $importUsers)
    {
        //dsl_urlaub_fe_user_uid
        $urlaubs->setTitel($importUrlaub[$index->dsl_urlaub_bemerkung]);
        $urlaubs->setOldid($importUrlaub[$index->dsl_urlaub_id]);
        $urlaubs->setStatus(20);
        $urlaubs->setBegin(new \DateTime($importUrlaub[$index->dsl_urlaub_von]));
        $urlaubs->setEnd(new \DateTime($importUrlaub[$index->dsl_urlaub_bis]));
        $user = $importUsers->items->{$importUrlaub[$index->dsl_urlaub_fe_user_uid]};
        if ($mitarbeiter = $this->mitarbeiterRepository->findByInitialien($user[$importUsers->index->title])) {
            //echo "MITARBEITER GEFUNDEN!!!";
            $urlaubs->setMitarbeiter($mitarbeiter);
        }
        //echo 'Z6';
        return $urlaubs;
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
        $now = new \DateTime();
        $jahr = false;
        $monateArr = array();
        if ($this->request->hasArgument('jahr')) {
            $jahr = intval($this->request->getArgument('jahr'));
        }
        if (!$jahr) {
            $jahr = $now->format('Y');
        }
        $feiertage = \DslFactory\DslIntranet\Utility\FeiertageUtility::init();
        $feiertageArr = $feiertage->getFeiertageFuerJahr($jahr);
        /*?><pre><?php print_r($feiertageArr);?></pre><?php die;*/

        $ferientage = \DslFactory\DslIntranet\Utility\FerienUtility::init();
        $ferientageArr = $ferientage->getFerienFuerJahr($jahr);
        /*?><pre><?php print_r($ferientageArr);?></pre><?php die;*/

        //$jahr=2017;
        $monateArr = array();
        for ($x = 1; $x <= 12; $x++) {
            $monateArr[$x] = array();
            $firstDayOfMonth = new \DateTime($jahr . '-' . str_pad((string)$x, 2, '0', STR_PAD_LEFT) . '-01');
            $filledDay = false;
            while ($firstDayOfMonth->format('w') != 1 || !$filledDay) {
                //solange der wochentag kein montag ist zurückzählen
                $filledDay = true;
                date_sub($firstDayOfMonth, date_interval_create_from_date_string('1 day'));
            }
            for ($y = 0; $y < 6; $y++) {
                for ($d = 0; $d < 7; $d++) {
                    if (intval($firstDayOfMonth->format('m')) != $x) {
                        $filledDay = true;
                    } else {
                        $filledDay = false;
                    }
                    if ($d == 6 || $d == 5) {
                        $weekendDay = true;
                    } else {
                        $weekendDay = false;
                    }
                    if (isset($feiertageArr[$firstDayOfMonth->format('Y-m-d')])) {
                        $feiertag = $feiertageArr[$firstDayOfMonth->format('Y-m-d')];
                    } else {
                        $feiertag = false;
                    }

                    if (isset($ferientageArr[$firstDayOfMonth->format('Y-m-d')])) {
                        $ferientag = $ferientageArr[$firstDayOfMonth->format('Y-m-d')];
                    } else {
                        $ferientag = false;
                    }

                    if ($now->format('Y-m-d') == $firstDayOfMonth->format('Y-m-d')) {
                        $today = true;
                    } else {
                        $today = false;
                    }
                    $monateArr[$x][$firstDayOfMonth->format('W')][$firstDayOfMonth->format('w')] = array(
                        'datum' => clone $firstDayOfMonth,
                        'termine' => array(),
                        'filledDay' => $filledDay,
                        'feiertag' => $feiertag,
                        'ferientag' => $ferientag,
                        'weekendDay' => $weekendDay,
                        'today' => $today
                    );
                    date_add($firstDayOfMonth, date_interval_create_from_date_string('1 day'));
                }
            }
        }
        $this->view->assign('jahr', $jahr);
        $this->view->assign('jahrPrev', $jahr - 1);
        $this->view->assign('jahrNext', $jahr + 1);
        /*?><pre><?php print_r($feiertageArr);?></pre><?php die;*/
        $settings = array('jahr' => $jahr);
        $urlaubs = $this->urlaubRepository->findByFilter($settings);
        $urlaubsArr = array();
        foreach ($urlaubs as $urlaub) {
            $datum = clone $urlaub->getBegin();
            while ($datum <= $urlaub->getEnd()) {
                if ($datum->format('Y') == $jahr) {
                    if (!$feiertageArr[$datum->format('Y-m-d')]) {
                        if ($urlaub->getStatus() < 30) {
                            if (!$monateArr[$datum->format('n')][$datum->format('W')][$datum->format('w')]['weekendDay']) {
                                if (!$monateArr[$datum->format('n')][$datum->format('W')][$datum->format('w')]['termine'][$urlaub->getStatus()]) {
                                    $monateArr[$datum->format('n')][$datum->format('W')][$datum->format('w')]['termine'][$urlaub->getStatus()] = array();
                                }
                                $monateArr[$datum->format('n')][$datum->format('W')][$datum->format('w')]['termine'][$urlaub->getStatus()][] = $urlaub;
                            }
                        }
                    }
                }
                date_add($datum, date_interval_create_from_date_string('1 day'));
            }
        }
        //echo count($urlaubs);die;
        $urlaubsTageArr = array();
        foreach ($urlaubs as $urlaub) {
            if ($urlaub->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                $urlaub->getMitarbeiter()->_loadRealInstance();
            }
			 //\TYPO3\CMS\Core\Utility\DebugUtility::debug($settings['jahr']);

            $urlaub->setArbeitstageFuerJahr((int)$settings['jahr']);
            if ($urlaub->getMitarbeiter()) {
                if (!isset($urlaubsTageArr[$urlaub->getMitarbeiter()->getUid()])) {
                    $urlaubsTageArr[$urlaub->getMitarbeiter()->getUid()] = 0;
                }
                if ($urlaub->getStatus() < 30 && !$urlaub->getSonstiges()) {
                    $urlaubsTageArr[$urlaub->getMitarbeiter()->getUid()] += $urlaub->getArbeitstage();
                }
            }
        }
        /*?><pre><?php print_r($urlaubsTageArr);?></pre><?php */
        $this->view->assign('urlaubsTageArr', $urlaubsTageArr);
        $this->view->assign('monate', $monateArr);
        /* ?><pre><?php print_r($monateArr);?></pre><?php  */
        //	die;
        $urlaubs = $this->urlaubRepository->findAll();
//        	DebugUtility::debug($urlaubs);
//        ?><!--<pre>--><?php //print_r($urlaubs); ?><!--</pre>--><?php
//        	die;
//        		echo count($urlaubs);
//        		exit;
        $this->view->assign('urlaubs', $urlaubs);
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $this->view->assign('mitarbeiters', $mitarbeiters);
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $this->view->assign('user', $user);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub): \Psr\Http\Message\ResponseInterface
    {
        $mitarbeiter = $this->mitarbeiterRepository->findByUid($this->request->getArgument('mitarbeiter'));
        $this->view->assign('mitarbeiter', $mitarbeiter);
        $this->view->assign('jahr', $this->request->getArgument('jahr'));
        $urlaubs = $this->urlaubRepository->findByFilter(array('jahr' => $this->request->getArgument('jahr'), 'mitarbeiter' => $mitarbeiter), false, false, array(array('column' => 4, 'dir' => 'asc')));
        //, 'status' => 20
        //$jahrBegin = new \DateTime("01.01.".$this->request->getArgument('jahr'));
        //$jahrEnd = new \DateTime("31.12.".$this->request->getArgument('jahr'));
        foreach ($urlaubs as $urlaub) {
            //	if($jahrBegin > $urlaub->getBegin()) $urlaub->setBegin(new \DateTime("01.01.".$this->request->getArgument('jahr')));
            //	if($jahrEnd < $urlaub->getEnd()) $urlaub->setEnd(new \DateTime("31.12.".$this->request->getArgument('jahr')));
            $urlaub->setArbeitstageFuerJahr($this->request->getArgument('jahr'));
        }
        $this->view->assign('urlaubs', $urlaubs);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $newUrlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();
        //$newAuftraege->setTitel('neu / vorbelegung');
        $newUrlaub->setBegin(new \DateTime());
        $newUrlaub->setEnd(new \DateTime());
        $this->view->assign('urlaub', $newUrlaub);
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $this->view->assign('mitarbeiters', $mitarbeiters);
        /*        $this->view->assign('prioritaets', $this->getPrioritaets());
                  //$this->view->assign('statuss', $this->getStatuss());
                  $this->view->assign('pers', $this->getPers());
                  $mitarbeiters = $this->mitarbeiterRepository->findAll();
                  $this->view->assign('mitarbeiters', $mitarbeiters);
                  $kundens = $this->kundenRepository->getActive();
                  $this->view->assign('kundens', $kundens);
                  $auftragsartens = $this->auftragsartenRepository->findAll();
                  $this->view->assign('auftragsartens', $auftragsartens);
                  $phasens = $this->phasenRepository->findAll();
                  $this->view->assign('phasens', $phasens);*/

        $this->view->assign('feuser', \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        return $this->htmlResponse();
    }

    /**
     * action create
     * 
     * @return void
     */
    public function createAction()
    {
        $urlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();
        $urlaub->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        $urlaub = $this->updateUrlaubFromRequest($urlaub);
        //wenn ein nicht admin es eingetragen hat
        if (!$urlaub->getMitarbeiter()) {
            $urlaub->setMitarbeiter(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        }
        if (!$urlaub->getStatus()) {
            $urlaub->setStatus(10);
        }
        if ($urlaub->getBegin() != $urlaub->getEnd()) {
            $zeitraum = $urlaub->getBegin()->format('d.m.Y') . ' - ' . $urlaub->getEnd()->format('d.m.Y');
        } else {
            $zeitraum = $urlaub->getBegin()->format('d.m.Y');
        }
        $notificationMitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Notification();
        $notificationMitarbeiter->setUrlaub($urlaub);
        $notificationMitarbeiter->setArt(100, $urlaub->getTitel(), $urlaub->getNotiz(), $zeitraum, $urlaub->getStatus());
        $notificationMitarbeiter->setMitarbeiter($urlaub->getMitarbeiter());
        if ($notificationMitarbeiter->forOtherUser()) {
            $this->notificationRepository->add($notificationMitarbeiter);
        }
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        foreach ($mitarbeiters as $mitarbeiter) {
            if ($mitarbeiter->getRechteUrlaubsManager()) {
                $notificationUrlaubsManager = clone $notificationMitarbeiter;
                $notificationUrlaubsManager->resetUid();
                $notificationUrlaubsManager->setMitarbeiter($mitarbeiter);
                if ($notificationUrlaubsManager->forOtherUser()) {
                    $this->notificationRepository->add($notificationUrlaubsManager);
                }
            }
        }
        //$this->checkRechteUrlaubEdit($urlaub);
        $this->urlaubRepository->add($urlaub);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        /*  if ($eventArr = $this->getFullcalendarEvent($urlaub)) {
            echo json_encode($eventArr);
            }*/

        echo json_encode(array('newUid' => $urlaub->getUid()));
        die;
		//$this->redirect('list');

    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("urlaub")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('feuser', \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $this->view->assign('mitarbeiters', $mitarbeiters);
        $this->view->assign('urlaub', $urlaub);
        return $this->htmlResponse();
    }

    /**
     * @param $urlaub
     */
    private function checkRechteUrlaubEdit($urlaub)
    {
        if (!$urlaub->getRechteUrlaubEdit()) {
            header('HTTP/1.1 400 Bad Request');
            die;
        }
    }

    /**
     * action update
     *
     * @return void
     */
    public function updateAction()
    {
        /*$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->urlaubRepository->update($urlaub);
        $this->redirect('list');*/

        if ($this->request->hasArgument('urlaub')) {
			
            $urlaub = $this->urlaubRepository->findByUid($this->request->getArgument('urlaub')['__identity']);
            if ($urlaub->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                $urlaub->getMitarbeiter()->_loadRealInstance();
            }

            $urlaub = $this->updateUrlaubFromRequest($urlaub);
            $this->checkRechteUrlaubEdit($urlaub);
            $this->urlaubRepository->update($urlaub);
            if ($urlaub->getBegin() != $urlaub->getEnd()) {
                $zeitraum = $urlaub->getBegin()->format('d.m.Y') . ' - ' . $urlaub->getEnd()->format('d.m.Y');
            } else {
                $zeitraum = $urlaub->getBegin()->format('d.m.Y');
            }
            $notificationMitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Notification();
            $notificationMitarbeiter->setUrlaub($urlaub);
            $notificationMitarbeiter->setArt(110, $urlaub->getTitel(), $urlaub->getNotiz(), $zeitraum, $urlaub->getStatus());
            $notificationMitarbeiter->setMitarbeiter($urlaub->getMitarbeiter());
            if ($notificationMitarbeiter->forOtherUser()) {
                $this->notificationRepository->add($notificationMitarbeiter);
            }
            $mitarbeiters = $this->mitarbeiterRepository->findAll();
            foreach ($mitarbeiters as $mitarbeiter) {
                if ($mitarbeiter->getRechteUrlaubsManager()) {
                    $notificationUrlaubsManager = clone $notificationMitarbeiter;
                    $notificationUrlaubsManager->resetUid();
                    $notificationUrlaubsManager->setMitarbeiter($mitarbeiter);
                    if ($notificationUrlaubsManager->forOtherUser()) {
                        $this->notificationRepository->add($notificationUrlaubsManager);
                    }
                }
            }
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            if ($urlaubArr = $this->getFullcalendarEvent($urlaub)) {
                echo json_encode(array_merge($urlaubArr, array('foo' => 'bar', 'args' => $this->request->getArguments())));
            }
        }
        die;
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->urlaubRepository->remove($urlaub);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
		die();
    }
}
