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
class KundenStammdatenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\KundenStammdaten|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\KundenStammdaten::class,
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
    public function getSettingsKundeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsKunde()
        );
    }

    /**
     * @test
     */
    public function setSettingsKundeForStringSetsSettingsKunde(): void
    {
        $this->subject->setSettingsKunde('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsKunde'));
    }

    /**
     * @test
     */
    public function getNewsletterReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getNewsletter());
    }

    /**
     * @test
     */
    public function setNewsletterForBoolSetsNewsletter(): void
    {
        $this->subject->setNewsletter(true);

        self::assertEquals(true, $this->subject->_get('newsletter'));
    }
}
