<?php
namespace DslFactory\DslKanban\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author mz@dsl-factory.de <mz@dsl-factory.de>
 */
class BoardTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DslFactory\DslKanban\Domain\Model\Board
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DslFactory\DslKanban\Domain\Model\Board();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getKuerzelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getKuerzel()
        );

    }

    /**
     * @test
     */
    public function setKuerzelForStringSetsKuerzel()
    {
        $this->subject->setKuerzel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'kuerzel',
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
    public function getFixiertReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getFixiert()
        );

    }

    /**
     * @test
     */
    public function setFixiertForBoolSetsFixiert()
    {
        $this->subject->setFixiert(true);

        self::assertAttributeEquals(
            true,
            'fixiert',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getItemsReturnsInitialValueForItem()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getItems()
        );

    }

    /**
     * @test
     */
    public function setItemsForObjectStorageContainingItemSetsItems()
    {
        $item = new \DslFactory\DslKanban\Domain\Model\Item();
        $objectStorageHoldingExactlyOneItems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneItems->attach($item);
        $this->subject->setItems($objectStorageHoldingExactlyOneItems);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneItems,
            'items',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addItemToObjectStorageHoldingItems()
    {
        $item = new \DslFactory\DslKanban\Domain\Model\Item();
        $itemsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $itemsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($item));
        $this->inject($this->subject, 'items', $itemsObjectStorageMock);

        $this->subject->addItem($item);
    }

    /**
     * @test
     */
    public function removeItemFromObjectStorageHoldingItems()
    {
        $item = new \DslFactory\DslKanban\Domain\Model\Item();
        $itemsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $itemsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($item));
        $this->inject($this->subject, 'items', $itemsObjectStorageMock);

        $this->subject->removeItem($item);

    }
}
