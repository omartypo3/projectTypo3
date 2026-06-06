<?php
namespace DslFactory\DslJobs\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class JobsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DslFactory\DslJobs\Controller\JobsController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\DslFactory\DslJobs\Controller\JobsController::class)
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
    public function listActionFetchesAllJobssFromRepositoryAndAssignsThemToView()
    {

        $allJobss = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $jobsRepository = $this->getMockBuilder(\DslFactory\DslJobs\Domain\Repository\JobsRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $jobsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allJobss));
        $this->inject($this->subject, 'jobsRepository', $jobsRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('jobss', $allJobss);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
