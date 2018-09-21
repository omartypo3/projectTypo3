<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 12/06/2018
 * Time: 12:41
 */
namespace DLD\Dld\Command;
use DLD\Dld\Domain\Model\EventTicket;
use \TYPO3\CMS\Extbase\Mvc\Controller\CommandController;


class xingCommandController extends CommandController
{

    /**
     * EventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     *
     **/
    protected $eventReposetory;

    /**
     * eventTicketRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventTicketRepository
     * @inject
     *
     **/
    protected $eventTicketRepository;


    public function xingCommand()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $xingApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['xingApiKey'];
        $homepage = file_get_contents("https://www.xing-events.com/api/ticketCategory/4394561?apikey=" . $xingApiKey . "&version=1&format=json");
        $d = new \DateTime('NOW');
        $t = $d->modify('-1 minutes');
        $cronTime = $t->format('YmdHis');
        /******************* Get all xing event; Ther's no condition; even the old event will be getted***********/
        $eventXings = $this->eventReposetory->findByXing();

        $ticketCategorieIdArray = array();

        foreach ($eventXings as $eventXing) {
            $XingEventId = $eventXing->getXingEventId();
//            $homepage = file_get_contents("https://www.xing-events.com/api/event/" . $XingEventId . "/participants?apikey=" . $xingApiKey . "&version=1&format=json");
            $homepage = file_get_contents("https://www.xing-events.com/api/event/" . $XingEventId . "/ticketCategories?apikey=" . $xingApiKey . "&version=1&format=json");
            $obj = \GuzzleHttp\json_decode($homepage);
            $cpt = count($obj->ticketCategories);
            /****getting the number of ticket_id from the table eventTicket by the $XingEventId ****/
            $eventTicket = $this->eventTicketRepository->findByConferenceId($XingEventId);
            if (count($eventTicket) > 0) {//it's an old we should update it
                /**get the number of id categories and copmare it with the number comming from the api*/
                $TypoCpt = count($eventTicket);
                if ($cpt > $TypoCpt) {// ther's a new categorie
                    $xingTicCat = array();
                    $typoTicCat = array();
                    foreach ($obj->ticketCategories as $ticketCategorie) {
                        $xingTicCat[] = $ticketCategorie;
                    }
                    foreach ($eventTicket as $eventT) {
                        $typoTicCat[] = $eventT->getTicketId();
                    }
                    $result = array_diff($xingTicCat,$typoTicCat);
                    if(count($result)){
                        $newEventTicket = new EventTicket();
                        $newEventTicket->setConferenceId($XingEventId);
                        $newEventTicket->setTicketId($result);
                        $newEventTicket->setHighriseTagSuffix("invited_".$result);
                        $newEventTicket->setPid(10);
                        $this->eventTicketRepository->add($newEventTicket);
                        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                        $persistenceManager->persistAll();
                    }
                }

            } else {//it's a new entrie ( we should add it)
                foreach ($obj->ticketCategories as $ticketCategorie) {
                    $newEventTicket = new EventTicket();
                    $newEventTicket->setConferenceId($XingEventId);
                    $newEventTicket->setTicketId($ticketCategorie);
                    $newEventTicket->setHighriseTagSuffix("invited_".$ticketCategorie);
                    $newEventTicket->setPid(10);
                    $this->eventTicketRepository->add($newEventTicket);
                    $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                    $persistenceManager->persistAll();
                }

            }


        }
    }
}