<?php

namespace Emagineurs\ENews\Utility;

use Emagineurs\ENews\Event\BeforeGenerateMailContent;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\EventDispatcher\EventDispatcherInterface;

use Emagineurs\ENews\Utility\FluidUtility;
use Emagineurs\ENews\Event\MailBeforeGenerateContentEvent;
use Emagineurs\ENews\MailBeforeSendEvent;

class MailUtility
{
    /**
     * Send an email using template to generate the body text
     *
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email, is generated using fluid
     * @param string $templateName template name (UpperCamelCase)
     * @param array $variables variables to be passed to the Fluid view
     * @return boolean TRUE on success, otherwise false
     */
    public static function sendMail($recipient, $sender, $subject, $template, $assigns = array(), $uriBuilder = null)
    {

    //  $signalSlotDispatcher = GeneralUtility::makeInstance(className: Dispatcher::class);

            /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = GeneralUtility::makeInstance(EventDispatcherInterface::class);

        // Trigger BEFORE generating the mail content (replacement for SignalSlot BeforeGenerateMailContent)
        $eventDispatcher->dispatch(new BeforeGenerateMailContent($template, $assigns));


        /** @var MailMessage $message */
        $message = GeneralUtility::makeInstance(MailMessage::class);
        $message->setTo($recipient)->setFrom($sender)->setSubject($subject);


         $validateUrl = $uriBuilder
            ->reset()
            ->setTargetPageUid($assigns['validationPid']) // page with DOI handler plugin
            ->setArguments(
                    [
                    'tx_enews_validatenews' => [
                        'news' => $assigns['news']->getUid(),
                        'token' => $assigns['news']->getAdminValidationToken(),
                        'validate' => 1,
                        'validationType' => 'admin'
                    ]
                ]
            )
            ->setCreateAbsoluteUri(true)
            ->buildFrontendUri();



         $refuseUrl = $uriBuilder
            ->reset()
            ->setTargetPageUid($assigns['validationPid']) // page with DOI handler plugin
            ->setArguments(
                    [
                    'tx_enews_validatenews' => [
                        'news' => $assigns['news']->getUid(),
                        'token' => $assigns['news']->getAdminValidationToken(),
                        'validate' => 0,
                        'validationType' => 'admin'
                    ]
                ]
            )
            ->setCreateAbsoluteUri(true)
            ->buildFrontendUri();






        // Pass to Fluid:
        $assigns['validateUrl'] = $validateUrl;
        $assigns['refuseUrl'] = $refuseUrl;


        //Subject
        $subject = FluidUtility::renderStringTemplate($subject, $assigns);
        $bodyHtml       = FluidUtility::renderFileTemplate($template, $assigns);

   

        
        // Create the email
        /** @var MailMessage $message */
        $message = GeneralUtility::makeInstance(MailMessage::class);
        $message->setTo($recipient)
            ->setFrom($sender)
            ->setSubject($subject)
            ->html($bodyHtml, 'text/html');



        //Body
        // $signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__ . 'BeforeGenerateMailContent', array($template, $assigns));
        // $bodyText = FluidUtility::renderFileTemplate($template, $assigns);
        // $message->setBody($bodyText, 'text/html');
        // $signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__ . 'BeforeSend', array($message));

                $eventDispatcher->dispatch(new MailBeforeSendEvent($message));



        $message->send();
        return $message->isSent();
    }
}
