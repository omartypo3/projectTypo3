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
 * The repository for KundenStammdatens
 */
class KundenStammdatenRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // $querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(8));
        //        $querySettings->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        //$querySettings->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($querySettings);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @return
     */
    public function getByFeUser()
    {
        /*$query = $this->createQuery();
        //$query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $user = $GLOBALS['TSFE']->fe_user->user;
        $query->matching($query->equals('uid', $user['uid']));
        $result = $query->execute()->getFirst();*/
		$user = $GLOBALS['TSFE']->fe_user->user;
		$query = $this->createQuery();
		$result = $query->statement("SELECT * FROM fe_users WHERE deleted = 0 AND disable = 0 AND uid =". $user['uid'])->execute();
        return $result->getFirst();
    }

    /**
     * @param $email
     * @return
     */
    public function checkOtherForEmail($email)
    {
        /*$query = $this->createQuery();
        //$query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $user = $GLOBALS['TSFE']->fe_user->user;
        $query->matching($query->logicalAnd(array(
            $query->logicalNot($query->equals('uid', $user['uid'])),
            $query->equals('email', $email)
        )));
        //	\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $result = $query->execute();*/
		$user = $GLOBALS['TSFE']->fe_user->user;
		$query = $this->createQuery();
		$result = $query->statement("SELECT * FROM fe_users WHERE deleted = 0 AND disable = 0 AND uid !=". $user['uid']." AND email LIKE '". $email."'")->execute();

        return $result;
    }
}
