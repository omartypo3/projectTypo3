<?php
namespace Emagineurs\EComment\Event;

use Emagineurs\EComment\Domain\Model\Message;

final class NewMessageEvent
{
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}

