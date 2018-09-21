<?php
namespace DLD\Dld\Xing;

use DLD\Dld\Domain\Model\People;
use DLD\Dld\Domain\Model\Event;

class Payment
{
    var $user;
    var $event;
    var $apiEndpoint;
    var $apiKey;
    var $errors = [];

    var $ticketCategoryId;
    var $paymentId;
    var $highrisePersonId;
    var $createPaymentSuccess;
    var $getFirstTicketIdSuccess;
    var $applyPromoCodeSuccess;
    var $setTicketCountSuccess;
    var $setTicketDataSuccess;
    var $setUserDataSuccess;
    var $setBuyerAddressSuccess;
    var $initializePaymentSuccess;
    var $startIdentifier;
    var $queueIdentifier;
    var $firstTicketId;
    var $redirectUrl;

    function __construct(People $user, Event $event, $apiEndpoint, $apiKey, $ticketCategoryId)
    {
        $this->user = $user;
        $this->event = $event;
        $this->apiEndpoint = $apiEndpoint;
        $this->apiKey = $apiKey;
        $this->ticketCategoryId = $ticketCategoryId;

        $this->createPayment();
    }

    private function createPayment()
    {
        $url = $this->apiEndpoint . "/event/" . $this->event->getXingEventId() . '/payment/create?apikey=' . $this->apiKey . "&applicationData=" . $this->user->getHighrisePersonId() . "&version=1";
        $postFields = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        $jsonResponse = json_decode($response, true);
        curl_close($ch);

        $this->createPaymentSuccess = $jsonResponse["success"];
        if (isset($jsonResponse["errors"])) {
            $this->errors["createPayment"] = $jsonResponse["errors"];
        } else {
            $this->paymentId = $jsonResponse["id"];
        }
    }

    public function applyPromoCode()
    {
        $url = $this->apiEndpoint . "/payment/" . $this->paymentId . '/applyDiscountCode?discountCode=hide&apikey=' . $this->apiKey . "&version=1";
        $postFields = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        $jsonResponse = json_decode($response, true);
        curl_close($ch);

        $this->applyPromoCodeSuccess = $jsonResponse["success"];
        if (isset($jsonResponse["errors"])) {
            $this->errors["applyPromoCode"] = $jsonResponse["errors"];
        }
    }

    public function setTicketCount()
    {
        $url = $this->apiEndpoint . "/payment/" . $this->paymentId . '/setTicketCount?apikey=' . $this->apiKey . "&version=1&" . $this->ticketCategoryId . "=1";
        $postFields = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        $jsonResponse = json_decode($response, true);
        curl_close($ch);

        $this->setTicketCountSuccess = $jsonResponse["success"];
        if (isset($jsonResponse["errors"])) {
            $this->errors["setTicketCount"] = $jsonResponse["errors"];
        }
    }

    public function setTicketData()
    {
        $ticketType = "ETicket";
        $email = $this->user->getEmailPrivate();
        $firstName = $this->user->getFirstName();
        $lastName = $this->user->getLastName();
        if (is_null($this->firstTicketId)) {
            $this->firstTicketId = $this->getFirstTicketID();
        }

        $url = $this->apiEndpoint . "/ticket/" . $this->firstTicketId . '/tickets?apikey=' . $this->apiKey . "&version=1&ticket_type=" . $ticketType . "&email=" . $email . "&firstName=" . $firstName . "&lastName=" . $lastName;
        $postFields = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        $jsonResponse = json_decode($response, true);
        curl_close($ch);

        $this->setTicketDataSuccess = $jsonResponse["success"];
        if (isset($jsonResponse["errors"])) {
            $this->errors["setTicketData"] = $jsonResponse["errors"];
        }
    }

    private function getFirstTicketId ()
    {
        $url = $this->apiEndpoint . "/payment/" . $this->paymentId . '/tickets?apikey=' . $this->apiKey . "&version=1";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $jsonResponse = json_decode($response, true);
        curl_close($ch);

        $this->getFirstTicketIdSuccess = $jsonResponse["success"];
        if (isset($jsonResponse["errors"])) {
            $this->errors["getFirstTicketId"] = $jsonResponse["errors"];
            throw new \Exception("Ticket can't be bought");
        } else {
            return $jsonResponse["tickets"][0];
        }
    }

    public function setUserData()
    {
        $xingEventCompanyId = $this->event->getXingEventCompanyId();
        if ($xingEventCompanyId) {
            $company = $this->user->getCompany();

            if (is_null($this->firstTicketId)) {
                $this->firstTicketId = $this->getFirstTicketID();
            }
            $url = $this->apiEndpoint . "/ticket/" . $this->firstTicketId . '/userData?apikey=' . $this->apiKey . "&version=1&" . $xingEventCompanyId . "=" . $company;
            $postFields = [];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            $response = curl_exec($ch);
            $jsonResponse = json_decode($response, true);
            curl_close($ch);

            $this->setUserDataSuccess = $jsonResponse["success"];
            if (isset($jsonResponse["errors"])) {
                $this->errors["setUserData"] = $jsonResponse["errors"];
            }
        }
    }

    public function setBuyerAddress()
    {
        $email = $this->user->getEmailPrivate();
        $firstName = $this->user->getFirstName();
        $lastName = $this->user->getLastName();
        $street = $this->user->getAddress();
        $city = $this->user->getCity();
        $state = $this->user->getState();
        $country = $this->user->getCountryCode();
        $zipCode = $this->user->getZip();
        $company = $this->user->getCompany();

        $url = $this->apiEndpoint . "/payment/" . $this->paymentId . '/address/buyer?apikey=' . $this->apiKey . "&version=1&" . "&email=" . $email . "&firstName=" . $firstName . "&lastName=" . $lastName . "&street=" . $street . "&city=" . $city . "&state=" . $state . "&country=" . $country . "&zipCode=" . $zipCode . "&company=" . $company;
        $postFields = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        $jsonResponse = json_decode($response, true);
        curl_close($ch);

        $this->setBuyerAddressSuccess = $jsonResponse["success"];
        if (isset($jsonResponse["errors"])) {
            $this->errors["setBuyerAddress"] = $jsonResponse["errors"];
        }
    }

    public function initializePayment()
    {
        $url = $this->apiEndpoint . "/payment/" . $this->paymentId . '/start?apikey=' . $this->apiKey . "&version=1";
        $postFields = [];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        $jsonResponse = json_decode($response, true);
        curl_close($ch);

        $this->initializePaymentSuccess = $jsonResponse["success"];
        if (isset($jsonResponse["errors"])) {
            $this->errors["initializePayment"] = $jsonResponse["errors"];
            throw new \Exception("Ticket can't be bought");
        }

        $this->redirectUrl = $jsonResponse["startUrl"];
        $this->startIdentifier = $jsonResponse["startIdentifier"];
        $this->queueIdentifier = $jsonResponse["queueIdentifier"];
        $this->cleanupRedirectUrl();
    }

    private function cleanupRedirectUrl()
    {
        $this->redirectUrl = preg_replace('/(^|&)viewType=[^&]*/', '', $this->redirectUrl);
        $this->redirectUrl = preg_replace('/(^|&)step=[^&]*/', '', $this->redirectUrl);
        $this->redirectUrl = preg_replace('/(^|&)secure=[^&]*/', '', $this->redirectUrl);
        $this->redirectUrl = $this->redirectUrl . "&step=paymentData";
        $this->redirectUrl = $this->redirectUrl . "&secure=true";
    }
}