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
class WartungsvertraegeTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege::class,
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
    public function getTitelReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitel()
        );
    }

    /**
     * @test
     */
    public function setTitelForStringSetsTitel(): void
    {
        $this->subject->setTitel('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('titel'));
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
    public function getGekuendigtReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getGekuendigt());
    }

    /**
     * @test
     */
    public function setGekuendigtForBoolSetsGekuendigt(): void
    {
        $this->subject->setGekuendigt(true);

        self::assertEquals(true, $this->subject->_get('gekuendigt'));
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
    public function getBezahltbisReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getBezahltbis()
        );
    }

    /**
     * @test
     */
    public function setBezahltbisForDateTimeSetsBezahltbis(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setBezahltbis($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('bezahltbis'));
    }

    /**
     * @test
     */
    public function getLaufzeitReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getLaufzeit()
        );
    }

    /**
     * @test
     */
    public function setLaufzeitForIntSetsLaufzeit(): void
    {
        $this->subject->setLaufzeit(12);

        self::assertEquals(12, $this->subject->_get('laufzeit'));
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
    public function getReIntervallReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getReIntervall()
        );
    }

    /**
     * @test
     */
    public function setReIntervallForIntSetsReIntervall(): void
    {
        $this->subject->setReIntervall(12);

        self::assertEquals(12, $this->subject->_get('reIntervall'));
    }

    /**
     * @test
     */
    public function getStundenProJahrReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getStundenProJahr()
        );
    }

    /**
     * @test
     */
    public function setStundenProJahrForIntSetsStundenProJahr(): void
    {
        $this->subject->setStundenProJahr(12);

        self::assertEquals(12, $this->subject->_get('stundenProJahr'));
    }

    /**
     * @test
     */
    public function getSichtbarkeitReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getSichtbarkeit());
    }

    /**
     * @test
     */
    public function setSichtbarkeitForBoolSetsSichtbarkeit(): void
    {
        $this->subject->setSichtbarkeit(true);

        self::assertEquals(true, $this->subject->_get('sichtbarkeit'));
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
    public function getKuendigungsFristReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getKuendigungsFrist()
        );
    }

    /**
     * @test
     */
    public function setKuendigungsFristForIntSetsKuendigungsFrist(): void
    {
        $this->subject->setKuendigungsFrist(12);

        self::assertEquals(12, $this->subject->_get('kuendigungsFrist'));
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
    public function getOptionenReturnsInitialValueForWartungsvertraegeOptionen(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getOptionen()
        );
    }

    /**
     * @test
     */
    public function setOptionenForObjectStorageContainingWartungsvertraegeOptionenSetsOptionen(): void
    {
        $optionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();
        $objectStorageHoldingExactlyOneOptionen = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneOptionen->attach($optionen);
        $this->subject->setOptionen($objectStorageHoldingExactlyOneOptionen);

        self::assertEquals($objectStorageHoldingExactlyOneOptionen, $this->subject->_get('optionen'));
    }

    /**
     * @test
     */
    public function addOptionenToObjectStorageHoldingOptionen(): void
    {
        $optionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();
        $optionenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $optionenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($optionen));
        $this->subject->_set('optionen', $optionenObjectStorageMock);

        $this->subject->addOptionen($optionen);
    }

    /**
     * @test
     */
    public function removeOptionenFromObjectStorageHoldingOptionen(): void
    {
        $optionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();
        $optionenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $optionenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($optionen));
        $this->subject->_set('optionen', $optionenObjectStorageMock);

        $this->subject->removeOptionen($optionen);
    }

    /**
     * @test
     */
    public function getZeitraeumeReturnsInitialValueForWartungsvertraegeZeitraeume(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getZeitraeume()
        );
    }

    /**
     * @test
     */
    public function setZeitraeumeForObjectStorageContainingWartungsvertraegeZeitraeumeSetsZeitraeume(): void
    {
        $zeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();
        $objectStorageHoldingExactlyOneZeitraeume = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneZeitraeume->attach($zeitraeume);
        $this->subject->setZeitraeume($objectStorageHoldingExactlyOneZeitraeume);

        self::assertEquals($objectStorageHoldingExactlyOneZeitraeume, $this->subject->_get('zeitraeume'));
    }

    /**
     * @test
     */
    public function addZeitraeumeToObjectStorageHoldingZeitraeume(): void
    {
        $zeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();
        $zeitraeumeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeitraeumeObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($zeitraeume));
        $this->subject->_set('zeitraeume', $zeitraeumeObjectStorageMock);

        $this->subject->addZeitraeume($zeitraeume);
    }

    /**
     * @test
     */
    public function removeZeitraeumeFromObjectStorageHoldingZeitraeume(): void
    {
        $zeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();
        $zeitraeumeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeitraeumeObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($zeitraeume));
        $this->subject->_set('zeitraeume', $zeitraeumeObjectStorageMock);

        $this->subject->removeZeitraeume($zeitraeume);
    }
}
