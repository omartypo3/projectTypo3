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


    class TeamContent{
      // INFO: Diese Methode registriert den Indexer in den ke_search Indexer-Auswahl
      function registerIndexerConfiguration(&$params, $pObj) {
        // add item to "type" field

        $newArray = array(
          'Custom TeamContent Indexer',  // LABEL
          'customteamcontent',	// TYPE
          //\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('ke_search_hooks') . 'customnews-indexer-icon.gif'	// ICON
        );

        $params['items'][] = $newArray;

      }

       public function customIndexer(&$indexerConfig, &$indexerObject) {

        // Only fire if my TYPE is meant
        if($indexerConfig['type'] == 'customteamcontent') {
            var_dump($indexerConfig['sysfolder']);
          $content = '';

          // Build and execute the SQL command for the records to be indexed
          $fields = '*';
          $table = 'fe_users ,tx_dld_domain_model_sessionpeople';
          $where = 'fe_users.uid = tx_dld_domain_model_sessionpeople.people_id And `tx_extbase_type` LIKE \'Tx_Dld_People\'  and fe_users.disable=0';
          $groupBy = 'fe_users.uid';
          $orderBy = '';
          $limit = '';
          $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields,$table,$where,$groupBy,$orderBy,$limit);

          // Has the SQL query returned a result? If so, analyze each entry
          $resCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
          if($resCount) {
            while ( ($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) ) {

              // Set the title
              $title = strip_tags($record['first_name']).' '.strip_tags($record['last_name']);

              // Set the company text
              $company= strip_tags($record['company']);

                // Set the country text
              $country= strip_tags($record['country']);

                // Set the city text
              $city= strip_tags($record['city']);
                // Set the city titlecompany
             // $titlecompany= strip_tags($record['title']);

                // Generate the overall result. Important: the "\ n" must be there!
              $fullContent = $title . "\n" . $company."\n". $country."\n" . $city."\n";

              // e.g. Detail views of elements require that certain GET parameters be appended to the URL
              // this can be done here. Since here only a specific page without parameters is referenced. Did I leave that empty?
              $padlrams = '';//&tx_ttnews[tt_news]=' . $record['uid'];

              // Optionally there can be fixed tags in here, we do not use them until dato and can be configured later via the indexer
              $tags = '';//#example_tag_1#,#example_tag_2#';
              $params = '';
              $abstract='';
              // Write additional information about the index
              $additionalFields = array(
                'sortdate' => $record['crdate'],
                'orig_uid' => $record['uid'],
                'orig_pid' => $record['pid'],
              );

              // write the created index to the index database

              $indexerObject->storeInIndex(
                $indexerConfig['storagepid'], // storage PID
                $title, // record title
                'customteamcontent', // content type -> IMPORTANT! Here, the TYPE must also be set
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
                $additionalFields // additionalFields
              );
            }

            // Output a message at the end of the indexer passthrough in the backend.
            $content = '<p><b>Custom Indexer "' . $title . '": ' . $resCount . 'Elements have been indexed.<b></p>';
          }
          return $content;
        }
      }
    }