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
 * WartungsvertraegeOptionenController
 */
class WartungsvertraegeOptionenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * wartungsvertraegeOptionenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeOptionenRepository
     */
    protected $wartungsvertraegeOptionenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeOptionenRepository $wartungsvertraegeOptionenRepository
     */
    public function injectWartungsvertraegeOptionenRepository(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeOptionenRepository $wartungsvertraegeOptionenRepository)
    {
        $this->wartungsvertraegeOptionenRepository = $wartungsvertraegeOptionenRepository;
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
        $wartungsvertraegeOptionens = $this->wartungsvertraegeOptionenRepository->findAll();
        $this->view->assign('wartungsvertraegeOptionens', $wartungsvertraegeOptionens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('wartungsvertraegeOptionen', $wartungsvertraegeOptionen);
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
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $newWartungsvertraegeOptionen
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $newWartungsvertraegeOptionen)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeOptionenRepository->add($newWartungsvertraegeOptionen);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("wartungsvertraegeOptionen")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('wartungsvertraegeOptionen', $wartungsvertraegeOptionen);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeOptionenRepository->update($wartungsvertraegeOptionen);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen $wartungsvertraegeOptionen)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->wartungsvertraegeOptionenRepository->remove($wartungsvertraegeOptionen);
        $this->redirect('list');
    }
}
