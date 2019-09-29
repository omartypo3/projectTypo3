<?php

namespace FRONTAL\FagInstitutionManagement\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Roland Kneubühler <rk@frontal.ch>, Agentur Frontal AG
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package fag_calendar_willisau
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

use FRONTAL\FagInstitutionManagement\Domain\Model\Dates;
use FRONTAL\FagInstitutionManagement\Domain\Model\Docs;
use FRONTAL\FagInstitutionManagement\Domain\Model\Linkev;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use FRONTAL\FagInstitutionManagement\Property\TypeConverter\UploadedFileReferenceConverter;

class EventController extends \FRONTAL\FagCalendar\Controller\EventController
{

    /**
     * eventRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository;

    /**
     * datesRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\DatesRepository
     * @inject
     */
    protected $datesRepository = null;

    /**
     * docsRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\DocsRepository
     * @inject
     */
    protected $docsRepository = null;
    /**
     * institutionRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\InstitutionRepository
     * @inject
     */
    protected $institutionRepository;

    /**
     * linkevRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\LinkevRepository
     * @inject
     */
    protected $linkevRepository;
    /**
     * fileRepository
     *
     * @var TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    protected $fileRepository;

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {

        $institution = $this->institutionRepository->findByUid($GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"));
        $this->view->assign('institution', $institution);
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializecreateAction()
    {

        // DebugUtility::debug($this->request->getArgument('newEvent'));
//        $this->arguments['newEvent']
//            ->getPropertyMappingConfiguration()
//            ->forProperty('dates')
//            ->allowAllProperties();
        $this->setTypeConverterConfigurationForImageUpload('newEvent');
    }

    /**
     * action create
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Event $newEvent
     * @return void
     */
    public function createAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Event $newEvent)
    {

//        DebugUtility::debug($newEvent);
//        DebugUtility::debug($this->request->getArguments());
//        die;
        $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
        $links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
        if ($this->request->hasArgument('linkText')) {
            foreach ($this->request->getArgument('linkText') as $i => $linktext) {
                $link = new Linkev();
                $link->setText($linktext);
                $link->setUrl($this->request->getArgument('linkUrl')[$i]);
                $this->linkevRepository->add($link);
                $persistenceManager->persistAll();
                $links->attach($link);
            }
        }

        $newEvent->setLinks($links);
        $dates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
        foreach ($this->request->getArgument('dates') as $i => $date) {
            $datee = new Dates();
            $sdarray = explode('/', $date['startdate']);
            $startdate = implode("/", array($sdarray[1], $sdarray[0], $sdarray[2]));
            $edarray = explode('/', $date['enddate']);
            $enddate = implode("/", array($edarray[1], $edarray[0], $edarray[2]));

            if (!empty($date['starttime'])) {
				$newEvent->setStartTime (strtotime( $date['starttime'] . ':00'));
				$timestamps = strtotime($startdate . ' ' . $date['starttime'] . ':00');
            } else {
                $timestamps = strtotime($startdate);
            }
            if (!empty($date['endtime'])) {
				$newEvent->setEndTime ( strtotime( $date['endtime'] . ':00'));
                $timestampe = strtotime($enddate . ' ' . $date['endtime'] . ':00');
            } else {
                $timestampe = strtotime($enddate);
            }
			$newEvent->setStart(strval($timestamps));
			$newEvent->setEnd(strval($timestampe));
            $this->datesRepository->add($datee);
            $persistenceManager->persistAll();
            $dates->attach($datee);
        }


        $institution = $this->institutionRepository->findByUid($GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"));
        $newEvent->setDates($dates);
        $newEvent->setInstitution($institution);
        $this->eventRepository->add($newEvent);
        $persistenceManager->persistAll();
        $i = 0;
        if ($newEvent->getDocument()) {
            foreach ($newEvent->getDocument() as $docu) {
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file_reference', 'uid=' . $docu->getUid(), array(
                    'title' => $this->request->getArgument('docstitle')[$i]
                ));
                $i++;
            }
        }

        $assignedValues = [
            'institution' => $institution
        ];

        $this->redirect('nextStep', 'Institution', 'FagInstitutionManagement', $assignedValues, $this->settings['termine']);
    }

    /**
     * action edit
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Event $event
     * @ignorevalidation $event
     * @return void
     */
    public function editAction($event)
    {
        $datess = $event->getDates();
//        $datess = [];
//        foreach ($dates as $i => $date) {
//            $datess[$i]['startdate'] = date('m/d/Y', (int)$date->getStartdate());
//            if ($date->getStartdate()) {
//                $datess[$i]['starttime'] = date('H:i', (int)$date->getStartdate());
//
//            }
//            if ($date->getEnddate()) {
//                $datess[$i]['enddate'] = date('m/d/Y', (int)$date->getEnddate());
//            }
//            if ($date->getEnddate()) {
//                $datess[$i]['endttime'] = date('H:i', (int)$date->getEnddate());
//            }
//
//        }
        //DebugUtility::debug($datess);
		$event->setStartTime(date('H:i', (int)$event->getStartTime()));
		$event->setEndTime(date('H:i', (int)$event->getEndTime()));
        $this->view->assignMultiple(['event' => $event, 'dates' => $datess]);
    }


    /**
     * action  delete
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Event $event
     * @ignorevalidation $event
     * @return void
     */
    public function deleteAction($event)
    {
        $this->eventRepository->remove($event);
        $institution = $this->institutionRepository->findByUid($GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"));

        $assignedValues = [
            'institution' => $institution
        ];

        $this->redirect('nextStep', 'Institution', 'FagInstitutionManagement', $assignedValues, $this->settings['termine']);
    }


    /**
     * Set TypeConverter option for image upload
     */
    public function initializeupdateAction()
    {
        $this->setTypeConverterConfigurationForImageUpload('event');
    }

    /**
     * action update
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Event $event
     */
    public function updateAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Event $event)
    {
//        DebugUtility::debug($event);
//        DebugUtility::debug($this->request->getArguments());
//
//        die;


        $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
        $links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
        if ($this->request->hasArgument('linkText')) {
            foreach ($this->request->getArgument('linkText') as $i => $linktext) {
                $link = new Linkev();
                $link->setText($linktext);
                $link->setUrl($this->request->getArgument('linkUrl')[$i]);
                $this->linkevRepository->add($link);
                $persistenceManager->persistAll();
                $links->attach($link);
            }
        }
        $event->setLinks($links);
        //DebugUtility::debug($this->request->getArgument('dates'));
        //die();
        $dates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
        foreach ($this->request->getArgument('dates') as $i => $date) {
            $datee = new Dates();
            $sdarray = explode('/', $date['startdate']);
            $startdate = implode("/", array($sdarray[1], $sdarray[0], $sdarray[2]));
            $edarray = explode('/', $date['enddate']);
            $enddate = implode("/", array($edarray[1], $edarray[0], $edarray[2]));

            if (!empty($date['starttime'])) {
				$event->setStartTime (strtotime( $date['starttime'] . ':00'));
                $timestamps = strtotime($startdate . ' ' . $date['starttime'] . ':00');
            } else {
                $event->setStartTime(0);
                $timestamps = strtotime($startdate);
            }
            if (!empty($date['endtime'])) {
				$event->setEndTime ( strtotime( $date['endtime'] . ':00'));
				$timestampe =  strtotime($enddate . ' ' . $date['endtime'] . ':00');
            } else {
                $event->setEndTime(0);
                $timestampe = strtotime($enddate);
            }
			$event->setStart(strval($timestamps));
			$event->setEnd(strval($timestampe));
            $this->datesRepository->add($datee);
            $persistenceManager->persistAll();
            $dates->attach($datee);
        }

        $event->setDates($dates);

        $institution = $event->getInstitution()->getUid();
        $this->eventRepository->update($event);
        $persistenceManager->persistAll();
        $i = 0;

        if ($this->request->hasArgument('docstitle')) {


            foreach ($event->getDocument() as $docu) {
//            DebugUtility::debug($docu);
                $desc = "";
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file_reference', 'uid=' . $docu->getUid(), array(
                    'title' => $this->request->getArgument('docstitle')[$i],
                ));
                $i++;
            }
        } else {
            foreach ($event->getDocument() as $docu) {
//            DebugUtility::debug($docu);
                $desc = "";
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file_reference', 'uid=' . $docu->getUid(), array(
                    'deleted' => 1
                ));
                $i++;
            }
        }

        $assignedValues = [
            'institution' => $institution
        ];

        $this->redirect('nextStep', 'Institution', 'FagInstitutionManagement', $assignedValues, $this->settings['termine']);
    }

    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
//         \TYPO3\CMS\Core\Utility\DebugUtility::debug($this->arguments) ;
//         die;
        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => 'files/',
        ];
        /** @var PropertyMappingConfiguration $newExampleConfiguration */
        $newImageConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();
        $newImageConfiguration->allowAllProperties();


        //        $newExampleConfiguration->forProperty('image')
        ////            ->setTypeConverterOptions(
        ////                'FRONTAL\\FagInstitutionManagement\\Property\\TypeConverter\\UploadedFileReferenceConverter',
        ////                $uploadConfiguration
        ////            );
//         \TYPO3\CMS\Core\Utility\DebugUtility::debug($this->arguments) ;
//         die;
//         $newImageConfiguration->forProperty('image')->setTypeConverterOptions($uploadConfiguration);

        $newImageConfiguration->forProperty('images')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('images');
        $newImageConfiguration->allowModificationForSubProperty('images');
        $newImageConfiguration->forProperty('images')
            ->setTypeConverterOptions(
                'FRONTAL\\FagInstitutionManagement\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );
        $newImageConfiguration->forProperty('document')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('document');
        $newImageConfiguration->allowModificationForSubProperty('document');
        $newImageConfiguration->forProperty('document')
            ->setTypeConverterOptions(
                'FRONTAL\\FagInstitutionManagement\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );

    }
}
