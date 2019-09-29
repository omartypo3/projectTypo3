<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class GruppentypTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitel()
        );
    }

    /**
     * @test
     */
    public function setTitelForStringSetsTitel()
    {
        $this->subject->setTitel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'titel',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUntertitelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUntertitel()
        );
    }

    /**
     * @test
     */
    public function setUntertitelForStringSetsUntertitel()
    {
        $this->subject->setUntertitel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'untertitel',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTextReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getText()
        );
    }

    /**
     * @test
     */
    public function setTextForStringSetsText()
    {
        $this->subject->setText('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'text',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBildReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getBild()
        );
    }

    /**
     * @test
     */
    public function setBildForFileReferenceSetsBild()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setBild($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'bild',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getKostenReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getKosten()
        );
    }

    /**
     * @test
     */
    public function setKostenForStringSetsKosten()
    {
        $this->subject->setKosten('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'kosten',
            $this->subject
        );
    }
}
