<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Model;

use Stratis\Common\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Configuration
 * @package Stratis\StratisSocialAuth\Domain\Model
 */
class Configuration extends AbstractEntity
{
    protected int $storagePid = 0;
    protected string $mailBody = '';
    protected string $mailSenderName = '';
    protected string $mailSenderEmail = '';
    protected string $mailSubject = '';

    /**
     * @var ObjectStorage<FrontendUserGroup>
     */
    protected ObjectStorage $defaultGroups;

    /**
     * @var ObjectStorage<Provider>
     */
    protected ObjectStorage $providers;

    /**
     * Initialize relations
     *
     */
    public function __construct()
    {
        $this->defaultGroups = new ObjectStorage();
        $this->providers = new ObjectStorage();
    }

    /**
     * @return int
     */
    public function getStoragePid(): int
    {
        return $this->storagePid;
    }

    /**
     * @param int $storagePid
     */
    public function setStoragePid(int $storagePid): void
    {
        $this->storagePid = $storagePid;
    }

    /**
     * @return ObjectStorage
     */
    public function getDefaultGroups(): ObjectStorage
    {
        return $this->defaultGroups;
    }

    /**
     * @param ObjectStorage $defaultGroups
     */
    public function setDefaultGroups(ObjectStorage $defaultGroups): void
    {
        $this->defaultGroups = $defaultGroups;
    }

    /**
     * @return ObjectStorage
     */
    public function getProviders(): ObjectStorage
    {
        return $this->providers;
    }

    /**
     * @param ObjectStorage $providers
     */
    public function setProviders(ObjectStorage $providers): void
    {
        $this->providers = $providers;
    }

    /**
     * @return string
     */
    public function getMailBody(): string
    {
        return $this->mailBody;
    }

    /**
     * @param string $mailBody
     */
    public function setMailBody(string $mailBody): void
    {
        $this->mailBody = $mailBody;
    }

    /**
     * @return string
     */
    public function getMailSenderName(): string
    {
        return $this->mailSenderName;
    }

    /**
     * @param string $mailSenderName
     */
    public function setMailSenderName(string $mailSenderName): void
    {
        $this->mailSenderName = $mailSenderName;
    }

    /**
     * @return string
     */
    public function getMailSenderEmail(): string
    {
        return $this->mailSenderEmail;
    }

    /**
     * @param string $mailSenderEmail
     */
    public function setMailSenderEmail(string $mailSenderEmail): void
    {
        $this->mailSenderEmail = $mailSenderEmail;
    }

    /**
     * @return string
     */
    public function getMailSubject(): string
    {
        return $this->mailSubject;
    }

    /**
     * @param string $mailSubject
     */
    public function setMailSubject(string $mailSubject): void
    {
        $this->mailSubject = $mailSubject;
    }
}
