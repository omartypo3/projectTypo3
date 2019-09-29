<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 12/06/2018
 * Time: 12:41
 */

namespace FRONTAL\FagBesichtigung\Command;

use TYPO3\CMS\Core\Utility\DebugUtility;
use \TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;


class sendCommandController extends CommandController
{

    /**
     * datumRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository
     * @inject
     */
    protected $datumRepository = null;
    /**
     * eventRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    public function sendCommand()
    {
        $datums = $this->datumRepository->findAll();
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $Helfenstein = $extbaseFrameworkConfiguration['plugin.']['tx_fagbesichtigung_besichtigung.']['settings.']['Helfenstein_email'];
        $max = 0;
        foreach ($datums as $datum) {
            $i = $datum->getGruppentyp()->getUid();
            switch ($i) {
                case 1:
                    if (count($datum->getAnfrage()) == 0) {
                        $max = $datum->getTeilnehmerMax();
                    } else {
                        $somme = 0;
                        foreach ($datum->getAnfrage() as $max0) {
                            $somme = intval($somme) + intval($max0->getTeilnehmeraktuell());
                            // DebugUtility::debug($somme);
                        }

                        $max = $datum->getTeilnehmerMax() - $somme;

                    }
                    $date_aujourdhui = new \DateTime();
                    $date = date_format($date_aujourdhui, "Y-m-d");
                    $eventdate = date_format($datum->getDate(), "Y-m-d");
                    if ($max == 0) {

                        $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $datum->getUid(), array(
                            'status' => 'Ausgebucht'
                        ));
                    }
                    if($date == $eventdate) {
                        $time = date_format($date_aujourdhui, "H:i");
                        $eventtime = new \DateTime();
                        $eventtime->setTimestamp($datum->getStartTime());
                        $eventtime->format("H:i");
                        $timehi = date_format($eventtime, "H:i");
                        if($time >= $timehi){
                            $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $datum->getUid(), array(
                                'status' => 'Ausgebucht'
                            ));
                        }
                    }else if($date > $eventdate){
                        $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $datum->getUid(), array(
                            'status' => 'Ausgebucht'
                        ));
                    }
                    break;
                case 2:
                    if ($datum->getStatus() == 'Verfügbar') {
                        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fagbesichtigung_domain_model_datum');
                        $rows = $queryBuilder
                            ->select('event')
                            ->from('tx_fagbesichtigung_domain_model_datum')
                            ->Where(
                                "tx_fagbesichtigung_domain_model_datum.uid = " . $datum->getUid()
                            )
                            ->andWhere(
                                "tx_fagbesichtigung_domain_model_datum.deleted = 0"
                            )
                            ->andWhere(
                                "tx_fagbesichtigung_domain_model_datum.hidden = 0"
                            )
                            ->execute();

                        while ($r = $rows->fetch()) {
                            $e = $this->eventRepository->findByUid((int)$r['event']);
                            if (count($e) != 0) {
                                $emails = [];
                                foreach ($e->getGruppenFuhrer() as $adminemail) {
                                    $admin = $adminemail->getEmail();
                                    array_push($emails, $admin);
                                }
                                $date_aujourdhui = new \DateTime('today');
                                // On compare les deux dates
                                $date = date_format($datum->getDate(), "Y-m-d");
                                $datesub = date_create($date);

                                $sub = date_sub($datesub, date_interval_create_from_date_string("14 days"));
                                if ($sub <= $date_aujourdhui) {
                                    $dateV = $datum->getDate();
                                    $m = $dateV->format('n');
                                    $d = $dateV->format('d');
                                    $y = $dateV->format('Y');
                                    $dayOfWeek = date("w", strtotime($dateV->format('Y-m-d')));

                                    $monthNames = array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
                                    $days = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
                                    $dateFormat = $days[$dayOfWeek] . ", " . $d . ". " . $monthNames[$m - 1] . " " . $y;
                                    $startDate = date("H:i", $datum->getStartTime());
                                    $endDate = date("H:i", $datum->getEndTime());
                                    $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                                    $mail->setSubject('');
                                    $mail->setfrom(array('admin@ewl.ch' => 'Absagen'));
                                    $mail->setSubject("Absage " . $e->getTitel());
                                    $mail->setTo($datum->getGruppenFuhrer()->getEmail());
                                    $mail->setBody('Here is the message itself');
                                    $mail->addPart('<p>Guten Tag</p>
                           <p>Der folgende Besichtigungstermin wurde nicht gebucht und wird deshalb abgesagt.</p>
                           <p>Datum: ' . $dateFormat . '</p>
                           <p>' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>', 'text/html');
                                    $mail->send();

                                    $mail1 = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                                    $mail1->setSubject('');
                                    $mail1->setfrom(array('admin@ewl.ch' => 'Absagen'));
                                    $mail1->setSubject("Absage " . $e->getTitel());
                                    $mail1->setTo($emails);
                                    $mail1->setBody('Here is the message itself');
                                    $mail1->addPart('<p>Guten Tag</p>
                           <p>Der folgende Besichtigungstermin wurde nicht gebucht und wird deshalb abgesagt.</p>
                           <p>Datum: ' . $dateFormat . '</p>
                           <p>' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>', 'text/html');
                                    $mail1->send();

                                    if ($e->getSendEmail() == '1') {
                                        $mail2 = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                                        $mail2->setSubject('');
                                        $mail2->setfrom(array('admin@ewl.ch' => 'Absagen'));
                                        $mail2->setSubject("Absage " . $e->getTitel());
                                        $mail2->setTo($Helfenstein);
                                        $mail2->setBody('Here is the message itself');
                                        $mail2->addPart('<p>Guten Tag</p>
                               <p>Der folgende Besichtigungstermin wurde nicht gebucht und wird deshalb abgesagt.</p>
                               <p>Datum: ' . $dateFormat . '</p>
                               <p>' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>', 'text/html');
                                        $mail2->send();
                                    }

                                    $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . $datum->getUid(), array(
                                        'status' => 'Ausgebucht'
                                    ));
                                }
                            }

                        }
                    }
                    break;

            }



        }
       // die();
    }
}