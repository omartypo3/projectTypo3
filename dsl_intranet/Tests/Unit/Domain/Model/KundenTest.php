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
class KundenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Kunden::class,
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
    public function getNummerReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getNummer()
        );
    }

    /**
     * @test
     */
    public function setNummerForStringSetsNummer(): void
    {
        $this->subject->setNummer('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('nummer'));
    }

    /**
     * @test
     */
    public function getQbrefnumReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbrefnum()
        );
    }

    /**
     * @test
     */
    public function setQbrefnumForStringSetsQbrefnum(): void
    {
        $this->subject->setQbrefnum('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbrefnum'));
    }

    /**
     * @test
     */
    public function getQbbaddrReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbbaddr()
        );
    }

    /**
     * @test
     */
    public function setQbbaddrForStringSetsQbbaddr(): void
    {
        $this->subject->setQbbaddr('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbbaddr'));
    }

    /**
     * @test
     */
    public function getSpitznameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSpitzname()
        );
    }

    /**
     * @test
     */
    public function setSpitznameForStringSetsSpitzname(): void
    {
        $this->subject->setSpitzname('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('spitzname'));
    }

    /**
     * @test
     */
    public function getInitialienReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getInitialien()
        );
    }

    /**
     * @test
     */
    public function setInitialienForStringSetsInitialien(): void
    {
        $this->subject->setInitialien('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('initialien'));
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
    public function getFreigabenReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFreigaben()
        );
    }

    /**
     * @test
     */
    public function setFreigabenForStringSetsFreigaben(): void
    {
        $this->subject->setFreigaben('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('freigaben'));
    }

    /**
     * @test
     */
    public function getHistoryReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getHistory()
        );
    }

    /**
     * @test
     */
    public function setHistoryForStringSetsHistory(): void
    {
        $this->subject->setHistory('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('history'));
    }

    /**
     * @test
     */
    public function getQbEmailReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbEmail()
        );
    }

    /**
     * @test
     */
    public function setQbEmailForStringSetsQbEmail(): void
    {
        $this->subject->setQbEmail('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbEmail'));
    }

    /**
     * @test
     */
    public function getQbEinvEmailReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbEinvEmail()
        );
    }

    /**
     * @test
     */
    public function setQbEinvEmailForStringSetsQbEinvEmail(): void
    {
        $this->subject->setQbEinvEmail('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbEinvEmail'));
    }

    /**
     * @test
     */
    public function getQbContReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbCont()
        );
    }

    /**
     * @test
     */
    public function setQbContForStringSetsQbCont(): void
    {
        $this->subject->setQbCont('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbCont'));
    }

    /**
     * @test
     */
    public function getQbAnredeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbAnrede()
        );
    }

    /**
     * @test
     */
    public function setQbAnredeForStringSetsQbAnrede(): void
    {
        $this->subject->setQbAnrede('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbAnrede'));
    }

    /**
     * @test
     */
    public function getQbFirstnameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbFirstname()
        );
    }

    /**
     * @test
     */
    public function setQbFirstnameForStringSetsQbFirstname(): void
    {
        $this->subject->setQbFirstname('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbFirstname'));
    }

    /**
     * @test
     */
    public function getQbLastnameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbLastname()
        );
    }

    /**
     * @test
     */
    public function setQbLastnameForStringSetsQbLastname(): void
    {
        $this->subject->setQbLastname('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbLastname'));
    }

    /**
     * @test
     */
    public function getQbStreetReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbStreet()
        );
    }

    /**
     * @test
     */
    public function setQbStreetForStringSetsQbStreet(): void
    {
        $this->subject->setQbStreet('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbStreet'));
    }

    /**
     * @test
     */
    public function getQbPostalReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbPostal()
        );
    }

    /**
     * @test
     */
    public function setQbPostalForStringSetsQbPostal(): void
    {
        $this->subject->setQbPostal('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbPostal'));
    }

    /**
     * @test
     */
    public function getQbCityReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbCity()
        );
    }

    /**
     * @test
     */
    public function setQbCityForStringSetsQbCity(): void
    {
        $this->subject->setQbCity('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbCity'));
    }

    /**
     * @test
     */
    public function getQbPhoneReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbPhone()
        );
    }

    /**
     * @test
     */
    public function setQbPhoneForStringSetsQbPhone(): void
    {
        $this->subject->setQbPhone('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbPhone'));
    }

    /**
     * @test
     */
    public function getQbFaxReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbFax()
        );
    }

    /**
     * @test
     */
    public function setQbFaxForStringSetsQbFax(): void
    {
        $this->subject->setQbFax('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbFax'));
    }

    /**
     * @test
     */
    public function getQbCont2ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbCont2()
        );
    }

    /**
     * @test
     */
    public function setQbCont2ForStringSetsQbCont2(): void
    {
        $this->subject->setQbCont2('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbCont2'));
    }

    /**
     * @test
     */
    public function getQbPhone2ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbPhone2()
        );
    }

    /**
     * @test
     */
    public function setQbPhone2ForStringSetsQbPhone2(): void
    {
        $this->subject->setQbPhone2('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbPhone2'));
    }

    /**
     * @test
     */
    public function getAutologinReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAutologin()
        );
    }

    /**
     * @test
     */
    public function setAutologinForStringSetsAutologin(): void
    {
        $this->subject->setAutologin('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('autologin'));
    }

    /**
     * @test
     */
    public function getEmailRechnungenReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEmailRechnungen()
        );
    }

    /**
     * @test
     */
    public function setEmailRechnungenForStringSetsEmailRechnungen(): void
    {
        $this->subject->setEmailRechnungen('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('emailRechnungen'));
    }

    /**
     * @test
     */
    public function getEmailAngeboteReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEmailAngebote()
        );
    }

    /**
     * @test
     */
    public function setEmailAngeboteForStringSetsEmailAngebote(): void
    {
        $this->subject->setEmailAngebote('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('emailAngebote'));
    }

    /**
     * @test
     */
    public function getNewsletterReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getNewsletter());
    }

    /**
     * @test
     */
    public function setNewsletterForBoolSetsNewsletter(): void
    {
        $this->subject->setNewsletter(true);

        self::assertEquals(true, $this->subject->_get('newsletter'));
    }

    /**
     * @test
     */
    public function getEmailNewsletterReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEmailNewsletter()
        );
    }

    /**
     * @test
     */
    public function setEmailNewsletterForStringSetsEmailNewsletter(): void
    {
        $this->subject->setEmailNewsletter('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('emailNewsletter'));
    }

    /**
     * @test
     */
    public function getQbKtoInhReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbKtoInh()
        );
    }

    /**
     * @test
     */
    public function setQbKtoInhForStringSetsQbKtoInh(): void
    {
        $this->subject->setQbKtoInh('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbKtoInh'));
    }

    /**
     * @test
     */
    public function getQbBicReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbBic()
        );
    }

    /**
     * @test
     */
    public function setQbBicForStringSetsQbBic(): void
    {
        $this->subject->setQbBic('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbBic'));
    }

    /**
     * @test
     */
    public function getQbIbanReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbIban()
        );
    }

    /**
     * @test
     */
    public function setQbIbanForStringSetsQbIban(): void
    {
        $this->subject->setQbIban('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbIban'));
    }

    /**
     * @test
     */
    public function getQbBankReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbBank()
        );
    }

    /**
     * @test
     */
    public function setQbBankForStringSetsQbBank(): void
    {
        $this->subject->setQbBank('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbBank'));
    }

    /**
     * @test
     */
    public function getPicDropZugangscodeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPicDropZugangscode()
        );
    }

    /**
     * @test
     */
    public function setPicDropZugangscodeForStringSetsPicDropZugangscode(): void
    {
        $this->subject->setPicDropZugangscode('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('picDropZugangscode'));
    }

    /**
     * @test
     */
    public function getPasswortKopieReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPasswortKopie()
        );
    }

    /**
     * @test
     */
    public function setPasswortKopieForStringSetsPasswortKopie(): void
    {
        $this->subject->setPasswortKopie('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('passwortKopie'));
    }

    /**
     * @test
     */
    public function getQbCompanyReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getQbCompany()
        );
    }

    /**
     * @test
     */
    public function setQbCompanyForStringSetsQbCompany(): void
    {
        $this->subject->setQbCompany('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('qbCompany'));
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
