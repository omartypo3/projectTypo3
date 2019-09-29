<?php
namespace FRONTAL\FagBesichtigung\Controller;

/***
 *
 * This file is part of the "besichtigung" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 * ZahlungController
 */
class ZahlungController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * datumRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository
     * @inject
     */
    protected $datumRepository = null;

    /**
     * anfrageRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\AnfrageRepository
     * @inject
     */
    protected $anfrageRepository = null;

    /**
     * eventRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {

        $idAnfrage = intval($this->request->getArgument('anfrage'));

        $idEvent = intval($this->request->getArgument('event'));
        $idDatum = intval($this->request->getArgument('datum'));

        $emaildatum = $this->datumRepository->findByUid($idDatum);
        $emailevent = $this->eventRepository->findByUid($idEvent);

        $newAnfrage = $this->anfrageRepository->findHiddenByUid($idAnfrage);

        $newAnfrage->setHidden(false);
        $this->anfrageRepository->update($newAnfrage);
        $anfragepayment = $this->anfrageRepository->findByUid($idAnfrage);

        if($anfragepayment->getHidden() == FALSE){

            $startDate = date("H:i", $emaildatum->getStartTime());
            $endDate = date("H:i", $emaildatum->getEndTime());
            $personen = $anfragepayment->getTeilnehmeraktuell();
            if ($anfragepayment->getGruppenname()) {
                if ($personen > 1) {
                    $Teilnehmende = $anfragepayment->getGruppenname() . ", " . $personen . " Personen";
                } else {
                    $Teilnehmende = $anfragepayment->getGruppenname() . ", " . $personen . " Person";
                }
            } else {
                if ($personen > 1) {
                    $Teilnehmende = $personen . " Personen";
                } else {
                    $Teilnehmende = $personen . " Person";
                }
            }

            $listEmailClinetAndFuhrerin = array($emaildatum->getGruppenFuhrer()->getEmail());
            foreach ($emailevent->getGruppenFuhrer() as $adminemail) {
                $admin = $adminemail->getEmail();
                array_push($listEmailClinetAndFuhrerin, $admin);
            }
            $date = $emaildatum->getDate();
            $m = $date->format('n');
            $d = $date->format('d');
            $y = $date->format('Y');
            $dayOfWeek = date("w", strtotime($date->format('Y-m-d')));
            $monthNames = array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
            $days = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
            $dateFormat = $days[$dayOfWeek] . ", " . $d . ". " . $monthNames[$m - 1] . " " . $y;

            $mail1 = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mail1->setSubject('');
            $mail1->setfrom(array('admin@ewl.ch' => 'frontal'));
            $mail1->setSubject("Bestätigung " . $emailevent->getTitel());
            $mail1->setTo($anfragepayment->getEmail());
            $mail1->setBody('Here is the message itself');
            $mail1->addPart('<p>Guten Tag, ' . $anfragepayment->getAnrede() . ' ' . $anfragepayment->getName() . '</p><p>
            Wir danken Ihnen für das Interesse an ewl und Ihre Anfrage für eine Besichtigung vom '.$emailevent->getTitel().'. Wir freuen uns sehr, Ihnen die Besichtigung wie folgt zu bestätigen:</p>
            <p>Name: ' . $newAnfrage->getVorname() . ' ' . $newAnfrage->getName() . '</p>
            <p>E-Mail: ' . $newAnfrage->getEmail() . '</p>
            <p>Telefon: ' . $newAnfrage->getTelefon() . '</p>
            <p>Datum: ' . $dateFormat . '</p>
            <p>Zeit: ' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>
            <p>Treffpunkt: ' . $emailevent->getTreffpunkt() . '</p>
            <p>Teilnehmende: ' . $Teilnehmende . '</p>
            <p>Führerin: ' .$emaildatum->getGruppenFuhrer()->getVorname() . ' ' . $emaildatum->getGruppenFuhrer()->getNachname() . ', ' . $emaildatum->getGruppenFuhrer()->getTelefon() . '</p>
            <p>Ausrüstung: </p>' . $emailevent->getTextEmail(), 'text/html');
            $mail1->send();


            $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mail->setSubject('');
            $mail->setfrom(array('admin@ewl.ch' => 'frontal'));
            $mail->setSubject("Bestätigung " . $emailevent->getTitel());
            $mail->setTo($listEmailClinetAndFuhrerin);
            $mail->setBody('Here is the message itself');
            $mail->addPart('<p>Guten Tag, ' . $anfragepayment->getAnrede() . ' ' . $anfragepayment->getName() . '</p><p>
            Wir danken Ihnen für das Interesse an ewl und Ihre Anfrage für eine Besichtigung vom '.$emailevent->getTitel().'. Wir freuen uns sehr, Ihnen die Besichtigung wie folgt zu bestätigen:</p>
            <p>Name: ' . $newAnfrage->getVorname() . ' ' . $newAnfrage->getName() . '</p>
            <p>E-Mail: ' . $newAnfrage->getEmail() . '</p>
            <p>Telefon: ' . $newAnfrage->getTelefon() . '</p>
            <p>Datum: ' . $dateFormat . '</p>
            <p>Zeit: ' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>
            <p>Treffpunkt: ' . $emailevent->getTreffpunkt() . '</p>
            <p>Teilnehmende: ' . $Teilnehmende . '</p>
            <p>Führerin: ' .$emaildatum->getGruppenFuhrer()->getVorname() . ' ' . $emaildatum->getGruppenFuhrer()->getNachname() . ', ' . $emaildatum->getGruppenFuhrer()->getTelefon() . '</p>
            <p>Ausrüstung: </p>' . $emailevent->getTextEmail(), 'text/html');
            $mail->send();

            $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . (int)$this->request->getArgument('datum'), array(
                'status' => 'Ausgebucht'
            ));
            $emailsendSpecial = $emailevent->getSendEmail();
            if ($emailsendSpecial == '1') {

                if (count($emaildatum->getAnfrage()) == 0) {
                    $mail2 = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $mail2->setSubject('');
                    $mail2->setfrom(array('admin@ewl.ch' => 'frontal'));
                    $mail2->setSubject("Bestätigung " . $emailevent->getTitel());
                    $mail2->setTo($this->settings['Helfenstein_email']);
                    $mail2->setBody('Here is the message itself');
                    $mail2->addPart('<p>Guten Tag Frau Helfenstein,</p>
                <p>Gerne reservieren wir das Atelier am
                ' . $dateFormat . ' um
                ' . $startDate . ' bis ' . $endDate . ' Uhr definitiv. </p>
                <p>Vielen Dank für die Reservation.</p>', 'text/html');
                    $mail2->send();

                }

            }


        }
        //$this->redirect('list', 'Anfrage');





    }
}
