<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 12/07/2018
 * Time: 13:55
 */

namespace DLD\Dld\ViewHelpers;


use TYPO3\CMS\Core\Utility\DebugUtility;

class UserEventTagViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param string $tags
     * @return string
     */
    public function render($tags) {

        foreach ($tags as $tagArray) {

            $prefixEvent = stristr($tagArray->getHighrisetag(),"_invited");
            if ($prefixEvent!= FALSE) {
                $note = "invited";
            }

           $prefixEvent = stristr($tagArray->getHighrisetag(),"_rejected");
            if ($prefixEvent!= FALSE) {
                $note = "rejected";
            }

             $prefixEvent = stristr($tagArray->getHighrisetag(),"_accepted");
            if ($prefixEvent!= FALSE) {
                $note = "accepted";
            }

            $prefixEvent = stristr($tagArray->getHighrisetag(),"_remind");
            if ($prefixEvent!= FALSE) {
                $note = "remind";
            }

            $prefixEvent = stristr($tagArray->getHighrisetag(),"_payement_started");
            if ($prefixEvent!= FALSE) {
                $note = "Payement started";
            }

            $prefixEvent = stristr($tagArray->getHighrisetag()," _ticketissued_started");
            if ($prefixEvent!= FALSE) {
                $note = " Ticketissued Started";
            }

            $prefixEvent = stristr($tagArray->getHighrisetag(),"_ticket_issued");
            if ($prefixEvent!= FALSE) {
                $note = "Ticket issued";
            }

             $prefixEvent = stristr($tagArray->getHighrisetag(),"_entred");
            if ($prefixEvent!= FALSE) {
                $note = "Entred";
            }

             $prefixEvent = stristr($tagArray->getHighrisetag(),"_someone_else_entred");
            if ($prefixEvent!= FALSE) {
                $note = "Someone else entred";
            }

              $prefixEvent = stristr($tagArray->getHighrisetag(),"_confirmed");
            if ($prefixEvent!= FALSE) {
                $note = "confirmed";
            }
        }


        return $note;
    }
}