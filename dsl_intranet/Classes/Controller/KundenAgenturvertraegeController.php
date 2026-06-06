<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * KundenAgenturvertraegeController
 */
class KundenAgenturvertraegeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * kundenAgenturvertraegeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\KundenAgenturvertraegeRepository
     */
    protected $kundenAgenturvertraegeRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\KundenAgenturvertraegeRepository $kundenAgenturvertraegeRepository
     */
    public function injectKundenAgenturvertraegeRepository(\DslFactory\DslIntranet\Domain\Repository\KundenAgenturvertraegeRepository $kundenAgenturvertraegeRepository)
    {
        $this->kundenAgenturvertraegeRepository = $kundenAgenturvertraegeRepository;
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
                case 'setNewRange':    /*$mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                      $settings = $mitarbeiter->getSettingsAgenturauftrag();
                      $settings['start'] = $this->request->getArgument('start');
                      $settings['end'] = $this->request->getArgument('end');
                      //$this->view->assign('agenturvertrag', $agenturvertraege);
                      $mitarbeiter->setSettingsAgenturauftrag($settings);
                      $this->mitarbeiterRepository->update($mitarbeiter);
                      $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();*/

                    $monthArr = explode('/', $this->request->getArgument('month'));
                    $kundenAgenturvertraeges = $this->kundenAgenturvertraegeRepository->findAllForKunde();
                    //					echo $this->request->getArgument('start');;
                    foreach ($kundenAgenturvertraeges as $kundenAgenturvertraege) {
                        $kundenAgenturvertraege->setMonth(new \DateTime('01.' . $monthArr[0] . '.' . $monthArr[1]));
                    }
                    $this->view->assign('kundenAgenturvertraeges', $kundenAgenturvertraeges);
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
        $kundenAgenturvertraeges = $this->kundenAgenturvertraegeRepository->findAllForKunde();
        $agenturvertraegeRange = $this->kundenAgenturvertraegeRepository->getRange();
        $this->view->assign('agenturvertraegeRange', $agenturvertraegeRange);
        //echo count($kundenAgenturvertraeges);die;
        //$month = new \DateTime();
        //$month = new \DateTime('01.' . $month->format('m.Y'));
        //$this->view->assign('month', $month);
        foreach ($kundenAgenturvertraeges as $kundenAgenturvertraege) {
            $kundenAgenturvertraege->setMonth(new \DateTime('01.' . $agenturvertraegeRange['maxDate']->format('m.Y')));
        }
        $this->view->assign('kundenAgenturvertraeges', $kundenAgenturvertraeges);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("kundenAgenturvertraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege): \Psr\Http\Message\ResponseInterface
    {
        $monthArr = explode('/', $this->request->getArgument('month'));
        //$this->request->getArgument('month');
        //$kundenAgenturvertraege
        //print_r($monthArr);die;
        $kundenAgenturvertraege->setMonth(new \DateTime('01.' . $monthArr[0] . '.' . $monthArr[1]));
        $kundenAgenturvertraege->getAuftraege(true);
        //echo $kundenAgenturvertraege->getMonth()->format("d.m.Y");die;
        $this->view->assign('agenturvertrag', $kundenAgenturvertraege);
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
     * @param \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $newKundenAgenturvertraege
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $newKundenAgenturvertraege)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenAgenturvertraegeRepository->add($newKundenAgenturvertraege);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("kundenAgenturvertraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenAgenturvertraege', $kundenAgenturvertraege);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenAgenturvertraegeRepository->update($kundenAgenturvertraege);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $kundenAgenturvertraege)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenAgenturvertraegeRepository->remove($kundenAgenturvertraege);
        $this->redirect('list');
    }
}
