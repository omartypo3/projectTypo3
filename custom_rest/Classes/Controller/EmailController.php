<?php

namespace Cundd\CustomRest\Controller;

use Cundd\CustomRest\Domain\Model\Email;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationBuilder;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;

/**
 * An example Extbase controller that will be called through REST
 */
class EmailController extends ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Mvc\View\JsonView
     */
    protected $view;

    /**
     * @var string
     */
    protected $defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;

    /**
     * Email Repository
     *
     * @var \Cundd\CustomRest\Domain\Repository\EmailRepository
     * @inject
     */
    protected $emailRepository;


    /* ----------------- POST -------------*/
    /**
     * initialize action create
     */
    public function initializeCreateAction()
    {
        // If the request does not come from a fluid form the properties which are allowed to map must be set manually
        if (!$this->request->getInternalArgument('__trustedProperties')) {
            $this->addPropertyMappingConfiguration();
        }
    }

    /**
     * action create
     *
     *@param \Cundd\CustomRest\Domain\Model\Email $email
     */
    public function createAction(Email $email)
    {

            $this->emailRepository->add($email);

            $MailMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $MailMessage->setSubject('');
            $MailMessage->setfrom(array('topapp@pingag.ch' => 'Toponline.ch'));
            $MailMessage->setSubject($email->getSubject());
            $MailMessage->setTo($email->getEmail());
            $MailMessage->setBody('Here is the message itself');
            $MailMessage->addPart('<p>' . $email->getText() . '</p>', 'text/html');
            $MailMessage->send();


            $this->view->assign('value', ['success' =>  $email->getText()]);



    }

    /*-----------------------------------------------------------------*/

    /**
     * error action
     */
    protected function errorAction()
    {
        $flattenedValidationErrors = $this->arguments->getValidationResults()->getFlattenedErrors();

        $response = [
            'success' => 0,
            'errors' => $flattenedValidationErrors['email'],
        ];

        $this->view->assign('value', $response);
    }

    /**
     * addPropertyMappingConfiguration
     */
    protected function addPropertyMappingConfiguration()
    {
        if ($this->request->hasArgument('email')) {
            /** @var MvcPropertyMappingConfiguration $propertyMappingConfiguration */
            $propertyMappingConfiguration = (new PropertyMappingConfigurationBuilder())->build(
                MvcPropertyMappingConfiguration::class
            );
            $propertyMappingConfiguration->setTypeConverterOption(
                PersistentObjectConverter::class,
                PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
                true
            );

            /** @noinspection PhpUnhandledExceptionInspection */
            foreach ((array)$this->request->getArgument('email') as $propertyName => $value) {
                $propertyMappingConfiguration->allowProperties($propertyName);
            }

            /** @noinspection PhpUnhandledExceptionInspection */
            $this->arguments->getArgument('email')->injectPropertyMappingConfiguration($propertyMappingConfiguration);
        }
    }

}
