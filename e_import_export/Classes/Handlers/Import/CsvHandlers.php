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
 * CsvHandlers
 */
class CsvHandlers extends AbstractHandlers {
    /**
     * Read the contents from the file, store it into $this->dataArray, an array with a specific format, the format is an array of object with $obj->key = $value
     *
     * @access public
     * @param resource $inputHandle the input stream
     */
	public function read($inputHandle){
		$this->dataArray = [];
		$itemArray = [];
		$arrayPrimaire = [];

		while (($datas = fgetcsv($inputHandle,0,";")) !== FALSE) {
			$arrayPrimaire[]=$this->encodeUtf8($datas);
		}
		
		$arrayKeys = $arrayPrimaire[0];
		unset($arrayPrimaire[0]);
		foreach($arrayPrimaire as $primary){
			$iterator = 0;
			foreach($primary as $internalArray){
				$itemArray[trim($arrayKeys[$iterator])] = trim($internalArray);
				$iterator++;
			}
			$this->dataArray[] = (object)$itemArray;
		}
	}

    /**
     * Encode a string array into UTF-8 format
     *
     * @access public
     * @param $datas array of input datas
     * @return array The encoded array
     */
	public function encodeUtf8($datas){
		$detectOrder = 'UTF-8,ISO-8859-1';
		$array_encode = [];
		foreach($datas as $encoding){ 
				$encode_code = mb_detect_encoding($encoding, $detectOrder);
				if($encode_code && $encode_code =="ISO-8859-1"){
					$array_encode[] = mb_convert_encoding($encoding, 'UTF-8', 'ISO-8859-1');
				}else{
					$array_encode[] = $encoding;
}
		}
		return $array_encode;
	}
}