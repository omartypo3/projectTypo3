<?php
namespace Silcoplastproduct\SilcoplastProduct\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author ons <ons.chaari@softtodo.com>
 */
class ProductTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Silcoplastproduct\SilcoplastProduct\Domain\Model\Product
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Product();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImagesReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getImages()
        );
    }

    /**
     * @test
     */
    public function setImagesForFileReferenceSetsImages()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setImages($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'images',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCategorieReturnsInitialValueForCategoryproduct()
    {
        self::assertEquals(
            null,
            $this->subject->getCategorie()
        );
    }

    /**
     * @test
     */
    public function setCategorieForCategoryproductSetsCategorie()
    {
        $categorieFixture = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct();
        $this->subject->setCategorie($categorieFixture);

        self::assertAttributeEquals(
            $categorieFixture,
            'categorie',
            $this->subject
        );
    }
}
