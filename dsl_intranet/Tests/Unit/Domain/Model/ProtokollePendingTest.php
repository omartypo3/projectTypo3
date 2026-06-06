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
class ProtokollePendingTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\ProtokollePending|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\ProtokollePending::class,
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
    public function getPendingReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getPending());
    }

    /**
     * @test
     */
    public function setPendingForBoolSetsPending(): void
    {
        $this->subject->setPending(true);

        self::assertEquals(true, $this->subject->_get('pending'));
    }

    /**
     * @test
     */
    public function getTimestampReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getTimestamp()
        );
    }

    /**
     * @test
     */
    public function setTimestampForDateTimeSetsTimestamp(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setTimestamp($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('timestamp'));
    }

    /**
     * @test
     */
    public function getMitarbeiterReturnsInitialValueForMitarbeiter(): void
    {
        self::assertEquals(
            null,
            $this->subject->getMitarbeiter()
        );
    }

    /**
     * @test
     */
    public function setMitarbeiterForMitarbeiterSetsMitarbeiter(): void
    {
        $mitarbeiterFixture = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();
        $this->subject->setMitarbeiter($mitarbeiterFixture);

        self::assertEquals($mitarbeiterFixture, $this->subject->_get('mitarbeiter'));
    }
}
