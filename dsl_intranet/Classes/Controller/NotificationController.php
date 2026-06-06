<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * NotificationController
 */
class NotificationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * notificationRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\NotificationRepository
     */
    protected $notificationRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\NotificationRepository $notificationRepository
     */
    public function injectNotificationRepository(\DslFactory\DslIntranet\Domain\Repository\NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * action readall
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function readallAction(): \Psr\Http\Message\ResponseInterface
    {
        $notifications = $this->notificationRepository->findAllUnreadByFrontendUser();
        foreach ($notifications as $notification) {
            $notification->setGelesen(1);
            $this->notificationRepository->update($notification);
        }
        return $this->htmlResponse();
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $lastUid = 0;
        if ($this->request->hasArgument('ajax')) {
            $this->view->assign('ajax', true);
            if ($this->request->hasArgument('lastUid')) {
                //sleep(10);
                $lastUid = (int) $this->request->getArgument('lastUid');
            }
        }
        //$this->view->assign('lasttest', $lastUid);
        $notifications = $this->notificationRepository->findAllByFrontendUser($lastUid);
        //echo "!!".count($notifications);
        $this->view->assign('notifications', $notifications);
        $this->view->assign('lastUid', $lastUid);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Notification $notification
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Notification $notification): \Psr\Http\Message\ResponseInterface
    {
        $notification->setGelesen(1);
        $this->notificationRepository->update($notification);
        $this->view->assign('notification', $notification);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Notification $newNotification
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Notification $newNotification)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->notificationRepository->add($newNotification);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Notification $notification
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("notification")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Notification $notification): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('notification', $notification);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Notification $notification
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Notification $notification)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->notificationRepository->update($notification);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Notification $notification
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Notification $notification)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->notificationRepository->remove($notification);
        $this->redirect('list');
    }
}
