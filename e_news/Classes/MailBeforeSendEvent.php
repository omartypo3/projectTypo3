<?php
namespace Emagineurs\ENews;

use TYPO3\CMS\Core\Mail\MailMessage;

class MailBeforeSendEvent
{
    public function __construct(
        public MailMessage $message
    ) {}
}