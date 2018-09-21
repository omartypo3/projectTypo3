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
 * DownloadController
 */
class DownloadController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $downloads = $this->downloadRepository->findAll();
        $this->view->assign('downloads', $downloads);
    }

    /**
     * action show
     *
     * @param \J77\J77products\Domain\Model\Download $download
     * @return void
     */
    public function showAction(\J77\J77products\Domain\Model\Download $download)
    {
        $this->view->assign('download', $download);
    }
}
