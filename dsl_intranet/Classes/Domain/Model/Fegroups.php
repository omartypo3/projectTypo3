<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;
use DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * Fegroups
 */
class Fegroups extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
{


    public function getMitarbeiter()
    {
        $mitarbeiterRepository = GeneralUtility::makeInstance(MitarbeiterRepository::class);
        return $mitarbeiterRepository->findByGroup($this);
    }
}
