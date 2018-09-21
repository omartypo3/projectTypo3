<?php

namespace DLD\Dld\ViewHelpers;


class EventEndViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
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

        $query = $this->sessionRepository->findEnd($id);
        if (isset($query)) {
            return $query->getEnd();
        }
        return $query;
    }
}