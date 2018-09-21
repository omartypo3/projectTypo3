<?php

namespace DLD\Dld\Domain\Repository;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * The repository for UserTag
 */

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;


class UserTagRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(FALSE);

    }

    public function getByNewTags(){
        $t = new \DateTime('NOW');
        $searchTime = $t->modify('-1 minutes');
//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($searchTime);die();

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                [
                    $query->greaterThanOrEqual('crdate', $searchTime),
                    $query->greaterThanOrEqual('highrisetagcreatedat', $searchTime),


                ]
            )
        );
        return $query->execute();
    }

    /**
     * @param string $tag
     * @param int $userid
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getByTagsAndUserId($tag,$userid){
        $t = new \DateTime('NOW');
        $searchTime = $t->modify('-1 minutes');
//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($searchTime);die();

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('highrisetag', $tag),
                    $query->equals('userid', $userid),


                ]
            )
        );
        return $query->execute()->count();
    }

}
