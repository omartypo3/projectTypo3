<?php
namespace BravoBuero\BbPortfolio\Controller;

use BravoBuero\BbPortfolio\Domain\Repository\KundenRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * KundenController
 */
class KundenController extends ActionController
{

    /**
     * kundenRepository
     *
     * @var \BravoBuero\BbPortfolio\Domain\Repository\KundenRepository
     */
    protected $kundenRepository = NULL;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction(): ResponseInterface
    {
        $kundens = $this->kundenRepository->findAll();
        $this->view->assign('kundens', $kundens);
         return $this->htmlResponse();
    }

    /**
     * action listslider
     * 
     * @return void
     */
    public function listsliderAction(): ResponseInterface
    {
        $kundens = $this->kundenRepository->findAll()->toArray();
        shuffle($kundens);
        $this->view->assign('kundens', array_slice($kundens, 0, 20));
         return $this->htmlResponse();
    }

    public function injectKundenRepository(KundenRepository $kundenRepository): void
    {
        $this->kundenRepository = $kundenRepository;
    }

}