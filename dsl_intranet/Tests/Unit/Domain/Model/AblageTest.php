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
class AblageTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Ablage|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Ablage::class,
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
    public function getAuftragReturnsInitialValueForAuftraege(): void
    {
        self::assertEquals(
            null,
            $this->subject->getAuftrag()
        );
    }

    /**
     * @test
     */
    public function setAuftragForAuftraegeSetsAuftrag(): void
    {
        $auftragFixture = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
        $this->subject->setAuftrag($auftragFixture);

        self::assertEquals($auftragFixture, $this->subject->_get('auftrag'));
    }
}
