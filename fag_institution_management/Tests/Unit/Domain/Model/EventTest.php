<?php
namespace FRONTAL\FagInstitutionManagement\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Roland Kneubühler <rk@frontal.ch>
 */
class EventTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\Event
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagInstitutionManagement\Domain\Model\Event();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function dummyTestToNotLeaveThisFileEmpty()
    {
        self::markTestIncomplete();
    }
}
