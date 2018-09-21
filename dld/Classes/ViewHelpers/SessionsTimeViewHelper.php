<?php

namespace DLD\Dld\ViewHelpers;


class SessionsTimeViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
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
     * @param string $date
     *
     */
    public function render($id,$date)
    {
        $query = $this->sessionRepository->findtime($id,$date);
         return $query;
    }
}