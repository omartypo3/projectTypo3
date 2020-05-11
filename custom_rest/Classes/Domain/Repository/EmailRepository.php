<?php

namespace Cundd\CustomRest\Domain\Repository;

use Cundd\CustomRest\Domain\Model\Person;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Emails
 *
 */
class EmailRepository extends Repository
{
    /**
     * defaultOrderings
     *
     * @var array
     */
    protected $defaultOrderings = array(
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
    );

}

