<?php
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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

//http://localhost/package/index.php?eID=eImportExport&uidconf=1

use TYPO3\CMS\Extbase\Object\ObjectManager;

\Emagineurs\EImportExport\Utility::initAjax();
$cacheSystem = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('eImportExport');
$confUid = intval($_GET['uidconf']);

//check if uidconf param is set
if($confUid<=0){
	return \Emagineurs\EImportExport\Utility::throwError(
		"Invalid configuration argument. Check your urls parameters and configuration states.",
		1986030404);
}

$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
$confRepo = $objectManager->get('Emagineurs\EImportExport\Domain\Repository\ConfRepository');
$conf = $confRepo->findByUid($confUid);

//check if the conf exists
if(empty($conf)){
	return \Emagineurs\EImportExport\Utility::throwError(
		"Conf with uid " . $confUid . " does not exists.",
		1986030404);
	die();
}

//check if the conf is an ajax conf
if(!in_array('2', $conf->getInterface())){
	return \Emagineurs\EImportExport\Utility::throwError(
		"You are not allowed to execute this task.",
		1986030404);
	die();
}

$cacheIdentifier = 'CondUid'.$confUid;
$content = $cacheSystem->get($cacheIdentifier);

if($content === false){
	$args = array();
	$args['vendor'] = 'Emagineurs';
	$args['extensionName'] = 'EImportExport';
	$args['controller'] = 'ImportExport';
	$args['action'] = 'index';
	$args['arguments'] = array('confuid' => $confUid);

	$returns =  \Emagineurs\EImportExport\Utility::callExtbaseAction($args);
	$returns = unserialize($returns);
	
	$content = $returns['content'];
	
	$cacheSystem->set($cacheIdentifier, $content);
}else{
	$conf->getHandler()->header();
}

echo $content;

die();
