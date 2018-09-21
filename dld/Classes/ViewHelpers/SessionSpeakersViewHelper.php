<?php

namespace DLD\Dld\ViewHelpers;


class SessionSpeakersViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**
     * sessionPeopleRepository
     *
     * @var \DLD\Dld\Domain\Repository\SessionPeopleRepository
     * @inject
     */
    protected $sessionPeopleRepository = null;

    /**
     * @param int $id
     *
     */
    public function render($id)
    {
        return $this->sessionPeopleRepository->findBySessionId($id);

    }
}