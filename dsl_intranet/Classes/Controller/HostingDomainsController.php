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
 * HostingDomainsController
 */
class HostingDomainsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * hostingDomainsRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\HostingDomainsRepository
     */
    protected $hostingDomainsRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\HostingDomainsRepository $hostingDomainsRepository
     */
    public function injectHostingDomainsRepository(\DslFactory\DslIntranet\Domain\Repository\HostingDomainsRepository $hostingDomainsRepository)
    {
        $this->hostingDomainsRepository = $hostingDomainsRepository;
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
        $hostingDomains = $this->hostingDomainsRepository->findAll();
        $this->view->assign('hostingDomains', $hostingDomains);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('hostingDomains', $hostingDomains);
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
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $newHostingDomains
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\HostingDomains $newHostingDomains)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingDomainsRepository->add($newHostingDomains);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("hostingDomains")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('hostingDomains', $hostingDomains);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingDomainsRepository->update($hostingDomains);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingDomainsRepository->remove($hostingDomains);
        $this->redirect('list');
    }
}
