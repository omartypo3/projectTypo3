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
class ZeiteintraegeSegmenteTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente::class,
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
    public function getMinutenReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getMinuten()
        );
    }

    /**
     * @test
     */
    public function setMinutenForIntSetsMinuten(): void
    {
        $this->subject->setMinuten(12);

        self::assertEquals(12, $this->subject->_get('minuten'));
    }

    /**
     * @test
     */
    public function getPhaseReturnsInitialValueForPhasen(): void
    {
        self::assertEquals(
            null,
            $this->subject->getPhase()
        );
    }

    /**
     * @test
     */
    public function setPhaseForPhasenSetsPhase(): void
    {
        $phaseFixture = new \DslFactory\DslIntranet\Domain\Model\Phasen();
        $this->subject->setPhase($phaseFixture);

        self::assertEquals($phaseFixture, $this->subject->_get('phase'));
    }
}
