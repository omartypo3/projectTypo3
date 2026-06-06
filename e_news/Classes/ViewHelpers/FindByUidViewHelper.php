<?php
namespace Emagineurs\ENews\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Xavier LEY <xley@e-magineurs.com>, E-magineurs
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
 * @package e_news_essonne
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
 
class FindByUidViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('field', 'string', 'Field to select', true);
        $this->registerArgument('table', 'string', 'Table of the record', true);
        $this->registerArgument('uid', 'string', 'UID of the record', true);
    }

    /**
     * @return string uid de la page détail
     */
    public function render(): string
    {
        $field = $this->arguments['field'];
        $table = $this->arguments['table'];
        $uid = $this->arguments['uid'];
        
        $content = '';		

		$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable($table);
		
		$req = $queryBuilder
			->select($field)
			->from($table)
			->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid)))
			->executeQuery()
			->fetchAssociative();
		
		$content = $req[$field] ?? '';		
		return $content;
    }
	
}

?>