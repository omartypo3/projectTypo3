<?php
/***************************************************************
*  Copyright notice
*
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

if (!defined ("TYPO3_MODE")) die ("Access denied.");

#$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'TYPO3\\J77Kesearch\\Hooks\\RegisterIndexerFluidcontent';
#$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = 'TYPO3\\J77Kesearch\\Hooks\\RegisterIndexerFluidcontent';


$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifySearchWords'][] = 'TYPO3\J77Kesearch\Service\HighlightService';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['getQueryParts'][] = 'TYPO3\J77Kesearch\Service\HighlightService';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyResultList'][] = 'TYPO3\J77Kesearch\Service\HighlightService';

#$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'TYPO3\\J77Kesearch\\KeSearchIndexer\\FlexibleContent';
#$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = 'TYPO3\\J77Kesearch\\KeSearchIndexer\\FlexibleContent';



//$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['searchsuggest'] = TYPO3\J77Kesearch\Utility\Ajax::class . '::searchAction';


$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'TYPO3\\J77Kesearch\\KeSearchIndexer\\ConferenceContent';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] ='TYPO3\\J77Kesearch\\KeSearchIndexer\\ConferenceContent';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'TYPO3\\J77Kesearch\\KeSearchIndexer\\TeamContent';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] ='TYPO3\\J77Kesearch\\KeSearchIndexer\\TeamContent';

?>
