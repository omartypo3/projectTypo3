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
 * AblageController
 */
class AblageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * ablageRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\AblageRepository
     */
    protected $ablageRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\AblageRepository $ablageRepository
     */
    public function injectAblageRepository(\DslFactory\DslIntranet\Domain\Repository\AblageRepository $ablageRepository)
    {
        $this->ablageRepository = $ablageRepository;
    }
	
	/**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->ablageRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AblageRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
		if ($this->request->hasArgument('switch')) {
            // echo "switch ja";
            $this->view->assign('switch', $this->request->getArgument('switch'));
            switch ($this->request->getArgument('switch')) {
                case 'toggleAblage':    $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    $settings = $mitarbeiter->getSettingsAblage();
                    $settings['ablageToggleStatus'] = $this->request->getArgument('ablageToggleStatus');
                    //$this->view->assign('agenturvertrag', $agenturvertraege);
                    $mitarbeiter->setSettingsAblage($settings);
                    $this->mitarbeiterRepository->update($mitarbeiter);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //$agenturvertraeges = $this->agenturvertraegeRepository->findAll();
                    //$this->view->assign('agenturvertraeges', $agenturvertraeges);
                    break;
                case 'toggleAuftrag':    if ($auftrag = $this->auftraegeRepository->findByUid($this->request->getArgument('auftrag'))) {
                        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                        if ($this->request->getArgument('ablage') == 1) {
                            $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();
                            $ablage->setAuftrag($auftrag);
                            $mitarbeiter->insertAblage($ablage);
                        } else {
                            //echo "remove";die;
                            foreach ($mitarbeiter->getAblage() as $ablage) {
                                if ($ablage->getAuftrag()) {
                                    //echo "auftrag:".$auftrag->getUid();
                                    if ($ablage->getAuftrag()->getUid() == $auftrag->getUid()) {
                                        //	echo "removeablage:".$ablage->getUid();
                                        $mitarbeiter->removeAblage($ablage);
                                        $this->view->assign('ablage', $ablage);
                                    }
                                }
                            }
                        }
                        $this->view->assign('foundFavoriten', count($mitarbeiter->getAblage()));
                        $this->view->assign('switch', 'toggleAuftrag');
                        //$ablage->setMitarbeiter($mitarbeiter);
                        //$this->ablageRepository->add($ablage);
                        $this->mitarbeiterRepository->update($mitarbeiter);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }
                    break;
                case 'sortAblage':    if ($ablageToMove = $this->ablageRepository->findByUid($this->request->getArgument('ablage'))) {
                        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                        if ($this->request->hasArgument('ablageBefore')) {
                            if ($ablageBefore = $this->ablageRepository->findByUid($this->request->getArgument('ablageBefore'))) {
                                //echo $ablageBefore->getUid();
                                $mitarbeiter->moveAblageAfter($ablageToMove, $ablageBefore);
                            }
                        } else {
                            $mitarbeiter->moveAblageToTop($ablageToMove);
                        }
                        $this->mitarbeiterRepository->update($mitarbeiter);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        echo $ablageToMove->getUid();
                    }
                    echo 'sort';
                    die;
                    break;
                default:    die;
                    break;
            }
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
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAblage();
        //$settings['ablageToggleStatus'] = $this->request->getArgument('ablageToggleStatus');
        $this->view->assign('settings', $settings);
        //$ablages = $this->ablageRepository->findAllByMitarbeiter();
        $ablages = $mitarbeiter->getAblage();
        $this->view->assign('ablages', $ablages);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablage
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Ablage $ablage): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('ablage', $ablage);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $newAblage
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Ablage $newAblage)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ablageRepository->add($newAblage);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablage
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("ablage")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Ablage $ablage): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('ablage', $ablage);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablage
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Ablage $ablage)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ablageRepository->update($ablage);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Ablage $ablage
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Ablage $ablage)
    {
        /*$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ablageRepository->remove($ablage);
        $this->redirect('list');*/
		$mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $mitarbeiter->removeAblage($ablage);
        $this->mitarbeiterRepository->update($mitarbeiter);
    }
}
