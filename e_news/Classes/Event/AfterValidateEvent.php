<?php
declare(strict_types=1);

namespace Emagineurs\ENews\Event;

use Emagineurs\ENews\Domain\Model\Enews;


final class AfterValidateEvent
{
    private ?Enews $news;
    private bool $validate;
    private string $validationType;

    public function __construct(?Enews $news, bool $validate, string $validationType)
    {
        $this->news = $news;
        $this->validate = $validate;
        $this->validationType = $validationType;
    }

    public function getNews(): ?Enews
    {
        return $this->news;
    }

    public function getValidate(): bool
    {
        return $this->validate;
    }

    public function getValidationType(): string
    {
        return $this->validationType;
    }
}

