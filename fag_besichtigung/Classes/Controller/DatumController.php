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
 * DatumController
 */
class DatumController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * datumRepository
     * 
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository
     * @inject
     */
    protected $datumRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $data = $this->datumRepository->findAll();
        $this->view->assign('data', $data);
    }

    /**
     * action show
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Datum $datum
     * @return void
     */
    public function showAction(\FRONTAL\FagBesichtigung\Domain\Model\Datum $datum)
    {
        $this->view->assign('datum', $datum);
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
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Datum $newDatum
     * @return void
     */
    public function createAction(\FRONTAL\FagBesichtigung\Domain\Model\Datum $newDatum)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->datumRepository->add($newDatum);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Datum $datum
     * @ignorevalidation $datum
     * @return void
     */
    public function editAction(\FRONTAL\FagBesichtigung\Domain\Model\Datum $datum)
    {
        $this->view->assign('datum', $datum);
    }

    /**
     * action update
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Datum $datum
     * @return void
     */
    public function updateAction(\FRONTAL\FagBesichtigung\Domain\Model\Datum $datum)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->datumRepository->update($datum);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Datum $datum
     * @return void
     */
    public function deleteAction(\FRONTAL\FagBesichtigung\Domain\Model\Datum $datum)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->datumRepository->remove($datum);
        $this->redirect('list');
    }
}
