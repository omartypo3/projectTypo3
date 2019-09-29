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
 * GruppenFuhrerController
 */
class GruppenFuhrerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * gruppenFuhrerRepository
     * 
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\GruppenFuhrerRepository
     * @inject
     */
    protected $gruppenFuhrerRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $gruppenFuhrers = $this->gruppenFuhrerRepository->findAll();
        $this->view->assign('gruppenFuhrers', $gruppenFuhrers);
    }

    /**
     * action show
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer
     * @return void
     */
    public function showAction(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer)
    {
        $this->view->assign('gruppenFuhrer', $gruppenFuhrer);
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
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $newGruppenFuhrer
     * @return void
     */
    public function createAction(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $newGruppenFuhrer)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->gruppenFuhrerRepository->add($newGruppenFuhrer);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer
     * @ignorevalidation $gruppenFuhrer
     * @return void
     */
    public function editAction(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer)
    {
        $this->view->assign('gruppenFuhrer', $gruppenFuhrer);
    }

    /**
     * action update
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer
     * @return void
     */
    public function updateAction(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->gruppenFuhrerRepository->update($gruppenFuhrer);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer
     * @return void
     */
    public function deleteAction(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->gruppenFuhrerRepository->remove($gruppenFuhrer);
        $this->redirect('list');
    }
}
