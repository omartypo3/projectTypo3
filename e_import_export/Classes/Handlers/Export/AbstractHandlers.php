<?php
namespace Emagineurs\EImportExport\Handlers\Export;
use Emagineurs\EImportExport\Domain\Model\Field;
use Emagineurs\EImportExport\Utility;


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

abstract class AbstractHandlers extends \Emagineurs\EImportExport\Handlers\AbstractHandlers {
	/**
	 * export the file to the $outputHandle stream
	 * 
	 * @access public
	 * @return void
	 */
	public function export() {
		$this->prepare();
		$this->format();
		$this->write();
	}
	
	/**
	 * Write header for file type
	 * 
	 * @access public
	 * @return void
	 */
	abstract public function header();
	
	/**
	 * Build the file content
	 * 
	 * @param resource|null $outputHandle
	 * @access protected
	 * @return void
	 */
	abstract protected function write($outputHandle = null);
	
	/**
	 * read and parse the configuration
	 * 
	 * @access protected
	 * @return void
	 */
	protected function prepare(){
		$this->fields = $this->conf->getFields()->toArray();
		$this->firstTag = $this->conf->getTag();
		$this->datas = $this->conf->getFirstTable()->getDatas();
	}
	
	/**
	 * build an usable array from datas get by using get() func
	 * 
	 * @access protected
	 * @return void
	 */
	protected function format(){
		$datas = [];
		foreach($this->datas as $item){
			$this->processField($item, $datas, $this->fields);
		}

		$this->datas = $datas;
	}
	
	/**
	 * Modify the build table for given fields
	 * 
	 * @param mixed $valueInit This is the global value of the row
	 * @param array $buildTable This is the array were the datas are stored
	 * @param array $fields A list of \Emagineurs\EImportExport\Domain\Model\Field
	 * @param string $valuechanged If the value has been modified, this is the new value
	 * @access protected
	 * @return array A reference to the given $buildtable
	 */
	protected function processField($valueInit, &$buildTable, $fields, $valuechanged = null){
		$itemNumber = $this->itemNumber($buildTable);
		foreach($fields as $field){
			$ifEmpty = $field->getIfempty();
			$type = $field->getType();
			
			if(isset($valuechanged) && $valuechanged != ""){
				$value = $valuechanged;
			}else{
				$value = $this->getValue($valueInit, $field);
			}
			
			$dataProcessCase = $this->processFieldType($type, $value, $field);
			$wrapData = $this->stdWrap($dataProcessCase, $field);
			
			$arrcheck = $field->getArrcheck();
			$buildTable = $this->insertData($itemNumber, $field->getName(), $wrapData, $buildTable, $arrcheck, $ifEmpty);
		}
		
		return $buildTable;
	}

	/**
	 * Get the correct information from a field, detect the  field type and process the correct traitment
	 * 
	 * @param integer $type The field type, 0 for value, 1 for relation, 3 for time, 4 for file, 5 for fixed value
	 * @param mixed $value The value if it is a value type, the file if it is a file type
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @access protected
	 * @return string The value of the field
	 */
	protected function processFieldType($type, $value, $field) {
        $data = "";

		switch($type){
			case 0: //value
				$data = $value;
				break;
			case 1: //relation
				$datasTable = $field->getRelation()->getDatas($value);
				$datavalue = $this->processFieldRelation($datasTable, $field, $datavalue);
				$data = $this->postProcessing($field, $datavalue);
				break;
			case 3: //time
				$data = date_format($value, $field->getFormat());
				break;
			case 4: //file
				break;
			case 5: //fixed value
				$data = ($this->getFixedValue($field));
				break;
		}
		return $data;
	}

    /**
     * insert $data into $buildTable
     *
     * @param integer $itemNumber The index of the processed item in the buildtable array
     * @param string $field The name attribute of the \Emagineurs\EImportExport\Domain\Model\Field
     * @param mixed $data The data that will be inserted
     * @param array $buildTable This is the array were the datas are stored
     * @param $arrcheck
     * @param mixed $ifEmpty value if field value is empty
     * @return array A reference to the given $buildtable
     * @access protected
     */
	protected function insertData($itemNumber, $field, $data, &$buildTable, $arrcheck, $ifEmpty = null){
		$fields = explode('.', $field);
		$fields = array_reverse($fields);
		foreach($fields as $fieldTmp){
			$data = array($fieldTmp => $data);
		}
		$key = key($data);
		$val = current($data);
		
		if(is_string($val)){
			$val = htmlspecialchars($val);
		}
				
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

		if(is_array($val) && key($val)==0 && $arrcheck == 1 && is_array($val[0])){
			$array_rework = [];
			reset($val);
			$first = $val[0];
			foreach ($first as $keydata => $dataarray){
			   $array_rework[$keydata] = $dataarray;
			}
			$buildTable[$itemNumber][$key] = $array_rework;
		}
		
		if(is_array($val) && is_array($buildTable[$itemNumber][$key])){
			$buildTable[$itemNumber][$key] = array_merge_recursive($buildTable[$itemNumber][$key], $val);
		}elseif(!is_array($val) && !empty($buildTable[$itemNumber][$key])){
			$buildTable[$itemNumber][$key] .= $val;
		}else{
			$buildTable[$itemNumber][$key] = $val;
		}

		return $buildTable;
	}
	
	/**
	 * The processFieldType function behaviour for relation type, you can use inheritance to create new behaviour for specific handlers
	 * 
	 * @param array $datas An array of an sql row
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @access protected
	 * @return string The value of the field
	 */
	protected function processFieldRelation($datas, $field, $datavalue){
          
		$relationProcessing = $field->getUserpost();
                
		foreach($datas as $item){
                    
			if(!empty($relationProcessing)){ 
				$processingArray = explode(";", $relationProcessing);   
				$valuechanged = ($this->isFunctionExist($processingArray))? $this->valueProcessing($processingArray, $item, $field) : null;  
			}else{ 
				$valuechanged = null;
			}
		
			$data = $this->processField($item, $datavalue, $field->getMultiple(), $valuechanged);
                        
            
		}
                return $data;
	}
	
	/**
	 * The processFieldType function behaviour for relation type, you can use inheritance to create new behaviour for specific handlers
	 * 
	 * @param array $valueInit This is the global value of the row
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @access protected
	 * @return string The value of the field
	 */
	protected function getValue($valueInit, $field){
		list(, $key) = explode('.', $field->getTablefield());
		return $valueInit[$key];
	}
	
	/* THE FOLLOWING METHODS HAVE TO BE REWRITED */
	
	/**
	 * The processFieldType function behaviour for relation type, you can use inheritance to create new behaviour for specific handlers
	 * 
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @param mixed $data the value of the record
	 * @access protected
	 * @return string The post-processed value
	 */
	protected function postProcessing($field, $data){
		$relationProcessing = $field->getUserpost();
		$function = explode(";", $relationProcessing);
		$result = $data;
		if(count($function)>0 && $function[0] != "UserFunc" &&  method_exists($this, $function[0])){
			 $result = call_user_func_array(array($this, $function[0]),array($data, $function[1]));
		}elseif(count($function) > 4 &&  method_exists($this, $function[3])){
			$result = call_user_func_array(array($this, $function[3]),array($data, $function[4]));
		}
		return $result;
	}
	
	/**
	 * Return true if the given function name is a valid UserFunc function
	 * 
	 * @param string $function The function that will process the value as an array formated as ['Class name', 'method name', additional_param]
	 * @access protected
	 * @return true if the function exists, false otherwise
	 */
	protected function isFunctionExist($function){
		return count($function) > 2 && $function[0] == "UserFunc" && method_exists($this, $function[1]);
	}

	/**
	 * Return true if the given function name is a valid UserFunc function
	 * 
	 * @param array $function The function that will process the value as an array formated as ['Class name', 'method name', additional_param]
	 * @param array $item This is the global value of the row
	 * @param Field $field The field model object
	 * @access protected
	 * @return string the processed value
	 */
	protected function valueProcessing($function, $item, $field){
		////A modifier, le valuechanged est écrasé et la fonctionnalité est très mal pensé
		$valuechanged = "";
		foreach($field->getMultiple() as $object){
			$object = $this->getValue($item, $object);
			$valuechanged = call_user_func_array(array($this, $function[1]), array($object, $function[2]));
		}
		return $valuechanged;
	}
}
