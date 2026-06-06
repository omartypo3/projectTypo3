<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository;

use Stratis\StratisServices\DependencyInjection\ContainerAwareTrait;
use Stratis\StratisSocialAuth\Domain\Model\Configuration;
use Stratis\StratisSocialAuth\Domain\Model\Provider;
use Stratis\StratisSocialAuth\Domain\Model\SocialAccount;
use Stratis\StratisSocialAuth\Domain\Model\User;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;

/**
 * Class SocialAccountRepository
 * @package Stratis\StratisSocialAuth\Domain\Repository
 */
class SocialAccountRepository extends AbstractRepository
{
    use ContainerAwareTrait;

    /**
     * @param Configuration $configuration
     * @param Provider $provider
     * @param string $identifier
     * @param User $user
     *
     * @return SocialAccount
     * @throws IllegalObjectTypeException
     */
    public function createSocialAccount(
        Configuration $configuration,
        Provider $provider,
        string $identifier,
        User $user
    ): SocialAccount {
        /** @var SocialAccount $account */
        $account = $this->getContainer()->get(SocialAccount::class);
        $account->setProvider($provider);
        $account->setPid($configuration->getStoragePid());
        $account->setIdentifier($identifier);
        $account->setUser($user);
        $this->add($account);

        return $account;
    }
}
