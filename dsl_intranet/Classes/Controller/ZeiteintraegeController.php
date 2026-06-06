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
 * ZeiteintraegeController
 */
class ZeiteintraegeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * zeiteintraegeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeRepository
     */
    protected $zeiteintraegeRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeRepository $zeiteintraegeRepository
     */
    public function injectZeiteintraegeRepository(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeRepository $zeiteintraegeRepository)
    {
        $this->zeiteintraegeRepository = $zeiteintraegeRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $this->zeiteintraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ZeiteintraegeRepository');
        $this->zeiteintraegeSegmenteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ZeiteintraegeSegmenteRepository');
        $this->trackerSegmenteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\TrackerSegmenteRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->phasenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\PhasenRepository');
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
                /*Zeiteintragshandling*/
                case 'toggleSichtbarkeit':    if ($this->request->hasArgument('uid')) {
                    if ($zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        $zeiteintraege->toggleSichtbarkeit();
                        $this->zeiteintraegeRepository->update($zeiteintraege);
                        echo $zeiteintraege->getSichtbarkeit();
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        die;
                        break;
                    }
                }
                    break;
                case 'delete':    if ($this->request->hasArgument('uid')) {
                    if ($zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($zeiteintraege);
                    }
                }
                    break;
                case 'deleteTracker':    if ($this->request->hasArgument('uid')) {
                    $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'));
                    $tracker = $this->zeiteintraegeRepository->findOpened($mitarbeiter, $auftraege);
					
                    $this->deleteAction($tracker);
                }
                    break;
                case 'update':    $zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('zeiteintraege'));
                    $zeiteintraege = $this->updateZeiteintragFromRequest($zeiteintraege);
                    $zeiteintraege->setZeitnahme(0);
                    //$zeiteintraege->setZeitnahmeBegin(new \DateTime());

                    $this->zeiteintraegeRepository->update($zeiteintraege);

                    $zeiteintraege->getAuftraege()->setKontingentUsedCached(0); $zeiteintraege->getAuftraege()->getKontingentUsed();

                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('auftraegeUid' => $zeiteintraege->getAuftraege()->getUid(), 'uid' => $zeiteintraege->getUid()));
                    //, 'contentList' => $this->getPartialsListRow($zeiteintraege)
                    die;
                    break;
                case 'create':    if ($this->request->hasArgument('auftraege')) {
                    $newZeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
                    $newZeiteintraege->setPid((int)$this->settings['zeiteintraegePid']);
                    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
                    $auftraege->addZeiten($newZeiteintraege);
                    //Ersteller für den Zeiteintrag ermitteln
                    $newZeiteintraege->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $newZeiteintraege = $this->updateZeiteintragFromRequest($newZeiteintraege);
                    $this->zeiteintraegeRepository->add($newZeiteintraege);

                    $auftraege->setKontingentUsedCached(0);$auftraege->getKontingentUsed();

                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('auftraegeUid' => $auftraege->getUid()));
                    //, 'content' => $this->getPartialsList($auftraege)
                    die;
                }
                    echo json_encode(array('content___' => print_r($this->request->getArguments(), 1)));
                    die;
                    break;
            }
        }
        header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
        //return $this->htmlResponse();
    }

    /**
     * @param $uid
     */
    private function getZeiteintragCounter()
    {

    }

    /**
     * @param $auftraege
     */
    private function updateZeiteintragFromRequest($zeiteintraege)
    {
        //print_r($this->request->getArguments());

        if ($this->request->hasArgument('sichtbarkeit')) {
			if($this->request->getArgument('sichtbarkeit') == '1'){
                $zeiteintraege->setSichtbarkeit(TRUE);
            }else{
                $zeiteintraege->setSichtbarkeit(FALSE);
            }
        }
        if ($zeiteintraege->getBegin()) {
            if (!$zeiteintraege->getEnd()) {
                //muss ein tracker sein also beenden
                $lastTrackerSegmente = $zeiteintraege->getLastTrackerSegmente();
                if ($zeiteintraege->getZeitnahme()) {
                    //tracker läuft gerade
                    $lastTrackerSegmente->setEnd(new \DateTime(date('Y-m-d H:i:s')));
                    $this->trackerSegmenteRepository->update($lastTrackerSegmente);
                }
                //echo '<br>tracker enddatum auf zeiteintrag übernommen';
                $zeiteintraege->setEnd($lastTrackerSegmente->getEnd());
                $zeiteintraege->setZeitnahme(0);
            }
        } else {

        }
        if ($this->request->hasArgument('phasenKontingent')) {
            //echo '<br>Phasen setzen';
            $segmente = $zeiteintraege->getSegmente()->toArray();
            foreach ($segmente as $segment) {
                $zeiteintraege->removeSegmente($segment);
            }
            //$zeiteintraege->setSegmente($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            if (is_array($this->request->getArgument('phasenKontingent'))) {
                foreach ($this->request->getArgument('phasenKontingent') as $phase => $minuten) {
                    if ($minuten) {
                        $segment = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();
                        $segment->setMinuten((int)$minuten);
                        if ($phase) {
                            $segment->setPhase($this->phasenRepository->findByUid($phase));
                        }
                        $this->zeiteintraegeSegmenteRepository->add($segment);
                        $zeiteintraege->addSegmente($segment);
                    }
                }
            }
        }
        //echo "<br>www";
        // die;
        if ($this->request->hasArgument('text')) {
            $zeiteintraege->setText($this->request->getArgument('text'));
        }
        if ($this->request->hasArgument('phase')) {
            $zeiteintraege->clearPhase();
            //print_r($this->request->getArgument('phase'));
            //die;
            if (is_array($this->request->getArgument('phase'))) {
                $phaseArr = $this->request->getArgument('phase');
                if (isset($phaseArr[__identity])) {
                    if ($phaseArr[__identity][0]) {
                        $zeiteintraege->setPhase($this->phasenRepository->findByUid($phaseArr[__identity][0]));
                    }
                } else {
                    if ($phaseArr[0]) {
                        $zeiteintraege->setPhase($this->phasenRepository->findByUid($phaseArr[0]));
                    }
                }
            } else {
                $phase = $this->request->getArgument('phase');
                if ($phase) {
                    $zeiteintraege->setPhase($this->phasenRepository->findByUid($phase));
                }
            }
        }
        if ($this->request->hasArgument('kontingent')) {
            $zeiteintraege->setKontingent((int)$this->request->getArgument('kontingent'));
        }


        if ($this->request->hasArgument('kontingentMehraufwand')) {
            if($this->request->getArgument('kontingentMehraufwand') == ''){
                $zeiteintraege->setKontingentMehraufwand(0);
            }else{
                $zeiteintraege->setKontingentMehraufwand($this->request->getArgument('kontingentMehraufwand'));
            }
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
        //if( $zeiteintraege->getEnd()->getTimestamp() < $zeiteintraege->getBegin()->getTimestamp() ){//Anfang und Ende drehen
        /*	$tmpBegin = $zeiteintraege->getBegin();
           $tmpEnd = $zeiteintraege->getEnd();
           $zeiteintraege->setBegin($tmpBegin);
           $zeiteintraege->setEnd($tmpEnd);*/

        //}
        //		$zeiteintraege->setText('abcdeft:'.$this->request->getArgument('begin'));



        return $zeiteintraege;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function getPartialsList(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege)
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Zeiteintraege/ListAjax.html', $this->request->getControllerExtensionName());
        $dbView->assignMultiple(array('auftraege' => $auftraege));
        return $dbView->render();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     */
    public function getPartialsListRow(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege)
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Zeiteintraege/ListItemAjax.html', $this->request->getControllerExtensionName());
        $dbView->assignMultiple(array('zeiteintraege' => $zeiteintraege));
        return $dbView->render();
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
        $zeiteintraeges = $this->zeiteintraegeRepository->findAll();
        $this->view->assign('zeiteintraeges', $zeiteintraeges);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('zeiteintraege', $zeiteintraege);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $newZeiteintraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("newZeiteintraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $newZeiteintraege = NULL): \Psr\Http\Message\ResponseInterface
    {
        $user = $GLOBALS['TSFE']->fe_user->user;
        $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
        $begin = false;
        if ($zeiteintraegeLast = $this->zeiteintraegeRepository->findLast($mitarbeiter)) {
            if (date('Y-m-d') == date('Y-m-d', $zeiteintraegeLast->getEnd()->getTimestamp())) {
                $begin = $zeiteintraegeLast->getEnd();
            }
        }
        if (!$begin) {
            $begin = new \DateTime(date('Y-m-d H:i:s', mktime(0, 0, 0, (int)date('m'), (int)date('d'), (int)date('Y')) + $mitarbeiter->getArbeitsbegin()));
        }
		
        //$this->view->assign('newZeiteintraege', $newZeiteintraege);
        $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
        //echo $auftraege->getUid();
        $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        //$zeiteintraege->setText($mitarbeiter->getArbeitsbegin());
        //$zeiteintraege->setText($settings['defaultMitarbeiterArbeitsbegin']);
        //$zeiteintraege->setText($debugtext);
        //		$zeiteintraege->setBegin(new \DateTime(date('Y-m-d H:i:s', time() - 1800)));
        $zeiteintraege->setBegin($begin);
        //hier das letzte ende oder den tagesbegin eintragen
        $zeiteintraege->setEnd(new \DateTime());
        $zeiteintraege->setKontingent((int)ceil(($zeiteintraege->getEnd()->getTimestamp() - $zeiteintraege->getBegin()->getTimestamp()) / 60));
        $this->view->assign('zeiteintraege', $zeiteintraege);
        //wenn phasen im Auftrag editiert wurden nur diese für die Zeiteinträge bereitstellen
        /*
        $phasenTmpArr = array();
        $phasensAll = $this->phasenRepository->findAll();
                if (count($auftraege->getPhasen())) {
                    $phasens = $auftraege->getPhasen();
                } else {
                    $phasens = $this->phasenRepository->findAll();
                }
                $phasenArr = array('keine Auswahl');
                foreach ($phasens as $phase) {
                    $phasenArr[$phase->getUid()] = $phase->getTitel();
                }
                $phasenIconArr = array('fa fa-fw fa-exclamation-circle');
                foreach ($phasensAll as $phase) {
                    if (isset($phasenArr[$phase->getUid()])) {
                        $phasenIconArr[$phase->getUid()] = $phase->getIcon();
                    }
                }
        */

        $phasenTmpArr = array();
        $phasensAll = $this->phasenRepository->findAll();
        //$auftraege = $zeiteintraege->getAuftraege();
        //wenn phasen im Auftrag editiert wurden nur diese für die Zeiteinträge bereitstellen
        if ($auftraege->getPhasen()) {
            foreach ($auftraege->getPhasen() as $phase) {
                $phasenTmpArr[$phase->getUid()] = true;
            }
        } else {
            foreach ($phasensAll as $phase) {
                $phasenTmpArr[$phase->getUid()] = true;
            }
        }
        $phasenArr = array('Sonstige Arbeiten');
        foreach ($phasensAll as $phase) {
            if (isset($phasenTmpArr[$phase->getUid()])) {
                $phasenArr[$phase->getUid()] = $phase->getTitel();
            }
        }
        $phasenIconArr = array('fa fa-fw fa-exclamation-circle');
        foreach ($phasensAll as $phase) {
            if (isset($phasenTmpArr[$phase->getUid()])) {
                $phasenIconArr[$phase->getUid()] = $phase->getIcon();
            }
        }
        $this->view->assign('phaseSelected', 0);
        $this->view->assign('auftraege', $auftraege);
        $this->view->assign('phasens', $phasenArr);
        $this->view->assign('phasenIcons', $phasenIconArr);
        echo $this->view->render();
        die;
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $newZeiteintraege
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $newZeiteintraege)
    {
        /*$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zeiteintraegeRepository->add($newZeiteintraege);
        $this->redirect('list');*/
        die;
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("zeiteintraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege): \Psr\Http\Message\ResponseInterface
    {
        if (!$zeiteintraege->getEnd()) {
            if ($zeiteintraege->getZeitnahme()) {
                $zeiteintraege->setEnd(new \DateTime());
            } else {
                $zeiteintraege->setEnd($zeiteintraege->getLastTrackerSegmente()->getEnd());
            }
        }
        /*$counter = false;
          if ($this->request->hasArgument('counter')) {
          $this->view->assign('counter', true);
          }*/

        $this->view->assign('zeiteintraege', $zeiteintraege);
        $phasenTmpArr = array();
        $phasensAll = $this->phasenRepository->findAll();
        $auftraege = $zeiteintraege->getAuftraege();
        //wenn phasen im Auftrag editiert wurden nur diese für die Zeiteinträge bereitstellen
        if ($auftraege->getPhasen()) {
            foreach ($auftraege->getPhasen() as $phase) {
                $phasenTmpArr[$phase->getUid()] = true;
            }
            if ($zeiteintraege->getSegmente()) {
                foreach ($zeiteintraege->getSegmente() as $segment) {
                    if ($segment->getPhase()) {
                        $phasenTmpArr[$segment->getPhase()->getUid()] = true;
                    }
                }
            }
        } else {
            foreach ($phasensAll as $phase) {
                $phasenTmpArr[$phase->getUid()] = true;
            }
        }
        $phasenArr = array('Sonstige Arbeiten');
        foreach ($phasensAll as $phase) {
            if (isset($phasenTmpArr[$phase->getUid()])) {
                $phasenArr[$phase->getUid()] = $phase->getTitel();
            }
        }
        $phasenIconArr = array('fa fa-fw fa-exclamation-circle');
        foreach ($phasensAll as $phase) {
            if (isset($phasenTmpArr[$phase->getUid()])) {
                $phasenIconArr[$phase->getUid()] = $phase->getIcon();
            }
        }
        $phasenKontingent = array();
        $phasenStunden = array();
        $phasenMinuten = array();
        if ($zeiteintraege->getSegmente()) {
            foreach ($zeiteintraege->getSegmente() as $segment) {
                $kontingent = $segment->getMinuten();
                $stunden = floor($kontingent / 60);
                $minuten = $kontingent - $stunden * 60;
                if ($segment->getPhase()) {
                    $phasenKontingent[$segment->getPhase()->getUid()] = $kontingent;
                    $phasenStunden[$segment->getPhase()->getUid()] = $stunden;
                    $phasenMinuten[$segment->getPhase()->getUid()] = $minuten;
                } else {
                    $phasenKontingent[0] = $kontingent;
                    $phasenStunden[0] = $stunden;
                    $phasenMinuten[0] = $minuten;
                }
            }
        }
        if (!count($zeiteintraege->getSegmente()) && $zeiteintraege->getKontingent()) {
            $kontingent = $zeiteintraege->getKontingent();
            $stunden = floor($kontingent / 60);
            $minuten = $kontingent - $stunden * 60;
            $phasenKontingent[0] = $kontingent;
            $phasenStunden[0] = $stunden;
            $phasenMinuten[0] = $minuten;
        }
        $this->view->assign('phasenKontingent', $phasenKontingent);
        $this->view->assign('phasenStunden', $phasenStunden);
        $this->view->assign('phasenMinuten', $phasenMinuten);
        //$this->view->assign('phaseSelected', $phaseSelected);
        $this->view->assign('phasens', $phasenArr);
        $this->view->assign('phasenIcons', $phasenIconArr);
        $this->view->assign('auftraege', $auftraege);
        echo $this->view->render();
        die;
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zeiteintraegeRepository->update($zeiteintraege);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege)
    {
       /* $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zeiteintraegeRepository->remove($zeiteintraege);
        $this->redirect('list');*/
        $auftraege = $zeiteintraege->getAuftraege();

        $this->zeiteintraegeRepository->remove($zeiteintraege);

        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

        //echo $auftraege->getUid();
        $auftraege->setKontingentUsedCached(0); $auftraege->getKontingentUsed();
        $this->auftraegeRepository->update($auftraege);

       //$auftrag = $zeiteintraege->getAuftraege();
        //$this->redirect('list');
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        die;
	}
	
	
}
