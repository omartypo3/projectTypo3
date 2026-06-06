<?php

declare(strict_types=1);

namespace Emagineurs\EPowermailMultirecip\EventListener;

use In2code\Powermail\Events\SendMailServicePowermailSendEvent;
use Emagineurs\EPowermailMultirecip\Hooks\SendMailServiceHook;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Event listener for Powermail SendMailService events
 * 
 * Listens to SendMailServicePowermailSendEvent and processes multirecipients fields
 * to add BCC recipients based on form selections.
 */
class SendMailServiceEventListener
{
    protected SendMailServiceHook $sendMailServiceHook;

    public function __construct(?SendMailServiceHook $sendMailServiceHook = null)
    {
        $this->sendMailServiceHook = $sendMailServiceHook ?? GeneralUtility::makeInstance(SendMailServiceHook::class);
    }

    /**
     * Modify mail before sending by adding BCC recipients from multirecipients fields
     * 
     * @param SendMailServicePowermailSendEvent $event The Powermail send event
     * @return void
     */
    public function modifyMailBeforeSend(SendMailServicePowermailSendEvent $event): void
    {
        // Extract parameters from event to match the hook signature
        $message = $event->getMessage();
        $emailParent = null; 
        $parent = $event->getSendMailService();
        
        // Call the hook with the expected signature
        $this->sendMailServiceHook->setReceiverEmailsSignal($message, $emailParent, $parent);
    }
}

