<?php

namespace DLD\Dld\Controller;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/
use DLD\Dld\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;

/**
 * PartnerController
 */
class PartnerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * partnerRepository
     *
     * @var \DLD\Dld\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = null;

    /**
     * eventPartnerReposetory
     *
     * @var  \DLD\Dld\Domain\Repository\EventPartnerRepository
     * @inject
     */
    protected $eventPartnerReposetory;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $title = $this->settings['input'];
        $pageid = $this->settings['pageid'];
        if (TYPO3_MODE == 'BE') {
            $parteners = $this->partnerRepository->findAll();
        }
        else {
            if ($this->settings['partenersEvent'] == 'methode1') {
                $eventId = $this->settings['partenerMethodeOne'];
                $parteners = $this->eventPartnerReposetory->findByEventId($eventId);

                if (count($parteners) > 0) {
                    $partnersIds = array();
                    foreach ($parteners as $partener) {
                        $partnersIds[] = $partener->getPartnerId();
                    }
                    $parteners = $this->partnerRepository->findPartnerById($partnersIds);
                } else {
                    $parteners = '';
                }

            } else {
                $partnersId = explode(",", $this->settings['partenerMethode']);
                $parteners = $this->partnerRepository->findPartnerById($partnersId);
            }
        }
            $this->view->assignMultiple(array('partners' => $parteners, 'pageid' => $pageid, 'title' => $title));

    }

    /**
     * action show
     *
     * @param \DLD\Dld\Domain\Model\Partner $partner
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\Partner $partner)
    {
        $this->view->assign('partner', $partner);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {

$fields =array();$fields[''] = '' ;
$fields['Art, Design, Culture'] = 'Art, Design, Culture' ;
$fields['Business (non digital) Professional Service'] = 'Business (non digital) Professional Service' ;
$fields['Digital, Technology'] = 'Digital, Technology' ;
$fields['Education'] = 'Education' ;
$fields['Entertainment'] = 'Entertainment' ;
$fields['Finance'] = 'Finance' ;
$fields['Investor'] = 'Investor' ;
$fields['Journalist'] = 'Journalist' ;
$fields['Life & Health'] = 'Life & Health' ;
$fields['Media'] = 'Media' ;
$fields['Politics'] = 'Politics' ;
$fields['Science'] = 'Science' ;
$fields['Social'] = 'Social' ;
$fields['Start-up'] = 'Start-up' ;
$fields['Student'] = 'Student' ;
$fields['Other'] = 'Other' ;
$this->view->assign('fields',$fields);
    }

    /**
     * action create
     *
     * @param \DLD\Dld\Domain\Model\Partner $newPartner
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\Partner $newPartner)
    {
        //$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $storagePid = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['partnersPid'];
        $newPartner->setPid($storagePid);
        $this->partnerRepository->add($newPartner);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DLD\Dld\Domain\Model\Partner $partner
     * @ignorevalidation $partner
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\Partner $partner)
    {$fields =array();
        $fields[''] = '' ;
        $fields['Art, Design, Culture'] = 'Art, Design, Culture' ;
        $fields['Business (non digital) Professional Service'] = 'Business (non digital) Professional Service' ;
        $fields['Digital, Technology'] = 'Digital, Technology' ;
        $fields['Education'] = 'Education' ;
        $fields['Entertainment'] = 'Entertainment' ;
        $fields['Finance'] = 'Finance' ;
        $fields['Investor'] = 'Investor' ;
        $fields['Journalist'] = 'Journalist' ;
        $fields['Life & Health'] = 'Life & Health' ;
        $fields['Media'] = 'Media' ;
        $fields['Politics'] = 'Politics' ;
        $fields['Science'] = 'Science' ;
        $fields['Social'] = 'Social' ;
        $fields['Start-up'] = 'Start-up' ;
        $fields['Student'] = 'Student' ;
        $fields['Other'] = 'Other' ;
        $this->view->assign('fields',$fields);
        $this->view->assign('partner', $partner);
    }

    /**
     * action update
     *
     * @param \DLD\Dld\Domain\Model\Partner $partner
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\Partner $partner)
    {
        //$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $storagePid = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['partnersPid'];
        $partner->setPid($storagePid);
        $this->partnerRepository->removeFileRefrence($partner->getUid());
        $this->partnerRepository->update($partner);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DLD\Dld\Domain\Model\Partner $partner
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\Partner $partner)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->partnerRepository->remove($partner);
        $this->redirect('list');
    }

    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {

            $uploadConfiguration = [
                UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => 'fileadmin/dld/partner',
            ];

            /** @var PropertyMappingConfiguration $newExampleConfiguration */
            $newImageConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();


            $newImageConfiguration->forProperty('logo')->allowAllProperties();
            $newImageConfiguration->allowCreationForSubProperty('logo');
            $newImageConfiguration->allowModificationForSubProperty('logo');
            $newImageConfiguration->forProperty('logo')
                ->setTypeConverterOptions(
                    'DLD\\Dld\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                    $uploadConfiguration
                );
        }


    /**
     * Set TypeConverter option for image upload
     */
    public function initializeUpdateAction()
    {

        $this->setTypeConverterConfigurationForImageUpload('partner');
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeCreateAction()
    {
        $this->setTypeConverterConfigurationForImageUpload('newPartner');
    }

}
