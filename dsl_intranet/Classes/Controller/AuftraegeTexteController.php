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
 * AuftraegeTexteController
 */
class AuftraegeTexteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * auftraegeTexteRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\AuftraegeTexteRepository
     */
    protected $auftraegeTexteRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\AuftraegeTexteRepository $auftraegeTexteRepository
     */
    public function injectAuftraegeTexteRepository(\DslFactory\DslIntranet\Domain\Repository\AuftraegeTexteRepository $auftraegeTexteRepository)
    {
        $this->auftraegeTexteRepository = $auftraegeTexteRepository;
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
        $auftraegeTextes = $this->auftraegeTexteRepository->findAll();
        $this->view->assign('auftraegeTextes', $auftraegeTextes);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('auftraegeTexte', $auftraegeTexte);
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
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $newAuftraegeTexte
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $newAuftraegeTexte)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->auftraegeTexteRepository->add($newAuftraegeTexte);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("auftraegeTexte")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('auftraegeTexte', $auftraegeTexte);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->auftraegeTexteRepository->update($auftraegeTexte);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\AuftraegeTexte $auftraegeTexte)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->auftraegeTexteRepository->remove($auftraegeTexte);
        $this->redirect('list');
    }
}
