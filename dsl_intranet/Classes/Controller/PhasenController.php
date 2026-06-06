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
 * PhasenController
 */
class PhasenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * phasenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\PhasenRepository
     */
    protected $phasenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\PhasenRepository $phasenRepository
     */
    public function injectPhasenRepository(\DslFactory\DslIntranet\Domain\Repository\PhasenRepository $phasenRepository)
    {
        $this->phasenRepository = $phasenRepository;
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
        $phasens = $this->phasenRepository->findAll();
        $this->view->assign('phasens', $phasens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phasen
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Phasen $phasen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('phasen', $phasen);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $newPhasen
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Phasen $newPhasen)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->phasenRepository->add($newPhasen);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phasen
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("phasen")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Phasen $phasen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('phasen', $phasen);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phasen
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Phasen $phasen)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->phasenRepository->update($phasen);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phasen
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Phasen $phasen)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->phasenRepository->remove($phasen);
        $this->redirect('list');
    }
}
