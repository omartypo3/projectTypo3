<?php
namespace BravoBuero\BbPortfolio\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
class BoostrapcontainerViewHelper extends AbstractViewHelper {

	public function initializeArguments(): void
	{
		$this->registerArgument('data', 'string', '', true);
		$this->registerArgument('key', 'string', '', true);
	}
    /**
	*
	* @return string
	*/
	public function render()
	{
		$input = $this->arguments['data'];
		$key = $this->arguments['key'];
		$flexformArray = GeneralUtility::xml2array($input);
		// Make sure parsing worked
		if (!is_array($flexformArray) || 
			!isset($flexformArray['data']['sDEF']['lDEF'][$key]['vDEF'])) {
			return '';
		}

		return $flexformArray['data']['sDEF']['lDEF'][$key]['vDEF'];
		
		
	}
}
