<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***
 *
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * The repository for ProtokollePendings
 */
class ProtokollePendingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'timestamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    public function findAllPendingForMitarbeiter()
    {
        $query = $this->createQuery();
        //$query->setOrderings(array("sorting" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $andConstraints = array();
        $andConstraints[] = $query->equals('mitarbeiter', $mitarbeiter);
        $andConstraints[] = $query->equals('pending', true);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        return $query = $query->execute();
    }
}
