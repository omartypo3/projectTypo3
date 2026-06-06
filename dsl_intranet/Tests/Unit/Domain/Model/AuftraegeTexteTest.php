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
class AuftraegeTexteTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte::class,
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
    public function getBeschreibungReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBeschreibung()
        );
    }

    /**
     * @test
     */
    public function setBeschreibungForStringSetsBeschreibung(): void
    {
        $this->subject->setBeschreibung('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('beschreibung'));
    }

    /**
     * @test
     */
    public function getSichtbarkeitReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getSichtbarkeit());
    }

    /**
     * @test
     */
    public function setSichtbarkeitForBoolSetsSichtbarkeit(): void
    {
        $this->subject->setSichtbarkeit(true);

        self::assertEquals(true, $this->subject->_get('sichtbarkeit'));
    }
}
