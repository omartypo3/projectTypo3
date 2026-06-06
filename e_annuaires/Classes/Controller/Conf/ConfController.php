<?php
namespace Emagineurs\EAnnuaires\Controller\Conf;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Xavier Ley <xley@e-magineurs.com>
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
 *
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
use Emagineurs\EAnnuaires\Domain\Repository\Conf\ChampbddRepository;
use Emagineurs\EAnnuaires\Domain\Repository\Conf\TypeannuaireRepository;
use Emagineurs\EAnnuaires\Domain\Repository\FicheRepository;
use TYPO3\CMS\Core\Http\UploadedFile;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConfController extends ActionController {

	protected $typeannuaireRepository;
	protected $champBddRepository;
	protected $ficheRepository;
	protected $registry;
	protected $listeChampsBdd;
	protected $currentField = [];
	protected $oldToNewTypeUid = [];
	protected ViewFactoryInterface $viewFactory;

	public function __construct(
		TypeannuaireRepository $typeannuaireRepository,
		ChampbddRepository $champBddRepository,
		FicheRepository $ficheRepository,
		ViewFactoryInterface $viewFactory
	) {
		$this->typeannuaireRepository = $typeannuaireRepository;
		$this->champBddRepository = $champBddRepository;
		$this->ficheRepository = $ficheRepository;
		$this->viewFactory = $viewFactory;
	}

	public function initializeAction(): void
	{ 
		$this->registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Registry::class);
		$this->listeChampsBdd = $this->getListeChampsBdd();
		
		$this->removeUploadedFilesFromRequest();
	}

	/**
	 * Remove UploadedFile objects from request arguments
	 * to prevent "Object could not be converted to string" errors in backend action menus
	 */
	protected function removeUploadedFilesFromRequest(): void
	{
		$arguments = $this->request->getArguments();
		$filteredArguments = $this->filterUploadedFiles($arguments);
		
		if ($filteredArguments !== $arguments) {
			$this->request = $this->request->withArguments($filteredArguments);
		}
	}

	/**
	 * Recursively filter out UploadedFile objects from an array
	 */
	protected function filterUploadedFiles(array $data): array
	{
		foreach ($data as $key => $value) {
			if ($value instanceof UploadedFile) {
				unset($data[$key]);
			} elseif (is_array($value)) {
				$data[$key] = $this->filterUploadedFiles($value);
			}
		}
		return $data;
	}
			
	/**
	 * action index	
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function indexAction(): \Psr\Http\Message\ResponseInterface
	{
		$listTypes = $this->typeannuaireRepository->findAll();
		
		$locallangPath = $this->registry->get('tx_eannuaires','locallangPath');
		
		$this->view->assign('locallangPath',$locallangPath);
		$this->view->assign('listTypes',$listTypes);
		$this->view->assign('ListeChampBdd',$this->listeChampsBdd);
		
		return $this->htmlResponse();
	}
	
	
	/**
	 * action createType	
	 *
	 * @return void
	 */
	public function createTypeAction(): \Psr\Http\Message\ResponseInterface
	{		
		$currentRequest = $this->request->getArguments();
		
		// On crée le nouveau type
		$newType = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire::class);
		$newType->setTitle($currentRequest['newType']); 
		
		$this->typeannuaireRepository->add($newType);
		
		// On crée, par défaut, un champ titre pour le type que l'on vient de créer
		$newField = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Champbdd::class);
		$newField->setTitle('title'); 
		$newField->setSorting(0); 
		$newField->setTypeannuaire($newType); 
		
		$this->champBddRepository->add($newField);
		
		// On rend effectifs les ajouts définis au dessus
		$this->typeannuaireRepository->publicPersistAll();
		$this->champBddRepository->publicPersistAll();

		// prépare les rendu frontend
		$this->view->assign('type',$newType);
		$contentConf = $this->getContentConf($newType);
		
		// On met les données dans les sessions car le dispatcher ne semble pas permettre un simple return.
		$arrayToReturn = array(
			'contentType' => $this->view->render(),
			'contentConf' => $contentConf,
			'idType' => $newType->getUid()
		);
		$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
		return $this->jsonResponse(json_encode($arrayToReturn));
	}
	
	public function getContentConf($type){		
		$mainTemplate = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:e_annuaires/Resources/Private/Partials/Conf/Type.html');
		$viewFactoryData = new ViewFactoryData(
			templatePathAndFilename: $mainTemplate
		);
		$tmpView = $this->viewFactory->create($viewFactoryData);
		
		$tmpView->assign('type',$type);
		$tmpView->assign('ListeChampBdd',$this->listeChampsBdd);
		
		return $tmpView->render();
	}
	
	/**
	 * action deleteType	
	 *
	 * @return void
	 */
	public function deleteTypeAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();

		$typeToDeleteInfoArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('-',$currentRequest['typeToDelete']); 
		$typeToDeleteUid = $typeToDeleteInfoArray[1];
		
		$typeToDelete = $this->typeannuaireRepository->findByUid($typeToDeleteUid);
		
		$this->typeannuaireRepository->remove($typeToDelete);
		
		$this->typeannuaireRepository->publicPersistAll();

		// On vérifie que la suppression à bien fonctionné
		$typeToDelete = $this->typeannuaireRepository->findByUid($typeToDeleteUid);

		// On met les données dans les sessions car le dispatcher ne semble pas permettre un simple return.
		if(!$typeToDelete){
			$arrayToReturn = array(
				'deleteSuccess' => true
			);
			$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
			return $this->jsonResponse(json_encode($arrayToReturn));
		}
		return $this->jsonResponse(json_encode(['deleteSuccess' => false]));
	}
	
	/**
	 * action generateDetailConf	
	 *
	 * @return void
	 */
	public function generateDetailConfAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
		
		$source = $currentRequest['source'] ? $currentRequest['source'] : 'tca' ; 
		$idTypeInfoArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('-',$currentRequest['idType']); 
		$idType = $idTypeInfoArray[1];
						
		if(trim($idType) != ''){	
			$selectedFields = $this->champBddRepository->selectConfType($idType);
			$this->view->assign('selectedFields',$selectedFields);
			$this->view->assign('source',$source);
	
			$arrayToReturn = array(
				'generateDetailConf' => $this->view->render()
			);
			
			$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
		} else {
			$arrayToReturn = array(
				'generateDetailConf' => 'Aucun type d\'annuaire n\a été selectionné'
			);
			$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
		}
		return $this->jsonResponse(json_encode($arrayToReturn));
	}
	
	/**
	 * action addNewField	
	 *
	 * @return void
	 */
	public function addNewFieldAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
				
		// On instancie un nouveau champ
		$newField = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Champbdd::class);
		
		// On lui attribue un titre, un type et un sorting
		$newField->setTitle($currentRequest['newFieldName'][0]); 
		$newField->setSorting($currentRequest['sorting']); 
		
		$type = $this->typeannuaireRepository->findByUid($currentRequest['newFieldType']);
		$newField->setTypeannuaire($type); 
				
		// On fait l'ajout
		$this->champBddRepository->add($newField);
		
		// On rend effetifs les ajouts définis au dessus
		$this->champBddRepository->publicPersistAll();
		
		$newFieldCheck = $this->champBddRepository->findByUid($newField->getUid());
				
		$this->view->assign('newField',array($newField));
		$content = ($newFieldCheck !== null) ? $this->view->render() : '' ;
				
		$arrayToReturn = array(
			'addNewField' => $content
		);
			
		// On met les données dans les sessions car le dispatcher ne semble pas permettre un simple return.
		$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
		return $this->jsonResponse(json_encode($arrayToReturn));
	}
	
	/**
	 * action increaseSorting	
	 *
	 * Cette fonction va permettre d'inverser les sorting
	 *
	 * @return void
	 */
	public function changeSortingAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
		
		$lowSorting = $currentRequest['lowSorting'];
		$highSorting = $currentRequest['highSorting'];
		
		// On récupère les objets correspondants aux champs dont l'on souhaite échanger les places
		$fieldWithIncreasingSorting = $this->champBddRepository->findByUid($lowSorting);
		$fieldWithDecreasingSorting = $this->champBddRepository->findByUid($highSorting);
	
		// On stocke les sorting dans des variables
		$highestSorting = $fieldWithDecreasingSorting->getSorting(); 
		$lowestSorting = $fieldWithIncreasingSorting->getSorting(); 
					
		// On attribue le sorting de chaque item à l'autre
		$fieldWithIncreasingSorting->setSorting($highestSorting); 
		$fieldWithDecreasingSorting->setSorting($lowestSorting); 
			
		//On fait l'update	
		$this->champBddRepository->update($fieldWithIncreasingSorting);
		$this->champBddRepository->update($fieldWithDecreasingSorting);
			
			
		// On rend effetifs les modifications définis au dessus
		$this->champBddRepository->publicPersistAll();
	}
	
	/**
	 * action deleteField	
	 *
	 * @return void
	 */
	public function deleteFieldAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
		
		$fieldToDelete = $this->champBddRepository->findByUid($currentRequest['fieldToDelete']);
		$fieldsToUpdate = $this->champBddRepository->findByTypeannuaire($fieldToDelete->getTypeannuaire())->toArray();
		
		$this->champBddRepository->remove($fieldToDelete);
		
		if(is_array($fieldsToUpdate) && !empty($fieldsToUpdate)){
			foreach($fieldsToUpdate as $field) {
				$newSorting = (intval($field->getSorting())-1) == 0 ? -1 : intval($field->getSorting())-1 ;  
				$field->setSorting($newSorting);
				$this->champBddRepository->update($field);
			}
		}
		
		$this->champBddRepository->publicPersistAll();

		// On vérifie que la suppression à bien fonctionné
		$fieldToDeleteCheck = $this->champBddRepository->findByUid($currentRequest['fieldToDelete']);

		// On met les données dans les sessions car le dispatcher ne semble pas permettre un simple return.
		if(!$fieldToDeleteCheck){
			$arrayToReturn = array(
				'fieldToDelete' => true
			);
			$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
		}
	}
	
	/**
	 * action updateLabelTab	
	 *
	 * @return void
	 */
	public function updateLabelTabAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
				
		$newArrayUpdate = array();
		foreach($currentRequest['updateArray'] as $inputField => $inputVal){
			$infoInput = explode('-',$inputField);
			
			if(!$this->currentField[$infoInput[1]]){
				$this->currentField[$infoInput[1]] = $this->champBddRepository->findByUid($infoInput[1]);
			}
			
			if($this->currentField[$infoInput[1]]){
				if($infoInput[0] == 'newLabel'){
					$this->currentField[$infoInput[1]]->setLabel($inputVal);
				} else if($infoInput[0] == 'newTab'){
					$this->currentField[$infoInput[1]]->setTablabel($inputVal);
				}
			}
			
			$this->champBddRepository->update($this->currentField[$infoInput[1]]);
		}

		$this->champBddRepository->publicPersistAll();
		
		$valid = true;
		
		foreach($this->currentField as $item){
			if(
				$item->getLabel() != $currentRequest['updateArray']['newLabel-'.$item->getUid()]
				|| $item->getTablabel() != $currentRequest['updateArray']['newTab-'.$item->getUid()]
			){
				$valid = false;
			}
		}
		
		// On met les données dans les sessions car le dispatcher ne semble pas permettre un simple return.
		$arrayToReturn = array(
			'updateLabelTab' => ($valid === true) ? 'Les labels ont bien été sauvegardé.' : 'La sauvegarde des labels a echoué'
		);
		$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
	}
	
	/**
	 * action getTcaConf	
	 *
	 * @return void
	 */
	public function getTcaConfAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
		
		$conf = $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$currentRequest['fieldName']]['config'];
		
		$this->view->assign('conf',$conf);
		
		// On récupère le résultat du debug sous forme d'un html
		ob_start();
		
		// echo '<h4 class="titreConf">'.$currentRequest['fieldName'].'</h4>';
		// echo '<pre>';
		// var_dump($conf);
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($conf,$currentRequest['fieldName']);
		// echo '</pre>';
		
		$content = ob_get_contents();
		
		ob_end_clean();
		
		// On retourne les valeurs via les sessions
		$arrayToReturn = array(
			'getTcaConf' => $content
		);
		
		$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
	}
	
	/**
	 * action generateConf
	 *
	 * @return void
	 */
	public function generateConfAction(): \Psr\Http\Message\ResponseInterface
	{
		$confArray= array();
		
		$listType = $this->typeannuaireRepository->findAll()->toArray();
		
		if(is_array($listType) && !empty($listType)){
			foreach($listType as $type){
				$confArray[$type->getUid()] = $this->generateConfArray($type->getUid());
			} 
		}
		
		// On stocke la conf dans la table des registres
		$registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Registry::class);		
		$registry->set('tx_eannuaires','confAnnuaires',$confArray);
		
		// On retourne les valeurs via les sessions
		if(!empty($confArray)){
			$arrayToReturn = array(
				'generateConf' => true
			);
		
			$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $arrayToReturn);
		}
	}
	
	public function generateConfArray($type){
		if(intval($type) > 0){
			$confTypeArray = array();
			
			$listChampType = $this->champBddRepository->selectConfType($type)->toArray();
			
			foreach($listChampType as $champ){
				$confTypeArray[$champ->getTitle().'.'] = array(
					'value' => $champ->getTitle(),
					'sorting' => $champ->getSorting(),
					'label' => $champ->getLabel(),
					'newTab' => $champ->getTablabel()
				);
			}
			
			return $confTypeArray;
		}
	}
	
	/**
	 * action export
	 *
	 * @return void
	 */
	// public function exportAction(): \Psr\Http\Message\ResponseInterface
	// {
	// 	$currentRequest = $this->request->getArguments();

	// 	if(!empty($currentRequest['exportConf'])){
	// 		$confAnnuaires = $this->registry->get('tx_eannuaires','confAnnuaires');

	// 		foreach($confAnnuaires as $type => $conf){
	// 			$titleType = $this->typeannuaireRepository->findByUid($type);

	// 			if($titleType != null){
	// 				$confAnnuaires[$type]['titleType'] = $titleType->getTitle();
	// 			}
	// 		}
	// 		$xmlExport =  \TYPO3\CMS\Core\Utility\GeneralUtility::array2xml_cs($confAnnuaires);

	// 		$nomFichier = 'exportConf_'.date('d-m-Y-H-i-s').'.xml';

	// 		header('Content-type: text/xml');
	// 		header('Content-Disposition: attachment; filename="'.$nomFichier.'"');

	// 		echo $xmlExport;	
	// 		die;
	// 	}

	// 	$this->view->assign('test','Je suis dans l\'action export de mon module');

	// 	return $this->htmlResponse();
	// }


	public function exportAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();

		if (!empty($currentRequest['exportConf'])) {
			$confAnnuaires = $this->registry->get('tx_eannuaires', 'confAnnuaires', []);

			// Add type titles
			foreach ($confAnnuaires as $typeUid => $conf) {
				$titleType = $this->typeannuaireRepository->findByUid((int)$typeUid);
				if ($titleType !== null) {
					$confAnnuaires[$typeUid]['titleType'] = $titleType->getTitle();
				}
			}

			// Convert array to XML
			$xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><confAnnuaires></confAnnuaires>');

			$this->arrayToXml($confAnnuaires, $xml);

			$fileName = 'exportConf_' . date('Y-m-d-H-i-s') . '.xml';

			$response = new \TYPO3\CMS\Core\Http\Response();
			$response = $response->withHeader('Content-Type', 'text/xml')
				->withHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"');

			$response->getBody()->write($xml->asXML());
			return $response;
		}

		$this->view->assign('message', 'Aucune configuration à exporter');
		return $this->htmlResponse();
	}

	/**
	 * Recursive helper to convert array to XML
	 */
	protected function arrayToXml(array $data, \SimpleXMLElement $xmlElement): void
	{
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$subNode = $xmlElement->addChild(is_numeric($key) ? "item$key" : $key);
				$this->arrayToXml($value, $subNode);
			} else {
				$xmlElement->addChild(is_numeric($key) ? "item$key" : $key, htmlspecialchars((string)$value));
			}
		}
	}



	/**
	 * action import
	 *
	 * @return void
	 */
	// public function importAction(): \Psr\Http\Message\ResponseInterface
	// {
	// 	$currentRequest = $this->request->getArguments();
	// 	if(!empty($currentRequest['confToImport'])){
	// 		$importFile = file_get_contents($currentRequest['confToImport']['tmp_name']);

	// 		$confArray = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($importFile);

	// 		$this->champBddRepository->removeAll();
	// 		$this->typeannuaireRepository->removeAll();
	// 		$this->typeannuaireRepository->publicPersistAll();
	// 		$this->champBddRepository->publicPersistAll();

	// 		$confArrayToAdd = array();
	// 		foreach($confArray as $idType => $confType){
	// 			$newType = $this->typeannuaireRepository->findAllByUid($idType);

	// 			if(!empty($newType)){
	// 				$newType->setDeleted('0');
	// 				$this->typeannuaireRepository->update($newType);
	// 			} else {
	// 				$newType = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire::class);
	// 				$newType->setTitle($confType['titleType']);
	// 				$this->typeannuaireRepository->add($newType);
	// 			}

	// 			$this->typeannuaireRepository->publicPersistAll();

	// 			$confArrayToAdd[$newType->getUid()] = $confType;
	// 		}

	// 		$confArray = $confArrayToAdd;

	// 		$this->generateNewConf($confArray);

	// 		$this->updateTypeFiche('import');
	// 		$confAnnuaires = $this->registry->set('tx_eannuaires','confAnnuaires',$confArray);

	// 		$this->view->assign('message','Import terminé');
	// 	}

	// 	return $this->htmlResponse();
	// }


	public function importAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();

		if (!empty($currentRequest['confToImport']) && $currentRequest['confToImport'] instanceof \TYPO3\CMS\Core\Http\UploadedFile){
			/** @var \TYPO3\CMS\Core\Http\UploadedFile $uploadedFile */

			$uploadedFile = $currentRequest['confToImport'];

		
			// Save uploaded file to a temporary location
			$tempFilePath = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3temp/' . $uploadedFile->getClientFilename();
			$uploadedFile->moveTo($tempFilePath);

			// Convert XML file to array (keep it as a file, not string)
			$confArray = $this->xmlFileToArray($tempFilePath);
		
			// Remove all previous data
			$this->champBddRepository->removeAll();
			$this->typeannuaireRepository->removeAll();
			$this->typeannuaireRepository->publicPersistAll();
			$this->champBddRepository->publicPersistAll();

			$confArrayToAdd = [];

			foreach ($confArray as $idType => $confType) {
				$newType = $this->typeannuaireRepository->findByUid((int)$idType);

				if ($newType !== null) {
					$newType->setDeleted('0');
					$this->typeannuaireRepository->update($newType);
				} else {
					$newType = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
						\Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire::class
					);
					$newType->setTitle($confType['titleType'] ?? '');
					$this->typeannuaireRepository->add($newType);
				}

				$this->typeannuaireRepository->publicPersistAll();
				$confArrayToAdd[$newType->getUid()] = $confType;
			}

			$confArray = $confArrayToAdd;

			$this->generateNewConf($confArray);
			$this->updateTypeFiche('import');
			$this->registry->set('tx_eannuaires', 'confAnnuaires', $confArray);

			$this->view->assign('message', 'Import terminé');
		}

		return $this->htmlResponse();
	}

	/**
	 * action convert	
	 *
	 * @return void
	 */
	public function convertAction(): \Psr\Http\Message\ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
		
		if(!empty($currentRequest['generateConfFromLocalconf'])){
			$this->convertOldConf();
			$this->view->assign('message','La conf à bien été générer');
		}
		
		return $this->htmlResponse();
	}
	
	public function convertOldConf(){		
		/*
		*/
		$confExtTplAnnuaires = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['e_annuaires'] ?? [];

		// On récupère les données de l'ancinne conf
		$defaultLocallangPath = 'EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf';
		$oldTypes = $confExtTplAnnuaires['types'] ?? '';
		$oldConf = $confExtTplAnnuaires['confType'] ?? '';
		
		// On met en base de données les données provenant de l'ancienne conf	
		$this->champBddRepository->removeAll();
		$this->typeannuaireRepository->removeAll();
		$this->typeannuaireRepository->publicPersistAll();
		$this->champBddRepository->publicPersistAll();
			
		$conf = $this->registry->set('tx_eannuaires','locallangPath',$defaultLocallangPath);
		$this->generateTypes($oldTypes);
		$this->generateNewConf($oldConf);
		
		// On attibue le nouveau type correspondant aux fiches existante
		$this->updateTypeFiche('convert');
		
		// On stocke la conf récupere telle quelle du localconfiguration
		$confAnnuaires = $this->registry->set('tx_eannuaires','confAnnuaires',$oldConf);
	}
	
	public function generateTypes($oldTypes){	
		$oldTypesArray = explode(',',$oldTypes);
		
		foreach($oldTypesArray as $typeConfArray){
			$typeArray = explode('-',$typeConfArray);
			$arrayTypes[$typeArray[0]] = $typeArray[1];
		}
	
		$this->oldToNewTypeUid = array();
	
		foreach($arrayTypes as $oldUid => $type){
			// On instancie un object de type conf
			$newType = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire::class);
			
			// On set les valeurs à partir de celles provenant de l'ancienne conf 
			$newType->setTitle($type); 
			
			$this->typeannuaireRepository->add($newType);
			
			// On rend effetifs les ajouts définis au dessus
			$this->typeannuaireRepository->publicPersistAll();
			
			// On stocke dans un tableau les equivalence entre anciens et nouveaux uid afin de pouvoir les utiliser dans la création des champs, fonction generateNewConf()
			$this->oldToNewTypeUid[$oldUid] = $newType->getUid();
		}
	}

	public function generateNewConf($oldConf)
	{
		if (is_array($oldConf) && !empty($oldConf)) {
			foreach ($oldConf as $type => $champArray) {
				$idType = ($this->oldToNewTypeUid[$type]) ? $this->oldToNewTypeUid[$type] : $type;
				$typeAnnuaire = $this->typeannuaireRepository->findAllByUid($idType);

				// \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($idType,'TEST $idType');
				// \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($typeAnnuaire,'TEST $typeAnnuaire');

				foreach ($champArray as $conf) {
					if (!empty($conf['value'])) {
						$newChampConf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
							\Emagineurs\EAnnuaires\Domain\Model\Conf\Champbdd::class
						);

						$newChampConf->setTitle($conf['value']);
						$newChampConf->setSorting(
							isset($conf['sorting']) && trim($conf['sorting']) !== ''
								? (int)$conf['sorting']
								: null
						);
						$newChampConf->setLabel($conf['label'] ?? '');
						$newChampConf->setTablabel($conf['newTab'] ?? '');
						if ($typeAnnuaire instanceof \Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire) {
							$newChampConf->setTypeannuaire($typeAnnuaire);
						}
						$this->champBddRepository->add($newChampConf);
						$this->champBddRepository->publicPersistAll();
					}
				}
			}
		}
	}
	
	public function updateTypeFiche($origin){
		$this->ficheRepository->updateTypeFiche($origin);
	}
	
	public function getListeChampsBdd(){
        // On récupère la liste des champs de la table des fiches annuaires
        $fieldListArray = array(); 
        $connection = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getConnectionForTable('tx_eannuaires_domain_model_fiche');
        $fieldListArrayBegin = $connection->createSchemaManager()->listTableColumns('tx_eannuaires_domain_model_fiche'); 
        
        // On exclut les tables dont on sait qu'elle ne seront pas utilsé dans le TCA
        $excludeFields = array(
            'uid',
            'pid',
            'cruser_id',
            'deleted',
            't3ver_oid',
            't3ver_id',
            't3ver_wsid',
            't3ver_label',
            't3ver_state',
            't3ver_stage',
            't3ver_count',
            't3ver_tstamp',
            't3ver_move_id',
            't3_origuid',
            'l10n_parent',
            'l10n_diffsource',
            'typeelement'
        );
        
        foreach($fieldListArrayBegin as $field => $column){
            if(!in_array($field,$excludeFields)){
                $fieldListArray[$field]['title'] = $field;
                $fieldListArray[$field]['config'] = $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$field]['config'] ?? [];
            }
        }
		
		sort($fieldListArray);
		
		return $fieldListArray;
	}

	// private function arrayToXml(array $data, string $root = 'root', \XMLWriter $xml = null): string
	// {
	// 	$isRoot = false;

	// 	if ($xml === null) {
	// 		$xml = new \XMLWriter();
	// 		$xml->openMemory();
	// 		$xml->startDocument('1.0', 'UTF-8');
	// 		$xml->startElement($root);
	// 		$isRoot = true;
	// 	}

	// 	foreach ($data as $key => $value) {
	// 		$tag = preg_match('/^[A-Za-z_][A-Za-z0-9_-]*$/', (string)$key) ? (string)$key : 'item';

	// 		if (is_array($value)) {
	// 			$xml->startElement($tag);
	// 			$this->arrayToXml($value, $root, $xml);
	// 			$xml->endElement();
	// 		} else {
	// 			$xml->writeElement($tag, (string)$value);
	// 		}
	// 	}

	// 	if ($isRoot) {
	// 		$xml->endElement();
	// 		$xml->endDocument();
	// 	}

	// 	return $xml->outputMemory();
	// }

	/**
	 * Convert XML string to PHP array
	 */
	private function xmlFileToArray(string $filePath): array
	{
		if (!file_exists($filePath)) {
			return [];
		}

		$xml = simplexml_load_file($filePath, "SimpleXMLElement", LIBXML_NOCDATA);
		return $xml ? json_decode(json_encode($xml), true) : [];
	}
	
}?>
