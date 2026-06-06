<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Model;

use Stratis\Common\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class User
 * @package Stratis\StratisSocialAuth\Domain\Model
 */
class User extends FrontendUser
{
    /**
     * @var ObjectStorage<SocialAccount>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ObjectStorage $socialAccounts;

    protected bool $createdByFranceConnect = false;
    protected int $gender = 0;
    protected int $dateOfBirth = 0;

    /**
     * Initialize relations
     *
     */
    public function __construct()
    {
        $this->socialAccounts = new ObjectStorage();
        parent::__construct();
    }

    /**
     * @return ObjectStorage|null
     */
    public function getSocialAccounts(): ?ObjectStorage
    {
        return $this->socialAccounts;
    }

    /**
     * @param ObjectStorage $socialAccounts
     */
    public function setSocialAccounts(ObjectStorage $socialAccounts): void
    {
        $this->socialAccounts = $socialAccounts;
    }

    /**
     * Add a social account
     *
     * @param SocialAccount $socialAccount
     */
    public function addSocialAccount(SocialAccount $socialAccount): void
    {
        if ($this->getSocialAccounts() === null) {
            $this->socialAccounts = new ObjectStorage;
        }
        $this->socialAccounts->attach($socialAccount);
    }

    /**
     * @return bool
     */
    public function isCreatedByFranceConnect(): bool
    {
        return $this->createdByFranceConnect;
    }

    /**
     * @param bool $createdByFranceConnect
     */
    public function setCreatedByFranceConnect(bool $createdByFranceConnect): void
    {
        $this->createdByFranceConnect = $createdByFranceConnect;
    }

    /**
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function getDateOfBirth(): int
    {
        return $this->dateOfBirth;
    }

    /**
     * @param int $dateOfBirth
     */
    public function setDateOfBirth(int $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }
}
