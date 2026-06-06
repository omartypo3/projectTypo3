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
class BenutzerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Benutzer|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Benutzer::class,
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
    public function getSettingsReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettings()
        );
    }

    /**
     * @test
     */
    public function setSettingsForStringSetsSettings(): void
    {
        $this->subject->setSettings('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settings'));
    }

    /**
     * @test
     */
    public function getSettingsHostingReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsHosting()
        );
    }

    /**
     * @test
     */
    public function setSettingsHostingForStringSetsSettingsHosting(): void
    {
        $this->subject->setSettingsHosting('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsHosting'));
    }

    /**
     * @test
     */
    public function getGeoeffneterAuftragReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getGeoeffneterAuftrag()
        );
    }

    /**
     * @test
     */
    public function setGeoeffneterAuftragForIntSetsGeoeffneterAuftrag(): void
    {
        $this->subject->setGeoeffneterAuftrag(12);

        self::assertEquals(12, $this->subject->_get('geoeffneterAuftrag'));
    }

    /**
     * @test
     */
    public function getSettingsAufgabenReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsAufgaben()
        );
    }

    /**
     * @test
     */
    public function setSettingsAufgabenForStringSetsSettingsAufgaben(): void
    {
        $this->subject->setSettingsAufgaben('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsAufgaben'));
    }

    /**
     * @test
     */
    public function getSettingsDateienReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsDateien()
        );
    }

    /**
     * @test
     */
    public function setSettingsDateienForStringSetsSettingsDateien(): void
    {
        $this->subject->setSettingsDateien('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsDateien'));
    }

    /**
     * @test
     */
    public function getAvatarReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getAvatar()
        );
    }

    /**
     * @test
     */
    public function setAvatarForFileReferenceSetsAvatar(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setAvatar($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('avatar'));
    }

    /**
     * @test
     */
    public function getSettingsAgenturauftragReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsAgenturauftrag()
        );
    }

    /**
     * @test
     */
    public function setSettingsAgenturauftragForStringSetsSettingsAgenturauftrag(): void
    {
        $this->subject->setSettingsAgenturauftrag('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsAgenturauftrag'));
    }

    /**
     * @test
     */
    public function getSettingsAblageReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsAblage()
        );
    }

    /**
     * @test
     */
    public function setSettingsAblageForStringSetsSettingsAblage(): void
    {
        $this->subject->setSettingsAblage('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsAblage'));
    }

    /**
     * @test
     */
    public function getSettingsAllgemeinReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsAllgemein()
        );
    }

    /**
     * @test
     */
    public function setSettingsAllgemeinForStringSetsSettingsAllgemein(): void
    {
        $this->subject->setSettingsAllgemein('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsAllgemein'));
    }

    /**
     * @test
     */
    public function getSettingsKundenReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsKunden()
        );
    }

    /**
     * @test
     */
    public function setSettingsKundenForStringSetsSettingsKunden(): void
    {
        $this->subject->setSettingsKunden('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsKunden'));
    }

    /**
     * @test
     */
    public function getOffeneAuftraegeReturnsInitialValueForAuftraege(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getOffeneAuftraege()
        );
    }

    /**
     * @test
     */
    public function setOffeneAuftraegeForObjectStorageContainingAuftraegeSetsOffeneAuftraege(): void
    {
        $offeneAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
        $objectStorageHoldingExactlyOneOffeneAuftraege = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneOffeneAuftraege->attach($offeneAuftraege);
        $this->subject->setOffeneAuftraege($objectStorageHoldingExactlyOneOffeneAuftraege);

        self::assertEquals($objectStorageHoldingExactlyOneOffeneAuftraege, $this->subject->_get('offeneAuftraege'));
    }

    /**
     * @test
     */
    public function addOffeneAuftraegeToObjectStorageHoldingOffeneAuftraege(): void
    {
        $offeneAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
        $offeneAuftraegeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $offeneAuftraegeObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($offeneAuftraege));
        $this->subject->_set('offeneAuftraege', $offeneAuftraegeObjectStorageMock);

        $this->subject->addOffeneAuftraege($offeneAuftraege);
    }

    /**
     * @test
     */
    public function removeOffeneAuftraegeFromObjectStorageHoldingOffeneAuftraege(): void
    {
        $offeneAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
        $offeneAuftraegeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $offeneAuftraegeObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($offeneAuftraege));
        $this->subject->_set('offeneAuftraege', $offeneAuftraegeObjectStorageMock);

        $this->subject->removeOffeneAuftraege($offeneAuftraege);
    }

    /**
     * @test
     */
    public function getAblageReturnsInitialValueForAblage(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAblage()
        );
    }

    /**
     * @test
     */
    public function setAblageForObjectStorageContainingAblageSetsAblage(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();
        $objectStorageHoldingExactlyOneAblage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAblage->attach($ablage);
        $this->subject->setAblage($objectStorageHoldingExactlyOneAblage);

        self::assertEquals($objectStorageHoldingExactlyOneAblage, $this->subject->_get('ablage'));
    }

    /**
     * @test
     */
    public function addAblageToObjectStorageHoldingAblage(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();
        $ablageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $ablageObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($ablage));
        $this->subject->_set('ablage', $ablageObjectStorageMock);

        $this->subject->addAblage($ablage);
    }

    /**
     * @test
     */
    public function removeAblageFromObjectStorageHoldingAblage(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();
        $ablageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $ablageObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($ablage));
        $this->subject->_set('ablage', $ablageObjectStorageMock);

        $this->subject->removeAblage($ablage);
    }
}
