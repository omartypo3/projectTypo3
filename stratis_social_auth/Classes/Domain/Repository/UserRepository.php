<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository;

use Hybridauth\User\Profile;
use Stratis\StratisSocialAuth\Domain\Model\Configuration;
use Stratis\StratisSocialAuth\Domain\Model\Provider;
use Stratis\StratisSocialAuth\Domain\Model\User;
use Stratis\StratisSocialAuth\Service\MailService;
use Stratis\StratisSocialAuth\Utility\DateUtility;
use Stratis\StratisSocialAuth\Utility\PasswordUtility;
use Stratis\StratisSocialAuth\Utility\StringUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Persistence\Generic\Exception\TooDirtyException;

/**
 * Class UserRepository
 * @package Stratis\StratisSocialAuth\Domain\Repository
 */
class UserRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     * @param SocialAccountRepository $socialAccountRepository
     * @param MailService $mailService
     */
    public function __construct(
        protected SocialAccountRepository $socialAccountRepository,
        protected MailService $mailService
    ) {
        parent::__construct();
    }

    /**
     * @param int $uid
     *
     * @return array
     */
    public function findArrayByUid(int $uid): array
    {
        $query = $this->createQuery();

        $result = $query->matching(
            $query->logicalAnd(
                $query->equals('uid', $uid)
            )
        )->execute(true);

        return array_shift($result) ?? [];
    }

    /**
     * Search by email or by already bound account
     *
     * @param Configuration $configuration
     * @param Provider $provider
     * @param string $email
     * @param string $identifier
     * @return array
     */
    protected function findFirstUserByEmailOrAccount(Configuration $configuration, Provider $provider, string $email, string $identifier): array
    {
        $query = $this->createQuery();

        $constraints = $query->logicalAnd(
            $query->equals('pid', $configuration->getStoragePid()),
            $query->logicalOr(
                $query->logicalOr(
                    $query->equals('username', $email),
                    $query->equals('email', $email)
                ),
                $query->logicalAnd(
                    $query->equals('socialAccounts.identifier', $identifier),
                    $query->equals('socialAccounts.provider', $provider)
                )
            )
        );

        $result = $query->matching($query->logicalAnd($constraints))->execute(true);

        return array_shift($result) ?? [];
    }

    /**
     * @param Configuration $configuration
     * @param Provider $provider
     * @param Profile $externalUser
     * @return array
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     * @throws TooDirtyException
     */
    public function getUser(Configuration $configuration, Provider $provider, Profile $externalUser): array
    {
        $email = (string)!empty($externalUser->emailVerified) ? $externalUser->emailVerified : $externalUser->email;
        $email = StringUtility::sanitize($email);
        $identifier = StringUtility::sanitize($externalUser->identifier === null ? '' : (string)$externalUser->identifier);

        $user = $this->findFirstUserByEmailOrAccount($configuration, $provider, $email, $identifier);

        if (empty($user) === true) {
            $uid = $this->createUser($configuration, $provider, $externalUser, $email, $identifier);
            $user = $this->findArrayByUid($uid);
        } elseif ($provider->getType() === Provider::FRANCE_CONNECT) {
            $user = $this->updateForFranceConnect($user, $externalUser);
        }

        $user['fromHybrid'] = true;

        return $user;
    }

    /**
     * @param array $user
     * @param Profile $externalUser
     * @return array
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     * @throws TooDirtyException
     */
    public function updateForFranceConnect(array $user, Profile $externalUser): array
    {
        /** @var User $frontendUser */
        $frontendUser = $this->findByUid($user['uid']);

        $email = StringUtility::sanitize($externalUser->email);
        if ($email) {
            $frontendUser->setEmail($email);
            $user['email'] = $email;
        }

        $name = StringUtility::sanitize($externalUser->displayName);
        if ($name) {
            $frontendUser->setName($name);
            $user['name'] = $name;
        }

        $firstName = StringUtility::sanitize($externalUser->firstName);
        if ($firstName) {
            $frontendUser->setFirstName($firstName);
            $user['first_name'] = $firstName;
        }

        if (StringUtility::sanitize($externalUser->gender)) {
            $gender = StringUtility::sanitize($externalUser->gender) === 'male' ? 0 : 1;
            $frontendUser->setGender($gender);
            $user['gender'] = $gender;
        }

        $telephone = StringUtility::sanitize($externalUser->phone);
        if ($telephone) {
            $frontendUser->setTelephone($telephone);
            $user['telephone'] = $telephone;
        }

        $address = StringUtility::sanitize($externalUser->address ?? '');
        if ($address) {
            $frontendUser->setAddress($address);
            $user['address'] = $address;
        }

        $city = StringUtility::sanitize($externalUser->city ?? '');
        if ($city) {
            $frontendUser->setCity($city);
            $user['city'] = $city;
        }

        $zip = StringUtility::sanitize($externalUser->zip ?? '');
        if ($zip) {
            $frontendUser->setZip($zip);
            $user['zip'] = $zip;
        }

        $country = StringUtility::sanitize($externalUser->country ?? '');
        if ($country) {
            $frontendUser->setCountry($country);
            $user['country'] = $country;
        }

        $dateOfBirth = DateUtility::getDateOfBirth($externalUser);
        if ($dateOfBirth) {
            $frontendUser->setDateOfBirth($dateOfBirth);
            $user['date_of_birth'] = $dateOfBirth;
        }

        $frontendUser->setCreatedByFranceConnect(true);
        $user['created_by_france_connect'] = true;

        if ($frontendUser->_isDirty()) {
            $this->update($frontendUser);
            $this->persistenceManager->persistAll();
        }

        return $user;
    }

    /**
     * @param Configuration $configuration
     * @param Provider $provider
     * @param Profile $externalUser
     * @param string $email
     * @param string $identifier
     * @return int
     * @throws IllegalObjectTypeException
     */
    protected function createUser(
        Configuration $configuration,
        Provider $provider,
        Profile $externalUser,
        string $email,
        string $identifier
    ): int {
        $name = StringUtility::sanitize($externalUser->displayName);
        $username = !empty($email) ? $email : StringUtility::removeWhitespaces($name);
        $password = PasswordUtility::generatePassword();

        /** @var User $user */
        $user = $this->getContainer()->get(User::class);
        $user->setPid($configuration->getStoragePid());
        $user->setLastlogin(new \DateTime('now'));
        $user->setUsername($username);
        $user->setPassword(PasswordUtility::encryptNewPassword($password));
        $user->setEmail($email);

        if ($externalUser->firstName) {
            $user->setFirstName(StringUtility::sanitize($externalUser->firstName));
        }
        if ($externalUser->lastName) {
            $lastName = StringUtility::sanitize($externalUser->lastName);
            $user->setName($lastName);
            $user->setLastName($lastName);
        }
        if ($externalUser->phone) {
            $user->setTelephone(StringUtility::sanitize($externalUser->phone));
        }
        if ($externalUser->address) {
            $user->setAddress(StringUtility::sanitize($externalUser->address));
        }
        if ($externalUser->city) {
            $user->setCity(StringUtility::sanitize($externalUser->city));
        }
        if ($externalUser->zip) {
            $user->setZip(StringUtility::sanitize($externalUser->zip));
        }
        if ($externalUser->country) {
            $user->setCountry(StringUtility::sanitize($externalUser->country));
        }

        $dateOfBirth = DateUtility::getDateOfBirth($externalUser);
        if ($dateOfBirth) {
            $user->setDateOfBirth($dateOfBirth);
        }
        if ($provider->getType() === Provider::FRANCE_CONNECT) {
            if ($externalUser->displayName) {
                $user->setName(StringUtility::sanitize($externalUser->displayName));
            } elseif ($externalUser->lastName) {
                $user->setName(StringUtility::sanitize($externalUser->lastName));
            }

            $user->setCreatedByFranceConnect(true);
            if ($externalUser->gender) {
                $gender =  StringUtility::sanitize($externalUser->gender) === 'male' ? 0 : 1;
                $user->setGender($gender);
            }
        }

        $user->getUsergroup()->addAll($configuration->getDefaultGroups());
        // todo: emit signal here
        $this->add($user);
        $account = $this->socialAccountRepository->createSocialAccount($configuration, $provider, $identifier, $user);
        $user->addSocialAccount($account);
        $this->persistenceManager->persistAll();

        // @todo : notify user that password change and email set are required if the email was not sent
        // TODO : check this
        $this->mailService->sendMail($configuration, $provider, $user);

        return $user->getUid();
    }
}
