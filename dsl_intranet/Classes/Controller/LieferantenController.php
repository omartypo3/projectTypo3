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
 * LieferantenController
 */
class LieferantenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * lieferantenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\LieferantenRepository
     */
    protected $lieferantenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\LieferantenRepository $lieferantenRepository
     */
    public function injectLieferantenRepository(\DslFactory\DslIntranet\Domain\Repository\LieferantenRepository $lieferantenRepository)
    {
        $this->lieferantenRepository = $lieferantenRepository;
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
        $lieferantens = $this->lieferantenRepository->findAll();
        $this->view->assign('lieferantens', $lieferantens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('lieferanten', $lieferanten);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Lieferanten $newLieferanten
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Lieferanten $newLieferanten)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->lieferantenRepository->add($newLieferanten);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("lieferanten")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('lieferanten', $lieferanten);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->lieferantenRepository->update($lieferanten);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Lieferanten $lieferanten)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->lieferantenRepository->remove($lieferanten);
        $this->redirect('list');
    }
}
