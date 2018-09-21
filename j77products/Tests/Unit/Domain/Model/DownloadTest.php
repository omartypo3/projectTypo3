<?php
namespace J77\J77products\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class DownloadTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Domain\Model\Download
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \J77\J77products\Domain\Model\Download();
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
    public function getDateiReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getDatei()
        );
    }

    /**
     * @test
     */
    public function setDateiForFileReferenceSetsDatei()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setDatei($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'datei',
            $this->subject
        );
    }
}
