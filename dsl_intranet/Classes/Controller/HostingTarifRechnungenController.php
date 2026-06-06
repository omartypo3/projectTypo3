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
 * HostingTarifRechnungenController
 */
class HostingTarifRechnungenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * hostingTarifRechnungenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\HostingTarifRechnungenRepository
     */
    protected $hostingTarifRechnungenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\HostingTarifRechnungenRepository $hostingTarifRechnungenRepository
     */
    public function injectHostingTarifRechnungenRepository(\DslFactory\DslIntranet\Domain\Repository\HostingTarifRechnungenRepository $hostingTarifRechnungenRepository)
    {
        $this->hostingTarifRechnungenRepository = $hostingTarifRechnungenRepository;
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
        $hostingTarifRechnungens = $this->hostingTarifRechnungenRepository->findAll();
        $this->view->assign('hostingTarifRechnungens', $hostingTarifRechnungens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('hostingTarifRechnungen', $hostingTarifRechnungen);
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
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $newHostingTarifRechnungen
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $newHostingTarifRechnungen)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingTarifRechnungenRepository->add($newHostingTarifRechnungen);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("hostingTarifRechnungen")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('hostingTarifRechnungen', $hostingTarifRechnungen);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingTarifRechnungenRepository->update($hostingTarifRechnungen);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $hostingTarifRechnungen)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->hostingTarifRechnungenRepository->remove($hostingTarifRechnungen);
        $this->redirect('list');
    }
}
