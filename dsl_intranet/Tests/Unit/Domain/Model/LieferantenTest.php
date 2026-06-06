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
class LieferantenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Lieferanten|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Lieferanten::class,
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
}
