<?php

namespace DslFactory\DslProdukte\Hooks;



/***************************************************************

 *

 *  Copyright notice

 *

 *  (c) 2014 Torben Hansen <derhansen@gmail.com>

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



use TYPO3\CMS\Core\Utility\GeneralUtility;



/**

 * Hooks for DataHandler

 */

class DataHandlerHooks {







 /**

  * Checks if the fields defined in $checkFields are set in the data-array of pi_flexform. If a field is

  * present and contains an empty value, the field is unset.

  *

  * Structure of the checkFields array:

  *

  * array('sheet' => array('field1', 'field2'));

  *

  * @param string $status

  * @param string $table

  * @param string $id

  * @param array $fieldArray

  * @param \TYPO3\CMS\Core\DataHandling\DataHandler $reference

  *

  * @return void

  */

 public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$reference) {

	 

	 //fieldArray Wert wird nur nach änderung mitgegeben, wenn etwas in db geändert werden soll dann muss dieser hier modifiziert werden

	 //$reference->checkValue_currentRecord alter gespeicherter wert

	 //$reference->datamap[$table][$id] // neuer zu speichernder wert

	 

	 if ($table == 'tx_dslprodukte_domain_model_zubehoer' || $table == 'tx_dslprodukte_domain_model_produkte') {

		 

//		 $this->zubehoerRepository->findAllWithoutPidRestriction();

//		 print_r($this->zubehoerRepository);

/*DataHandlerHooks*/

		

		 

		 if(isset($fieldArray["alias"])) {

			 if(!$fieldArray["alias"]){	//wenn alias übermittelt wurde jedoch leer ist

			

			

				$alias = $reference->datamap[$table][$id]["titel"];

				

				

				// lowercase for realUrl

				$alias = strtolower($alias);

				

				// we also clean umlauts (<- does this word exist in english ?!?)

				$alias = str_replace(array("ä","ü","ö","ß"), array("ae","ue","oe","ss"), $alias);

				

				// no special characters (you never know :-))

				$alias = preg_replace('/[^a-zA-Z0-9 -_]/', '', $alias);

				$alias = preg_replace('/ /', '_', $alias);

				

				//$pObj->datamap[$table][$id]["alias"] = $alias;

				

			

				/*$row = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*",$table,"uid!=".$id." AND alias='".$alias."'");//, "uid=$id"

				if($row->num_rows){

					$aliasnr=-1;

					do {

						$aliasnr++;

						$rowintern = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*",$table,"uid!=".$id." AND alias='".$alias.$aliasnr."'");

					} while($rowintern->num_rows);

					$alias.=$aliasnr;		

				}*/

				

				$fieldArray["alias"] = $alias;

			

			 } else { //wenn ein neuer alias mitgegeben wurde

				

				$alias = $fieldArray["alias"];

				

				

				// lowercase for realUrl

				$alias = strtolower($alias);

				

				// we also clean umlauts (<- does this word exist in english ?!?)

				$alias = str_replace(array("ä","ü","ö","ß"), array("ae","ue","oe","ss"), $alias);

				

				// no special characters (you never know :-))

				$alias = preg_replace('/[^a-zA-Z0-9 -_]/', '', $alias);

				$alias = preg_replace('/ /', '_', $alias);

				

				/*if($status!="new") $updateWhere = " AND uid!=".$id; else $updateWhere = "";

				$row = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*",$table,"alias='".$alias."'".$updateWhere);//, "uid=$id"

				if($row->num_rows){

					$aliasnr=-1;

					do {

						

						$aliasnr++;

						$rowintern = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*",$table,"alias='".$alias.$aliasnr."'".$updateWhere);

					} while($rowintern->num_rows);

					$alias.=$aliasnr;		

				}*/

				$fieldArray["alias"] = $alias;

				

				

			 }

			

		 }

		/* print_r($fieldArray);

		 echo $table;

		 echo "<br />fa:".$fieldArray["alias"];

		 echo "<br />dM:".$reference->datamap[$table][$id]["alias"];

		 echo "<br />cR:".$reference->checkValue_currentRecord["alias"];*/

//		 exit;

/*		 $reference->datamap[$table][$id]["alias"] = 'zubtest1';

		 $reference->checkValue_currentRecord["alias"] = 'zubtest2';

		 

		 $fieldArray["alias"] = 'zub_test4';*/

//			echo "<br />->1";

		//	exit;

	}

		

  /*if ($table === 'tt_content' && $status == 'update' && isset($fieldArray['pi_flexform'])) {

   $checkFields = array(

    'sDEF' => array(

     'settings.myFirstSetting',

     'settings.mySecondSetting'

    ),

   );



   $flexformData =  GeneralUtility::xml2array($fieldArray['pi_flexform']);



   foreach ($checkFields as $sheet => $fields) {

    foreach($fields as $field) {

     if (isset($flexformData['data'][$sheet]['lDEF'][$field]['vDEF']) &&

      $flexformData['data'][$sheet]['lDEF'][$field]['vDEF'] === '') {

      unset($flexformData['data'][$sheet]['lDEF'][$field]);

     }

    }



    // If remaining sheet does not contain fields, then remove the sheet

    if (isset($flexformData['data'][$sheet]['lDEF']) && $flexformData['data'][$sheet]['lDEF'] === array()) {

     unset($flexformData['data'][$sheet]);

    }

   }



   /** @var \TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools $flexFormTools */

   /*

   $flexFormTools = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Configuration\\FlexForm\\FlexFormTools');

   $fieldArray['pi_flexform'] = $flexFormTools->flexArray2Xml($flexformData, TRUE);

  }*/

 }



}

?>