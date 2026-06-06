<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Service;

use Stratis\StratisSocialAuth\Domain\Model\Configuration;
use Stratis\StratisSocialAuth\Domain\Model\Provider;
use Stratis\StratisSocialAuth\Domain\Model\User;
use Stratis\StratisSocialAuth\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class MailService
 * @package Stratis\StratisSocialAuth\Service
 */
class MailService
{
    /**
     * MailService constructor.
     * @param MessageService $messageService
     */
    public function __construct(protected MessageService $messageService)
    {
    }

    /**
     * @param Configuration $configuration
     * @param Provider $provider
     * @param User $user
     *
     * @return bool
     */
    public function sendMail(Configuration $configuration, Provider $provider, User $user): bool
    {
        if (empty($user['email'])) {
            $this->messageService->addFlashMessage(
                LocalizationUtility::translateMessage('notifications.passwordChangeRequired'),
                '',
                ContextualFeedbackSeverity::WARNING
            );

            return false;
        }

        /** @var MailMessage $mail */
        $mail = GeneralUtility::makeInstance(MailMessage::class);
        $sender = [
            $configuration->getMailSenderEmail() => $configuration->getMailSenderName(),
        ];
        $mailBody = $this->prepareMailBody($user, $provider, $configuration->getMailBody());

        $mail
            ->setSubject($configuration->getMailSubject())
            ->setFrom($sender)
            ->setTo($user['email'])
            ->text(strip_tags($mailBody))
            ->html($mailBody, 'text/html')
            ->send();

        return $mail->isSent();
    }

    /**
     * @param User $user
     * @param Provider $provider
     * @param string $mailBody
     *
     * @return string
     */
    protected function prepareMailBody(User $user, Provider $provider, string $mailBody = ''): string
    {
        $mailBody = str_replace('###PASSWORD###', $user->getPassword(), $mailBody);
        $mailBody = str_replace('###LOGIN###', $user->getUsername(), $mailBody);

        return str_replace('###SOCIAL_SERVICE###', $provider->getTitle(), $mailBody);
    }
}
