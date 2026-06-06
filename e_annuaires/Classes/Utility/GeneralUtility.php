<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Xavier Ley <xley@e-magineurs.com>
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

use Emagineurs\EAnnuaires\Domain\Repository\FicheRepository;
use Emagineurs\EAnnuaires\Domain\Repository\CategorieRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility as CoreGeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Core\View\ViewFactoryData;
/**
 *
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class GeneralUtility
{
	protected ?array $settings = null;
	protected $pageRepo = null;

	
	public function __construct(
		protected readonly FicheRepository $ficheRepository,
		protected readonly CategorieRepository $categorieRepository
	)
	{}

	public function getArrayForSearchForm(array $confArray, array $settings): array
	{
		$this->settings = $settings;
		// $this->ficheRepository->setSettings($settings, array('cObj' => $this->configurationManager->getContentObject()));	

		if ($confArray['values'] ?? false) {
            return $confArray['values'];
        }
        
        if($confArray['table']){
            $result = $this->handleArrayFromSettings($confArray);             
        }
        
        if($confArray['excludeItems']){
            $result = $this->excludeItems($confArray,$result);
        }
        
        if($confArray['addItems']){
            $result = $result + $confArray['addItems'];
        }
                
		if(empty($confArray['noEmptyValue'])){
			$newArray = array(0 => '');
			//array_unshift($result,'');
		}		
		
		foreach($result as $key => $item){
			$newArray[$key] = $item;
		}
		
        return $newArray;
        //return $result;
    }
    
    public function handleArrayFromSettings($confArray){            
        $filtreConf = array(
            'table' => $confArray['table'],
            'orderBy' => $confArray['orderBy'],
            'andWhere' => $confArray['andWhere'],
            'groupBy' => $confArray['groupBy'],
            'selectFields' => $confArray['selectFields'],
            'doNotExplode' => $confArray['doNotExplode'],
            'inAllSites' => $confArray['inAllSites']
        );

        $pidTable = $this->getPidInArrayGeneration($filtreConf); 
        $filtreConf['selectFields'] .= ($pidTable[1] > 1) ? ', '.$pidTable[0].'.pid': ', pid';

        if(!$confArray['mainCat']){
            $filtreConf['parentField'] = ($confArray['pid']) ? 'pid = '.$confArray['pid'].' AND 1 ' : ' 1 ';
            $fieldArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$filtreConf['selectFields']);

            if($confArray['recursive'] && $confArray['parentValue'] && $confArray['parentField']){
                $result = $this->getRecursiveArray($filtreConf,$confArray,$fieldArray);               
            } else {
                $result = $this->getStandardArray($filtreConf,$fieldArray); 
            }
        } else {
            $result = $this->getMainCatArray($confArray,$filtreConf);
        }
        
        return $result;
    }

    public function getPidInArrayGeneration($filtreConf){
		$pidTable = array();
		$pidTableArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$filtreConf['table']);

        $pidTable[0] = $pidTableArray[0];
		$pidTable[1] = count($pidTableArray);
		
        return $pidTable;
    }
    
    public function getMainCatArray($confArray,$filtreConf){
        $result = array();
        $resultArray = array();
        
        $fieldArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$filtreConf['selectFields']);

        $catList =  !empty($confArray['parentValue']) ? $confArray['parentValue'] : $this->settings['filtre']['categories']['value'];
        $confArray['recursive'] =  !empty($confArray['recursive']) ? $confArray['recursive'] : $this->settings['filtre']['categories']['recursive'];
        $arrayCat = explode(',',$catList);

        $i = 0;
        foreach($arrayCat as $cat){
            $confArray['parentValue'] = intval($cat);
            $result[$i] = $this->getRecursiveArray($filtreConf,$confArray,$fieldArray);
			
            if($confArray['mainCat'] && $confArray['displayParent'] != '1'){
                unset($result[$i][$cat]);                
            }
            $i++;
        }

        if(count($result) > 1){
            $i = 0;
            $test = array();
            while($i < count($result)){
                // $resultArray = array_merge($resultArray,$result[$i]);
                $resultArray = $resultArray+$result[$i];
                $i = $i+1;
            }
        } else if(is_array($result)){
            $resultArray = $result[0];
        }
                
        if(is_array($resultArray[0])){
            return array_unique($resultArray[0]);
        } else {
            return array_unique($resultArray);
        }
        
    }


    public function excludeItems($confArray,$result){
        $arrayToExclude = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$confArray['excludeItems']);

        foreach($arrayToExclude as $itemToExclude){
            unset($result[$itemToExclude]);
        }
        
        return $result;
    }
    
    public function getStandardArray($filtreConf,$fieldArray){
        $result = array();
        
        $arrayItem = $this->ficheRepository->getChildrenRecords($filtreConf,$filtreConf['parentField']);

        if(!empty($arrayItem) && is_array($arrayItem)){
			$fieldArrayTemp = array();
			
			$fieldArrayTemp[0] = array_search(reset($arrayItem[0]), $arrayItem[0]);
			$fieldArrayTemp[1] = array_search(next($arrayItem[0]), $arrayItem[0]);
			$fieldArrayTemp[2] = end($fieldArray);
			
			$fieldArray = $fieldArrayTemp;
		}
		
        if(is_array($fieldArray) && !empty($fieldArray)){
            foreach($fieldArray as $key => $field){
                $finalFieldArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('.',$field);
                $finalField = end($finalFieldArray);

                $fieldArray[$key] = $finalField;
            }
        }

        foreach($arrayItem as $item){
			if($filtreConf['inAllSites'] || $this->checkRootPage($item['pid'])){
				$result = $this->fillStandardArray($item,$fieldArray,$result,$filtreConf['doNotExplode']);
			}
        }
		
        $result = array_unique($result);
				
        return $result;
    }
	
	public function fillStandardArray($item,$fieldArray,$result,$doNotExplode = FALSE){
		//si j'ai une valeur et une virgule dans mes clé et valeur (surtout pour le cas d'une liste à choix multiple dans le formulaire)
		if((strpos($item[$fieldArray[0]], ",")!==false AND strpos($item[$fieldArray[1]], ",")!==false) && $doNotExplode === FALSE){
			$fa1 = explode(",", $item[$fieldArray[1]]);
			foreach($fa1 as $fa_value){
				$result[] = $fa_value;
			}
		}else {
			$result[$item[$fieldArray[0]]] = $item[$fieldArray[1]];
		}
		
		return $result;
	}
    
    public function getRecursiveArray($filtreConf,$confArray,$fieldArray){ 
        $res = array();
        $currentArray = array();
        
        $filtreConf['recursive'] = $confArray['recursive'];
        $filtreConf['parentField'] = ($confArray['pid']) ? 'pid = '.$confArray['pid'].' AND '.$confArray['parentField'].' ' : $confArray['parentField'];
	
        
        if(intval($filtreConf['recursive']) > 0){   
            foreach($fieldArray as $key => $field){        
                $currentArray[$key] = $this->generateRecursiveArray($filtreConf,$field,$key,$res,$confArray,$currentArray,$fieldArray);
            }
        } else {
            $currentArray[0][0] = $confArray['parentValue'];
        }
        
        if($confArray['mainCat'] && $confArray['displayParent'] == '1'){
            $currentArray = $this->addMainCat($currentArray);
        }
		
		$result = array();
		if(is_array($currentArray[2]) && !empty($currentArray[2]) && count($currentArray[2]) > 0){   
			foreach($currentArray[2] as $key => $pid){
				if($confArray['inAllSites'] || $this->checkRootPage($pid)){
					$result[$currentArray[0][$key]] = $currentArray[1][$key];
				}
			}                   
		}

       $result = $this->removeExcessIndentation($result);
                
        return $result;
    }
    
    public function addMainCat($currentArray){
        $idMainCat = $currentArray[0][0];
		
        $mainCat = $this->categorieRepository->findByUid($idMainCat);
                
        $currentArray[1][0] = $mainCat->getTitle();  
        $currentArray[2][0] = strval($mainCat->getPid()); 
                        
        return $currentArray;
    }
    
    public function removeExcessIndentation($result){
        $i = 0;
        foreach($result as $key => $chaine){
            $currentSpaces = substr_count($chaine, '&nbsp;&nbsp;&nbsp;');
            
            if($currentSpaces > 0){
                if($i > 0){
                    if($countSpace > $currentSpaces){  
                        $countSpace = $currentSpaces; 
                    }
                } else {
                    $countSpace = $currentSpaces; 
                }
                
                $i++;    
            } else {
                return $result;
            }
         
            $result[$key] = $this->removeIndentation($chaine,$countSpace);
        }
                
        return $result;
    }
    
    public function removeIndentation($chaine,$countSpace){   
        while($countSpace > 0){
            $chaine = substr($chaine,18);
            $countSpace--;
        }
        
        return $chaine;
    }
    
    public function generateRecursiveArray($filtreConf,$field,$key,$res,$confArray,$currentArray,$fieldArray){
        $filtreConf['returnedField'] = $field;
        $select = $key;

        $res[$field] = $this->ficheRepository->getRecursiveValue($confArray['parentValue'], $filtreConf, $select);
                
        if($key === 1 && $confArray['displayParent'] != '1'){
            $res[$field][1] = $this->replaceFirstValue($res[$field][1],$filtreConf,$fieldArray[0]);
        }

        $currentArray[$key] = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('||',$res[$field][1]); 
        
        return $currentArray[$key];
    }
    
    public function replaceFirstValue($value,$filtreConf,$field){
        $valueArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('||',$value);
        
        $select = $filtreConf['returnedField'];
        $table = $filtreConf['table'];
        
        $connectionPool = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable($table);
        
        $req = $queryBuilder
            ->select($select)
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq($field, $queryBuilder->createNamedParameter((int)$valueArray[0], \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
            )
            ->executeQuery()
            ->fetchAllAssociative();
        
        $valueArray[0] = $req[0][$filtreConf['returnedField']] ?? ''; 
        
        return implode('||',$valueArray);
    }
    
    function checkRootPage($page){
        $this->pageRepo = CoreGeneralUtility::makeInstance(PageRepository::class);
        
        $currentPage = 0;
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if ($request instanceof \Psr\Http\Message\ServerRequestInterface) {
            $routing = $request->getAttribute('routing');
            if ($routing !== null && method_exists($routing, 'getPageId')) {
                $currentPage = $routing->getPageId();
            } else {
                $frontendController = $request->getAttribute('frontend.controller');
                if ($frontendController !== null && property_exists($frontendController, 'id')) {
                    $currentPage = $frontendController->id;
                }
            }
        }
        
        if ($currentPage === 0) {
            return false;
        }
        
        $currentRootLine = $this->getSiteRootPage($currentPage); 
        
        $testedRootLine = $this->getSiteRootPage($page); 
        
        if($currentRootLine[0]['uid'] == $testedRootLine[0]['uid']){
            return true;        
        }    
    }
    
    public function getSiteRootPage($page){
        $rootLine = $this->getRootlineForPage($page);;
        
        sort($rootLine);
        
        foreach($rootLine as $key => $item){
            if($item['is_siteroot']){     
                return $rootLine; 
            } else {
                $rootLine = array_splice($rootLine,1,(count($rootLine)-1));
            }
        }
    }	
		
	public static function createTemplateFluid(string $path, array $assign, int $tpl = 0): string
	{
		// On instancie un nouveau template via ViewFactory
		$viewFactory = CoreGeneralUtility::makeInstance(ViewFactoryInterface::class);

		// On défini le chemin du fichier a utiliser comme template
		if ($tpl == 1) {
			// For template source (inline template), create a temporary file
			$tempFile = CoreGeneralUtility::tempnam('fluid_template_', '.html');
			file_put_contents($tempFile, $path);
			$templatePath = $tempFile;
		} else {
			$templatePath = CoreGeneralUtility::getFileAbsFileName($path);
		}

		$viewFactoryData = new ViewFactoryData(
			templatePathAndFilename: $templatePath
		);
		$view = $viewFactory->create($viewFactoryData);

		// On assigne les données a passés
		$view->assignMultiple($assign);

		// On stocke le rendu du template dans la variable $contenu 
		$contenu = $view->render();
		
		// Clean up temporary file if created
		if ($tpl == 1 && isset($tempFile) && file_exists($tempFile)) {
			unlink($tempFile);
		}

		return $contenu;
	}

	public static function removeDotsInConf(array $array): array
	{
		foreach ($array as $key => $setting) {
			if (str_contains((string)$key, '.')) {
				$newKey = substr((string)$key, 0, -1);
				$array[$newKey] = self::removeDotsInConf($setting);
				unset($array[$key]);
			}
		}

		return $array;
	}
	
	public static function sendMail($fiche, string $key, array $settings = []): void
	{
		$mailConf = $settings['sendMail'][reset($fiche->getTypeelement())][$key] ?? [];

		// The path to the template of the mail can be defined through the settings
		$mailPath = $mailConf['mailPath'] ?? '';

		// Values assigned to the mail
		$assign = [
			'fiche' => $fiche,
			'settings' => $settings,
		];

		$contentMail = self::createTemplateFluid($mailPath, $assign);
		
		// subject defined through settings, and interpreted as a fluid template
		$subject = reset($mailConf['subject']) ?? '';
		if (key($mailConf['subject']) == 'static') {
			$subjectMail = LocalizationUtility::translate($subject) ?? $subject;
		} else {
			$subjectMail = self::createTemplateFluid($subject, $assign);
		}

		// We set the sender informations according to the typoscript configuration
		$mailSender = $mailConf['sender']['mail'];
		$nameSender = $mailConf['sender']['name'];
		
		// We set the receiver informations according to the typoscript configurationManager
		if(key($mailConf['mail']) == 'static') {			
			$receiverMail = reset($mailConf['mail']);
		} else {
			$receiver = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('.', reset($mailConf['mail']));
			// If the mail is not statically define we check if the property directly belongs to our object
			// Or if it defined in another table
			if(count($receiver) > 1) {
				$getterRelatedObject = 'get'.ucFirst($receiver[0]);
				$getterRelatedObjectField = 'get'.ucFirst($receiver[1]);
				
				if(!empty($fiche->$getterRelatedObject()->count() > 0)){
					$fiche->$getterRelatedObject()->rewind();					
					$relatedObject = $fiche->$getterRelatedObject()->current();					
					$receiverMail = $relatedObject->$getterRelatedObjectField();
				}
			} else {
				$getter = 'get'.ucFirst(reset($receiver));
				$receiverMail = $fiche->$getter();
			}			
		}
		
		$receiverMailArray = explode(',', $receiverMail);
		
		// We send the mail
		$mail = CoreGeneralUtility::makeInstance(MailMessage::class);
		$mail->to(...$receiverMailArray)
			->from(new \Symfony\Component\Mime\Address($mailSender, $nameSender))
			->subject($subjectMail)
			->returnPath($mailSender)
			->replyTo(new \Symfony\Component\Mime\Address($mailSender, $nameSender))
			->html($contentMail);
		
		// We get the attachments according to the typoscript configuration the same way we did with the receiver
		if(is_array($mailConf['attachment']) && !empty($mailConf['attachment'])){
			foreach($mailConf['attachment'] as $attachment) {
				$confAttachment = explode('.', reset($attachment));
				
				if(count($confAttachment) > 1) {
					$getterRelatedObject = 'get'.ucFirst($confAttachment[0]);
					$getterRelatedObjectField = 'get'.ucFirst($confAttachment[1]);
					
					if(!empty($fiche->$getterRelatedObject())){
						foreach($fiche->$getterRelatedObject() as $relatedObject) {
							$attachmentObj = $relatedObject->$getterRelatedObjectField();
							
							foreach($attachmentObj as $currentFile) {
								$file = $currentFile->getOriginalResource()->getOriginalFile();
								$attachmentPath = $file->getForLocalProcessing(false);
                                $mail->attachFromPath($attachmentPath, $file->getName());
                            }
						}
					}
				} else {
					$getter = 'get'.ucFirst(reset($confAttachment));
					
					if(!empty($fiche->$getter())){
						foreach($fiche->$getter() as $currentFile) {
							$file = $currentFile->getOriginalResource()->getOriginalFile();
							$attachmentPath = $file->getForLocalProcessing(false);
							$mail->attachFromPath($attachmentPath, $file->getName());
						}
					}
				}
			}
		}

		$mail->send();
    }
    public function getRootlineForPage(int $pageId): array
    {
        $rootlineUtility = CoreGeneralUtility::makeInstance(RootlineUtility::class, $pageId);
        return $rootlineUtility->get();
    }

}