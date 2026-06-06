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
class TarifeTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Tarife|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Tarife::class,
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
}
