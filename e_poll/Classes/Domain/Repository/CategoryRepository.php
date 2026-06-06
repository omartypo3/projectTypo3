<?php
namespace Emagineurs\EPoll\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Category Repository
 */
class CategoryRepository extends Repository
{
    /**
     * @var string
     */
    protected $objectType = \TYPO3\CMS\Extbase\Domain\Model\Category::class;
    
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
        'title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
    ];
}

