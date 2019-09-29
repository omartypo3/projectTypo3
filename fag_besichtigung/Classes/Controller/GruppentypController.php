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

/**
 * GruppentypController
 */
class GruppentypController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * gruppentypRepository
     * 
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\GruppentypRepository
     * @inject
     */
    protected $gruppentypRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $gruppentyps = $this->gruppentypRepository->findAll();
        $this->view->assign('gruppentyps', $gruppentyps);
    }

    /**
     * action show
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp
     * @return void
     */
    public function showAction(\FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp)
    {
        $this->view->assign('gruppentyp', $gruppentyp);
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
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $newGruppentyp
     * @return void
     */
    public function createAction(\FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $newGruppentyp)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->gruppentypRepository->add($newGruppentyp);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp
     * @ignorevalidation $gruppentyp
     * @return void
     */
    public function editAction(\FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp)
    {
        $this->view->assign('gruppentyp', $gruppentyp);
    }

    /**
     * action update
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp
     * @return void
     */
    public function updateAction(\FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->gruppentypRepository->update($gruppentyp);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp
     * @return void
     */
    public function deleteAction(\FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->gruppentypRepository->remove($gruppentyp);
        $this->redirect('list');
    }
}
