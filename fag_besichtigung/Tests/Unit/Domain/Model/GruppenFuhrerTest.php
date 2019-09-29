<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class GruppenFuhrerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getVornameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getVorname()
        );
    }

    /**
     * @test
     */
    public function setVornameForStringSetsVorname()
    {
        $this->subject->setVorname('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'vorname',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getNachnameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNachname()
        );
    }

    /**
     * @test
     */
    public function setNachnameForStringSetsNachname()
    {
        $this->subject->setNachname('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'nachname',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'email',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTelefonReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTelefon()
        );
    }

    /**
     * @test
     */
    public function setTelefonForStringSetsTelefon()
    {
        $this->subject->setTelefon('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'telefon',
            $this->subject
        );
    }
}
