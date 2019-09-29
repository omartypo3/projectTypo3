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
 * AnfrageController
 */
class AnfrageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * anfrageRepository
     *
     * @var \FRONTAL\FagBesichtigung\Domain\Repository\AnfrageRepository
     * @inject
     */
    protected $anfrageRepository = null;
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

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $anfrages = $this->anfrageRepository->findAll();
        $this->view->assign('anfrages', $anfrages);
    }

    /**
     * action show
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage
     * @return void
     */
    public function showAction(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage)
    {
        $this->view->assign('anfrage', $anfrage);
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
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $newAnfrage
     * @return void
     */
    public function createAction(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $newAnfrage)
    {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

        $iddatum = (int)$this->request->getArgument('datum');
        $idevent = (int)$this->request->getArgument('event');
        $gruppentyp = (int)$this->request->getArgument('gruppentyp');
        $emaildatum = $this->datumRepository->findByUid($iddatum);
        $emailevent = $this->eventRepository->findByUid($idevent);

        $emailsendSpecial = $emailevent->getSendEmail();


        $startDate = date("H:i", $emaildatum->getStartTime());
        $endDate = date("H:i", $emaildatum->getEndTime());
        $personen = $newAnfrage->getTeilnehmeraktuell();
        if ($newAnfrage->getGruppenname()) {
            if ($personen > 1) {
                $Teilnehmende = $newAnfrage->getGruppenname() . ", " . $personen . " Personen";
            } else {
                $Teilnehmende = $newAnfrage->getGruppenname() . ", " . $personen . " Person";
            }
        } else {
            if ($personen > 1) {
                $Teilnehmende = $personen . " Personen";
            } else {
                $Teilnehmende = $personen . " Person";
            }
        }

        $datum = $this->datumRepository->findByUid((int)$this->request->getArgument('datum'));
        $newAnfrage->setDatum((int)$this->request->getArgument('datum'));

        $Teilnehmeraktuell = (int)($newAnfrage->getTeilnehmeraktuell());
        $newAnfrage->setTeilnehmeraktuell((int)$Teilnehmeraktuell);

        //
        // COSTS START
        //
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
        $costs = $emaildatum->getGruppentyp()->getKosten();
        if (intval($costs) > 1 && $gruppentyp == 2) {
            require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('fag_besichtigung') . 'lib/php-sdk/autoload.php');

            // Configuration
            $spaceId = 4370;
            $userId = 18275;
            $secret = "NsWwImHGGTFvsacKRw9gamLR1BrnELQ/pbpF1N3XNAQ=";

            // Setup API client
            $client = new \PostFinanceCheckout\Sdk\ApiClient($userId, $secret);

            // Create API service instance
            $transactionService = new \PostFinanceCheckout\Sdk\Service\TransactionService($client);

            // Create transaction
            $lineItem = new \PostFinanceCheckout\Sdk\Model\LineItemCreate();
            $lineItem->setName($emailevent->getTitel());
            $lineItem->setUniqueId('5412');
            $lineItem->setSku($emailevent->getTitel());
            $lineItem->setQuantity(1);
            $lineItem->setAmountIncludingTax($costs);
            $lineItem->setType(\PostFinanceCheckout\Sdk\Model\LineItemType::PRODUCT);

            $transaction = new \PostFinanceCheckout\Sdk\Model\TransactionCreate();
            $transaction->setCurrency("CHF");
            $transaction->setLineItems(array($lineItem));
            $transaction->setAutoConfirmationEnabled(true);

            // persist
            $newAnfrage->setHidden(true);
            $this->anfrageRepository->add($newAnfrage);

            $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface')->persistAll();

            // success url
            $uriBuilder = $this->uriBuilder;
            $successUri = $uriBuilder->reset()
                ->setTargetPageUid(1130)
                ->setCreateAbsoluteUri(true)
                ->uriFor('show', [
                    'anfrage' => $newAnfrage->getUid(),
                    'datum' => $iddatum,
                    'event' => $idevent,
                ], 'Zahlung', 'FagBesichtigung', 'Besichtigung');

            /*$failureUrl = $uriBuilder->reset()
                ->setTargetPageUid(1130)
                ->setCreateAbsoluteUri(true)
                ->uriFor('anfrage', [
                    'uid' => $newAnfrage->getUid(),
                    'event' => $idevent,
                    'success' => '0',
                ], 'Event', 'FagBesichtigung', 'Besichtigung');
            */

            /*test url failureUrl*/
            //if ($this->unsuccessful) {
            $failureUrl = $uriBuilder
                ->setTargetPageUid(1130)
                ->setCreateAbsoluteUri(true)
                ->uriFor('anfrage', ['event' => $idevent, 'unsuccessful' => 'true'], 'Event');
            // header('Location: ' . $failureUrl);
            //}

            $transaction->setSuccessUrl($successUri);
            $transaction->setFailedUrl($failureUrl);

            $createdTransaction = $transactionService->create($spaceId, $transaction);

            // Create Payment Page URL:
            $redirectionUrl = $transactionService->buildPaymentPageUrl($spaceId, $createdTransaction->getId());

            header('Location: ' . $redirectionUrl);

            die();
        }


        // COSTS END

        // $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);





        if ($gruppentyp == 3) {
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . (int)$this->request->getArgument('datum'), array(
                'status' => 'Ausgebucht'
            ));
            $this->anfrageRepository->add($newAnfrage);
            $MailMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $MailMessage->setSubject('');
            $MailMessage->setfrom(array('admin@ewl.ch' => 'frontal'));
            $MailMessage->setSubject("Bestätigung " . $emailevent->getTitel());
            $MailMessage->setTo($newAnfrage->getEmail());
            $MailMessage->setBody('Here is the message itself');
            $MailMessage->addPart('<p>Guten Tag, ' .$newAnfrage->getAnrede().' '. $newAnfrage->getName().'</p>
            <p>
            Wir danken Ihnen für das Interesse an ewl und Ihre Anfrage für eine Besichtigung vom  '.$emailevent->getTitel().' . Wir freuen uns sehr, Ihnen die Besichtigung wie folgt zu bestätigen:</p>
            <p>Name: ' . $newAnfrage->getVorname() . ' ' . $newAnfrage->getName() . '</p>
            <p>E-Mail: ' . $newAnfrage->getEmail() . '</p>
            <p>Telefon: ' . $newAnfrage->getTelefon() . '</p>
            <p>Datum: ' . $dateFormat . '</p>
            <p>Zeit: ' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>
            <p>Treffpunkt: ' . $emailevent->getTreffpunkt() . '</p>
            <p>Teilnehmende: ' . $Teilnehmende . '</p>
            <p>Führerin: ' . $emaildatum->getGruppenFuhrer()->getVorname() . ' ' . $emaildatum->getGruppenFuhrer()->getNachname() . ', ' . $emaildatum->getGruppenFuhrer()->getTelefon() . '</p>
            <p>Ausrüstung: </p>' . $emailevent->getTextEmail(), 'text/html');
            $MailMessage->send();

            $Message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $Message->setSubject('');
            $Message->setfrom(array('admin@ewl.ch' => 'frontal'));
            $Message->setSubject("Bestätigung " . $emailevent->getTitel());
            $Message->setTo($listEmailClinetAndFuhrerin);
            $Message->setBody('Here is the message itself');
            $Message->addPart('<p>Guten Tag, ' . $newAnfrage->getAnrede() . ' ' . $newAnfrage->getName() . '</p><p>
            Wir danken Ihnen für das Interesse an ewl und Ihre Anfrage für eine Besichtigung vom '.$emailevent->getTitel().' . Wir freuen uns sehr, Ihnen die Besichtigung wie folgt zu bestätigen:</p>
            <p>Name: ' . $newAnfrage->getVorname() . ' ' . $newAnfrage->getName() . '</p>
            <p>E-Mail: ' . $newAnfrage->getEmail() . '</p>
            <p>Telefon: ' . $newAnfrage->getTelefon() . '</p>
            <p>Datum: ' . $dateFormat . '</p>
            <p>Zeit: ' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>
            <p>Treffpunkt: ' . $emailevent->getTreffpunkt() . '</p>
            <p>Teilnehmende: ' . $Teilnehmende . '</p>
            <p>Führerin: ' . $emaildatum->getGruppenFuhrer()->getVorname() . ' ' . $emaildatum->getGruppenFuhrer()->getNachname() . ', ' . $emaildatum->getGruppenFuhrer()->getTelefon() . '</p>
            <p>Ausrüstung: </p>' . $emailevent->getTextEmail(), 'text/html');
            $Message->send();
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
        } else if($gruppentyp == 1) {
            $date_aujourdhui = new \DateTime('today');
            $date = date_format($datum->getDate(), "Y-m-d");
            if ($datum->getTeilnehmerMax() == (int)($newAnfrage->getTeilnehmeraktuell())) {
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . (int)$this->request->getArgument('datum'), array(
                    'status' => 'Ausgebucht'
                ));
            } else {
                $somme = 0;
                foreach ($datum->getAnfrage() as $max0) {
                    $somme = intval($somme) + intval($max0->getTeilnehmeraktuell());
                    // DebugUtility::debug($somme);
                }
                $max = $datum->getTeilnehmerMax() - $somme;
                if ($max == (int)($newAnfrage->getTeilnehmeraktuell() || $date_aujourdhui == $date )) {

                    $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_fagbesichtigung_domain_model_datum', 'uid=' . (int)$this->request->getArgument('datum'), array(
                        'status' => 'Ausgebucht'
                    ));
                }
            }
            $this->anfrageRepository->add($newAnfrage);
            $MailMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $MailMessage->setSubject('');
            $MailMessage->setfrom(array('admin@ewl.ch' => 'frontal'));
            $MailMessage->setSubject("Bestätigung " . $emailevent->getTitel());
            $MailMessage->setTo($newAnfrage->getEmail());
            $MailMessage->setBody('Here is the message itself');
            $MailMessage->addPart('<p>Guten Tag, ' . $newAnfrage->getAnrede() . ' ' . $newAnfrage->getName() . '</p>
            <p>
            Wir danken Ihnen für das Interesse an ewl und Ihre Anfrage für eine Besichtigung vom '.$emailevent->getTitel().'. Wir freuen uns sehr, Ihnen die Besichtigung wie folgt zu bestätigen:</p>
            <p>Name: ' . $newAnfrage->getVorname() . ' ' . $newAnfrage->getName() . '</p>
            <p>E-Mail: ' . $newAnfrage->getEmail() . '</p>
            <p>Telefon: ' . $newAnfrage->getTelefon() . '</p>
            <p>Datum: ' . $dateFormat . '</p>
            <p>Zeit: ' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>
            <p>Treffpunkt: ' . $emailevent->getTreffpunkt() . '</p>
            <p>Teilnehmende: ' . $Teilnehmende . '</p>
            <p>Führerin: ' . $emaildatum->getGruppenFuhrer()->getVorname() . ' ' . $emaildatum->getGruppenFuhrer()->getNachname() . ', ' . $emaildatum->getGruppenFuhrer()->getTelefon() . '</p>
            <p>Ausrüstung: </p>' . $emailevent->getTextEmail(), 'text/html');
            $MailMessage->send();

            $Message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $Message->setSubject('');
            $Message->setfrom(array('admin@ewl.ch' => 'frontal'));
            $Message->setSubject("Bestätigung " . $emailevent->getTitel());
            $Message->setTo($listEmailClinetAndFuhrerin);
            $Message->setBody('Here is the message itself');
            $Message->addPart('<p>Guten Tag, ' . $newAnfrage->getAnrede() . ' ' . $newAnfrage->getName() . '</p><p>
            Wir danken Ihnen für das Interesse an ewl und Ihre Anfrage für eine Besichtigung vom '.$emailevent->getTitel().'. Wir freuen uns sehr, Ihnen die Besichtigung wie folgt zu bestätigen:</p>
            <p>Name: ' . $newAnfrage->getVorname() . ' ' . $newAnfrage->getName() . '</p>
            <p>E-Mail: ' . $newAnfrage->getEmail() . '</p>
            <p>Telefon: ' . $newAnfrage->getTelefon() . '</p>
            <p>Datum: ' . $dateFormat . '</p>
            <p>Zeit: ' . $startDate . ' bis zirka ' . $endDate . ' Uhr</p>
            <p>Treffpunkt: ' . $emailevent->getTreffpunkt() . '</p>
            <p>Teilnehmende: ' . $Teilnehmende . '</p>
            <p>Führerin: ' . $emaildatum->getGruppenFuhrer()->getVorname() . ' ' . $emaildatum->getGruppenFuhrer()->getNachname() . ', ' . $emaildatum->getGruppenFuhrer()->getTelefon() . '</p>
            <p>Ausrüstung: </p>' . $emailevent->getTextEmail(), 'text/html');
            $Message->send();
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

        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage
     * @ignorevalidation $anfrage
     * @return void
     */
    public function editAction(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage)
    {
        $this->view->assign('anfrage', $anfrage);
    }

    /**
     * action update
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage
     * @return void
     */
    public function updateAction(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->anfrageRepository->update($anfrage);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage
     * @return void
     */
    public function deleteAction(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->anfrageRepository->remove($anfrage);
        $this->redirect('list');
    }
}
