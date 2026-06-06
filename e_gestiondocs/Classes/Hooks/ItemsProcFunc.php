<?php
	namespace Emagineurs\EGestiondocs\Hooks;
	/***************************************************************
	*  Copyright notice
	*
	*  (c) 2016 Costa «Coco» C. <ccosta@e-magineurs.com>
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

	use TYPO3\CMS\Backend\Utility\BackendUtility;
	use TYPO3\CMS\Core\Database\ConnectionPool;
	use TYPO3\CMS\Core\Utility\GeneralUtility;

	/**
	 * Userfunc to render alternative label for flexform elements
	 *
	 * @package e_gestiondocs
	 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
	 *
	 */
	class ItemsProcFunc  {

		/**
		 * Itemsproc function to get the sys_file_collection
		 *
		 * @param array &$config configuration array
		 * @return void
		 */
		public function user_getSysFileCollectiontList(array &$config) {

            if (is_numeric($config['flexParentDatabaseRow']['pid'] ?? null)) {
                $pagesTsConfig = BackendUtility::getPagesTSconfig($config['flexParentDatabaseRow']['pid']);
            }elseif(is_numeric($config['row']['pid'] ?? null)) {
                $pagesTsConfig = BackendUtility::getPagesTSconfig($config['row']['pid']);
            }else{
                $pagesTsConfig = null;
            }

            // Add tsconfig values
			if (!is_null($pagesTsConfig)) {
				$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
					->getQueryBuilderForTable('sys_file_collection');

				$queryBuilder
					->select('uid', 'title')
					->from('sys_file_collection')
					->where(
						$queryBuilder->expr()->eq('deleted', 0),
						$queryBuilder->expr()->eq('hidden', 0)
					);

				if (isset($pagesTsConfig['tx_gestiondocs.']['templateFolders']) && is_numeric($pagesTsConfig['tx_gestiondocs.']['templateFolders'])) {
					$queryBuilder->andWhere(
						$queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter((int)$pagesTsConfig['tx_gestiondocs.']['templateFolders'], \PDO::PARAM_INT))
					);
				}

				$formsRepository = $queryBuilder->executeQuery()->fetchAllAssociative();

				$optionList = [
					['label' => '', 'value' => 0]
				];
				foreach($formsRepository as $item){
					$optionList[] = [
						'label' => (string)($item['title'] ?? ''),
						'value' => (int)$item['uid']
					];
				}

				$config['items'] = array_merge($config['items'], $optionList);
			}

		}


	}


?>