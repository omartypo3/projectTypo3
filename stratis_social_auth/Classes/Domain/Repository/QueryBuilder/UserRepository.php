<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder;

use Doctrine\DBAL\Exception;
use Hybridauth\User\Profile;
use Stratis\StratisServices\DependencyInjection\ContainerAwareTrait;
use Stratis\StratisSocialAuth\Domain\Model\Provider;
use Stratis\StratisSocialAuth\Utility\DateUtility;
use Stratis\StratisSocialAuth\Utility\PasswordUtility;
use Stratis\StratisSocialAuth\Utility\StringUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class UserRepository
 *
 * @author Vladimir Cherednichenko <vova.cherednichenko.stratis@gmail.com>
 */
class UserRepository extends BaseRepository
{
    use ContainerAwareTrait;

    protected string $socialAccountTable = 'tx_stratissocialauth_domain_model_social_account';

    public function __construct()
    {
        $this->table = 'fe_users';
    }

    /**
     * @param array $configuration
     * @param array $provider
     * @param Profile $externalUser
     * @return array
     * @throws \Exception
     */
    public function getUser(array $configuration, array $provider, Profile $externalUser): array
    {
        $email = (string) (!empty($externalUser->emailVerified) ? $externalUser->emailVerified : $externalUser->email);
        $email = StringUtility::sanitize($email);
        $identifier = StringUtility::sanitize($externalUser->identifier === null ? '': (string)$externalUser->identifier);

        $user = $this->findFirstUserByEmailOrAccount($configuration, (int) $provider['uid'], $email, $identifier);

        if ($user === null) {
            $user = $this->createUser($configuration, $provider, $externalUser, $email, $identifier);
        } elseif ($provider['type'] === Provider::FRANCE_CONNECT) {
            $socialAccountRepository = $this->getContainer()->get(SocialAccountRepository::class);
            $account = $socialAccountRepository->createOrUpdateUserAccount($identifier, $user, $provider);
            $user = $this->updateForFranceConnect($user, $externalUser, $account);
        }

        $user['fromHybrid'] = true;

        return $user;
    }

    /**
     * Search by email or by already bound account
     *
     * @param array $configuration
     * @param int $provider
     * @param string $email
     * @param string $identifier
     *
     * @return array|null
     * @throws Exception
     */
    protected function findFirstUserByEmailOrAccount(array $configuration, int $provider, string $email, string $identifier): ?array
    {
        $queryBuilder = $this->getQueryBuilder($this->socialAccountTable, 'sa');

        $account = $queryBuilder
            ->select('sa.*')
            ->where(
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->eq('sa.pid', $queryBuilder->createNamedParameter($configuration['storage_pid'], \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('sa.identifier', $queryBuilder->createNamedParameter($identifier, \PDO::PARAM_STR))
                )
            )
            ->executeQuery()
            ->fetchAssociative();

        $queryBuilder = $this->getQueryBuilder($this->table, 'u');

        return $queryBuilder
            ->select('u.*')
            ->where(
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->eq('u.pid', $configuration['storage_pid']),
                    $queryBuilder->expr()->or(
                        $queryBuilder->expr()->or(
                            $queryBuilder->expr()->eq('u.username', $queryBuilder->createNamedParameter($email, \PDO::PARAM_STR)),
                            $queryBuilder->expr()->eq('u.email', $queryBuilder->createNamedParameter($email, \PDO::PARAM_STR)),
                        ),
                        $queryBuilder->expr()->eq('u.uid', $queryBuilder->createNamedParameter($account['user'], \PDO::PARAM_INT))
                    )
                )
            )
            ->executeQuery()
            ->fetchAssociative() ?: null;
    }

    /**
     * @param array $configuration
     * @param array $provider
     * @param Profile $externalUser
     * @param string $email
     * @param string $identifier
     * @return array
     */
    protected function createUser(
        array $configuration,
        array $provider,
        Profile $externalUser,
        string $email,
        string $identifier
    ): array {
        if (!empty($email)) {
            $username = $email;
        } elseif ($provider['type'] === Provider::FRANCE_CONNECT && !empty($externalUser->firstName)) {
            $username = StringUtility::sanitize($externalUser->firstName . ' ' . $externalUser->displayName);
        } elseif (!empty($externalUser->displayName)) {
            $username = StringUtility::sanitize($externalUser->displayName);
        } else {
            return [];
        }

        $name = $provider['type'] === Provider::FRANCE_CONNECT ? $externalUser->displayName : $externalUser->lastName;

        $user = [
            'pid' => $configuration['storage_pid'],
            'tstamp' => time(),
            'crdate' => time(),
            'lastlogin' => time(),
            'username' => StringUtility::removeWhitespaces($username),
            'password' => PasswordUtility::generatePassword(),
            'email' => $email,
            'first_name' => StringUtility::sanitize($externalUser->firstName ?? ''),
            'last_name' => StringUtility::sanitize($externalUser->lastName ?? ''),
            'name' => StringUtility::sanitize($name ?? ''),
            'telephone' => StringUtility::sanitize($externalUser->phone ?? ''),
            'address' => StringUtility::sanitize($externalUser->address ?? ''),
            'city' => StringUtility::sanitize($externalUser->city ?? ''),
            'zip' => StringUtility::sanitize($externalUser->zip ?? ''),
            'country' => StringUtility::sanitize($externalUser->country ?? ''),
            'created_by_france_connect' => (int)($provider['type'] === Provider::FRANCE_CONNECT),
            'gender' => StringUtility::sanitize($externalUser->gender) === 'male' ? 0 : 1,
            'civility' => StringUtility::sanitize($externalUser->gender) === 'male' ? 2 : 1,
            'usergroup' => $configuration['default_groups'],
            'social_accounts' => 1,
            'date_of_birth' => DateUtility::getDateOfBirth($externalUser),
        ];

        // user must have an encrypted password to write to database
        $userToCreate = $user;
        $userToCreate['password'] = PasswordUtility::encryptNewPassword($userToCreate['password']);
        $user['uid'] = $this->create($userToCreate);

        $this->getContainer()->get(SocialAccountRepository::class)->create([
            'provider' => $provider['uid'],
            'pid' => $configuration['storage_pid'],
            'identifier' => $identifier,
            'user' => $user['uid'],
        ]);

        // @todo : notify user that password change and email set are required if the email was not sent
        // $this->getContainer()->get(MailService::class)->sendMail($configuration, $provider, $user);

        return $user;
    }

    /**
     * @param array $user
     * @param Profile $externalUser
     * @param int|null $accountId
     *
     * @return array
     */
    public function updateForFranceConnect(array $user, Profile $externalUser, int $accountId = null): array
    {
        $values = [
            'first_name' => StringUtility::sanitize($externalUser->firstName ?? ''),
            'last_name' => StringUtility::sanitize($externalUser->lastName ?? ''),
            'name' => StringUtility::sanitize($externalUser->displayName ?? ''),
            'gender' => StringUtility::sanitize($externalUser->gender) === 'male' ? 0 : 1,
            'civility' => StringUtility::sanitize($externalUser->gender) === 'male' ? 2 : 1,
            'created_by_france_connect' => 1,
            'telephone' => StringUtility::sanitize($externalUser->phone ?? ''),
            'address' => StringUtility::sanitize($externalUser->address ?? ''),
            'city' => StringUtility::sanitize($externalUser->city ?? ''),
            'zip' => StringUtility::sanitize($externalUser->zip ?? ''),
            'country' => StringUtility::sanitize($externalUser->country ?? ''),
            'email' => StringUtility::sanitize($externalUser->email ?? ''),
            'date_of_birth' => DateUtility::getDateOfBirth($externalUser),
        ];

        if ($accountId && $user['social_accounts'] && !$this->isAccountAttached($accountId, $user['social_accounts'])) {
            $values['social_accounts'] = sprintf('%s,%d', $user['social_accounts'], $accountId);
        } else {
            $values['social_accounts'] = $accountId;
        }

        $this->update($user['uid'], $values);

        return array_merge($user, $values);
    }

    /**
     * @param int $id
     * @param string $accounts
     * @return bool
     */
    private function isAccountAttached(int $id, string $accounts): bool
    {
        return in_array($id, GeneralUtility::intExplode(',', $accounts, true));
    }
}
