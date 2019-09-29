<?php
namespace FRONTAL\FagBesichtigung\Domain\Model;

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

/**
 * Zahlung
 */
class Zahlung extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * amount
     * 
     * @var string
     */
    protected $amount = '';

    /**
     * brand
     * 
     * @var string
     */
    protected $brand = '';

    /**
     * cardNumber
     * 
     * @var string
     */
    protected $cardNumber = '';

    /**
     * customerName
     * 
     * @var string
     */
    protected $customerName = '';

    /**
     * currency
     * 
     * @var string
     */
    protected $currency = '';

    /**
     * expiryDate
     * 
     * @var \DateTime
     */
    protected $expiryDate = null;

    /**
     * errorCode
     * 
     * @var string
     */
    protected $errorCode = '';

    /**
     * orderId
     * 
     * @var int
     */
    protected $orderId = 0;

    /**
     * payId
     * 
     * @var int
     */
    protected $payId = 0;

    /**
     * shasign
     * 
     * @var string
     */
    protected $shasign = '';

    /**
     * status
     * 
     * @var string
     */
    protected $status = '';

    /**
     * transactionDate
     * 
     * @var \DateTime
     */
    protected $transactionDate = null;

    /**
     * anfrageid
     * 
     * @var \FRONTAL\FagBesichtigung\Domain\Model\Anfrage
     */
    protected $anfrageid = null;

    /**
     * Returns the amount
     * 
     * @return string $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the amount
     * 
     * @param string $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Returns the brand
     * 
     * @return string $brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Sets the brand
     * 
     * @param string $brand
     * @return void
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Returns the cardNumber
     * 
     * @return string $cardNumber
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Sets the cardNumber
     * 
     * @param string $cardNumber
     * @return void
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * Returns the customerName
     * 
     * @return string $customerName
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Sets the customerName
     * 
     * @param string $customerName
     * @return void
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    }

    /**
     * Returns the currency
     * 
     * @return string $currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets the currency
     * 
     * @param string $currency
     * @return void
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Returns the expiryDate
     * 
     * @return \DateTime $expiryDate
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Sets the expiryDate
     * 
     * @param \DateTime $expiryDate
     * @return void
     */
    public function setExpiryDate(\DateTime $expiryDate)
    {
        $this->expiryDate = $expiryDate;
    }

    /**
     * Returns the errorCode
     * 
     * @return string $errorCode
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Sets the errorCode
     * 
     * @param string $errorCode
     * @return void
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * Returns the orderId
     * 
     * @return int $orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Sets the orderId
     * 
     * @param int $orderId
     * @return void
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Returns the payId
     * 
     * @return int $payId
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * Sets the payId
     * 
     * @param int $payId
     * @return void
     */
    public function setPayId($payId)
    {
        $this->payId = $payId;
    }

    /**
     * Returns the shasign
     * 
     * @return string $shasign
     */
    public function getShasign()
    {
        return $this->shasign;
    }

    /**
     * Sets the shasign
     * 
     * @param string $shasign
     * @return void
     */
    public function setShasign($shasign)
    {
        $this->shasign = $shasign;
    }

    /**
     * Returns the status
     * 
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     * 
     * @param string $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Returns the transactionDate
     * 
     * @return \DateTime $transactionDate
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * Sets the transactionDate
     * 
     * @param \DateTime $transactionDate
     * @return void
     */
    public function setTransactionDate(\DateTime $transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }

    /**
     * Returns the anfrageid
     * 
     * @return \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrageid
     */
    public function getAnfrageid()
    {
        return $this->anfrageid;
    }

    /**
     * Sets the anfrageid
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrageid
     * @return void
     */
    public function setAnfrageid(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrageid)
    {
        $this->anfrageid = $anfrageid;
    }
}
