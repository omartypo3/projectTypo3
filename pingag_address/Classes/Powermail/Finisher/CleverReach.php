<?php
namespace Pingag\PingagAddress\Powermail\Finisher;

/**
 * This file is part of the "cleverreach" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */


use In2code\Powermail\Domain\Model\Answer;
use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Finisher\AbstractFinisher;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use WapplerSystems\Cleverreach\CleverReach\Api;
use WapplerSystems\Cleverreach\Domain\Model\Receiver;
use WapplerSystems\Cleverreach\Service\ConfigurationService;

class CleverReach extends \WapplerSystems\Cleverreach\Powermail\Finisher\CleverReach
{

    /**
     * @var array
     */
    protected $dataArray = [];


    /**
     * @var string
     */
    protected $email = '';


    /**
     * @var string
     */
    protected $name = '';

    const PINGAG_IP = '196.179.244.127';

    /**
     *
     * @return void
     */
    public function cleverreachFinisher()
    {

        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);


        if ($this->email === '') return;

        $api = GeneralUtility::makeInstance(Api::class);
        $configurationService = GeneralUtility::makeInstance(ConfigurationService::class);

        $formValues = $this->getFormValues($this->getMail());
        
        $settings = $this->getSettings();
        $formId = isset($settings['main']['cleverreachFormId']) && \strlen($settings['main']['cleverreachFormId']) > 0 ? $settings['main']['cleverreachFormId'] : null;
        $groupId = isset($settings['main']['cleverreachGroupId']) && \strlen($settings['main']['cleverreachGroupId']) > 0 ? $settings['main']['cleverreachGroupId'] : null;




        if (array_key_exists('newslettercondition',$formValues)) {
            if ((int)$formValues['newslettercondition'] !== 1 ) {
                return;
            }
        }



        if($formValues['newsletteranmeldungcheckbox'] && $this->settings['main']['optin'] == 0) {
            if ($this->settings['main']['cleverreach'] === Api::MODE_OPTIN) {


                 $formValues['herr___frau'] = $formValues['marker'];
                 $newDate = date("Y-m-d", strtotime($formValues['geburtsdatum']));
                 $formValues['geburtstdatum'] = $newDate;
                 $formValues['firma'] = $formValues['unternehmenorganisation'];
                 $receiver = new Receiver($formValues['mailadresse'], $formValues);
                 $receiver->setActivated(1);
                 $api->addReceiversToGroup($receiver, $groupId);
                 $api->sendSubscribeMail($formValues['mailadresse'], $formId, $groupId);

            } else if ($this->settings['main']['cleverreach'] === Api::MODE_OPTOUT) {

                if ($configurationService->getUnsubscribeMethod() === 'doubleoptout') {

                    $api->sendUnsubscribeMail($formValues['mailadresse']);

                } else if ($configurationService->getUnsubscribeMethod() === 'delete') {

                    $api->removeReceiversFromGroup($formValues['mailadresse']);

                } else {

                    $api->disableReceiversInGroup($formValues['mailadresse '], $groupId);

                }

            }
        }


    }
    /**
     * Initialize
     */
    public function initializeFinisher(): void
    {
        $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
        $configuration = $typoScriptService->convertPlainArrayToTypoScriptArray($this->settings);
        if (!empty($configuration['dbEntry.'])) {
            $this->configuration = $configuration['dbEntry.'];
        }

        $this->email = $this->findSenderEmail($this->mail);
    }


    /**
     * @param Mail $mail
     * @return array
     */
    private function getFormValues(Mail $mail) {
        $values = [];

        /** @var Answer $answer */
        foreach ($mail->getAnswers() as $answer) {

            if (!method_exists($answer, 'getField') || !method_exists($answer->getField(), 'getMarker')) {
                continue;
            }

            $value = $answer->getValue();
            if (\is_array($value)) {
                $value = implode(', ', $value);
            }

            $values[$answer->getField()->getMarker()] = $value;

        }

        return $values;
    }

    /**
     *
     * @param Mail $mail
     * @return string
     */
    private function findSenderEmail(Mail $mail): string
    {
        /** @var Answer $answer */
        foreach ($mail->getAnswers() as $answer) {
            if (!method_exists($answer, 'getField') || !method_exists($answer->getField(), 'getMarker')) {
                continue;
            }
            $value = $answer->getValue();
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            if ($answer->getField()->isSenderEmail()) {
                return $value;
            }
        }

        return '';
    }


    /**
     *
     * @param Mail $mail
     * @return string
     */
    private function findSenderName(Mail $mail): string
    {
        /** @var Answer $answer */
        foreach ($mail->getAnswers() as $answer) {
            if (!method_exists($answer, 'getField') || !method_exists($answer->getField(), 'getMarker')) {
                continue;
            }
            $value = $answer->getValue();
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            if ($answer->getField()->isSenderName()) {
                return $value;
            }
        }

        return '';
    }

}
