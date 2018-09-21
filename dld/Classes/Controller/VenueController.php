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
 * VenueController
 */
class VenueController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * venueRepository
     * 
     * @var \DLD\Dld\Domain\Repository\VenueRepository
     * @inject
     */
    protected $venueRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $venues = $this->venueRepository->findAll();
        $this->view->assign('venues', $venues);
    }

    /**
     * action show
     * 
     * @param \DLD\Dld\Domain\Model\Venue $venue
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\Venue $venue)
    {
        $this->view->assign('venue', $venue);
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
     * @param \DLD\Dld\Domain\Model\Venue $newVenue
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\Venue $newVenue)
    {
        //$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->venueRepository->add($newVenue);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \DLD\Dld\Domain\Model\Venue $venue
     * @ignorevalidation $venue
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\Venue $venue)
    {
        $this->view->assign('venue', $venue);
    }

    /**
     * action update
     * 
     * @param \DLD\Dld\Domain\Model\Venue $venue
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\Venue $venue)
    {
        //$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->venueRepository->update($venue);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \DLD\Dld\Domain\Model\Venue $venue
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\Venue $venue)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->venueRepository->remove($venue);
        $this->redirect('list');
    }
}
