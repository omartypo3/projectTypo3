<?php
namespace Emagineurs\EImportExport\Handlers\Import;


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

/**
 * JsonHandlers
 */
class JsonHandlers extends \Emagineurs\EImportExport\Handlers\Import\AbstractHandlers {
	/**
	 * Read the contents from the file, store it into $this->dataArray, an array with a specific format, the format is an array of object with $obj->key = $value
	 *
	 * @access public
	 * @param $inputHandle resource the input resource
	 */
	public function read($inputHandle){
		$data = stream_get_contents($inputHandle);
		$this->dataArray = json_decode($data);
	}
	
	public function getValue($valueInit, $field){
		$type = $field->getType();
		if($type!=5){
			$value = $valueInit;
			$tag = explode('.', $field->getName());
			foreach($tag as $path){
				$matches = array();
				if(preg_match('/^(\w+)\[(\w+)\]$/', $path, $matches) === 1) {
					$array = $value->$matches[1];
					$value = $array[$matches[2]];
				} else {
					$value = $value->$path;
				}
			}
		}
		return (string)$value;
	}
}
