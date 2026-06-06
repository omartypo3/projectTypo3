<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class AgenturvertraegeTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Agenturvertraege|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Agenturvertraege::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getStundenMonatlichReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getStundenMonatlich()
        );
    }

    /**
     * @test
     */
    public function setStundenMonatlichForFloatSetsStundenMonatlich(): void
    {
        $this->subject->setStundenMonatlich(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('stundenMonatlich'));
    }

    /**
     * @test
     */
    public function getPreisMonatlichReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getPreisMonatlich()
        );
    }

    /**
     * @test
     */
    public function setPreisMonatlichForFloatSetsPreisMonatlich(): void
    {
        $this->subject->setPreisMonatlich(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('preisMonatlich'));
    }

    /**
     * @test
     */
    public function getBeschreibungReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBeschreibung()
        );
    }

    /**
     * @test
     */
    public function setBeschreibungForStringSetsBeschreibung(): void
    {
        $this->subject->setBeschreibung('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('beschreibung'));
    }

    /**
     * @test
     */
    public function getVertragsbeginReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getVertragsbegin()
        );
    }

    /**
     * @test
     */
    public function setVertragsbeginForDateTimeSetsVertragsbegin(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setVertragsbegin($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('vertragsbegin'));
    }

    /**
     * @test
     */
    public function getVertragsendeReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getVertragsende()
        );
    }

    /**
     * @test
     */
    public function setVertragsendeForDateTimeSetsVertragsende(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setVertragsende($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('vertragsende'));
    }

    /**
     * @test
     */
    public function getVertragReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getVertrag()
        );
    }

    /**
     * @test
     */
    public function setVertragForFileReferenceSetsVertrag(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setVertrag($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('vertrag'));
    }

    /**
     * @test
     */
    public function getPreisMehraufwandStundeReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getPreisMehraufwandStunde()
        );
    }

    /**
     * @test
     */
    public function setPreisMehraufwandStundeForFloatSetsPreisMehraufwandStunde(): void
    {
        $this->subject->setPreisMehraufwandStunde(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('preisMehraufwandStunde'));
    }

    /**
     * @test
     */
    public function getKundeReturnsInitialValueForKunden(): void
    {
        self::assertEquals(
            null,
            $this->subject->getKunde()
        );
    }

    /**
     * @test
     */
    public function setKundeForKundenSetsKunde(): void
    {
        $kundeFixture = new \DslFactory\DslIntranet\Domain\Model\Kunden();
        $this->subject->setKunde($kundeFixture);

        self::assertEquals($kundeFixture, $this->subject->_get('kunde'));
    }

    /**
     * @test
     */
    public function getDateienReturnsInitialValueForDateien(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getDateien()
        );
    }

    /**
     * @test
     */
    public function setDateienForObjectStorageContainingDateienSetsDateien(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $objectStorageHoldingExactlyOneDateien = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneDateien->attach($dateien);
        $this->subject->setDateien($objectStorageHoldingExactlyOneDateien);

        self::assertEquals($objectStorageHoldingExactlyOneDateien, $this->subject->_get('dateien'));
    }

    /**
     * @test
     */
    public function addDateienToObjectStorageHoldingDateien(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $dateienObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $dateienObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($dateien));
        $this->subject->_set('dateien', $dateienObjectStorageMock);

        $this->subject->addDateien($dateien);
    }

    /**
     * @test
     */
    public function removeDateienFromObjectStorageHoldingDateien(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $dateienObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $dateienObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($dateien));
        $this->subject->_set('dateien', $dateienObjectStorageMock);

        $this->subject->removeDateien($dateien);
    }
}
