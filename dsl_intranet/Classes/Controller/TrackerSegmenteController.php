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
 * TrackerSegmenteController
 */
class TrackerSegmenteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * trackerSegmenteRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\TrackerSegmenteRepository
     */
    protected $trackerSegmenteRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\TrackerSegmenteRepository $trackerSegmenteRepository
     */
    public function injectTrackerSegmenteRepository(\DslFactory\DslIntranet\Domain\Repository\TrackerSegmenteRepository $trackerSegmenteRepository)
    {
        $this->trackerSegmenteRepository = $trackerSegmenteRepository;
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
        $trackerSegmentes = $this->trackerSegmenteRepository->findAll();
        $this->view->assign('trackerSegmentes', $trackerSegmentes);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('trackerSegmente', $trackerSegmente);
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
     * @param \DslFactory\DslIntranet\Domain\Model\TrackerSegmente $newTrackerSegmente
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\TrackerSegmente $newTrackerSegmente)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->trackerSegmenteRepository->add($newTrackerSegmente);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("trackerSegmente")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('trackerSegmente', $trackerSegmente);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->trackerSegmenteRepository->update($trackerSegmente);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerSegmente)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->trackerSegmenteRepository->remove($trackerSegmente);
        $this->redirect('list');
    }
}
