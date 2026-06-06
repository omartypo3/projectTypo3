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
 * The repository for Zeiteintraeges
 */
class ZeiteintraegeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'end' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
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

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function findOpened(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL, \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege = NULL)
    {
        //echo "blaa";
        $query = $this->createQuery();
        $andConstraints = array();
        if ($auftraege) {
            $andConstraints[] = $query->equals('auftraege', $auftraege);
        }
        $andConstraints[] = $query->equals('end', 0);
        //$andConstraints[] = $query->equals('cruser', $mitarbeiter);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
       
        return $query->execute()->getFirst();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function findRunning(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        //        $andConstraints[] = $query->equals('end', 0);
        $andConstraints[] = $query->equals('zeitnahme', 1);
        $andConstraints[] = $query->equals('cruser', $mitarbeiter);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        return $query->execute()->getFirst();
    }

    public function findAllRunning()
    {
        $query = $this->createQuery();
        $andConstraints = array();
        //        $andConstraints[] = $query->equals('end', 0);
        $andConstraints[] = $query->equals('zeitnahme', 1);
        ///        $andConstraints[] = $query->equals('cruser', $mitarbeiter);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        return $query->execute();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function findOtherRunning(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL, \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        //	$andConstraints[] = $query->equals('auftraege', $auftraege);
        //$andConstraints[] = $query->equals('end', 0);
        $andConstraints[] = $query->equals('cruser', $mitarbeiter);
        $andConstraints[] = $query->equals('zeitnahme', 1);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints), $query->logicalNot($query->equals('auftraege', $auftraege)));
        }
        return $query->execute();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function findLast(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL)
    {
        //neue funktion um den letzten gespeicherten zeiteintrag zu finden
        $query = $this->createQuery();
        $andConstraints = array();
        //	$andConstraints[] = $query->equals('auftraege', $auftraege);
        $andConstraints[] = $query->greaterThan('end', 0);
        $andConstraints[] = $query->equals('cruser', $mitarbeiter);
        // $andConstraints[] = $query->equals('zeitnahme', 1);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        return $query->execute()->getFirst();
    }

    /**
     * @param integer $oldid
     */
    public function findByOldid($oldid)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('oldid', $oldid)));
        $posts = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \DateTime $date
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function findAktivitaeten(\DateTime $date, \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL)
    {
        //echo "blaa";
        $query = $this->createQuery();
        $andConstraints = array();
        if ($mitarbeiter) {
            $andConstraints[] = $query->equals('cruser', $mitarbeiter);
        }
        //$date->format('Y-m-d')
        $dayBegin = new \DateTime($date->format('Y-m-d') . ' 00:00:00');
        $dayEnd = new \DateTime($date->format('Y-m-d') . '23:59:59');
        $andConstraints[] = $query->greaterThanOrEqual('begin', $dayBegin->getTimestamp());
        $andConstraints[] = $query->lessThan('begin', $dayEnd->getTimestamp() + 1);
        //$andConstraints[] = $query->equals('end', 0);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $query->execute();
    }
	
	
	
    public function getAktivitaetenRange()
    {
		
		$range=array();
		
		$query = $this->createQuery();
		
		
//$query->statement('SELECT tx_dslintranet_domain_model_dateien.uid FROM tx_dslintranet_domain_model_dateien LEFT JOIN fe_users ON fe_users.uid = tx_dslintranet_domain_model_dateien.kunden WHERE tx_dslintranet_domain_model_dateien.kunden AND ( fe_users.tstamp>tx_dslintranet_domain_model_dateien.tstamp OR tx_dslintranet_domain_model_dateien.temp_timestamp=\'0\' ) ');
		
			
		$sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(begin), '%Y-%m-%d %H:%i:%s') as begin_formatted FROM tx_dslintranet_domain_model_zeiteintraege WHERE FIND_IN_SET(pid,'9,25') and deleted = 0 and hidden = 0  and kontingent > 0 ORDER BY begin ASC LIMIT 0,1";
		$query->statement($sql);
		$row = $query->execute(TRUE);
		
		$range[0]=$row[0]["begin_formatted"];
		
		
		$sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(begin), '%Y-%m-%d %H:%i:%s') as begin_formatted FROM tx_dslintranet_domain_model_zeiteintraege WHERE FIND_IN_SET(pid,'9,25') and deleted = 0 and hidden = 0  and kontingent > 0 ORDER BY begin DESC LIMIT 0,1";
		$query->statement($sql);
		$row = $query->execute(TRUE);
		
		
		$range[1]=$row[0]["begin_formatted"];
		
		/*?><pre><?php var_dump(intval($row[0]["kontingent_summe"]));*/
		return $range;

		
	}
	
	
	//SELECT begin FROM tx_dslintranet_domain_model_zeiteintraege WHERE FIND_IN_SET(pid,'9,25') and deleted = 0 and hidden = 0 and cruser = 1 and kontingent > 0 ORDER BY begin ASC LIMIT 0,1
	
	//SELECT begin FROM tx_dslintranet_domain_model_zeiteintraege WHERE FIND_IN_SET(pid,'9,25') and deleted = 0 and hidden = 0 and cruser = 1 and kontingent > 0 ORDER BY begin DESC LIMIT 0,1
	
/**
     * @param \DateTime $dateBegin
	 * @param \DateTime $dateEnd
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function findAktivitaetenInRange(\DateTime $dateBegin,\DateTime $dateEnd, \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL)
    {
		
        //echo "blaa";
        $query = $this->createQuery();
		
		
//$query->statement('SELECT tx_dslintranet_domain_model_dateien.uid FROM tx_dslintranet_domain_model_dateien LEFT JOIN fe_users ON fe_users.uid = tx_dslintranet_domain_model_dateien.kunden WHERE tx_dslintranet_domain_model_dateien.kunden AND ( fe_users.tstamp>tx_dslintranet_domain_model_dateien.tstamp OR tx_dslintranet_domain_model_dateien.temp_timestamp=\'0\' ) ');
		
		$sql = "SELECT SUM(kontingent) as kontingent_summe FROM tx_dslintranet_domain_model_zeiteintraege WHERE FIND_IN_SET(pid,'9,25') and deleted = 0 and hidden = 0 and cruser = ".$mitarbeiter->getUid()." and kontingent > 0 and begin > ".$dateBegin->getTimestamp()." and begin < ".$dateEnd->getTimestamp();
		$query->statement($sql);
		$row = $query->execute(TRUE);
		/*?><pre><?php var_dump(intval($row[0]["kontingent_summe"]));*/
		return intval($row[0]["kontingent_summe"]);

        $andConstraints = array();
        if ($mitarbeiter) {
            $andConstraints[] = $query->equals('cruser', $mitarbeiter);
        }
        //$date->format('Y-m-d')
        $dayBegin = new \DateTime($dateBegin->format('Y-m-d') . ' 00:00:00');
        $dayEnd = new \DateTime($dateEnd->format('Y-m-d') . ' 23:59:59');
        $andConstraints[] = $query->greaterThanOrEqual('begin', $dayBegin->getTimestamp());
		//echo '<br>:greaterThanOrEqual(\'begin\', '.$dayBegin->getTimestamp().')';
		//echo $dayBegin->getTimestamp();
		//echo ":::".$dayBegin->format('Y-m-d H:i:s');
        $andConstraints[] = $query->lessThan('begin', $dayEnd->getTimestamp() + 1);
        //$andConstraints[] = $query->equals('end', 0);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
		
		//$queryParser = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser::class);
		//$queryParser = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser');
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL());
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL());
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $query->execute();
    }	

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function findAktivitaetenForAuftrag(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege = NULL, \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL)
    {
        //echo "blaa";
        $query = $this->createQuery();
        $andConstraints = array();
        if ($mitarbeiter) {
            $andConstraints[] = $query->equals('cruser', $mitarbeiter);
        }
        if ($auftraege) {
            $andConstraints[] = $query->equals('auftraege', $auftraege);
        }
        //$date->format('Y-m-d')
        //$dayBegin = new \DateTime($date->format('Y-m-d')." 00:00:00");
        //$dayEnd =  new \DateTime($date->format('Y-m-d')."23:59:59");
        //$andConstraints[] = $query->greaterThanOrEqual('begin', $dayBegin->getTimestamp() );
        //$andConstraints[] = $query->lessThan('begin', $dayEnd->getTimestamp()+1 );
        //$andConstraints[] = $query->equals('end', 0);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $query->execute();
    }
}
