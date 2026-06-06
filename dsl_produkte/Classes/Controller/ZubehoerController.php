<?php
namespace DslFactory\DslProdukte\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
 * ZubehoerController
 */
class ZubehoerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {


    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->zubehoerRepository  = $this->objectManager->get('DslFactory\\DslProdukte\\Domain\\Repository\\ZubehoerRepository');
    }

	/**
	 * action list
	 * 
	 * @return void
	 */
	public function listAction() {
		$zubehoers = $this->zubehoerRepository->findAll();
		$this->view->assign('zubehoers', $zubehoers);
	}

	/**
	 * action show
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer
	 * @return void
	 */
	public function showAction(\DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer) {
		$this->view->assign('zubehoer', $zubehoer);
	}

}