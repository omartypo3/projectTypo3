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
 * MaschinenelementeController
 */
class MaschinenelementeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $maschinenelementes = $this->maschinenelementeRepository->findAll();
        $this->view->assign('maschinenelementes', $maschinenelementes);
    }

    /**
     * action show
     *
     * @param \J77\J77products\Domain\Model\Maschinenelemente $maschinenelemente
     * @return void
     */
    public function showAction(\J77\J77products\Domain\Model\Maschinenelemente $maschinenelemente)
    {
        $this->view->assign('maschinenelemente', $maschinenelemente);
    }
}
