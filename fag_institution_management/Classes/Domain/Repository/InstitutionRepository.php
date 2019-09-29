<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/***
 *
 * This file is part of the "FRONTAL / Institutionen" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Roland Kneubühler <rk@frontal.ch>, Agentur Frontal AG
 *
 ***/

/**
 * The repository for Institutions
 */
class InstitutionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    /**
     * Get institutions by search form filter with links
     * 
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter $institutionFilter Event Filter object
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Institution>
     */
    public function findByLinks($institutionFilter = NULL) {
        // if no filter
        if($institutionFilter == NULL){
            $institutionFilter = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('FRONTAL\\FagInstitutionManagement\\Domain\\Model\\InstitutionFilter');
        }
        
        // build query
        $query = $this->createQuery();
        $constraints = array();

        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        // search string
        if (is_string($institutionFilter->getSearchString()) && strlen($institutionFilter->getSearchString()) > 0) {
            $searchWords = explode(' ', $institutionFilter->getSearchString());

            //fields from settings
            $propertiesToSearch = $institutionFilter->getSearchFields();
            foreach($searchWords as $searchWord){
                $searchWordConstraints = array();
                foreach ($propertiesToSearch as $propertyName) {
                    $searchWordConstraints[] = $query->like($propertyName, '%' . $searchWord . '%');
                }

                $constraints[] = $query->logicalOr($searchWordConstraints);
            }
        }

        // merge Conditions AND
        if (count($constraints)>0) {
            $query->matching($query->logicalAnd($constraints));
        }

        // sorting
        if ($institutionFilter->getSorting()) {
            $sortArr = explode(' ',$institutionFilter->getSorting());
            $sortField = $sortArr[0];
            $sortDirection = ($sortArr[1] == 'DESC') ? \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING : \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;

            $query->setOrderings (array($sortField => $sortDirection));
        }
        else {
            $query->setOrderings (array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                                        'city' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        }

        // limit
        if ($institutionFilter->getLimit() > 0) {
            $query->setLimit($institutionFilter->getLimit());
        }

        // execute
        $result = $query->execute();

        return $result;
    }

	/**
	 * Get institutions by search form filter
	 *
	 * @param \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter $institutionFilter Event Filter object
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Institution>
	 */
	public function findByFilter($institutionFilter = NULL) {
        
        // if no filter
        if($institutionFilter == NULL){
            $institutionFilter = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('FRONTAL\\FagInstitutionManagement\\Domain\\Model\\InstitutionFilter');
        }


        // build query
        $query = $this->createQuery();
        $constraints = array();

        // search string
        if (is_string($institutionFilter->getSearchString()) && strlen($institutionFilter->getSearchString()) > 0) {
            $searchWords = explode(' ', $institutionFilter->getSearchString());

            //fields from settings
            $propertiesToSearch = $institutionFilter->getSearchFields();
            foreach($searchWords as $searchWord){
                $searchWordConstraints = array();
                foreach ($propertiesToSearch as $propertyName) {
                    $searchWordConstraints[] = $query->like($propertyName, '%' . $searchWord . '%');
                }

                $constraints[] = $query->logicalOr($searchWordConstraints);
            }
        }

        /**
         *		Categories (1-3)
         *
         */
        for ($i = 1; $i <= 3; $i ++) {

            // category (single select dropdown in filter)
            if (method_exists($institutionFilter, 'getSearchCategory' . $i)) {
                $searchCategory = call_user_func_array(array( $institutionFilter, 'getSearchCategory' . $i), array() );
                if ($searchCategory != NULL) {
                    $constraints[] = $query->contains('categories', $searchCategory);
                }
            }

            // categories (multi select dropdown in filter)
            if (method_exists($institutionFilter, 'getSearchCategories' . $i)) {
                $searchCategories = call_user_func_array(array( $institutionFilter, 'getSearchCategories' . $i), array() );
                if ($searchCategories != NULL) {
                    $subConstraints = array();
                    foreach($searchCategories as $searchCategory){
                        $subConstraints[] = $query->contains('categories', $searchCategory);
                    }
                    if (count($subConstraints) > 0) $constraints[] = $query->logicalOr($subConstraints);
                    unset($subConstraints);
                }
            }
        }

        // allowed categories (set in flexform)
        $allowedCategories = $institutionFilter->getAllowedCategories();
        if ($allowedCategories != NULL) {
            $subConstraints = array();
            foreach($allowedCategories as $allowedCategory){
                $subConstraints[] = $query->contains('categories', $allowedCategory);
            }
            if (count($subConstraints) > 0) {
                    $constraints[] = $query->logicalOr($subConstraints);
            }
            unset($subConstraints);
        }

        // merge Conditions AND
        if (count($constraints)>0) {
            $query->matching($query->logicalAnd($constraints));
        }

        // sorting
        if ($institutionFilter->getSorting()) {
            $sortArr = explode(' ',$institutionFilter->getSorting());
            $sortField = $sortArr[0];
            $sortDirection = ($sortArr[1] == 'DESC') ? \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING : \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;

            $query->setOrderings (array($sortField => $sortDirection));
        }
        else {
            $query->setOrderings (array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                                        'city' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        }

        // limit
        if ($institutionFilter->getLimit() > 0) {
            $query->setLimit($institutionFilter->getLimit());
        }

        // execute
        $result = $query->execute();

        return $result;
    }

    /**
     * Get institutions by search By User(
     *
     */

    public function findByUser($uid, $id)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $statement = $queryBuilder
            ->select('fe_users.uid')
            ->from('fe_users')
            ->join(
                'fe_users',
                'tx_faginstitutionmanagement_fe_users_institution_mm',
                'userinst',
                $queryBuilder->expr()->eq('userinst.uid_foreign', $queryBuilder->quoteIdentifier('fe_users.uid'))
            )
            ->where(
                $queryBuilder->expr()->eq('userinst.uid_local', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('fe_users.uid', $queryBuilder->createNamedParameter($id, \PDO::PARAM_INT))
            )
            ->execute()->fetch();
        return $statement;
    }

    /**
     * @param $modeluid
     * @param $field
     * @param int $uid
     */
    public function removeFileRefrence($modeluid, $field, $uid = 0)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');

//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($uid);
//        die;

        $queryBuilder->delete('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($modeluid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter($field))
            );
        if ($uid > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)));
        }
        $queryBuilder->execute();
    }

    /**
     * @param int $uid
     */
    public function findByAdmin($uid)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('admin.uid', $uid));
        return $query->execute();
    }
}
