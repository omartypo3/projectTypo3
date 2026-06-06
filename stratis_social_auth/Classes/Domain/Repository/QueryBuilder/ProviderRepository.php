<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder;

/**
 * Class ProviderRepository
 *
 * @author Vladimir Cherednichenko <vova.cherednichenko.stratis@gmail.com>
 */
class ProviderRepository extends BaseRepository
{
    public function __construct()
    {
        $this->table = 'tx_stratissocialauth_domain_model_provider';
    }
}
