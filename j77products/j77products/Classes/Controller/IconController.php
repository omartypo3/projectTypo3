<?php
namespace J77\J77products\Controller;

/***
 *
 * This file is part of the "Produkte" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * IconController
 */
class IconController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $icons = $this->iconRepository->findAll();
        $this->view->assign('icons', $icons);
    }

    /**
     * action show
     *
     * @param \J77\J77products\Domain\Model\Icon $icon
     * @return void
     */
    public function showAction(\J77\J77products\Domain\Model\Icon $icon)
    {
        $this->view->assign('icon', $icon);
    }
}
