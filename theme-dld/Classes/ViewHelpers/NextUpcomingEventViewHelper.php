<?php

namespace Theme\ViewHelpers;

class NextUpcomingEventViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * event Repository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository;


    public function render()
    {
        return $this->eventRepository->findNextUpcoming();
    }

}