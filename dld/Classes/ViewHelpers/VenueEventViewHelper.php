<?php

namespace DLD\Dld\ViewHelpers;


class VenueEventViewHelper  extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**
     * bookRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * @param int $id
     * @return bool result
     */
    public function render($id)
    {
        $query = $this->eventRepository->haveVenue($id);
        if ($query > 0) {
            return false;
        }
        return true;
    }
}