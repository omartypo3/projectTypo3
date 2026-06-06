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
 * ZusatzleistungenController
 */
class ZusatzleistungenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * zusatzleistungenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\ZusatzleistungenRepository
     */
    protected $zusatzleistungenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\ZusatzleistungenRepository $zusatzleistungenRepository
     */
    public function injectZusatzleistungenRepository(\DslFactory\DslIntranet\Domain\Repository\ZusatzleistungenRepository $zusatzleistungenRepository)
    {
        $this->zusatzleistungenRepository = $zusatzleistungenRepository;
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
        $zusatzleistungens = $this->zusatzleistungenRepository->findAll();
        $this->view->assign('zusatzleistungens', $zusatzleistungens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('zusatzleistungen', $zusatzleistungen);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $newZusatzleistungen
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $newZusatzleistungen)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zusatzleistungenRepository->add($newZusatzleistungen);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("zusatzleistungen")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('zusatzleistungen', $zusatzleistungen);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zusatzleistungenRepository->update($zusatzleistungen);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistungen)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->zusatzleistungenRepository->remove($zusatzleistungen);
        $this->redirect('list');
    }
}
