<?php
namespace Emagineurs\EMagineurs\Xclass;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 xley <xley@e-magineurs.com>
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
 
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
 
/**
 *
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EFicheController extends \Emagineurs\EAnnuaires\Controller\FicheController {
    
    public function getListeItems(string $listeItems): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
        ->getQueryBuilderForTable($listeItems);

        $queryBuilder->select('*')
            ->from($listeItems)
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            );

        // Add order for specific table
        if ($listeItems === 'tx_eannuaires_domain_model_pack') {
            $queryBuilder->orderBy('title', 'ASC');
        }

        // Execute query
        $rows = $queryBuilder->executeQuery()->fetchAllAssociative();

        $result = [];
        foreach ($rows as $item) {
            if ($this->utility->checkRootPage($item['pid']) === true) {
                $result[] = $item;
            }
        }

        return $result;
    }	
}
?>
