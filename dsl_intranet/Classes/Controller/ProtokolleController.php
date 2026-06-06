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
 * ProtokolleController
 */
class ProtokolleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * protokolleRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\ProtokolleRepository
     */
    protected $protokolleRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\ProtokolleRepository $protokolleRepository
     */
    public function injectProtokolleRepository(\DslFactory\DslIntranet\Domain\Repository\ProtokolleRepository $protokolleRepository)
    {
        $this->protokolleRepository = $protokolleRepository;
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
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->protokolleRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
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
                case 'toggleKundeninfoSichtbarkeit':    if ($this->request->hasArgument('uid')) {
                    if ($protokolle = $this->protokolleRepository->findByUid($this->request->getArgument('uid'))) {
                        $protokolle->toggleKundeninfoSichtbarkeit();
                        //echo $protokolle->getKundeninfoSichtbarkeit();
                        $this->protokolleRepository->update($protokolle);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        echo json_encode(array('auftrag' => $protokolle->getAuftrag()->getUid(), 'uid' => $protokolle->getUid(), 'contentShow' => $this->getPartialsListRow($protokolle)));
                        die;
                        break;
                    }
                }
                    break;
                case 'sendKundeninfoMail':    if ($this->request->hasArgument('uid')) {
                    if ($protokolle = $this->protokolleRepository->findByUid($this->request->getArgument('uid'))) {
                        //$protokolle->toggleKundeninfoSichtbarkeit();
                        /*mail abfrage statusmeldungen änderung*/
                        //$protokolle->sendKundeninfoMail(true);
                        $protokollePending = $this->initProtokollPending($protokolle);

                        $this->protokolleRepository->update($protokolle);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        //die;
                        echo json_encode(array('auftrag' => $protokolle->getAuftrag()->getUid(), 'uid' => $protokolle->getUid(), 'contentShow' => $this->getPartialsListRow($protokolle), 'protokollePendingUid' => $protokollePending->getUid()));
                        //echo json_encode(array('kundeninfoTime' => $protokolle->getKundeninfoTime(), 'kundeninfoMail' => $protokolle->getKundeninfoMail()));
                        die;
                        break;
                    }
                }
                    break;
                case 'delete':    if ($this->request->hasArgument('uid')) {
                    if ($protokolle = $this->protokolleRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($protokolle);
                        return true;
                    }
                }
                    break;
                case 'update':    $protokolle = $this->protokolleRepository->findByUid($this->request->getArgument('protokolle'));
                    $protokolle = $this->updateProtokollFromRequest($protokolle);
                    $this->protokolleRepository->update($protokolle);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('auftraegeUid' => $protokolle->getAuftrag()->getUid(), 'uid' => $protokolle->getUid()));
                    //, 'contentList' => $this->getPartialsListRow($zeiteintraege)
                    die;
                    break;
                case 'create':    if ($this->request->hasArgument('auftraege')) {
                    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
                    $newProtokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                    $newProtokolle->setZeitpunkt(new \DateTime());
                    $newProtokolle->setPid((int)$this->settings['protokollePid']);
                    $newProtokolle->setAuftrag($auftraege);
                    $newProtokolle->setAktion(20);
                    $newProtokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $newProtokolle = $this->updateProtokollFromRequest($newProtokolle);
                    /*mail abfrage statusmeldungen änderung*/
                    /*if ($newProtokolle->getKundeninfoSichtbarkeit()) {
                      $newProtokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();
                      $newProtokollePending->setMitarbeiter(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                      $newProtokollePending->setPending(true);
                      $newProtokollePending->setTimestamp(new \DateTime());
                      $this->protokollePendingRepository->add($newProtokollePending);
                      $newProtokolle->addPending($newProtokollePending);
                      }*/

                    if ($newProtokolle->getKundeninfoSichtbarkeit()) {
                        $newProtokollePending = $this->initProtokollPending($newProtokolle);
                    }
                    $this->protokolleRepository->add($newProtokolle);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //$newProtokollePendingUid ? $newProtokollePendingUid->getUid() : false;
                    echo json_encode(array('auftraegeUid' => $auftraege->getUid(), 'uid' => $newProtokolle->getUid(), 'contentShow' => $this->getPartialsListRow($newProtokolle), 'protokollePendingUid' => $newProtokollePending ? $newProtokollePending->getUid() : false));
                    die;
                }
                    echo json_encode(array('content___' => print_r($this->request->getArguments(), 1)));
                    die;
                    break;
            }
        }
        //header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
       // return $this->htmlResponse();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     */
    private function updateProtokollFromRequest($protokolle)
    {
        if ($this->request->hasArgument('notiz')) {
            $protokolle->setNotiz($this->request->getArgument('notiz'));
        }
        if ($this->request->hasArgument('kundeninfoSichtbarkeit')) {
            $protokolle->setKundeninfoSichtbarkeit((int)$this->request->getArgument('kundeninfoSichtbarkeit'));
        }
        //$protokolle->setKundeninfoSichtbarkeit(1);
        if ($this->request->hasArgument('zeitpunkt')) {
            //			$protokolle->setZeitpunkt($this->request->getArgument('zeitpunkt'));
            $protokolle->setZeitpunkt(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('zeitpunkt'))));
        }
        return $protokolle;
    }

    /**
     * @param $time
     */
    private function convertTimeToArray($time)
    {
        $stunden = floor($time / 60);
        $minuten = $time - $stunden * 60;
        return array('stunden' => $stunden, 'minuten' => $minuten);
    }


    /**
     * action kundennew
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $newProtokolle
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundennewAction(\DslFactory\DslIntranet\Domain\Model\Protokolle $newProtokolle = NULL): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('newProtokolle', $newProtokolle);
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
        $protokolle->setZeitpunkt(new \DateTime());
        $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
        $this->view->assign('auftraege', $auftraege);
        $this->view->assign('aktion', 20);
        $this->view->assign('protokolle', $protokolle);
        return $this->htmlResponse();
    }

    /**
     * action kundenajax
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundenajaxAction(): \Psr\Http\Message\ResponseInterface
    {
        if ($this->request->hasArgument('switch')) {
            switch ($this->request->getArgument('switch')) {
                case 'create':    if ($this->request->hasArgument('auftraege')) {
                    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
                    $newProtokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                    $newProtokolle->setPid($this->settings['protokollePid']);
                    $newProtokolle->setAuftrag($auftraege);
                    $newProtokolle->setAktion(20);
                    $newProtokolle->setZeitpunkt(new \DateTime());
                    $newProtokolle->setKundeninfoSichtbarkeit(1);
                    $newProtokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $newProtokolle = $this->updateProtokollFromRequest($newProtokolle);
                    //$newProtokolle->sendMitarbeiterinfoMail();
                    $this->protokolleRepository->add($newProtokolle);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
                    $notificationAnsprechpartner->setAuftrag($auftraege);
                    $notificationAnsprechpartner->setArt(70, $auftraege->getStatusText(), $newProtokolle->getNotiz());
                    //echo $auftraege->getAnsprechpartner()->getUid();
                    if ($auftraege->getAnsprechpartner() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                        $auftraege->getAnsprechpartner()->_loadRealInstance();
                    }
                    $notificationAnsprechpartner->setMitarbeiter($auftraege->getAnsprechpartner());
                    if ($notificationAnsprechpartner->forOtherUser()) {
                        $this->notificationRepository->add($notificationAnsprechpartner);
                    }

                    if ($auftraege->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                        $auftraege->getMitarbeiter()->_loadRealInstance();
                    }
                    foreach ($auftraege->getMitarbeiter() as $mitarbeiter) {
                        if ($auftraege->getAnsprechpartner() != $mitarbeiter) {
                            $notificationMitarbeiter = clone $notificationAnsprechpartner;
                            $notificationMitarbeiter->resetUid();
                            //$notificationMitarbeiter->setMitarbeiter($mitarbeiter);
                            if ($notificationMitarbeiter->forOtherUser()) {
                                $this->notificationRepository->add($notificationMitarbeiter);
                            }
                        }
                    }
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //++autosend an admin
                    echo json_encode(array('auftraegeUid' => $auftraege->getUid(), 'uid' => $newProtokolle->getUid(), 'contentShow' => $this->getPartialsListRow($newProtokolle)));
                    die;
                }
                    echo json_encode(array('content___' => print_r($this->request->getArguments(), 1)));
                    die;
                    break;
                case 'delete':    if ($this->request->hasArgument('uid')) {
                    if ($protokolle = $this->protokolleRepository->findByUid($this->request->getArgument('uid'))) {
                        $protokolle->setHidden(1);
                        $this->protokolleRepository->update($protokolle);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        // $this->deleteAction($protokolle);
                        die;
                    }
                }
                    break;
            }
        }
        header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
        return $this->htmlResponse();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     */
    public function getPartialsListRow(\DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle)
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($user->isKunde()) {
            $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Protokolle/KundenListItemAjax.html', $this->request->getControllerExtensionName());
        } else {
            $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Protokolle/ListItemAjax.html', $this->request->getControllerExtensionName());
        }
        $dbView->assignMultiple(array('protokolle' => $protokolle));
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
        $protokolles = $this->protokolleRepository->findAll();
        $this->view->assign('protokolles', $protokolles);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('protokolle', $protokolle);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $newProtokolle
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(\DslFactory\DslIntranet\Domain\Model\Protokolle $newProtokolle = NULL): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('newProtokolle', $newProtokolle);
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
        $protokolle->setZeitpunkt(new \DateTime());
        $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
        $this->view->assign('auftraege', $auftraege);
        $this->view->assign('aktion', 20);
        $this->view->assign('protokolle', $protokolle);
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $newProtokolle
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Protokolle $newProtokolle)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->protokolleRepository->add($newProtokolle);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("protokolle")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('protokolle', $protokolle);
        $this->view->assign('aktion', $protokolle->getAktion());
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->protokolleRepository->update($protokolle);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->protokolleRepository->remove($protokolle);
        $this->redirect('list');
    }

    /**
     * initProtokollPending
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     * @return \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     */
    private function initProtokollPending($protokolle)
    {
        $newProtokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
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
}
