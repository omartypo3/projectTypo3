<?php
namespace J77\J77products\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class AnlagenelementeTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Domain\Model\Anlagenelemente
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \J77\J77products\Domain\Model\Anlagenelemente();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getAnlagenReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getAnlagen()
        );
    }

    /**
     * @test
     */
    public function setAnlagenForIntSetsAnlagen()
    {
        $this->subject->setAnlagen(12);

        self::assertAttributeEquals(
            12,
            'anlagen',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAnsatzgroesseReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAnsatzgroesse()
        );
    }

    /**
     * @test
     */
    public function setAnsatzgroesseForStringSetsAnsatzgroesse()
    {
        $this->subject->setAnsatzgroesse('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'ansatzgroesse',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAnwendungsbereichReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAnwendungsbereich()
        );
    }

    /**
     * @test
     */
    public function setAnwendungsbereichForStringSetsAnwendungsbereich()
    {
        $this->subject->setAnwendungsbereich('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'anwendungsbereich',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAutomatisierungsgradReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAutomatisierungsgrad()
        );
    }

    /**
     * @test
     */
    public function setAutomatisierungsgradForStringSetsAutomatisierungsgrad()
    {
        $this->subject->setAutomatisierungsgrad('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'automatisierungsgrad',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAutorReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAutor()
        );
    }

    /**
     * @test
     */
    public function setAutorForStringSetsAutor()
    {
        $this->subject->setAutor('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'autor',
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
    public function getBrancheReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBranche()
        );
    }

    /**
     * @test
     */
    public function setBrancheForStringSetsBranche()
    {
        $this->subject->setBranche('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'branche',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBrancheniconReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getBranchenicon()
        );
    }

    /**
     * @test
     */
    public function setBrancheniconForFileReferenceSetsBranchenicon()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setBranchenicon($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'branchenicon',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEndprodukteReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEndprodukte()
        );
    }

    /**
     * @test
     */
    public function setEndprodukteForStringSetsEndprodukte()
    {
        $this->subject->setEndprodukte('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'endprodukte',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFuellstoffanteilReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFuellstoffanteil()
        );
    }

    /**
     * @test
     */
    public function setFuellstoffanteilForStringSetsFuellstoffanteil()
    {
        $this->subject->setFuellstoffanteil('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'fuellstoffanteil',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getKapazitaetReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getKapazitaet()
        );
    }

    /**
     * @test
     */
    public function setKapazitaetForStringSetsKapazitaet()
    {
        $this->subject->setKapazitaet('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'kapazitaet',
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
    public function getPlatzbedarfReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPlatzbedarf()
        );
    }

    /**
     * @test
     */
    public function setPlatzbedarfForStringSetsPlatzbedarf()
    {
        $this->subject->setPlatzbedarf('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'platzbedarf',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPortraitbildReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getPortraitbild()
        );
    }

    /**
     * @test
     */
    public function setPortraitbildForFileReferenceSetsPortraitbild()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setPortraitbild($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'portraitbild',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPulverzufuehrungReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPulverzufuehrung()
        );
    }

    /**
     * @test
     */
    public function setPulverzufuehrungForStringSetsPulverzufuehrung()
    {
        $this->subject->setPulverzufuehrung('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'pulverzufuehrung',
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
    public function getReinigungsfaehigkeitReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getReinigungsfaehigkeit()
        );
    }

    /**
     * @test
     */
    public function setReinigungsfaehigkeitForStringSetsReinigungsfaehigkeit()
    {
        $this->subject->setReinigungsfaehigkeit('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'reinigungsfaehigkeit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getZitatReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getZitat()
        );
    }

    /**
     * @test
     */
    public function setZitatForStringSetsZitat()
    {
        $this->subject->setZitat('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'zitat',
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
    public function getWeitereanforderungrepeaterReturnsInitialValueForWeitereAnforderungen()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getWeitereanforderungrepeater()
        );
    }

    /**
     * @test
     */
    public function setWeitereanforderungrepeaterForObjectStorageContainingWeitereAnforderungenSetsWeitereanforderungrepeater()
    {
        $weitereanforderungrepeater = new \J77\J77products\Domain\Model\WeitereAnforderungen();
        $objectStorageHoldingExactlyOneWeitereanforderungrepeater = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneWeitereanforderungrepeater->attach($weitereanforderungrepeater);
        $this->subject->setWeitereanforderungrepeater($objectStorageHoldingExactlyOneWeitereanforderungrepeater);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneWeitereanforderungrepeater,
            'weitereanforderungrepeater',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addWeitereanforderungrepeaterToObjectStorageHoldingWeitereanforderungrepeater()
    {
        $weitereanforderungrepeater = new \J77\J77products\Domain\Model\WeitereAnforderungen();
        $weitereanforderungrepeaterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $weitereanforderungrepeaterObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($weitereanforderungrepeater));
        $this->inject($this->subject, 'weitereanforderungrepeater', $weitereanforderungrepeaterObjectStorageMock);

        $this->subject->addWeitereanforderungrepeater($weitereanforderungrepeater);
    }

    /**
     * @test
     */
    public function removeWeitereanforderungrepeaterFromObjectStorageHoldingWeitereanforderungrepeater()
    {
        $weitereanforderungrepeater = new \J77\J77products\Domain\Model\WeitereAnforderungen();
        $weitereanforderungrepeaterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $weitereanforderungrepeaterObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($weitereanforderungrepeater));
        $this->inject($this->subject, 'weitereanforderungrepeater', $weitereanforderungrepeaterObjectStorageMock);

        $this->subject->removeWeitereanforderungrepeater($weitereanforderungrepeater);
    }
}
