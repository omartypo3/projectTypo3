<?php

namespace DLD\Dld\Controller;

use DLD\Dld\Domain\Model\People;
use DLD\Dld\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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

/**
 * PeopleController
 */
class PeopleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * peopleRepository
     *
     * @var \DLD\Dld\Domain\Repository\PeopleRepository
     * @inject
     */
    protected $peopleRepository = null;
    /**
     * userTagRepository
     *
     * @var \DLD\Dld\Domain\Repository\UserTagRepository
     * @inject
     */
    protected $userTagRepository = null;

    /**
     * sessionPeopleRepository
     *
     * @var \DLD\Dld\Domain\Repository\SessionPeopleRepository
     * @inject
     */
    protected $sessionPeopleRepository = null;

    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * userGroupRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $userGroupRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $peoples = $this->peopleRepository->findAll();
        $this->view->assign('peoples', $peoples);

    }

    /**
     * action amazing
     *
     * @return void
     */
    public function amazingAction()
    {
        $settings = $this->settings;
        $peoples = $this->peopleRepository->getAmazingSpeakers();
        $this->view->assignMultiple(array('peoples' => $peoples, 'pageid' => $settings));

    }

    /**
     * action dldteam
     *
     * @return void
     */
    public function dldteamAction()
    {
        $list = explode(",", $this->settings['teamlist']);

        $peoples = array();
        foreach ($list as $p) {
            $people = $this->peopleRepository->findByUid((int)$p);
            array_push($peoples, $people);
        }
        $this->view->assign('peoples', $peoples);

    }

    public function initializeShowAction()
    {

        if(empty($this->peopleRepository->findByUid($this->request->getArgument('people'))))
        {
            $people = $this->peopleRepository->findByUsername($this->request->getArgument('people'))->getFirst();
            if ($people)
                $this->request->setArgument('people',$people );

            else {
                $this->request->setArgument('people', new People());

            }
        }


    }


    /**
     * action show
     *
     * @param \DLD\Dld\Domain\Model\People $people
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\People $people)
    {


        if ($GLOBALS['TSFE']->fe_user->user['uid'] != $people->getUid() ) {

            if ($this->sessionPeopleRepository->findByPeopleId($people->getUid())->count() == 0 || $people->getUid() ==null)
                $people = Null;
            $this->view->assign('currentuser', 0);
        } else {
            $this->view->assign('currentuser', 1);
        }

        $this->view->assign('profilevisibility', $this->settings['profilevisibilitymessage']);
        $this->view->assign('people', $people);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     *
     * @param \DLD\Dld\Domain\Model\People $newPeople
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\People $newPeople)
    {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $storagePid = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['feUserStoragePid'];

        $newPeople->setPid($storagePid);
        //$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->peopleRepository->add($newPeople);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DLD\Dld\Domain\Model\People $people
     * @ignorevalidation $people
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\People $people)
    {
        $tags = $this->userTagRepository->findByUserid($people->getUid());
        $this->view->assignMultiple(array('people' => $people, 'tags' => $tags));
    }

    /**
     * action update
     *
     * @param \DLD\Dld\Domain\Model\People $people
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\People $people)
    {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $storagePid = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['feUserStoragePid'];
        $people->setPid($storagePid);
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->peopleRepository->update($people);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DLD\Dld\Domain\Model\People $people
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\People $people)
    {
        $tags = $this->userTagRepository->findByUserid($people->getUid());
        foreach ($tags as $tag) {
            $this->userTagRepository->remove($tag);
        }
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->peopleRepository->remove($people);
        $this->redirect('list');
    }


    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => 'fileadmin/dld/people',
        ];

        /** @var PropertyMappingConfiguration $newExampleConfiguration */
        $newImageConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();


        $newImageConfiguration->forProperty('image.0')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('image.0');
        $newImageConfiguration->allowModificationForSubProperty('image.0');
        $newImageConfiguration->forProperty('image.0')
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

        $this->setTypeConverterConfigurationForImageUpload('people');
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeCreateAction()
    {


        $this->setTypeConverterConfigurationForImageUpload('newPeople');
    }

    public function alllistAction()
    {
        $peoples = $this->peopleRepository->findAll();
        $this->view->assign('peoples', $peoples);
    }

    public function allspeakersAction()
    {

        $varevent = 0;
        $name = '';
        $lastnames = '';
        $company = '';
        $limit = (int)$this->settings['peopleItemsPerPage'];
        $offset = 0;
        if (isset($this->request->getArguments()['offset'])) {
            $offset = (int)$this->request->getArgument('offset');

        }

        if (isset($this->request->getArguments()['selectevent'])) {
            $varevent = (int)$this->request->getArgument('selectevent');
        }
        if (isset($this->request->getArguments()['names'])) {
            $name = $this->request->getArgument('names');
        }
        if (isset($this->request->getArguments()['lastnames'])) {
            $lastnames = $this->request->getArgument('lastnames');
        }
        if (isset($this->request->getArguments()['company'])) {
            $company = $this->request->getArgument('company');
        }
        $offset *= $limit;
        $speakersevent = $this->sessionPeopleRepository->getSpeakersByEventId($varevent, $company, $name, $lastnames, $limit, $offset);
        $speaker = array();
        foreach ($speakersevent as $item) {
            array_push($speaker, $item->getPeopleId());
        }
        $events = $this->eventRepository->findAll();
        $this->view->assignMultiple(array('isAmazing' => $speaker, 'events' => $events));

    }
}