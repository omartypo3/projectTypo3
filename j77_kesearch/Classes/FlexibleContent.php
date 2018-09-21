<?php

namespace TYPO3\J77Kesearch\KeSearchIndexer;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
/***************************************************************
 *  Copyright notice
 *  (c) 2010 Andreas Kiefer (kennziffer.com) <kiefer@kennziffer.com>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Plugin 'Faceted search' for the 'ke_search' extension.
 * @author    Andreas Kiefer (kennziffer.com) <kiefer@kennziffer.com>
 * @author    Stefan Froemken
 * @package    TYPO3
 * @subpackage    tx_kesearch
 */
 
 
    class FlexibleContent{
      // INFO: Diese Methode registriert den Indexer in den ke_search Indexer-Auswahl      	
      function registerIndexerConfiguration(&$params, $pObj) {
        // add item to "type" field
        
        $newArray = array(
          'Custom FlexibleContent Indexer',  // LABEL
          'customflexiblecontent',	// TYPE
          //\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('ke_search_hooks') . 'customnews-indexer-icon.gif'	// ICON
        );
        
        $params['items'][] = $newArray; 
        
      }

      // INFO: Diese Methode führt den eigentlichen Index Befehl aus

     /**
      * Custom indexer for ke_search
      *
      * @param array $indexerConfig Configuration from TYPO3 Backend
      * @param array $indexerObject Reference to indexer class.
      * @return string Output.
      * @author Christian Buelter <buelter@kennziffer.com>
      * @since Fri Jan 07 2011 16:01:51 GMT+0100
      */
     public function customIndexer(&$indexerConfig, &$indexerObject) {
        // Nur feuern wenn mein TYPE am Zuge ist
        if($indexerConfig['type'] == 'customflexiblecontent') {
          $content = '';
          //im richtigen Baum suchen
          $childs = $this->getTreePids($indexerConfig['sysfolder']);
          $pids = '';
          foreach($childs AS $key => $pid){
            if($key>0){
              $pids .= ', ';
            }
            $pids .= $pid;
          }
          
          // Baue den SQL-Befehl für die zu indexierenden Datensätze zusammen und führe diesen aus
          $fields = '*';
          $table = 'tt_content';
          $where = 'hidden = 0 AND deleted = 0';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
          if($pids != ''){
            $where .= ' AND pid IN ('.$pids.')';
          }
          $groupBy = '';
          $orderBy = '';
          $limit = '';
          $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields,$table,$where,$groupBy,$orderBy,$limit);
           
          $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		      $flexFormService = $objectManager->get('TYPO3\\CMS\\Extbase\\Service\\FlexFormService');
          
          $forbiddenKeys = array('id','tag','image','target','display','layout','class','youtubeUrl','color','googleMapsStyle', 'toptitle', 'subtitle', 'unit'); 
           
          // Hat die SQL-Abfrage ein Ergebniss gebracht? Wenn ja: Analysiere jeden Eintrag
          $resCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
          if($resCount) {
            while ( ($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) ) {
               
              //$fullContent = strip_tags($record['pi_flexform']); 
             
              // Anpassung Ticket 56741
              //$fullContent = str_replace('  ', ' ', str_replace('\\"', '"', strip_tags(htmlspecialchars_decode(str_replace([' -', 'blank'], '', preg_replace ('/t3:\/\/page\?\S*/i' , '' , $fullContent))))));
              
              $flexArray = $flexFormService->convertFlexFormContentToArray($record['pi_flexform']);
		          $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($flexArray));
              
              $content = [];
              
              foreach($iterator as $key=>$value){			
          		   if($value!=='' && !$this->in_arrayi($key, $forbiddenKeys) && !is_numeric($value) && (strpos( $value, 'fileadmin') === false) && (strpos( $value, 't3://') === false) && strlen($value) > 13) {
          					$content[] = strip_tags(str_replace(['&shy; ', '&shy;'], '', $value));
          		   }
          		}
          		
          		$fullContent = implode(' ', $content);
          		
          		
          		
              
              $title = strip_tags($record['header']);
              
              /*if($title == 'So arbeiten wir zusammen') {
                DebuggerUtility::var_dump($flexArray)
              }*/
               //DebuggerUtility::var_dump($record);
               
              // Setze den Titel
              //$title = strip_tags($record['name']);
              
              // Setze den Beschreibungstext
              //$content = strip_tags($record['beschreibung']);
              
              // Erzeuge davon das Gesamtergebnis. Wichtig: das "\n" muss mit dabei sein!
              //$fullContent = $title . "\n" . $content;

              // z.B. bei Detailansichten von Elementen müssen bestimmte GET-Parameter an die URL dran gehangen werden
              // dies kann hier erfolgen. Da hier nur auf eine bestimmte Seite ohne Parameter verwiesen wird. Habe ich das leer gelassen
              //$params = '';//&tx_ttnews[tt_news]=' . $record['uid'];

              // Hier können optional noch feste Tags drin stehen, diese benutzen wir bis Dato nicht und können nachträglich noch über den Indexer konfiguriert werden
              //$tags = '';//#example_tag_1#,#example_tag_2#';

              // Zusatzinfos zu dem Index schreiben
              $additionalFields = array(
                'sortdate' => $record['crdate'],
                'orig_uid' => $record['uid'],
                'orig_pid' => $record['pid'],
                //'sortdate' => $record['datetime'],
              );

              // Den erstellten Index in die Index-Datenbank schreiben

              $indexerObject->storeInIndex(
                $indexerConfig['storagepid'], // storage PID
                $title, // record title
                'customflexiblecontent', // content type -> WICHTIG! Hier muss der TYPE ebenfalls gesetzt werden///customansprechpartner
                $record['pid'],//$indexerConfig['targetpid'], // target PID: where is the single view?
                $fullContent, // indexed content, includes the title (linebreak after title)
                $tags, // tags for faceted search
                $params, // typolink params for singleview
                $abstract, // abstract; shown in result list if not empty
                $record['sys_language_uid'], // language uid
                $record['starttime'], // starttime
                $record['endtime'], // endtime
                $record['fe_group'], // fe_group
                false, // debug only?
                $additionalFields // additionalFields
              );
              /*$array = array($indexerConfig['storagepid'], // storage PID
                $title, // record title
                'customansprechpartner', // content type -> WICHTIG! Hier muss der TYPE ebenfalls gesetzt werden
                $indexerConfig['targetpid'], // target PID: where is the single view?
                $fullContent, // indexed content, includes the title (linebreak after title)
                $tags, // tags for faceted search
                $params, // typolink params for singleview
                $abstract, // abstract; shown in result list if not empty
                $record['sys_language_uid'], // language uid
                $record['starttime'], // starttime
                $record['endtime'], // endtime
                $record['fe_group'], // fe_group
                false, // debug only?
                $additionalFields);//*/
              //DebuggerUtility::var_dump($array);die();//*/
            }

            // Am Ende des Indexerdurchlaus im Backend eine Meldung ausgeben.            
            $content = '<p><b>Custom Indexer "' . $indexerConfig['title'] . '": ' . $resCount . 'Elements have been indexed.<b></p>';
          }
          return $content;
        }
      }
        
      private function getTreePids($parent = 0, $as_array = true){
          $depth = 999999;
          $queryGenerator = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance( 'TYPO3\\CMS\\Core\\Database\\QueryGenerator' );
          $childPids = $queryGenerator->getTreeList($parent, $depth, 0, 1); //Will be a string like 1,2,3
          if($as_array) {
              $childPids = explode(',',$childPids );
          }
          return $childPids;
      }
      
      function in_arrayi($needle, $haystack) {
        if(empty($haystack)) {
          return false;
        }
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
  }
    
    
    








