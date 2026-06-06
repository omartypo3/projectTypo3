<?php
namespace DslFactory\DslJobs\Domain\Repository;

/***
 *
 * This file is part of the "Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * The repository for Jobs
 */
class JobsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     * @param int $jobid
     */
    public function findByJobid($jobid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->getQuerySettings()->setIncludeDeleted(false);
        //dslweg $query->getQuerySettings()->setIncludeDeleted(false);
        $query->matching($query->equals('jobid', $jobid));
        //$query->matching($query->logicalAnd($query->equals('ref_art_nr', $refArtNr)));
        return $query->execute()->getFirst();
    }
}
