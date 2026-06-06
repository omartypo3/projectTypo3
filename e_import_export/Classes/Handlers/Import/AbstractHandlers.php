<?php
namespace Emagineurs\EImportExport\Handlers\Import;
use Emagineurs\EImportExport\Domain\Model\Field;
use Emagineurs\EImportExport\Domain\Repository\GenericRepository;
use Emagineurs\EImportExport\Utility;
use TYPO3\CMS\Core\Database\ConnectionPool;
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

abstract class AbstractHandlers extends \Emagineurs\EImportExport\Handlers\AbstractHandlers {
	/**
	 * genericRepository
	 *
	 * @var GenericRepository
	 */
	protected $genericRepository;

	/**
	 * Import the input file (from the conf url) to the database
	 * 
	 * @access public
	 * @return string
	 */
	public function import($url="") {
		$this->prepare();
		
		$inputHandle = $this->openFile($this->conf->getUrl());
		
		$this->read($inputHandle);
		$this->format();

		$return = $this->insert();
		
		fclose($inputHandle);
		
		return $return;
	}

	/**
	 * Get file content
	 *
	 * @param string $url
	 * @access public
	 * @return resource|boolean the file stream, false if couldn't open the file
	 */
	public function openFile($url) {
		return fopen($this->conf->getUrl(), 'r');
	}

    /**
     * Read the contents from the file, store it into $this->dataArray, an array with a specific format, the format is an array of object with $obj->key = $value
     *
     * @access public
     * @param resource $inputHandle the input stream
     */
	abstract protected function read($inputHandle);
	
	/**
	 * read and parse the configuration, change the query settings
	 * 
	 * @access protected
	 * @return void
	 */
	protected function prepare(){
		ini_set('max_execution_time', -1);
		ini_set('memory_limit', '3G');

		$this->genericRepository = GeneralUtility::makeInstance(GenericRepository::class);
				 
		$this->fields = $this->conf->getFields()->toArray();
		
		$this->firstTag = $this->conf->getTag();
		$this->uniqfield = $this->conf->getUniqfield();
		$this->forceadd = $this->conf->getForceadd();
		
		$tablesStorage = $this->conf->getTables()->toArray();
		$tables = array();
		foreach($tablesStorage as $table){
			$tables[] = $table->getName();
		}

		$this->table = implode(',', $tables);
	}
	
	/**
	 * Insert/update the datas into the database (todo : add a field into the field conf : "is uniq", to guess if we need to insert or update)
	 * 
	 * @access protected
	 * @return array with 3 elements, ['status'] equals 'ok' if eveithings worked fine, ['create'] is an integer with the count of the inserted rows and ['update'] is the same for updated rows
	 */
	protected function insert(){
		$return = array();
		$return['status'] = 'ok';
		$return['create'] = 0;
		$return['update'] = 0;
		
		foreach($this->datas as $key => $data){
			$isDataExist = false;
			/// Vérifie que la ligne n'existe pas déjà en base (sauf pour les relations MM, ça a l'air relou pour le peu que ça apporte)
			if(!empty($this->forceadd)){
				$isDataExist = $this->isDataExist($this->table, $data);
			}

			if(!$isDataExist){
				//Vérifie que l'entrée existe, définis sur des champs unique. Si c'est le cas, on met à jour les autres champs non unique de l'entrée
				$dataUid = $this->getDataUid($this->table, $data);
				if($dataUid){
					$this->genericRepository->update($dataUid, $this->table, $data, true);
					$return['update']++;
				}else{
					$dataUid = $this->genericRepository->add($this->table, $data, true);
					$return['create']++;
				}
				if(is_array($this->filesToLink[$key])){
					$pid = empty($data['pid']) ? 0 : $data['pid'];
					Utility::createFileRef($this->table, $dataUid, $pid, $this->filesToLink[$key]);
				}
			}
		}
		return $return;
	}
	
	/**
	 * Get the uid of a database record
	 * 
	 * @param string $table The table name
	 * @param array $data An array with structure like ['key'] = $value that describe a where request like "WHERE key = value"
	 * @access protected
	 * @return integer The uid of the record
	 */
	protected function getDataUid($table, $data){
		$uniqfields = explode(',', strtolower($this->uniqfield));
		$where = array();
		foreach($uniqfields as $field){
			list($tableF, $field) = explode('.', $field);
			if($tableF != $table || empty($data[$field]))
					return false;
			$where[$field] = $data[$field];
		}
		
		return $this->genericRepository->find($table, $where, ' AND deleted = "0" ');
	}

	/**
	 * Check if a row is present into the database by giving values, the row is choosen if the values of each field match the given datas array
	 *
	 * @param string $table The table name
	 * @param array $data An array with structure like ['key'] = $value that describe a where request like "WHERE key = value"
	 * @access protected
	 * @return integer The uid of the record
	 */
	public function isDataExist($table, $datas){
		foreach($datas as $key => $data) {
			$tcaConfigField = (\TYPO3\CMS\Backend\Utility\BackendUtility::getTcaFieldConfiguration($table, $key));

			if(isset($tcaConfigField['MM']) && !empty($tcaConfigField['MM'])) {
				unset($datas[$key]);
			}
		}

		$isDataExist = $this->genericRepository->find($table, $datas, ' AND deleted = "0" ');

		return $isDataExist;
	}
    
	/**
	 * Get the correct information from a field, detect the  field type and process the correct traitment
	 * 
	 * @param integer $type The field type, 0 for value, 1 for relation, 3 for time, 4 for file, 5 for fixed value
	 * @param mixed $value The value if it is a value type, the file if it is a file type
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @param integer $itemNumber The index of the processed item in the buildtable array
	 * @param \stdclass $item The record object (same format as the ones stored into $this->dataArray)
	 * @access protected
	 * @return string The value of the field
	 */
	protected function processFieldType($type, $value, $field, $itemNumber, $item) {
		$data = "";
		switch($type){
			case 0: //value
				$data = $value;
				break;
			case 1: //relation
				$table = $field->getRelation()->getName();
				$data = $this->fieldProcessingForRelation($field, $value, $table, $item);
				break;
			case 3: //time
				$data = Utility::getTimeStamp($value, $field->getFormat());
				break;
			case 4: //file
				$data = '';
				$file = $value;
				$this->linkFile($file, $field, $itemNumber);
				break;
			case 5: //fixed value
				$data = $this->getFixedValue($field);
				break;
		}
		return $data;
	}
	
	/**
	 * Turn the data stored into $this->dataArray as usable datas (array), store it into $this->datas
	 * 
	 * @access protected
	 * @return void
	 */
	protected function format(){
		$tags = explode('.', $this->firstTag);
		foreach($tags as $item){
			if(isset($this->dataArray->{$item})) {
				$this->dataArray = $this->dataArray->{$item};
			}
		}

		$this->datas = array();
		foreach($this->dataArray as $item){
			$this->datas = $this->processField($item, $this->datas, $this->conf->getFields()->toArray());
		}
	}
	
	/**
	 * Modify the data array for given fields
	 * 
	 * @param mixed $valueInit This is the global value of the row with the same format as the ones stocked into $this->dataArray (see read() function description)
	 * @param array $datasFinal This is the array were the datas are stored
	 * @param array $fields An array of \Emagineurs\EImportExport\Domain\Model\Field
	 * @access protected
	 * @return array A reference to the given $datasFinal
	 */
	protected function processField($valueInit, &$datasFinal, $fields){
		$itemNumber = $this->itemNumber($datasFinal);

		foreach($fields as $field){
			$type = $field->getType();
			$value = $this->getValue($valueInit, $field);
			$dataProcessCase = $this->processFieldType($type, $value, $field, $itemNumber, $valueInit);
			$data = $this->stdWrap($dataProcessCase, $field);
			$datasFinal = $this->insertData($itemNumber, $field, $data, $datasFinal);
		}
		
		return $datasFinal;
	}

	/**
	 * Add the $data value into the given field, everithing is stored into $dataFinal
	 *
	 * @param integer $num The record id number
	 * @param Field $field The field model object
	 * @param mixed $data The value that will be imported
	 * @param array $datasFinal This is the array were the datas are stored
	 * @access protected
	 * @return array A reference to the given $datasFinal
	 */
	protected function insertData($num, $field, $data, &$datasFinal){
		$key = $this->getFieldKey($field);
		
		if(!empty($data)){
			if(empty($datasFinal[$num][$key])){
				$datasFinal[$num][$key] = $data;
			}else{
				$datasFinal[$num][$key] .= $data;
			}
		}
		return $datasFinal;
	}
	
	/**
	 * The traitment of processFieldType for relation type
	 * 
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @param mixed $value The value that will be stored
	 * @param string $table The table where the value will be stored
	 * @param \stdclass $item The record object (same format as the ones stored into $this->dataArray)
	 * @access protected
	 * @return integer An integer wich is the uid of the relation record
	 */
	protected function fieldProcessingForRelation($field, $value, $table, $item){
		$array_value = explode(',', $value);
		$fieldType = count($array_value) > 1;

        $array_uid_relation = "";
		if($fieldType){
			foreach($array_value as $valuerelation){
				$array_uid_relation = $this->processValueByType($field, $value, $table,$item,$valuerelation);
			}
		}else{
			$array_uid_relation = $this->processValueByType($field, $value, $table, $item);
		}
		return $array_uid_relation;
	}
	
	/**
	 * Insert a relation into the database
	 * 
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @param mixed $value The value that will be stored
	 * @param string $table The table where the value will be stored
	 * @param \stdclass $item The record object (same format as the ones stored into $this->dataArray)
	 * @param mixed $valuerelation A param to force de $value
	 * @access protected
	 * @return integer An integer wich is the uid of the relation record
	 */
	protected function processValueByType($field, $value, $table, $item, $valuerelation = ''){
		$hasuserPost = $this->hasUserPost($field);
		
		if($hasuserPost){
			$value_test_type = empty($valuerelation) ? $value : $valuerelation;
			$type_value = ctype_digit(trim($value_test_type));
			
			$array_uid_relation = $this->fieldProcessing($field, $value, $type_value, $item);
		}else{
			$array_uid_relation = $this->getOrAddRecord($field, $table, $item);
		}
		return $array_uid_relation;
	}
	
	/**
	 * Check if the given field has a Relation post-processing UserFunc
	 * 
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @access protected
	 * @return true if there is a relation post-processing UserFunc fonction, false otherwise
	 */
	protected function hasUserPost($field){
		$processing_uf = $field->getUserpost();
		if(empty($processing_uf)){
			return false;
		}else{
			$processingArray = explode(";", $processing_uf); 
			return !(empty($processingArray) || $processingArray[0] != "UserFunc" || !method_exists($this, $processingArray[1]));
		}
	}
	
	/**
	 * process a field by using postuser component
	 * 
	 * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
	 * @param mixed $valuerelation The value that will be stored
	 * @param bool $type_value should be set to true if $valuerelation is an int, false if it is a string
	 * @param \stdclass $item The record object (same format as the ones stored into $this->dataArray)
	 * @access protected
	 * @return integer An integer wich is the uid of the relation record
	 */
	protected function fieldProcessing($field, $valuerelation, $type_value, $item){
		$processing_uf = $field->getUserpost();
        $processingArray = array();
		if(!empty($processing_uf)){
			$processingArray = explode(";",$processing_uf); 
		}
		$array_uid_relation = $this->execUserfunc($processingArray, $valuerelation, $type_value, $item);
		return $array_uid_relation;
	}

    /**
     * Add or get a record from the database, if the record exists, it get, otherwise it add
     *
     * @param \Emagineurs\EImportExport\Domain\Model\Field $field The field model object
     * @param string $table The table where the value will be stored
     * @param \stdclass $item The record object (same format as the ones stored into $this->dataArray)
     * @return int An integer wich is the uid of the relation record
     * @internal param mixed $value The value that will be stored
     * @internal param mixed $valuerelation A param to force de $value
     * @access protected
     */
	protected function getOrAddRecord($field, $table, $item){
        $array_key_value = array();
		foreach($field->getMultiple() as $field2){
			//// need to be modified for the case where there are multiple fields
			$type = $field2->getType(); 
			if($type == 0){
				$key = $this->getFieldKey($field2); 
				$value = $this->getValue($item, $field2); 
				$value = $this->stdWrap($value, $field2);

				$array_key_value[$key] = $value;
			}
			if($type == 5){
				$key = $this->getFieldKey($field2); 
				$value = $this->getFixedValue($field2);
				$value = $this->stdWrap($value, $field2);
				$array_key_value[$key] = $value;
			}
		} 
		$query_res = $this->getRecord($table, $array_key_value);//// need to be modified for the case where there are multiple fields
		  
		if(!empty($query_res)){
			 $uid_relation =(int)$query_res;
		}else{
			$record_uid = $this->addRecord($table, $array_key_value);
			$uid_relation =(int)$record_uid;
		}
		return $uid_relation;
	}
	
	/**
	 * Insert datas into the database
	 * 
	 * @param string $table The table name
	 * @param array $array_key_value An array with datas formated as $array['key'] = $value
	 * @access protected
	 * @return integer The record uid
	 */
	protected function addRecord($table, $array_key_value){
		if(empty($array_key_value['pid'])){
			$array_key_value['pid']=0;
		}
		$uid = $this->genericRepository->add($table, $array_key_value, true);
		return $uid;
	}
	
	/**
	 * Get a record id
	 * 
	 * @param string $table The table name
	 * @param array $array_key_value An array with datas formated as $array['key'] = $value, it will be used to build a WHERE condition like "WHERE key = value" for every $array_key_value entry
	 * @access protected
	 * @return integer The record uid
	 */
	protected function getRecord($table, $array_key_value){
		$where = '';
		
		$connectionPool = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$dbConnection = $connectionPool->getConnectionByName('Default')->getWrappedConnection()->getWrappedResourceHandle();
		
		foreach($array_key_value as $key => $value){
			$stringtMysql = mysqli_real_escape_string($dbConnection, $value);
			if (empty($stringtMysql)) {
				$stringtMysql = $value;
			} 
			if(empty($where)){
				
				$where = '`'.$key.'` = "'.$stringtMysql.'"';
			}else{
				$where .= ' AND `'.$key.'` = "'.$stringtMysql.'"';
			}
		}
		
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_eimportexport_domain_model_field');
		$res = $queryBuilder
			->select('uid')
			->from($table)
			->where(
				$where
			)
			->andWhere($queryBuilder->expr()->eq('deleted', 0))
			->andWhere($queryBuilder->expr()->eq('hidden', 0))
			->execute()
			->fetch();
		
		$query_res = $res['uid']; //// need to be modified for the case where there are multiple fields
		return $query_res;
	}
	
	/**
	 * Exec an UserFunc routine
	 * 
	 * @param string $processingArray The function that will process the value as an array formated as ['Class name', 'method name', additional_param]
	 * @param mixed $valuerelation The value that will be stored
	 * @param bool $type_value should be set to true if $valuerelation is an int, false if it is a string
	 * @param \stdclass $item The record object (same format as the ones stored into $this->dataArray)
	 * @access protected
	 * @return integer An integer wich is the uid of the relation record
	 */
	protected function execUserfunc($processingArray, $valuerelation, $type_value, $item){
		switch($type_value){
			case true:
                $valuerelation = (int) $valuerelation;
				break;
			case false:
				break;
		}
		if(!empty($processingArray) && count($processingArray)!=0 ){
			if($processingArray[0] == "UserFunc"){
				$valuerelation = $this->$processingArray[1]($valuerelation, $processingArray[2], $item); /// test
			}
		}	 
		return $valuerelation;
	}
	
	/**
	 * Get the field value of a database row
	 *
	 * @param \stdclass $value The row
	 * @param Field $field The field model object
	 * @access protected
	 * @return mixed the value
	 */
	protected function getValue($value, $field){
		$type = $field->getType();
		if($type != 5){
			$tags = explode('.', $field->getName());
			foreach($tags as $chemin){
				$value = $value->{$chemin};
			}
		}

		return $value;
	}
	
	/**
	 * Link te given field to the given file
	 * 
	 * @param string $file The file (can be a file list)
	 * @param Field $field The field model object
	 * @param integer $itemNumber the file index
	 * @access protected
	 * @return string the value
	 */
	protected function linkFile($file, $field, $itemNumber){
		if(!empty($file)){
			$fileUid = $this->handleFile($file, $field->getFormat());
			if($fileUid){
				$this->filesToLink[$itemNumber][$this->getFieldKey($field)] = $fileUid;
			}
			return $fileUid;
		}
		return "";
	}
	
	/**
	 * Link te given field to the given file
	 * 
	 * @param string $file The file (can be a file list)
	 * @param string $saveFolder the folder were to store the file
	 * @access protected
	 * @return string the value
	 */
	protected function handleFile($file, $saveFolder){
		$fileNames = [];
		$pathFiles = [];

		$multiplefile = array_map('trim', explode(",",$file));

		foreach($multiplefile as $fileName){
			$fileNames[] = basename($fileName);
			if(strlen(dirname($fileName))>1){
				$pathFiles[] = $fileName;
			}else{
				$pathFiles[] = dirname($pathFiles[0]).'/'.basename($fileName);
			}
		}

		if(!empty($fileNames) && count($fileNames)>0) {
			$iterator = 0;
			$fileUids = [];
			foreach($fileNames as $name){
				$destFile = PATH_site.'uploads/'.$name;

				// @copy($pathFiles[$iterator], $destFile);

				$ch = curl_init($pathFiles[$iterator]);
				$fp = fopen($destFile, 'wb');
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_exec($ch);
				curl_close($ch);
				fclose($fp);

				if(is_file($destFile)){
					if(!$this->storage){
						$storageRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
						$this->storage = $storageRepository->findByUid(1);
					}
					$fileUid = Utility::createFile($destFile, $saveFolder, $this->storage);

					@unlink($destFile);
					$fileUids[] = $fileUid;
				}
				$iterator ++;
			}
			return $fileUids;
		}
		return false;
	}
}
