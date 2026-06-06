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
class AgenturvertraegeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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

    public function findAllByKunde()
    {
        //return false;
        $query = $this->createQuery();
        $andConstraints = array();
        //$andConstraints[] = $query->equals('kunde', $agenturvertrag->getKunde());
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }
	
	
	
	
	/**
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunde
     * @param string $datum	 
     */
    public function findAgenturvertragByKundeDatum($kunde,$datum)
    {

        $query = $this->createQuery();

        $andConstraints = array();
        $andConstraints[] = $query->equals('kunde', $kunde);
		$andConstraints[] = $query->lessThanOrEqual('vertragsbegin', $datum);
		$andConstraints[] = $query->logicalOr(array($query->greaterThanOrEqual('vertragsende', $datum),$query->equals('vertragsende', '0000-00-00')));

        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }

		if($agenturvertrag = $query->execute()->getFirst()){
			return round($agenturvertrag->getStundensatz(),2);

		}
		return NULL;
		
    }
	
	
}
