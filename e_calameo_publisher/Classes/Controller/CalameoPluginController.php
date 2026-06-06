<?php

namespace Emagineurs\ECalameoPublisher\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Dominique Feyer <dfeyer@ttree.ch>, ttree ltd
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
use Emagineurs\ECalameoPublisher\Service\CalameoService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;


class CalameoPluginController extends ActionController
{
	public function __construct(protected CalameoService $calameoService)
	{}
	public function indexAction(): ResponseInterface
	{
		$calameoPublish = $this->calameoService;
		$calameoPublish->ecpublish();

		$this->settings['width'] = !empty($this->settings['width']) ? $this->settings['width'] : 'auto';
		$this->settings['height'] = !empty($this->settings['height']) ? $this->settings['height'] : 'auto';

		$documents = array();
		if (!empty($this->settings['documentSelection'])) {
			$liste = explode(',', $this->settings['documentSelection']);
			if (is_array($liste)) {
				foreach ($liste as $item) {
					$documents[] = $calameoPublish->getDocumentInformations($item);
				}
			}
		}

		$this->view->assign('documents', $documents);
		$this->view->assign('settings', $this->settings);
		
		return $this->htmlResponse();
	}
}
