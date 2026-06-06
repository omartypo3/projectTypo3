<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository;

use Stratis\StratisServices\DependencyInjection\ContainerAwareTrait;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class AbstractRepository
 * @package Stratis\StratisSocialAuth\Domain\Repository
 */
abstract class AbstractRepository extends Repository
{
    use ContainerAwareTrait;

    /**
     * Override default querySettings
     */
    public function initializeObject(): void
    {
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $this->getContainer()->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
}
