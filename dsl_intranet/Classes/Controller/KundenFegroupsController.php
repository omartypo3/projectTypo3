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
 * KundenFegroupsController
 */
class KundenFegroupsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * kundenFegroupsRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\KundenFegroupsRepository
     */
    protected $kundenFegroupsRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\KundenFegroupsRepository $kundenFegroupsRepository
     */
    public function injectKundenFegroupsRepository(\DslFactory\DslIntranet\Domain\Repository\KundenFegroupsRepository $kundenFegroupsRepository)
    {
        $this->kundenFegroupsRepository = $kundenFegroupsRepository;
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
        $kundenFegroups = $this->kundenFegroupsRepository->findAll();
        $this->view->assign('kundenFegroups', $kundenFegroups);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenFegroups', $kundenFegroups);
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
     * @param \DslFactory\DslIntranet\Domain\Model\KundenFegroups $newKundenFegroups
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\KundenFegroups $newKundenFegroups)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenFegroupsRepository->add($newKundenFegroups);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("kundenFegroups")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenFegroups', $kundenFegroups);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenFegroupsRepository->update($kundenFegroups);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\KundenFegroups $kundenFegroups)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenFegroupsRepository->remove($kundenFegroups);
        $this->redirect('list');
    }
}
