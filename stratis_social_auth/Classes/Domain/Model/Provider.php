<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Provider
 * @package Stratis\StratisSocialAuth\Domain\Model
 */
class Provider extends AbstractEntity
{
    /**
     * Supported providers,
     * names according to HybridAuth specification
     */
    const FACEBOOK = 'Facebook';
    const FRANCE_CONNECT = 'FranceConnect';
    const GOOGLE = 'Google';
    const PUBLIK = 'Publik';

    protected bool $hidden = false;
    protected string $keyId = '';
    protected string $keySecret = '';
    protected string $type = '';
    protected string $scope = '';
    protected string $acrValues = '';
    protected string $display = '';
    protected string $title;

    /**
     * To log in to an OpenID-enabled website you need an OpenID identifier,
     * also called an OpenID URL or simply an OpenID.
     */
    protected string $openIdUrl;

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * @return string
     */
    public function getKeyId(): string
    {
        return $this->keyId;
    }

    /**
     * @param string $keyId
     */
    public function setKeyId(string $keyId): void
    {
        $this->keyId = $keyId;
    }

    /**
     * @return string
     */
    public function getKeySecret(): string
    {
        return $this->keySecret;
    }

    /**
     * @param string $keySecret
     */
    public function setKeySecret(string $keySecret): void
    {
        $this->keySecret = $keySecret;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getAcrValues(): string
    {
        return $this->acrValues;
    }

    /**
     * @param string $acrValues
     */
    public function setAcrValues(string $acrValues): void
    {
        $this->acrValues = $acrValues;
    }

    /**
     * @return string
     */
    public function getDisplay(): string
    {
        return $this->display;
    }

    /**
     * @param string $display
     */
    public function setDisplay(string $display): void
    {
        $this->display = $display;
    }

    /**
     * @return string
     */
    public function getOpenIdUrl(): string
    {
        return $this->openIdUrl;
    }

    /**
     * @param string $openIdUrl
     */
    public function setOpenIdUrl(string $openIdUrl): void
    {
        $this->openIdUrl = $openIdUrl;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
