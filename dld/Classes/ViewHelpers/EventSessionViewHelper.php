<?php

namespace DLD\Dld\ViewHelpers;


class EventSessionViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
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
     *
     */
    public function render($id)
    {

        $query = $this->sessionRepository->findEventSessions($id);
         return $query;
    }
}