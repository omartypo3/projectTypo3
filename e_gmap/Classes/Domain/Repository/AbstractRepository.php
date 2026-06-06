<?php
namespace Emagineurs\EGmap\Domain\Repository;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;

/**
 * The repository for Pois
 */
class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public $tableName = '';
    public $cObj = false;
    protected array $settings = [];
    protected string|bool|null $catField = null;
    public function setSettings($settings, $catField)
    {
        $this->settings = $settings;
        $this->catField = $catField;
    }
    /**
     * Returns all objects of this repository.
     *
     * @return QueryResultInterface|array
     * @api
     */
    public function findAllOriginal($pid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $where = $query->equals('pid', $pid);
        $notWhere = $query->equals('lat', '');
        $query->matching(
            $query->logicalAnd(
                $query->logicalOr($where),
                $query->logicalNot($notWhere)
            )
        );
        return $query->execute();
    }
    public function findAll()
    {
        $conf = $this->settings['pois'];
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        // :white_tick: Safe access for displayHidden
        $displayHidden = $this->settings['displayHidden'][$this->tableName] ?? false;
        if ($displayHidden) {
            $query->getQuerySettings()->setIgnoreEnableFields(true);
            $query->getQuerySettings()->setEnableFieldsToBeIgnored(['disabled']);
        }
        $where = [];
        if (!empty($conf['pages'])) {
            $pids = $this->getAllPids($conf['pages']);
            $where[] = $query->in('pid', $pids);
        }
        if ($this->catField && !empty($conf['sys_category'])) {
            $allCats = $this->arrayToList($this->getAllCats($conf['sys_category']));
            $allCats = array_map('intval', $allCats);
            foreach ($allCats as $selectedCategory) {
                $where[] = $query->contains($this->catField, $selectedCategory);
            }
        }
        if (!empty($conf[$this->tableName])) {
            $where[] = $query->in('uid', $conf[$this->tableName]);
        }
        if (empty($where)) {
            return false;
        }
        $query->matching($query->logicalOr(...$where));
        if (!empty($conf[$this->tableName])) {
            $query->setOrderings(['uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING]);
        }
        return $query->execute();
    }
    public function getAllPids($pids)
    {
        $list = array();
        $rec = 5;
        if (!empty($this->settings->recursivity)) {
            $rec = $this->settings->recursivity;
        }
        foreach ($pids as $pid) {
            if (isset($_GLOBALS['TSFE'])) {
                if (!$this->cObj) {
                    $this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
                }
                $list[] = $pid;
                $listTmp = $this->cObj->getTreeList($pid, $rec, 0);
                if (!empty($listTmp)) {
                    $list[] = $listTmp;
                }
            } else {
                //If we are in backend context, we don't care about the recursivity
                $list[] = $pid;
            }
        }
        $list = explode(',', implode(',', $list));
        return $list;
    }
    public function arrayToList($array)
    {
        $liste = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $liste = array_merge($liste, $this->arrayToList($value));
            } else {
                $liste[$key] = $value;
            }
        }
        return $liste;
    }
    public function getAllCats($cats, $rec = -1)
    {
        if (!is_array($cats)) {
            return $cats;
        }
        if ($rec < 0) {
            $rec = 5;
            if (!empty($this->settings->recursivity)) {
                $rec = $this->settings->recursivity;
            }
        } else {
            $rec--;
        }
        $liste = array();
        foreach ($cats as $cat) {
            $liste[] = $this->getAllCats($cat, $rec);
            if ($rec > 0) {
                $listTmp = $this->getAllCats($this->getCatChildren($cat), $rec);
                if (!empty($listTmp)) {
                    $liste[] = $listTmp;
                }
            }
        }
        return $liste;
    }
    public function getCatChildren($cat)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $statement = $queryBuilder
            ->select('uid')
            ->from('sys_category')
            ->where(
                $queryBuilder->expr()->eq('parent', $queryBuilder->createNamedParameter((int)$cat, Connection::PARAM_INT))
            )
            ->executeQuery();
        
        $ret = array();
        while ($row = $statement->fetchAssociative()) {
            $ret[] = $row['uid'];
        }
        return $ret;
    }
}