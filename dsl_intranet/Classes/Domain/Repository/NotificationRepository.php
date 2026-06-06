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
 * The repository for Notifications
 */
class NotificationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        //$querySettings->setStoragePageIds(array(0,9, 25));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param $lastUid
     */
    public function findAllByFrontendUser($lastUid = false)
    {
        $query = $this->createQuery();
        //\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser()
        //$lastUid=24;
        if ($lastUid) {
            $andConstraints[] = $query->greaterThan('uid', $lastUid);
        }
//$mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
		//var_dump($mitarbeiter);
		//echo get_class($mitarbeiter);
		//echo $mitarbeiter->getUid();die;
		
		$ma = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
		//echo $ma->getUid();
		
		
        /*$andConstraints[] = $query->equals('mitarbeiter', $ma->getUid());*/
		if(isset($andConstraints)){
			$query->matching($query->logicalAnd($andConstraints));
		}
        $query->setLimit(20);
		
		/*
		echo "bla:uid:";
			echo \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
		
		
		$parser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser');  
		$queryParts = $parser->parseQuery($query); 
		\TYPO3\CMS\Core\Utility\DebugUtility::debug($queryParts, 'Query');
		*/
		//echo "anzahl:";
		//echo count($query->execute());
		//die;
        return $query->execute();
    }

    public function findAllUnreadByFrontendUser()
    {
        $query = $this->createQuery();
        //\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser()
        //$lastUid=24;
        $andConstraints[] = $query->equals('gelesen', 0);
        //$andConstraints[] = $query->equals('mitarbeiter', \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        $query->matching($query->logicalAnd($andConstraints));
        return $query->execute();
    }
}
