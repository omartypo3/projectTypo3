<?php
namespace Emagineurs\EAnnuaires\Domain\Repository;

use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/***************************************************************
 *  Copyright notice
 *
 * (c) 2013 Xavier Ley <xley@e-magineurs.com>
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
 * use Emagineurs\EAnnuaires\Domain\Model\Fiche;
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FicheRepository extends AbstractRepository {
    
    // Explicitly declare all properties used dynamically
    protected array $settings = [];

    // For params, you can store them in an array instead of creating dynamic properties
    protected array $params = [];

     // Declare all possible dynamic keys
    protected $liste;
    protected ContentObjectRenderer $cObj;
    protected $foo;
    protected $bar;
    protected $wordsToExclude;
    protected $search = null;

	/**
	* @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	*/
	protected $configurationManager;

	/**
	* @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	* @return void
	*/
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}
    
    /**
	 * Permet d'accéder aux settings dans le repo si appelé dans le controller.
     * Permet également de définir des variables spécifiques à chaque vue via la variable params
	 *
	 * @param array $settings
	 * @param array $params
	 * @return void
	 */
	public function setSettings($settings, $params = array()){
		$this->settings = $settings;
		
		if(count($params) > 0){
			foreach($params as $key => $value){
				$this->$key = $value;
			}
		}
    }
	
	public function findAll(){
		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		
		return $query->execute();
	}
    
	public function findWithSettings($currentRequest = '', $count = 0, $rawResult = FALSE){
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

        $this->wordsToExclude = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$this->settings['search']['excludeWords']);

        // On applique a la liste les filtres des configurations
        $constraints = $this->getConstraintFromSettings($query);	

        // On applique a la liste les filtres de la recherche
        if($this->search){    
            $constraints = $this->getConstraintFromSearch($currentRequest,$constraints,$query);
        }
		 
		if ($this->settings["filterDate"]["activate"]) {
            $constraints = $this->addDateConstraint($constraints, $query);
        }
        
        if($constraints){
            $query->matching(
                $query->logicalAnd(...$constraints)
            );
        }

        // Si, dans le controller,on a spéfifié que l'on voulait le nombre de résultat, en le renvoie au lieu de la liste
        // Sinon on applique les critères de tri et la limite
        if($count != 1){
            $this->setOrderingsQuery($query,$currentRequest);

            $this->setLimitQuery($query,$currentRequest);
        } else {
            return $query->count();
        }

		return $query->execute($rawResult);
    }

    public function findWithSettingsRaw($currentRequest = '', $count = 0, $rawResult = FALSE)
    {
        if ($count == 1) {
            return $this->findWithSettings($currentRequest, $count, $rawResult);
        }

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        $this->wordsToExclude = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['search']['excludeWords']);

        // On applique a la liste les filtres des configurations
        $constraints = $this->getConstraintFromSettings($query);

        // On applique a la liste les filtres de la recherche
        if ($this->search) {
            $constraints = $this->getConstraintFromSearch($currentRequest, $constraints, $query);
        }

        if ($this->settings["filterDate"]["activate"]) {
            $constraints = $this->addDateConstraint($constraints, $query);
        }

        if ($constraints) {
            $query->matching(
                $query->logicalAnd($constraints)
            );
        }

        $this->setOrderingsQuery($query, $currentRequest);
        $this->setLimitQuery($query, $currentRequest);

        $queryParser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Typo3DbQueryParser::class);

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $queryParser->convertQueryToDoctrineQueryBuilder($query);
        $queryParameters = $queryBuilder->getParameters();
        $params = [];
        foreach ($queryParameters as $key => $value) {
            // prefix array keys with ':'
            $params[':' . $key] = (is_numeric($value)) ? $value : "'" . $value . "'"; //all non numeric values have to be quoted
            unset($params[$key]);
        }
        return $queryBuilder->execute()->fetchAll();
    }

    public function setLimitQuery($query,$currentRequest){
        // On défini une limite à partir des configurations (TS/flexform ou get), si rien de défini on met par défaut a 5
        if($this->settings['nbElement']){
            $nbElement = (!empty($currentRequest['nbElement']) && $this->settings['getLimiteByGP']) ? $currentRequest['nbElement'] : $this->settings['nbElement'];
            
            $query->setLimit(intval($nbElement));
        }
        
        // On change l'offset de l'affichage si on a parametre "page", qui indique l'utilisation de la pagination
        if(isset($currentRequest['page']) && isset($this->settings['nbElement'])){
            $offset = (intval($currentRequest['page']) - 1)*(intval($this->settings['nbElement']));

            $query->setOffset($offset);
        }
    }
    
    public function setOrderingsQuery($query,$currentRequest = array()){
        // On défini ici le champ de tri
        if($this->settings['orderBy']){

            // Cas particulier pour le tri aléatoire
    		if ($this->settings['orderBy'] == 'aleatoire') {
                $query->setOrderings(
                    array(
                        'deleted, rand()' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
                    )
                );
            } else {
                // On fait le tri selon des champs configurés
                $orderings = $this->getOrderingsFromSettings($currentRequest);
                $query->setOrderings($orderings);
            }
        }        
    }
    
    public function getOrderingsFromSettings($currentRequest = array()){
        //On determine d'apres le confs si le tri est ascendant ou descendant
        $orderFromSettings = $this->getOrderFromSettings($currentRequest);
		
		// Si on a le bon paramètre dans l'url, le tri est fait en fonction de ce paramètre : orderby
        $order = (!empty($currentRequest['orderby'])) ? $currentRequest['orderby'] : $this->settings['orderBy'];
		
        // Les champs du tri sont récupéré à partir des confs
        $arrayTri = explode(',',$order);
            
        // On met les infos de tri sous la forme d'un tableau pour extbase ($tableau[champ] = ORDER_ASCENDING)
        $orderings = $this->getMultipleOrderings($orderFromSettings,$arrayTri);

        return $orderings;
    }
    
    public function getMultipleOrderings($orderFromSettings,$champTriArray){
        $arrayTri = array();
        foreach($champTriArray as $champTri){
            $arrayTri[$champTri] = $orderFromSettings;
        }
        
        return $arrayTri;
    }
    
    public function getOrderFromSettings($currentRequest){
		if($this->settings['ordre']){
			$order = $this->settings['ordre'];
		}
		if(isset($currentRequest['sorting'])){
			$order = $currentRequest['sorting'];
		}
		
		switch ($order) {
			case 'DESC':           
				$orderFromSettings = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
				break; 
			case 'ASC':
			default:    
				$orderFromSettings = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING; 
			break;
		}
		           
        return $orderFromSettings;
    }
           
	public function getConstraintFromSettings($query){
		$constraint = array();
		
		$filtreArray = $this->settings['filtre'];      

		if(is_array($filtreArray) && !empty($filtreArray)){
			foreach($filtreArray as $filtre => $filtreConf){
                $filtreConf['value'] = $this->convertValueIntoStdWrap($this->settings['filtre'][$filtre]);

                if($filtreConf['value']){
                    $filtreConf['value'] = str_replace(',','||', $filtreConf['value']);
                    
                    $constraint = $this->applyFiltre($filtreConf,$query,$constraint);
				}
			}
		}

		return $constraint;
	}
    
    public function convertValueIntoStdWrap($filtreConf){

        $valueConf = $filtreConf['valueConf'] ?? null; // safely get valueConf
        $value = $filtreConf['value'] ?? null;         // safely get value
		$stdWrapValue = $this->cObj->stdWrap($value, $valueConf);

        if(!empty($valueConf) && !empty($stdWrapValue)){   
            $filtreValue = $this->cObj->stdWrap($value, $valueConf);
        } else if(!empty($filtreConf['specialValue'])){
			$filtreValue = $this->getSpecialValue($filtreConf['specialValue'],$value);
        } else {
            $filtreValue = $value;
        }
						
        return $filtreValue;
    }
	
	public function getSpecialValue($specialValue,$value){
		$field = $specialValue['specialField'];
		$table = $specialValue['specialTable'];
		
		if(is_array($value) && count($value) > 0){
			$where = '1 = 1 AND (';
			foreach($value as $key => $currentValue){
				$where .= $this->cObj->stdWrap($currentValue,$specialValue['specialValue'][$key]);
			}
			$where .= ')';
		} else {
			$where = $this->cObj->stdWrap($value,$specialValue['specialValue']);
		}
		
		$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable($table);
		$req = $queryBuilder->select($field)->from($table)->where($where)->executeQuery()->fetchAllAssociative();
		
		$result = array();
		
		foreach($req as $item){
			$result[] = $item[$field];
		}
		
		return implode('||',$result);
	}
	
	public function getConstraintFromSearch($currentRequest,$constraints,$query){
		$constraint = array();
		$filtreArray = $currentRequest['search'];
					
        if(is_array($filtreArray) && !empty($filtreArray)){   
            foreach($filtreArray as $filtre => $value){   
		        $this->settings['search']['properties'][$filtre]['value'] = $value;

                if($this->settings['search']['properties'][$filtre]['valueConf'] && $value){
                    // if(array_key_exists('_typoScriptNodeValue',$this->settings['search']['properties'][$filtre]['valueConf'])){
                        $tsAvecPoint = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
                        $this->settings['search']['properties'][$filtre]['valueConf'] = $tsAvecPoint['plugin.']['tx_eannuaires.']['settings.']['search.']['properties.'][$filtre.'.']['valueConf.'];
                    // }
                }

                if($this->settings['search']['properties'][$filtre]['value']){
                    $filtreConf = $this->settings['search']['properties'][$filtre];                                                 
                    $filtreConf['value'] = $this->convertValueIntoStdWrap($filtreConf);
                }
				
                if($filtreConf['value'] || ($filtreConf['value'] == 0 && $filtreConf['zeroAllowed'] == 1) ){
                    $constraint = $this->applyFiltre($filtreConf,$query,$constraint);
                }
            }
        }
            
        if($constraint){
            $constraints[] = $query->logicalAnd($constraint);
        }
		return $constraints;
	}

	public function addDateConstraint($constraints,$query){
        $constraint = array();
        
        if($this->settings['filterDate']['slider'] && $this->settings['filterDate']['range']){
            $periodValue = $this->settings['filterDate']['slider'];
            $period = $this->settings['filterDate']['range'];
            // integer = timestamp
            $timeLimit = strtotime('-'.$periodValue.' '.$period);
           
            $constraint[] = $query->greaterThanOrEqual(
                'tstamp',
                $timeLimit
            );
        }
        
            
        if($constraint){
            $constraints[] = $query->logicalAnd($constraint);
        }
		return $constraints;
	}
	
	public function applyFiltre($filtreConf,$query,$constraint){
		$typeReq = $filtreConf['typeRequete'];

		$champFiltre = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$filtreConf['champFiltre']);
        $filtreValue = $filtreConf['value'];
                
		if($typeReq != 'contains'){
			$value = $this->generateValue($typeReq,$filtreValue,$filtreConf);
		}
        
		if($typeReq == 'equals'){  
            if(is_array($champFiltre) && !empty($champFiltre)){
                foreach($champFiltre as $champ){
                    $constraintIntermediaire[] = $query->$typeReq($champ,$value,$filtreConf['caseSensitive']);
                }
                $constraint[] = $query->logicalOr(...$constraintIntermediaire);
            }
		} else if($typeReq == 'contains'){
            $andOr = ($filtreConf['andOr']) ? $filtreConf['andOr'] : 0;  
            $constraint = $this->generateContainsValue($constraint,$query,$filtreValue,$champFiltre,$andOr);
        } else if($typeReq == 'typeCat'){
			$constraint = $this->generateTypeCatValue($constraint,$query,$value,$filtreConf);
		} else if($typeReq == 'keyword'){
            $constraint = $this->keyWordConstraint($constraint,$query,$value,$filtreConf);
        } else if($typeReq == 'extendKeyword'){
            $constraint = $this->extendKeyWordConstraint($constraint,$query,$value,$filtreConf);
        } else if($typeReq == 'between'){
            $constraint = $this->generateBetweenValue($constraint,$query,$value,$filtreConf,$champFiltre);
		} else {	
            if(is_array($champFiltre) && !empty($champFiltre) && ($champFiltre[0] != '' && count($champFiltre) ==1)){

                foreach($champFiltre as $champ){
                    $constraintIntermediaire[] = $query->$typeReq($champ,$value);
                }

	            $constraint[] = $query->logicalOr(...$constraintIntermediaire);
            }

		}
        
		return $constraint;
	}
    
    public function extendKeyWordConstraint($constraint,$query,$value,$filtreConf){		
		$constraintFinal = array();
		
		$queryKeyWord = $this->createQuery();

		$queryKeyWord->getQuerySettings()->setRespectStoragePage(FALSE);
		
		$constraintInter = $this->keyWordConstraint(array(),$queryKeyWord,$value,$filtreConf);
		
		$queryKeyWord->matching(
			$queryKeyWord->logicalOr($constraintInter)
		);
		
		$res =  $queryKeyWord->execute()->toArray();
		
        $fieldsArray = explode(',',$filtreConf['champFiltre']);
        
        $andOr = $filtreConf['keyWord'];
        $keyWordInstruction = $filtreConf['keyWordInstruction'];
        
        foreach($fieldsArray as $field){
            $constraintKeyWord[] = $this->searchKeyWord($field,$value,$query,$andOr,$keyWordInstruction);
        }
				
		if(is_array($res) && count($res) > 0){
			$resArray = array();
			foreach($res as $fiche){
				$resArray[] = $query->contains($filtreConf['field'],$fiche->getUid());
			}

			if(count($res) > 1){
				$constraintKeyWord[] = $query->logicalOr($resArray);
			} else {
				$constraintKeyWord[] = $resArray[0];
			}
		}
        
        $constraint[] = $query->logicalOr($constraintKeyWord);
		                
        return $constraint;
    }
    
    public function keyWordConstraint($constraint,$query,$value,$filtreConf){
        $fieldsArray = explode(',',$filtreConf['champFiltre']);
        
        $andOr = $filtreConf['keyWord'];
        $keyWordInstruction = $filtreConf['keyWordInstruction'] ?? '';
        
        foreach($fieldsArray as $field){
            $constraintKeyWord[] = $this->searchKeyWord($field,$value,$query,$andOr,$keyWordInstruction);
        }
        
        $constraint[] = $query->logicalOr(...$constraintKeyWord);
                
        return $constraint;
    }
    
    public function searchKeyWord($field,$keyWord,$query,$andOr,$keyWordInstruction = 'standard'){
        $keyWordArray = preg_split('/[ ,]/', $keyWord);
        
        $constraint = array();
        
        foreach($keyWordArray as $key => $word){
            if(!in_array($word, $this->wordsToExclude)){
                $wordConstraintArray = $this->getKeyWordInstruction($keyWordInstruction, $word, $field, $query, $key);        
                $constraint[] = $query->logicalOr(...$wordConstraintArray);
            }
        }
                
        if($andOr == 'AND'){
            $constraintKeyWord = $query->logicalAnd(...$constraint);
        } else{
            $constraintKeyWord = $query->logicalOr(...$constraint);
        }
        
        return $constraintKeyWord;
    }
	
    public function getKeyWordInstruction($keyWordInstruction, $word, $field, $query, $key)
	{
        $finalInstruction = array();

        switch($keyWordInstruction)
		{
            case 'strict' :                
                $finalInstruction[] = $query->like($field,'% '.trim($word).'%');
                $finalInstruction[] = $query->like($field,'%'.trim($word).' %');
                $finalInstruction[] = $query->like($field, $word);
                break;
            case 'standard' :
            default :
                $finalInstruction[] = $query->like($field, '%'.trim($word).'%');
                break;
		}
        
        return $finalInstruction;
    }

    public function generateTypeCatValue($constraint,$query,$value,$filtreConf){
        $cas = $filtreConf['andOr'];
        $champFiltre = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$filtreConf['champFiltre']);
        
		switch ($cas) {
			case 3:
				$constraint = $this->generateContainsValue($constraint,$query,$value,$champFiltre,'1');
				break;
			case 2:
				$constraint[] = $query->in($champFiltre,explode(',',$value));
				break;
			case 1:
			default:                 
				$constraint = $this->generateContainsValue($constraint,$query,$value,$champFiltre);
				break;
		}
        
        return $constraint;
    }

    public function generateBetweenValue($constraint,$query,$value,$filtreConf,$champFiltre){
        
        $valueArray = explode('<',strval($value));
        $constraintStep = array();
        
        if(is_array($champFiltre) && !empty($champFiltre)){
            foreach ($champFiltre as $champ){
                if (count($valueArray) ==1){
                    $constraintIntermediaire[] = $query->greaterThanOrEqual($champ, (int) $valueArray[0]);
                }else {
                    $constraintStep[] = $query->greaterThanOrEqual($champ, (int) $valueArray[0]);
                    $constraintStep[] = $query->lessThanOrEqual($champ,(int) $valueArray[1]);
                    
                    
                    $constraintIntermediaire[] = $query->logicalAnd(...$constraintStep);
                }
            }   
            $constraint[] = $query->logicalAnd(...$constraintIntermediaire);
            
        }
        return $constraint;
    }

    public function generateContainsValue($constraint,$query,$filtreValue,$champFiltre, $equals = '0'){
        if(!is_array($filtreValue)) {
            $filtreValue = str_replace(',','||', $filtreValue);            
            $valueArray = explode('||',strval($filtreValue));
        } else {
            $valueArray = $filtreValue;
        }
        
        $constraintStep = array();
        
        if(is_array($champFiltre) && !empty($champFiltre)){
            foreach ($champFiltre as $champ){
                foreach($valueArray as $value){
                    $constraintStep[] = $query->contains($champ,$value);
                }
                
                if($equals == '1'){
                    $constraintIntermediaire[] = $query->logicalAnd(...$constraintStep);
                } else {
                    $constraintIntermediaire[] = $query->logicalOr(...$constraintStep);
                }
            }   
            if($equals == '1'){
                $constraint[] = $query->logicalAnd(...$constraintIntermediaire);
            } else {
                $constraint[] = $query->logicalOr(...$constraintIntermediaire);
            }
        }
        
        return $constraint;
    }

	public function generateValue($typeReq,$value,$filtreConf){
        if(isset($filtreConf['recursive'])){
            $result = $this->getRecursiveValue($value,$filtreConf);
            $value = $result[1];
        }
        
		switch ($typeReq) {
			case 'in':
                $finalValue = explode('||',$value);
				break;
			case 'like':
				$finalValue = $this->generateLikeValue($value,$filtreConf);
				break;
			default:
				$finalValue = $value;
				break;
		}
        				
		return $finalValue;
	}
    
    public function getRecursiveValue($value,$filtreConf,$select = 0,$res = array(0)){
        $recursive = $filtreConf['recursive'] ?? 0;

        // Ensure $res[1] exists before appending
        if (!isset($res[1])) {
            $res[1] = '';
        }

        if (!empty($res[0]) && $res[0] < 1) {
            $res[1] .= $value;
        }
        
        if($value){
            $req = $this->getChildrenRecords($filtreConf,$value);

            $res[0]++;  
            
            if(is_array($req) && !empty($req) && count($req) > 0){                
                $res = $this->recursiveCallIfResults($req,$res,$recursive,$filtreConf,$value,$select);
            }
        }
        
        return $res;
    }
    
    public function recursiveCallIfResults($req,$res,$recursive,$filtreConf,$value,$select){
        foreach($req as $parent){
            if($select === 1 && $parent[$filtreConf['returnedField']]){
                $compteur = $res[0];
                while($compteur > 0){
                    $parent[$filtreConf['returnedField']] = '&nbsp;&nbsp;&nbsp;'.$parent[$filtreConf['returnedField']];
                    $compteur--;
                }
            }
            
            $res[1] .= ($filtreConf['returnedField']) ? '||'.$parent[$filtreConf['returnedField']] : '||'.$parent['uid'];
                
            if(intval($recursive) > $res[0] && $value){
                $result = $this->getRecursiveValue($parent['uid'],$filtreConf,$select,$res);
                $res[1] = $result[1];
            }
        }

        return $res; 
    }
    
    public function getChildrenRecords($filtreConf,$value){
        $tables = $filtreConf['table'];
        $select = $filtreConf['selectFields'] ?? 'uid';
		$orderby = $filtreConf['orderBy'] ?? '';
		$groupby = $filtreConf['groupBy'] ?? '';
		
        $where = $filtreConf['parentField'].' IN ('.$value.') ';

        if(!empty($filtreConf['andWhere'])){   
            $where .= ' AND '.$filtreConf['andWhere'];
        }
        
        $tableFinal = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',',$tables);

        	
        $queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable($tables);
        
        if(!empty($tableFinal)){
             $queryBuilder->setRestrictions(
                 GeneralUtility::makeInstance(FrontendRestrictionContainer::class)
            );
        }
        
        $query = $queryBuilder->select(...\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $select))->from($tables);
        if ($where) {
            $query->where($where);
        }
        if ($groupby) {
            $query->groupBy(...\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $groupby));
        }
        if ($orderby) {
            $orderByParts = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $orderby);
            foreach ($orderByParts as $orderByPart) {
                $parts = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(' ', $orderByPart);
                $query->addOrderBy($parts[0], $parts[1] ?? 'ASC');
            }
        }
        return $query->executeQuery()->fetchAllAssociative();
    }
	
	public function getFichesUser($uid, $count = 0){
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
        
		// On cherche les fiches ayant comme feuser associé le feuser passé en parametre.
		$query->matching($query->contains('feuser',$uid));

        // Si, dans le controller,on a spéfifié que l'on voulait le nombre de résultat, en le renvoie au lieu de la liste
        if($count == 1){
    		return $query->count();
        }
                
		return $query->execute();
	}
    
	public function updateTypeFiche($origin){
		switch($origin){
			case 'import':
				$this->updateTypeFicheIfImport();
			break;
			case 'convert':
				$this->updateTypeFicheIfConvert();
			break;			
		}
	}
	
	public function updateTypeFicheIfImport(){
		$typeRepo = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\Conf\TypeannuaireRepository::class);
		$typeArrayInfo = array();
		
		$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
		$listExistingTypes = $queryBuilder->select('typeelement')->from('tx_eannuaires_domain_model_fiche')->where($queryBuilder->expr()->eq('deleted', 0))->groupBy('typeelement')->executeQuery()->fetchAllAssociative();
		
		foreach($listExistingTypes as $uidType){
			$qb = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('tx_eannuaires_domain_model_typeannuaire');
			$titleType = $qb->select('title')->from('tx_eannuaires_domain_model_typeannuaire')->where($qb->expr()->eq('uid', $qb->createNamedParameter((int)$uidType['typeelement'], \TYPO3\CMS\Core\Database\Connection::PARAM_INT)))->executeQuery()->fetchAllAssociative();
			
			if(!empty($titleType)){
				$typeArrayInfo[$uidType['typeelement']] = $titleType[0]['title'];
			}
		}
		
		$this->updateFiche($typeArrayInfo);
	}
	
	public function updateTypeFicheIfConvert(){
		$confExtTplAnnuaires = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['e_annuaires'] ?? [];
		
		$typeArray = explode(',', $confExtTplAnnuaires['types'] ?? '');
		$typeArrayInfo = array();
		
		foreach($typeArray as $typeOld){
			$typeOldArray = explode('-',$typeOld);
			$typeArrayInfo[$typeOldArray[0]] = $typeOldArray[1];
		}
		
		$this->updateFiche($typeArrayInfo);
	}
	
	public function updateFiche($typeArrayInfo){
		if(is_array($typeArrayInfo) && !empty($typeArrayInfo)){
			$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
			
			$connection = $connectionPool->getConnectionForTable('tx_eannuaires_domain_model_fiche');
			$connection->executeStatement(
				"UPDATE tx_eannuaires_domain_model_fiche SET typeelement = 0 WHERE typeelement = '' OR typeelement IS NULL"
			);
			
			$connection = $connectionPool->getConnectionForTable('pages');
			$connection->executeStatement(
				"UPDATE pages SET typeannuaire = 0 WHERE typeannuaire = '' OR typeannuaire IS NULL"
			);
			
			foreach($typeArrayInfo as $idOld => $nameOld){
				if (empty($idOld) || !is_numeric($idOld) || empty($nameOld)) {
					continue;
				}
				// Get the new type UID
				$queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_typeannuaire');
				$idToUpdate = $queryBuilder
					->select('uid')
					->from('tx_eannuaires_domain_model_typeannuaire')
					->where(
						$queryBuilder->expr()->like('title', $queryBuilder->createNamedParameter('%' . $nameOld . '%')),
						$queryBuilder->expr()->eq('deleted', 0),
						$queryBuilder->expr()->eq('hidden', 0)
					)
					->executeQuery()
					->fetchAllAssociative();
				
				if (!empty($idToUpdate[0]['uid'])) {
					// Update fiches
					$updateQueryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
					$updateQueryBuilder
						->update('tx_eannuaires_domain_model_fiche')
						->set('typeelement', (int)$idToUpdate[0]['uid'])
						->where(
							$updateQueryBuilder->expr()->eq('typeelement', $updateQueryBuilder->createNamedParameter((int)$idOld, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
						)
						->executeStatement();
					
					// Update pages (TSconfig)
					$tsConfigToAdd = chr(10).'TCAdefaults.tx_eannuaires_domain_model_fiche.typeelement = '.$idToUpdate[0]['uid'];
					
					$pagesQueryBuilder = $connectionPool->getQueryBuilderForTable('pages');
					$pagesQueryBuilder->getRestrictions()->removeAll();
					$pagesQueryBuilder
						->update('pages')
						->set('typeannuaire', (int)$idToUpdate[0]['uid'])
						->set('TSconfig', $pagesQueryBuilder->quoteIdentifier('TSconfig') . ' || ' . $pagesQueryBuilder->createNamedParameter($tsConfigToAdd), false)
						->where(
							$pagesQueryBuilder->expr()->eq('typeannuaire', $pagesQueryBuilder->createNamedParameter((int)$idOld, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
						)
						->executeStatement();
				}
			}
		}
	}
}
