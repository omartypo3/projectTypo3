<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder;

use Doctrine\DBAL\Exception;

/**
 * Class SocialAccountRepository
 *
 * @author Vladimir Cherednichenko <vova.cherednichenko.stratis@gmail.com>
 */
class SocialAccountRepository extends BaseRepository
{
    public function __construct()
    {
        $this->table = 'tx_stratissocialauth_domain_model_social_account';
    }

    /**
     * @param string $identifier
     * @param array $user
     * @param array $provider
     * @return int
     * @throws Exception
     */
    public function createOrUpdateUserAccount(string $identifier, array $user, array $provider): int
    {
        $accountParameters = [
            'pid' => $user['pid'],
            'identifier' => $identifier,
            'user' => $user['uid'],
            'provider' => $provider['uid'],
        ];
        $account = $this->fetchByParams($accountParameters);

        return $account[0]['uid'] ?? $this->create($accountParameters);
    }
}
