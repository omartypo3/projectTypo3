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
 * WartungsvertraegeRechnungenController
 */
class WartungsvertraegeRechnungenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * wartungsvertraegeRechnungenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRechnungenRepository
     */
    protected $wartungsvertraegeRechnungenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRechnungenRepository $wartungsvertraegeRechnungenRepository
     */
    public function injectWartungsvertraegeRechnungenRepository(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRechnungenRepository $wartungsvertraegeRechnungenRepository)
    {
        $this->wartungsvertraegeRechnungenRepository = $wartungsvertraegeRechnungenRepository;
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
        $wartungsvertraegeRechnungens = $this->wartungsvertraegeRechnungenRepository->findAll();
        $this->view->assign('wartungsvertraegeRechnungens', $wartungsvertraegeRechnungens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('wartungsvertraegeRechnungen', $wartungsvertraegeRechnungen);
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
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $newWartungsvertraegeRechnungen
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $newWartungsvertraegeRechnungen)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeRechnungenRepository->add($newWartungsvertraegeRechnungen);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("wartungsvertraegeRechnungen")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('wartungsvertraegeRechnungen', $wartungsvertraegeRechnungen);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeRechnungenRepository->update($wartungsvertraegeRechnungen);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeRechnungenRepository->remove($wartungsvertraegeRechnungen);
        $this->redirect('list');
    }
}
