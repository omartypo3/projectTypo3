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
 * HostingZusatzleistungenController
 */
class HostingZusatzleistungenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * hostingZusatzleistungenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\HostingZusatzleistungenRepository
     */
    protected $hostingZusatzleistungenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\HostingZusatzleistungenRepository $hostingZusatzleistungenRepository
     */
    public function injectHostingZusatzleistungenRepository(\DslFactory\DslIntranet\Domain\Repository\HostingZusatzleistungenRepository $hostingZusatzleistungenRepository)
    {
        $this->hostingZusatzleistungenRepository = $hostingZusatzleistungenRepository;
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
        $hostingZusatzleistungens = $this->hostingZusatzleistungenRepository->findAll();
        $this->view->assign('hostingZusatzleistungens', $hostingZusatzleistungens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('hostingZusatzleistungen', $hostingZusatzleistungen);
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
     * @param \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $newHostingZusatzleistungen
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $newHostingZusatzleistungen)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingZusatzleistungenRepository->add($newHostingZusatzleistungen);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("hostingZusatzleistungen")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('hostingZusatzleistungen', $hostingZusatzleistungen);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingZusatzleistungenRepository->update($hostingZusatzleistungen);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $hostingZusatzleistungen)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingZusatzleistungenRepository->remove($hostingZusatzleistungen);
        $this->redirect('list');
    }
}
