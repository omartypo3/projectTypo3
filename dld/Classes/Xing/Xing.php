<?php
namespace DLD\Dld\Xing;

use DLD\Dld\Domain\Model\People;
use DLD\Dld\Domain\Model\Event;

class Xing
{
    var $apiKey;
    var $apiEndpoint = 'https://www.xing-events.com/api';

    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    function createTicketPayment(People $user, Event $event, $ticketCategoryId)
    {
        $payment = $this->createPayment($event, $user, $ticketCategoryId);
        $this->applyPromoCode($payment);
        $this->setTicketCount($payment);
        $this->setTicketData($payment);
        $this->setUserData($payment);
        $this->setBuyerAddress($payment);
        $this->initializePayment($payment);

        return $payment;
    }

    private function createPayment(Event $event, People $user, $ticketCategoryId)
    {
        $payment = new Payment($user, $event, $this->apiEndpoint, $this->apiKey, $ticketCategoryId);
        if (!$payment->createPaymentSuccess) {
            throw new \Exception("Ticket can't be bought");
        }
        return $payment;
    }

    private function applyPromoCode(Payment $payment)
    {
        $payment->applyPromoCode();
        if (!$payment->applyPromoCodeSuccess) {
            // Do nothing for now.
        }
    }

    private function setTicketCount(Payment $payment)
    {
        $payment->setTicketCount();
        if (!$payment->setTicketCountSuccess) {
            throw new \Exception("Ticket can't be bought");
        }
    }

    private function setTicketData(Payment $payment)
    {
        $payment->setTicketData();
        if (!$payment->setTicketDataSuccess) {
            throw new \Exception("Ticket can't be bought");
        }
    }

    private function setUserData(Payment $payment)
    {
        $payment->setUserData();
        if (!$payment->setUserDataSuccess) {
            // Do nothing for now.
        }
    }

    private function setBuyerAddress(Payment $payment)
    {
        $payment->setBuyerAddress();
        if (!$payment->setBuyerAddressSuccess) {
            // Do nothing for now.
        }
    }

    private function initializePayment(Payment $payment)
    {
        $payment->initializePayment();
        if (!$payment->initializePaymentSuccess) {
            throw new \Exception("Ticket can't be bought");
        }
    }
}