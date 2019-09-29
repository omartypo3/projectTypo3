<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
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
class UserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    public function initializeObject() {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);

        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Get all city councils
     * 
     * @param integer $storagePid
     * @param bool $respectStoragePage
     * @param bool $deputy
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User>
     */
    public function findCityCouncil($storagePid=418,$respectStoragePage=TRUE,$deputy=FALSE){

        // build query
        $query = $this->createQuery();
        $constraints = array();

        $query->getQuerySettings()->setRespectStoragePage($respectStoragePage);

        if($respectStoragePage) {
            $query->getQuerySettings()->setStoragePageIds(explode(',',$storagePid));
        }

        if($query->getQuerySettings()->getRespectStoragePage() == '0') {
            $constraints[] = $query->equals('ismanagement', 1);
            $query->setOrderings(
                ['management_position' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING]
            );
        }

        if($deputy) {
            $query->getQuerySettings()->setRespectStoragePage(FALSE);
            $constraints[] = $query->equals('ismanagement_deputy', 1);
            $query->setOrderings(
                ['management_deputy_position' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING]
            );
        }

        // merge Conditions AND
        if (count($constraints)>0) {
            $query->matching($query->logicalAnd($constraints));
        }

        $result = $query->execute();

        return $result;
    }

	/**
	 * Get events by search form filter
	 *
	 * @param \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter $peopleFilter Event Filter object
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User>
	 */
	public function findByFilter($peopleFilter = NULL) {

        // if no filter
        if($peopleFilter == NULL){
            $peopleFilter = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('FRONTAL\\FagInstitutionManagement\\Domain\\Model\\InstitutionFilter');
        }


        // build query
        $query = $this->createQuery();
        $constraints = array();

        // search string
        if (is_string($peopleFilter->getSearchString()) && strlen($peopleFilter->getSearchString()) > 0) {
            $searchWords = explode(' ', $peopleFilter->getSearchString());

            //fields from settings
            $propertiesToSearch = $peopleFilter->getSearchFields();
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
            if (method_exists($peopleFilter, 'getSearchCategory' . $i)) {
                $searchCategory = call_user_func_array(array( $peopleFilter, 'getSearchCategory' . $i), array() );
                if ($searchCategory != NULL) {
                    $constraints[] = $query->contains('categories', $searchCategory);
                }
            }

            // categories (multi select dropdown in filter)
            if (method_exists($peopleFilter, 'getSearchCategories' . $i)) {
                $searchCategories = call_user_func_array(array( $peopleFilter, 'getSearchCategories' . $i), array() );
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

        // searchInstitution
        if(method_exists($peopleFilter, 'getSearchInstitution')){
            $searchInstitution = call_user_func_array(array( $peopleFilter, 'getSearchInstitution'), array() );
            if($searchInstitution != NULL){
                $constraints[] = $query->equals('roles.institution', $searchInstitution);
            }
        }

        // allowed categories (set in flexform)
        $allowedCategories = $peopleFilter->getAllowedCategories();
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
        if ($peopleFilter->getSorting()) {
            $sortArr = explode(' ',$peopleFilter->getSorting());
            $sortField = $sortArr[0];
            $sortDirection = ($sortArr[1] == 'DESC') ? \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING : \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;

            $query->setOrderings (array($sortField => $sortDirection));
        }
        else {
            $query->setOrderings (array('last_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                                        'first_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        }

        // limit
        if ($peopleFilter->getLimit() > 0) {
            $query->setLimit($peopleFilter->getLimit());
        }

        // execute
        $result = $query->execute();

        return $result;
    }

    /**
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findUsers($email, $first_name, $last_name)
    {
        $query = $this->createQuery();
        $constraints = [];
        if (empty($first_name) == false) {
            $constraints[] = $query->like('first_name', '%' . $first_name . '%');
        }
        if (empty($last_name) == false) {
            $constraints[] = $query->like('last_name', '%' . $last_name . '%');
        }
        if (empty($email) == false) {
            $constraints[] = $query->equals('email', $email);
        }

        $query->matching($query->logicalOr( $constraints));


        return $query->execute();
    }

    /**
     * @param int $modeluid
     */
    public function removeFileRefrence($modeluid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
        $queryBuilder
            ->delete('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($modeluid, \PDO::PARAM_INT))
            )
            ->execute();
    }
}
