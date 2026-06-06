<?php

namespace Pingag\PingagAddress\Controller;

use In2code\Powermail\DataProcessor\DataProcessorRunner;
use In2code\Powermail\Domain\Factory\MailFactory;
use In2code\Powermail\Domain\Model\Form;
use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Domain\Service\ConfigurationService;
use In2code\Powermail\Domain\Service\Mail\SendDisclaimedMailPreflight;
use In2code\Powermail\Domain\Service\Mail\SendOptinConfirmationMailPreflight;
use In2code\Powermail\Domain\Service\Mail\SendReceiverMailPreflight;
use In2code\Powermail\Domain\Service\Mail\SendSenderMailPreflight;
use In2code\Powermail\Exception\DeprecatedException;
use In2code\Powermail\Finisher\FinisherRunner;
use In2code\Powermail\Utility\ConfigurationUtility;
use In2code\Powermail\Utility\HashUtility;
use In2code\Powermail\Utility\LocalizationUtility;
use In2code\Powermail\Utility\ObjectUtility;
use In2code\Powermail\Utility\SessionUtility;
use In2code\Powermail\Utility\TemplateUtility;
use function in_array;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as ExtbaseAnnotation;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentNameException;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use WapplerSystems\Cleverreach\CleverReach\Api;
use WapplerSystems\Cleverreach\Domain\Model\Receiver;

use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * Class FormController
 */
class FormController extends \In2code\Powermail\Controller\FormController
{
    const PINGAG_IP = '149.34.244.165';
    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @var DataProcessorRunner
     */
    protected $dataProcessorRunner;

    /**
     * @return ResponseInterface
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws Exception
     * @noinspection PhpUnused
     */
    public function formAction(): ResponseInterface
    {
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);

        if (!ArrayUtility::isValidPath($this->settings, 'main/form')) {
            return $this->htmlResponse();
        }
        /** @var Form $form */

        $form = $this->formRepository->findByUid($this->settings['main']['form']);
      /*  \TYPO3\CMS\Core\Utility\DebugUtility::debug($sys_language_uid);
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($form);*/

        $this->signalDispatch(__CLASS__, __FUNCTION__ . 'BeforeRenderView', [$form, $this]);
        SessionUtility::saveFormStartInSession($this->settings, $form);
        $this->view->assignMultiple(
            [
                'form' => $form,
                'ttContentData' => $this->contentObject->data,
                'messageClass' => $this->messageClass,
                'action' => ($this->settings['main']['confirmation'] ? 'confirmation' : 'create')
            ]
        );

        return $this->htmlResponse();
    }

    /**
     * Rewrite Arguments to receive a clean mail object in confirmationAction
     *
     * @return void
     * @throws Exception
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     * @throws InvalidArgumentNameException
     * @throws InvalidQueryException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws NoSuchArgumentException
     * @throws StopActionException
     * @throws DeprecatedException
     * @noinspection PhpUnused
     */
    public function initializeConfirmationAction(): void
    {
        $this->forwardIfFormParamsDoNotMatch();
        $this->forwardIfMailParamEmpty();
        $this->reformatParamsForAction();
        $this->debugVariables();
    }

    /**
     * Show a "Are your values ok?" message before final submit (if turned on)
     *
     * @param Mail $mail
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\UploadValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\InputValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\PasswordValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\CaptchaValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\SpamShieldValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\UniqueValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\ForeignValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\CustomValidator", param="mail")
     * @return ResponseInterface
     * @throws InvalidConfigurationTypeException
     * @throws InvalidExtensionNameException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws Exception
     * @noinspection PhpUnused
     */
    public function confirmationAction(Mail $mail): ResponseInterface
    {
        $this->signalDispatch(__CLASS__, __FUNCTION__ . 'BeforeRenderView', [$mail, $this]);
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->dataProcessorRunner->callDataProcessors(
            $mail,
            $this->actionMethodName,
            $this->settings,
            $this->contentObject
        );
        $this->prepareOutput($mail);

        return $this->htmlResponse();
    }

    /**
     * Rewrite Arguments to receive a clean mail object in createAction
     *
     * @return void
     * @throws Exception
     * @throws InvalidArgumentNameException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws NoSuchArgumentException
     * @throws StopActionException
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     * @throws InvalidQueryException
     * @throws DeprecatedException
     * @noinspection PhpUnused
     */
    public function initializeCreateAction(): void
    {
        $this->forwardIfFormParamsDoNotMatch();
        $this->forwardIfMailParamEmpty();
        $this->reformatParamsForAction();
        $this->debugVariables();
    }

    /**
     * @param Mail $mail
     * @param string $hash
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\UploadValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\InputValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\PasswordValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\CaptchaValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\SpamShieldValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\UniqueValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\ForeignValidator", param="mail")
     * @ExtbaseAnnotation\Validate("In2code\Powermail\Domain\Validator\CustomValidator", param="mail")
     * @return ResponseInterface
     * @throws IllegalObjectTypeException
     * @throws InvalidConfigurationTypeException
     * @throws InvalidExtensionNameException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws UnknownObjectException
     * @throws InvalidControllerNameException
     * @throws \Exception
     * @noinspection PhpUnused
     */
    public function createAction(Mail $mail, string $hash = ''): ResponseInterface
    {

        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);


        $markers = $this->mailRepository->getVariablesWithMarkersFromMail($mail, true);

        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $all = [];


        if ($sys_language_uid != 0) {
            $uidForm = $mail->getForm()->getUid();
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
            $FormRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FormRepository');
            $FieldRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FieldRepository');
            $PageRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\PageRepository');
            $uidFormTranslate = $FormRepository->getTranslateFrom($uidForm, $sys_language_uid);

            if ($uidFormTranslate) {
                $uidPageTranslate = $PageRepository->getTranslateFrom($uidFormTranslate->getUid(), $sys_language_uid);

                if ($uidPageTranslate) {
                    $uidFieldTranslate = $FieldRepository->getTranslateFrom($uidPageTranslate->getUid(), $sys_language_uid);

                    foreach ($uidFieldTranslate as $Fields) {
                        $orginalUid = $Fields->_getProperty('l10nParent');
                        $orginalField = $FieldRepository->getOrginalMarker($orginalUid);
                        $all[$orginalField->getMarker()] = $Fields->getTitle();
                    }
                }
            }else if ($this->formTranslate($uidForm, $sys_language_uid)) {
                $uidPageTranslate = $PageRepository->getTranslateFrom((int)$this->formTranslate($uidForm, $sys_language_uid), $sys_language_uid);

                if ($uidPageTranslate) {
                    $uidFieldTranslate = $FieldRepository->getTranslateFrom($uidPageTranslate->getUid(), $sys_language_uid);

                    foreach ($uidFieldTranslate as $Fields) {
                        $orginalUid = $Fields->_getProperty('l10nParent');
                        $orginalField = $FieldRepository->getOrginalMarker($orginalUid);
                        $all[$orginalField->getMarker()] = $Fields->getTitle();
                    }
                }
            }


            $templates = "<table class='table table-striped table-hover table-responsive'><tbody>";

            if(count($all) > 0){
                foreach ($markers as $key => $marker ) {
                    if ($marker && $marker != ' ' && $key != "mailadressenewslettre" && $key != "datei") {
                        $templates .= "<tr><td class='powermail_all_label powermail_all_type_select powermail_all_marker_" . $key . "'><strong>" . $all[$key] . "</strong></td>";
                        $templates .= "<td class='powermail_all_value powermail_all_type_select powermail_all_marker_" . $key . "'>" . $marker . "<br></td></tr>";
                    }
                }
            }else{
                foreach ($markers as $key => $marker) {
                    if ($marker && $marker != ' ' && $key != "mailadressenewslettre" && $key != "datei") {
                        $templates .= "<tr><td class='powermail_all_label powermail_all_type_select powermail_all_marker_" . $key . "'><strong>" . $key . "</strong></td>";
                        $templates .= "<td class='powermail_all_value powermail_all_type_select powermail_all_marker_" . $key . "'>" . $marker . "<br></td></tr>";
                    }
                }
            }

            $templates .= "</tbody></table>";

        } else {

           
       

            //$templates = TemplateUtility::powermailAll($mail, 'web', $this->settings, $this->actionMethodName);
            $uidForm = $mail->getForm()->getUid();
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
            $FormRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FormRepository');
            $FieldRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FieldRepository');
            $PageRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\PageRepository');
            $all = [];
            $uidPage = $PageRepository->getFrom($uidForm);

           //\TYPO3\CMS\Core\Utility\DebugUtility::debug($PageRepository->getFrom($uidForm));

            if ($uidPage) {
                $uidField = $FieldRepository->getFrom($uidPage->getUid());

                foreach ($uidField as $Fields) {
                    $orginalUid = $Fields->_getProperty('uid');
                    $orginalField = $FieldRepository->getOrginalMarker($orginalUid);
                    $all[$orginalField->getMarker()] = $Fields->getTitle();
                }
            }



            $templates = "<table class='table table-striped table-hover table-responsive'><tbody>";
            if(count($all) > 0) {
                $hasBegleiter = isset($markers['ichwerdebegleitetvon']) && trim($markers['ichwerdebegleitetvon']) !== '';

                foreach ($markers as $key => $marker) {
                    if ($marker && $key != "mailadressenewslettre" && $key != "datei") {

                        $key = preg_replace('/_\d+$/', '', $key);
                         // Skip begleitpersonessen if ichwerdebegleitetvon is missing or empty
                        if ($key === 'begleitpersonessen' && !$hasBegleiter) {
                            continue; // skip this iteration
                        }
                        if ($key != "mailadressenewslettre"){
                            if(isset($all[$key])){
                                if($marker != ' '){
                                    $templates .= "<tr><td class='powermail_all_label powermail_all_type_select powermail_all_marker_" . $key . "'><strong>" . $all[$key] . "</strong></td>";
                                    $templates .= "<td class='powermail_all_value powermail_all_type_select powermail_all_marker_" . $key . "'>" . $marker . "<br></td></tr>";
                                }
                            }else{
                                if($marker != ' '){
                                    $name = $this->keyname($key);
                                    $templates .= "<tr><td class='powermail_all_label powermail_all_type_select powermail_all_marker_" . $key . "'><strong>" . $name . "</strong></td>";
                                    $templates .= "<td class='powermail_all_value powermail_all_type_select powermail_all_marker_" . $key . "'>" . $marker . "<br></td></tr>";
                                }
                                
                            }
                        }
                    }
                }
            }else{
                foreach ($markers as $key => $marker) {
                    if ($marker && $marker != ' ' && $key != "mailadressenewslettre" && $key != "datei") {
                        if ($key != "mailadressenewslettre")
                            $templates .= "<tr><td class='powermail_all_label powermail_all_type_select powermail_all_marker_" . $key . "'><strong>" . $key . "</strong></td>";
                        $templates .= "<td class='powermail_all_value powermail_all_type_select powermail_all_marker_" . $key . "'>" . $marker . "<br></td></tr>";
                    }
                }
            }


            $templates .= "</tbody></table>";

        }

        //die();


        $AM = '';

        foreach ($mail->getAnswers() as $answer) {
            if ($answer->getField()->getType() == 'date') {
                $array = (array)$answer;
                $value = array_key_first($array);
                $first_value = $array[$value];

                if($first_value != '') {
                    $AM = date("Y", $first_value);
                }

            }
        }


        //die();

        $template = str_replace('AM', $AM, $templates);


        $subjectEmail = ($this->settings['receiver']['subject']) ? $this->settings['receiver']['subject'] : $this->settings['sender']['subject'];

        if(str_contains($subjectEmail, "{anfrageoderbestellung}")){
            $subjectEmail = str_replace('{anfrageoderbestellung}', $markers['anfrageoderbestellung'] ,$subjectEmail);
        }
        if(str_contains($subjectEmail, "{name}")){
            $subjectEmail = str_replace('{name}',$markers['name'] ,$subjectEmail);
        }
        if(str_contains($subjectEmail, "{vorname}")){
            $subjectEmail = str_replace('{vorname}',$markers['vorname'] ,$subjectEmail);

        }

        if($markers['datei']){
            $path = "/home/httpd/vhosts/szb.ch/szblind.ch/uploads/tx_powermail/".$markers['datei'];
        }else{
            $path = '';
        }



        $this->signalDispatch(__CLASS__, __FUNCTION__ . 'BeforeRenderView', [$mail, $hash, $this]);
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->dataProcessorRunner->callDataProcessors(
            $mail,
            $this->actionMethodName,
            $this->settings,
            $this->contentObject
        );

        if ($this->settings['receiver']['ReplayTo']) {
            $ReplayTo = preg_split('/[\s,;]+/', $this->settings['receiver']['ReplayTo']);
            $ReplayToEmail = (count($ReplayTo) == 1) ? $ReplayTo[0] : "website@szblind.ch";
        } else {
            $ReplayToEmail = "website@szblind.ch";
        }


        if ($markers['newsletteranmeldungcheckbox'] == '') {
            

            if ($markers['kommissionen']) {
                $bodySender = str_replace('<p>{powermail_all}</p>', $template, $this->settings['sender']['body']);

                $mailsendkommissionen = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                $mailsendkommissionen
                    ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                    ->to(
                    // new \Symfony\Component\Mime\Address('omar.jmal91@gmail.com')
                        new \Symfony\Component\Mime\Address($markers['kommissionen'])
                    )
                    ->subject($subjectEmail)
                    ->replyTo($this->settings['receiver']['ReplayTo'])
                    ->html($bodySender);
                     if($path){
                         $mailsendkommissionen->attachFromPath($path);
                     }

                    $mailsendkommissionen->send();

            }




            if ($this->isMailPersistActive($hash)) {
                $this->saveMail($mail);
                $this->signalDispatch(__CLASS__, __FUNCTION__ . 'AfterMailDbSaved', [$mail, $this]);
            }
            if ($this->isNoOptin($mail, $hash)) {

                $templatefinal = str_replace(['<br>', '</br>', ' <br >', ' <br />'], '', $template);
                $bodySender = str_replace('<p>{powermail_all}</p>', $templatefinal, $this->settings['sender']['body']);

                $this->sendMailPreflight($mail, $hash);
                $mailsend = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                $mailsend
                    ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                    ->to(
                    // new \Symfony\Component\Mime\Address('omar.jmal91@gmail.com')
                        new \Symfony\Component\Mime\Address($markers['mailadresse'])
                    )
                    ->subject($subjectEmail)
                    ->replyTo($ReplayToEmail)
                    ->html($bodySender);
                    if($path){
                        $mailsend->attachFromPath($path);
                    }
                    $mailsend->send();
                $resiced = preg_split('/[\s,;]+/', $this->settings['receiver']['email']);

                if (count($resiced) > 1) {
                    $templatefinal = str_replace(['<br>', '</br>', ' <br >', ' <br />'], '', $template);
                    $bodyReceiver = str_replace('<p>{powermail_all}</p>', $templatefinal, $this->settings['receiver']['body']);

                    foreach ($resiced as $key => $resice) {

                        $mailToAdmin = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                        $mailToAdmin
                            ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                            ->to(
                                new \Symfony\Component\Mime\Address($resice)
                            )
                            ->subject($subjectEmail)
                            ->replyTo($ReplayToEmail)
                            ->html($bodyReceiver);
                            if($path){
                                $mailToAdmin->attachFromPath($path);
                            }
                            $mailToAdmin->send();
                    }
                } else {
                    if ($this->settings['receiver']['email']) {
                        $templatefinal = str_replace(['<br>', '</br>', ' <br >', ' <br />'], '', $template);
                        $bodyReceiver = str_replace('<p>{powermail_all}</p>', $templatefinal, $this->settings['receiver']['body']);

                        $mailToAdminOne = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                        $mailToAdminOne
                            ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                            ->to(
                                new \Symfony\Component\Mime\Address($this->settings['receiver']['email'])
                            )
                            ->subject($subjectEmail)
                            ->replyTo($ReplayToEmail)
                            ->html($bodyReceiver);
                             if($path){
                                 $mailToAdminOne->attachFromPath($path);
                             }
                            $mailToAdminOne->send();
                    }
                }
            } else {

                if($this->settings['main']['optin'] != 0) {
                    $hashs = HashUtility::getHash($mail);
                    $templatefinal = str_replace(['<br>', '</br>', ' <br >', ' <br />'], '', $template);
                    $bodyReceiver = str_replace('<p>{powermail_all}</p>', $templatefinal, $this->settings['receiver']['body']);
                    $bodySender = str_replace('<p>{powermail_all}</p>', $templatefinal, $this->settings['sender']['body']);

                        $mail->setHidden(0);
                        $this->mailRepository->update($mail);
                        $this->persistenceManager->persistAll();
                        $mailsend = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                        $mailsend
                            ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                            ->to(
                            // new \Symfony\Component\Mime\Address('omar.jmal91@gmail.com')
                                new \Symfony\Component\Mime\Address($markers['mailadresse'])
                            )
                            ->subject($subjectEmail)
                            ->replyTo($ReplayToEmail)
                            ->html($bodySender);
                            if($path){
                                $mailsend->attachFromPath($path);
                            }
                            $mailsend->send();

                    $resiced = preg_split('/[\s,;]+/', $this->settings['receiver']['email']);



                    if (count($resiced) > 1) {
                        foreach ($resiced as $key => $resice) {

                            $mailToAdmin = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                            $mailToAdmin
                                ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                                ->to(
                                    new \Symfony\Component\Mime\Address($resice)
                                )
                                ->subject($subjectEmail)
                                ->replyTo($ReplayToEmail)
                                ->html($bodyReceiver);
                            if($path){
                                $mailToAdmin->attachFromPath($path);
                            }
                            $mailToAdmin->send();
                        }
                    } else {
                        if ($this->settings['receiver']['email']) {
                            $mailToAdminOne = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                            $mailToAdminOne
                                ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                                ->to(
                                    new \Symfony\Component\Mime\Address($this->settings['receiver']['email'])
                                )
                                ->subject($this->settings['receiver']['subject'])
                                ->replyTo($ReplayToEmail)
                                ->html($bodyReceiver);
                                if($path){
                                    $mailToAdminOne->attachFromPath($path);
                                }
                            $mailToAdminOne->send();
                        }
                    }
                }

                        $this->view->assign('optinActive', false);
                if ($sys_language_uid != 0) {
                    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
                    $FormRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FormRepository');
                    $uidFormTranslateOptin = $FormRepository->getTranslateFrom($mail->getForm()->getUid(), $sys_language_uid);
                    if ($uidFormTranslateOptin) {
                        $uidFormOptin = $uidFormTranslateOptin->getUid();
                    }
                }else{
                    $uidFormOptin = $mail->getForm()->getUid();
                }


                if($uidFormOptin == 7 || $uidFormOptin == 23){
                    $uriBuilder = $this->controllerContext->getUriBuilder();
                    $uriBuilder->reset();
                    //$uriBuilder->setTargetPageUid((int)68);
                    if($this->settings['thx']['redirect']){
                        $explode = explode('t3://page?uid=',$this->settings['thx']['redirect']);
                        if(count($explode) == 2){
                            $uriBuilder->setTargetPageUid((int)$explode['1']);
                        }else{
                            $uriBuilder->setTargetPageUid((int)68);
                        }
                    }else{
                        $uriBuilder->setTargetPageUid((int)68);
                    }
                    $uri = $uriBuilder->build(); // ready, steady…
                    $this->redirectToUri($uri);
                }else {
                    $uriBuilder = $this->controllerContext->getUriBuilder();
                    $uriBuilder->reset();
                    //$uriBuilder->setTargetPageUid((int)767);
                    if($this->settings['thx']['redirect']){
                        $explode = explode('t3://page?uid=',$this->settings['thx']['redirect']);
                        if(count($explode) == 2){
                            $uriBuilder->setTargetPageUid((int)$explode['1']);
                        }else{
                            $uriBuilder->setTargetPageUid((int)767);
                        }
                    }else{
                        $uriBuilder->setTargetPageUid((int)767);
                    }
                    $uri = $uriBuilder->build(); // ready, steady…
                    $this->redirectToUri($uri);
                }



            }
            if ($this->isPersistActive()) {
                $this->mailRepository->update($mail);
                $this->persistenceManager->persistAll();
            }

            $this->signalDispatch(__CLASS__, __FUNCTION__ . 'AfterSubmitView', [$mail, $hash, $this]);
            $this->prepareOutput($mail);


            $finisherRunner = $this->objectManager->get(FinisherRunner::class);
            /** @noinspection PhpUnhandledExceptionInspection */
            $finisherRunner->callFinishers(
                $mail,
                $this->isNoOptin($mail, $hash),
                $this->actionMethodName,
                $this->settings,
                $this->contentObject
            );


        } else {



            if ($this->isMailPersistActive($hash)) {
                $this->saveMail($mail);
                $this->signalDispatch(__CLASS__, __FUNCTION__ . 'AfterMailDbSaved', [$mail, $this]);
            }



            if ($this->isNoOptin($mail, $hash)) {
                $this->sendMailPreflight($mail, $hash);
                if($this->settings['main']['optin'] == 0) {
                    $templatefinal = str_replace(['<br>', '</br>', ' <br >', ' <br />'], '', $template);
                    $bodySender = str_replace('<p>{powermail_all}</p>', $templatefinal, $this->settings['sender']['body']);

                    if ($markers['mailadressenewslettre']) {
                        $mailsend = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                        $mailsend
                            ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                            ->to(
                            // new \Symfony\Component\Mime\Address('omar.jmal91@gmail.com')
                                new \Symfony\Component\Mime\Address($markers['mailadresse'])
                            )
                            ->subject($subjectEmail)
                            ->replyTo($ReplayToEmail)
                            ->html($bodySender);
                            if($path){
                                $mailsend->attachFromPath($path);
                            }
                            $mailsend->send();
                    }
                }
            } else {

                $mailPreflight = $this->objectManager->get(
                    SendOptinConfirmationMailPreflight::class,
                    $this->settings,
                    $this->conf
                );
               
                $mailPreflight->sendOptinConfirmationMail($mail);
                $templatefinal = str_replace(['<br>', '</br>', ' <br >', ' <br />'], '', $template);
                $bodyReceiver = str_replace('<p>{powermail_all}</p>', $templatefinal, $this->settings['receiver']['body']);

                if($this->settings['main']['optin'] != 0) {
                    $resiced = preg_split('/[\s,;]+/', $this->settings['receiver']['email']);
                    if (count($resiced) > 1) {
                        foreach ($resiced as $key => $resice) {

                            $mailToAdmin = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                            $mailToAdmin
                                ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                                ->to(
                                    new \Symfony\Component\Mime\Address($resice)
                                )
                                ->subject($subjectEmail)
                                ->replyTo($ReplayToEmail)
                                ->html($bodyReceiver);
                                 if($path){
                                     $mailToAdmin->attachFromPath($path);
                                 }
                            $mailToAdmin->send();
                        }
                    } else {
                        if ($this->settings['receiver']['email']) {
                            $mailToAdminOne = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                            $mailToAdminOne
                                ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                                ->to(
                                    new \Symfony\Component\Mime\Address($this->settings['receiver']['email'])
                                )
                                ->subject($subjectEmail)
                                ->replyTo($ReplayToEmail)
                                ->html($bodyReceiver);
                                  if($path){
                                      $mailToAdminOne->attachFromPath($path);
                                  }
                            $mailToAdminOne->send();
                        }
                    }
                     $hashs = HashUtility::getHash($mail);
                    if ($sys_language_uid != 0) {
                        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
                        $FormRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FormRepository');
                        $uidFormTranslateOptin = $FormRepository->getTranslateFrom($mail->getForm()->getUid(), $sys_language_uid);
                        if ($uidFormTranslateOptin) {
                            $uidFormOptin = $uidFormTranslateOptin->getUid();
                        }
                    }else{
                        $uidFormOptin = $mail->getForm()->getUid();
                    }

                    $link = $_SERVER['HTTP_ORIGIN'].$_SERVER['REDIRECT_URL']."?tx_powermail_pi1%5Baction%5D=optinConfirm&tx_powermail_pi1%5Bcontroller%5D=Form&tx_powermail_pi1%5Bhash%5D=".$hashs."&tx_powermail_pi1%5Bmail%5D=".$mail->getUid();
                    if ($sys_language_uid == 0) {
                        $textlink = "Bitte klicken Sie hier, um Ihre Anmeldung zu bestätigen";
                    }else if ($sys_language_uid == 1) {
                        $textlink = "Please click here to confirm your registration";
                    }else if ($sys_language_uid == 2) {
                        $textlink = "Veuillez cliquer ici pour confirmer votre inscription";
                    }else if ($sys_language_uid == 3) {
                        $textlink = "Fare clic qui per confermare la registrazione";
                    }
                    $template .= "<div style='padding-top: 10px;'><a href='".$link."'>".$textlink."</a></div> ";

                    if ($markers['mailadressenewslettre']) {
                        $mailsend = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                        $mailsend
                            ->from(new \Symfony\Component\Mime\Address($markers['mailadressenewslettre'], 'SZBLIND'))
                            ->to(
                            // new \Symfony\Component\Mime\Address('omar.jmal91@gmail.com')
                                new \Symfony\Component\Mime\Address($markers['mailadresse'])
                            )
                            ->subject($subjectEmail ." + Newsletter Anmeldung")
                            ->replyTo($ReplayToEmail)
                            ->html(str_replace(['<br>', '</br>', ' <br >', ' <br />'], '', $template));
                            if($path){
                                $mailsend->attachFromPath($path);
                            }
                            $mailsend->send();
                    }
                }

                $this->view->assign('optinActive', true);

                if($uidFormOptin == 7 || $uidFormOptin == 23){
                    $uriBuilder = $this->controllerContext->getUriBuilder();
                    $uriBuilder->reset();
                    if($this->settings['thx']['redirect']){
                        $explode = explode('t3://page?uid=',$this->settings['thx']['redirect']);
                        if(count($explode) == 2){
                            $uriBuilder->setTargetPageUid((int)$explode['1']);
                        }else{
                            $uriBuilder->setTargetPageUid((int)68);
                        }
                    }else{
                        $uriBuilder->setTargetPageUid((int)68);
                    }
                    $uri = $uriBuilder->build(); // ready, steady…
                    $this->redirectToUri($uri);
                }else {
                    $uriBuilder = $this->controllerContext->getUriBuilder();
                    $uriBuilder->reset();
                    //$uriBuilder->setTargetPageUid((int)767);
                    if($this->settings['thx']['redirect']){
                        $explode = explode('t3://page?uid=',$this->settings['thx']['redirect']);
                        if(count($explode) == 2){
                            $uriBuilder->setTargetPageUid((int)$explode['1']);
                        }else{
                            $uriBuilder->setTargetPageUid((int)767);
                        }
                    }else{
                        $uriBuilder->setTargetPageUid((int)767);
                    }
                    $uri = $uriBuilder->build(); // ready, steady…
                    $this->redirectToUri($uri);
                }
            }

            if ($this->isPersistActive()) {
                $this->mailRepository->update($mail);
                $this->persistenceManager->persistAll();
            }

            $this->signalDispatch(__CLASS__, __FUNCTION__ . 'AfterSubmitView', [$mail, $hash, $this]);
            $this->prepareOutput($mail);




            $finisherRunner = $this->objectManager->get(FinisherRunner::class);
            /** @noinspection PhpUnhandledExceptionInspection */
            $finisherRunner->callFinishers(
                $mail,
                $this->isNoOptin($mail, $hash),
                $this->actionMethodName,
                $this->settings,
                $this->contentObject
            );

        }


        return $this->htmlResponse();
    }

    /**
     * @param Mail $mail
     * @param string $hash
     * @return void
     */
    protected function sendMailPreflight(Mail $mail, string $hash = ''): void
    {
        try {
            if ($this->isSenderMailEnabled() && $this->mailRepository->getSenderMailFromArguments($mail)) {
                $mailPreflight = $this->objectManager->get(
                    SendSenderMailPreflight::class,
                    $this->settings,
                    $this->conf
                );
                $mailPreflight->sendSenderMail($mail);
            }
            if ($this->isReceiverMailEnabled()) {
                $mailPreflight = $this->objectManager->get(SendReceiverMailPreflight::class, $this->settings);
                $isSent = $mailPreflight->sendReceiverMail($mail, $hash);
                if ($isSent === false) {
                    $this->addFlashMessage(
                        LocalizationUtility::translate('error_mail_not_created'),
                        '',
                        AbstractMessage::ERROR
                    );
                    $this->messageClass = 'error';
                }
            }
        } catch (\Exception $exception) {
            $logger = ObjectUtility::getLogger(__CLASS__);
            $logger->critical('Mail could not be sent', [$exception->getMessage()]);
        }
    }

    /**
     * @param Mail $mail
     * @return void
     * @throws InvalidConfigurationTypeException
     * @throws InvalidExtensionNameException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws Exception
     */
    protected function prepareOutput(Mail $mail): void
    {
        $this->view->assignMultiple(
            [
                'variablesWithMarkers' => $this->mailRepository->getVariablesWithMarkersFromMail($mail, true),
                'mail' => $mail,
                'marketingInfos' => SessionUtility::getMarketingInfos(),
                'messageClass' => $this->messageClass,
                'ttContentData' => $this->contentObject->data,
                'uploadService' => $this->uploadService,
                'powermail_rte' => $this->settings['thx']['body'],
                'powermail_all' => TemplateUtility::powermailAll($mail, 'web', $this->settings, $this->actionMethodName)
            ]
        );
        $this->view->assignMultiple($this->mailRepository->getVariablesWithMarkersFromMail($mail, true));
        $this->view->assignMultiple($this->mailRepository->getLabelsWithMarkersFromMail($mail));
    }

    /**
     * @param Mail $mail
     * @return void
     * @throws Exception
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     * @throws IllegalObjectTypeException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @codeCoverageIgnore
     */
    protected function saveMail(Mail $mail): void
    {
        $mailFactory = $this->objectManager->get(MailFactory::class);
        $mailFactory->prepareMailForPersistence($mail, $this->settings);
        $this->mailRepository->add($mail);
        $this->persistenceManager->persistAll();
    }

    /**
     * Confirm Double Optin
     *
     * @param int $mail mail uid
     * @param string $hash Given Hash String
     * @return ResponseInterface
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     * @throws Exception
     * @noinspection PhpUnused
     */
    public function optinConfirmAction(int $mail, string $hash): ResponseInterface
    {
        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);
        $settings = $this->getSettings();
        $formId = isset($settings['main']['cleverreachFormId']) && \strlen($settings['main']['cleverreachFormId']) > 0 ? $settings['main']['cleverreachFormId'] : null;
        $groupId = isset($settings['main']['cleverreachGroupId']) && \strlen($settings['main']['cleverreachGroupId']) > 0 ? $settings['main']['cleverreachGroupId'] : null;
        $api = GeneralUtility::makeInstance(Api::class);


        $this->signalDispatch(__CLASS__, __FUNCTION__ . 'BeforeRenderView', [$mail, $hash, $this]);
        $mail = $this->mailRepository->findByUid($mail);
        $formValues = $this->mailRepository->getVariablesWithMarkersFromMail($mail,true);

        $response = $this->forwardIfFormParamsDoNotMatchForOptinConfirm($mail);
        if ($response !== null) {
            return $response;
        }
        $labelKey = 'failed';

        /** @noinspection PhpUnhandledExceptionInspection */
        if ($mail !== null && HashUtility::isHashValid($hash, $mail)) {
            if ($mail->getHidden()) {
                $mail->setHidden(false);
                $this->mailRepository->update($mail);
                $this->persistenceManager->persistAll();
                $this->signalDispatch(__CLASS__, __FUNCTION__ . 'AfterPersist', [$mail, $hash, $this]);

                $formValues['herr___frau'] = $formValues['marker'];
                $newDate = date("Y-m-d", strtotime($formValues['geburtsdatum']));
                $formValues['geburtstdatum'] = $newDate;
                $formValues['firma'] = $formValues['unternehmenorganisation'];

                $receiver = new Receiver($formValues['mailadresse'], $formValues);
                $receiver->setActivated(1);
                $api->addReceiversToGroup($receiver, $groupId);
                $api->sendSubscribeMail($formValues['mailadresse'], $formId, $groupId);
                $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
                $sys_language_uid = $languageAspect->getId();

                if ($sys_language_uid != 0) {
                    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
                    $FormRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FormRepository');
                    $uidFormTranslateOptin = $FormRepository->getTranslateFrom($mail->getForm()->getUid(), $sys_language_uid);
                    if ($uidFormTranslateOptin) {
                        $uidFormOptin = $uidFormTranslateOptin->getUid();
                    }
                }else{
                    $uidFormOptin = $mail->getForm()->getUid();
                }

                if($uidFormOptin == 7 || $uidFormOptin == 23){
                    $uriBuilder = $this->controllerContext->getUriBuilder();
                    $uriBuilder->reset();
                    $uriBuilder->setTargetPageUid((int)374);
                    $uri = $uriBuilder->build(); // ready, steady…
                    $this->redirectToUri($uri);
                }else{
                    return (new ForwardResponse('create'))->withArguments(['mail' => $mail, 'hash' => $hash]);

                }

            }
            $labelKey = 'done';


        }
        $this->view->assign('labelKey', $labelKey);

        return $this->htmlResponse();
    }

    /**
     * @param int $mail
     * @param string $hash
     * @return ResponseInterface
     * @throws \Exception
     * @noinspection PhpUnused
     */
    public function disclaimerAction(int $mail, string $hash): ResponseInterface
    {
        $this->signalDispatch(__CLASS__, __FUNCTION__ . 'BeforeRenderView', [$mail, $hash, $this]);
        $mail = $this->mailRepository->findByUid($mail);
        $status = false;
        if ($mail !== null && HashUtility::isHashValid($hash, $mail, 'disclaimer')) {
            $mailService = $this->objectManager->get(SendDisclaimedMailPreflight::class, $this->settings, $this->conf);
            $mailService->sendMail($mail);
            $this->mailRepository->removeFromDatabase($mail->getUid());
            $status = true;
        }
        $this->view->assign('status', $status);

        return $this->htmlResponse();
    }

    /**
     * @param string $referer Referer
     * @param int $language Frontend Language Uid
     * @param int $pid Page Id
     * @param bool $mobileDevice Is mobile device?
     * @return ResponseInterface
     * @noinspection PhpUnused
     * @codeCoverageIgnore
     */
    public function marketingAction(
        string $referer = '',
        int $language = 0,
        int $pid = 0,
        bool $mobileDevice = false
    ): ResponseInterface
    {
        SessionUtility::storeMarketingInformation($referer, $language, $pid, $mobileDevice, $this->settings);
        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(json_encode([]));
        return $response;
    }

    /**
     * Initializes this object
     *
     * @return void
     * @codeCoverageIgnore
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws Exception
     */
    public function initializeObject()
    {
        // @extensionScannerIgnoreLine Seems to be a false positive: getContentObject() is still correct in 9.0
        $this->contentObject = $this->configurationManager->getContentObject();
        $configurationService = $this->objectManager->get(ConfigurationService::class);
        $this->conf = $configurationService->getTypoScriptConfiguration();
        $this->settings = ConfigurationUtility::mergeTypoScript2FlexForm($this->settings);
        if (ArrayUtility::isValidPath($this->settings, 'debug/settings') && $this->settings['debug']['settings']) {
            $logger = ObjectUtility::getLogger(__CLASS__);
            $logger->info('Powermail settings', $this->settings);
        }
        $this->signalDispatch(__CLASS__, __FUNCTION__ . 'Settings', [$this, &$this->settings]);
    }

    /**
     * Forward to formAction if wrong form in plugin variables given
     *        used for createAction() and confirmationAction()
     *
     * @throws StopActionException
     */
    protected function forwardIfFormParamsDoNotMatch(): void
    {
        $arguments = $this->request->getArguments();
        if (isset($arguments['mail'])) {
            $formUid = null;
            if ($arguments['mail'] instanceof Mail) {
                $form = $arguments['mail']->getForm();
                if (null !== $form) {
                    $formUid = $form->getUid();
                }
            } else {
                $formUid = $arguments['mail']['form'] ?? null;
            }

            $formsToContent = GeneralUtility::intExplode(',', $this->settings['main']['form']);
            if (null === $formUid || in_array($formUid, $formsToContent, false)) {
                return;
            }
            $this->forward('form');
        }
    }

    /**
     * Forward to formAction if no mail param given
     *
     * @return ForwardResponse|null
     */
    protected function forwardIfMailParamEmpty(): ?ForwardResponse
    {
        $arguments = $this->request->getArguments();
        if (empty($arguments['mail'])) {
            $logger = ObjectUtility::getLogger(__CLASS__);
            $logger->warning('Redirect (mail empty)', $arguments);

            return new ForwardResponse('form');
        }
        return null;
    }

    /**
     * Forward to formAction if wrong form in plugin variables given
     *        used in optinConfirmAction()
     *
     * @param Mail|null $mail
     * @return ResponseInterface|null
     */
    protected function forwardIfFormParamsDoNotMatchForOptinConfirm(Mail $mail = null): ?ResponseInterface
    {
        if ($mail !== null) {
            $formsToContent = GeneralUtility::intExplode(',', $this->settings['main']['form']);
            if (!in_array($mail->getForm()->getUid(), $formsToContent)) {
                $logger = ObjectUtility::getLogger(__CLASS__);
                $logger->warning('Redirect (optin)', [$formsToContent, (array)$mail]);

                return new ForwardResponse('form');
            }
        }

        return null;
    }

    /**
     * Always forward to formAction if a validation fails. Otherwise it could happen that when
     * a validator for createAction fails, confirmationAction is called (if function is turned on) and same validators
     * are firing again
     *
     * @return ResponseInterface|null
     */
    protected function forwardToReferringRequest(): ?ResponseInterface
    {
        $originalRequest = clone $this->request;
        $this->request->setOriginalRequest($originalRequest);
        $this->request->setOriginalRequestMappingResults($this->arguments->validate());

        $response = new ForwardResponse('form');
        return $response->withArgumentsValidationResult($this->arguments->validate());
    }

    /**
     * Decide if the mail object should be persisted or not
     *        persist if
     *            - enabled with TypoScript AND hash is not set OR
     *            - optin is enabled AND hash is not set (even if disabled in TS)
     *
     * @param string $hash
     * @return bool
     */
    protected function isMailPersistActive(string $hash = ''): bool
    {
        return ($this->isPersistActive() || !empty($this->settings['main']['optin'])) && $hash === '';
    }

    /**
     * Check if mail should be send
     *        send when
     *            - optin is deaktivated OR
     *            - optin is active AND hash is correct
     *
     * @param Mail $mail
     * @param string $hash
     * @return bool
     * @throws \Exception
     */
    protected function isNoOptin(Mail $mail, string $hash = ''): bool
    {
        return empty($this->settings['main']['optin']) ||
            (!empty($this->settings['main']['optin']) && HashUtility::isHashValid($hash, $mail));
    }

    /**
     * @return void
     * @codeCoverageIgnore
     */
    protected function debugVariables(): void
    {
        if (!empty($this->settings['debug']['variables'])) {
            $logger = ObjectUtility::getLogger(__CLASS__);
            $logger->info('Variables', GeneralUtility::_POST());
        }
    }

    /**
     * @return bool
     */
    protected function isPersistActive(): bool
    {
        return $this->settings['db']['enable'] === '1';
    }

    /**
     * @return bool
     */
    protected function isSenderMailEnabled(): bool
    {
        return $this->settings['sender']['enable'] === '1';
    }

    /**
     * @return bool
     */
    protected function isReceiverMailEnabled(): bool
    {
        return $this->settings['receiver']['enable'] === '1';
    }

    /**
     * @param DataProcessorRunner $dataProcessorRunner
     * @return void
     */
    public function injectDataProcessorRunner(DataProcessorRunner $dataProcessorRunner): void
    {
        $this->dataProcessorRunner = $dataProcessorRunner;
    }

    /**
     * @param PersistenceManager $persistenceManager
     * @return void
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager): void
    {
        $this->persistenceManager = $persistenceManager;
    }


    public function formTranslate($uid,$lang)
    {


        $fields = 'uid';
        $table = 'tx_powermail_domain_model_form';
        $where = $uid . '= tx_powermail_domain_model_form.t3_origuid AND tx_powermail_domain_model_form.sys_language_uid ='.$lang;
        $groupBy = '';
        $orderBy = '';
        $limit = '1';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        return $record['uid'];
    }

     public function keyname($uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_powermail_domain_model_field');
        $record = $queryBuilder
            ->select('title')
            ->from('tx_powermail_domain_model_field')
            ->where(
                $queryBuilder->expr()->like(
                    'marker',
                    $queryBuilder->createNamedParameter($uid)
                )
            )
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        return $record['title'] ?? '';
    }

    


}
