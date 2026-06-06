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
class TrackerSegmenteTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\TrackerSegmente|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\TrackerSegmente::class,
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
    public function getBeginReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getBegin()
        );
    }

    /**
     * @test
     */
    public function setBeginForDateTimeSetsBegin(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setBegin($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('begin'));
    }

    /**
     * @test
     */
    public function getEndReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getEnd()
        );
    }

    /**
     * @test
     */
    public function setEndForDateTimeSetsEnd(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setEnd($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('end'));
    }
}
