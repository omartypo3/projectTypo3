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
 * BenutzerController
 */
class BenutzerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action avatar
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function avatarAction(): \Psr\Http\Message\ResponseInterface
    {
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $this->view->assign('benutzer', $benutzer);
        return $this->htmlResponse();
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
        $benutzers = $this->benutzerRepository->findAll();
        $this->view->assign('benutzers', $benutzers);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('benutzer', $benutzer);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Benutzer $newBenutzer
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Benutzer $newBenutzer)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->benutzerRepository->add($newBenutzer);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("benutzer")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('benutzer', $benutzer);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->benutzerRepository->update($benutzer);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Benutzer $benutzer)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->benutzerRepository->remove($benutzer);
        $this->redirect('list');
    }
}
