<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder;

/**
 * Class ConfigurationRepository
 *
 * @author Vladimir Cherednichenko <vova.cherednichenko.stratis@gmail.com>
 */
class ConfigurationRepository extends BaseRepository
{
    public function __construct()
    {
        $this->table = 'tx_stratissocialauth_domain_model_configuration';
    }
}
