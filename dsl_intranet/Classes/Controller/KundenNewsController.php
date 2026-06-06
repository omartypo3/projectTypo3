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
 * KundenNewsController
 */
class KundenNewsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * kundenNewsRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\KundenNewsRepository
     */
    protected $kundenNewsRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\KundenNewsRepository $kundenNewsRepository
     */
    public function injectKundenNewsRepository(\DslFactory\DslIntranet\Domain\Repository\KundenNewsRepository $kundenNewsRepository)
    {
        $this->kundenNewsRepository = $kundenNewsRepository;
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
        $kundenNews = $this->kundenNewsRepository->findAll();
        $this->view->assign('kundenNews', $kundenNews);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenNews', $kundenNews);
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
     * @param \DslFactory\DslIntranet\Domain\Model\KundenNews $newKundenNews
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\KundenNews $newKundenNews)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenNewsRepository->add($newKundenNews);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("kundenNews")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenNews', $kundenNews);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenNewsRepository->update($kundenNews);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\KundenNews $kundenNews)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenNewsRepository->remove($kundenNews);
        $this->redirect('list');
    }
}
