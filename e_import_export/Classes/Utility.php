<?php
namespace Emagineurs\EImportExport;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Dispatcher;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentTypeException;
use TYPO3\CMS\Extbase\Mvc\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Request;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageGenerator;
use TYPO3\CMS\Frontend\Utility\EidUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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
 
class Utility {
	/**
	 * Init parameters for the ajax handler
	 * 
	 * @param int $id The value from request 'id' parameter
	 * @static
	 * @access public
	 * @return TypoScriptFrontendController $GLOBALS['TSFE'] the frontend controller for the ajax handler
	 */
	public static function initAjax($id = null){
		if(!$id){
			$request = $GLOBALS['TYPO3_REQUEST'] ?? null;
			$id = $request ? ($request->getQueryParams()['id'] ?? $request->getParsedBody()['id'] ?? 0) : 0;
		}
		$id = intval($id);
		$GLOBALS['TSFE'] = GeneralUtility::makeInstance(TypoScriptFrontendController::class, $GLOBALS['TYPO3_CONF_VARS'], $id, 0);
		EidUtility::initLanguage();
		EidUtility::initTCA();
		$GLOBALS['TSFE']->initFEuser();
		$GLOBALS['TSFE']->set_no_cache();
		$GLOBALS['TSFE']->checkAlternativeIdMethods();
		$GLOBALS['TSFE']->determineId();
		$GLOBALS['TSFE']->initTemplate();
		$GLOBALS['TSFE']->getConfigArray();
		$GLOBALS['TSFE']->cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
		$GLOBALS['TSFE']->settingLanguage();
		$GLOBALS['TSFE']->settingLocale();
		PageGenerator::pagegenInit();
		return $GLOBALS['TSFE'];
	}

	/**
	 * Call an action among extbase extensions
	 * 
	 * @param array $conf An array that contain conf informations, you should set keys ['extensionName'], ['vendor'], ['controller'], ['action'], ['arguments'] and optionnaly ['pluginName']
	 * @static
	 * @access public
	 * @return string $content More response content
	 */
	public static function callExtbaseAction($conf){
		
	
		$class = "Emagineurs\\EImportExport\\Controller\\" . $conf['controller'] ."Controller";

		$controller = GeneralUtility::makeInstance($class); // e.g. ModuleController::class

		// Determine action method
		$actionMethod = $conf['action'] . 'Action';

		if (!method_exists($controller, $actionMethod)) {
			throw new \RuntimeException(
				sprintf('Action "%s" not found in controller "%s"', $actionMethod, $conf['controller'])
			);
		}

		
		$args = $conf['arguments'] ?? [];
		$content = $controller->{$actionMethod}(...array_values($args));

		// Call the action
		return $content;
	
	}
	
	/**
	 * Get the timestamp of $date by using format
	 * 
	 * @param string $date the date as string
	 * @param string $format the format of the given $date, see http://www.w3schools.com/php/func_date_date_format.asp for more informations
	 * @throws InvalidArgumentTypeException if date and the format are incompatibles
	 * @static
	 * @access public
	 * @return int The desired timestamp
	 */
	public static function getTimeStamp($date, $format){
		$dateObj = \DateTime::createFromFormat($format, $date);
		
		if(!$dateObj){
			self::throwError('Error while generating timestamp, incorrect format or date', 66925);
		}

        return $dateObj->getTimestamp();
	}
	
	/**
	 * Store the file into the typo3 file system, operate into the fileadmin folder
	 * 
	 * @param string $file the file name
	 * @param string $folder the folder where the file will be stored (use / as separator), the root folder is the fileadmin folder
	 * @param \TYPO3\CMS\Core\Resource\ResourceStorage $storage the resource storage where the file should be stored, if null, the storage with uid 1 is used
	 * @static
	 * @access public
	 * @return int The new file record uid
	 */
	public static function createFile($file, $folder, $storage = null){
        if(!$file) {
            self::throwError('Error while storing a file', 66926);
        }

        if(!$storage){
            $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
            $storage = $storageRepository->findByUid(1);
        }
        $fileName = trim(basename($file));
        if(substr($folder, -1)!= '/'){
            $folder .= '/';
        }
        $pathFile = 'fileadmin/'.$folder.$fileName;

        if(file_exists(GeneralUtility::getIndpEnv('TYPO3_DOCUMENT_ROOT').'/'.$pathFile)){
            $fileObject = ResourceFactory::getInstance()->retrieveFileOrFolderObject($pathFile);
        }else{
            $saveFolder = $storage->getFolder($folder);
            $fileObject = $storage->addFile($file, $saveFolder);
        }

        return $fileObject->getUid();
	}
	
	
	
	public static function handleFileUtility($file, $saveFolder, $name){
		$fileName = basename($file);
                
                
		if(!empty($fileName)){
			$destFile = PATH_site.'uploads/'.$fileName;
                        
			@copy($file, $destFile);
			@rename(PATH_site.'uploads/'.$fileName, PATH_site.'uploads/'.$name);
			$destFile = PATH_site.'uploads/'.$name;
			if(is_file($destFile)){
				if(!$this->storage){
                    $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\StorageRepository::class);
					$this->storage = $storageRepository->findByUid(1);
				}
				$fileUid = \Emagineurs\EImportExport\Utility::creatFile($destFile, $saveFolder, $this->storage);
				//// si on upload un fichier qui a déjà été importé, je crois que le fichier est automatiquement renommé en _01.tmp ou un truc du genre. Du coup le unlink ne fonctionne pas. à vérifier. Mettre un controle pour éviter d'importer un fichier qui existe déjà.
				@unlink($destFile);
				return $fileUid;
			}
		}
		
		return false;
	}
	
	/**
	 * Create a file reference into the sys_file_reference table
	 * 
	 * @param string $table The table name
	 * @param int $contentUid the uid of your content record
	 * @param string $pid the page id of your content record
	 * @param array $filesToLink the files that should be linked to the reference
	 * @static
	 * @access public
	 * @return void
	 */
	public static function createFileRef($table, $contentUid, $pid, $filesToLink){
		$datas = array();
        $genericRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EImportExport\Domain\Repository\GenericRepository::class);
		foreach($filesToLink as $field => $fileUids){	
			foreach($fileUids as $fileUid){
				$datas = array(
					'uid_local' => $fileUid,
					'uid_foreign' => $contentUid,
					'tablenames' =>  $table,
					'fieldname' => $field,
					'pid' => $pid,
					'table_local' => 'sys_file',
				);
				if(!$genericRepository->find('sys_file_reference', $datas)){
					$tcemainId = uniqid();
					$newDatas['sys_file_reference']['NEW'.$tcemainId] = $datas;
                    /** Modif Xavier Debut **/
					$datas[$table][$contentUid] = array($field => 'NEW'.$tcemainId);
                    /** Modif Xavier fin **/
				}
			}
		}
		$genericRepository->handleRecords($newDatas);
	}

    /**
     * Throw a php error
     *
     * @param string $message the error message
     * @param int $code the error code
     * @throws InvalidArgumentTypeException
     * @static
     * @access public
     */
	public static function throwError($message, $code){
		throw new InvalidArgumentTypeException(
			$message,
			$code
		);
	}
	
	/**
	 * Replace the stripped characters of a string by the associated characters
	 * 
	 * @param string $str the string
	 * @static
	 * @access public
	 * @return string $str the string without any accent
	 */
	public static function stripAccents($str){
		$caracteres = array(
			'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
			'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
			'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
			'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
			'Œ' => 'oe', 'œ' => 'oe',
			'$' => 's'
		);

		$str = strtr(trim($str), $caracteres);
		$str = strtolower($str);
		$str = str_replace(" ","",$str); $str = str_replace("-","",$str); $str = str_replace("'","",$str);

		return $str;
	}
	
	/**
	 * Get a locallang entry value located into e_import_export/Resources/Private/Language/locallang.xlf
	 * 
	 * @param string $label The label of the local lang entry
	 * @static
	 * @access public
	 * @return string the value of the locallang entry
	 */
	public static function getLL($label) {
		if(substr($label, 0, 7) != 'LLL:EXT'){
			$label = 'LLL:EXT:e_import_export/Resources/Private/Language/locallang.xlf:'.$label;
		}
		return $GLOBALS['LANG']->sL($label);
	}	
}
