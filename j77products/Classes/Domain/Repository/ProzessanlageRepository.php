<?php
namespace J77\J77products\Domain\Repository;

/**
 * Returns all objects of this repository.
 *
 * @return QueryResultInterface|array
 * @api
 */

class ProzessanlageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     *
     */
    public function findAll()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query->execute();
    }
}
