<?php
namespace Emagineurs\EImportExport;


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
use Emagineurs\EImportExport\Domain\Model\Conf;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * UserItemProcFunc 
 */
class UserItemProcFunc {
    /**
     * Get the conf title as "title [id]"
     *
     * @param array $params the typo3 array to write outputs
     * @access public
     */
	public function getConfTitle(&$params) {
		$record = BackendUtility::getRecord($params['table'], $params['row']['uid']);
		$params['title'] = $record['title'] . ' [' . $record['uid'] . ']';
	}
	
	/**
	 * Build table list for TCA 
	 * 
	 * @param array $params the typo3 array to write outputs
	 * @access public
	 * @return void
	 */
	public function getTables(&$params) {
		$tables = array();
		foreach($GLOBALS['TCA'] as $table => $conf){
			$tables[$table] = array(
				self::getLabel($table, $conf['ctrl']['title']),
				$table
			);
		}
		ksort($tables);
		foreach($tables as $item){
			$params['items'][] = $item;
		}
	}
	
	/**
	 * Build the name of a table for TCA 
	 * 
	 * @param array $params the typo3 array to write outputs
	 * @access public
	 * @return void
	 */
	public function getTableName(&$params){
		$table =  $params['row']['name'];
		if(is_array($table)) $table = reset($table);
		if(!empty($GLOBALS['TCA'][$table])){
			$params['title'] = self::getLabel($table, $GLOBALS['TCA'][$table]['ctrl']['title']);
		}
	}

    /**
     * Build table list for TCA
     *
     * @param string $key the field key
     * @param string $defaultvalue value if key was not found
     * @return string the field title
     * @internal param string $default the erturn value if key was not found
     * @access private
     */
	private static function getLabel($key, $local){
		if($GLOBALS['LANG'] && !empty($local)){
			$label = $GLOBALS['LANG']->sL($local);
		}

		if(!empty($label)){
			$key .= ' - '.$label;
		} else {
            $key .= ' - '.$local;
        }


		return $key;
	}
	
	/**
	 * Build field list for TCA 
	 * 
	 * @param array $params the typo3 array to write outputs
	 * @access public
	 * @return void
	 */
	public function getAllFields(&$params){
		$conf = $this->getParentObject($params['row']['uid'], 'FieldRepository', $params);
		$this->getAllFieldsFromConf($params, $conf);
	}
	
	/**
	 * Build file type list for TCA (different if we export or import)
	 * 
	 * @param array $params the typo3 array to write outputs
	 * @access public
	 * @return void
	 */
	public function getFileTypes(&$params){
		$record = BackendUtility::getRecord($params['table'], $params['row']['uid']);
		$interaction = ($record['interaction'] == '0') ? 'export' : 'import';
		
		foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers'][$interaction] as $key => $handlerType) {
			$params['items'][] = array($key, $key);
		}
	}
	
	/**
	 * Build field list for TCA, only conf field
	 * 
	 * @param array $params the typo3 array to write outputs
	 * @access public
	 * @return void
	 */
	public function getAllFieldsUniqField(&$params){
		$conf = $this->getParentObject($params['row']['uid'], 'ConfRepository');
		$this->getAllFieldsFromConf($params, $conf);
	}
	
	/**
	 * Build field list for TCA, this is the common part of getAllFields and getAllFieldsUniqField
	 * 
	 * @param array $params the typo3 array to write outputs
	 * @param Conf $conf
	 * @access private
	 * @return void
	 */
	private function getAllFieldsFromConf(&$params, $conf){
		$fieldsParam = array();
		
		if($conf !== null){
			$allFields = $conf->getAllFields();
			foreach($allFields as $field){
				$fieldsParam[$field] = array($field, $field);
					
				list($table, $key) = explode('.', $field);
				if(is_array($GLOBALS['TCA'][$table]) && !empty($GLOBALS['TCA'][$table]['columns'][$key]['label'])){
					$fieldsParam[$field][0] = self::getLabel($field, $GLOBALS['TCA'][$table]['columns'][$key]['label']);
				}
			}
		}
		ksort($fieldsParam);
		foreach($fieldsParam as $item){
			$params['items'][] = $item;
		}
	}
	
	/**
	 * Get the upper parent entry of an entry in the database
	 * 
	 * @param int $uid the uid of the child object
	 * @param string $repo the repository name, should be located into namespace Emagineurs\EImportExport\Domain\Repository
	 * @access private
	 * @return Conf $conf the upper parent object of the entry with $uid into repository $repo
	 */
	private function getParentObject($uid, $repo = 'FieldRepository', &$params = null){
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$itemRepo = $objectManager->get('Emagineurs\EImportExport\Domain\Repository\\'.$repo);
		
		$method = ($params === null) ? 'findByUid' : 'findByFieldUid';
		
		$conf = $itemRepo->$method($uid);
		// $conf = $itemRepo->findByFieldUid($uid);
		
		if($conf == null && $repo != 'ConfRepository'){
			return $this->getParentObject($uid, 'ConfRepository', $params);
		}
		
		return $conf;
	}
}