<?php
namespace Emagineurs\EImportExport\Controller;

use Emagineurs\EImportExport\Domain\Model\Conf;
use Emagineurs\EImportExport\Handlers\Export\AbstractHandlers as ExportAbstractHandlers;
use Emagineurs\EImportExport\Handlers\Import\AbstractHandlers as ImportAbstractHandlers;
use Emagineurs\EImportExport\Utility;
use Exception;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Emagineurs\EImportExport\Domain\Repository\ConfRepository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
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

class ImportExportController extends ActionController {

	/**
	 * @var ConfRepository
	 */
	protected $confRepository;

	public function __construct(
		ConfRepository $confRepository
	) {
		$this->confRepository = $confRepository;
	}
	
	/**
	 * Main action for import_export
	 *
	 * @param integer $confuid
     * @param string $url
	 * @access public
	 * @return ResponseInterface
	 */
	public function indexAction($confuid, $url=""): ResponseInterface {
		$conf = $this->confRepository->findByUid($confuid);
		
		if(empty($conf) OR !($conf instanceof Conf)){
			throw new Exception(
				'Invalid configuration uid: '.$confuid.'. Check your configuration state.',
				1986030403);
		}

		$handler = $conf->getHandler();
		 
		if(empty($handler)){
			throw new Exception(
				'Invalid handler, null. Check your interaction and type in GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'eImportExport\'][\'Handlers\'].',
				1986030401);
		}
		if($handler instanceof ExportAbstractHandlers){
			$fp = fopen('php://output', 'w');
			$handler->header();
			$handler->export($fp);
			exit();
		}
		else if($handler instanceof ImportAbstractHandlers){
			$content = $handler->import($url);
		} else {
			throw new Exception(
				'Invalid handler "'.get_class($handler).'", must implement the \Emagineurs\EImportExport\Handlers\AbstractHandlers class.',
				1986030402);
		}
		
		
		if(!isset($content) || !$content){
			$content = array();
		} else {
			$content = serialize($content);
		}
		
		return $this->htmlResponse($content);
	}
}