<?php
declare(strict_types = 1);
namespace Pingag\PingagAddress\Domain\Service\Mail;

use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Domain\Repository\MailRepository;
use In2code\Powermail\Utility\FrontendUtility;
use In2code\Powermail\Utility\HashUtility;
use In2code\Powermail\Utility\ObjectUtility;
use Pingag\PingagAddress\Domain\Service\Mail\SendMailService;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * Class SendOptinConfirmationMailPreflight
 */
class SendOptinConfirmationMailPreflight extends \In2code\Powermail\Domain\Service\Mail\SendOptinConfirmationMailPreflight
{
    const PINGAG_IP = '196.179.244.127';
    /**
     * @var SendMailService
     */
    protected $sendMailService;

    /**
     * @var MailRepository
     */
    protected $mailRepository;

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var array
     */
    protected $conf = [];

    /**
     * @param array $settings
     * @param array $conf
     * @throws Exception
     */
    public function __construct(array $settings, array $conf)
    {
        $this->settings = $settings;
        $this->conf = $conf;
        $this->sendMailService = ObjectUtility::getObjectManager()->get(SendMailService::class);
        $this->mailRepository = ObjectUtility::getObjectManager()->get(MailRepository::class);
    }

    /**
     * @param Mail $mail
     * @return void
     * @throws InvalidConfigurationTypeException
     * @throws InvalidControllerNameException
     * @throws InvalidExtensionNameException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws Exception
     */
    public function sendOptinConfirmationMail(Mail $mail): void
    {
        $email = [
            'template' => 'Mail/OptinMail',
            'receiverEmail' => $this->mailRepository->getSenderMailFromArguments($mail),
           // 'receiverEmail' => 'sekretariat@szblind.ch',
            'receiverName' => $this->mailRepository->getSenderNameFromArguments(
                $mail,
                [$this->conf['sender.']['default.'], 'senderName']
            ),
            //'senderEmail' => $this->settings['sender']['email'],
            'senderEmail' => $mail->getSenderMail(),
            'senderName' => $this->settings['sender']['name'],
            'replyToEmail' => ($this->settings['sender']['email'] ? $this->settings['sender']['email'] : $mail->getReceiverMail()),
            'replyToName' => $this->settings['sender']['name'],
            'subject' => ObjectUtility::getContentObject()->cObjGetSingle(
                $this->conf['optin.']['subject'],
                $this->conf['optin.']['subject.']
            ),
            'rteBody' => '',
            'format' => $this->settings['sender']['mailformat'],
            'variables' => [
                'hash' => HashUtility::getHash($mail),
                'hashDisclaimer' => HashUtility::getHash($mail, 'disclaimer'),
                'mail' => $mail,
                'L' => FrontendUtility::getSysLanguageUid()
            ]
        ];

        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);

        /*if($debug){
            \TYPO3\CMS\Core\Utility\DebugUtility::debug($email);
            die();
        }*/
        $this->sendMailService->sendMail($email, $mail, $this->settings, 'optin');
    }
}
