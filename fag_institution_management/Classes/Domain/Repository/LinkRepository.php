<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Repository;

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
class LinkRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject() {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);

        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * findByCategories
     * @param  $categories
     * @param  boolean $groupByCategories
     */
    public function findByCategories($categories, $groupByCategories=false)
    {
        if($groupByCategories){
            $groupedByCategories = [];
            foreach($categories as $category) {
                $query = $this->createQuery();
                $groupedByCategories[$category->getTitle()] = $query->matching(
                    $query->logicalOr(
                        $query->contains('categories', $category)
                    )
                )->execute();
            }
            return $groupedByCategories;
        }else{
            $query = $this->createQuery();
            $constraints = [];    
            foreach($categories as $category) {
                $constraints[] = $query->contains('categories', $category);
            }
            $query->matching(
                $query->logicalOr($constraints)
            );
            return $query->execute();
        }
    }
}
