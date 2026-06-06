<?php
namespace DslFactory\DslProdukte\ViewHelpers;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */
/**
 *	Wraps some of the basic Typolink settings in a viewhelper. Good for rendering links to pages and page titles
 *	when all you have is the page id.
 */
class FileSizeViewHelper extends AbstractViewHelper {

	/**
	 * Renders the size of a file using \TYPO3\CMS\Core\Utility\GeneralUtility::formatSize
	 *
	 * @param string $file Path to the file
	 * @param string $format Labels for bytes, kilo, mega and giga separated by vertical bar (|) and possibly encapsulated in "". Eg: " | K| M| G" (which is the default value)
	 * @param boolean $hideError Define if an error should be displayed if file not found
	 * @param integer $fileSize File size
	 * @return string
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException
	 */
	public function render($file = NULL, $format = '', $hideError = FALSE, $fileSize = NULL) {

		if (!is_file($file)) {
			$errorMessage = sprintf('Given file "%s" for %s is not valid', htmlspecialchars($file), get_class());
			\TYPO3\CMS\Core\Utility\GeneralUtility::devLog($errorMessage, 'news', \TYPO3\CMS\Core\Utility\GeneralUtility::SYSLOG_SEVERITY_WARNING);

			if (!$hideError) {
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException(
					'Given file is not a valid file: ' . htmlspecialchars($file));
			}
		}


		if ($fileSize === NULL) {
			$result = $this->formatSize(filesize($file), $format);
		} else {
			$result = $this->formatSize($fileSize, $format);
		}

		return $result;
	}
	
		/**
	 * Formats the input integer $sizeInBytes as bytes/kilobytes/megabytes (-/K/M)
	 *
	 * @param integer $sizeInBytes Number of bytes to format.
	 * @param string $labels Labels for bytes, kilo, mega and giga separated by vertical bar (|) and possibly encapsulated in "". Eg: " | K| M| G" (which is the default value)
	 * @return string Formatted representation of the byte number, for output.
	 */
	static public function formatSize($sizeInBytes, $labels = '') {
		// Set labels:
		if (strlen($labels) == 0) {
			$labels = ' | K| M| G';
		} else {
			$labels = str_replace('"', '', $labels);
		}
		$labelArr = explode('|', $labels);
		// Find size:
		if ($sizeInBytes > 900) {
			// GB
			if ($sizeInBytes > 900000000) {
				$val = $sizeInBytes / (1024 * 1024 * 1024);
				return number_format($val, ($val < 20 ? 1 : 0), ',', '') . $labelArr[3];
			} elseif ($sizeInBytes > 900000) {
				// MB
				$val = $sizeInBytes / (1024 * 1024);
				return number_format($val, ($val < 20 ? 1 : 0), ',', '') . $labelArr[2];
			} else {
				// KB
				$val = $sizeInBytes / 1024;
				return number_format($val, ($val < 20 ? 1 : 0), ',', '') . $labelArr[1];
			}
		} else {
			// Bytes
			return $sizeInBytes . $labelArr[0];
		}
	}


}


?>