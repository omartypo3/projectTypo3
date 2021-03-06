<?php

namespace Cundd\CustomRest\Controller;

use DRCSystems\NewsComment\Domain\Model\Comment;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationBuilder;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;

/**
 * An example Extbase controller that will be called through REST
 */
class PersonController extends ActionController
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
     * Person Repository
     *
     * @var \DRCSystems\NewsComment\Domain\Repository\CommentRepository
     * @inject
     */
    protected $personRepository;


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
     * @param \DRCSystems\NewsComment\Domain\Model\Comment $person
     */
    public function createAction(Comment $person)
    {

        $person->setPid("84");
        $person->setHidden("1");
        $person->setCrdate(time());
        $this->personRepository->add($person);

        $this->view->assign('value', ['success' => 1]);
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
            'errors'  => $flattenedValidationErrors['person'],
        ];

        $this->view->assign('value', $response);
    }


    /**
     * addPropertyMappingConfiguration
     */
    protected function addPropertyMappingConfiguration()
    {
        if ($this->request->hasArgument('person')) {
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
            foreach ((array)$this->request->getArgument('person') as $propertyName => $value) {
                $propertyMappingConfiguration->allowProperties($propertyName);
            }

            /** @noinspection PhpUnhandledExceptionInspection */
            $this->arguments->getArgument('person')->injectPropertyMappingConfiguration($propertyMappingConfiguration);
        }
    }
}
