<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
 * The repository for Kundens
 */
class KundenRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
        $querySettings->setStoragePageIds(array(8));
        //        $querySettings->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        $querySettings->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($querySettings);
        $this->setDefaultQuerySettings($querySettings);
    }
	
	
    /**
     * @param int $uid
     * @return
     */
    public function getUidIgnoreDeleted($uid)
    {
        $query = $this->createQuery();
        //$query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->matching($query->equals('uid', $uid));
        //	\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $result = $query->execute()->getFirst();
        return $result;
    }
	

    public function getActive()
    {
        //$querySettings = $this->getDefaultQuerySettings($querySettings);
        //$querySettings->setIgnoreEnableFields(false);
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(false);
        return $query->execute();
    }

    public function findAllIgnoreDeleted()
    {
        //$querySettings = $this->getDefaultQuerySettings($querySettings);
        //$querySettings->setIgnoreEnableFields(false);
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        return $query->execute();
    }

    /**
     * @param string $search
     * @param boolean $searchInNummer
     * @return \DslFactory\DslIntranet\Domain\Model\Kunden The Kunde
     */
    public function findByName($search, $searchInNummer = false)
    {
        $query = $this->createQuery();
        //$query->getQuerySettings()->setStoragePageIds(array(8));
        $constraints = array();
        $constraints[] = $query->like('name', $search);
		$constraints[] = $query->like('company', $search);
		$constraints[] = $query->like('qbbaddr', $search);
        if ($searchInNummer) {
            $constraints[] = $query->like('nummer', $search);
        }
        $query->matching($query->logicalOr($constraints));
        //		$posts = $query->execute()->getFirst();
        //		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $posts = $query->execute();
        return $posts;
    }

    /**
     * @param string $nummer
     */
    public function findByNummer($nummer)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        //->setIncludeDeleted(true);
        $constraints = array();
        $constraints[] = $query->equals('nummer', $nummer);
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param string $qbrefnum
     */
    public function findByQbrefnum($qbrefnum)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        //->setIncludeDeleted(true)
        $constraints = array();
        $constraints[] = $query->equals('qbrefnum', $qbrefnum);
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param array $kundenArr
     */
    public function sortByName($kundenArr)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $constraints = array();
        foreach ($kundenArr as $kunde) {
            $constraints[] = $query->equals('uid', $kunde->getUid());
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($query->logicalOr($constraints)));
        }
        return $query->execute();
    }

    /**
     * @param string $fieldKey
     * @param string $fieldValue
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunde
     */
    public function findOtherByField($fieldKey, $fieldValue, $kunde)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        //->setIncludeDeleted(true)
        $constraints = array();
        $constraints[] = $query->logicalNot($query->equals('uid', $kunde));
        $constraints[] = $query->equals($fieldKey, $fieldValue);
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param array $settings
     * @param integer $offset
     * @param integer $limit
     * @param array $order
     * @param string $search
     */
    public function findByFilter($settings, $offset = false, $limit = false, $order = array(), $search = false)
    {
        $query = $this->createQuery();
        /*$this->defaultOrderings = array(
          'datumfertigstellung' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
          );*/

        //return $query->execute();
        $andConstraints = array();
		if (!is_array($settings)){
			$settings = json_decode($settings, true);
		}
        if (is_array($settings['aktiv'])) {
            if (count($settings['aktiv']) == 2) {
                unset($settings['aktiv']);
            }
        }
        if (is_array($settings['login'])) {
            if (count($settings['login']) == 2) {
                unset($settings['login']);
            }
        }
        foreach ($settings as $key => $value) {
            //echo "<br>".$key.":".print_r($value,1);
            if (is_array($value)) {
                $orConstraints = array();
                switch ($key) {
                    case 'aktiv':    foreach ($value as $wert) {
                            if ($wert == 'aktiv') {
                                $andConstraints[] = $query->equals('disable', 0);
                            }
                            if ($wert == 'inaktiv') {
                                $andConstraints[] = $query->equals('disable', 1);
                            }
                        }
                        break;
                    case 'login':    foreach ($value as $wert) {
                            if ($wert == 'aktiv') {
                                foreach ($this->findAll() as $kunde) {
                                    //echo $kunde->getUid().":";
                                    if ($kunde->isLogin()) {
                                        $orConstraints[] = $query->equals('uid', $kunde->getUid());
                                    }
                                }
                            }
                            if ($wert == 'inaktiv') {
                                foreach ($this->findAll() as $kunde) {
                                    if (!$kunde->isLogin()) {
                                        $orConstraints[] = $query->equals('uid', $kunde->getUid());
                                    }
                                }
                            }
                        }
                        break;
                }
                if (count($orConstraints)) {
                    $andConstraints[] = $query->logicalOr($orConstraints);
                }
            } else {
                switch ($key) {

                }
            }
        }
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        if ($offset !== false) {
            $query->setOffset($offset);
        }
        if ($limit !== false) {
            $query->setLimit($limit);
        }
        $posts = $query->execute();
        // 		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }
}
