<?php

namespace Emagineurs\ECalameoPublisher\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ian SEBBAGH <vscharpen@e-magineurs.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class'Calameo Publisher' for the 'e_calameo_publisher' extension.
 *
 * @author	Vincent Scharpen <vscharpen@e-magineurs.com>
 * @package	e_calameo_pulisher
 * @license http://www.gnu.org/licenses/lgpl.html
 * 			GNU Lesser General Public License, version 3 or later
 */
class TemplateUtility
{

	public function __construct(protected ViewFactoryInterface $viewFactory)
	{
	}
	/**
	 * Process a template and return the content of the template.
	 * @param string $template the template path
	 * @param array $assigns Assign array that you could use with assignMultiple function of classic view
	 * @param ServerRequestInterface|null $request Optional request object
	 * @return string the processed file contents
	 */
	public function getTemplateContents(string $path, array $assigns, ?ServerRequestInterface $request = null): string
	{
		// Create ViewFactoryData with the template path
		$viewFactoryData = new ViewFactoryData(
			templatePathAndFilename: $path,
			request: $request
		);

		$view = $this->viewFactory->create($viewFactoryData);

		$view->assignMultiple($assigns);

		// Render and return the template
		return $view->render();
	}
}