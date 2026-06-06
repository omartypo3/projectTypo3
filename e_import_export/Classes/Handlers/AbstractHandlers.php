<?php
namespace Emagineurs\EImportExport\Handlers;

use Emagineurs\EImportExport\Domain\Model\Conf;
use Emagineurs\EImportExport\Domain\Model\Field;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
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

abstract class AbstractHandlers {
	protected $conf;

    /**
     * Constructor
     *
     * @param Conf $conf
     * @access public
     */
	public function __construct(Conf $conf){
		$this->conf = $conf;
	}
	
	/**
	 * Execute a TYPO3 stdWrap routine
	 * 
	 * @param string $data Input value undergoing processing in this function. Possibly substituted by other values fetched from another source.
	 * @param Field $field The field where the stdWrap is written (in the stdWrap property)
	 * @access public
	 * @return string The processed input value
	 */
	protected function stdWrap($data, $field){
		$stdWrap = $field->getStdwrap();
		if(!empty($stdWrap)){
			$tsparser = GeneralUtility::makeInstance('TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser');
			$tsparser->parse($stdWrap);
			$stdWrapParsed = $tsparser->setup;

			if($GLOBALS['TSFE']->cObj){
				$cObj = $GLOBALS['TSFE']->cObj;
			} else{
				$cObj = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
			}
			if($stdWrapParsed && $cObj){
				$cObj->setCurrentVal($data);
				$data = $cObj->stdWrap($data, $stdWrapParsed);
			}
		}
		return $data;
	}
	
	/**
	 * Get the fixed value of a fixed value field
	 * 
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field
	 * @access public
	 * @return string The value
	 */
	protected function getFixedValue($field){
		return $field->getName();
	}
	
	/**
	 * Count the number of elements into an array
	 * 
	 * @param array $datasFinal The array
	 * @access public
	 * @return number of elements in the array
	 */
	protected function itemNumber($datasFinal){
		return count($datasFinal);
	}
	
	/**
	 * Get field name from a complete field string
	 * 
	 * @param string $field The field string formated as tx_table.field
	 * @access public
	 * @return string The key
	 */
	public function getFieldKey($field){
		list(, $key) = explode('.', $field->getTablefield());
		return $key;
	}
}
