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
class PhasenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Phasen|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Phasen::class,
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
    public function getColorReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getColor()
        );
    }

    /**
     * @test
     */
    public function setColorForStringSetsColor(): void
    {
        $this->subject->setColor('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('color'));
    }

    /**
     * @test
     */
    public function getHighlightcolorReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getHighlightcolor()
        );
    }

    /**
     * @test
     */
    public function setHighlightcolorForStringSetsHighlightcolor(): void
    {
        $this->subject->setHighlightcolor('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('highlightcolor'));
    }

    /**
     * @test
     */
    public function getIconReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getIcon()
        );
    }

    /**
     * @test
     */
    public function setIconForStringSetsIcon(): void
    {
        $this->subject->setIcon('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('icon'));
    }

    /**
     * @test
     */
    public function getTitelKurzReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitelKurz()
        );
    }

    /**
     * @test
     */
    public function setTitelKurzForStringSetsTitelKurz(): void
    {
        $this->subject->setTitelKurz('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('titelKurz'));
    }
}
