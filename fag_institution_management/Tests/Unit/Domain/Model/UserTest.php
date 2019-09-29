<?php
namespace FRONTAL\FagInstitutionManagement\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Roland Kneubühler <rk@frontal.ch>
 */
class UserTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\User
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagInstitutionManagement\Domain\Model\User();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getPrivilegeReturnsInitialValueForInstitution()
    {
        self::assertEquals(
            null,
            $this->subject->getPrivilege()
        );
    }

    /**
     * @test
     */
    public function setPrivilegeForInstitutionSetsPrivilege()
    {
        $privilegeFixture = new \FRONTAL\FagInstitutionManagement\Domain\Model\Institution();
        $this->subject->setPrivilege($privilegeFixture);

        self::assertAttributeEquals(
            $privilegeFixture,
            'privilege',
            $this->subject
        );
    }
}
