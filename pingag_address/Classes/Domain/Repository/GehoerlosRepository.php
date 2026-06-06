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
 * The repository for Gehoerlos
 */
class GehoerlosRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $defaultOrderings =
        array(
            'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        );
    public function initializeObject()
    {
        $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
}
