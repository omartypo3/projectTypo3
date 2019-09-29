<?php

namespace LeadGeneration\ContactForm\Controller;

use LeadGeneration\ContactForm\Domain\Model\Participant;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Service\CacheService;

/***
 *
 * This file is part of the "Lead Generation contact form" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * EventController
 */
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * eventRepository
     *
     * @var \LeadGeneration\ContactForm\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * participantRepository
     *
     * @var \LeadGeneration\ContactForm\Domain\Repository\ParticipantRepository
     * @inject
     */
    protected $participantRepository = null;

    /**
     * action list
     *
     * @param string $keyword
     * @return void
     */
    public function listAction($keyword = '')
    {

        if ($keyword) {
            $events = $this->eventRepository->findByKeyword($keyword);
        } else {
            $events = $this->eventRepository->findAll();
        }

        $this->view->assign('events', $events);
    }

    /**
     * action show
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Event $event
     * @return void
     */
    public function showAction(\LeadGeneration\ContactForm\Domain\Model\Event $event)
    {
        $participants = $this->participantRepository->findByEvent($event->getUid());
        $this->view->assignMultiple(['event' => $event, 'participants' => $participants]);
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
     * @param \LeadGeneration\ContactForm\Domain\Model\Event $newEvent
     * @return void
     */
    public function createAction(\LeadGeneration\ContactForm\Domain\Model\Event $newEvent)
    {
        $this->addFlashMessage('Event Successfully Created', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $setting = $extbaseFrameworkConfiguration['plugin.']['tx_contactform_fecontactform.']['settings.']['EventsStoragePageUid'];
        $newEvent->setPid((int)$setting);
        $this->eventRepository->add($newEvent);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Event $event
     * @ignorevalidation $event
     * @return void
     */
    public function editAction(\LeadGeneration\ContactForm\Domain\Model\Event $event)
    {
        $this->view->assign('event', $event);
    }

    /**
     * action update
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Event $event
     * @return void
     */
    public function updateAction(\LeadGeneration\ContactForm\Domain\Model\Event $event)
    {
        $this->addFlashMessage('Event Successfully Uppdated', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->eventRepository->update($event);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Event $event
     * @return void
     */
    public function deleteAction(\LeadGeneration\ContactForm\Domain\Model\Event $event)
    {
        $this->addFlashMessage('Event Successfully Deleted', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->eventRepository->remove($event);
        $this->redirect('list');
    }

    /**
     * action export
     *
     * @param array $events
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return void
     */
    public function exportAction($events = [])
    {

        if (!file_exists('fileadmin/export')) {
            mkdir('fileadmin/export', 511, true);
        }
        if ($events) {
            $exports = $this->eventRepository->findByUids($events);
            $phpExcelService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('phpexcel');
            $objPHPExcel = $phpExcelService->getPHPExcel();
            foreach ($exports as $key => $event) {
                if ($key > 0) {
                    $objPHPExcel->createSheet();
                }
                $objPHPExcel->setActiveSheetIndex($key);
                $objPHPExcel->getActiveSheet()->setTitle($event->getName());
                $participants = $this->participantRepository->findByEvent($event->getUid());
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A1', 'Gender')
                    ->setCellValue('B1', 'Title')
                    ->setCellValue('C1', 'First Name')
                    ->setCellValue('D1', 'Last Name')
                    ->setCellValue('E1', 'Email')
                    ->setCellValue('F1', 'Company')
                    ->setCellValue('G1', 'City')
                    ->setCellValue('H1', 'Country')
                    ->setCellValue('I1', 'Interventional Pulmonologist')
                    ->setCellValue('J1', 'Pneumologist')
                    ->setCellValue('K1', 'Thoracic Surgeon')
                    ->setCellValue('L1', 'General Practitioner')
                    ->setCellValue('M1', 'Distributor')
                    ->setCellValue('N1', 'Other Specialist')
                    ->setCellValue('O1', 'Product Portfolio information')
                    ->setCellValue('P1', 'Clinical Evidence Information')
                    ->setCellValue('Q1', 'Other materials / topics of the discussion')
                    ->setCellValue('R1', 'Make contact by sales representative ')
                    ->setCellValue('S1', 'Reason for contact')
                    ->setCellValue('T1', 'Contact at Pulmonx');
                $dataArray = [];
                foreach ($participants as $participant) {
                    $rowarray = [];
                    $rowarray['Gender'] = $participant->getGender();
                    $rowarray['Title'] = $participant->getTitle();
                    $rowarray['First Name'] = $participant->getFirstName();
                    $rowarray['Last Name'] = $participant->getLastName();
                    $rowarray['Email'] = $participant->getEmail();
                    $rowarray['Company'] = $participant->getCompany();
                    $rowarray['City'] = $participant->getCompany();
                    $rowarray['Country'] = $participant->getCountry();
                    $rowarray['Interventional Pulmonologist'] = $participant->getInterventionalPulmonologist();
                    $rowarray['Pneumologist'] = $participant->getPneumologist();
                    $rowarray['Thoracic Surgeon'] = $participant->getThoracicSurgeon();
                    $rowarray['General Practitioner'] = $participant->getGeneralPractitioner();
                    $rowarray['Distributor'] = $participant->getDistributor();
                    $rowarray['Other Specialist'] = $participant->getSpecialistOther();
                    $rowarray['Product Portfolio information'] = $participant->getInformationProductPortfolio();
                    $rowarray['Clinical Evidence Information'] = $participant->getInformaztionClinicalEvidence();
                    $rowarray['Other Information'] = $participant->getInformationOther();
                    $rowarray['Contact'] = $participant->getContact();
                    $rowarray['Contact Reason'] = $participant->getContactReason();
                    $rowarray['Captured By'] = $participant->getCapturedBy();
                    array_push($dataArray, $rowarray);
                }
                $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A2');
            }
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Type: application/force-download');
            header('Content-Type: application/octet-stream');
            header('Content-Type: application/download');
            header('Content-Disposition: attachment;filename=export.xls');
            header('Content-Transfer-Encoding: binary ');
            $excelWriter = $phpExcelService->getInstanceOf('PHPExcel_Writer_Excel2007', $objPHPExcel);
            $file = 'fileadmin/export/export_' . date('d-m-Y_H.i.s') . '.xlsx';
            $excelWriter->save($file);
            $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
            $dataHandler->start([], []);
            $dataHandler->clear_cacheCmd('all');
            $this->view->assign('url', 'http://medical9.local/'. $file);

        }
    }
    /**
     * Set TypeConverter option for image upload
     */
    public function initializeCreateAction()
    {


        $this->arguments['newEvent']->getPropertyMappingConfiguration()->forProperty('startDate')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd/m/Y'
        );

        $this->arguments['newEvent']->getPropertyMappingConfiguration()->forProperty('endDate')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',


            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd/m/Y'
        );

    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeUpdateAction()
    {
        $this->arguments['event']->getPropertyMappingConfiguration()->forProperty('startDate')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd/m/Y'
        );
        $this->arguments['event']->getPropertyMappingConfiguration()->forProperty('endDate')->setTypeConverterOption(
            'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
            'd/m/Y'
        );
    }

}
