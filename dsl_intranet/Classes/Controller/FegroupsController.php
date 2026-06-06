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
 * FegroupsController
 */
class FegroupsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * fegroupsRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\FegroupsRepository
     */
    protected $fegroupsRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\FegroupsRepository $fegroupsRepository
     */
    public function injectFegroupsRepository(\DslFactory\DslIntranet\Domain\Repository\FegroupsRepository $fegroupsRepository)
    {
        $this->fegroupsRepository = $fegroupsRepository;
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
        $fegroups = $this->fegroupsRepository->findAll();
        $this->view->assign('fegroups', $fegroups);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('fegroups', $fegroups);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $newFegroups
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Fegroups $newFegroups)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->fegroupsRepository->add($newFegroups);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("fegroups")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('fegroups', $fegroups);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->fegroupsRepository->update($fegroups);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Fegroups $fegroups)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->fegroupsRepository->remove($fegroups);
        $this->redirect('list');
    }
}
