<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***
 *
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * The repository for Ablages
 */
class AblageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    

    /**
     * @var array
     */
    public function findAllByMitarbeiter()
    {
        //return false;
        $query = $this->createQuery();
        $andConstraints = array();
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $andConstraints[] = $query->equals('mitarbeiter', $mitarbeiter);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }
}
