<?php
namespace DLD\Dld\Controller;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * SessionPeopleController
 */
class SessionPeopleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * sessionPeopleRepository
     * 
     * @var \DLD\Dld\Domain\Repository\SessionPeopleRepository
     * @inject
     */
    protected $sessionPeopleRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $sessionPeoples = $this->sessionPeopleRepository->findAll();
        $this->view->assign('sessionPeoples', $sessionPeoples);
    }

    /**
     * action show
     * 
     * @param \DLD\Dld\Domain\Model\SessionPeople $sessionPeople
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\SessionPeople $sessionPeople)
    {
        $this->view->assign('sessionPeople', $sessionPeople);
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
     * @param \DLD\Dld\Domain\Model\SessionPeople $newSessionPeople
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\SessionPeople $newSessionPeople)
    {
        //$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->sessionPeopleRepository->add($newSessionPeople);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \DLD\Dld\Domain\Model\SessionPeople $sessionPeople
     * @ignorevalidation $sessionPeople
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\SessionPeople $sessionPeople)
    {
        $this->view->assign('sessionPeople', $sessionPeople);
    }

    /**
     * action update
     * 
     * @param \DLD\Dld\Domain\Model\SessionPeople $sessionPeople
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\SessionPeople $sessionPeople)
    {
        //$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->sessionPeopleRepository->update($sessionPeople);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \DLD\Dld\Domain\Model\SessionPeople $sessionPeople
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\SessionPeople $sessionPeople)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->sessionPeopleRepository->remove($sessionPeople);
        $this->redirect('list');
    }
}
