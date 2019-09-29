<?php
namespace Silcoplastproduct\SilcoplastProduct\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author ons <ons.chaari@softtodo.com>
 */
class CategoryproductTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getIconReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getIcon()
        );
    }

    /**
     * @test
     */
    public function setIconForFileReferenceSetsIcon()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setIcon($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'icon',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getIcongReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getIcong()
        );
    }

    /**
     * @test
     */
    public function setIcongForFileReferenceSetsIcong()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setIcong($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'icong',
            $this->subject
        );
    }
}
