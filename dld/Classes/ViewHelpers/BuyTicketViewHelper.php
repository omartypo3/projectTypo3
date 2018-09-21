<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 09/07/2018
 * Time: 10:29
 */

namespace DLD\Dld\ViewHelpers;


use TYPO3\CMS\Core\Utility\DebugUtility;

class BuyTicketViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository;

    /**
     * eventTicketRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventTicketRepository
     * @inject
     */
    protected $eventTicketRepository;

    /**
     * @param string $tag
     * @return bool
     */
    public function render($tag)
    {
        if (stripos('_invited',$tag)) {
        $tags = explode('_invited', $tag);

        $event = $this->eventRepository->findByTagPrefix($tags[0]);
        $eventid = $event[0]->getUid();
        $exist = $this->eventTicketRepository->findEventTicket($eventid, 'invited' . $tags[1]);
            DebugUtility::debug($exist);
        if ($exist) {
            return true;
        }
    }
        return false;
    }
}