<?php

declare(strict_types=1);

namespace Stratis\StratisMobileapp\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class AppSettings extends AbstractEntity
{
    protected string $version = '1.0.0';

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }
}
