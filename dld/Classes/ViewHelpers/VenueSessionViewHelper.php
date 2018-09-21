<?php

namespace DLD\Dld\ViewHelpers;


class VenueSessionViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**
     * bookRepository
     *
     * @var \DLD\Dld\Domain\Repository\SessionRepository
     * @inject
     */
    protected $sessionRepository = null;

    /**
     * @param int $id
     * @return bool result
     */
    public function render($id)
    {
        $query = $this->sessionRepository->haveVenue($id);
        if ($query > 0) {
            return false;
        }
        return true;
    }
}