<?php
namespace FRONTAL\FagInstitutionManagement\Evaluation;

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class for field value validation/evaluation to be used in 'eval' of TCA
 */
class UniqueFrontendUserEvaluation
{

    /**
     * backendSession
     */
    protected $backendSession;

    /**
     * userRepository
     */
    protected $userRepository;

    /**
    * @return void
    */
    public function __construct()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->backendSession = $objectManager->get('FRONTAL\\FagExtbase\\Domain\\Session\\BackendSessionHandler');
        $this->backendSession->setStorageKey('currentUser');

        $this->userRepository = $objectManager->get('FRONTAL\\FagInstitutionManagement\\Domain\\Repository\\UserRepository');
    }


    /**
     * Server-side validation/evaluation on saving the record
     *
     * @param string $value The field value to be evaluated
     * @param string $is_in The "is_in" value of the field configuration from TCA
     * @param bool $set Boolean defining if the value is written to the database or not.
     * @return string Evaluated field value
     */
    public function evaluateFieldValue($value, $is_in, &$set)
    {
        if (count($this->userRepository->findByUsername($value)) > 0 && $this->backendSession->get('Username') != $value) {
            $this->flashMessage('Benutzername bereits vorhanden', 'Der von Ihnen eingegebene Benutzername existiert bereits in der Datenbank!', FlashMessage::ERROR);
            $set = false; //do not save value
        }

        return $value;
    }

    /**
     * Server-side validation/evaluation on opening the record
     *
     * @param array $parameters Array with key 'value' containing the field value from the database
     * @return string Evaluated field value
     */
    public function deevaluateFieldValue(array $parameters)
    {
        $this->backendSession->set('Username',$parameters['value']);

        return $parameters['value'];
    }

    /**
     * @param string $messageTitle
     * @param string $messageText
     * @param int $severity
     */
    protected function flashMessage($messageTitle, $messageText, $severity = FlashMessage::ERROR)
    {
        $message = GeneralUtility::makeInstance(
            FlashMessage::class,
            $messageText,
            $messageTitle,
            $severity,
            true
        );

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $flashMessageService = $objectManager->get(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
    }
}
?>
