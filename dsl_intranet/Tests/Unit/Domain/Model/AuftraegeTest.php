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
class AuftraegeTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Auftraege|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Auftraege::class,
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
    public function getStatusReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getStatus()
        );
    }

    /**
     * @test
     */
    public function setStatusForIntSetsStatus(): void
    {
        $this->subject->setStatus(12);

        self::assertEquals(12, $this->subject->_get('status'));
    }

    /**
     * @test
     */
    public function getDatumReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getDatum()
        );
    }

    /**
     * @test
     */
    public function setDatumForDateTimeSetsDatum(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDatum($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('datum'));
    }

    /**
     * @test
     */
    public function getPrioritaetReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getPrioritaet()
        );
    }

    /**
     * @test
     */
    public function setPrioritaetForIntSetsPrioritaet(): void
    {
        $this->subject->setPrioritaet(12);

        self::assertEquals(12, $this->subject->_get('prioritaet'));
    }

    /**
     * @test
     */
    public function getDatumfertigstellungReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getDatumfertigstellung()
        );
    }

    /**
     * @test
     */
    public function setDatumfertigstellungForDateTimeSetsDatumfertigstellung(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDatumfertigstellung($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('datumfertigstellung'));
    }

    /**
     * @test
     */
    public function getPhasenKontingentReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPhasenKontingent()
        );
    }

    /**
     * @test
     */
    public function setPhasenKontingentForStringSetsPhasenKontingent(): void
    {
        $this->subject->setPhasenKontingent('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('phasenKontingent'));
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
    public function getKontingentReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getKontingent()
        );
    }

    /**
     * @test
     */
    public function setKontingentForIntSetsKontingent(): void
    {
        $this->subject->setKontingent(12);

        self::assertEquals(12, $this->subject->_get('kontingent'));
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
    public function getPerReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getPer()
        );
    }

    /**
     * @test
     */
    public function setPerForIntSetsPer(): void
    {
        $this->subject->setPer(12);

        self::assertEquals(12, $this->subject->_get('per'));
    }

    /**
     * @test
     */
    public function getDurchReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDurch()
        );
    }

    /**
     * @test
     */
    public function setDurchForStringSetsDurch(): void
    {
        $this->subject->setDurch('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('durch'));
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
    public function getFestpreisReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getFestpreis()
        );
    }

    /**
     * @test
     */
    public function setFestpreisForFloatSetsFestpreis(): void
    {
        $this->subject->setFestpreis(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('festpreis'));
    }

    /**
     * @test
     */
    public function getFremdkostenSummeReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getFremdkostenSumme()
        );
    }

    /**
     * @test
     */
    public function setFremdkostenSummeForFloatSetsFremdkostenSumme(): void
    {
        $this->subject->setFremdkostenSumme(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('fremdkostenSumme'));
    }

    /**
     * @test
     */
    public function getDatumAbschlussReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getDatumAbschluss()
        );
    }

    /**
     * @test
     */
    public function setDatumAbschlussForDateTimeSetsDatumAbschluss(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDatumAbschluss($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('datumAbschluss'));
    }

    /**
     * @test
     */
    public function getNutzungsFaktorNurEntwurfKreativleistungReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getNutzungsFaktorNurEntwurfKreativleistung());
    }

    /**
     * @test
     */
    public function setNutzungsFaktorNurEntwurfKreativleistungForBoolSetsNutzungsFaktorNurEntwurfKreativleistung(): void
    {
        $this->subject->setNutzungsFaktorNurEntwurfKreativleistung(true);

        self::assertEquals(true, $this->subject->_get('nutzungsFaktorNurEntwurfKreativleistung'));
    }

    /**
     * @test
     */
    public function getNutzungsFaktorenReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getNutzungsFaktoren()
        );
    }

    /**
     * @test
     */
    public function setNutzungsFaktorenForStringSetsNutzungsFaktoren(): void
    {
        $this->subject->setNutzungsFaktoren('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('nutzungsFaktoren'));
    }

    /**
     * @test
     */
    public function getStundensatzReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getStundensatz()
        );
    }

    /**
     * @test
     */
    public function setStundensatzForFloatSetsStundensatz(): void
    {
        $this->subject->setStundensatz(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('stundensatz'));
    }

    /**
     * @test
     */
    public function getPhasenStundensatzReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPhasenStundensatz()
        );
    }

    /**
     * @test
     */
    public function setPhasenStundensatzForStringSetsPhasenStundensatz(): void
    {
        $this->subject->setPhasenStundensatz('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('phasenStundensatz'));
    }

    /**
     * @test
     */
    public function getNotizenInternReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getNotizenIntern()
        );
    }

    /**
     * @test
     */
    public function setNotizenInternForStringSetsNotizenIntern(): void
    {
        $this->subject->setNotizenIntern('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('notizenIntern'));
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
    public function getMitarbeiterReturnsInitialValueForMitarbeiter(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getMitarbeiter()
        );
    }

    /**
     * @test
     */
    public function setMitarbeiterForObjectStorageContainingMitarbeiterSetsMitarbeiter(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();
        $objectStorageHoldingExactlyOneMitarbeiter = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneMitarbeiter->attach($mitarbeiter);
        $this->subject->setMitarbeiter($objectStorageHoldingExactlyOneMitarbeiter);

        self::assertEquals($objectStorageHoldingExactlyOneMitarbeiter, $this->subject->_get('mitarbeiter'));
    }

    /**
     * @test
     */
    public function addMitarbeiterToObjectStorageHoldingMitarbeiter(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();
        $mitarbeiterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $mitarbeiterObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($mitarbeiter));
        $this->subject->_set('mitarbeiter', $mitarbeiterObjectStorageMock);

        $this->subject->addMitarbeiter($mitarbeiter);
    }

    /**
     * @test
     */
    public function removeMitarbeiterFromObjectStorageHoldingMitarbeiter(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();
        $mitarbeiterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $mitarbeiterObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($mitarbeiter));
        $this->subject->_set('mitarbeiter', $mitarbeiterObjectStorageMock);

        $this->subject->removeMitarbeiter($mitarbeiter);
    }

    /**
     * @test
     */
    public function getZeitenReturnsInitialValueForZeiteintraege(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getZeiten()
        );
    }

    /**
     * @test
     */
    public function setZeitenForObjectStorageContainingZeiteintraegeSetsZeiten(): void
    {
        $zeiten = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $objectStorageHoldingExactlyOneZeiten = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneZeiten->attach($zeiten);
        $this->subject->setZeiten($objectStorageHoldingExactlyOneZeiten);

        self::assertEquals($objectStorageHoldingExactlyOneZeiten, $this->subject->_get('zeiten'));
    }

    /**
     * @test
     */
    public function addZeitenToObjectStorageHoldingZeiten(): void
    {
        $zeiten = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $zeitenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeitenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($zeiten));
        $this->subject->_set('zeiten', $zeitenObjectStorageMock);

        $this->subject->addZeiten($zeiten);
    }

    /**
     * @test
     */
    public function removeZeitenFromObjectStorageHoldingZeiten(): void
    {
        $zeiten = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $zeitenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeitenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($zeiten));
        $this->subject->_set('zeiten', $zeitenObjectStorageMock);

        $this->subject->removeZeiten($zeiten);
    }

    /**
     * @test
     */
    public function getAuftragsartReturnsInitialValueForAuftragsarten(): void
    {
        self::assertEquals(
            null,
            $this->subject->getAuftragsart()
        );
    }

    /**
     * @test
     */
    public function setAuftragsartForAuftragsartenSetsAuftragsart(): void
    {
        $auftragsartFixture = new \DslFactory\DslIntranet\Domain\Model\Auftragsarten();
        $this->subject->setAuftragsart($auftragsartFixture);

        self::assertEquals($auftragsartFixture, $this->subject->_get('auftragsart'));
    }

    /**
     * @test
     */
    public function getPhasenReturnsInitialValueForPhasen(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getPhasen()
        );
    }

    /**
     * @test
     */
    public function setPhasenForObjectStorageContainingPhasenSetsPhasen(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();
        $objectStorageHoldingExactlyOnePhasen = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOnePhasen->attach($phasen);
        $this->subject->setPhasen($objectStorageHoldingExactlyOnePhasen);

        self::assertEquals($objectStorageHoldingExactlyOnePhasen, $this->subject->_get('phasen'));
    }

    /**
     * @test
     */
    public function addPhasenToObjectStorageHoldingPhasen(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();
        $phasenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $phasenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($phasen));
        $this->subject->_set('phasen', $phasenObjectStorageMock);

        $this->subject->addPhasen($phasen);
    }

    /**
     * @test
     */
    public function removePhasenFromObjectStorageHoldingPhasen(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();
        $phasenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $phasenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($phasen));
        $this->subject->_set('phasen', $phasenObjectStorageMock);

        $this->subject->removePhasen($phasen);
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

    /**
     * @test
     */
    public function getAnsprechpartnerReturnsInitialValueForMitarbeiter(): void
    {
        self::assertEquals(
            null,
            $this->subject->getAnsprechpartner()
        );
    }

    /**
     * @test
     */
    public function setAnsprechpartnerForMitarbeiterSetsAnsprechpartner(): void
    {
        $ansprechpartnerFixture = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();
        $this->subject->setAnsprechpartner($ansprechpartnerFixture);

        self::assertEquals($ansprechpartnerFixture, $this->subject->_get('ansprechpartner'));
    }

    /**
     * @test
     */
    public function getTexteReturnsInitialValueForAuftraegeTexte(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getTexte()
        );
    }

    /**
     * @test
     */
    public function setTexteForObjectStorageContainingAuftraegeTexteSetsTexte(): void
    {
        $texte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();
        $objectStorageHoldingExactlyOneTexte = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneTexte->attach($texte);
        $this->subject->setTexte($objectStorageHoldingExactlyOneTexte);

        self::assertEquals($objectStorageHoldingExactlyOneTexte, $this->subject->_get('texte'));
    }

    /**
     * @test
     */
    public function addTexteToObjectStorageHoldingTexte(): void
    {
        $texte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();
        $texteObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $texteObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($texte));
        $this->subject->_set('texte', $texteObjectStorageMock);

        $this->subject->addTexte($texte);
    }

    /**
     * @test
     */
    public function removeTexteFromObjectStorageHoldingTexte(): void
    {
        $texte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();
        $texteObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $texteObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($texte));
        $this->subject->_set('texte', $texteObjectStorageMock);

        $this->subject->removeTexte($texte);
    }

    /**
     * @test
     */
    public function getFegroupsReturnsInitialValueForFegroups(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getFegroups()
        );
    }

    /**
     * @test
     */
    public function setFegroupsForObjectStorageContainingFegroupsSetsFegroups(): void
    {
        $fegroup = new \DslFactory\DslIntranet\Domain\Model\Fegroups();
        $objectStorageHoldingExactlyOneFegroups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFegroups->attach($fegroup);
        $this->subject->setFegroups($objectStorageHoldingExactlyOneFegroups);

        self::assertEquals($objectStorageHoldingExactlyOneFegroups, $this->subject->_get('fegroups'));
    }

    /**
     * @test
     */
    public function addFegroupToObjectStorageHoldingFegroups(): void
    {
        $fegroup = new \DslFactory\DslIntranet\Domain\Model\Fegroups();
        $fegroupsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $fegroupsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($fegroup));
        $this->subject->_set('fegroups', $fegroupsObjectStorageMock);

        $this->subject->addFegroup($fegroup);
    }

    /**
     * @test
     */
    public function removeFegroupFromObjectStorageHoldingFegroups(): void
    {
        $fegroup = new \DslFactory\DslIntranet\Domain\Model\Fegroups();
        $fegroupsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $fegroupsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($fegroup));
        $this->subject->_set('fegroups', $fegroupsObjectStorageMock);

        $this->subject->removeFegroup($fegroup);
    }

    /**
     * @test
     */
    public function getFremdkostenReturnsInitialValueForFremdkosten(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getFremdkosten()
        );
    }

    /**
     * @test
     */
    public function setFremdkostenForObjectStorageContainingFremdkostenSetsFremdkosten(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();
        $objectStorageHoldingExactlyOneFremdkosten = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFremdkosten->attach($fremdkosten);
        $this->subject->setFremdkosten($objectStorageHoldingExactlyOneFremdkosten);

        self::assertEquals($objectStorageHoldingExactlyOneFremdkosten, $this->subject->_get('fremdkosten'));
    }

    /**
     * @test
     */
    public function addFremdkostenToObjectStorageHoldingFremdkosten(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();
        $fremdkostenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $fremdkostenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($fremdkosten));
        $this->subject->_set('fremdkosten', $fremdkostenObjectStorageMock);

        $this->subject->addFremdkosten($fremdkosten);
    }

    /**
     * @test
     */
    public function removeFremdkostenFromObjectStorageHoldingFremdkosten(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();
        $fremdkostenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $fremdkostenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($fremdkosten));
        $this->subject->_set('fremdkosten', $fremdkostenObjectStorageMock);

        $this->subject->removeFremdkosten($fremdkosten);
    }

    /**
     * @test
     */
    public function getLieferantenReturnsInitialValueForLieferanten(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getLieferanten()
        );
    }

    /**
     * @test
     */
    public function setLieferantenForObjectStorageContainingLieferantenSetsLieferanten(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();
        $objectStorageHoldingExactlyOneLieferanten = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneLieferanten->attach($lieferanten);
        $this->subject->setLieferanten($objectStorageHoldingExactlyOneLieferanten);

        self::assertEquals($objectStorageHoldingExactlyOneLieferanten, $this->subject->_get('lieferanten'));
    }

    /**
     * @test
     */
    public function addLieferantenToObjectStorageHoldingLieferanten(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();
        $lieferantenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $lieferantenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($lieferanten));
        $this->subject->_set('lieferanten', $lieferantenObjectStorageMock);

        $this->subject->addLieferanten($lieferanten);
    }

    /**
     * @test
     */
    public function removeLieferantenFromObjectStorageHoldingLieferanten(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();
        $lieferantenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $lieferantenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($lieferanten));
        $this->subject->_set('lieferanten', $lieferantenObjectStorageMock);

        $this->subject->removeLieferanten($lieferanten);
    }
}
