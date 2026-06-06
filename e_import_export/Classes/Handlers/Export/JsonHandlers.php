<?php
namespace Emagineurs\EImportExport\Handlers\Export;


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
 * The repository for Confs
 */
class JsonHandlers extends AbstractHandlers {
	/**
	 * Write header for file type
	 * 
	 * @access public
	 * @return void
	 */
	public function header(){
		header('Content-Type:application/json;charset=utf-8');
		header('Content-Disposition: attachment; filename=data.json');
	}

    /**
     * Build the file content
     *
     * @param resource|null $outputHandle the output stream
     * @access protected
     * @return void
     */
	protected function write($outputHandle = null){
		$dataFinal = $this->datas;
		
		//Tag correction
		if($this->firstTag !=""){
			$tags = explode('.', $this->firstTag);
			$fields = array_reverse($tags);

			foreach($fields as $fieldTmp){
				$dataFinal = array($fieldTmp => $dataFinal);
			}
			 
		}

		fputs($outputHandle, json_encode($dataFinal, JSON_PRETTY_PRINT));
	}		

	/*protected function processField($valueInit, &$buildTable, $champs, $valuechanged = null){
		$itemNumber = $this->itemNumber($buildTable);
		foreach($champs as $champ){
			$field = $this->getField($champ);
			$type = $champ->getType();
			if(isset($valuechanged) && $valuechanged!=""){
					$value = $valuechanged;
			}else{
					$value = $this->getValue($valueInit, $champ);
			}
			$ifEmpty = $champ->getIfempty();
			$dataProcessCase = $this->processFieldType($type, $value, $champ, $field, $itemNumber);
		   
			$arrcheck = $champ->getArrcheck();
			$wrapData = $this->stdWrap($dataProcessCase, $champ);
			$data = $this->formatInline($wrapData, $champ);
			 
			$buildTable = $this->insertData($itemNumber, $field, $data, $buildTable, $arrcheck, $ifEmpty);
		}
		return $buildTable;
	}
	
	
	public function processFieldType($type, $value, $champ, $field, $itemNumber){
		switch($type){
			case 0: //value
				$data = $value;
				break;
			case 1: //relation
				$datasTable = $champ->getRelation()->getDatas($value);
				$datavalue = $this->processFieldRelation($datasTable, $champ, $datavalue);
				$dataProcessingField = $this->forceField($datavalue, $champ);
				$data = $this->postProcessing($champ, $dataProcessingField);
				break;
			case 3: //time
				$data = \Emagineurs\EImportExport\Utility::getTimeStamp($value, $champ->getFormat());
				break;
			case 4: //file
				$data = '';
				$file = $value;
				$this->linkFile($file, $champ, $itemNumber, $field);
				break;
			case 5: //fixed value
				$data = $this->getFixedValue($champ);
				break;
			}
			
		return $data;
	}
	
	public function insertData($itemNumber, $field, $data, &$buildTable, $arrcheck, $ifEmpty){
		$fields = explode('.', $field);
		$fields = array_reverse($fields);
		$dataFinal = $data; 
		foreach($fields as $fieldTmp){
			$dataFinal = array($fieldTmp => $dataFinal);
		}
		$key = key($dataFinal);
		$val = current($dataFinal);

		if($ifEmpty > 0 && (empty($val) || (is_array($val) && count($val)==0))){		
			switch($ifEmpty){
				case 1:	
					$val = null; // array('NULL', 1),
					break;
				case 2:	
					$val = [];// array('ARRAY', 2),
					break;
				case 3:	
					$val = ''; // array('EMPTY', 3),
					break;
			}
		}

		$array_rework = [];
		if(is_array($val) && key($val)==0 && $arrcheck == 1 && is_array($val[0])){
			$first = reset($val);
			$first = $val[0];
			foreach ($first as $keydata => $dataarray){
			   $array_rework[$keydata] = $dataarray;
			}
			$buildTable[$itemNumber][$key] = $array_rework;

		}elseif(is_array($val) && is_array($buildTable[$itemNumber][$key])){
			$buildTable[$itemNumber][$key] = array_merge_recursive($buildTable[$itemNumber][$key], $val);
		}elseif(!is_array($val) && !empty($buildTable[$itemNumber][$key])){
			$buildTable[$itemNumber][$key] .= $val;
		}else{
			$buildTable[$itemNumber][$key] = $val;
		}

		return $buildTable;
	}
		
	/////Correction pour faire en sorte que les arrays qui ne contienne qu'une valeure puisse s'afficher en ligne
	//pareil, fonctionnalité mal pensé, à modifier
	public function formatInline($data, $champ){
		if(is_array($data) && count($data)==1 && empty($champ->getForcefield()) && is_array($data[0])){
			$keys = array_keys($data[0]);
			foreach ($keys as $key){
				if(empty($key)){
					$data = implode($data[0]);
				}
			}
		}
		return $data;
	}
	
	///// à revoir, non fonctionnel
	public function forceField($datas, $champ){
		$result = $datas;
		if(count($datas) ==0 && $champ->getForcefield()){
			$result = array($this->setEmptyRelation($champ));
		}
		return $result;
	}*/
}
	
