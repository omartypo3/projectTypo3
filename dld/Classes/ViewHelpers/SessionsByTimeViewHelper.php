<?php

namespace DLD\Dld\ViewHelpers;


class SessionsByTimeViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
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
     * @param \DateTime $date
     *
     */
    public function render($id,$date)
    {
        $query = $this->sessionRepository->findBytime($id,$date);
         return $query;
    }
}