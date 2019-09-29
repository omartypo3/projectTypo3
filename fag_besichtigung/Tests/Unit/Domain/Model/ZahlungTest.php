<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class ZahlungTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Domain\Model\Zahlung
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagBesichtigung\Domain\Model\Zahlung();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getAmountReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAmount()
        );
    }

    /**
     * @test
     */
    public function setAmountForStringSetsAmount()
    {
        $this->subject->setAmount('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'amount',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBrandReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBrand()
        );
    }

    /**
     * @test
     */
    public function setBrandForStringSetsBrand()
    {
        $this->subject->setBrand('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'brand',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCardNumberReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCardNumber()
        );
    }

    /**
     * @test
     */
    public function setCardNumberForStringSetsCardNumber()
    {
        $this->subject->setCardNumber('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'cardNumber',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCustomerNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCustomerName()
        );
    }

    /**
     * @test
     */
    public function setCustomerNameForStringSetsCustomerName()
    {
        $this->subject->setCustomerName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'customerName',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCurrencyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCurrency()
        );
    }

    /**
     * @test
     */
    public function setCurrencyForStringSetsCurrency()
    {
        $this->subject->setCurrency('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'currency',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getExpiryDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getExpiryDate()
        );
    }

    /**
     * @test
     */
    public function setExpiryDateForDateTimeSetsExpiryDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setExpiryDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'expiryDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getErrorCodeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getErrorCode()
        );
    }

    /**
     * @test
     */
    public function setErrorCodeForStringSetsErrorCode()
    {
        $this->subject->setErrorCode('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'errorCode',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getOrderIdReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getOrderId()
        );
    }

    /**
     * @test
     */
    public function setOrderIdForIntSetsOrderId()
    {
        $this->subject->setOrderId(12);

        self::assertAttributeEquals(
            12,
            'orderId',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPayIdReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getPayId()
        );
    }

    /**
     * @test
     */
    public function setPayIdForIntSetsPayId()
    {
        $this->subject->setPayId(12);

        self::assertAttributeEquals(
            12,
            'payId',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getShasignReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getShasign()
        );
    }

    /**
     * @test
     */
    public function setShasignForStringSetsShasign()
    {
        $this->subject->setShasign('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'shasign',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStatusReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStatus()
        );
    }

    /**
     * @test
     */
    public function setStatusForStringSetsStatus()
    {
        $this->subject->setStatus('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'status',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTransactionDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getTransactionDate()
        );
    }

    /**
     * @test
     */
    public function setTransactionDateForDateTimeSetsTransactionDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setTransactionDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'transactionDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAnfrageidReturnsInitialValueForAnfrage()
    {
        self::assertEquals(
            null,
            $this->subject->getAnfrageid()
        );
    }

    /**
     * @test
     */
    public function setAnfrageidForAnfrageSetsAnfrageid()
    {
        $anfrageidFixture = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();
        $this->subject->setAnfrageid($anfrageidFixture);

        self::assertAttributeEquals(
            $anfrageidFixture,
            'anfrageid',
            $this->subject
        );
    }
}
