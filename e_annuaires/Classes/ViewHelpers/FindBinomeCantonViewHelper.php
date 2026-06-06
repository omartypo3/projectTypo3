<?php
namespace Emagineurs\EAnnuaires\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Xavier Ley <xley@e-magineurs.com>, E-magineurs
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
 
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
 
/**
 * Retrieves binome canton data
 *
 * @package e_annuaires
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FindBinomeCantonViewHelper extends AbstractViewHelper {

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('canton', 'int', 'Canton ID', true);
        $this->registerArgument('type', 'int', 'Type', true);
        $this->registerArgument('uidFicheActuelle', 'int', 'Current fiche UID', true);
        $this->registerArgument('pid', 'int', 'Page ID', true);
        $this->registerArgument('count', 'string', 'Count', false, '');
    }

    public function render()
    {
        $canton = $this->arguments['canton'];
        $type = $this->arguments['type'];
        $uidFicheActuelle = $this->arguments['uidFicheActuelle'];
        $pid = $this->arguments['pid'];
        $count = $this->arguments['count'];
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_mandat');
        
        $req = $queryBuilder
            ->select('uid', 'canton')
            ->from('tx_eannuaires_domain_model_mandat')
            ->where(
                $queryBuilder->expr()->eq('canton', $queryBuilder->createNamedParameter((int)$canton, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('typemandat', $queryBuilder->createNamedParameter((int)$type, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->executeQuery()
            ->fetchAllAssociative();
        
        $ficheUid = null;
		if(is_array($req) && count($req) > 0){
			foreach($req as $mandat) {
				$queryBuilder2 = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
				
				$req2 = $queryBuilder2
					->select('uid')
					->from('tx_eannuaires_domain_model_fiche')
					->where(
						$queryBuilder2->expr()->eq('deleted', 0),
						$queryBuilder2->expr()->eq('hidden', 0),
						$queryBuilder2->expr()->eq('mandats', $queryBuilder2->createNamedParameter((int)$mandat['uid'], Connection::PARAM_INT)),
						$queryBuilder2->expr()->neq('uid', $queryBuilder2->createNamedParameter((int)$uidFicheActuelle, Connection::PARAM_INT))
					)
					->setMaxResults(1)
					->executeQuery()
					->fetchAssociative();
					
				$ficheUid[] = $req2['uid'] ?? null;
			}
			
			rsort($ficheUid);
			$ficheUid = $ficheUid[0];
		}


        $urlBinome = array(
            'pid' => $pid,
            'fiche' => $ficheUid
        );
        if ($count!='' AND $ficheUid !='' ){
            //pas besoin de compter les valeurs, le but et de savoir si il y a un autre élus avec ce canton ou non
            return "ok";
        }

        return $urlBinome;
        
    }
}