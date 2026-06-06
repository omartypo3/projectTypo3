<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Controller;


/**
 * This file is part of the "pingagaddress" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022
 */

/**
 * DienstleistungenController
 */
class DienstleistungenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * dienstleistungenRepository
     *
     * @var \Pingag\PingagAddress\Domain\Repository\DienstleistungenRepository
     */
    protected $dienstleistungenRepository = null;

    /**
     * @param \Pingag\PingagAddress\Domain\Repository\DienstleistungenRepository $dienstleistungenRepository
     */
    /**
     * kantoneRepository
     *
     * @var \Pingag\PingagAddress\Domain\Repository\KantoneRepository
     */
    protected $kantoneRepository = null;

    /**
     * @param \Pingag\PingagAddress\Domain\Repository\KantoneRepository $kantoneRepository
     */
    public function injectMapRepository(\Pingag\PingagAddress\Domain\Repository\MapRepository $dienstleistungenRepository,  $kantoneRepository)
    {
        $this->dienstleistungenRepository = $dienstleistungenRepository;
        $this->kantoneRepository = $kantoneRepository;
    }



    public function initializeAction(): void
    {


        $this->addressRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\AddressRepository');
    }
    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {


        $dienstleistungens = $this->dienstleistungenRepository->findAll();
        $kantones = $this->kantonesRepository->findAll();

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($maps);
        $this->view->assign('dienstleistungens', $dienstleistungens);
        $this->view->assign('kantones', $kantones);

        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \Pingag\PingagAddress\Domain\Model\Dienstleistungen $dienstleistungen
     * @param \Pingag\PingagAddress\Domain\Model\Kantone $kantone
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\Pingag\PingagAddress\Domain\Model\Dienstleistungen $dienstleistungen, $kantone): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('dienstleistungen', $dienstleistungen);
        $this->view->assign('kantone', $kantone);
        return $this->htmlResponse();
    }


}
