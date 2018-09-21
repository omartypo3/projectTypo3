<?php
namespace DLD\Dld\Controller;

/***
 *
 * This file is part of the "DLD Event" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * DashboardController
 */
class DashboardController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * eventRepository
     * 
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = null;

    /**
     * action home
     * 
     * @return void
     */


    public function homeAction()
    {
        $upcomingEvents= $this->eventRepository->findUpcomingEvents();
        $this->view->assign('upcomingEvents' , $upcomingEvents);
    }


}
