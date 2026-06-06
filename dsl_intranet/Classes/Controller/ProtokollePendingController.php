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
 * ProtokollePendingController
 */
class ProtokollePendingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * protokollePendingRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\ProtokollePendingRepository
     */
    protected $protokollePendingRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\ProtokollePendingRepository $protokollePendingRepository
     */
    public function injectProtokollePendingRepository(\DslFactory\DslIntranet\Domain\Repository\ProtokollePendingRepository $protokollePendingRepository)
    {
        $this->protokollePendingRepository = $protokollePendingRepository;
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
                case 'getMailPreview':    /*
                                                                                                                                                                                                                                                $monthArr = explode('/', $this->request->getArgument('month'));
                                                                                                                                                                                                                                                $kundenAgenturvertraeges = $this->kundenAgenturvertraegeRepository->findAllForKunde();
                                                                                                                                                                                                                                                //					echo $this->request->getArgument('start');;
                                                                                                                                                                                                                                                foreach ($kundenAgenturvertraeges as $kundenAgenturvertraege) {
                                                                                                                                                                                                                                                    $kundenAgenturvertraege->setMonth(new \DateTime('01.' . $monthArr[0] . '.' . $monthArr[1]));
                                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                                $this->view->assign('kundenAgenturvertraeges', $kundenAgenturvertraeges);*/

                    if ($this->request->hasArgument('protokollePending')) {
                        //$this->view->assign('var', "test(".$this->request->getArgument("protokollePending").")");
                        $protokollePending = $this->protokollePendingRepository->findByUid((int)$this->request->getArgument('protokollePending'));

                        $forceMailSettings = array();
                        foreach (array('subject', 'mitteilung', 'mailTo', 'kundeName', 'mailToCC', 'kundeNameCC') as $key) {
                            if ($this->request->hasArgument($key)) {
                                if ($this->request->getArgument($key)) {
                                    $forceMailSettings[$key] = $this->request->getArgument($key);
                                }
                            }
                        }

                        if($protokollePending) {
                            //echo $forceMailSettings["subject"];
                            $protokollePending->getProtokoll()->setForceMailSettings($forceMailSettings);
                            //print_r($protokollePending->getProtokoll()->getMailSettings());die;
                            //$set = $protokollePending->getProtokoll()->getMailSettings();
                            //echo $set["subject"];
                            $this->view->assign('protokollePending', $protokollePending);
                        }
                    }
                    //$this->view->assign('protokollePending', $protokollePending);
                    break;
                case 'protokollePendingClose':    if ($this->request->hasArgument('protokollePending')) {
                    //	$this->view->assign('var', "test(".$this->request->getArgument("protokollePending").")");
                    $protokollePending = $this->protokollePendingRepository->findByUid($this->request->getArgument('protokollePending'));
                    $protokollePending->setPending(false);
                    //$protokollePending->getProtokoll()->sendKundeninfoMail(true);
                    $this->protokollePendingRepository->update($protokollePending);
                }
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
        $protokollePendings = $this->protokollePendingRepository->findAllPendingForMitarbeiter();
				
        $invalidFound = false;
        foreach ($protokollePendings as $protokollePending) {
            if ($protokollePending->getProtokoll() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                $protokollePending->getProtokoll()->_loadRealInstance();
            }
			
            //echo "protokolluid:".$protokollePending->getProtokoll()->getUid();
            //echo "-".$protokollePending->getProtokoll()->isValidAuftrag()."-";
				if (!$protokollePending->getProtokoll()->isValidAuftrag()) {
					$invalidFound = true;
					$this->protokollePendingRepository->remove($protokollePending);
				}
			
            //echo "<div>blu</div>";
        }
        if ($invalidFound) {
            //	echo "invalidfound";//die;
            //			die;
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            $protokollePendings = $this->protokollePendingRepository->findAllPendingForMitarbeiter();



        }
        $this->view->assign('protokollePendings', $protokollePendings);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('protokollePending', $protokollePending);
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
     * @param \DslFactory\DslIntranet\Domain\Model\ProtokollePending $newProtokollePending
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\ProtokollePending $newProtokollePending)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->protokollePendingRepository->add($newProtokollePending);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("protokollePending")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('protokollePending', $protokollePending);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
	 * @return void
     */
    public function updateAction()
    {
		 if ($this->request->hasArgument('protokollePending')) {
			$protokollePending = $this->protokollePendingRepository->findByUid($this->request->getArgument('protokollePending'));
			$forceMailSettings = array();
			foreach (array('subject', 'mitteilung', 'mailTo', 'kundeName', 'mailToCC', 'kundeNameCC', 'fromName', 'fromMail') as $key) {
				if ($this->request->hasArgument($key)) {
					if ($this->request->getArgument($key)) {
						$forceMailSettings[$key] = $this->request->getArgument($key);
					}
				}
			}
			//if ($protokollePending) {
				$protokollePending->getProtokoll()->setForceMailSettings($forceMailSettings);
				$protokollePending->getProtokoll()->sendKundeninfoMail(true);
				$protokollePending->setPending(false);
				$this->protokollePendingRepository->update($protokollePending);
				$this->view->assign('protokollePending', $protokollePending);
			//}
		 }
		
       // $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->protokollePendingRepository->remove($protokollePending);
        $this->redirect('list');
    }
}
