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
 * WartungsvertraegeZeitraeumeController
 */
class WartungsvertraegeZeitraeumeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * wartungsvertraegeZeitraeumeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository
     */
    protected $wartungsvertraegeZeitraeumeRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository $wartungsvertraegeZeitraeumeRepository
     */
    public function injectWartungsvertraegeZeitraeumeRepository(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository $wartungsvertraegeZeitraeumeRepository)
    {
        $this->wartungsvertraegeZeitraeumeRepository = $wartungsvertraegeZeitraeumeRepository;
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
        $wartungsvertraegeZeitraeumes = $this->wartungsvertraegeZeitraeumeRepository->findAll();
        $this->view->assign('wartungsvertraegeZeitraeumes', $wartungsvertraegeZeitraeumes);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('wartungsvertraegeZeitraeume', $wartungsvertraegeZeitraeume);
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
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $newWartungsvertraegeZeitraeume
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $newWartungsvertraegeZeitraeume)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeZeitraeumeRepository->add($newWartungsvertraegeZeitraeume);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("wartungsvertraegeZeitraeume")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('wartungsvertraegeZeitraeume', $wartungsvertraegeZeitraeume);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeZeitraeumeRepository->update($wartungsvertraegeZeitraeume);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeZeitraeumeRepository->remove($wartungsvertraegeZeitraeume);
        $this->redirect('list');
    }
}
