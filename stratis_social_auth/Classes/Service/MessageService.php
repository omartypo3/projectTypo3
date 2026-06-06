<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Service;

use Stratis\StratisServices\DependencyInjection\ContainerAwareTrait;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class MessageService
 * @package Stratis\StratisSocialAuth\Service
 */
class MessageService
{
    use ContainerAwareTrait;

    /**
     * @var FlashMessageService
     */
    protected FlashMessageService $flashMessageService;

    /**
     * Private constructor so nobody else can instantiate it
     */
    public function initializeObject(): void
    {
        $this->flashMessageService = $this->getContainer()->get(FlashMessageService::class);
    }

    /**
     * @param string $text
     * @param string $header
     * @param int|ContextualFeedbackSeverity $severity
     * @param bool $inSession
     */
    public function addFlashMessage(
        string $text,
        string $header = '',
        int|ContextualFeedbackSeverity $severity = 0,
        bool $inSession = true
    ): void {
        /** @var FlashMessage $message */
        $message = GeneralUtility::makeInstance(FlashMessage::class, $text, $header, $severity, $inSession);
        $messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();

        // @extensionScannerIgnoreLine
        $messageQueue->addMessage($message);
    }
}
