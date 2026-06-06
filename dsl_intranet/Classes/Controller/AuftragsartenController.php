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
 * AuftragsartenController
 */
class AuftragsartenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * auftragsartenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\AuftragsartenRepository
     */
    protected $auftragsartenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\AuftragsartenRepository $auftragsartenRepository
     */
    public function injectAuftragsartenRepository(\DslFactory\DslIntranet\Domain\Repository\AuftragsartenRepository $auftragsartenRepository)
    {
        $this->auftragsartenRepository = $auftragsartenRepository;
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
        $auftragsartens = $this->auftragsartenRepository->findAll();
        $this->view->assign('auftragsartens', $auftragsartens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('auftragsarten', $auftragsarten);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Auftragsarten $newAuftragsarten
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Auftragsarten $newAuftragsarten)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->auftragsartenRepository->add($newAuftragsarten);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("auftragsarten")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('auftragsarten', $auftragsarten);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->auftragsartenRepository->update($auftragsarten);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Auftragsarten $auftragsarten)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->auftragsartenRepository->remove($auftragsarten);
        $this->redirect('list');
    }
}
