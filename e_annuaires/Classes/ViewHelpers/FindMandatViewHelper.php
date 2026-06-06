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
 * Retrieves mandat data for a commune
 *
 * @package e_annuaires
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FindMandatViewHelper extends AbstractViewHelper {

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('commune', 'int', 'Commune ID', true);
        $this->registerArgument('typemandat', 'int', 'Type mandat', false, 0);
        $this->registerArgument('commission', 'int', 'Commission', false, 0);
    }

    public function render()
    {
        $commune = $this->arguments['commune'];
        $typemandat = $this->arguments['typemandat'];
        $commission = $this->arguments['commission'];
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
	
        //maire
        if($typemandat == 4){
            //récup le mandat de maire de cette commune
            $queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_mandat');
            
            $id_mandat = $queryBuilder
                ->select('uid', 'typemandat', 'communemandat')
                ->from('tx_eannuaires_domain_model_mandat')
                ->where(
                    $queryBuilder->expr()->eq('typemandat', $queryBuilder->createNamedParameter((int)$typemandat, Connection::PARAM_INT)),
                    $queryBuilder->expr()->eq('communemandat', $queryBuilder->createNamedParameter((int)$commune, Connection::PARAM_INT)),
                    $queryBuilder->expr()->eq('deleted', 0)
                )
                ->orderBy('uid', 'DESC')
                ->setMaxResults(1)
                ->executeQuery()
                ->fetchAllAssociative();
                    
            if(!empty($id_mandat)){
                $id_mandat = $id_mandat[0];

                //Récup tous les élus avec possiblement ce mandat dans leur liste de mandats
                $queryBuilder2 = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
                
                $req = $queryBuilder2
                    ->select('*')
                    ->from('tx_eannuaires_domain_model_fiche')
                    ->where(
                        $queryBuilder2->expr()->eq('deleted', 0),
                        $queryBuilder2->expr()->eq('typeelement', 7),
                        $queryBuilder2->expr()->like('mandats', $queryBuilder2->createNamedParameter('%' . $id_mandat['uid'] . '%'))
                    )
                    ->executeQuery()
                    ->fetchAllAssociative();

                return $req[0] ?? null; 
            }
        //les autres mandats, vérirfie si la fiche n'est pas supprimée et si il a toujours des mandats
        }else{
            $queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_commission');
            
            $ficheelu = $queryBuilder
                ->select('membres')
                ->from('tx_eannuaires_domain_model_commission')
                ->where(
                    $queryBuilder->expr()->eq('deleted', 0),
                    $queryBuilder->expr()->eq('hidden', 0),
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$commission, Connection::PARAM_INT))
                )
                ->executeQuery()
                ->fetchAllAssociative();

            if (!empty($ficheelu[0]['membres'])) {
                $queryBuilder2 = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
                
                $req = $queryBuilder2
                    ->select('mandats')
                    ->from('tx_eannuaires_domain_model_fiche')
                    ->where(
                        $queryBuilder2->expr()->eq('deleted', 0),
                        $queryBuilder2->expr()->eq('hidden', 0),
                        $queryBuilder2->expr()->eq('typeelement', 7),
                        $queryBuilder2->expr()->eq('uid', $queryBuilder2->createNamedParameter((int)$ficheelu[0]['membres'], Connection::PARAM_INT))
                    )
                    ->executeQuery()
                    ->fetchAllAssociative();
                
                if(!empty($req)){
                    return true;
                }
            }

        }
    
    }
}