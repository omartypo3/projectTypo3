<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Repository;


/**
 * This file is part of the "pingagaddress" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */

/**
 * The repository for Language
 */
class LanguageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function getOrder()
    {
        $query = $this->createQuery();
        $query->setOrderings(array("orderOtherLanguages" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)); // array
        return $query->execute();
    }

    public function getOrderName($uids)
    {

        $query = $this->createQuery();
        $query->matching($query->logicalNot($query->in('uid', $uids)));
        $query->setOrderings(array("orderOtherLanguages" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)); // array
        return $query->execute();
    }
}
