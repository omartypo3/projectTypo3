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
 * The repository for Lieferantens
 */
class LieferantenRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // $querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(97));
        //        $querySettings->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        //$querySettings->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($querySettings);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param string $name
     */
    public function findByName($name)
    {
        $query = $this->createQuery();
        $query->matching($query->like('name', $name));
        //$query->matching($query->logicalAnd($query->equals('oldid', intval($oldid))));
        $posts = $query->execute();
        //        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        if ($posts) {
            return $posts->getFirst();
        } else {
            return false;
        }
    }
}
