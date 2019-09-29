<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class AnfrageTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Domain\Model\Anfrage
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getAnredeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAnrede()
        );
    }

    /**
     * @test
     */
    public function setAnredeForStringSetsAnrede()
    {
        $this->subject->setAnrede('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'anrede',
            $this->subject
        );
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
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFunktionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFunktion()
        );
    }

    /**
     * @test
     */
    public function setFunktionForStringSetsFunktion()
    {
        $this->subject->setFunktion('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'funktion',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStrasseReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStrasse()
        );
    }

    /**
     * @test
     */
    public function setStrasseForStringSetsStrasse()
    {
        $this->subject->setStrasse('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'strasse',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getOrtPLZReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getOrtPLZ()
        );
    }

    /**
     * @test
     */
    public function setOrtPLZForStringSetsOrtPLZ()
    {
        $this->subject->setOrtPLZ('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'ortPLZ',
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

    /**
     * @test
     */
    public function getBemerkungReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBemerkung()
        );
    }

    /**
     * @test
     */
    public function setBemerkungForStringSetsBemerkung()
    {
        $this->subject->setBemerkung('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'bemerkung',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getGruppennameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getGruppenname()
        );
    }

    /**
     * @test
     */
    public function setGruppennameForStringSetsGruppenname()
    {
        $this->subject->setGruppenname('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'gruppenname',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDurchschnittsalterReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDurchschnittsalter()
        );
    }

    /**
     * @test
     */
    public function setDurchschnittsalterForStringSetsDurchschnittsalter()
    {
        $this->subject->setDurchschnittsalter('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'durchschnittsalter',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTeilnehmeraktuellReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getTeilnehmeraktuell()
        );
    }

    /**
     * @test
     */
    public function setTeilnehmeraktuellForIntSetsTeilnehmeraktuell()
    {
        $this->subject->setTeilnehmeraktuell(12);

        self::assertAttributeEquals(
            12,
            'teilnehmeraktuell',
            $this->subject
        );
    }
}
