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
 * TarifeController
 */
class TarifeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * tarifeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\TarifeRepository
     */
    protected $tarifeRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\TarifeRepository $tarifeRepository
     */
    public function injectTarifeRepository(\DslFactory\DslIntranet\Domain\Repository\TarifeRepository $tarifeRepository)
    {
        $this->tarifeRepository = $tarifeRepository;
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
        $tarives = $this->tarifeRepository->findAll();
        $this->view->assign('tarives', $tarives);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Tarife $tarife
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Tarife $tarife): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('tarife', $tarife);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Tarife $newTarife
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Tarife $newTarife)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tarifeRepository->add($newTarife);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Tarife $tarife
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("tarife")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Tarife $tarife): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('tarife', $tarife);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Tarife $tarife
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Tarife $tarife)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tarifeRepository->update($tarife);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Tarife $tarife
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Tarife $tarife)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tarifeRepository->remove($tarife);
        $this->redirect('list');
    }
}
