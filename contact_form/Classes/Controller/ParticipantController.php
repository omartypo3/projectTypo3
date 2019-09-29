<?php

namespace LeadGeneration\ContactForm\Controller;

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

use SJBR\StaticInfoTables\Domain\Model\Country;
use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 * ParticipantController
 */
class ParticipantController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * participantRepository
     *
     * @var \LeadGeneration\ContactForm\Domain\Repository\ParticipantRepository
     * @inject
     */
    protected $participantRepository = null;

    /**
     * eventRepository
     *
     * @var \LeadGeneration\ContactForm\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * countryRepository
     *
     * @var \SJBR\StaticInfoTables\Domain\Repository\CountryRepository
     * @inject
     */
    protected $countryRepository = null;

    /**
     * action list
     * @param string $keyword
     *
     * @return void
     */
    public function listAction($keyword = '')
    {


        $participants = $this->participantRepository->findByKeyword($keyword);
        $this->view->assign('participants', $participants);
    }

    /**
     * action show
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Participant $participant
     * @return void
     */
    public function showAction(\LeadGeneration\ContactForm\Domain\Model\Participant $participant)
    {
        $this->view->assign('participant', $participant);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $defaultOrderings = array(
            'cn_short_en' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
        );
        $this->countryRepository->setDefaultOrderings($defaultOrderings);
        $events = $this->eventRepository->findCurrentAndUpcoming();
        $countries = $this->countryRepository->findAll();
        $cummon = array();
        $ids = explode(',', $this->settings['countries']);
        foreach ($ids as $id) {

            array_push($cummon, $this->countryRepository->findByUid((int)$id));
        }
        usort($cummon, function ($a, $b) {
            return strcmp($a->getShortNameEn(), $b->getShortNameEn());
        });
        
        $this->view->assignMultiple(array('events' => $events, 'cummon' => $cummon, 'countries' => $countries));
    }

    /**
     * action create
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Participant $newParticipant
     * @return void
     */
    public function createAction(\LeadGeneration\ContactForm\Domain\Model\Participant $newParticipant)
    {
        $this->addFlashMessage('Your Participation is Successfully submitted', 'Thank you for participation', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $setting = $extbaseFrameworkConfiguration['plugin.']['tx_contactform_fecontactform.']['settings.']['ParticipantsStoragePageUid'];
        $newParticipant->setPid((int)$setting);
        $this->participantRepository->add($newParticipant);

       // $this->redirect('new');
    }

    /**
     * action edit
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Participant $participant
     * @ignorevalidation $participant
     * @return void
     */
    public function editAction(\LeadGeneration\ContactForm\Domain\Model\Participant $participant)
    {
        $this->view->assign('participant', $participant);
    }

    /**
     * action update
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Participant $participant
     * @return void
     */
    public function updateAction(\LeadGeneration\ContactForm\Domain\Model\Participant $participant)
    {
        $this->addFlashMessage('Participant Successfully Updated', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->participantRepository->update($participant);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \LeadGeneration\ContactForm\Domain\Model\Participant $participant
     * @return void
     */
    public function deleteAction(\LeadGeneration\ContactForm\Domain\Model\Participant $participant)
    {
        $this->addFlashMessage('Participant Successfully Deleted', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->participantRepository->remove($participant);
        $this->redirect('list');
    }
}
