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
 * ZeiteintraegeSegmenteController
 */
class ZeiteintraegeSegmenteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * zeiteintraegeSegmenteRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeSegmenteRepository
     */
    protected $zeiteintraegeSegmenteRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeSegmenteRepository $zeiteintraegeSegmenteRepository
     */
    public function injectZeiteintraegeSegmenteRepository(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeSegmenteRepository $zeiteintraegeSegmenteRepository)
    {
        $this->zeiteintraegeSegmenteRepository = $zeiteintraegeSegmenteRepository;
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
        $zeiteintraegeSegmentes = $this->zeiteintraegeSegmenteRepository->findAll();
        $this->view->assign('zeiteintraegeSegmentes', $zeiteintraegeSegmentes);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('zeiteintraegeSegmente', $zeiteintraegeSegmente);
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
     * @param \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $newZeiteintraegeSegmente
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $newZeiteintraegeSegmente)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zeiteintraegeSegmenteRepository->add($newZeiteintraegeSegmente);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("zeiteintraegeSegmente")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('zeiteintraegeSegmente', $zeiteintraegeSegmente);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zeiteintraegeSegmenteRepository->update($zeiteintraegeSegmente);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $zeiteintraegeSegmente)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zeiteintraegeSegmenteRepository->remove($zeiteintraegeSegmente);
        $this->redirect('list');
    }
}
