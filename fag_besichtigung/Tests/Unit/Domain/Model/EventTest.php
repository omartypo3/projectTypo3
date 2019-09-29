<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class EventTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Domain\Model\Event
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagBesichtigung\Domain\Model\Event();
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
    public function getZusatztextReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getZusatztext()
        );
    }

    /**
     * @test
     */
    public function setZusatztextForStringSetsZusatztext()
    {
        $this->subject->setZusatztext('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'zusatztext',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPreishinweisReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPreishinweis()
        );
    }

    /**
     * @test
     */
    public function setPreishinweisForStringSetsPreishinweis()
    {
        $this->subject->setPreishinweis('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'preishinweis',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDatumReturnsInitialValueForDatum()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getDatum()
        );
    }

    /**
     * @test
     */
    public function setDatumForObjectStorageContainingDatumSetsDatum()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();
        $objectStorageHoldingExactlyOneDatum = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneDatum->attach($datum);
        $this->subject->setDatum($objectStorageHoldingExactlyOneDatum);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneDatum,
            'datum',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addDatumToObjectStorageHoldingDatum()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();
        $datumObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $datumObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($datum));
        $this->inject($this->subject, 'datum', $datumObjectStorageMock);

        $this->subject->addDatum($datum);
    }

    /**
     * @test
     */
    public function removeDatumFromObjectStorageHoldingDatum()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();
        $datumObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $datumObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($datum));
        $this->inject($this->subject, 'datum', $datumObjectStorageMock);

        $this->subject->removeDatum($datum);
    }

    /**
     * @test
     */
    public function getGruppenFuhrerReturnsInitialValueForGruppenFuhrer()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getGruppenFuhrer()
        );
    }

    /**
     * @test
     */
    public function setGruppenFuhrerForObjectStorageContainingGruppenFuhrerSetsGruppenFuhrer()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();
        $objectStorageHoldingExactlyOneGruppenFuhrer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneGruppenFuhrer->attach($gruppenFuhrer);
        $this->subject->setGruppenFuhrer($objectStorageHoldingExactlyOneGruppenFuhrer);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneGruppenFuhrer,
            'gruppenFuhrer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addGruppenFuhrerToObjectStorageHoldingGruppenFuhrer()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();
        $gruppenFuhrerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppenFuhrerObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($gruppenFuhrer));
        $this->inject($this->subject, 'gruppenFuhrer', $gruppenFuhrerObjectStorageMock);

        $this->subject->addGruppenFuhrer($gruppenFuhrer);
    }

    /**
     * @test
     */
    public function removeGruppenFuhrerFromObjectStorageHoldingGruppenFuhrer()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();
        $gruppenFuhrerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppenFuhrerObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($gruppenFuhrer));
        $this->inject($this->subject, 'gruppenFuhrer', $gruppenFuhrerObjectStorageMock);

        $this->subject->removeGruppenFuhrer($gruppenFuhrer);
    }
}
