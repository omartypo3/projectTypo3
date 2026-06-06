<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class NotificationControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\NotificationController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\NotificationController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllNotificationsFromRepositoryAndAssignsThemToView(): void
    {
        $allNotifications = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $notificationRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NotificationRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationRepository->expects(self::once())->method('findAll')->will(self::returnValue($allNotifications));
        $this->subject->_set('notificationRepository', $notificationRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('notifications', $allNotifications);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenNotificationToView(): void
    {
        $notification = new \DslFactory\DslIntranet\Domain\Model\Notification();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('notification', $notification);

        $this->subject->showAction($notification);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenNotificationToNotificationRepository(): void
    {
        $notification = new \DslFactory\DslIntranet\Domain\Model\Notification();

        $notificationRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NotificationRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $notificationRepository->expects(self::once())->method('add')->with($notification);
        $this->subject->_set('notificationRepository', $notificationRepository);

        $this->subject->createAction($notification);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenNotificationToView(): void
    {
        $notification = new \DslFactory\DslIntranet\Domain\Model\Notification();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('notification', $notification);

        $this->subject->editAction($notification);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenNotificationInNotificationRepository(): void
    {
        $notification = new \DslFactory\DslIntranet\Domain\Model\Notification();

        $notificationRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NotificationRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $notificationRepository->expects(self::once())->method('update')->with($notification);
        $this->subject->_set('notificationRepository', $notificationRepository);

        $this->subject->updateAction($notification);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenNotificationFromNotificationRepository(): void
    {
        $notification = new \DslFactory\DslIntranet\Domain\Model\Notification();

        $notificationRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NotificationRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $notificationRepository->expects(self::once())->method('remove')->with($notification);
        $this->subject->_set('notificationRepository', $notificationRepository);

        $this->subject->deleteAction($notification);
    }
}
