<?php
namespace FRONTAL\FagInstitutionManagement\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Roland Kneubühler <rk@frontal.ch>
 */
class FunctionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\Function
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagInstitutionManagement\Domain\Model\Function();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUserReturnsInitialValueForUser()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getUser()
        );
    }

    /**
     * @test
     */
    public function setUserForObjectStorageContainingUserSetsUser()
    {
        $user = new \FRONTAL\FagInstitutionManagement\Domain\Model\User();
        $objectStorageHoldingExactlyOneUser = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneUser->attach($user);
        $this->subject->setUser($objectStorageHoldingExactlyOneUser);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneUser,
            'user',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addUserToObjectStorageHoldingUser()
    {
        $user = new \FRONTAL\FagInstitutionManagement\Domain\Model\User();
        $userObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $userObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($user));
        $this->inject($this->subject, 'user', $userObjectStorageMock);

        $this->subject->addUser($user);
    }

    /**
     * @test
     */
    public function removeUserFromObjectStorageHoldingUser()
    {
        $user = new \FRONTAL\FagInstitutionManagement\Domain\Model\User();
        $userObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $userObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($user));
        $this->inject($this->subject, 'user', $userObjectStorageMock);

        $this->subject->removeUser($user);
    }

    /**
     * @test
     */
    public function getInstitutionReturnsInitialValueForInstitution()
    {
        self::assertEquals(
            null,
            $this->subject->getInstitution()
        );
    }

    /**
     * @test
     */
    public function setInstitutionForInstitutionSetsInstitution()
    {
        $institutionFixture = new \FRONTAL\FagInstitutionManagement\Domain\Model\Institution();
        $this->subject->setInstitution($institutionFixture);

        self::assertAttributeEquals(
            $institutionFixture,
            'institution',
            $this->subject
        );
    }
}
