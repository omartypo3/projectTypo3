<?php
namespace J77\J77products\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class MaschinenelementeTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Domain\Model\Maschinenelemente
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \J77\J77products\Domain\Model\Maschinenelemente();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getElementReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getElement()
        );
    }

    /**
     * @test
     */
    public function setElementForIntSetsElement()
    {
        $this->subject->setElement(12);

        self::assertAttributeEquals(
            12,
            'element',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBeschreibungstextReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBeschreibungstext()
        );
    }

    /**
     * @test
     */
    public function setBeschreibungstextForStringSetsBeschreibungstext()
    {
        $this->subject->setBeschreibungstext('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'beschreibungstext',
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
    public function getChargengroesseReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getChargengroesse()
        );
    }

    /**
     * @test
     */
    public function setChargengroesseForStringSetsChargengroesse()
    {
        $this->subject->setChargengroesse('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'chargengroesse',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDichtungReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDichtung()
        );
    }

    /**
     * @test
     */
    public function setDichtungForStringSetsDichtung()
    {
        $this->subject->setDichtung('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'dichtung',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDispergierkammerReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDispergierkammer()
        );
    }

    /**
     * @test
     */
    public function setDispergierkammerForStringSetsDispergierkammer()
    {
        $this->subject->setDispergierkammer('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'dispergierkammer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDrehzahlReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDrehzahl()
        );
    }

    /**
     * @test
     */
    public function setDrehzahlForStringSetsDrehzahl()
    {
        $this->subject->setDrehzahl('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'drehzahl',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDurchsatzfluessigkeitReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDurchsatzfluessigkeit()
        );
    }

    /**
     * @test
     */
    public function setDurchsatzfluessigkeitForStringSetsDurchsatzfluessigkeit()
    {
        $this->subject->setDurchsatzfluessigkeit('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'durchsatzfluessigkeit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEinsaugleistungpulverReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEinsaugleistungpulver()
        );
    }

    /**
     * @test
     */
    public function setEinsaugleistungpulverForStringSetsEinsaugleistungpulver()
    {
        $this->subject->setEinsaugleistungpulver('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'einsaugleistungpulver',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFunktionsbild1ReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getFunktionsbild1()
        );
    }

    /**
     * @test
     */
    public function setFunktionsbild1ForFileReferenceSetsFunktionsbild1()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setFunktionsbild1($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'funktionsbild1',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFunktionsbild2ReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getFunktionsbild2()
        );
    }

    /**
     * @test
     */
    public function setFunktionsbild2ForFileReferenceSetsFunktionsbild2()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setFunktionsbild2($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'funktionsbild2',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getHauptbildReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getHauptbild()
        );
    }

    /**
     * @test
     */
    public function setHauptbildForFileReferenceSetsHauptbild()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setHauptbild($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'hauptbild',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getIconReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getIcon()
        );
    }

    /**
     * @test
     */
    public function setIconForFileReferenceSetsIcon()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setIcon($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'icon',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLagerflanschReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLagerflansch()
        );
    }

    /**
     * @test
     */
    public function setLagerflanschForStringSetsLagerflansch()
    {
        $this->subject->setLagerflansch('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'lagerflansch',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLeistungReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLeistung()
        );
    }

    /**
     * @test
     */
    public function setLeistungForStringSetsLeistung()
    {
        $this->subject->setLeistung('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'leistung',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLinkespalteReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLinkespalte()
        );
    }

    /**
     * @test
     */
    public function setLinkespalteForStringSetsLinkespalte()
    {
        $this->subject->setLinkespalte('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'linkespalte',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMaschinenvarianteReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getMaschinenvariante()
        );
    }

    /**
     * @test
     */
    public function setMaschinenvarianteForIntSetsMaschinenvariante()
    {
        $this->subject->setMaschinenvariante(12);

        self::assertAttributeEquals(
            12,
            'maschinenvariante',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMaximaleviskositaetReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMaximaleviskositaet()
        );
    }

    /**
     * @test
     */
    public function setMaximaleviskositaetForStringSetsMaximaleviskositaet()
    {
        $this->subject->setMaximaleviskositaet('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'maximaleviskositaet',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getOptionenReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getOptionen()
        );
    }

    /**
     * @test
     */
    public function setOptionenForStringSetsOptionen()
    {
        $this->subject->setOptionen('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'optionen',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRechtespalteReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getRechtespalte()
        );
    }

    /**
     * @test
     */
    public function setRechtespalteForStringSetsRechtespalte()
    {
        $this->subject->setRechtespalte('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'rechtespalte',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSchergeschwindigkeitReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSchergeschwindigkeit()
        );
    }

    /**
     * @test
     */
    public function setSchergeschwindigkeitForStringSetsSchergeschwindigkeit()
    {
        $this->subject->setSchergeschwindigkeit('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'schergeschwindigkeit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSpannungReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSpannung()
        );
    }

    /**
     * @test
     */
    public function setSpannungForStringSetsSpannung()
    {
        $this->subject->setSpannung('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'spannung',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTauchteilReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTauchteil()
        );
    }

    /**
     * @test
     */
    public function setTauchteilForStringSetsTauchteil()
    {
        $this->subject->setTauchteil('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'tauchteil',
            $this->subject
        );
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
    public function getUmfangsgeschwindigkeitReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUmfangsgeschwindigkeit()
        );
    }

    /**
     * @test
     */
    public function setUmfangsgeschwindigkeitForStringSetsUmfangsgeschwindigkeit()
    {
        $this->subject->setUmfangsgeschwindigkeit('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'umfangsgeschwindigkeit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getWerkzeugschaftReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getWerkzeugschaft()
        );
    }

    /**
     * @test
     */
    public function setWerkzeugschaftForStringSetsWerkzeugschaft()
    {
        $this->subject->setWerkzeugschaft('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'werkzeugschaft',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUeberschriftReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUeberschrift()
        );
    }

    /**
     * @test
     */
    public function setUeberschriftForStringSetsUeberschrift()
    {
        $this->subject->setUeberschrift('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'ueberschrift',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDownloadrepeaterReturnsInitialValueForDownload()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getDownloadrepeater()
        );
    }

    /**
     * @test
     */
    public function setDownloadrepeaterForObjectStorageContainingDownloadSetsDownloadrepeater()
    {
        $downloadrepeater = new \J77\J77products\Domain\Model\Download();
        $objectStorageHoldingExactlyOneDownloadrepeater = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneDownloadrepeater->attach($downloadrepeater);
        $this->subject->setDownloadrepeater($objectStorageHoldingExactlyOneDownloadrepeater);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneDownloadrepeater,
            'downloadrepeater',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addDownloadrepeaterToObjectStorageHoldingDownloadrepeater()
    {
        $downloadrepeater = new \J77\J77products\Domain\Model\Download();
        $downloadrepeaterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $downloadrepeaterObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($downloadrepeater));
        $this->inject($this->subject, 'downloadrepeater', $downloadrepeaterObjectStorageMock);

        $this->subject->addDownloadrepeater($downloadrepeater);
    }

    /**
     * @test
     */
    public function removeDownloadrepeaterFromObjectStorageHoldingDownloadrepeater()
    {
        $downloadrepeater = new \J77\J77products\Domain\Model\Download();
        $downloadrepeaterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $downloadrepeaterObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($downloadrepeater));
        $this->inject($this->subject, 'downloadrepeater', $downloadrepeaterObjectStorageMock);

        $this->subject->removeDownloadrepeater($downloadrepeater);
    }

    /**
     * @test
     */
    public function getIconrepeaterReturnsInitialValueForIcon()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getIconrepeater()
        );
    }

    /**
     * @test
     */
    public function setIconrepeaterForObjectStorageContainingIconSetsIconrepeater()
    {
        $iconrepeater = new \J77\J77products\Domain\Model\Icon();
        $objectStorageHoldingExactlyOneIconrepeater = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneIconrepeater->attach($iconrepeater);
        $this->subject->setIconrepeater($objectStorageHoldingExactlyOneIconrepeater);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneIconrepeater,
            'iconrepeater',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addIconrepeaterToObjectStorageHoldingIconrepeater()
    {
        $iconrepeater = new \J77\J77products\Domain\Model\Icon();
        $iconrepeaterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $iconrepeaterObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($iconrepeater));
        $this->inject($this->subject, 'iconrepeater', $iconrepeaterObjectStorageMock);

        $this->subject->addIconrepeater($iconrepeater);
    }

    /**
     * @test
     */
    public function removeIconrepeaterFromObjectStorageHoldingIconrepeater()
    {
        $iconrepeater = new \J77\J77products\Domain\Model\Icon();
        $iconrepeaterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $iconrepeaterObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($iconrepeater));
        $this->inject($this->subject, 'iconrepeater', $iconrepeaterObjectStorageMock);

        $this->subject->removeIconrepeater($iconrepeater);
    }
}
