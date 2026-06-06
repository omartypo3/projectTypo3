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

/**
 * The repository for News
 */
class NewsRepository extends AbstractRepository {
	public $tableName = 'tx_news_domain_model_news';

    public function setSettings($settings, $catField){
        $this->settings = $settings;
        $this->catField = $catField;
    }

    public function findAll(){
        $conf = $this->settings['pois'];
        $query = $this->createQuery();

        $query->getQuerySettings()->setRespectStoragePage(false);

        if (isset($this->settings['displayHidden'][$this->tableName]) && $this->settings['displayHidden'][$this->tableName]) {
            $query->getQuerySettings()->setIgnoreEnableFields(true);
            $query->getQuerySettings()->setEnableFieldsToBeIgnored(array('disabled'));
        }

        $where = array();
        $categories = array();
        if(!empty($conf['pages'])){
            $pids = $this->getAllPids($conf['pages']);
            $where[] = $query->in('pid', $pids);
        }

        if ($this->catField && !empty($conf['sys_category']) ) {
            $allCats = $this->arrayToList($this->getAllCats($conf['sys_category']));
            $allCats = array_map('intval', $allCats);

            foreach ($allCats as $selectedCategory) {
                $where[] = $query->contains($this->catField, $selectedCategory);
            }
        }

        if ($this->catField && !empty($this->settings['cat']['cats']) ) {
            $catsValue = $this->settings['cat']['cats'];
            if (is_array($catsValue)) {
                $catsArray = $catsValue;
            } else {
                $catsArray = explode(",", (string)$catsValue);
            }
            $allCats = $this->arrayToList($this->getAllCats($catsArray));
            $allCats = array_map('intval', $allCats);

            foreach ($allCats as $selectedCategory) {
                $categories[] = $query->contains($this->catField, $selectedCategory);
            }
            if (!empty($categories)) {
                $where[] = $query->logicalOr(...$categories);
            }
        }

        if (!empty($conf[$this->tableName])) {
            $where[] = $query->in('uid', $conf[$this->tableName]);
        }
        if (empty($where))  {
            return false;
        }
        
        if(isset($this->settings['choseandor']) && $this->settings['choseandor'] == 1){
             $query->matching(
                $query->logicalAnd(...$where)
            );
        }
        else{
            $query->matching(
                $query->logicalOr(...$where)
            );
        }

        if (!empty($conf[$this->tableName])) {
            /*
            $query->setOrderings(
                array(
                    'deleted, field (uid,' . (implode(',',
                        $conf[$this->tableName])) . ')' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
                )
            );
            */
            $query->setOrderings(array('uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        }

        return $query->execute();
    }
}