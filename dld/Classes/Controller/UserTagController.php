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
 * ApplicationController
 */
class UserTagController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * UserTagRepository
     * 
     * @var \DLD\Dld\Domain\Repository\UserTagRepository
     * @inject
     */
    protected $UserTagRepository  = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $settings = $this->UserTagRepository->findAll();
        $this->view->assign('applications', $settings);
    }

    /**
     * action show
     * 
     * @param \DLD\Dld\Domain\Model\Application $application
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\Application $application)
    {
        $this->view->assign('application', $application);
    }


    /**
     * action create
     *
     * @param \DLD\Dld\Domain\Model\Application $newapplication
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\Application $newapplication)
    {
        //$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->applicationRepository->add($newapplication);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DLD\Dld\Domain\Model\Application $application
     * @ignorevalidation $setting
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\Application $application)
    {
        $this->view->assign('application', $application);
    }

    /**
     * action update
     *
     * @param \DLD\Dld\Domain\Model\Setting $setting
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\Application $application)
    {
        //$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->applicationRepository->update($application);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DLD\Dld\Domain\Model\Application $application
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\Application $application)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->applicationRepository->remove($application);
        $this->redirect('list');
    }

}
