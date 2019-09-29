<?php
namespace Silcoplastproduct\SilcoplastProduct\Domain\Repository;

/***
 *
 * This file is part of the "Silcoplast_Product" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 ons <ons.chaari@softtodo.com>, softtodo
 *
 ***/
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for Products
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
{
    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $defaultQuerySettings->setRespectStoragePage(false);
        $defaultQuerySettings->setIgnoreEnableFields(true);
        $defaultQuerySettings->setEnableFieldsToBeIgnored(array('starttime', 'endtime'));
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }
     /**
     * find uid parent
     * 
     * @param  string $nom_parent
     * 
     * @return void
     */

    public function findUidparent($nom_parent = null)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $statement = $queryBuilder
            ->select('*')
            ->from('sys_category')
            
            ->where(
                $queryBuilder->expr()->like(
                    'sys_category.title',
                    $queryBuilder->createNamedParameter( $queryBuilder->escapeLikeWildcards($nom_parent) )
                )
            )
            ->execute();
        while ($row = $statement->fetch()) {
           $list_children =  $this->findChildren($row['uid']);
        }
      return $list_children;
    }

     /**
     * Find children by parent id
     * 
     * @param  int $id_parent
     * @return void
     */
        public function findChildren($id_parent){
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $statement = $queryBuilder
            ->select('sys_category.*')
            ->from('sys_category')
            
            ->where(
                $queryBuilder->expr()->eq('sys_category.parent', $queryBuilder->createNamedParameter($id_parent))
               )
            ->andWhere(
                $queryBuilder->expr()->eq('sys_category.sys_language_uid', $queryBuilder->createNamedParameter($GLOBALS['TSFE']->sys_language_uid, \PDO::PARAM_INT))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('sys_category.deleted', $queryBuilder->createNamedParameter(0))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('sys_category.hidden', $queryBuilder->createNamedParameter(0))
            )
            ->execute();
            $list_cat=[];
        while ($row = $statement->fetch()) {

            $list= array(
                'uid' => $row['uid'],
                'title' => $row['title'],
                'parent' => $row['parent'],
                'icon' => $row['icon'],
                'icong' => $row['icong'],
            );
            array_push($list_cat, $list);
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $statement = $queryBuilder
            ->select('sys_category.*')
            ->from('sys_category')
            
            ->where(
                $queryBuilder->expr()->eq('sys_category.uid', $queryBuilder->createNamedParameter($id_parent))
               )
        
            ->execute();
            while ($row = $statement->fetch()) {
                $list=array(
                    'uid' =>$row['uid'],
                    'title' =>$row['title'],
                    'icon' => $row['icon'],
                    'icong' => $row['icong'],
                    'children' => $list_cat);
            }
            return $list;
        }


}

