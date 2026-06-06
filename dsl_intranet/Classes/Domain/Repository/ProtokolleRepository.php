<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
 * The repository for Protokolles
 */
class ProtokolleRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
        $querySettings->setStoragePageIds(array(9));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function findByAuftraege(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege = NULL)
    {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('auftrag', $auftraege);
        $user = $GLOBALS['TSFE']->fe_user->user;
        switch ($user['tx_extbase_type']) {
            case 'Tx_DslIntranet_Mitarbeiter':    $query->getQuerySettings()->setIgnoreEnableFields(true);
                break;
            case 'Tx_DslIntranet_Kunden':    $query->getQuerySettings()->setIgnoreEnableFields(false);
                $constraints[] = $query->equals('kundeninfo_sichtbarkeit', 1);
                break;
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function findKommentareByAuftraege(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege = NULL)
    {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('auftrag', $auftraege);
        $constraints[] = $query->equals('aktion', 20);
        $user = $GLOBALS['TSFE']->fe_user->user;
        //echo $user['tx_extbase_type'];
        switch ($user['tx_extbase_type']) {
            case 'Tx_DslIntranet_Mitarbeiter':    $query->getQuerySettings()->setIgnoreEnableFields(true);
                break;
            case 'Tx_DslIntranet_Kunden':    $query->getQuerySettings()->setIgnoreEnableFields(false);
                $constraints[] = $query->equals('kundeninfo_sichtbarkeit', 1);
                //echo "asdjkhasldkjhadlkjh";
                break;
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function findStatusmeldungenByAuftraege(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege = NULL)
    {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('auftrag', $auftraege);
        $constraints[] = $query->logicalNot($query->equals('aktion', 20));
        $user = $GLOBALS['TSFE']->fe_user->user;
        switch ($user['tx_extbase_type']) {
            case 'Tx_DslIntranet_Mitarbeiter':    $query->getQuerySettings()->setIgnoreEnableFields(true);
                break;
            case 'Tx_DslIntranet_Kunden':    $query->getQuerySettings()->setIgnoreEnableFields(false);
                $constraints[] = $query->equals('kundeninfo_sichtbarkeit', 1);
                break;
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     */
    public function findByDateien(\DslFactory\DslIntranet\Domain\Model\Dateien $dateien = NULL)
    {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('datei', $dateien);
        $user = $GLOBALS['TSFE']->fe_user->user;
        switch ($user['tx_extbase_type']) {
            case 'Tx_DslIntranet_Mitarbeiter':    $query->getQuerySettings()->setIgnoreEnableFields(true);
                break;
            case 'Tx_DslIntranet_Kunden':    $query->getQuerySettings()->setIgnoreEnableFields(false);
                $constraints[] = $query->equals('kundeninfo_sichtbarkeit', 1);
                break;
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\ProtokollePending protokollePending
     */
    public function findProtokollByProtokollePending($protokollePending)
    {
        //return false;
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->contains('pending', $protokollePending);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        if ($posts->getFirst()) {
            return $posts->getFirst();
        } else {
            return false;
        }
    }
}
