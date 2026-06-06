<?php
namespace Emagineurs\ECalameoPublisher\Service;

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
use Emagineurs\ECalameoPublisher\Utility\TemplateUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UserItemFunc {
	/**
	 * Display every checkbox used to select te documents into  the flexform
	 * @param array $params
	 * @param object|null $ref
	 * @return string
	 */
	public function selectDocuments(array &$params, $ref = null): string {
		/** @var CalameoService $ecpublish */
		$ecpublish = GeneralUtility::makeInstance(CalameoService::class);
		$ecpublish->ecpublish();

		$pdfList = array();
		foreach($ecpublish->getList() as $id => $pdf) {
			$params['items'][] = array($pdf['Name'], $id);

			$pdfList[] = array(
				'id' => $id,
				'name' => $pdf['Name'],
				'thumbUrl' => $pdf['ThumbUrl'],
				'selected' => strpos($params['itemFormElValue'], $id) !== false,
			);
		}

		$assigments = array(
			'pdfList' => $pdfList,
			'itemFormElValue' => $params['itemFormElValue'],
			'itemFormElName' => $params['itemFormElName'],
			'fieldChangeFunc' => $params['fieldChangeFunc'][0],
		);

		/** @var TemplateUtility $templateUtility */
		$templateUtility = GeneralUtility::makeInstance(TemplateUtility::class);
		$assigments['script'] = $templateUtility->getTemplateContents('EXT:e_calameo_publisher/Resources/Private/Templates/Service/SelectDocuments.js', $assigments);
		$assigments['style'] = $templateUtility->getTemplateContents('EXT:e_calameo_publisher/Resources/Private/Templates/Service/SelectDocuments.css', $assigments);

		return $templateUtility->getTemplateContents('EXT:e_calameo_publisher/Resources/Private/Templates/Service/SelectDocuments.html', $assigments);
	}

	/**
	 * Display a checkbox to select every documents into the cameleo flexform
	 * @param array $params
	 * @param object|null $ref
	 * @return string
	 */
	public function selectAllDocuments(array &$params, $ref = null): string {
		return '<input type="checkbox" value="" onchange="javascript: return selectAllPdf(this.checked);" />';
	}
}