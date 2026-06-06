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
 * The repository for Agenturvertraeges
 */
class ProjekteRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
        //$querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(9, 25));
        $this->setDefaultQuerySettings($querySettings);
    }

    public function findAllOffen()
    {
        $query = $this->createQuery();
        $query->matching($query->equals('abgeschlossen', 0));
        $posts = $query->execute();
        return $posts;
    }
	
	
    public function findAllAbgeschlossen()
    {
        $query = $this->createQuery();
        $query->matching($query->equals('abgeschlossen', 1));
        $posts = $query->execute();
        return $posts;
    }
	
	
	
	/**
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunde
     * @param string $datum	 
     */
	
    public function findByKunde($kunde)
    {

        $query = $this->createQuery();

        $andConstraints = array();
        $andConstraints[] = $query->equals('kunde', $kunde);
		

        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
		return $query->execute();
		
    }
	
	
	/**
     * @param string $search	 
     */
	
    public function findBySearch($search)
    {

        $query = $this->createQuery();

        $andConstraints = array();
        //$andConstraints[] = $query->equals('kunde', $kunde);
		
		$searchOrConstraints = array();
		$searchOrConstraints[] = $query->like('titel', '%' . $search . '%');
		
		
		
		$tmp = strtolower($search);
		if(substr($tmp,0,1) == "p"){
			$tmp = ltrim($tmp,'p');
			$tmp = ltrim($tmp,'0');
			$searchOrConstraints[] = $query->equals('uid', (int) $tmp);	
		}
		
		if (count($searchOrConstraints)) {
            $andConstraints[] = $query->logicalOr($searchOrConstraints);
        }
		

        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
		return $query->execute();
		
    }
	
	
	
	
}
