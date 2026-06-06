<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IncludeConf
{
	public function processDatamap_afterAllOperations(&$pObj): void
	{
		$data = $pObj->datamap['pages'] ?? [];
		$fiche = $pObj->datamap['tx_eannuaires_domain_model_fiche'] ?? [];

		// AJOUT DU TSCONFIG CORRESPONDANT AU CHAMP TYPEANNUAIRE DES PAGES (le tsconfig ajouté sert à définir le type d'annuaire par défaut de la page)
		if (is_array($data) && !empty($data)) {
			$currentData = $pObj->checkValue_currentRecord;
			$tsconfig = BackendUtility::getPagesTSconfig($currentData['uid']);

			if (
				(
					empty($tsconfig['TCAdefaults.']['tx_eannuaires_domain_model_fiche.']['typeelement']) 
					|| $tsconfig['TCAdefaults.']['tx_eannuaires_domain_model_fiche.']['typeelement'] != $data[$currentData['uid']]['typeannuaire']
				)
				&& !empty($data[$currentData['uid']]['typeannuaire'])
			) {
				$this->addDefaultAnnuaireToTsconfig($currentData, $data);
			}
		}
	}

	protected function addDefaultAnnuaireToTsconfig(array $currentData, array $data): void
	{
		$tsConfigToAdd = 'TCAdefaults.tx_eannuaires_domain_model_fiche.typeelement = ' . $data[$currentData['uid']]['typeannuaire'];

		$newTsConfig = $data[$currentData['uid']]['TSconfig'] . chr(10) . $tsConfigToAdd;

		foreach ($data[$currentData['uid']] as $key => $field) {
			$currentData[$key] = $field;
		}

		$currentData['TSconfig'] = $newTsConfig;

		$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');
		$connection->update(
			'pages',
			$currentData,
			['uid' => (int)$currentData['uid']]
		);
	}
}
