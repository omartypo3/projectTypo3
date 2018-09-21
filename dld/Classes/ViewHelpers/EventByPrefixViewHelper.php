<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 12/07/2018
 * Time: 11:02
 */

namespace DLD\Dld\ViewHelpers;


use DLD\Dld\Domain\Model\Event;

class EventByPrefixViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * @param string $prefix
     * @return Event
     */
    public function render($prefix) {
        $events = $this->eventRepository->findOneByTagPrefix($prefix);
        return $events;
    }
}