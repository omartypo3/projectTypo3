<?php
namespace Silcoplastproduct\SilcoplastProduct\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author ons <ons.chaari@softtodo.com>
 */
class CategoryproductControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Silcoplastproduct\SilcoplastProduct\Controller\CategoryproductController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Silcoplastproduct\SilcoplastProduct\Controller\CategoryproductController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllCategoryproductsFromRepositoryAndAssignsThemToView()
    {

        $allCategoryproducts = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $categoryproductRepository = $this->getMockBuilder(\Silcoplastproduct\SilcoplastProduct\Domain\Repository\CategoryproductRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $categoryproductRepository->expects(self::once())->method('findAll')->will(self::returnValue($allCategoryproducts));
        $this->inject($this->subject, 'categoryproductRepository', $categoryproductRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('categoryproducts', $allCategoryproducts);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCategoryproductToView()
    {
        $categoryproduct = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('categoryproduct', $categoryproduct);

        $this->subject->showAction($categoryproduct);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenCategoryproductToCategoryproductRepository()
    {
        $categoryproduct = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct();

        $categoryproductRepository = $this->getMockBuilder(\Silcoplastproduct\SilcoplastProduct\Domain\Repository\CategoryproductRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $categoryproductRepository->expects(self::once())->method('add')->with($categoryproduct);
        $this->inject($this->subject, 'categoryproductRepository', $categoryproductRepository);

        $this->subject->createAction($categoryproduct);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenCategoryproductToView()
    {
        $categoryproduct = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('categoryproduct', $categoryproduct);

        $this->subject->editAction($categoryproduct);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenCategoryproductInCategoryproductRepository()
    {
        $categoryproduct = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct();

        $categoryproductRepository = $this->getMockBuilder(\Silcoplastproduct\SilcoplastProduct\Domain\Repository\CategoryproductRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $categoryproductRepository->expects(self::once())->method('update')->with($categoryproduct);
        $this->inject($this->subject, 'categoryproductRepository', $categoryproductRepository);

        $this->subject->updateAction($categoryproduct);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenCategoryproductFromCategoryproductRepository()
    {
        $categoryproduct = new \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct();

        $categoryproductRepository = $this->getMockBuilder(\Silcoplastproduct\SilcoplastProduct\Domain\Repository\CategoryproductRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $categoryproductRepository->expects(self::once())->method('remove')->with($categoryproduct);
        $this->inject($this->subject, 'categoryproductRepository', $categoryproductRepository);

        $this->subject->deleteAction($categoryproduct);
    }
}
