<?php

namespace Pingag\PingagAddress\Task;

use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use DateTime;

/**
 * Created by Visual Studio.
 * User: Markus Rutz
 * Date: 17.04.2024
 * Time: 09:33
 */
class SendMailOnOldDigitalMapAngebote extends AbstractTask
{
    public function execute()
    {
        /*$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');
        $result = $queryBuilder
            ->select('*')
            ->from('tt_address')
            ->where(
                $queryBuilder->expr()->eq('pid', '1048'),
                $queryBuilder->expr()->eq('deleted', '0'),
            )
            ->execute();

        while ($row = $result->fetchAssociative()) {      

            $queryBuilder2 = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
            $result2 = $queryBuilder2
            ->select('*')
            ->from('fe_users')
            ->where(
                $queryBuilder2->expr()->eq('addressid', $row["uid"])
            )
            ->execute();

            while ($row2 = $result2->fetchAssociative()) {   
                \TYPO3\CMS\Core\Utility\DebugUtility::debug( $row["uid"] . ' ' . $row["tstamp"] . ' ' . $row2["email"] );
            }

        }*/

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');
        $result = $queryBuilder
        ->select('tt_address.uid', 'tt_address.tstamp', 'u.email')
        ->from('tt_address')
        ->join(
            'tt_address',
            'fe_users',
            'u',
            $queryBuilder->expr()->eq('u.addressid', $queryBuilder->quoteIdentifier('tt_address.uid'))
        )
        ->where(
            $queryBuilder->expr()->eq('tt_address.pid', '1048')
        )
        ->executeQuery();

        while ($row = $result->fetchAssociative()) {        
            if( $row["email"] && $row["tstamp"] ) {

                $now = new DateTime();
                $angebotLastModified = DateTime::createFromFormat('U', $row["tstamp"]);
                if ( $angebotLastModified->modify('+1 year') < $now) {
                
                    //\TYPO3\CMS\Core\Utility\DebugUtility::debug( $row["uid"] . ' ' . $row["tstamp"] . ' ' . $row["email"] );
                    $this->sendMail( $row['email'] );

                }
            }
        }

        return true;
    }

    public function sendMail($receiver_email)
    {
        $mailSubject = "Inhaltsprüfung/Aktualisierung Ihres DigitalMap Angebotes";

        $mailText = "Guten Tag\n\nIhr DigitalMap Angebot auf der Seite www.angebote-schlechtsehen.ch wurde seit einem Jahr nicht aktualisiert. " .
        "Bitte loggen Sie sich ein und prüfen Sie, ob die Angaben Ihres Angebotes noch stimmen. " .
        "Speichern Sie Ihr Angebot auf jeden Fall neu ab. Damit wird dem System mitgeteilt, dass " .
        "das Angebot wieder aktuell ist. Aktualisieren Sie bitte das Angebot falls notwendig. " . 
        "Danach werden Sie dazu auch ein Jahr keine E-Mails wie dieses mehr erhalten. " . 
        "Besten Dank.\n\nFreundliche Grüsse\nSZBLIND und Retina.ch" . 
        "\n\n---\n\n" .
        "Bonjour\n\nVotre offre DigitalMap sur le site www.offres-malvoir.ch n'a pas été mise à jour depuis un an. " .
        "Veuillez vous connecter et vérifier si les informations de votre offre sont toujours correctes. " .
        "Dans tous les cas, enregistrez à nouveau votre offre. Cela permettra d'indiquer au système que  " .
        "l'offre est à nouveau d'actualité. Veuillez mettre à jour l'offre si nécessaire. " . 
        "Vous ne recevrez alors plus d'e-mails de ce type pendant un an.  " . 
        "Merci beaucoup.\n\nCordialement\nUCBA et Retina.ch" . 
        "\n\n---\n\n" .
        "Buongiorno\n\nLa sua offerta DigitalMap sulla pagina www.offerte-vederemale.ch non viene aggiornata da un anno. " .
        "Effettui il login e verifichi se i dati della sua offerta sono ancora corretti. " .
        "In ogni caso, salvi nuovamente la sua offerta. In questo modo il sistema verrà informato che " .
        "l'offerta è nuovamente aggiornata. Se necessario, aggiorni l'offerta. " . 
        "In seguito non riceverà più e-mail come questa per un anno. " . 
        "Grazie mille.\n\nCordiali saluti\nUCBC e Retina.ch";


        // Create the message
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);

        // Prepare and send the message
        $mail

        // Defining the "From" email address and name as an object
        // (email clients will display the name)
        ->from(new \Symfony\Component\Mime\Address('website@szblind.ch', 'Customer Self Care'))

        // Set the "To" addresses
        ->to(
            new \Symfony\Component\Mime\Address($receiver_email, $receiver_email),
            // new \Symfony\Component\Mime\Address('other@example.net')
        )

        // Give the message a subject
        ->subject($mailSubject)

        // Give it the text message
        ->text($mailText)

        // And optionally a HTML message
        // ->html('<p>Here is the message itself</p>')

        // Optionally add any attachments
        //->attachFromPath('/path/to/my-document.pdf')

        // And finally send it
        ->send();
    }
}

