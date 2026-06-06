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
class HostingTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Hosting|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Hosting::class,
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
    public function getBenutzernameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBenutzername()
        );
    }

    /**
     * @test
     */
    public function setBenutzernameForStringSetsBenutzername(): void
    {
        $this->subject->setBenutzername('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('benutzername'));
    }

    /**
     * @test
     */
    public function getKennwortReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getKennwort()
        );
    }

    /**
     * @test
     */
    public function setKennwortForStringSetsKennwort(): void
    {
        $this->subject->setKennwort('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('kennwort'));
    }

    /**
     * @test
     */
    public function getStatistikReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getStatistik()
        );
    }

    /**
     * @test
     */
    public function setStatistikForStringSetsStatistik(): void
    {
        $this->subject->setStatistik('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('statistik'));
    }

    /**
     * @test
     */
    public function getOldidReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getOldid()
        );
    }

    /**
     * @test
     */
    public function setOldidForIntSetsOldid(): void
    {
        $this->subject->setOldid(12);

        self::assertEquals(12, $this->subject->_get('oldid'));
    }

    /**
     * @test
     */
    public function getNotizReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getNotiz()
        );
    }

    /**
     * @test
     */
    public function setNotizForStringSetsNotiz(): void
    {
        $this->subject->setNotiz('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('notiz'));
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
    public function getHauptTarifReturnsInitialValueForHostingDomains(): void
    {
        self::assertEquals(
            null,
            $this->subject->getHauptTarif()
        );
    }

    /**
     * @test
     */
    public function setHauptTarifForHostingDomainsSetsHauptTarif(): void
    {
        $hauptTarifFixture = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();
        $this->subject->setHauptTarif($hauptTarifFixture);

        self::assertEquals($hauptTarifFixture, $this->subject->_get('hauptTarif'));
    }

    /**
     * @test
     */
    public function getZusatzLeistungenReturnsInitialValueForHostingZusatzleistungen(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getZusatzLeistungen()
        );
    }

    /**
     * @test
     */
    public function setZusatzLeistungenForObjectStorageContainingHostingZusatzleistungenSetsZusatzLeistungen(): void
    {
        $zusatzLeistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();
        $objectStorageHoldingExactlyOneZusatzLeistungen = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneZusatzLeistungen->attach($zusatzLeistungen);
        $this->subject->setZusatzLeistungen($objectStorageHoldingExactlyOneZusatzLeistungen);

        self::assertEquals($objectStorageHoldingExactlyOneZusatzLeistungen, $this->subject->_get('zusatzLeistungen'));
    }

    /**
     * @test
     */
    public function addZusatzLeistungenToObjectStorageHoldingZusatzLeistungen(): void
    {
        $zusatzLeistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();
        $zusatzLeistungenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zusatzLeistungenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($zusatzLeistungen));
        $this->subject->_set('zusatzLeistungen', $zusatzLeistungenObjectStorageMock);

        $this->subject->addZusatzLeistungen($zusatzLeistungen);
    }

    /**
     * @test
     */
    public function removeZusatzLeistungenFromObjectStorageHoldingZusatzLeistungen(): void
    {
        $zusatzLeistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();
        $zusatzLeistungenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zusatzLeistungenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($zusatzLeistungen));
        $this->subject->_set('zusatzLeistungen', $zusatzLeistungenObjectStorageMock);

        $this->subject->removeZusatzLeistungen($zusatzLeistungen);
    }

    /**
     * @test
     */
    public function getZusatzTarifReturnsInitialValueForHostingDomains(): void
    {
        self::assertEquals(
            null,
            $this->subject->getZusatzTarif()
        );
    }

    /**
     * @test
     */
    public function setZusatzTarifForHostingDomainsSetsZusatzTarif(): void
    {
        $zusatzTarifFixture = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();
        $this->subject->setZusatzTarif($zusatzTarifFixture);

        self::assertEquals($zusatzTarifFixture, $this->subject->_get('zusatzTarif'));
    }
}
