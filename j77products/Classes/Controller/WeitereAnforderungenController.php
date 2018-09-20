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
 * WeitereAnforderungenController
 */
class WeitereAnforderungenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $weitereAnforderungens = $this->weitereAnforderungenRepository->findAll();
        $this->view->assign('weitereAnforderungens', $weitereAnforderungens);
    }

    /**
     * action show
     *
     * @param \J77\J77products\Domain\Model\WeitereAnforderungen $weitereAnforderungen
     * @return void
     */
    public function showAction(\J77\J77products\Domain\Model\WeitereAnforderungen $weitereAnforderungen)
    {
        $this->view->assign('weitereAnforderungen', $weitereAnforderungen);
    }
}
