<?php

declare(strict_types=1);

namespace Stratis\StratisMobileapp\Domain\Repository;

use Stratis\StratisMobileapp\Domain\Model\AppSettings;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @extends Repository<AppSettings>
 *
 * @method AppSettings|null findOneByUid(int $uid)
 * @method \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<AppSettings> findAll()
 * @method void add(AppSettings $object)
 * @method void update(AppSettings $object)
 */
class AppSettingsRepository extends Repository
{
}
