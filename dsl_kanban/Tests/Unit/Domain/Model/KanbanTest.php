<?php
namespace DslFactory\DslKanban\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author mz@dsl-factory.de <mz@dsl-factory.de>
 */
class KanbanTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DslFactory\DslKanban\Domain\Model\Kanban
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DslFactory\DslKanban\Domain\Model\Kanban();
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
    public function getBoardReturnsInitialValueForBoard()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getBoard()
        );

    }

    /**
     * @test
     */
    public function setBoardForObjectStorageContainingBoardSetsBoard()
    {
        $board = new \DslFactory\DslKanban\Domain\Model\Board();
        $objectStorageHoldingExactlyOneBoard = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneBoard->attach($board);
        $this->subject->setBoard($objectStorageHoldingExactlyOneBoard);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneBoard,
            'board',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addBoardToObjectStorageHoldingBoard()
    {
        $board = new \DslFactory\DslKanban\Domain\Model\Board();
        $boardObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $boardObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($board));
        $this->inject($this->subject, 'board', $boardObjectStorageMock);

        $this->subject->addBoard($board);
    }

    /**
     * @test
     */
    public function removeBoardFromObjectStorageHoldingBoard()
    {
        $board = new \DslFactory\DslKanban\Domain\Model\Board();
        $boardObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $boardObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($board));
        $this->inject($this->subject, 'board', $boardObjectStorageMock);

        $this->subject->removeBoard($board);

    }

    /**
     * @test
     */
    public function getItemsAusgeblendetReturnsInitialValueForItem()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getItemsAusgeblendet()
        );

    }

    /**
     * @test
     */
    public function setItemsAusgeblendetForObjectStorageContainingItemSetsItemsAusgeblendet()
    {
        $itemsAusgeblendet = new \DslFactory\DslKanban\Domain\Model\Item();
        $objectStorageHoldingExactlyOneItemsAusgeblendet = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneItemsAusgeblendet->attach($itemsAusgeblendet);
        $this->subject->setItemsAusgeblendet($objectStorageHoldingExactlyOneItemsAusgeblendet);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneItemsAusgeblendet,
            'itemsAusgeblendet',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addItemsAusgeblendetToObjectStorageHoldingItemsAusgeblendet()
    {
        $itemsAusgeblendet = new \DslFactory\DslKanban\Domain\Model\Item();
        $itemsAusgeblendetObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $itemsAusgeblendetObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($itemsAusgeblendet));
        $this->inject($this->subject, 'itemsAusgeblendet', $itemsAusgeblendetObjectStorageMock);

        $this->subject->addItemsAusgeblendet($itemsAusgeblendet);
    }

    /**
     * @test
     */
    public function removeItemsAusgeblendetFromObjectStorageHoldingItemsAusgeblendet()
    {
        $itemsAusgeblendet = new \DslFactory\DslKanban\Domain\Model\Item();
        $itemsAusgeblendetObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $itemsAusgeblendetObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($itemsAusgeblendet));
        $this->inject($this->subject, 'itemsAusgeblendet', $itemsAusgeblendetObjectStorageMock);

        $this->subject->removeItemsAusgeblendet($itemsAusgeblendet);

    }
}
