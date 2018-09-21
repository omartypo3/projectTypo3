<?php
namespace J77\J77products\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class MaschineTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Domain\Model\Maschine
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \J77\J77products\Domain\Model\Maschine();
    }

    protected function tearDown()
    {
        parent::tearDown();
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
    public function getTeaserbildReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getTeaserbild()
        );
    }

    /**
     * @test
     */
    public function setTeaserbildForFileReferenceSetsTeaserbild()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setTeaserbild($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'teaserbild',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTeasertextReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTeasertext()
        );
    }

    /**
     * @test
     */
    public function setTeasertextForStringSetsTeasertext()
    {
        $this->subject->setTeasertext('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'teasertext',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getVorschaugrafikReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getVorschaugrafik()
        );
    }

    /**
     * @test
     */
    public function setVorschaugrafikForFileReferenceSetsVorschaugrafik()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setVorschaugrafik($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'vorschaugrafik',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getElementeReturnsInitialValueForMaschinenelemente()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getElemente()
        );
    }

    /**
     * @test
     */
    public function setElementeForObjectStorageContainingMaschinenelementeSetsElemente()
    {
        $elemente = new \J77\J77products\Domain\Model\Maschinenelemente();
        $objectStorageHoldingExactlyOneElemente = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneElemente->attach($elemente);
        $this->subject->setElemente($objectStorageHoldingExactlyOneElemente);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneElemente,
            'elemente',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addElementeToObjectStorageHoldingElemente()
    {
        $elemente = new \J77\J77products\Domain\Model\Maschinenelemente();
        $elementeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $elementeObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($elemente));
        $this->inject($this->subject, 'elemente', $elementeObjectStorageMock);

        $this->subject->addElemente($elemente);
    }

    /**
     * @test
     */
    public function removeElementeFromObjectStorageHoldingElemente()
    {
        $elemente = new \J77\J77products\Domain\Model\Maschinenelemente();
        $elementeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $elementeObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($elemente));
        $this->inject($this->subject, 'elemente', $elementeObjectStorageMock);

        $this->subject->removeElemente($elemente);
    }
}
